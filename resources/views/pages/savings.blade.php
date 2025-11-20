@extends('pages.new-layout')

@section('content')
<section class="space-y-24">
    <!-- Hero Section -->
    <div class="text-center space-y-8">
        <div class="space-y-4">
            <p class="text-xs uppercase tracking-[0.4em] text-[#05c46b]">{{ config('app.name') }} Savings</p>
            <h1 class="text-5xl font-semibold leading-tight text-[#140a33] md:text-6xl lg:text-7xl">
                Earn high interest<br>on your savings
            </h1>
            <p class="mx-auto max-w-3xl text-xl text-[#6b628d]">
                Put your money to work in our easy access, high yield Savings. No lock-ins, no minimums, just competitive returns.
            </p>
        </div>
        <div>
            <a href="{{ route('register') }}" class="inline-block rounded-full bg-[#05c46b] px-10 py-4 text-lg font-semibold text-white shadow-xl shadow-[#05c46b]/30 hover:bg-[#04b35f] transition-colors">
                Start saving
            </a>
        </div>
    </div>

    <!-- APY Display -->
    <div class="rounded-[48px] bg-gradient-to-br from-[#f0fff8] to-[#e6fff4] border-2 border-[#05c46b]/20 px-8 py-20 text-center">
        <p class="text-sm uppercase tracking-[0.4em] text-[#05c46b]">Current Rate</p>
        <div class="mt-8 text-[120px] leading-none font-bold text-[#05c46b]">
            1.91<span class="text-5xl align-top">%</span>
        </div>
        <p class="mt-4 text-2xl font-medium text-[#35276e]">APY</p>
        <p class="mt-6 text-lg text-[#6b628d]">Annual Percentage Yield</p>
        <p class="mt-2 text-sm text-[#8a7fc1]">Rate is variable and may change. Updated daily.</p>
    </div>

    <!-- Key Features -->
    <div class="grid gap-6 md:grid-cols-3">
        <div class="rounded-3xl border border-[#f0edff] bg-white p-8 space-y-4">
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-[#f0fff8]">
                <svg class="h-7 w-7 text-[#05c46b]" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-[#05c46b]">Follows the</p>
                <h3 class="text-xl font-semibold text-[#140a33]">European Central Bank</h3>
                <p class="text-sm text-[#6b628d]">Benchmarked against the ECB's variable overnight interest rate, automatically calculated daily.</p>
            </div>
        </div>

        <div class="rounded-3xl border border-[#f0edff] bg-white p-8 space-y-4">
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-[#f4f0ff]">
                <svg class="h-7 w-7 text-[#5c28ff]" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-[#5c28ff]">Managed by</p>
                <h3 class="text-xl font-semibold text-[#140a33]">BlackRock</h3>
                <p class="text-sm text-[#6b628d]">Run by BlackRock, the world's largest asset manager with over $10 trillion under management.</p>
            </div>
        </div>

        <div class="rounded-3xl border border-[#f0edff] bg-white p-8 space-y-4">
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-[#fff5e6]">
                <svg class="h-7 w-7 text-[#ff9500]" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-[#ff9500]">No limits</p>
                <h3 class="text-xl font-semibold text-[#140a33]">No minimums</h3>
                <p class="text-sm text-[#6b628d]">Start from spare change or add millions—there's no cap on how much you can keep in Savings.</p>
            </div>
        </div>
    </div>

    <!-- How Savings Works -->
    <div class="space-y-10">
        <div class="text-center space-y-3">
            <p class="text-xs uppercase tracking-[0.4em] text-[#8f7dfd]">Simple & Flexible</p>
            <h2 class="text-4xl font-semibold text-[#140a33] md:text-5xl">How Savings works</h2>
        </div>

        <div class="grid gap-6 md:grid-cols-3">
            <div class="rounded-3xl border border-[#f0edff] bg-white p-8">
                <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-[#05c46b] to-[#04b35f] text-white text-2xl font-bold">
                    1
                </div>
                <h3 class="mb-3 text-xl font-semibold text-[#35276e]">Deposit funds</h3>
                <p class="text-[#6b628d]">Transfer money into your Savings account instantly from your {{ config('app.name') }} wallet or external bank account. No waiting periods.</p>
            </div>

            <div class="rounded-3xl border border-[#f0edff] bg-white p-8">
                <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-[#05c46b] to-[#04b35f] text-white text-2xl font-bold">
                    2
                </div>
                <h3 class="mb-3 text-xl font-semibold text-[#35276e]">Earn daily interest</h3>
                <p class="text-[#6b628d]">Interest is calculated daily and added to your balance automatically. Watch your savings grow with compound interest.</p>
            </div>

            <div class="rounded-3xl border border-[#f0edff] bg-white p-8">
                <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-[#05c46b] to-[#04b35f] text-white text-2xl font-bold">
                    3
                </div>
                <h3 class="mb-3 text-xl font-semibold text-[#35276e]">Withdraw anytime</h3>
                <p class="text-[#6b628d]">No lock-in periods or penalties. Access your money whenever you need it with instant transfers back to your wallet.</p>
            </div>
        </div>
    </div>

    <!-- Comparison with Traditional Banks -->
    <div class="rounded-[40px] bg-white border border-[#f0edff] p-10">
        <div class="text-center mb-10 space-y-3">
            <p class="text-xs uppercase tracking-[0.4em] text-[#8f7dfd]">Why choose us</p>
            <h2 class="text-4xl font-semibold text-[#140a33]">Better than traditional savings accounts</h2>
            <p class="text-[#6b628d]">See how {{ config('app.name') }} Savings compares to regular bank accounts</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <!-- {{ config('app.name') }} Savings -->
            <div class="rounded-3xl bg-gradient-to-br from-[#05c46b]/10 to-[#04b35f]/5 border-2 border-[#05c46b]/30 p-8">
                <div class="mb-6 inline-flex rounded-full bg-[#05c46b] px-4 py-1 text-xs font-semibold text-white">
                    {{ config('app.name') }} Savings
                </div>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <svg class="h-6 w-6 text-[#05c46b]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-[#140a33]"><strong>1.91% APY</strong> - Competitive rates</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="h-6 w-6 text-[#05c46b]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-[#140a33]"><strong>No fees</strong> - Keep what you earn</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="h-6 w-6 text-[#05c46b]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-[#140a33]"><strong>Instant access</strong> - Withdraw anytime</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="h-6 w-6 text-[#05c46b]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-[#140a33]"><strong>No minimum</strong> - Start with any amount</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="h-6 w-6 text-[#05c46b]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-[#140a33]"><strong>Protected</strong> - Up to €20,000 coverage</span>
                    </div>
                </div>
            </div>

            <!-- Traditional Bank -->
            <div class="rounded-3xl bg-[#f9f7ff] border border-[#f0edff] p-8">
                <div class="mb-6 inline-flex rounded-full bg-[#e4dcff] px-4 py-1 text-xs font-semibold text-[#6b628d]">
                    Traditional Bank
                </div>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <svg class="h-6 w-6 text-[#d1c4f9]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-[#6b628d]"><strong>0.1-0.5% APY</strong> - Low rates</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="h-6 w-6 text-[#d1c4f9]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-[#6b628d]"><strong>Monthly fees</strong> - Hidden charges</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="h-6 w-6 text-[#d1c4f9]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-[#6b628d]"><strong>Limited access</strong> - Withdrawal limits</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="h-6 w-6 text-[#d1c4f9]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-[#6b628d]"><strong>Minimum balance</strong> - Often required</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="h-6 w-6 text-[#d1c4f9]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-[#6b628d]"><strong>Basic protection</strong> - Standard FDIC</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Interest Calculation Example -->
    <div class="rounded-[40px] bg-gradient-to-br from-[#0a0118] to-[#1a0a3d] px-8 py-16 text-white">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-semibold mb-4">See your money grow</h2>
            <p class="text-lg text-white/80">Example of how your savings could grow over time</p>
        </div>

        <div class="grid gap-6 md:grid-cols-3 max-w-4xl mx-auto">
            @foreach ([
                ['period' => '1 Month', 'deposit' => '$10,000', 'earned' => '$15.92', 'total' => '$10,015.92'],
                ['period' => '6 Months', 'deposit' => '$10,000', 'earned' => '$95.50', 'total' => '$10,095.50'],
                ['period' => '1 Year', 'deposit' => '$10,000', 'earned' => '$191.00', 'total' => '$10,191.00']
            ] as $example)
            <div class="rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 p-6">
                <p class="text-sm text-white/70 mb-4">{{ $example['period'] }}</p>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-white/70">Initial deposit</span>
                        <span class="font-semibold">{{ $example['deposit'] }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-white/70">Interest earned</span>
                        <span class="font-semibold text-[#05c46b]">+{{ $example['earned'] }}</span>
                    </div>
                    <div class="border-t border-white/20 pt-2 flex justify-between">
                        <span class="font-semibold">Total</span>
                        <span class="text-xl font-bold text-[#05c46b]">{{ $example['total'] }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <p class="text-center text-sm text-white/60 mt-8">*Based on 1.91% APY. Actual returns may vary based on market conditions.</p>
    </div>

    <!-- Safety & Protection -->
    <div class="grid gap-12 lg:grid-cols-2 items-center">
        <div class="space-y-6">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-[#8f7dfd]">Your money is safe</p>
                <h2 class="mt-3 text-4xl font-semibold text-[#140a33]">Protected by regulation</h2>
            </div>
            <p class="text-lg text-[#6b628d]">
                {{ config('app.name') }} Savings is backed by institutional-grade money market funds managed by BlackRock. Your deposits are protected under EU regulations with coverage up to €20,000 per investor.
            </p>
            <div class="space-y-3">
                <div class="rounded-2xl border border-[#f0edff] bg-[#f9f7ff] p-5">
                    <h4 class="font-semibold text-[#140a33] mb-2">Regulatory Framework</h4>
                    <p class="text-sm text-[#6b628d]">Licensed and supervised by the Estonian Financial Supervision Authority (EFSA), ensuring strict compliance with EU investment regulations.</p>
                </div>
                <div class="rounded-2xl border border-[#f0edff] bg-[#f9f7ff] p-5">
                    <h4 class="font-semibold text-[#140a33] mb-2">Asset Segregation</h4>
                    <p class="text-sm text-[#6b628d]">Your funds are held in segregated accounts, completely separate from {{ config('app.name') }}'s operational capital.</p>
                </div>
                <div class="rounded-2xl border border-[#f0edff] bg-[#f9f7ff] p-5">
                    <h4 class="font-semibold text-[#140a33] mb-2">Investor Protection Fund</h4>
                    <p class="text-sm text-[#6b628d]">All customers are covered by the Estonian Investor Protection Sectoral Fund up to €20,000, regardless of residency.</p>
                </div>
            </div>
        </div>

        <div class="rounded-[40px] bg-gradient-to-br from-[#f4f0ff] to-[#faf8ff] border border-[#ece6ff] p-10">
            <div class="space-y-6 text-center">
                <div class="flex justify-center">
                    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br from-[#05c46b] to-[#04b35f]">
                        <svg class="h-10 w-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-2xl font-semibold text-[#140a33] mb-2">Bank-level security</h3>
                    <p class="text-[#6b628d]">Your savings are protected with the same security standards as traditional banks, plus the transparency of modern fintech.</p>
                </div>
                <div class="grid grid-cols-2 gap-4 pt-6">
                    <div class="rounded-xl bg-white p-4">
                        <p class="text-3xl font-bold text-[#5c28ff]">256-bit</p>
                        <p class="text-xs text-[#6b628d]">Encryption</p>
                    </div>
                    <div class="rounded-xl bg-white p-4">
                        <p class="text-3xl font-bold text-[#5c28ff]">2FA</p>
                        <p class="text-xs text-[#6b628d]">Authentication</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="space-y-10">
        <h2 class="text-center text-4xl font-semibold text-[#140a33]">Common questions about Savings</h2>
        
        <div class="space-y-4">
            @foreach ([
                [
                    'question' => 'How is interest calculated?',
                    'answer' => 'Interest is calculated daily based on your account balance and the current APY rate. The daily interest is added to your balance automatically, allowing you to benefit from compound interest. Your effective rate may be slightly higher than the stated APY due to daily compounding.'
                ],
                [
                    'question' => 'Is my money protected?',
                    'answer' => 'Yes. Your savings are protected in multiple ways: (1) Funds are held in segregated accounts separate from ' . config('app.name') . '\'s operational funds, (2) Covered by the Estonian Investor Protection Sectoral Fund up to €20,000, (3) Managed by BlackRock, a highly regulated institutional fund manager, (4) Subject to strict EU financial regulations and oversight.'
                ],
                [
                    'question' => 'Can I withdraw anytime?',
                    'answer' => 'Absolutely. There are no lock-in periods or withdrawal penalties. You can transfer money from your Savings account back to your ' . config('app.name') . ' wallet instantly, or withdraw to your bank account within 1-2 business days. You maintain full control of your money at all times.'
                ],
                [
                    'question' => 'What\'s the minimum deposit?',
                    'answer' => 'There is no minimum deposit requirement. You can start saving with any amount, even spare change. Whether you want to save $10 or $10,000, you\'ll earn the same competitive APY rate on your entire balance.'
                ],
                [
                    'question' => 'Will the interest rate change?',
                    'answer' => 'Yes, the APY is variable and follows the European Central Bank\'s overnight interest rate. As market conditions change, the rate may go up or down. We update the rate daily and always display the current rate transparently. You\'ll be notified of any significant rate changes.'
                ]
            ] as $faq)
            <details class="group rounded-2xl border border-[#f0edff] bg-white">
                <summary class="flex cursor-pointer items-center justify-between px-6 py-5 text-left font-semibold text-[#140a33] hover:text-[#5c28ff] transition-colors">
                    <span>{{ $faq['question'] }}</span>
                    <svg class="h-5 w-5 text-[#5c28ff] transition-transform group-open:rotate-45" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                </summary>
                <div class="border-t border-[#f0edff] px-6 py-5 text-[#6b628d]">
                    <p>{{ $faq['answer'] }}</p>
                </div>
            </details>
            @endforeach
        </div>
    </div>

    <!-- CTA Section -->
    <div class="rounded-[40px] bg-gradient-to-br from-[#05c46b] to-[#04b35f] px-8 py-16 text-center text-white shadow-xl shadow-[#05c46b]/30">
        <p class="text-sm uppercase tracking-[0.4em] text-white/80">Ready to start saving?</p>
        <h3 class="mt-3 text-4xl font-semibold">Earn more on your cash today</h3>
        <p class="mt-4 text-lg text-white/80">Open a Savings account in minutes and start earning competitive returns with full flexibility.</p>
        <div class="mt-8 flex flex-col items-center justify-center gap-4 md:flex-row">
            <a href="{{ route('register') }}" class="rounded-full bg-white px-10 py-3 text-sm font-semibold text-[#05c46b] hover:bg-white/90 transition-colors">
                Create free account
            </a>
            <a href="{{ route('about') }}" class="rounded-full border border-white/30 px-10 py-3 text-sm font-semibold text-white hover:bg-white/10 transition-colors">
                Learn more
            </a>
        </div>
    </div>
</section>
@endsection