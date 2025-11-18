@extends('dashboard.new-layout')

@section('content')
@php
    $holdingsBySymbol = $holdingsBySymbol ?? collect();
@endphp
<div class="space-y-6 text-white">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs uppercase tracking-wide text-[#08f58d]">Live Trading</p>
            <h1 class="text-2xl font-semibold tracking-tight">{{ is_array($asset) ? $asset['name'] : $asset->name }}</h1>
            <p class="text-sm text-gray-400">{{ strtoupper($assetType) }} Trading</p>
        </div>
        <a href="{{ route('user.nav.trade') }}" class="rounded-full border border-[#1f1f1f] px-4 py-2 text-sm text-gray-400 hover:border-[#1fff9c]/30 hover:text-white transition">
            ← Back
        </a>
    </div>

    <!-- Trading Interface -->
    <div class="grid grid-cols-1 lg:grid-cols-6 gap-6">
        <!-- Chart Section -->
        <div class="lg:col-span-4">
            <div class="rounded-[32px] border border-[#101010] bg-[#040404] overflow-hidden">
                <div class="border-b border-[#121212] px-6 py-4">
                    <h2 class="text-lg font-semibold">Price Chart</h2>
                </div>
                
                <!-- TradingView Chart Container -->
                <div class="relative w-full p-0">
                    <div id="tradingViewChart" class="w-full h-[500px] lg:h-[700px] bg-[#030303] rounded-xl overflow-hidden border border-[#0f0f0f]">
                        <div class="flex items-center justify-center h-full text-gray-500">
                            <div class="text-center">
                                <svg class="w-12 h-12 mx-auto mb-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                                </svg>
                                <p class="text-sm">Loading chart...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trading Panel -->
        <div class="lg:col-span-2">
            <div class="rounded-[32px] border border-[#101010] bg-[#040404] p-6 space-y-6">
                <h2 class="text-lg font-semibold">Place Trade</h2>
                
                @if(session('success'))
                    <div class="rounded-2xl border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-300">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                        {{ $errors->first('trade') ?? $errors->first() }}
                    </div>
                @endif
                
                <!-- Current Price Display -->
                <div class="rounded-2xl bg-[#0a0a0a] p-6 text-center">
                    @php
                        $currentPrice = is_array($asset) ? $asset['current_price'] : $asset->current_price;
                        $change = is_array($asset) ? $asset['price_change_24h'] : $asset->price_change_24h;
                        $decimals = $assetType === 'crypto' ? 6 : 2;
                    @endphp
                    <p id="currentPriceValue" data-decimals="{{ $decimals }}" class="text-4xl font-bold">
                        ${{ number_format($currentPrice, $decimals) }}
                    </p>
                    <p id="priceChangeValue" class="text-sm mt-2 {{ $change >= 0 ? 'text-green-400' : 'text-red-400' }}">
                        {{ $change >= 0 ? '↗' : '↘' }} {{ number_format(abs($change), 2) }}% <span class="text-gray-500">24h</span>
                    </p>
                </div>

                <!-- Trading Form -->
                <form id="tradingForm" class="space-y-4" data-current-price="{{ $currentPrice }}">
                    @csrf
                    <input type="hidden" name="asset_type" value="{{ $assetType }}">
                    <input type="hidden" name="symbol" value="{{ is_array($asset) ? $asset['symbol'] : $asset->symbol }}">
                    
                    <!-- Order Type -->
                    <div class="space-y-2">
                        <label class="text-xs uppercase tracking-wide text-gray-400">Order Type</label>
                        <select name="order_type" id="orderType" class="w-full rounded-2xl border border-[#191919] bg-[#030303] px-4 py-3 text-white focus:border-[#1fff9c] focus:outline-none">
                            <option value="market">Market Order</option>
                            <option value="limit">Limit Order</option>
                        </select>
                    </div>

                    <!-- Side -->
                    <div class="space-y-2">
                        <label class="text-xs uppercase tracking-wide text-gray-400">Side</label>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" class="side-btn buy-btn active rounded-2xl bg-green-600 px-4 py-3 font-semibold text-white transition hover:bg-green-700" data-side="buy">
                                Buy
                            </button>
                            <button type="button" class="side-btn sell-btn rounded-2xl border border-[#1f1f1f] bg-[#0a0a0a] px-4 py-3 font-semibold text-gray-400 transition hover:bg-red-600 hover:text-white hover:border-red-600" data-side="sell">
                                Sell
                            </button>
                        </div>
                        <input type="hidden" name="side" value="buy">
                    </div>

                    <!-- Limit Order Fields -->
                    <div id="limitOrderFields" class="hidden space-y-4">
                        <div class="space-y-2">
                            <label class="text-xs uppercase tracking-wide text-gray-400">Amount ({{ auth()->user()->currency ?? 'USD' }})</label>
                            <input type="number" name="limit_amount" step="0.01" min="1" class="w-full rounded-2xl border border-[#191919] bg-[#030303] px-4 py-3 text-white focus:border-[#1fff9c] focus:outline-none" placeholder="100.00" id="limitAmountInput">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs uppercase tracking-wide text-gray-400">Price</label>
                            <input type="number" name="price" step="0.00000001" class="w-full rounded-2xl border border-[#191919] bg-[#030303] px-4 py-3 text-white focus:border-[#1fff9c] focus:outline-none" placeholder="0.00" id="limitPriceInput">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs uppercase tracking-wide text-gray-400">Quantity</label>
                            <input type="number" name="quantity" step="0.00000001" class="w-full rounded-2xl border border-[#191919] bg-[#030303] px-4 py-3 text-white focus:border-[#1fff9c] focus:outline-none" placeholder="0.00" id="limitQuantityInput">
                        </div>
                    </div>

                    <!-- Market Order Fields -->
                    <div id="marketOrderFields">
                        <div class="space-y-2">
                            <label class="text-xs uppercase tracking-wide text-gray-400">Amount ({{ auth()->user()->currency ?? 'USD' }})</label>
                            <input type="number" name="amount" step="0.01" min="1" class="w-full rounded-2xl border border-[#191919] bg-[#030303] px-4 py-3 text-white focus:border-[#1fff9c] focus:outline-none" placeholder="100.00" id="marketAmountInput">
                        </div>
                    </div>

                    <!-- Leverage -->
                    <div class="space-y-2">
                        <label class="text-xs uppercase tracking-wide text-gray-400">Leverage</label>
                        <select name="leverage" class="w-full rounded-2xl border border-[#191919] bg-[#030303] px-4 py-3 text-white focus:border-[#1fff9c] focus:outline-none">
                            <option value="1">1x</option>
                            <option value="2">2x</option>
                            <option value="5">5x</option>
                            <option value="10">10x</option>
                            <option value="20">20x</option>
                            <option value="50">50x</option>
                            <option value="100">100x</option>
                        </select>
                    </div>

                    <!-- Place Order Button -->
                    <button type="submit" class="w-full rounded-2xl bg-[#0f6d42] py-3 text-sm font-semibold text-white hover:bg-[#0a5231] transition flex items-center justify-center gap-2">
                        <span id="submitText">Place Order</span>
                        <svg id="submitSpinner" class="hidden h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </button>
                    
                    <!-- Success/Error Messages -->
                    <div id="tradeMessage" class="hidden rounded-2xl px-4 py-3 text-sm"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Trade History -->
<div class="rounded-[32px] border border-[#101010] bg-[#040404] p-6 text-white space-y-4">
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
                        'filled', 'completed', 'closed' => 'text-green-400',
                        'cancelled' => 'text-red-400',
                        default => 'text-yellow-400',
                    };
                    $tradeSymbol = strtoupper($trade->symbol);
                    $holding = $holdingsBySymbol[$tradeSymbol] ?? null;
                    $pnlValue = $holding?->unrealized_pnl ?? null;
                    $pnlPercent = $holding?->unrealized_pnl_percentage ?? null;
                    $pnlPositive = $pnlValue >= 0;
                @endphp
                <div class="rounded-2xl border border-[#121212] bg-[#050505] px-4 py-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <p class="text-sm font-semibold {{ $isBuy ? 'text-green-400' : 'text-red-400' }}">
                            {{ strtoupper($trade->side) }} • {{ strtoupper($trade->symbol) }}
                        </p>
                        <p class="text-xs text-gray-500">{{ ucfirst($trade->order_type) }} • {{ $trade->created_at?->diffForHumans() }}</p>
                        @if(!is_null($pnlValue))
                            <p class="text-xs {{ $pnlPositive ? 'text-green-400' : 'text-red-400' }}">
                                Gain/Loss: {{ $pnlPositive ? '+' : '' }}{{ $user->formatAmount(abs($pnlValue)) }}
                                ({{ number_format($pnlPercent ?? 0, 2) }}%)
                            </p>
                        @endif
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize TradingView Chart
    initTradingViewChart('{{ is_array($asset) ? $asset["symbol"] : $asset->symbol }}', '{{ $assetType }}');
    initLivePrice();
    const tradeSuccessModal = document.getElementById('tradeSuccessModal');
    const tradeSuccessConfirm = document.getElementById('tradeSuccessConfirm');
    
    // Order type switching
    const orderType = document.getElementById('orderType');
    const limitFields = document.getElementById('limitOrderFields');
    const marketFields = document.getElementById('marketOrderFields');
    const marketAmountInput = document.getElementById('marketAmountInput');
    const limitAmountInput = document.getElementById('limitAmountInput');
    const limitPriceInput = document.getElementById('limitPriceInput');
    const limitQuantityInput = document.getElementById('limitQuantityInput');
    
    orderType.addEventListener('change', function() {
        if (this.value === 'limit') {
            limitFields.classList.remove('hidden');
            marketFields.classList.add('hidden');
            if (limitAmountInput && !limitAmountInput.value && marketAmountInput) {
                limitAmountInput.value = marketAmountInput.value;
            }
            updateLimitQuantity();
        } else {
            limitFields.classList.add('hidden');
            marketFields.classList.remove('hidden');
        }
    });
    
    const updateLimitQuantity = () => {
        if (!limitAmountInput || !limitPriceInput || !limitQuantityInput) return;
        const price = parseFloat(limitPriceInput.value);
        const amount = parseFloat(limitAmountInput.value);
        if (price > 0 && amount > 0) {
            limitQuantityInput.value = (amount / price).toFixed(8);
        } else {
            limitQuantityInput.value = '';
        }
    };
    
    limitAmountInput?.addEventListener('input', updateLimitQuantity);
    
    limitPriceInput?.addEventListener('input', updateLimitQuantity);
    
    // Side switching
    const sideBtns = document.querySelectorAll('.side-btn');
    const sideInput = document.querySelector('input[name="side"]');
    
    sideBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            sideBtns.forEach(b => {
                b.classList.remove('active', 'bg-green-600', 'bg-red-600', 'text-white', 'border-green-600', 'border-red-600');
                b.classList.add('bg-[#0a0a0a]', 'text-gray-400', 'border-[#1f1f1f]');
            });
            
            this.classList.add('active');
            if (this.classList.contains('buy-btn')) {
                this.classList.remove('bg-[#0a0a0a]', 'text-gray-400', 'border-[#1f1f1f]');
                this.classList.add('bg-green-600', 'text-white', 'border-green-600');
                sideInput.value = 'buy';
            } else {
                this.classList.remove('bg-[#0a0a0a]', 'text-gray-400', 'border-[#1f1f1f]');
                this.classList.add('bg-red-600', 'text-white', 'border-red-600');
                sideInput.value = 'sell';
            }
        });
    });
    
    // Form submission
    const form = document.getElementById('tradingForm');
    const submitText = document.getElementById('submitText');
    const submitSpinner = document.getElementById('submitSpinner');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        submitText.textContent = 'Processing...';
        submitSpinner.classList.remove('hidden');
        
        const formData = new FormData(this);
        
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
            const messageDiv = document.getElementById('tradeMessage');
            
            if (data.success) {
                // Show success message
                submitText.textContent = 'Success!';
                submitSpinner.classList.add('hidden');
                
                messageDiv.className = 'rounded-2xl border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-300';
                messageDiv.textContent = data.message || 'Trade placed successfully!';
                messageDiv.classList.remove('hidden');
                
                // Reset form after 2 seconds
                setTimeout(() => {
                    form.reset();
                    submitText.textContent = 'Place Order';
                    messageDiv.classList.add('hidden');
                    
                    // Reset buy button to active
                    sideBtns.forEach(b => {
                        b.classList.remove('active', 'bg-green-600', 'bg-red-600', 'text-white', 'border-green-600', 'border-red-600');
                        b.classList.add('bg-[#0a0a0a]', 'text-gray-400', 'border-[#1f1f1f]');
                    });
                    document.querySelector('.buy-btn').classList.add('active', 'bg-green-600', 'text-white', 'border-green-600');
                    document.querySelector('.buy-btn').classList.remove('bg-[#0a0a0a]', 'text-gray-400', 'border-[#1f1f1f]');
                    sideInput.value = 'buy';

                    openTradeSuccessModal();
                }, 500);
            } else {
                // Show error message
                submitText.textContent = 'Place Order';
                submitSpinner.classList.add('hidden');
                
                messageDiv.className = 'rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300';
                messageDiv.textContent = data.message || 'Failed to place trade. Please try again.';
                messageDiv.classList.remove('hidden');
                
                // Hide error after 5 seconds
                setTimeout(() => {
                    messageDiv.classList.add('hidden');
                }, 5000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const messageDiv = document.getElementById('tradeMessage');
            
            submitText.textContent = 'Place Order';
            submitSpinner.classList.add('hidden');
            
            messageDiv.className = 'rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300';
            messageDiv.textContent = 'An error occurred while placing the trade. Please try again.';
            messageDiv.classList.remove('hidden');
            
            setTimeout(() => {
                messageDiv.classList.add('hidden');
            }, 5000);
        });
    });
});

