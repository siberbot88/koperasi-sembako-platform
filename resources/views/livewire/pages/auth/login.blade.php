<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $user = auth()->user();
        if ($user && $user->isSeller()) {
            $this->redirect(route('seller.dashboard', absolute: false), navigate: true);
        } else {
            $this->redirectIntended(default: route('home', absolute: false), navigate: true);
        }
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8 text-center">
        <h2 class="text-2xl font-black font-heading text-koperasi-dark mb-2">Masuk ke Akun Anda</h2>
        <p class="text-sm font-medium text-koperasi-dark/60">Lanjutkan belanja atau kelola toko Anda</p>
    </div>

    <form wire:submit="login" class="space-y-5">
        <!-- Email Address -->
        <div>
            <label for="email" class="block font-bold text-sm text-koperasi-dark mb-1">Email Koperasi</label>
            <input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username" 
                class="w-full rounded-xl border-2 border-koperasi-dark bg-koperasi-bg/50 px-4 py-3 font-medium text-koperasi-dark focus:border-koperasi-primary focus:ring-0 focus:bg-white transition-colors" placeholder="nama@email.com">
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block font-bold text-sm text-koperasi-dark mb-1">Kata Sandi</label>
            <input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password" 
                class="w-full rounded-xl border-2 border-koperasi-dark bg-koperasi-bg/50 px-4 py-3 font-medium text-koperasi-dark focus:border-koperasi-primary focus:ring-0 focus:bg-white transition-colors" placeholder="••••••••">
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between pt-2">
            <label for="remember" class="inline-flex items-center cursor-pointer group">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-2 border-koperasi-dark text-koperasi-dark shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] focus:ring-koperasi-primary w-5 h-5 cursor-pointer" name="remember">
                <span class="ms-2 text-sm font-bold text-koperasi-dark/80 group-hover:text-koperasi-dark transition-colors">Ingat Saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-bold text-koperasi-primary hover:text-koperasi-dark underline decoration-2 underline-offset-4 transition-colors" href="{{ route('password.request') }}" wire:navigate>
                    Lupa sandi?
                </a>
            @endif
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full btn-primary py-3 text-lg uppercase tracking-wider shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[-2px] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] transition-all">
                Masuk Sekarang
            </button>
        </div>
        
        <div class="text-center pt-5 border-t-2 border-dashed border-koperasi-dark/10 mt-4">
            <p class="text-sm font-medium text-koperasi-dark/60">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-black text-koperasi-dark hover:text-koperasi-primary transition-colors underline decoration-2 underline-offset-4" wire:navigate>Daftar disini</a>
            </p>
        </div>
    </form>
</div>
