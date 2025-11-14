@extends('dashboard.new-layout')

@section('content')
<div class="space-y-8 text-white">
    <div class="flex flex-col gap-1">
        <p class="text-xs uppercase tracking-wide text-[#08f58d]">Market Watch</p>
        <h1 class="text-3xl font-semibold tracking-tight">All Stocks</h1>
        <p class="text-gray-400 text-sm">Live prices pulled from Finnhub are refreshed by the background scheduler.</p>
    </div>

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
                <div class="grid grid-cols-12 items-center px-4 py-4 text-sm">
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
                </div>
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
