@extends('layouts.auth')

@section('title', 'Create Account')
@section('subtitle', 'Open a Smart Trader account and start investing.')

@section('content')
<form method="POST" action="{{ route('register') }}" class="space-y-5">
    @csrf

    <div class="space-y-2">
        <label for="name" class="text-xs uppercase tracking-wide text-gray-400">Full Name</label>
        <input
            id="name"
            name="name"
            type="text"
            value="{{ old('name') }}"
            class="w-full rounded-2xl border border-[#161616] bg-[#030303] px-4 py-3 text-sm text-white placeholder-gray-500 focus:border-[#1fff9c] focus:outline-none"
            placeholder="Jane Doe"
            required
            autocomplete="name"
            autofocus
        >
        @error('name') <p class="text-xs text-red-400">{{ $message }}</p> @enderror
    </div>

    <div class="space-y-2">
        <label for="username" class="text-xs uppercase tracking-wide text-gray-400">Username</label>
        <input
            id="username"
            name="username"
            type="text"
            value="{{ old('username') }}"
            class="w-full rounded-2xl border border-[#161616] bg-[#030303] px-4 py-3 text-sm text-white placeholder-gray-500 focus:border-[#1fff9c] focus:outline-none"
            placeholder="janedoe"
            required
            autocomplete="username"
        >
        @error('username') <p class="text-xs text-red-400">{{ $message }}</p> @enderror
    </div>

    <div class="space-y-2">
        <label for="email" class="text-xs uppercase tracking-wide text-gray-400">Email</label>
        <input
            id="email"
            name="email"
            type="email"
            value="{{ old('email') }}"
            class="w-full rounded-2xl border border-[#161616] bg-[#030303] px-4 py-3 text-sm text-white placeholder-gray-500 focus:border-[#1fff9c] focus:outline-none"
            placeholder="you@email.com"
            required
            autocomplete="email"
        >
        @error('email') <p class="text-xs text-red-400">{{ $message }}</p> @enderror
    </div>

    <div class="space-y-2">
        <label for="password" class="text-xs uppercase tracking-wide text-gray-400">Password</label>
        <input
            id="password"
            name="password"
            type="password"
            class="w-full rounded-2xl border border-[#161616] bg-[#030303] px-4 py-3 text-sm text-white placeholder-gray-500 focus:border-[#1fff9c] focus:outline-none"
            placeholder="Create password"
            required
            autocomplete="new-password"
        >
        @error('password') <p class="text-xs text-red-400">{{ $message }}</p> @enderror
    </div>

    <div class="space-y-2">
        <label for="password_confirmation" class="text-xs uppercase tracking-wide text-gray-400">Confirm Password</label>
        <input
            id="password_confirmation"
            name="password_confirmation"
            type="password"
            class="w-full rounded-2xl border border-[#161616] bg-[#030303] px-4 py-3 text-sm text-white placeholder-gray-500 focus:border-[#1fff9c] focus:outline-none"
            placeholder="Repeat password"
            required
            autocomplete="new-password"
        >
    </div>

    <button type="submit" id="register-btn" class="w-full rounded-2xl bg-gradient-to-r from-[#00ff5f] to-[#05c46b] py-3 text-sm font-semibold text-black transition hover:brightness-110 flex items-center justify-center gap-2">
        <span id="register-btn-text">Create account</span>
        <svg id="register-spinner" class="hidden h-4 w-4 animate-spin text-black" viewBox="0 0 24 24" fill="none">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
    </button>
</form>
@endsection

@section('footer')
    <p>Already a member?
        <a href="{{ route('login') }}" class="text-[#00ff5f] font-semibold">Sign in</a>
    </p>
    <p class="mt-2">
        <a href="{{ route('index') }}" class="text-gray-500 hover:text-white">← Back to site</a>
    </p>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const btn = document.getElementById('register-btn');
    const text = document.getElementById('register-btn-text');
    const spinner = document.getElementById('register-spinner');
    form?.addEventListener('submit', () => {
        btn.disabled = true;
        spinner.classList.remove('hidden');
        text.textContent = 'Creating account...';
    });
});
</script>
@endpush
