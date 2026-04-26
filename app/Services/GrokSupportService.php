<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * GrokSupportService
 *
 * Handles communication with xAI Grok API for the AI Customer Service widget.
 * Builds a safe, constrained system prompt using the user's context,
 * calls the Grok Chat Completions API, and returns a structured response.
 */
class GrokSupportService
{
    private string $apiKey;
    private string $model;
    private int    $maxTokens;
    private string $apiUrl;

    public function __construct()
    {
        $this->apiKey    = config('services.grok.api_key', '');
        $this->maxTokens = (int) config('services.grok.max_tokens', 512);

        // Auto-detect provider based on API key prefix
        // gsk_...  → Groq (https://api.groq.com) — free, ultra-fast inference
        // xai-...  → xAI Grok (https://api.x.ai)  — official Grok model
        if (str_starts_with($this->apiKey, 'gsk_')) {
            $this->apiUrl = 'https://api.groq.com/openai/v1/chat/completions';
            $this->model  = config('services.grok.model', 'llama-3.3-70b-versatile');
        } else {
            $this->apiUrl = 'https://api.x.ai/v1/chat/completions';
            $this->model  = config('services.grok.model', 'grok-3-mini');
        }
    }

    /**
     * Send a message to Grok and get a response.
     *
     * @param  array  $conversationHistory  Array of ['role' => 'user|assistant', 'content' => '...']
     * @param  array  $userContext          Sanitized user context (name, recent orders)
     * @return array  ['reply' => string, 'should_escalate' => bool, 'error' => string|null]
     */
    public function chat(array $conversationHistory, array $userContext = []): array
    {
        if (empty($this->apiKey)) {
            return [
                'reply'            => $this->fallbackReply(),
                'should_escalate'  => false,
                'error'            => 'API key not configured',
            ];
        }

        $systemPrompt = $this->buildSystemPrompt($userContext);

        $messages = array_merge(
            [['role' => 'system', 'content' => $systemPrompt]],
            $conversationHistory
        );

        try {
            $response = Http::withToken($this->apiKey)
                ->timeout(20)
                ->post($this->apiUrl, [
                    'model'       => $this->model,
                    'messages'    => $messages,
                    'max_tokens'  => $this->maxTokens,
                    'temperature' => 0.5,
                ]);

            if ($response->failed()) {
                Log::warning('GrokSupportService: API call failed', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);

                return [
                    'reply'           => $this->fallbackReply(),
                    'should_escalate' => false,
                    'error'           => 'API error ' . $response->status(),
                ];
            }

            $data  = $response->json();
            $reply = $data['choices'][0]['message']['content'] ?? $this->fallbackReply();

            return [
                'reply'           => $reply,
                'should_escalate' => $this->detectEscalation($reply),
                'error'           => null,
            ];

        } catch (\Exception $e) {
            Log::error('GrokSupportService: Exception', ['message' => $e->getMessage()]);

            return [
                'reply'           => $this->fallbackReply(),
                'should_escalate' => false,
                'error'           => $e->getMessage(),
            ];
        }
    }

    /**
     * Build a tight, safe system prompt with injected user context.
     * The prompt strictly limits what the AI can and cannot do.
     */
    private function buildSystemPrompt(array $ctx): string
    {
        $userName     = $ctx['name']         ?? 'Pelanggan';
        $recentOrders = $ctx['recent_orders'] ?? [];
        $csWhatsApp   = config('services.cs_whatsapp', '6281234567890');

        $orderSummary = '';
        if (!empty($recentOrders)) {
            $orderSummary = "\n\nPesanan terbaru pelanggan ini:\n";
            foreach ($recentOrders as $order) {
                $orderSummary .= "- No: {$order['number']}, Status: {$order['status']}, Total: Rp {$order['total']}\n";
            }
        }

        return <<<PROMPT
Kamu adalah Asisten Koperasi Sembako, asisten layanan pelanggan digital yang ramah dan membantu.

IDENTITAS:
- Nama kamu: Asisten Koperasi
- Kamu bekerja untuk platform e-commerce sembako bernama "Koperasi Sembako"
- Kamu hanya bisa membantu soal penggunaan website, status pesanan, fitur platform, dan panduan belanja

INFORMASI PELANGGAN:
- Nama pelanggan saat ini: {$userName}{$orderSummary}

YANG BOLEH KAMU LAKUKAN:
- Menjelaskan cara menggunakan fitur website (checkout, keranjang, kupon, wishlist, ulasan, pelacakan pengiriman)
- Memberitahu status pesanan berdasarkan data yang diberikan
- Membantu navigasi halaman (pesanan saya: /orders, profil: /profile, produk: /products)
- Memberikan troubleshooting umum untuk masalah umum
- Menyarankan langkah selanjutnya yang jelas dan konkret
- Merekomendasikan untuk menghubungi CS manusia jika masalah tidak terselesaikan

YANG TIDAK BOLEH KAMU LAKUKAN:
- Menjanjikan refund, diskon, atau kompensasi apapun
- Mengubah data pesanan, alamat, atau akun pelanggan
- Memberikan informasi harga atau stok yang tidak kamu ketahui
- Membuat data pengiriman atau nomor resi palsu
- Memberikan jawaban di luar konteks platform Koperasi Sembako
- Berbicara soal kompetitor atau platform lain
- Mengambil keputusan bisnis yang seharusnya dilakukan manusia

JIKA ESKALASI DIPERLUKAN:
Jika masalah tidak dapat diselesaikan, tambahkan kalimat di akhir:
"[ESCALATE: Silakan hubungi CS kami di WhatsApp {$csWhatsApp} untuk bantuan lebih lanjut.]"

GAYA KOMUNIKASI:
- Bahasa Indonesia yang ramah dan natural
- Jawaban singkat dan to the point (maksimal 3 paragraf)
- Gunakan poin/list jika ada lebih dari 2 langkah
- Selalu akhiri dengan pertanyaan "Ada lagi yang bisa saya bantu?"
PROMPT;
    }

    /**
     * Detect if the AI's reply contains an escalation signal.
     */
    private function detectEscalation(string $reply): bool
    {
        return str_contains($reply, '[ESCALATE:');
    }

    /**
     * Fallback reply when the API is unavailable or not configured.
     */
    private function fallbackReply(): string
    {
        $csWhatsApp = config('services.cs_whatsapp', '6281234567890');
        return "Mohon maaf, asisten AI kami sedang tidak tersedia saat ini. "
            . "Silakan hubungi CS kami langsung melalui WhatsApp di nomor {$csWhatsApp} "
            . "untuk mendapatkan bantuan segera.";
    }
}
