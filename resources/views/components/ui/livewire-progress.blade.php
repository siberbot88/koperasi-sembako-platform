<div
    x-data="livewireProgress()"
    {{-- Alpine event listeners --}}
    x-on:livewire:navigating.window="start()"
    x-on:livewire:navigated.window="finish()"
    x-show="loading"
    x-cloak
    class="fixed top-0 inset-x-0 z-[9997] pointer-events-none"
>
    <div
        x-bind:style="'width: ' + progress + '%; transition: width 200ms ease'"
        class="h-[3px] bg-koperasi-primary shadow-[0_0_8px_rgba(246,249,48,0.8)] rounded-r-full"
    ></div>
</div>
