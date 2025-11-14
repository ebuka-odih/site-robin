<!DOCTYPE html>
<html lang="en" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }} - Verify Email</title>
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">
    
    <!-- Tailwind CSS CDN for immediate styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-black min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <!-- Brand Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-full mb-4">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-lg transform rotate-12"></div>
                </div>
            </div>
            <h1 class="text-2xl font-bold text-white">{{ env('APP_NAME') }}</h1>
        </div>

        <!-- Verification Form Card -->
        <div class="bg-gray-800 rounded-lg p-8 shadow-2xl border border-gray-700">
            <div class="text-center mb-6">
                <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-blue-600 mb-4">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white mb-2">Verify Your Email</h2>
                <p class="text-sm text-gray-400">
                    We've sent a verification code to your email address
                </p>
                @if(request()->query('email'))
                    <p class="mt-2 text-sm text-blue-400 font-medium">
                        {{ request()->query('email') }}
                    </p>
                @endif
            </div>

            @if (session('success'))
                <div class="mb-6 bg-green-900 border border-green-700 text-green-300 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-900 border border-red-700 text-red-300 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('verification.code.verify') }}" class="space-y-6">
                @csrf
                
                <!-- Verification Code Field -->
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-300 mb-2">Verification Code</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 00-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input 
                            id="code" 
                            name="code" 
                            type="text" 
                            value="{{ old('code') }}"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-600 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('code') border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Enter 6-digit code"
                            required 
                            autocomplete="off"
                            autofocus
                            maxlength="6"
                            pattern="[0-9]{6}"
                        >
                    </div>
                    @error('code')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Verify Button -->
                <button 
                    type="submit" 
                    id="verifySubmitBtn"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-cyan-400 hover:from-blue-600 hover:to-cyan-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105"
                >
                    <span id="verifyBtnText">Verify Email</span>
                    <span id="verifyBtnSpinner" class="hidden">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Verifying...
                    </span>
                </button>
            </form>

            <!-- Resend Code Section -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-400">
                    Didn't receive the code? 
                    <button 
                        type="button" 
                        onclick="resendCode()"
                        class="font-medium text-blue-400 hover:text-blue-300 transition-colors"
                    >
                        Resend Code
                    </button>
                </p>
            </div>

            <!-- Back to Login Link -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-400">
                    Remember your password? 
                    <a href="{{ route('login') }}" class="font-medium text-blue-400 hover:text-blue-300 transition-colors">
                        Sign In
                    </a>
                </p>
            </div>
        </div>

        <!-- Back to Home Link -->
        <div class="mt-8 text-center">
            <a href="{{ route('index') }}" class="text-sm text-gray-500 hover:text-gray-400 transition-colors">
                ← Back to Home
            </a>
        </div>
    </div>

    <!-- Resend Code Form (Hidden) -->
    <form id="resendForm" action="{{ route('verification.code.resend') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="email" value="{{ request()->query('email') }}">
    </form>

    <script>
        function resendCode() {
            const form = document.getElementById('resendForm');
            if (form) {
                form.submit();
            }
        }

        // Auto-focus on code input
        document.addEventListener('DOMContentLoaded', function() {
            const codeInput = document.getElementById('code');
            if (codeInput) {
                codeInput.focus();
            }
        });

        // Auto-format code input (6 digits only)
        document.getElementById('code').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 6) {
                value = value.slice(0, 6);
            }
            e.target.value = value;
        });

        // Verification form processing state
        function setVerifyButtonProcessing(isProcessing) {
            const button = document.getElementById('verifySubmitBtn');
            const buttonText = document.getElementById('verifyBtnText');
            const buttonSpinner = document.getElementById('verifyBtnSpinner');
            
            if (isProcessing) {
                button.disabled = true;
                button.classList.add('opacity-50', 'cursor-not-allowed');
                button.classList.remove('hover:from-blue-600', 'hover:to-cyan-500', 'hover:scale-105');
                buttonText.classList.add('hidden');
                buttonSpinner.classList.remove('hidden');
                buttonSpinner.classList.remove('hidden');
            } else {
                button.disabled = false;
                button.classList.remove('opacity-50', 'cursor-not-allowed');
                button.classList.add('hover:from-blue-600', 'hover:to-cyan-500', 'hover:scale-105');
                buttonText.classList.remove('hidden');
                buttonSpinner.classList.add('hidden');
            }
        }

        // Form submission
        document.querySelector('form').addEventListener('submit', function() {
            setVerifyButtonProcessing(true);
        });
    </script>
</body>
</html>