function initTradingViewChart(symbol, assetType) {
    if (typeof TradingView === 'undefined') {
        console.error('TradingView is not loaded');
        return;
    }
    
    let tradingViewSymbol = symbol;
    
    if (assetType === 'stock') {
        tradingViewSymbol = `NASDAQ:${symbol}`;
    } else if (assetType === 'forex') {
        tradingViewSymbol = `FX:${symbol}`;
    } else if (assetType === 'crypto') {
        tradingViewSymbol = `BINANCE:${symbol}USD`;
    }
    
    const container = document.getElementById('tradingViewChart');
    if (!container) {
        console.error('TradingView container not found');
        return;
    }
    
    container.innerHTML = '';
    
    new TradingView.widget({
        "width": "100%",
        "height": container.offsetHeight,
        "symbol": tradingViewSymbol,
        "interval": "D",
        "timezone": "Etc/UTC",
        "theme": "dark",
        "style": "1",
        "locale": "en",
        "toolbar_bg": "#030303",
        "enable_publishing": false,
        "hide_side_toolbar": false,
        "allow_symbol_change": true,
        "container_id": "tradingViewChart",
        "autosize": true,
        "studies": [
            "RSI@tv-basicstudies",
            "MACD@tv-basicstudies"
        ],
        "overrides": {
            "paneProperties.background": "#030303",
            "paneProperties.backgroundType": "solid",
            "paneProperties.vertGridProperties.color": "#0f0f0f",
            "paneProperties.horzGridProperties.color": "#0f0f0f",
            "symbolWatermarkProperties.transparency": 90,
            "scalesProperties.textColor": "#6b7280"
        }
    });
}

