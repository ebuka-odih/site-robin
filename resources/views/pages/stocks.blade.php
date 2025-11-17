@extends('pages.new-layout')

@section('content')
<section class="space-y-24">
    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-[48px] bg-gradient-to-b from-[#0a0118] to-[#1a0a3d] px-8 py-20 text-center text-white">
        <!-- Particle Effect Background -->
        <div class="pointer-events-none absolute inset-0 opacity-40">
            <div class="absolute inset-0" style="background-image: radial-gradient(2px 2px at 20% 30%, white, transparent), radial-gradient(2px 2px at 60% 70%, white, transparent), radial-gradient(1px 1px at 50% 50%, white, transparent), radial-gradient(1px 1px at 80% 10%, white, transparent), radial-gradient(2px 2px at 90% 60%, white, transparent), radial-gradient(1px 1px at 33% 50%, white, transparent), radial-gradient(1px 1px at 70% 40%, white, transparent); background-size: 200% 200%; background-position: 0% 0%; animation: drift 20s ease-in-out infinite;"></div>
        </div>
        
        <div class="relative z-10 space-y-8">
            <h1 class="text-5xl font-semibold leading-tight md:text-6xl lg:text-7xl">
                A stock universe<br>as vast as the cosmos
            </h1>
            <p class="text-xl text-white/80">Over 5,000 stocks to explore</p>
            <div>
                <a href="{{ route('register') }}" class="inline-block rounded-full bg-[#7c5dfa] px-10 py-4 text-lg font-semibold text-white shadow-xl shadow-[#7c5dfa]/40 hover:bg-[#6b4de8] transition-all">
                    Get started
                </a>
            </div>
            <p class="text-sm text-white/60">T&Cs apply. When you invest, your capital is at risk.</p>
        </div>
    </div>

    <!-- Pricing Section -->
    <div class="space-y-10 text-center">
        <div class="space-y-3">
            <p class="text-xs uppercase tracking-[0.4em] text-[#8f7dfd]">Simple, Fair & Transparent</p>
            <h2 class="text-4xl font-semibold text-[#140a33] md:text-5xl">Pricing that's out of this world</h2>
        </div>

        <!-- Pricing Tabs -->
        <div class="flex justify-center gap-3">
            <button class="rounded-full bg-[#7c5dfa] px-6 py-2 text-sm font-semibold text-white">Execution fees</button>
            <button class="rounded-full bg-[#f4f0ff] px-6 py-2 text-sm font-semibold text-[#4a21ef]">Custody & account</button>
            <button class="rounded-full bg-[#f4f0ff] px-6 py-2 text-sm font-semibold text-[#4a21ef]">FX fees</button>
        </div>

        <!-- Pricing Cards -->
        <div class="grid gap-6 md:grid-cols-3">
            <!-- US Shares -->
            <div class="rounded-3xl border border-[#f0edff] bg-white p-8 text-left">
                <div class="mb-6 flex h-12 w-12 items-center justify-center rounded-full bg-[#f4f0ff]">
                    <svg class="h-6 w-6 text-[#5c28ff]" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z"/>
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-semibold text-[#140a33]">US shares</h3>
                <div class="mb-4">
                    <p class="text-4xl font-bold text-[#140a33]">0.1%<span class="text-xl text-[#6b628d]">, max $1</span></p>
                    <p class="text-sm text-[#6b628d]">per order, minimum $0.10</p>
                </div>
                <a href="#" class="inline-flex items-center gap-2 text-sm font-semibold text-[#5c28ff] hover:text-[#4e1fff]">
                    View US stocks
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <!-- UK Shares -->
            <div class="rounded-3xl border border-[#f0edff] bg-white p-8 text-left">
                <div class="mb-6 flex h-12 w-12 items-center justify-center rounded-full bg-[#f4f0ff]">
                    <svg class="h-6 w-6 text-[#5c28ff]" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-semibold text-[#140a33]">UK shares</h3>
                <div class="mb-4">
                    <p class="text-4xl font-bold text-[#140a33]">£1</p>
                    <p class="text-sm text-[#6b628d]">per order</p>
                </div>
                <a href="#" class="inline-flex items-center gap-2 text-sm font-semibold text-[#5c28ff] hover:text-[#4e1fff]">
                    View UK stocks
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <!-- EU Shares -->
            <div class="rounded-3xl border border-[#f0edff] bg-white p-8 text-left">
                <div class="mb-6 flex h-12 w-12 items-center justify-center rounded-full bg-[#f4f0ff]">
                    <svg class="h-6 w-6 text-[#5c28ff]" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-semibold text-[#140a33]">EU shares</h3>
                <div class="mb-4">
                    <p class="text-4xl font-bold text-[#140a33]">1€</p>
                    <p class="text-sm text-[#6b628d]">per order</p>
                </div>
                <a href="#" class="inline-flex items-center gap-2 text-sm font-semibold text-[#5c28ff] hover:text-[#4e1fff]">
                    View EU stocks
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Stock Universe Section -->
    <div class="space-y-10">
        <div class="text-center space-y-3">
            <p class="text-xs uppercase tracking-[0.4em] text-[#8f7dfd]">Truly International</p>
            <h2 class="text-4xl font-semibold text-[#140a33] md:text-5xl">The biggest stocks from planet Earth</h2>
            <p class="text-lg text-[#6b628d]">5,000+ stocks to choose from</p>
        </div>

        <!-- Country Filter Pills -->
        <div class="flex flex-wrap justify-center gap-3">
            @foreach (['US', 'UK', 'Belgium', 'Canada', 'China', 'France', 'Germany', 'Netherlands', 'Spain'] as $country)
                <button class="rounded-full {{ $country === 'US' ? 'bg-[#7c5dfa] text-white' : 'bg-[#2a1f4d] text-white/70' }} px-5 py-2 text-sm font-semibold hover:bg-[#7c5dfa] hover:text-white transition-colors">
                    {{ $country }}
                </button>
            @endforeach
        </div>

        <!-- Stock Showcase -->
        <div class="grid gap-8 lg:grid-cols-2 items-center">
            <!-- Stock List Card -->
            <div class="rounded-[40px] bg-gradient-to-br from-[#5330ff] via-[#4617c3] to-[#27105c] p-8 shadow-[0_30px_80px_rgba(52,25,104,0.5)]">
                <div class="space-y-3">
                    @foreach ([
                        ['name' => 'NVIDIA', 'symbol' => '$NVDA', 'sector' => 'Semiconductors'],
                        ['name' => 'Apple', 'symbol' => '$AAPL', 'sector' => 'Digital Hardware'],
                        ['name' => 'Microsoft', 'symbol' => '$MSFT', 'sector' => 'Software & Cloud Services'],
                        ['name' => 'Alphabet Class A', 'symbol' => '$GOOGL', 'sector' => 'Software & Cloud Services'],
                        ['name' => 'Alphabet Class C', 'symbol' => '$GOOG', 'sector' => 'Software & Cloud Services'],
                        ['name' => 'Amazon', 'symbol' => '$AMZN', 'sector' => 'Consumer Essentials']
                    ] as $stock)
                    <div class="rounded-2xl bg-white/95 px-5 py-4 flex items-center justify-between shadow-lg">
                        <div>
                            <p class="font-semibold text-[#140a33]">{{ $stock['name'] }}</p>
                            <p class="text-xs text-[#6b628d]">{{ $stock['symbol'] }} · {{ $stock['sector'] }}</p>
                        </div>
                        <svg class="h-5 w-5 text-[#5c28ff]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-6 text-[#140a33]">
                <div>
                    <p class="text-xs uppercase tracking-[0.4em] text-[#8f7dfd]">The world's largest stocks</p>
                    <h3 class="mt-3 text-3xl font-semibold md:text-4xl">3,000+ US stocks across the NYSE and Nasdaq.</h3>
                    <p class="mt-4 text-lg text-[#6b628d]">Access blue chips, growth stories, and niche sectors without hopping between platforms. Trade fractional shares starting from just $1.</p>
                </div>
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-full bg-[#f4f0ff] px-8 py-3 text-sm font-semibold text-[#4a21ef] hover:bg-[#e6dcff] transition-colors">
                    Explore US stocks
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- The Universe is Yours Section -->
    <div class="rounded-[40px] bg-gradient-to-br from-[#0a0118] to-[#1a0a3d] px-8 py-16 text-center text-white">
        <h2 class="text-4xl font-semibold mb-4">The universe is yours</h2>
        <p class="text-lg text-white/80 mb-12">Explore our full universe of stocks, navigating by exchange, country, or sector.</p>
        
        <!-- Country Highlights -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 text-left">
            @foreach ([
                ['country' => 'Canada', 'description' => 'Canadian companies are leaders in natural resources, including mining and energy, while also making strides in technology.'],
                ['country' => 'China', 'description' => 'China\'s rapid economic growth is driven by its dominance in e-commerce, electric vehicles, and advanced manufacturing.'],
                ['country' => 'Europe', 'description' => 'Invest in European diversity. From Germany\'s engineering powerhouses to France\'s luxury brands.'],
                ['country' => 'France', 'description' => 'France is synonymous with luxury and sophistication, leading the world in fashion, cosmetics, and gourmet foods.'],
                ['country' => 'Germany', 'description' => 'Germany\'s industrial might is anchored by its world-renowned automotive sector and manufacturing excellence.'],
                ['country' => 'Netherlands', 'description' => 'The Netherlands is a global trade hub, with companies excelling in logistics, financial services, and high-tech innovation.']
            ] as $region)
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-sm hover:bg-white/10 transition-colors">
                <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-full bg-[#7c5dfa]/20">
                    <div class="h-6 w-6 rounded-full bg-gradient-to-br from-[#ff6b6b] via-[#ffd93d] to-[#6bcf7f]"></div>
                </div>
                <h4 class="mb-2 text-lg font-semibold">{{ $region['country'] }}</h4>
                <p class="text-sm text-white/70">{{ $region['description'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="mt-12">
            <a href="{{ route('register') }}" class="inline-block rounded-full border border-white/30 px-8 py-3 text-sm font-semibold text-white hover:bg-white/10 transition-colors">
                Browse all stocks →
            </a>
        </div>
    </div>

    <!-- Powerful Tools Section -->
    <div class="space-y-10">
        <div class="text-center space-y-3">
            <p class="text-xs uppercase tracking-[0.4em] text-[#8f7dfd]">Tools to suit every investor</p>
            <h2 class="text-4xl font-semibold text-[#140a33] md:text-5xl">Powerful investing tools</h2>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <!-- Analyst Projections -->
            <div class="rounded-3xl border border-[#f0edff] bg-white p-8">
                <div class="mb-6 inline-flex rounded-full bg-[#f4f0ff] px-4 py-1 text-xs font-semibold text-[#5c28ff]">
                    Analyst projections
                </div>
                <h3 class="mb-3 text-2xl font-semibold text-[#140a33]">Set your buy or sell targets</h3>
                <p class="text-[#6b628d]">See where Wall Street analysts think a stock is headed. Compare high, low, and average price targets to inform your strategy.</p>
                <div class="mt-6 rounded-2xl border border-dashed border-[#ded9ff] bg-[#f9f7ff] p-8 text-center">
                    <div class="text-sm text-[#8a7fc1]">
                        <div class="mb-2">High: $181.48</div>
                        <div class="mb-2 text-lg font-semibold text-[#5c28ff]">Average: $136.23</div>
                        <div>Low: $85.00</div>
                    </div>
                </div>
            </div>

            <!-- Dividend Calendar -->
            <div class="rounded-3xl border border-[#f0edff] bg-white p-8">
                <div class="mb-6 inline-flex rounded-full bg-[#f4f0ff] px-4 py-1 text-xs font-semibold text-[#5c28ff]">
                    Dividend calendar
                </div>
                <h3 class="mb-3 text-2xl font-semibold text-[#140a33]">Predictable shareholder earnings</h3>
                <p class="text-[#6b628d]">Track upcoming dividend payments and ex-dividend dates. Plan your portfolio around income-generating stocks.</p>
                <div class="mt-6 space-y-3">
                    @foreach ([
                        ['date' => 'NOV 17', 'company' => 'Company 1', 'type' => 'Dividend', 'status' => 'Payment', 'amount' => '$2.54'],
                        ['date' => 'NOV 18', 'company' => 'Company 2', 'type' => 'Dividend', 'status' => 'Ex-dividend', 'amount' => ''],
                        ['date' => 'NOV 21', 'company' => 'Company 3', 'type' => 'Dividend', 'status' => 'Payment', 'amount' => '$0.82']
                    ] as $dividend)
                    <div class="flex items-center justify-between rounded-xl bg-[#f9f7ff] px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="text-center">
                                <p class="text-xs font-semibold text-[#5c28ff]">{{ explode(' ', $dividend['date'])[0] }}</p>
                                <p class="text-lg font-bold text-[#140a33]">{{ explode(' ', $dividend['date'])[1] }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-[#140a33]">{{ $dividend['company'] }}</p>
                                <p class="text-xs text-[#6b628d]">{{ $dividend['type'] }} · {{ $dividend['status'] }}</p>
                            </div>
                        </div>
                        @if($dividend['amount'])
                        <p class="text-sm font-semibold text-[#05c46b]">{{ $dividend['amount'] }} <span class="text-xs text-[#6b628d]">per share</span></p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="space-y-10">
        <h2 class="text-center text-4xl font-semibold text-[#140a33]">Questions a curious investor might ask</h2>
        
        <div class="space-y-4">
            @foreach ([
                [
                    'question' => 'How does investing with different currencies work?',
                    'answer' => 'Building a global portfolio is important, and we want to make it as easy as possible to do that. Lightyear\'s multi-currency investment accounts mean you can invest and hold money in USD, GBP and EUR. So whether you\'re investing in local stocks or US giants, we\'ve got you covered. This way, you don\'t have to be constantly converting your money between currencies - which is subject to FX fees.'
                ],
                [
                    'question' => 'Can I move stocks over from another provider?',
                    'answer' => 'If your current broker supports transfers out, we can help you do it. There\'s a longer answer on our help centre with the links and a step-by-step process. But in short, we can help you transfer whole shares (above a value of $/£/€ 1000) over to Lightyear.'
                ],
                [
                    'question' => 'How are my assets protected?',
                    'answer' => 'Trusting us with your investments is not something we take for granted. Lightyear Europe AS is a licensed investment firm and as such is bound by strict regulatory obligations in how we handle and protect your assets. We do this via a process known as safeguarding. You can find full details about how we safeguard in our help centre. All Lightyear customers have their assets covered up to the amount of 20,000 EUR by the Estonian Investor Protection Sectoral Fund. Read more about this fund here. This protection covers all accounts regardless of the owner\'s residency country.'
                ],
                [
                    'question' => 'Can I request new stocks?',
                    'answer' => 'Yes! We\'re always looking to expand our universe. If there\'s a stock you\'d like to see on Lightyear, let us know through our support channels and we\'ll do our best to add it to our platform.'
                ]
            ] as $index => $faq)
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
        <p class="text-sm uppercase tracking-[0.4em] text-white/80">Ready to start investing?</p>
        <h3 class="mt-3 text-4xl font-semibold">Join thousands of investors worldwide.</h3>
        <p class="mt-4 text-lg text-white/80">Open an account in minutes and start building your portfolio with regulated protection.</p>
        <div class="mt-8 flex flex-col items-center justify-center gap-4 md:flex-row">
            <a href="{{ route('register') }}" class="rounded-full bg-white px-10 py-3 text-sm font-semibold text-[#5c28ff] hover:bg-white/90 transition-colors">
                Create free account
            </a>
            <a href="{{ route('about') }}" class="rounded-full border border-white/30 px-10 py-3 text-sm font-semibold text-white hover:bg-white/10 transition-colors">
                Learn more
            </a>
        </div>
    </div>
</section>

<style>
@keyframes drift {
    0%, 100% { background-position: 0% 0%; }
    50% { background-position: 100% 100%; }
}
</style>
@endsection