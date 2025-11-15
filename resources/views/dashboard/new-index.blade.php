@extends('dashboard.new-layout')

@section('content')
@php
    $accountTabs = $accountTabs ?? [];
    $timeRanges = ['1D', '1W', '1M', '3M', '1Y', 'All'];
    $watchlist = ($stockAssets ?? collect())->take(15);
    $accountTabsCollection = collect($accountTabs);
    $investingTab = $accountTabsCollection->firstWhere('id', 'investing') ?? $accountTabsCollection->first();
    $pnlTab = $accountTabsCollection->firstWhere('id', 'pnl');
    $walletTab = $accountTabsCollection->firstWhere('id', 'wallet');
@endphp

    <div class="space-y-8 text-white">
        <div>
            <p class="text-sm font-semibold text-[#08f58d]">Smart Trader</p>
            <h1 class="text-2xl font-semibold tracking-tight">Welcome back, {{ auth()->user()->name }}!</h1>
        </div>

        <div id="accountTabs" class="flex gap-3 overflow-x-auto pb-2">
            @foreach ($accountTabs as $index => $tab)
                <button
                    data-account="{{ $tab['id'] }}"
                    class="min-w-[200px] shrink-0 rounded-2xl border px-4 py-3 text-left transition-colors {{ $index === 0 ? 'border-[#1fff9c] bg-[#071c11]' : 'border-[#242424] bg-[#050505]' }}"
                >
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs text-gray-400">{{ $tab['label'] }}</p>
                            <p class="text-2xl font-semibold text-white tab-balance" data-balance="{{ $tab['balance'] }}">
                                {{ $index === 0 ? $tab['balance'] : '•••••' }}
                            </p>
                            <p class="text-xs {{ $tab['isPositive'] ? 'text-green-400' : 'text-red-400' }}">{{ $tab['change'] }}</p>
                        </div>
                        <div data-icon-ring class="flex h-8 w-8 items-center justify-center rounded-full border {{ $index === 0 ? 'border-[#1fff9c] text-[#1fff9c]' : 'border-[#2c2c2c] text-gray-400' }}">
                            <span data-icon-active class="{{ $index === 0 ? '' : 'hidden' }}">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            <span data-icon-inactive class="{{ $index === 0 ? 'hidden' : '' }}">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </button>
            @endforeach
        </div>

        <div class="rounded-[32px] bg-[#050505] text-white shadow-[0_0_60px_rgba(0,0,0,0.45)]">
            <div class="flex flex-col gap-4 px-6 pb-2 pt-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase text-gray-400">Balance</p>
                    <p id="activeBalance" class="text-4xl font-semibold">{{ data_get($investingTab, 'balance', '$0.00') }}</p>
                    <p id="activeChange" class="text-sm {{ data_get($investingTab, 'isPositive', true) ? 'text-green-400' : 'text-red-400' }}">
                        {{ data_get($investingTab, 'change', 'No data yet') }}
                    </p>
                </div>
                <button class="self-start rounded-full bg-[#c6ff00] px-5 py-2 text-sm font-semibold text-black">
                    Offers
                </button>
            </div>

            <div class="relative h-72 w-full">
                <div class="pointer-events-none absolute inset-0 top-2 flex items-center justify-center">
                    <div class="h-[90%] w-[94%] rounded-[30px] border border-[#0f0f0f]"></div>
                </div>
                <canvas id="portfolioChart"></canvas>
            </div>

            <div id="timeRanges" class="flex flex-wrap gap-2 px-6 pb-6">
                @foreach ($timeRanges as $index => $range)
                    <button
                        data-range="{{ $range }}"
                        class="rounded-full px-4 py-1 text-xs font-semibold {{ $range === '1M' ? 'bg-[#00ff5f] text-black' : 'bg-[#0f0f0f] text-gray-300' }}"
                    >
                        {{ $range }}
                    </button>
                @endforeach
            </div>

            <div class="px-6 pb-6 pt-4">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-sm uppercase tracking-wide text-gray-400">Watchlist</h3>
                    <a href="{{ route('user.nav.stocks') }}" class="text-xs text-[#a1a1a1] hover:text-white">View all stocks</a>
                </div>
                <div class="space-y-3">
                    @forelse ($watchlist as $stock)
                        @php
                            $isPositive = ((float) $stock->price_change_24h) >= 0;
                            $sparkValues = [];
                            $base = max((float) $stock->current_price, 0.01);
                            $points = 8;
                            for ($i = 0; $i < $points; $i++) {
                                $sparkValues[] = $base * (1 + (mt_rand(-25, 25) / 1000));
                            }
                            $minValue = min($sparkValues);
                            $maxValue = max($sparkValues);
                            $range = max($maxValue - $minValue, 0.0001);
                            $path = '';
                            foreach ($sparkValues as $index => $value) {
                                $x = $points > 1 ? ($index / ($points - 1)) * 60 : 0;
                                $y = 24 - (($value - $minValue) / $range * 24);
                                $path .= ($index === 0 ? 'M' : ' L') . round($x, 2) . ' ' . round($y, 2);
                            }
                        @endphp
                        <a href="{{ route('user.liveTrading.trade', ['asset_type' => 'stock', 'symbol' => $stock->symbol]) }}"
                           class="group flex items-center justify-between rounded-2xl border border-[#111111] bg-[#030303] px-4 py-3 hover:border-[#1fff9c]/40 hover:bg-[#060606] transition-colors">
                            <div>
                                <p class="text-sm font-semibold text-white">{{ $stock->symbol }}</p>
                                <p class="text-xs text-gray-500">{{ $stock->name }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <svg width="70" height="28" viewBox="0 0 70 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="{{ $path }}" stroke="{{ $isPositive ? '#00ff5f' : '#ff4d4d' }}" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <div class="text-right">
                                    <span class="rounded-lg px-3 py-1 text-xs font-semibold {{ $isPositive ? 'bg-[#1fff9c]/20 text-[#1fff9c]' : 'bg-[#ff4d4d]/20 text-[#ff4d4d]' }}">
                                        ${{ number_format($stock->current_price, 2) }}
                                    </span>
                                    <span class="text-xs block mt-1 {{ $isPositive ? 'text-green-400' : 'text-red-400' }}">
                                        {{ $isPositive ? '+' : '' }}{{ number_format($stock->price_change_24h, 2) }}%
                                    </span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="rounded-2xl border border-[#111111] bg-[#030303] px-4 py-6 text-center text-sm text-gray-500">
                            No stocks available. <a href="{{ route('user.liveTrading.index') }}" class="text-[#1fff9c] underline">Start trading</a>.
                        </div>
                    @endforelse
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('user.nav.stocks') }}" class="inline-flex items-center justify-center rounded-full border border-[#1fff9c]/30 px-5 py-2 text-xs font-semibold text-[#1fff9c] hover:border-[#1fff9c]">
                        View all stocks
                    </a>
                </div>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-3xl border border-[#151515] bg-[#050505] p-5">
                <p class="text-xs uppercase text-gray-500">Investing</p>
                <p id="activeBalanceCard" class="text-2xl font-semibold text-white">{{ data_get($investingTab, 'balance', '$0.00') }}</p>
                <p id="activeChangeCard" class="text-xs {{ data_get($investingTab, 'isPositive', true) ? 'text-green-400' : 'text-red-400' }}">
                    {{ data_get($investingTab, 'change', 'No data yet') }}
                </p>
            </div>
            <div class="rounded-3xl border border-[#151515] bg-[#050505] p-5">
                <p class="text-xs uppercase text-gray-500">PNL</p>
                <p class="text-2xl font-semibold text-white">{{ data_get($pnlTab, 'balance', '$0.00') }}</p>
                <p class="text-xs {{ data_get($pnlTab, 'isPositive', true) ? 'text-green-400' : 'text-red-400' }}">
                    {{ data_get($pnlTab, 'change', 'No data yet') }}
                </p>
            </div>
            <div class="rounded-3xl border border-[#151515] bg-[#050505] p-5">
                <p class="text-xs uppercase text-gray-500">Balance</p>
                <p class="text-2xl font-semibold text-white">{{ data_get($walletTab, 'balance', '$0.00') }}</p>
                <p class="text-xs text-gray-400">{{ data_get($walletTab, 'change', 'Available to invest') }}</p>
            </div>
            <div class="rounded-3xl border border-[#151515] bg-[#050505] p-5">
                <p class="text-xs uppercase text-gray-500">Rewards</p>
                <p class="text-2xl font-semibold text-white">2 offers</p>
                <p class="text-xs text-green-400">+1 new offer</p>
            </div>
        </div>

        <div class="rounded-3xl border border-[#151515] bg-[#050505] p-6">
            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                <h3 class="text-lg font-semibold text-white">Recent Activity</h3>
                <button class="text-sm text-gray-400 hover:text-white">View all</button>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-[#101010] pb-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-500/20 text-green-300">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">Deposit</p>
                            <p class="text-xs text-gray-500">2 hours ago</p>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-green-400">+$1,000.00</span>
                </div>
                <div class="flex items-center justify-between border-b border-[#101010] pb-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-500/20 text-blue-200">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v4H3zm3 4v14h12V7" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">Trade Profit</p>
                            <p class="text-xs text-gray-500">5 hours ago</p>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-green-400">+$150.75</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-purple-500/20 text-purple-200">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">Copy Trade</p>
                            <p class="text-xs text-gray-500">1 day ago</p>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-green-400">+$75.25</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('portfolioChart').getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(0, 255, 95, 0.3)');
            gradient.addColorStop(1, 'rgba(0, 255, 95, 0)');

            const chartDataSets = {
                '1D': {
                    labels: ['9a', '10a', '11a', '12p', '1p', '2p', '3p'],
                    data: [12.1, 12.12, 12.13, 12.15, 12.12, 12.1, 12.14]
                },
                '1W': {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
                    data: [12.0, 12.05, 12.08, 12.12, 12.14]
                },
                '1M': {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                    data: [11.8, 11.95, 12.05, 12.14]
                },
                '3M': {
                    labels: ['Mar', 'Apr', 'May'],
                    data: [11.2, 11.6, 12.14]
                },
                '1Y': {
                    labels: ['Jan', 'Mar', 'May', 'Jul', 'Sep', 'Nov'],
                    data: [9.5, 10.2, 10.8, 11.2, 11.9, 12.14]
                },
                'All': {
                    labels: ['2019', '2020', '2021', '2022', '2023'],
                    data: [3.5, 6.0, 8.4, 10.3, 12.14]
                }
            };

            const defaultRange = '1M';

            const portfolioChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartDataSets[defaultRange].labels,
                    datasets: [{
                        label: 'Portfolio Value',
                        data: chartDataSets[defaultRange].data,
                        borderColor: '#00ff5f',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointRadius: 0,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { display: false, beginAtZero: false },
                        x: {
                            ticks: { color: '#404040', font: { size: 12 }},
                            grid: { display: false }
                        }
                    }
                }
            });

            const updateChartRange = (range) => {
                const dataset = chartDataSets[range] || chartDataSets[defaultRange];
                portfolioChart.data.labels = dataset.labels;
                portfolioChart.data.datasets[0].data = dataset.data;
                portfolioChart.update();
            };

                    const tabs = document.querySelectorAll('#accountTabs button');
                    const balanceEl = document.getElementById('activeBalance');
                    const changeEl = document.getElementById('activeChange');
                    const balanceCardEl = document.getElementById('activeBalanceCard');
                    const changeCardEl = document.getElementById('activeChangeCard');
                    const tabData = @json($accountTabs);

            tabs.forEach((tab) => {
                tab.addEventListener('click', () => {
                    const currentId = tab.dataset.account;
                    const currentData = tabData.find(item => item.id === currentId) || tabData[0];

                    balanceEl.textContent = currentData.balance;
                    changeEl.textContent = currentData.change;
                    balanceCardEl.textContent = currentData.balance;
                    changeCardEl.textContent = currentData.change;

                    const isPositive = currentData.isPositive ?? true;
                    changeEl.classList.toggle('text-green-400', isPositive);
                    changeEl.classList.toggle('text-red-400', !isPositive);
                    changeCardEl.classList.toggle('text-green-400', isPositive);
                    changeCardEl.classList.toggle('text-red-400', !isPositive);

                    tabs.forEach(btn => {
                        const isActive = btn === tab;
                        const activeIcon = btn.querySelector('[data-icon-active]');
                        const inactiveIcon = btn.querySelector('[data-icon-inactive]');
                        const ring = btn.querySelector('[data-icon-ring]');
                        const fnBalance = btn.querySelector('[data-balance]');
                        const originalValue = fnBalance ? fnBalance.dataset.balance : '';

                        if (activeIcon && inactiveIcon) {
                            activeIcon.classList.toggle('hidden', !isActive);
                            inactiveIcon.classList.toggle('hidden', isActive);
                        }

                        if (ring) {
                            ring.classList.toggle('border-[#1fff9c]', isActive);
                            ring.classList.toggle('text-[#1fff9c]', isActive);
                            ring.classList.toggle('border-[#2c2c2c]', !isActive);
                            ring.classList.toggle('text-gray-400', !isActive);
                        }

                        btn.classList.toggle('border-[#1fff9c]', isActive);
                        btn.classList.toggle('bg-[#071c11]', isActive);
                        btn.classList.toggle('border-[#242424]', !isActive);
                        btn.classList.toggle('bg-[#050505]', !isActive);

                        if (fnBalance) {
                            fnBalance.textContent = isActive ? originalValue : '•••••';
                        }
                    });
                });
            });

            const timeButtons = document.querySelectorAll('#timeRanges button');
            timeButtons.forEach(button => {
                button.addEventListener('click', () => {
                    timeButtons.forEach(btn => {
                        btn.classList.remove('bg-[#00ff5f]', 'text-black');
                        btn.classList.add('bg-[#0f0f0f]', 'text-gray-300');
                    });
                    button.classList.add('bg-[#00ff5f]', 'text-black');
                    button.classList.remove('bg-[#0f0f0f]', 'text-gray-300');
                    updateChartRange(button.dataset.range);
                });
            });

            updateChartRange(defaultRange);
        });
    </script>
@endpush
