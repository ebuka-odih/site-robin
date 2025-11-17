@extends('pages.new-layout')

@section('content')
<section class="space-y-24">
    <!-- Hero Section -->
    <div class="text-center space-y-8">
        <div class="space-y-4">
            <p class="text-xs uppercase tracking-[0.4em] text-[#8f7dfd]">Money Market Funds</p>
            <h1 class="text-5xl font-semibold leading-tight text-[#140a33] md:text-6xl lg:text-7xl">
                Your cash,<br>working smarter
            </h1>
            <p class="mx-auto max-w-3xl text-xl text-[#6b628d]">
                Earn competitive returns on idle cash with institutional-grade money market funds. Low risk, daily liquidity, and regulatory protection.
            </p>
        </div>
        <div>
            <a href="{{ route('register') }}" class="inline-block rounded-full bg-[#5c28ff] px-10 py-4 text-lg font-semibold text-white shadow-xl shadow-[#5c28ff]/30 hover:bg-[#4e1fff] transition-colors">
                Get started
            </a>
        </div>
    </div>

    <!-- Current Yield Display -->
    <div class="rounded-[40px] bg-gradient-to-br from-[#f4f0ff] to-[#faf8ff] border border-[#ece6ff] px-8 py-16 text-center">
        <p class="text-sm uppercase tracking-[0.4em] text-[#5c28ff]">Current Yield</p>
        <div class="mt-6 text-8xl font-bold text-[#5c28ff]">
            3.2<span class="text-4xl align-top">%</span>
        </div>
        <p class="mt-4 text-lg text-[#6b628d]">Annual Percentage Yield</p>
        <p class="mt-2 text-sm text-[#8a7fc1]">Rate updated daily based on market conditions</p>
    </div>

    <!-- What Are MMFs Section -->
    <div class="grid gap-12 lg:grid-cols-2 items-center">
        <div class="space-y-6">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-[#8f7dfd]">Low-risk investing</p>
                <h2 class="mt-3 text-4xl font-semibold text-[#140a33]">What are money market funds?</h2>
            </div>
            <p class="text-lg text-[#6b628d]">
                Money market funds are low-risk investment vehicles that invest in short-term, high-quality debt securities. They're designed to offer better returns than traditional savings accounts while maintaining high liquidity and capital preservation.
            </p>
            <div class="space-y-4">
                <div class="flex items-start gap-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#f4f0ff]">
                        <svg class="h-5 w-5 text-[#5c28ff]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-[#140a33]">Daily liquidity</h4>
                        <p class="text-sm text-[#6b628d]">Access your money whenever you need it with same-day redemptions</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#f4f0ff]">
                        <svg class="h-5 w-5 text-[#5c28ff]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-[#140a33]">Institutional management</h4>
                        <p class="text-sm text-[#6b628d]">Managed by world-class fund managers like BlackRock and Vanguard</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#f4f0ff]">
                        <svg class="h-5 w-5 text-[#5c28ff]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-[#140a33]">Regulatory protection</h4>
                        <p class="text-sm text-[#6b628d]">Your investments are protected under strict EU regulations</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visual Placeholder -->
        <div class="rounded-[40px] bg-gradient-to-br from-[#f9f7ff] to-[#f0edff] p-12 border border-[#ece6ff]">
            <div class="space-y-6">
                <div class="rounded-2xl bg-white p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-semibold text-[#6b628d]">Money Market Fund</span>
                        <span class="rounded-full bg-[#05c46b]/10 px-3 py-1 text-xs font-semibold text-[#05c46b]">Active</span>
                    </div>
                    <div class="text-3xl font-bold text-[#140a33]">$25,430.82</div>
                    <div class="mt-2 flex items-center gap-2 text-sm">
                        <span class="text-[#05c46b]">↗ +$142.30</span>
                        <span class="text-[#6b628d]">(+0.56%) this month</span>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div class="rounded-xl bg-white p-4">
                        <p class="text-xs text-[#6b628d]">7-day yield</p>
                        <p class="text-xl font-bold text-[#5c28ff]">3.2%</p>
                    </div>
                    <div class="rounded-xl bg-white p-4">
                        <p class="text-xs text-[#6b628d]">NAV</p>
                        <p class="text-xl font-bold text-[#140a33]">$1.00</p>
                    </div>
                    <div class="rounded-xl bg-white p-4">
                        <p class="text-xs text-[#6b628d]">Duration</p>
                        <p class="text-xl font-bold text-[#140a33]">45d</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works -->
    <div class="space-y-10">
        <div class="text-center space-y-3">
            <p class="text-xs uppercase tracking-[0.4em] text-[#8f7dfd]">Simple & Automated</p>
            <h2 class="text-4xl font-semibold text-[#140a33] md:text-5xl">How it works</h2>
        </div>

        <div class="grid gap-6 md:grid-cols-3">
            <div class="rounded-3xl border border-[#f0edff] bg-white p-8">
                <div class="mb-4 text-sm font-semibold uppercase tracking-[0.4em] text-[#6b628d]">01</div>
                <h3 class="mb-3 text-xl font-semibold text-[#35276e]">Automatic sweep</h3>
                <p class="text-[#6b628d]">Your idle cash is automatically invested into money market funds, so you're always earning competitive returns without lifting a finger.</p>
            </div>
            <div class="rounded-3xl border border-[#f0edff] bg-white p-8">
                <div class="mb-4 text-sm font-semibold uppercase tracking-[0.4em] text-[#6b628d]">02</div>
                <h3 class="mb-3 text-xl font-semibold text-[#35276e]">Daily interest</h3>
                <p class="text-[#6b628d]">Interest is calculated daily and compounds automatically. Watch your balance grow steadily with institutional-grade fund management.</p>
            </div>
            <div class="rounded-3xl border border-[#f0edff] bg-white p-8">
                <div class="mb-4 text-sm font-semibold uppercase tracking-[0.4em] text-[#6b628d]">03</div>
                <h3 class="mb-3 text-xl font-semibold text-[#35276e]">Easy redemption</h3>
                <p class="text-[#6b628d]">Need your cash? Redeem anytime with same-day settlement. Your money is always available when you need it for trading or withdrawal.</p>
            </div>
        </div>
    </div>

    <!-- Comparison Section -->
    <div class="rounded-[40px] bg-white border border-[#f0edff] p-10">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-semibold text-[#140a33]">Better than traditional savings</h2>
            <p class="mt-2 text-[#6b628d]">See how money market funds stack up against regular bank accounts</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-[#f0edff]">
                        <th class="pb-4 text-left text-sm font-semibold text-[#6b628d]">Feature</th>
                        <th class="pb-4 text-center text-sm font-semibold text-[#5c28ff]">Money Market Funds</th>
                        <th class="pb-4 text-center text-sm font-semibold text-[#6b628d]">Traditional Savings</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f0edff]">
                    <tr>
                        <td class="py-4 text-sm text-[#140a33]">Interest Rate</td>
                        <td class="py-4 text-center text-sm font-semibold text-[#05c46b]">3.2% APY</td>
                        <td class="py-4 text-center text-sm text-[#6b628d]">0.5% APY</td>
                    </tr>
                    <tr>
                        <td class="py-4 text-sm text-[#140a33]">Liquidity</td>
                        <td class="py-4 text-center text-sm font-semibold text-[#05c46b]">Same-day</td>
                        <td class="py-4 text-center text-sm text-[#6b628d]">1-3 days</td>
                    </tr>
                    <tr>
                        <td class="py-4 text-sm text-[#140a33]">Minimum Balance</td>
                        <td class="py-4 text-center text-sm font-semibold text-[#05c46b]">None</td>
                        <td class="py-4 text-center text-sm text-[#6b628d]">Often required</td>
                    </tr>
                    <tr>
                        <td class="py-4 text-sm text-[#140a33]">Fees</td>
                        <td class="py-4 text-center text-sm font-semibold text-[#05c46b]">No fees</td>
                        <td class="py-4 text-center text-sm text-[#6b628d]">Monthly fees</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Safety & Protection -->
    <div class="grid gap-12 lg:grid-cols-2 items-center">
        <div class="order-2 lg:order-1">
            <div class="rounded-[40px] bg-gradient-to-br from-[#0a0118] to-[#1a0a3d] p-10 text-white">
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white/10">
                            <svg class="h-6 w-6 text-[#05c46b]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold">Regulatory Protection</h4>
                            <p class="text-sm text-white/70">Licensed and regulated by EFSA</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white/10">
                            <svg class="h-6 w-6 text-[#05c46b]" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold">Asset Safeguarding</h4>
                            <p class="text-sm text-white/70">Your funds are held separately from company assets</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white/10">
                            <svg class="h-6 w-6 text-[#05c46b]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold">Investor Protection</h4>
                            <p class="text-sm text-white/70">Coverage up to €20,000 per investor</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="order-1 lg:order-2 space-y-6">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-[#8f7dfd]">Your money is safe</p>
                <h2 class="mt-3 text-4xl font-semibold text-[#140a33]">Protected by regulation</h2>
            </div>
            <p class="text-lg text-[#6b628d]">
                {{ config('app.name') }} is a licensed investment firm regulated by the Estonian Financial Supervision Authority (EFSA). Your investments in money market funds are protected through strict safeguarding requirements and investor protection schemes.
            </p>
            <div class="space-y-3">
                <div class="rounded-2xl border border-[#f0edff] bg-[#f9f7ff] p-4">
                    <p class="text-sm font-semibold text-[#140a33]">Segregated accounts</p>
                    <p class="text-sm text-[#6b628d]">Your assets are held in segregated accounts, separate from {{ config('app.name') }}'s operational funds.</p>
                </div>
                <div class="rounded-2xl border border-[#f0edff] bg-[#f9f7ff] p-4">
                    <p class="text-sm font-semibold text-[#140a33]">Daily oversight</p>
                    <p class="text-sm text-[#6b628d]">Fund managers monitor holdings daily to maintain stability and liquidity requirements.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="space-y-10">
        <h2 class="text-center text-4xl font-semibold text-[#140a33]">Frequently asked questions</h2>
        
        <div class="space-y-4">
            @foreach ([
                [
                    'question' => 'What are money market funds?',
                    'answer' => 'Money market funds are mutual funds that invest in short-term, high-quality debt securities such as government bonds, treasury bills, and commercial paper. They aim to provide investors with a safe place to invest easily accessible cash while earning a modest return.'
                ],
                [
                    'question' => 'How safe are money market funds?',
                    'answer' => 'Money market funds are considered one of the safest investment options. They invest in high-quality, short-term securities and are subject to strict regulatory requirements. While not risk-free, they maintain a stable net asset value (NAV) of $1 per share and have historically been very stable.'
                ],
                [
                    'question' => 'How quickly can I access my money?',
                    'answer' => 'Money market funds offer excellent liquidity. You can typically redeem your shares on the same business day, with funds available in your account within 1-2 business days. This makes them ideal for parking cash you might need on short notice.'
                ],
                [
                    'question' => 'What are the fees?',
                    'answer' => 'We don\'t charge any additional fees for money market fund investments. The fund itself has a small expense ratio (typically 0.1-0.3% annually) which is already reflected in the yield you see. There are no transaction fees, account fees, or hidden charges.'
                ],
                [
                    'question' => 'How is the yield calculated?',
                    'answer' => 'The yield is calculated based on the fund\'s 7-day average return, annualized to show what you would earn over a year if the rate stayed constant. Yields fluctuate based on market interest rates and are updated daily.'
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
    <div class="rounded-[40px] bg-gradient-to-br from-[#5c28ff] to-[#4617c3] px-8 py-16 text-center text-white shadow-xl shadow-[#5c28ff]/30">
        <p class="text-sm uppercase tracking-[0.4em] text-white/80">Start earning today</p>
        <h3 class="mt-3 text-4xl font-semibold">Put your idle cash to work</h3>
        <p class="mt-4 text-lg text-white/80">Join investors who are already earning competitive returns on their uninvested cash.</p>
        <div class="mt-8">
            <a href="{{ route('register') }}" class="inline-block rounded-full bg-white px-10 py-3 text-sm font-semibold text-[#5c28ff] hover:bg-white/90 transition-colors">
                Create free account
            </a>
        </div>
    </div>
</section>
@endsection