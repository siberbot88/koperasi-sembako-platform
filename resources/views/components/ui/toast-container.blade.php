<div
    x-data="toastContainer()"
    @toast.window="add($event.detail.message, $event.detail.type || 'success', $event.detail.duration || 4000)"
    class="fixed bottom-5 right-5 z-[9999] flex flex-col gap-2.5 items-end pointer-events-none"
    style="max-width: min(calc(100vw - 2.5rem), 22rem)"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            :class="[
                'pointer-events-auto w-full rounded-2xl border-2 shadow-brutal-sm overflow-hidden',
                'transition-all duration-300',
                toast.removing ? 'opacity-0 translate-x-4 scale-95' : 'opacity-100 translate-x-0 scale-100',
                colors(toast.type)
            ]"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-8 scale-95"
            x-transition:enter-end="opacity-100 translate-x-0 scale-100"
        >
            {{-- Body --}}
            <div class="flex items-start gap-3 px-4 py-3.5">
                <span :class="iconColor(toast.type)" x-html="icon(toast.type)" class="flex-shrink-0 mt-0.5"></span>
                <p class="flex-1 text-sm font-semibold leading-snug" x-text="toast.message"></p>
                <button @click="remove(toast.id)" class="flex-shrink-0 opacity-50 hover:opacity-100 transition-opacity ml-1 mt-0.5">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
            {{-- Progress bar --}}
            <div class="h-1 w-full bg-black/5">
                <div
                    :class="progressColor(toast.type)"
                    :style="'width: ' + toast.progress + '%; transition: width 50ms linear'"
                    class="h-full rounded-full"
                ></div>
            </div>
        </div>
    </template>
</div>
