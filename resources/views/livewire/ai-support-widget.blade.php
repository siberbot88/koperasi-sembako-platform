<div
    x-data="{
        scrollToBottom() {
            this.$nextTick(() => {
                const el = document.getElementById('chat-messages');
                if (el) el.scrollTop = el.scrollHeight;
            });
        }
    }"
    x-init="
        $watch('messages', () => scrollToBottom());
        if (isOpen) {
            $nextTick(() => scrollToBottom());
        }
    }"
    {{-- Listen for trigger-ai-fetch: called AFTER user bubble renders --}}
    @trigger-ai-fetch.window="scrollToBottom(); $nextTick(() => $wire.fetchAiResponse())"
>

    {{-- ===== FLOATING ACTION BUTTON ===== --}}
    @if(!$isOpen)
    <button
        wire:click="toggleWidget"
        id="ai-support-fab"
        class="fixed bottom-6 right-6 z-40 w-14 h-14 bg-koperasi-dark border-2 border-koperasi-black rounded-2xl shadow-brutal flex items-center justify-center group transition-transform hover:scale-105 active:scale-95"
        title="Butuh Bantuan? Chat dengan Asisten Kami"
    >
        <svg class="w-6 h-6 text-koperasi-primary group-hover:scale-110 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
        </svg>
        {{-- Notification dot --}}
        <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-koperasi-primary border-2 border-koperasi-dark rounded-full animate-pulse"></span>
    </button>
    @endif

    {{-- ===== CHAT WIDGET PANEL ===== --}}
    @if($isOpen)
    <div
        id="ai-support-panel"
        class="fixed bottom-6 right-6 z-40 w-[360px] max-w-[calc(100vw-2rem)] flex flex-col rounded-2xl border-2 border-koperasi-dark shadow-brutal overflow-hidden"
        style="height: 520px; max-height: calc(100vh - 6rem);"
        x-init="scrollToBottom()"
    >
        {{-- ── Header ── --}}
        <div class="bg-koperasi-dark px-4 py-3 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-koperasi-primary border-2 border-koperasi-black rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-koperasi-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 4.5a.75.75 0 0 1 .721.544l.813 2.846a3.75 3.75 0 0 0 2.576 2.576l2.846.813a.75.75 0 0 1 0 1.442l-2.846.813a3.75 3.75 0 0 0-2.576 2.576l-.813 2.846a.75.75 0 0 1-1.442 0l-.813-2.846a3.75 3.75 0 0 0-2.576-2.576l-2.846-.813a.75.75 0 0 1 0-1.442l2.846-.813A3.75 3.75 0 0 0 7.466 7.89l.813-2.846A.75.75 0 0 1 9 4.5ZM18 1.5a.75.75 0 0 1 .728.568l.258 1.036c.236.94.97 1.674 1.91 1.91l1.036.258a.75.75 0 0 1 0 1.456l-1.036.258c-.94.236-1.674.97-1.91 1.91l-.258 1.036a.75.75 0 0 1-1.456 0l-.258-1.036a2.625 2.625 0 0 0-1.91-1.91l-1.036-.258a.75.75 0 0 1 0-1.456l1.036-.258a2.625 2.625 0 0 0 1.91-1.91l.258-1.036A.75.75 0 0 1 18 1.5Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-koperasi-bg leading-tight">Asisten Koperasi</p>
                    <div class="flex items-center gap-1">
                        <span class="w-1.5 h-1.5 {{ $isTyping ? 'bg-yellow-400 animate-ping' : 'bg-green-400 animate-pulse' }} rounded-full"></span>
                        <p class="text-[10px] text-koperasi-bg/60">{{ $isTyping ? 'Sedang mengetik...' : 'Aktif sekarang' }}</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-1.5">
                <button wire:click="requestEscalation" title="Hubungi CS Manusia" class="w-7 h-7 rounded-lg flex items-center justify-center text-koperasi-bg/50 hover:text-koperasi-bg hover:bg-koperasi-bg/10 transition-colors">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </button>
                <button wire:click="clearChat" title="Akhiri Sesi" class="w-7 h-7 rounded-lg flex items-center justify-center text-koperasi-bg/50 hover:text-koperasi-bg hover:bg-koperasi-bg/10 transition-colors">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- ── Messages ── --}}
        <div
            id="chat-messages"
            class="flex-1 overflow-y-auto p-4 space-y-3 bg-koperasi-bg"
        >
            @foreach($messages as $index => $msg)
            <div class="flex {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }}"
                 x-data="{}"
                 @if($index === count($messages) - 1)
                 x-init="
                    $el.style.opacity = '0';
                    $el.style.transform = '{{ $msg['role'] === 'user' ? 'translateX(16px)' : 'translateX(-16px)' }}';
                    requestAnimationFrame(function() {
                        $el.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
                        $el.style.opacity = '1';
                        $el.style.transform = 'translateX(0)';
                    });
                 "
                 @endif
            >
                @if($msg['role'] === 'assistant')
                <div class="w-6 h-6 bg-koperasi-dark rounded-lg flex items-center justify-center mr-2 mt-auto flex-shrink-0">
                    <svg class="w-3 h-3 text-koperasi-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 4.5a.75.75 0 0 1 .721.544l.813 2.846a3.75 3.75 0 0 0 2.576 2.576l2.846.813a.75.75 0 0 1 0 1.442l-2.846.813a3.75 3.75 0 0 0-2.576 2.576l-.813 2.846a.75.75 0 0 1-1.442 0l-.813-2.846a3.75 3.75 0 0 0-2.576-2.576l-2.846-.813a.75.75 0 0 1 0-1.442l2.846-.813A3.75 3.75 0 0 0 7.466 7.89l.813-2.846A.75.75 0 0 1 9 4.5Z" clip-rule="evenodd" />
                    </svg>
                </div>
                @endif

                <div class="max-w-[80%]">
                    <div class="{{ $msg['role'] === 'user'
                        ? 'bg-koperasi-dark text-koperasi-bg rounded-2xl rounded-br-sm'
                        : 'bg-white text-koperasi-dark border border-koperasi-dark/10 rounded-2xl rounded-bl-sm shadow-sm' }}
                        px-3 py-2.5 text-sm leading-relaxed whitespace-pre-wrap">{{ $msg['content'] }}</div>
                    <p class="text-[10px] text-koperasi-dark/40 mt-1 {{ $msg['role'] === 'user' ? 'text-right' : 'text-left' }}">{{ $msg['timestamp'] ?? '' }}</p>
                </div>
            </div>
            @endforeach

            {{-- ── AI Typing Indicator (shown while isTyping = true) ── --}}
            @if($isTyping)
            <div class="flex justify-start"
                 x-data="{}"
                 x-init="
                    $el.style.opacity = '0';
                    $el.style.transform = 'translateX(-16px)';
                    requestAnimationFrame(function() {
                        $el.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
                        $el.style.opacity = '1';
                        $el.style.transform = 'translateX(0)';
                    });
                 ">
                <div class="w-6 h-6 bg-koperasi-dark rounded-lg flex items-center justify-center mr-2 mt-auto flex-shrink-0">
                    <svg class="w-3 h-3 text-koperasi-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 4.5a.75.75 0 0 1 .721.544l.813 2.846a3.75 3.75 0 0 0 2.576 2.576l2.846.813a.75.75 0 0 1 0 1.442l-2.846.813a3.75 3.75 0 0 0-2.576 2.576l-.813 2.846a.75.75 0 0 1-1.442 0l-.813-2.846a3.75 3.75 0 0 0-2.576-2.576l-2.846-.813a.75.75 0 0 1 0-1.442l2.846-.813A3.75 3.75 0 0 0 7.466 7.89l.813-2.846A.75.75 0 0 1 9 4.5Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="bg-white border border-koperasi-dark/10 rounded-2xl rounded-bl-sm shadow-sm px-4 py-3">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 bg-koperasi-dark/30 rounded-full animate-bounce" style="animation-delay: 0ms; animation-duration: 1s;"></span>
                        <span class="w-2 h-2 bg-koperasi-dark/30 rounded-full animate-bounce" style="animation-delay: 200ms; animation-duration: 1s;"></span>
                        <span class="w-2 h-2 bg-koperasi-dark/30 rounded-full animate-bounce" style="animation-delay: 400ms; animation-duration: 1s;"></span>
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- ── Escalation Banner ── --}}
        @if($showEscalate)
        <div class="px-4 py-3 bg-orange-50 border-t border-orange-200 flex-shrink-0">
            <p class="text-xs text-orange-800 font-medium mb-2">Hubungi CS Manusia untuk bantuan lebih lanjut:</p>
            <a href="https://wa.me/{{ config('services.cs_whatsapp', '6281234567890') }}?text={{ urlencode('Halo, saya butuh bantuan terkait pesanan saya di Koperasi Sembako.') }}"
               target="_blank"
               class="flex items-center justify-center gap-2 w-full bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-2 rounded-xl transition-colors">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                Chat via WhatsApp
            </a>
        </div>
        @endif

        {{-- ── Quick Suggestion Chips (hanya saat awal) ── --}}
        @if(count($messages) <= 1 && !$isTyping)
        <div class="px-3 py-2 bg-koperasi-bg border-t border-koperasi-dark/10 flex-shrink-0">
            <div class="flex flex-wrap gap-1.5">
                @foreach(['Cara lacak pesanan', 'Cara batalkan pesanan', 'Cara gunakan kupon', 'Hubungi CS'] as $chip)
                <button
                    wire:click="$set('userInput', '{{ $chip }}')"
                    class="text-[11px] px-2.5 py-1 bg-white border border-koperasi-dark/15 rounded-lg text-koperasi-dark/70 hover:bg-koperasi-primary hover:text-koperasi-dark hover:border-koperasi-dark transition-colors">
                    {{ $chip }}
                </button>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ── Input Area ── --}}
        <div class="px-3 py-3 bg-white border-t border-koperasi-dark/10 flex-shrink-0">
            <form wire:submit="sendMessage" class="flex items-end gap-2">
                <textarea
                    wire:model="userInput"
                    id="ai-chat-input"
                    placeholder="{{ $isTyping ? 'Asisten sedang membalas...' : 'Ketik pertanyaan Anda...' }}"
                    rows="1"
                    maxlength="500"
                    {{ $isTyping ? 'disabled' : '' }}
                    class="flex-1 resize-none bg-koperasi-bg border border-koperasi-dark/15 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-koperasi-dark focus:ring-0 transition-colors leading-snug disabled:opacity-50 disabled:cursor-not-allowed"
                    style="max-height: 100px;"
                    @keydown.enter.prevent="if (!$event.shiftKey && !{{ $isTyping ? 'true' : 'false' }}) { $wire.sendMessage(); }"
                ></textarea>
                <button
                    type="submit"
                    {{ $isTyping ? 'disabled' : '' }}
                    class="w-10 h-10 bg-koperasi-dark border-2 border-koperasi-black rounded-xl flex items-center justify-center flex-shrink-0 hover:bg-koperasi-primary transition-colors group disabled:opacity-40 disabled:cursor-not-allowed">
                    @if($isTyping)
                    <svg class="w-4 h-4 text-koperasi-bg animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    @else
                    <svg class="w-4 h-4 text-koperasi-primary group-hover:text-koperasi-dark transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M3.478 2.405a.75.75 0 0 0-.926.94l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.405Z" />
                    </svg>
                    @endif
                </button>
            </form>
            <p class="text-[10px] text-koperasi-dark/30 mt-1.5 text-center">Powered by AI · Enter untuk kirim · Shift+Enter untuk baris baru</p>
        </div>
    </div>
    @endif
</div>
