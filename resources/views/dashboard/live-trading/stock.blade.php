@extends('dashboard.new-layout')

@section('content')
@php
    $change = $asset['price_change_24h'] ?? $asset->price_change_24h;
    $isPositive = $change >= 0;
    $timeRanges = ['1D', '1W', '1M', '3M', '1Y', 'All'];
    $quickStocks = ($relatedStocks ?? collect())->take(4);
@endphp

<div class="text-white">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('user.dashboard') }}" class="text-gray-400 hover:text-white text-sm flex items-center gap-1">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
        <div class="flex items-center gap-2 text-xs text-gray-500">
            <span class="h-1.5 w-1.5 rounded-full bg-green-400"></span>
            24 Hour Market
        </div>
    </div>

    <div class="space-y-6 rounded-[32px] bg-[#060606] p-6 shadow-[0_0_80px_rgba(0,0,0,0.65)]">
        <div>
            <div class="flex items-center gap-2 text-[11px] uppercase tracking-wide text-gray-500">
                <span class="text-[#08f58d]">Stock</span>
                <span>∙</span>
                <span>{{ strtoupper($asset['symbol'] ?? $asset->symbol) }}</span>
            </div>
            <h1 class="mt-1 text-2xl font-semibold tracking-tight">{{ is_array($asset) ? $asset['name'] : $asset->name }}</h1>
            <div class="mt-2 flex items-end gap-4">
                <p class="text-3xl font-semibold">${{ number_format($asset['current_price'] ?? $asset->current_price, 2) }}</p>
                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $isPositive ? 'bg-[#0f2b14] text-[#00ff5f]' : 'bg-[#2b0f0f] text-[#ff4d4d]' }}">
                    {{ $isPositive ? '+' : '' }}{{ number_format($change, 2) }}% Today
                </span>
            </div>
        </div>

        <div class="rounded-[28px] border border-[#101010] bg-black/80 p-5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="text-xs text-gray-400">
                    Swipe or tap chart to explore
                </div>
                <div class="flex items-center gap-2">
                    <button class="rounded-full border border-[#1fff9c] px-3 py-1 text-xs text-[#1fff9c]">Indicators</button>
                    <a href="{{ route('user.advancedTrading.trade', ['asset_type' => $assetType, 'symbol' => is_array($asset) ? $asset['symbol'] : $asset->symbol]) }}"
                       class="rounded-full border border-[#222] px-3 py-1 text-xs text-gray-300 hover:text-white hover:border-[#1fff9c]/30 transition">
                        Advanced
                    </a>
                </div>
            </div>

            <div class="mt-4 h-72 w-full rounded-[24px] bg-gradient-to-b from-[#081408] to-[#010101] p-1.5">
                <div class="relative h-full w-full rounded-[22px] border border-[#0a0a0a]/60 bg-black/90 px-2 pb-2 pt-6">
                    <div class="absolute left-6 top-4 text-xs text-gray-500">Price</div>
                    <canvas id="stockTradingChart"></canvas>
                    <div class="pointer-events-none absolute inset-0 rounded-[22px] border border-[#050505]/50"></div>
                </div>
            </div>

            <div class="mt-4 flex flex-wrap gap-2">
                @foreach ($timeRanges as $range)
                    <button class="time-range-btn rounded-full {{ $loop->first ? 'bg-[#00ff5f] text-black' : 'bg-[#0f0f0f] text-gray-300' }} px-4 py-1 text-xs font-semibold" data-range="{{ $range }}">
                        {{ $range }}
                    </button>
                @endforeach
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="rounded-3xl border border-[#111] bg-black p-4">
                <div class="mb-4 flex items-center justify-between">
                    <span class="text-sm text-gray-400">Quick Trade</span>
                    <span class="rounded-full bg-[#111] px-3 py-1 text-xs text-gray-400">Individual</span>
                </div>
                <div class="grid gap-2 text-sm text-white">
                    <button id="openBuyModal" class="flex items-center justify-between rounded-2xl border border-[#1fff9c] bg-gradient-to-r from-[#0b371a] to-[#05250f] px-4 py-3 text-left text-[#1fff9c] shadow-[0_10px_30px_rgba(0,255,95,0.15)] hover:from-[#0f4521] hover:to-[#073417]">
                        <span class="font-semibold">Buy {{ $asset['symbol'] ?? $asset->symbol }}</span>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5" />
                        </svg>
                    </button>
                    @forelse ($quickStocks as $quickStock)
                        <a href="{{ route('user.liveTrading.trade', ['asset_type' => 'stock', 'symbol' => $quickStock->symbol]) }}" class="rounded-2xl border border-[#191919] bg-[#050505] px-4 py-3 text-left hover:border-[#1fff9c]/30 flex items-center justify-between">
                            <div>
                                <p class="font-semibold text-white">{{ $quickStock->symbol }}</p>
                                <p class="text-xs text-gray-500">{{ $quickStock->name }}</p>
                            </div>
                            <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @empty
                        <p class="text-xs text-gray-500">No quick picks available.</p>
                    @endforelse
                </div>
            </div>
            <div class="rounded-3xl border border-[#111] bg-black p-4">
                <div class="mb-4 flex items-center justify-between">
                    <span>About {{ is_array($asset) ? $asset['name'] : $asset->name }}</span>
                    <span>Info</span>
                </div>
                <p class="text-sm text-gray-300">
                    {{ is_array($asset) ? $asset['name'] : $asset->name }} is actively trading in the market. Monitor key stats,
                    set price alerts, and execute trades with precision.
                </p>
                <div class="mt-4 grid grid-cols-2 gap-3 text-xs">
                    <div class="rounded-2xl border border-[#151515] bg-[#050505] p-3">
                        <p class="text-gray-400">Market Cap</p>
                        <p class="text-white">${{ number_format($asset['market_cap'] ?? 1200000000, 0) }}</p>
                    </div>
                    <div class="rounded-2xl border border-[#151515] bg-[#050505] p-3">
                        <p class="text-gray-400">Volume (24h)</p>
                        <p class="text-white">${{ number_format($asset['volume_24h'] ?? 32000000, 0) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-[32px] border border-[#101010] bg-[#040404] p-6 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wide text-[#08f58d]">Activity</p>
                    <h2 class="text-lg font-semibold">Recent Trades</h2>
                </div>
                <span class="text-xs text-gray-500">{{ $tradeHistory->count() }} shown</span>
            </div>
            @if($tradeHistory->isNotEmpty())
                <div class="space-y-3">
                    @foreach($tradeHistory as $trade)
                        @php
                            $isBuy = strtolower($trade->side) === 'buy';
                            $statusColor = match($trade->status) {
                                'completed', 'closed' => 'text-green-400',
                                'cancelled' => 'text-red-400',
                                default => 'text-yellow-400',
                            };
                        @endphp
                        <div class="rounded-2xl border border-[#121212] bg-[#050505] px-4 py-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <div>
                                <p class="text-sm font-semibold {{ $isBuy ? 'text-green-400' : 'text-red-400' }}">
                                    {{ strtoupper($trade->side) }} • {{ strtoupper($trade->symbol) }}
                                </p>
                                <p class="text-xs text-gray-500">{{ ucfirst($trade->order_type) }} • {{ $trade->created_at?->diffForHumans() }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-base font-semibold text-white">${{ number_format($trade->amount, 2) }}</p>
                                <p class="text-xs {{ $statusColor }}">{{ ucfirst($trade->status) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-[#1a1a1a] bg-[#050505] px-4 py-8 text-center text-sm text-gray-500">
                    No trades yet for this asset. Your activity will appear here once you place an order.
                </div>
            @endif
        </div>
    </div>
</div>

<div class="pb-24"></div>

<div id="buyModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 px-4">
    <div class="w-full max-w-md rounded-[28px] border border-[#111] bg-[#050505] p-6 shadow-[0_30px_90px_rgba(0,0,0,0.6)]">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-wide text-gray-500">Buy</p>
                <p class="text-xl font-semibold text-white">{{ is_array($asset) ? $asset['name'] : $asset->name }}</p>
            </div>
            <button id="closeBuyModal" class="rounded-full border border-gray-700 px-3 py-1 text-xs text-gray-300 hover:text-white">Close</button>
        </div>
        <form id="buyForm" class="space-y-4 text-white" method="POST" action="{{ route('user.liveTrading.store') }}" data-current-price="{{ $asset['current_price'] ?? $asset->current_price }}">
            @csrf
            <input type="hidden" name="asset_type" value="stock">
            <input type="hidden" name="symbol" value="{{ is_array($asset) ? $asset['symbol'] : $asset->symbol }}">
            <input type="hidden" name="side" value="buy">
            <input type="hidden" name="order_type" id="buyOrderType" value="market">
            <div class="rounded-2xl border border-[#111] bg-[#050505] px-4 py-3 flex items-center justify-between">
                <span class="text-xs text-gray-400">Trading Balance</span>
                <span class="text-sm font-semibold text-white">${{ number_format(optional($user)->trading_balance ?? 0, 2) }}</span>
            </div>
            <div>
                <label class="text-xs text-gray-400">Order Type</label>
                <div class="mt-2 grid grid-cols-2 gap-2">
                    <button type="button" data-order="market" class="order-btn rounded-2xl border border-[#1fff9c] bg-[#071d11] px-3 py-2 text-center text-sm font-semibold text-[#1fff9c]">Market</button>
                    <button type="button" data-order="limit" class="order-btn rounded-2xl border border-[#111] bg-[#050505] px-3 py-2 text-center text-sm text-gray-300">Limit</button>
                </div>
            </div>
            <div id="limitPriceField" class="hidden">
                <label class="text-xs text-gray-400">Limit Price</label>
                <div class="mt-1 rounded-2xl border border-[#111] bg-[#050505] px-3 py-2">
                    <input type="number" step="0.01" name="price" placeholder="Enter price" class="w-full bg-transparent text-white placeholder-gray-500 focus:outline-none">
                </div>
            </div>
            <div>
                <label class="text-xs text-gray-400">Amount</label>
                <div class="mt-1 rounded-2xl border border-[#111] bg-[#050505] px-3 py-2">
                    <input type="number" step="0.01" name="amount" id="buyAmount" placeholder="Enter amount" class="w-full bg-transparent text-white placeholder-gray-500 focus:outline-none">
                </div>
            </div>
            <div>
                <label class="text-xs text-gray-400">Quantity</label>
                <div class="mt-1 rounded-2xl border border-[#111] bg-[#050505] px-3 py-2">
                    <input type="number" step="0.0001" name="quantity" id="buyQuantity" placeholder="Enter quantity" class="w-full bg-transparent text-white placeholder-gray-500 focus:outline-none" readonly>
                </div>
            </div>
            <button type="submit" class="w-full rounded-2xl bg-[#00ff5f] py-3 text-center text-sm font-semibold text-black hover:bg-[#05d454]" id="buyFormSubmit">
                Place Buy Order
            </button>
            <div id="buyFormMessage" class="hidden rounded-2xl px-4 py-3 text-sm"></div>
        </form>
    </div>
</div>

<div id="tradeSuccessModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 px-4">
    <div class="w-full max-w-sm rounded-[28px] border border-[#111] bg-[#050505] p-6 text-center space-y-4">
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-green-500/10 text-green-300 border border-green-500/30">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div>
            <p class="text-lg font-semibold text-white">Order Placed</p>
            <p class="text-sm text-gray-400">Your trade has been submitted successfully.</p>
        </div>
        <button id="tradeSuccessConfirm" class="w-full rounded-2xl bg-[#00ff5f] py-3 text-black font-semibold hover:bg-[#05d454]">
            OK
        </button>
    </div>
</div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('stockTradingChart').getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 250);
            gradient.addColorStop(0, 'rgba(0, 255, 95, 0.4)');
            gradient.addColorStop(1, 'rgba(0, 255, 95, 0)');

            const timeRangeData = {
                '1D': [110, 112, 111, 115, 117, 113, 118, 120],
                '1W': [100, 103, 105, 108, 112, 114, 117, 119],
                '1M': [95, 97, 102, 106, 110, 115, 118, 122],
                '3M': [90, 92, 98, 105, 110, 115, 123, 128],
                '1Y': [60, 70, 80, 95, 105, 115, 118, 125],
                'All': [40, 60, 80, 100, 120, 135, 150, 165],
            };

            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: timeRangeData['1D'].map((_, i) => i + 1),
                    datasets: [{
                        data: timeRangeData['1D'],
                        borderColor: '#00ff5f',
                        backgroundColor: gradient,
                        borderWidth: 2.5,
                        pointRadius: 3,
                        pointBackgroundColor: '#00ff5f',
                        pointBorderColor: '#001902',
                        pointHoverRadius: 4,
                        fill: true,
                        tension: 0.4,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { display: false },
                        y: { display: false },
                    },
                },
            });

            document.querySelectorAll('.time-range-btn').forEach(button => {
                button.addEventListener('click', function () {
                    document.querySelectorAll('.time-range-btn').forEach(btn => {
                        btn.classList.remove('bg-[#00ff5f]', 'text-black');
                        btn.classList.add('bg-[#0f0f0f]', 'text-gray-300');
                    });
                    this.classList.add('bg-[#00ff5f]', 'text-black');
                    this.classList.remove('bg-[#0f0f0f]', 'text-gray-300');

                    const range = this.dataset.range;
                    chart.data.labels = timeRangeData[range].map((_, i) => i + 1);
                    chart.data.datasets[0].data = timeRangeData[range];
                    chart.update();
                });
            });

            const buyModal = document.getElementById('buyModal');
            const openBuy = document.getElementById('openBuyModal');
            const closeBuy = document.getElementById('closeBuyModal');
            const orderButtons = document.querySelectorAll('.order-btn');
            const limitPriceField = document.getElementById('limitPriceField');
            const limitPriceInput = limitPriceField?.querySelector('input[name="price"]');
            const orderTypeInput = document.getElementById('buyOrderType');
            const buyForm = document.getElementById('buyForm');
            const buyFormMessage = document.getElementById('buyFormMessage');
            const buyFormSubmit = document.getElementById('buyFormSubmit');
            const tradeSuccessModal = document.getElementById('tradeSuccessModal');
            const tradeSuccessConfirm = document.getElementById('tradeSuccessConfirm');
            const amountInput = document.getElementById('buyAmount');
            const quantityInput = document.getElementById('buyQuantity');
            const currentPrice = parseFloat(buyForm?.dataset.currentPrice ?? 0);

            function openBuyModal() {
                buyModal.classList.remove('hidden');
                buyModal.classList.add('flex');
            }

            function closeBuyModal() {
                buyModal.classList.add('hidden');
                buyModal.classList.remove('flex');
            }

            openBuy?.addEventListener('click', openBuyModal);
            closeBuy?.addEventListener('click', closeBuyModal);
            buyModal?.addEventListener('click', (e) => {
                if (e.target === buyModal) {
                    closeBuyModal();
                }
            });

            orderButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    orderButtons.forEach(b => {
                        b.classList.remove('border-[#1fff9c]', 'bg-[#071d11]', 'text-[#1fff9c]');
                        b.classList.add('border-[#111]', 'bg-[#050505]', 'text-gray-300');
                    });
                    btn.classList.add('border-[#1fff9c]', 'bg-[#071d11]', 'text-[#1fff9c]');
                    const isLimit = btn.dataset.order === 'limit';
                    if (orderTypeInput) {
                        orderTypeInput.value = isLimit ? 'limit' : 'market';
                    }
                    if (isLimit) {
                        limitPriceField.classList.remove('hidden');
                        if (limitPriceInput && !limitPriceInput.value) {
                            limitPriceInput.value = currentPrice ? currentPrice.toFixed(2) : '';
                        }
                    } else {
                        limitPriceField.classList.add('hidden');
                    }
                    updateQuantity();
                });
            });

            function updateQuantity() {
                if (!amountInput || !quantityInput) return;
                const amount = parseFloat(amountInput.value);
                if (!amount || amount <= 0) {
                    quantityInput.value = '';
                    return;
                }
                let priceForCalc = currentPrice;
                if (orderTypeInput?.value === 'limit') {
                    const limitPrice = parseFloat(limitPriceField?.querySelector('input[name="price"]')?.value);
                    if (limitPrice && limitPrice > 0) {
                        priceForCalc = limitPrice;
                    }
                }
                if (priceForCalc > 0) {
                    quantityInput.value = (amount / priceForCalc).toFixed(4);
                }
            }

            amountInput?.addEventListener('input', updateQuantity);
            limitPriceInput?.addEventListener('input', updateQuantity);

            buyForm?.addEventListener('submit', function (e) {
                e.preventDefault();
                if (!buyFormSubmit) return;

                const originalText = buyFormSubmit.textContent;
                buyFormSubmit.textContent = 'Processing...';
                buyFormSubmit.disabled = true;

                const formData = new FormData(buyForm);

                fetch('{{ route("user.liveTrading.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (!buyFormMessage) return;
                    
                    if (data.success) {
                        buyForm.reset();
                        if (orderTypeInput) {
                            orderTypeInput.value = 'market';
                        }
                        orderButtons.forEach(b => {
                            b.classList.remove('border-[#1fff9c]', 'bg-[#071d11]', 'text-[#1fff9c]');
                            b.classList.add('border-[#111]', 'bg-[#050505]', 'text-gray-300');
                        });
                        const defaultBtn = document.querySelector('.order-btn[data-order="market"]');
                        defaultBtn?.classList.add('border-[#1fff9c]', 'bg-[#071d11]', 'text-[#1fff9c]');
                        limitPriceField?.classList.add('hidden');
                        closeBuyModal();
                        tradeSuccessModal.classList.remove('hidden');
                        tradeSuccessModal.classList.add('flex');
                    } else {
                        buyFormMessage.className = 'rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300 mt-3';
                        buyFormMessage.textContent = data.message || 'Failed to place trade. Please try again.';
                        buyFormMessage.classList.remove('hidden');
                    }
                })
                .catch(() => {
                    if (!buyFormMessage) return;
                    buyFormMessage.className = 'rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300 mt-3';
                    buyFormMessage.textContent = 'An error occurred while placing the trade. Please try again.';
                    buyFormMessage.classList.remove('hidden');
                })
                .finally(() => {
                    buyFormSubmit.textContent = originalText;
                    buyFormSubmit.disabled = false;
                });
            });

            tradeSuccessConfirm?.addEventListener('click', () => {
                tradeSuccessModal.classList.add('hidden');
                tradeSuccessModal.classList.remove('flex');
                window.location.reload();
            });
        });
    </script>
@endpush
