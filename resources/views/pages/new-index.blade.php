@extends('pages.new-layout')

@section('content')
<section class="space-y-20">
    <div class="text-center space-y-6">
        <div class="flex items-center justify-center gap-4 text-xs uppercase tracking-[0.3em] text-[#6b628d]">
            <span class="flex items-center gap-2 text-[#35276e]">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                Regulated by EFSA
            </span>
            <span class="flex items-center gap-2 text-[#1ea672]">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 17l-3.5 1.8.7-4.1L6 11.7l4.2-.6L12 7l1.8 4.1 4.2.6-3.2 2.9.7 4.2z" />
                </svg>
                4.7 on Trustpilot
            </span>
        </div>
        <div class="space-y-4">
            <h1 class="text-4xl font-semibold leading-tight text-[#140a33] md:text-5xl xl:text-6xl">
                Invest smarter. <span class="text-[#35276e]">Go further.</span>
            </h1>
            <p class="text-lg text-[#6b628d] md:text-xl max-w-3xl mx-auto">
                The multi-award winning investment platform that pays up to 1.91% APY interest. Enhanced with {{ config('app.name') }} AI insights.
            </p>
        </div>
        <div class="flex justify-center">
            <a href="{{ route('register') }}" class="rounded-full bg-[#00ff5f] px-8 py-3 text-base font-semibold text-black shadow-xl shadow-[#00ff5f]/40">
                Get started
            </a>
        </div>
    </div>

    <div class="glass-card p-6 md:p-10">
        <div class="flex flex-col gap-10 lg:flex-row">
            <div class="lg:w-2/3 space-y-6">
                <div class="space-y-1">
                    <p class="text-sm uppercase tracking-[0.3em] text-[#6b628d]">General Investment Account</p>
                    <p class="text-4xl font-semibold text-[#5c28ff]">€158,687.32</p>
                    <p class="text-sm text-[#1ea672]">+8.63% (€14,235.30) · All time</p>
                </div>
                <div class="h-56 rounded-2xl bg-gradient-to-r from-[#ede8ff] to-white flex items-center justify-center text-[#6b628d]">
                    <div class="text-center">
                        <p class="text-sm uppercase tracking-[0.3em]">Chart placeholder</p>
                        <p class="text-xs text-[#a69fd4]">Upload product visuals later</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <p class="text-sm font-semibold text-[#35276e]">Investments snapshot</p>
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="rounded-2xl border border-[#f0edff] p-4">
                            <p class="text-sm text-[#6b628d]">Stocks</p>
                            <p class="text-lg font-semibold text-[#140a33]">€119,519.40</p>
                            <p class="text-xs text-[#1ea672]">+13.8% annualised</p>
                        </div>
                        <div class="rounded-2xl border border-[#f0edff] p-4">
                            <p class="text-sm text-[#6b628d]">Savings</p>
                            <p class="text-lg font-semibold text-[#140a33]">€24,138.11</p>
                            <p class="text-xs text-[#1ea672]">Earn up to 1.91% APY</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/3 space-y-5">
                <div class="rounded-2xl border border-[#f0edff] p-5">
                    <p class="text-sm text-[#6b628d]">Cash</p>
                    <p class="text-3xl font-semibold text-[#140a33]">€15,029.81</p>
                    <ul class="mt-4 space-y-2 text-sm text-[#6b628d]">
                        <li class="flex justify-between"><span>GBP</span><span>€12,027.86</span></li>
                        <li class="flex justify-between"><span>USD</span><span>€2,762.06</span></li>
                        <li class="flex justify-between"><span>EUR</span><span>€406.94</span></li>
                    </ul>
                    <button class="mt-4 w-full rounded-full bg-[#f4f1ff] py-2 text-sm font-semibold text-[#05c46b]">
                        Deposit
                    </button>
                </div>
                <div class="rounded-2xl border border-[#f0edff] p-5">
                    <p class="text-sm text-[#6b628d]">Investment calendar</p>
                    <div class="mt-4 space-y-3 text-sm text-[#35276e]">
                        <div>
                            <p class="font-medium">Vanguard USD Treasury Bond</p>
                            <p class="text-xs text-[#6b628d]">Dividend · Payment</p>
                        </div>
                        <div>
                            <p class="font-medium">Taiwan Semiconductor</p>
                            <p class="text-xs text-[#6b628d]">Dividend · Ex-dividend</p>
                        </div>
                        <div>
                            <p class="font-medium">Main Street Capital</p>
                            <p class="text-xs text-[#6b628d]">Dividend · Payment</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-2xl border border-dashed border-[#e4dcff] p-5 text-center text-sm text-[#6b628d]">
                    Future product render placeholder
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-8">
        <div class="text-center">
            <p class="text-xs uppercase tracking-[0.3em] text-[#6b628d]">Our trusted partners</p>
        </div>
        <div class="flex flex-wrap items-center justify-center gap-8 text-[#c9c3e8]">
            <span class="text-xl font-semibold tracking-wider">ABN·AMRO</span>
            <span class="text-xl font-semibold tracking-wider">NatWest</span>
            <span class="text-xl font-semibold tracking-wider">LHV</span>
            <span class="text-xl font-semibold tracking-wider">Drive</span>
            <span class="text-xl font-semibold tracking-wider">Bolt</span>
            <span class="text-xl font-semibold tracking-wider">Wise</span>
            <span class="text-xl font-semibold tracking-wider">Robinhood</span>
        </div>
    </div>

    <div class="rounded-[40px] bg-white p-10 text-center shadow-lg shadow-[#a48dff]/20">
        <p class="text-xs font-semibold uppercase tracking-[0.4em] text-[#05c46b]">Lightyear Savings</p>
        <h2 class="mt-3 text-3xl font-semibold text-[#140a33]">Earn high interest</h2>
        <p class="mt-2 text-lg text-[#6b628d]">Put your money to work in our easy access, high yield savings.</p>
        <div class="mt-8 text-6xl font-semibold text-[#05c46b]">1.91% <span class="text-2xl align-top text-[#6b628d]">APY</span></div>
        <div class="mt-8 flex flex-col gap-6 text-sm text-[#6b628d] md:flex-row md:justify-center">
            <div>
                <p class="font-semibold text-[#35276e]">Follows the</p>
                <p>EIOPA methodology for protection</p>
            </div>
            <div>
                <p class="font-semibold text-[#35276e]">Managed by</p>
                <p>Institutional-grade custodians</p>
            </div>
            <div>
                <p class="font-semibold text-[#35276e]">No minimums</p>
                <p>Start investing with spare change</p>
            </div>
        </div>
    </div>

    <div class="rounded-[40px] bg-[#f7f4ff] p-10">
        <div class="grid gap-10 lg:grid-cols-3">
            <div class="space-y-4">
                <div class="rounded-full bg-white px-4 py-1 text-xs font-semibold text-[#05c46b] w-max">What we offer</div>
                <h3 class="text-3xl font-semibold text-[#140a33]">Everything in one investing app.</h3>
                <p class="text-[#6b628d]">Trade thousands of U.S. and European stocks, earn on idle cash, and automate your strategy with {{ config('app.name') }} AI insights.</p>
            </div>
            <div class="space-y-4">
                <h4 class="text-lg font-semibold text-[#35276e]">Zero hidden fees</h4>
                <p class="text-sm text-[#6b628d]">Invest globally without FX markups, custody fees, or premium tiers. You always get the same transparent pricing.</p>
                <div class="rounded-2xl border border-dashed border-[#ded9ff] p-4 text-center text-xs text-[#8a7fc1]">Fee comparison chart placeholder</div>
            </div>
            <div class="space-y-4">
                <h4 class="text-lg font-semibold text-[#35276e]">Earn while you wait</h4>
                <p class="text-sm text-[#6b628d]">Idle cash automatically flows into money market funds so your dry powder works as hard as your portfolio.</p>
                <div class="rounded-2xl border border-dashed border-[#ded9ff] p-4 text-center text-xs text-[#8a7fc1]">Automation flow placeholder</div>
            </div>
        </div>
    </div>

    <div class="space-y-10">
        <div class="flex flex-col gap-4 text-center">
                <p class="text-xs uppercase tracking-[0.4em] text-[#05c46b]">How it works</p>
            <h3 class="text-3xl font-semibold text-[#140a33]">Built for serious compounding.</h3>
            <p class="mx-auto max-w-3xl text-[#6b628d]">Track performance across multiple currencies, schedule deposits, and rely on our regulated infrastructure.</p>
        </div>
        <div class="grid gap-6 md:grid-cols-3">
            <div class="rounded-3xl border border-[#f0edff] p-6">
                <div class="text-sm font-semibold uppercase tracking-[0.4em] text-[#6b628d]">01</div>
                <h4 class="mt-4 text-xl font-semibold text-[#35276e]">Onboard in minutes</h4>
                <p class="mt-2 text-sm text-[#6b628d]">Verify your identity digitally and fund your account in EUR, GBP, or USD without leaving the app.</p>
            </div>
            <div class="rounded-3xl border border-[#f0edff] p-6">
                <div class="text-sm font-semibold uppercase tracking-[0.4em] text-[#6b628d]">02</div>
                <h4 class="mt-4 text-xl font-semibold text-[#35276e]">Invest with insights</h4>
                <p class="mt-2 text-sm text-[#6b628d]">Screen 5,000+ securities, follow curated lists, and leverage {{ config('app.name') }} AI signals to act confidently.</p>
            </div>
            <div class="rounded-3xl border border-[#f0edff] p-6">
                <div class="text-sm font-semibold uppercase tracking-[0.4em] text-[#6b628d]">03</div>
                <h4 class="mt-4 text-xl font-semibold text-[#35276e]">Grow automatically</h4>
                <p class="mt-2 text-sm text-[#6b628d]">Schedule deposits, auto-invest into slices, and keep idle balances in high-yield vehicles for steady growth.</p>
            </div>
        </div>
    </div>

        <div class="rounded-[32px] bg-[#050505] px-8 py-12 text-center text-white">
            <p class="text-sm uppercase tracking-[0.4em] text-[#08f58d]">Ready to move your money?</p>
            <h3 class="mt-3 text-3xl font-semibold">Join investors who already trust {{ config('app.name') }}.</h3>
            <p class="mt-4 text-white/70">Open an account in minutes and put your capital to work with regulated protection and modern tooling.</p>
            <div class="mt-8 flex flex-col items-center justify-center gap-3 md:flex-row">
                <a href="{{ route('register') }}" class="rounded-full bg-[#05c46b] px-8 py-3 text-sm font-semibold text-[#030303]">Create free account</a>
                <a href="{{ route('products') }}" class="rounded-full border border-white/30 px-8 py-3 text-sm font-semibold text-white/90">Explore product</a>
            </div>
        </div>
</section>
@endsection
