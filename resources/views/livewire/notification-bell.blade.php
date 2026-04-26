<div x-data="{ open: @entangle('showDropdown') }" class="relative">
    {{-- Bell Icon - Ukuran Original --}}
    <button 
        @click="open = !open"
        class="relative p-2 rounded-xl hover:bg-koperasi-dark/5 transition-colors"
        title="Notifikasi"
    >
        <svg class="w-5 h-5 text-koperasi-dark/70" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
        </svg>
        
        {{-- Badge --}}
        @if($unreadCount > 0)
        <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center border border-white">
            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
        </span>
        @endif
    </button>

    {{-- Dropdown - Diperbesar --}}
    <div 
        x-show="open" 
        @click.outside="open = false"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-[420px] bg-white border-2 border-koperasi-dark rounded-xl shadow-brutal overflow-hidden z-50"
        x-cloak
    >
        {{-- Header --}}
        <div class="px-5 py-4 border-b border-koperasi-dark/10 flex items-center justify-between bg-koperasi-bg">
            <h3 class="font-bold text-base text-koperasi-dark">Notifikasi</h3>
            @if($unreadCount > 0)
            <button 
                wire:click="markAllAsRead"
                class="text-sm text-koperasi-primary hover:text-koperasi-dark font-medium transition-colors"
            >
                Tandai Semua Dibaca
            </button>
            @endif
        </div>

        {{-- Notifications List --}}
        <div class="max-h-[550px] overflow-y-auto">
            @forelse($notifications as $notification)
            <button 
                wire:click="markAsRead('{{ $notification->_id }}')"
                class="w-full text-left px-5 py-4 hover:bg-koperasi-accent/20 transition-colors border-b border-koperasi-dark/5 {{ $notification->isUnread() ? 'bg-koperasi-accent/10' : '' }}"
            >
                <div class="flex items-start gap-4">
                    {{-- Icon based on type --}}
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center {{ $notification->isUnread() ? 'bg-koperasi-primary' : 'bg-koperasi-dark/10' }}">
                        @if($notification->type === 'order_status')
                            <svg class="w-6 h-6 text-koperasi-dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3.375 4.5C2.339 4.5 1.5 5.34 1.5 6.375V13.5h12V6.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM13.5 15h-12v2.625c0 1.035.84 1.875 1.875 1.875h.375a3 3 0 1 1 6 0h3a.75.75 0 0 0 .75-.75V15Z" />
                                <path d="M8.25 19.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0ZM15.75 6.75a.75.75 0 0 0-.75.75v11.25c0 .087.015.17.042.248a3 3 0 0 1 5.958.464c.853-.175 1.522-.935 1.464-1.883a18.659 18.659 0 0 0-3.732-10.104 1.837 1.837 0 0 0-1.47-.725H15.75Z" />
                                <path d="M19.5 19.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
                            </svg>
                        @elseif($notification->type === 'new_order')
                            <svg class="w-6 h-6 text-koperasi-dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z" clip-rule="evenodd" />
                            </svg>
                        @elseif($notification->type === 'new_review')
                            <svg class="w-6 h-6 text-koperasi-dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                            </svg>
                        @elseif($notification->type === 'review_reply')
                            <svg class="w-6 h-6 text-koperasi-dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.848 2.771A49.144 49.144 0 0 1 12 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97a48.901 48.901 0 0 1-3.476.383.39.39 0 0 0-.297.17l-2.755 4.133a.75.75 0 0 1-1.248 0l-2.755-4.133a.39.39 0 0 0-.297-.17 48.9 48.9 0 0 1-3.476-.384c-1.978-.29-3.348-2.024-3.348-3.97V6.741c0-1.946 1.37-3.68 3.348-3.97Z" clip-rule="evenodd" />
                            </svg>
                        @elseif($notification->type === 'new_coupon')
                            <svg class="w-6 h-6 text-koperasi-dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.25 2.25a3 3 0 0 0-3 3v4.318a3 3 0 0 0 .879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.428a18.849 18.849 0 0 0 5.441-5.44c.758-1.16.492-2.629-.428-3.548l-9.58-9.581a3 3 0 0 0-2.122-.879H5.25ZM6.375 7.5a1.125 1.125 0 1 0 0-2.25 1.125 1.125 0 0 0 0 2.25Z" clip-rule="evenodd" />
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-koperasi-dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5A.75.75 0 0 0 12 9Z" clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-[15px] font-bold text-koperasi-dark leading-snug">{{ $notification->title }}</p>
                        <p class="text-[13px] text-koperasi-dark/70 mt-1.5 leading-relaxed">{{ $notification->message }}</p>
                        <p class="text-xs text-koperasi-dark/40 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>

                    {{-- Unread indicator --}}
                    @if($notification->isUnread())
                    <div class="flex-shrink-0 w-2.5 h-2.5 bg-koperasi-primary rounded-full mt-1"></div>
                    @endif
                </div>
            </button>
            @empty
            <div class="px-5 py-12 text-center">
                <svg class="w-12 h-12 text-koperasi-dark/20 mx-auto mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                </svg>
                <p class="text-sm text-koperasi-dark/40 font-medium">Belum ada notifikasi</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
