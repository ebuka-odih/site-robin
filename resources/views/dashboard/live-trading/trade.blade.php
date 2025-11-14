@extends('dashboard.layout.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">{{ $asset['name'] ?? $asset->name }}</h1>
            <p class="text-gray-400 mt-1">{{ strtoupper($assetType) }} Trading</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('user.liveTrading.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition-colors">
                <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                </svg>
                Back to Assets
            </a>
        </div>
    </div>

    <!-- Trading Interface -->
    <div class="grid grid-cols-1 lg:grid-cols-6 gap-6">
        <!-- Chart Section (66% width) -->
        <div class="lg:col-span-4">
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-4 sm:p-6">
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-white">Price Chart</h2>
                </div>
                
                <!-- TradingView Chart Container -->
                <div class="relative w-full">
                    <div id="tradingViewChart" class="w-full h-[400px] sm:h-[500px] lg:h-[700px] xl:h-[800px] bg-gray-900 rounded-lg overflow-hidden border border-gray-600">
                        <div class="flex items-center justify-center h-full text-gray-400">
                            <div class="text-center">
                                <svg class="w-12 h-12 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                                <p>Loading chart...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trading Panel (33% width) -->
        <div class="lg:col-span-2">
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Place Trade</h2>
                
                <!-- Current Price Display -->
                <div class="mb-6 p-4 bg-gray-700 rounded-lg">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">${{ number_format($asset['current_price'] ?? $asset->current_price, 4) }}</div>
                        <div class="text-sm text-gray-400 mt-1">
                            @php
                                $change = $asset['price_change_24h'] ?? $asset->price_change_24h;
                                $changeColor = $change >= 0 ? 'text-green-400' : 'text-red-400';
                                $changeIcon = $change >= 0 ? '↗' : '↘';
                            @endphp
                            <span class="{{ $changeColor }}">{{ $changeIcon }} {{ number_format(abs($change), 2) }}%</span>
                            <span class="text-gray-500">24h</span>
                        </div>
                    </div>
                </div>

                <!-- Trading Form -->
                <form id="tradingForm" class="space-y-4">
                    @csrf
                    <input type="hidden" name="asset_type" value="{{ $assetType }}">
                    <input type="hidden" name="symbol" value="{{ $asset['symbol'] ?? $asset->symbol }}">
                    
                    <!-- Order Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Order Type</label>
                        <select name="order_type" id="orderType" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="market">Market Order</option>
                            <option value="limit">Limit Order</option>
                        </select>
                    </div>

                    <!-- Side -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Side</label>
                        <div class="grid grid-cols-2 gap-2">
                            <button type="button" class="side-btn buy-btn active px-3 py-2 bg-green-600 text-white rounded font-medium" data-side="buy">
                                Buy
                            </button>
                            <button type="button" class="side-btn sell-btn px-3 py-2 bg-gray-700 text-gray-300 rounded font-medium" data-side="sell">
                                Sell
                            </button>
                        </div>
                        <input type="hidden" name="side" value="buy">
                    </div>

                    <!-- Limit Order Fields -->
                    <div id="limitOrderFields" class="hidden space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Price</label>
                            <input type="number" name="price" step="0.00000001" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="0.00">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Quantity</label>
                            <input type="number" name="quantity" step="0.00000001" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="0.00">
                        </div>
                    </div>

                    <!-- Market Order Fields -->
                    <div id="marketOrderFields">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Amount ({{ auth()->user()->currency ?? 'USD' }})</label>
                            <input type="number" name="amount" step="0.01" min="1" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="100.00">
                        </div>
                    </div>

                    <!-- Leverage -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Leverage</label>
                        <select name="leverage" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition-colors">
                        Place Order
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize TradingView Chart
    initTradingViewChart('{{ $asset["symbol"] ?? $asset->symbol }}', '{{ $assetType }}');
    
    // Order type switching
    const orderType = document.getElementById('orderType');
    const limitFields = document.getElementById('limitOrderFields');
    const marketFields = document.getElementById('marketOrderFields');
    
    orderType.addEventListener('change', function() {
        if (this.value === 'limit') {
            limitFields.classList.remove('hidden');
            marketFields.classList.add('hidden');
        } else {
            limitFields.classList.add('hidden');
            marketFields.classList.remove('hidden');
                        }
                    });
    
    // Side switching
    const sideBtns = document.querySelectorAll('.side-btn');
    const sideInput = document.querySelector('input[name="side"]');
    
    sideBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            sideBtns.forEach(b => {
                b.classList.remove('active', 'bg-green-600', 'bg-red-600');
                b.classList.add('bg-gray-700', 'text-gray-300');
            });
            
            this.classList.add('active');
            if (this.classList.contains('buy-btn')) {
                this.classList.add('bg-green-600', 'text-white');
                this.classList.remove('bg-gray-700', 'text-gray-300');
                sideInput.value = 'buy';
            } else {
                this.classList.add('bg-red-600', 'text-white');
                this.classList.remove('bg-gray-700', 'text-gray-300');
                sideInput.value = 'sell';
            }
        });
    });
    
    // Form submission
    document.getElementById('tradingForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('{{ route("user.liveTrading.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Trade placed successfully!');
                location.reload();
            } else {
                alert('Failed to place trade: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while placing the trade');
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
    }
    
    // Get the container element
    const container = document.getElementById('tradingViewChart');
    if (!container) {
        console.error('TradingView container not found');
        return;
    }
    
    // Clear any existing content
    container.innerHTML = '';
    
    // Get responsive height based on screen size
    const getChartHeight = () => {
        if (window.innerWidth < 640) return 400; // Mobile
        if (window.innerWidth < 1024) return 500; // Tablet
        if (window.innerWidth < 1280) return 700; // Large Desktop
        return 800; // Extra Large Desktop
    };
    
    new TradingView.widget({
        "width": "100%",
        "height": getChartHeight(),
        "symbol": tradingViewSymbol,
        "interval": "D",
        "timezone": "Etc/UTC",
        "theme": "dark",
        "style": "1",
        "locale": "en",
        "toolbar_bg": "#374151",
        "enable_publishing": false,
        "hide_side_toolbar": false,
        "allow_symbol_change": true,
        "container_id": "tradingViewChart",
        "autosize": true,
        "studies": [
            "RSI@tv-basicstudies",
            "MACD@tv-basicstudies",
            "Volume@tv-basicstudies"
        ],
        "overrides": {
            "paneProperties.background": "#1f2937",
            "paneProperties.vertGridProperties.color": "#374151",
            "paneProperties.horzGridProperties.color": "#374151",
            "symbolWatermarkProperties.transparency": 90,
            "scalesProperties.textColor": "#9ca3af"
        }
    });
    
    // Handle window resize
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            // Update container height on resize for better responsiveness
            if (window.innerWidth < 640) {
                container.style.height = '400px';
            } else if (window.innerWidth < 1024) {
                container.style.height = '500px';
            } else if (window.innerWidth < 1280) {
                container.style.height = '700px';
            } else {
                container.style.height = '800px';
            }
        }, 250);
    });
}
</script>

<!-- Bottom Spacing -->
<div class="pb-16"></div>

<!-- Include Trading Footer -->
@include('components.trading-footer')

@endsection
