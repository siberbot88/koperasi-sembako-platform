<div
    x-data="confirmDialog()"
    @confirm.window="show($event.detail)"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-[9990] flex items-center justify-center p-4"
    @keydown.escape.window="cancel()"
>
    {{-- Backdrop --}}
    <div
        class="absolute inset-0 bg-koperasi-dark/60 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="cancel()"
    ></div>

    {{-- Dialog --}}
    <div
        class="relative bg-white rounded-2xl border-2 border-koperasi-dark shadow-brutal w-full max-w-sm overflow-hidden"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        @click.stop
    >
        <div class="p-6">
            {{-- Icon --}}
            <div :class="iconClass()" class="w-12 h-12 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <template x-if="type === 'danger'">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd"/>
                    </svg>
                </template>
                <template x-if="type === 'warning'">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5A.75.75 0 0 0 12 9Z" clip-rule="evenodd"/>
                    </svg>
                </template>
                <template x-if="type === 'info'">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5A.75.75 0 0 0 12 9Z" clip-rule="evenodd"/>
                    </svg>
                </template>
            </div>

            <h3 class="text-center text-base font-bold text-koperasi-dark mb-2" x-text="title"></h3>
            <p class="text-center text-sm text-koperasi-dark/60 leading-relaxed" x-text="message"></p>
        </div>

        <div class="px-6 pb-6 flex gap-3">
            <button @click="cancel()" class="flex-1 btn btn-outline text-sm" x-text="cancelText"></button>
            <button @click="confirm()" :class="'flex-1 btn border-2 text-sm font-bold ' + btnClass()" x-text="confirmText"></button>
        </div>
    </div>
</div>
