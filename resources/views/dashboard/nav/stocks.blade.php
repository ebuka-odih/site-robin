@extends('dashboard.new-layout')

@section('content')
<div class="space-y-8 text-white">
    <div class="flex flex-col gap-1">
        <p class="text-xs uppercase tracking-wide text-[#08f58d]">Market Watch</p>
        <h1 class="text-3xl font-semibold tracking-tight">All Stocks</h1>
        <p class="text-gray-400 text-sm">Live prices pulled from Finnhub are refreshed by the background scheduler.</p>
    </div>

    <form method="GET" action="{{ route('user.nav.stocks') }}" class="flex gap-3">
        <div class="flex-1 relative">
            <input
                type="text"
                name="search"
                value="{{ $search ?? '' }}"
                placeholder="Search by symbol or name (e.g., AAPL, Apple)"
                class="w-full rounded-2xl border border-[#191919] bg-[#030303] px-4 py-3 pl-10 text-white placeholder-gray-500 focus:border-[#1fff9c] focus:outline-none"
            >
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <button type="submit" class="rounded-2xl bg-[#00ff5f] px-6 py-3 text-black font-semibold text-sm hover:brightness-110 transition">
            Search
        </button>
        @if($search)
            <a href="{{ route('user.nav.stocks') }}" class="rounded-2xl border border-[#1f1f1f] px-6 py-3 text-gray-400 font-semibold text-sm hover:text-white hover:border-[#1fff9c]/30 transition">
                Clear
            </a>
        @endif
    </form>

    @if($search)
        <div class="flex items-center gap-2 text-sm">
            <span class="text-gray-400">Search results for:</span>
            <span class="text-white font-semibold">"{{ $search }}"</span>
            <span class="text-gray-500">({{ $stocks->total() }} {{ $stocks->total() === 1 ? 'result' : 'results' }})</span>
        </div>
    @endif

    <div class="rounded-[32px] border border-[#101010] bg-[#040404] overflow-hidden">
        <div class="grid grid-cols-12 px-4 py-3 text-xs uppercase tracking-wide text-gray-500 border-b border-[#121212]">
            <span class="col-span-4">Symbol</span>
            <span class="col-span-3 text-right">Price</span>
            <span class="col-span-3 text-right">24h Change</span>
            <span class="col-span-2 text-right">Updated</span>
        </div>
        <div class="divide-y divide-[#0d0d0d]">
            @foreach($stocks as $stock)
                @php
                    $isPositive = (float) $stock->price_change_24h >= 0;
                @endphp
                <a href="{{ route('user.liveTrading.trade', ['asset_type' => 'stock', 'symbol' => $stock->symbol]) }}" class="grid grid-cols-12 items-center px-4 py-4 text-sm hover:bg-[#0a0a0a] transition-colors cursor-pointer">
                    <div class="col-span-4">
                        <p class="font-semibold">{{ $stock->symbol }}</p>
                        <p class="text-xs text-gray-500">{{ $stock->name }}</p>
                    </div>
                    <div class="col-span-3 text-right font-semibold">
                        ${{ number_format((float) $stock->current_price, 2) }}
                    </div>
                    <div class="col-span-3 text-right">
                        <span class="inline-flex items-center justify-end gap-1 rounded-full px-3 py-1 text-xs font-semibold {{ $isPositive ? 'bg-[#0f2b14] text-[#00ff5f]' : 'bg-[#2b0f0f] text-[#ff4d4d]' }}">
                            {{ $isPositive ? '+' : '' }}{{ number_format((float) $stock->price_change_24h, 2) }}%
                        </span>
                    </div>
                    <div class="col-span-2 text-right text-xs text-gray-500">
                        {{ optional($stock->updated_at)->diffForHumans() ?? '—' }}
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <div class="flex items-center justify-between text-xs text-gray-500">
        <span>Showing {{ $stocks->firstItem() }}-{{ $stocks->lastItem() }} of {{ $stocks->total() }}</span>
        <div class="flex gap-2">
            @if($stocks->onFirstPage())
                <span class="rounded-full border border-[#1f1f1f] px-3 py-1 opacity-50">Prev</span>
            @else
                <a href="{{ $stocks->previousPageUrl() }}" class="rounded-full border border-[#1fff9c]/30 px-3 py-1 text-[#1fff9c]">Prev</a>
            @endif
            @if($stocks->hasMorePages())
                <a href="{{ $stocks->nextPageUrl() }}" class="rounded-full border border-[#1fff9c]/30 px-3 py-1 text-[#1fff9c]">Next</a>
            @else
                <span class="rounded-full border border-[#1f1f1f] px-3 py-1 opacity-50">Next</span>
            @endif
        </div>
    </div>
</div>
@endsection