function initLivePrice() {
    const priceEl = document.getElementById('currentPriceValue');
    const changeEl = document.getElementById('priceChangeValue');
    if (!priceEl || !changeEl) {
        return;
    }

    const decimals = parseInt(priceEl.dataset.decimals ?? '2', 10);
    const assetType = '{{ $assetType }}';
    const symbol = '{{ is_array($asset) ? $asset["symbol"] : $asset->symbol }}';

    const formatter = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals,
    });

    const fetchPrice = () => {
        const url = new URL('{{ route('user.liveTrading.price') }}', window.location.origin);
        url.searchParams.set('asset_type', assetType);
        url.searchParams.set('symbol', symbol);

        fetch(url.toString())
            .then(res => res.json())
            .then(data => {
                if (!data.success) return;
                const price = parseFloat(data.price ?? 0) || 0;
                const change = parseFloat(data.change_24h ?? 0) || 0;
                priceEl.textContent = `$${formatter.format(price)}`;
                changeEl.classList.remove('text-green-400', 'text-red-400');
                changeEl.classList.add(change >= 0 ? 'text-green-400' : 'text-red-400');
                changeEl.innerHTML = `${change >= 0 ? '↗' : '↘'} ${Math.abs(change).toFixed(2)}% <span class="text-gray-500">24h</span>`;
            })
            .catch(() => {});
    };

    fetchPrice();
    setInterval(fetchPrice, 60000);
}

function openTradeSuccessModal() {
    const modal = document.getElementById('tradeSuccessModal');
    if (!modal) return;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeTradeSuccessModal() {
    const modal = document.getElementById('tradeSuccessModal');
    if (!modal) return;
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    window.location.reload();
}

document.addEventListener('click', function(event) {
    if (event.target && event.target.id === 'tradeSuccessConfirm') {
        closeTradeSuccessModal();
    }
});
</script>
@endsection
<!-- Trade Success Modal -->
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
