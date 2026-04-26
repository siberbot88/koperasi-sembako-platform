<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\SupportSession;
use App\Services\GrokSupportService;
use Livewire\Component;

/**
 * AiSupportWidget
 *
 * Floating AI Customer Service chat widget available on all storefront pages.
 * - Uses Grok via GrokSupportService
 * - Injects sanitized user context (name + last 3 orders) into system prompt
 * - Detects escalation signals and shows WhatsApp button
 * - Persists conversation in support_sessions collection (MongoDB)
 * - Rate limiting: max 15 messages per session
 */
class AiSupportWidget extends Component
{
    public bool   $isOpen      = false;
    public string $userInput   = '';
    public bool   $isTyping    = false;
    public bool   $showEscalate = false;
    public string $sessionId   = '';

    /** @var array<array{role: string, content: string, timestamp: string}> */
    public array $messages = [];

    private const MAX_MESSAGES_PER_SESSION = 15;

    public function mount(): void
    {
        $this->sessionId = session()->getId();
    }

    public function toggleWidget(): void
    {
        $this->isOpen = ! $this->isOpen;

        // Show greeting on first open
        if ($this->isOpen && empty($this->messages)) {
            $name = auth()->check() ? auth()->user()->name : 'Kak';
            $this->messages[] = [
                'role'      => 'assistant',
                'content'   => "Halo, {$name}! Saya Asisten Koperasi Sembako. Ada yang bisa saya bantu hari ini?\n\nSaya bisa membantu soal:\n- Status & pelacakan pesanan\n- Cara menggunakan fitur website\n- Pertanyaan seputar belanja\n- Kendala teknis umum",
                'timestamp' => now()->format('H:i'),
            ];
        }
    }

    public function closeWidget(): void
    {
        $this->isOpen = false;
    }

    public function sendMessage(): void
    {
        $input = trim($this->userInput);

        if (empty($input)) return;

        // Rate limit
        $userMessages = collect($this->messages)->where('role', 'user')->count();
        if ($userMessages >= self::MAX_MESSAGES_PER_SESSION) {
            $this->messages[] = [
                'role'      => 'assistant',
                'content'   => 'Anda telah mencapai batas percakapan untuk sesi ini. Untuk bantuan lebih lanjut, silakan hubungi CS kami via WhatsApp.',
                'timestamp' => now()->format('H:i'),
            ];
            $this->showEscalate = true;
            $this->userInput    = '';
            return;
        }

        // 1. Immediately add user bubble and show typing indicator
        $this->messages[] = [
            'role'      => 'user',
            'content'   => $input,
            'timestamp' => now()->format('H:i'),
        ];
        $this->userInput = '';
        $this->isTyping  = true;

        // 2. Dispatch browser event — JS will call fetchAiResponse() after render
        $this->dispatch('trigger-ai-fetch');
    }

    /**
     * Called via JS event after user bubble has rendered.
     * This runs as a separate Livewire request so the AI reply
     * appears after the user message — not simultaneously.
     */
    public function fetchAiResponse(): void
    {
        if (! $this->isTyping) return;

        // Build API conversation history from current messages
        $apiHistory = collect($this->messages)
            ->filter(fn($m) => in_array($m['role'], ['user', 'assistant']))
            ->map(fn($m) => ['role' => $m['role'], 'content' => $m['content']])
            ->values()
            ->toArray();

        // Get user context (safe, read-only)
        $userContext = $this->buildUserContext();

        // Call AI (Groq or xAI)
        $service  = app(GrokSupportService::class);
        $result   = $service->chat($apiHistory, $userContext);

        $rawReply = $result['reply'];

        // Strip escalation marker from display text, set flag
        $displayReply = preg_replace('/\[ESCALATE:[^\]]*\]/i', '', $rawReply);
        $displayReply = trim($displayReply);

        if (empty($displayReply)) {
            $displayReply = 'Silakan hubungi CS kami untuk mendapatkan bantuan lebih lanjut.';
        }

        $this->isTyping   = false;
        $this->messages[] = [
            'role'      => 'assistant',
            'content'   => $displayReply,
            'timestamp' => now()->format('H:i'),
        ];

        if ($result['should_escalate'] || $this->detectUserEscalationIntent(
            collect($this->messages)->where('role', 'user')->last()['content'] ?? ''
        )) {
            $this->showEscalate = true;
        }

        // Persist to MongoDB (best effort)
        $lastUser = collect($this->messages)->where('role', 'user')->last()['content'] ?? '';
        $this->persistSession($lastUser, $displayReply);
    }

    public function requestEscalation(): void
    {
        $this->showEscalate = true;
        $this->messages[] = [
            'role'      => 'assistant',
            'content'   => 'Baik, saya akan menghubungkan Anda dengan tim CS kami. Klik tombol WhatsApp di bawah ini untuk melanjutkan percakapan dengan agen manusia.',
            'timestamp' => now()->format('H:i'),
        ];
    }

    public function clearChat(): void
    {
        $this->messages     = [];
        $this->showEscalate = false;
        $this->isOpen       = false;
    }

    /**
     * Build sanitized user context for system prompt injection.
     * Only reads data - never modifies anything.
     */
    private function buildUserContext(): array
    {
        if (! auth()->check()) {
            return ['name' => 'Tamu', 'recent_orders' => []];
        }

        $user = auth()->user();

        $recentOrders = Order::where('user_id', (string) $user->_id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get(['order_number', 'status', 'total_amount'])
            ->map(fn($o) => [
                'number' => $o->order_number,
                'status' => $o->status,
                'total'  => number_format($o->total_amount, 0, ',', '.'),
            ])
            ->toArray();

        return [
            'name'          => $user->name,
            'recent_orders' => $recentOrders,
        ];
    }

    /**
     * Detect user intent to escalate based on keywords.
     */
    private function detectUserEscalationIntent(string $input): bool
    {
        $keywords = ['manusia', 'cs', 'admin', 'komplain', 'kecewa', 'marah', 'bisa dihubungi', 'nomor telepon', 'tidak membantu', 'tidak berguna'];
        $lower    = strtolower($input);

        foreach ($keywords as $kw) {
            if (str_contains($lower, $kw)) return true;
        }
        return false;
    }

    /**
     * Save conversation snapshot to MongoDB support_sessions.
     */
    private function persistSession(string $userMsg, string $aiReply): void
    {
        try {
            $userId = auth()->check() ? (string) auth()->user()->_id : null;

            SupportSession::updateOrCreate(
                ['session_key' => $this->sessionId],
                [
                    'user_id'    => $userId,
                    'updated_at' => now(),
                ]
            );

            // Append messages (we do a simple push via raw update)
            SupportSession::where('session_key', $this->sessionId)->push('messages', [
                ['role' => 'user',      'content' => $userMsg,  'timestamp' => now()->toISOString()],
                ['role' => 'assistant', 'content' => $aiReply,  'timestamp' => now()->toISOString()],
            ]);

        } catch (\Exception $e) {
            // Non-critical: silently fail if session logging fails
        }
    }

    public function render()
    {
        return view('livewire.ai-support-widget');
    }
}
