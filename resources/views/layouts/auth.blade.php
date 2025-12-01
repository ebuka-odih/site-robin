<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ \App\Helpers\WebsiteSettingsHelper::getSiteName() }} — @yield('title', 'Account')</title>
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">
    
    {{-- PWA Meta Tags --}}
    <meta name="theme-color" content="#1fff9c">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="{{ \App\Helpers\WebsiteSettingsHelper::getSiteName() }}">
    <meta name="description" content="{{ \App\Helpers\WebsiteSettingsHelper::getSiteTagline() ?: 'Secure cryptocurrency trading platform' }}">
    
    {{-- Apple Touch Icons --}}
    <link rel="apple-touch-icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="192x192" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="512x512" href="{{ asset('assets/img/favicon.png') }}">
    
    {{-- PWA Manifest --}}
    <link rel="manifest" href="{{ route('pwa.manifest') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-black text-white flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md space-y-8">
        <div class="text-center space-y-3">
            <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl border border-[#1fff9c]/40 bg-[#041207] text-[#1fff9c]">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M12 3v18" />
                </svg>
            </div>
            <div>
                <p class="text-xs tracking-[0.3em] text-[#08f58d] uppercase">Smart Trader</p>
                <h1 class="text-2xl font-semibold">{{ config('app.name') }}</h1>
            </div>
            @if(View::hasSection('subtitle'))
                <p class="text-sm text-gray-400">@yield('subtitle')</p>
            @endif
        </div>

        <div class="rounded-[28px] border border-[#111] bg-[#050505] p-6 shadow-[0_30px_120px_rgba(0,0,0,0.45)]">
            @yield('content')
        </div>

        @hasSection('footer')
            <div class="text-center text-sm text-gray-500">
                @yield('footer')
            </div>
        @endif
    </div>

    @stack('scripts')
    
    {{-- PWA Service Worker Registration --}}
    <script src="{{ asset('js/pwa-sw-register.js') }}"></script>
    
    {{-- PWA Install Prompt --}}
    <script src="{{ asset('js/pwa-install-prompt.js') }}"></script>
</body>
</html>
