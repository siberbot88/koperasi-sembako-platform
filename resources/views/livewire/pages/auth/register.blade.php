<?php

use App\Models\User;
use App\Models\Store;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\Support\Str;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'customer';

        $user = User::create($validated);

        event(new Registered($user));

        Auth::login($user);

        $this->redirect(route('home', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-black font-heading text-koperasi-dark mb-2">Daftar Anggota</h2>
        <p class="text-sm font-medium text-koperasi-dark/60">Bergabunglah dengan Koperasi Sembako</p>
    </div>

    <form wire:submit="register" class="space-y-4">

        <!-- Name -->
        <div>
            <label for="name" class="block font-bold text-sm text-koperasi-dark mb-1">Nama Lengkap</label>
            <input wire:model="name" id="name" type="text" name="name" required autofocus autocomplete="name" 
                class="w-full rounded-xl border-2 border-koperasi-dark bg-koperasi-bg/50 px-4 py-2.5 font-medium text-koperasi-dark focus:border-koperasi-primary focus:ring-0 focus:bg-white transition-colors" placeholder="Budi Santoso">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-bold text-sm text-koperasi-dark mb-1">Email</label>
            <input wire:model="email" id="email" type="email" name="email" required autocomplete="username" 
                class="w-full rounded-xl border-2 border-koperasi-dark bg-koperasi-bg/50 px-4 py-2.5 font-medium text-koperasi-dark focus:border-koperasi-primary focus:ring-0 focus:bg-white transition-colors" placeholder="budi@email.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="password" class="block font-bold text-sm text-koperasi-dark mb-1">Kata Sandi</label>
                <input wire:model="password" id="password" type="password" name="password" required autocomplete="new-password" 
                    class="w-full rounded-xl border-2 border-koperasi-dark bg-koperasi-bg/50 px-4 py-2.5 font-medium text-koperasi-dark focus:border-koperasi-primary focus:ring-0 focus:bg-white transition-colors" placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <label for="password_confirmation" class="block font-bold text-sm text-koperasi-dark mb-1">Ulangi Sandi</label>
                <input wire:model="password_confirmation" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                    class="w-full rounded-xl border-2 border-koperasi-dark bg-koperasi-bg/50 px-4 py-2.5 font-medium text-koperasi-dark focus:border-koperasi-primary focus:ring-0 focus:bg-white transition-colors" placeholder="••••••••">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="pt-6">
            <button type="submit" class="w-full btn-primary py-3 text-lg uppercase tracking-wider shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[-2px] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] transition-all">
                Daftar Sekarang
            </button>
        </div>

        <div class="text-center pt-5 border-t-2 border-dashed border-koperasi-dark/10 mt-4">
            <p class="text-sm font-medium text-koperasi-dark/60">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-black text-koperasi-dark hover:text-koperasi-primary transition-colors underline decoration-2 underline-offset-4" wire:navigate>Masuk disini</a>
            </p>
        </div>
    </form>
</div>
