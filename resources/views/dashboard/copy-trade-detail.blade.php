@extends('dashboard.layout.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('user.copyTrading.index') }}" 
               class="text-gray-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-white">Copy Trade Details</h1>
                <p class="text-gray-400 mt-1">Detailed information about your copied trade</p>
            </div>
        </div>
        
        @if($copiedTrade->status == 1)
        <form action="{{ route('user.copyTrading.stop', $copiedTrade->id) }}" method="POST" class="inline">
            @csrf
            <button type="submit" 
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2"
                    onclick="return confirm('Are you sure you want to stop copying this trader?')">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span>Stop Copying</span>
            </button>
        </form>
        @endif
    </div>

    <!-- Success/Error Messages -->
    @if(session()->has('success'))
        <div class="bg-green-900 border border-green-700 text-green-100 px-4 py-3 rounded-lg">
            {{ session()->get('success') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div class="bg-red-900 border border-red-700 text-red-100 px-4 py-3 rounded-lg">
            {{ session()->get('error') }}
        </div>
    @endif

    <!-- Trader Information Card -->
    <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
        <div class="flex items-center space-x-6">
            <div class="relative">
                <img src="{{ $trader->avatar_url }}" alt="{{ $trader->name }}" 
                     class="w-20 h-20 rounded-full object-cover border-2 border-gray-600"
                     onerror="this.src='{{ asset('img/trader.jpg') }}'">
                <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-gray-700"></div>
            </div>
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-white">{{ $trader->name }}</h2>
                <p class="text-gray-400">Professional Trader</p>
                <div class="flex items-center space-x-4 mt-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-200">
                        {{ $trader->win_rate }}% Win Rate
                    </span>
                    <span class="text-gray-400 text-sm">{{ $tradeCount }} total trades</span>
                </div>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-400">Status</div>
                @if($copiedTrade->status == 1)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-900 text-green-200">
                        Active
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-900 text-gray-200">
                        Inactive
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Trade Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <!-- Investment Amount -->
        <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-sm text-gray-400">Investment</div>
                    <div class="text-xl font-bold text-white">${{ number_format($copiedTrade->amount, 2) }}</div>
                </div>
            </div>
        </div>

        <!-- Trade Count -->
        <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2zm0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-sm text-gray-400">Trade Count</div>
                    <div class="text-xl font-bold text-white">{{ $tradeCount }}</div>
                </div>
            </div>
        </div>

        <!-- Profit/Loss -->
        <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-sm text-gray-400">Profit/Loss</div>
                    <div class="text-xl font-bold {{ $pnl >= 0 ? 'text-green-400' : 'text-red-400' }}">${{ number_format($pnl, 2) }}</div>
                </div>
            </div>
        </div>

        <!-- ROI -->
        <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-sm text-gray-400">ROI</div>
                    <div class="text-xl font-bold text-purple-400">{{ number_format($roi, 2) }}%</div>
                </div>
            </div>
        </div>

        <!-- Duration -->
        <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-sm text-gray-400">Duration</div>
                    <div class="text-xl font-bold text-white">
                        {{ $copiedTrade->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trader Performance -->
    <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-white mb-6">Trader Performance</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Trade Count -->
            <div class="text-center p-4 bg-gray-700 rounded-lg">
                <div class="text-2xl font-bold text-blue-400 mb-2">{{ $tradeCount }}</div>
                <div class="text-sm text-gray-400">Total Trades</div>
            </div>

            <!-- Win Rate -->
            <div class="text-center p-4 bg-gray-700 rounded-lg">
                @php 
                    $totalTrades = $wins + $losses;
                    $winRate = $totalTrades > 0 ? round(($wins / $totalTrades) * 100, 1) : 0;
                    $barPercent = min(100, max(0, $winRate));
                @endphp
                <div class="text-2xl font-bold text-green-400 mb-2">{{ $winRate }}%</div>
                <div class="text-sm text-gray-400">Win Rate</div>
                <div class="w-full bg-gray-600 rounded-full h-1.5 mt-3 overflow-hidden">
                    <div class="bg-green-500 h-1.5" style="width: {{ $barPercent }}%"></div>
                </div>
            </div>

            <!-- Wins -->
            <div class="text-center p-4 bg-gray-700 rounded-lg">
                <div class="text-2xl font-bold text-green-400 mb-2">{{ $wins }}</div>
                <div class="text-sm text-gray-400">Winning Trades</div>
            </div>

            <!-- Losses -->
            <div class="text-center p-4 bg-gray-700 rounded-lg">
                <div class="text-2xl font-bold text-red-400 mb-2">{{ $losses }}</div>
                <div class="text-sm text-gray-400">Losing Trades</div>
            </div>
        </div>
    </div>

    <!-- Trade Timeline -->
    <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-white mb-6">Trade Timeline</h3>
        
        <div class="space-y-4">
            <div class="flex items-center space-x-4">
                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                <div class="flex-1">
                    <div class="text-white font-medium">Copy Trade Started</div>
                    <div class="text-sm text-gray-400">{{ $copiedTrade->created_at->format('M d, Y \a\t g:i A') }}</div>
                </div>
            </div>
            
            @if($copiedTrade->stopped_at)
            <div class="flex items-center space-x-4">
                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                <div class="flex-1">
                    <div class="text-white font-medium">Copy Trade Stopped</div>
                    <div class="text-sm text-gray-400">{{ $copiedTrade->stopped_at->format('M d, Y \a\t g:i A') }}</div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex items-center justify-between">
        <a href="{{ route('user.copyTrading.index') }}" 
           class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition-colors duration-200">
            Back to Copy Trading
        </a>
        
        @if($copiedTrade->status == 1)
        <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-400">This trade is currently active and copying {{ $trader->name }}'s strategies</span>
        </div>
        @else
        <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-400">This trade has been stopped</span>
        </div>
        @endif
    </div>
</div>
@endsection
