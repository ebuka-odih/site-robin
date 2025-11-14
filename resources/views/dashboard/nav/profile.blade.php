@extends('dashboard.new-layout')

@section('content')
<div class="space-y-7 text-white">
    <div class="space-y-1">
        <p class="text-[11px] uppercase tracking-[0.3em] text-[#08f58d]">Profile</p>
        <h1 class="text-2xl font-semibold">Hi {{ $user->name }}, keep your account sharp.</h1>
        <p class="text-sm text-gray-400">Review account stats, jump into deeper settings, or sign out.</p>
    </div>

    <div class="rounded-[32px] border border-[#101010] bg-[#040404] p-5 flex flex-col sm:flex-row gap-5 items-center">
        <div class="flex items-center gap-4 w-full">
            <div class="h-16 w-16 rounded-2xl bg-[#0b0b0b] border border-[#1fff9c]/30 flex items-center justify-center text-xl font-semibold">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="flex-1">
                <p class="text-lg font-semibold">{{ $user->name }}</p>
                <p class="text-sm text-gray-400">{{ $user->email }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
            @csrf
            <button type="submit" class="w-full rounded-2xl border border-[#ff4d4d]/50 px-4 py-2 text-sm font-semibold text-[#ff4d4d] hover:bg-[#ff4d4d]/10">
                Logout
            </button>
        </form>
    </div>

    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-3xl border border-[#111] bg-[#050505] p-5 space-y-1">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Email</p>
            <p class="text-base font-semibold">{{ $user->email }}</p>
        </div>
        <div class="rounded-3xl border border-[#111] bg-[#050505] p-5 space-y-1">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Member Since</p>
            <p class="text-base font-semibold">{{ $user->created_at->format('M Y') }}</p>
        </div>
        <div class="rounded-3xl border border-[#111] bg-[#050505] p-5 space-y-1">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Status</p>
            <p class="text-sm font-semibold text-green-400 flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-green-400"></span> Active
            </p>
        </div>
    </div>

    <div class="rounded-[32px] border border-[#111] bg-[#050505] p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="space-y-1">
            <p class="text-[11px] uppercase tracking-[0.3em] text-gray-400">Full Settings</p>
            <p class="text-xl font-semibold">Update profile, security, and preferences</p>
            <p class="text-sm text-gray-400">Manage password, contact info, KYC details, and more.</p>
        </div>
        <a href="{{ route('user.profile') }}" class="rounded-full bg-gradient-to-r from-[#00ff5f] to-[#0fb863] px-6 py-3 text-black font-semibold text-sm text-center">
            Open Profile Settings
        </a>
    </div>
</div>
@endsection
