<?php

namespace App\Http\Controllers;

use App\Models\LiveTrade;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LiveTradingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $liveTrades = $user->liveTrades()->latest()->get();
        $cryptoAssets = Asset::where('type', 'crypto')->get();
        $stockAssets = Asset::where('type', 'stock')->get();
        $forexAssets = collect([
            // Major Pairs
            ['symbol' => 'EUR/USD', 'name' => 'Euro / US Dollar'],
            ['symbol' => 'GBP/USD', 'name' => 'British Pound / US Dollar'],
            ['symbol' => 'USD/JPY', 'name' => 'US Dollar / Japanese Yen'],
            ['symbol' => 'USD/CHF', 'name' => 'US Dollar / Swiss Franc'],
            ['symbol' => 'AUD/USD', 'name' => 'Australian Dollar / US Dollar'],
            ['symbol' => 'USD/CAD', 'name' => 'US Dollar / Canadian Dollar'],
            ['symbol' => 'NZD/USD', 'name' => 'New Zealand Dollar / US Dollar'],
            
            // Cross Pairs
            ['symbol' => 'EUR/GBP', 'name' => 'Euro / British Pound'],
            ['symbol' => 'EUR/JPY', 'name' => 'Euro / Japanese Yen'],
            ['symbol' => 'GBP/JPY', 'name' => 'British Pound / Japanese Yen'],
            ['symbol' => 'EUR/CHF', 'name' => 'Euro / Swiss Franc'],
            ['symbol' => 'GBP/CHF', 'name' => 'British Pound / Swiss Franc'],
            ['symbol' => 'AUD/JPY', 'name' => 'Australian Dollar / Japanese Yen'],
            ['symbol' => 'CAD/JPY', 'name' => 'Canadian Dollar / Japanese Yen'],
            ['symbol' => 'NZD/JPY', 'name' => 'New Zealand Dollar / Japanese Yen'],
            
            // Commodity Pairs
            ['symbol' => 'AUD/CAD', 'name' => 'Australian Dollar / Canadian Dollar'],
            ['symbol' => 'AUD/CHF', 'name' => 'Australian Dollar / Swiss Franc'],
            ['symbol' => 'AUD/NZD', 'name' => 'Australian Dollar / New Zealand Dollar'],
            ['symbol' => 'CAD/CHF', 'name' => 'Canadian Dollar / Swiss Franc'],
            ['symbol' => 'EUR/AUD', 'name' => 'Euro / Australian Dollar'],
            ['symbol' => 'EUR/CAD', 'name' => 'Euro / Canadian Dollar'],
            ['symbol' => 'GBP/AUD', 'name' => 'British Pound / Australian Dollar'],
            ['symbol' => 'GBP/CAD', 'name' => 'British Pound / Canadian Dollar'],
            ['symbol' => 'GBP/NZD', 'name' => 'British Pound / New Zealand Dollar'],
            
            // Exotic Pairs
            ['symbol' => 'USD/SEK', 'name' => 'US Dollar / Swedish Krona'],
            ['symbol' => 'USD/NOK', 'name' => 'US Dollar / Norwegian Krone'],
            ['symbol' => 'USD/DKK', 'name' => 'US Dollar / Danish Krone'],
            ['symbol' => 'USD/PLN', 'name' => 'US Dollar / Polish Zloty'],
            ['symbol' => 'USD/CZK', 'name' => 'US Dollar / Czech Koruna'],
            ['symbol' => 'USD/HUF', 'name' => 'US Dollar / Hungarian Forint'],
            ['symbol' => 'USD/TRY', 'name' => 'US Dollar / Turkish Lira'],
            ['symbol' => 'USD/ZAR', 'name' => 'US Dollar / South African Rand'],
            ['symbol' => 'USD/MXN', 'name' => 'US Dollar / Mexican Peso'],
            ['symbol' => 'USD/BRL', 'name' => 'US Dollar / Brazilian Real'],
            ['symbol' => 'USD/INR', 'name' => 'US Dollar / Indian Rupee'],
            ['symbol' => 'USD/SGD', 'name' => 'US Dollar / Singapore Dollar'],
            ['symbol' => 'USD/HKD', 'name' => 'US Dollar / Hong Kong Dollar'],
            ['symbol' => 'USD/KRW', 'name' => 'US Dollar / South Korean Won'],
            ['symbol' => 'USD/CNY', 'name' => 'US Dollar / Chinese Yuan'],
            
            // Additional Cross Pairs
            ['symbol' => 'CHF/JPY', 'name' => 'Swiss Franc / Japanese Yen'],
            ['symbol' => 'NZD/CHF', 'name' => 'New Zealand Dollar / Swiss Franc'],
            ['symbol' => 'CAD/AUD', 'name' => 'Canadian Dollar / Australian Dollar'],
            ['symbol' => 'EUR/NZD', 'name' => 'Euro / New Zealand Dollar'],
            ['symbol' => 'GBP/CHF', 'name' => 'British Pound / Swiss Franc'],
        ]);
        
        return view('dashboard.live-trading.index', compact(
            'liveTrades',
            'cryptoAssets',
            'stockAssets',
            'forexAssets'
        ));
    }

    public function trade(Request $request)
    {
        $assetType = $request->get('asset_type');
        $symbol = $request->get('symbol');
        
        // Get asset details
        if ($assetType === 'crypto' || $assetType === 'stock') {
            $asset = Asset::where('symbol', $symbol)->first();
            if (!$asset) {
                abort(404, 'Asset not found');
            }
        } else {
            // For forex, create a mock asset
            $asset = [
                'symbol' => $symbol,
                'name' => $symbol,
                'current_price' => rand(100, 200) / 100,
                'price_change_24h' => rand(-50, 50) / 10
            ];
        }
        
        if ($assetType === 'stock') {
            return view('dashboard.live-trading.stock', compact('asset', 'assetType'));
        }

        return view('dashboard.live-trading.trade', compact('asset', 'assetType'));
    }

    public function store(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'asset_type' => 'required|string|in:crypto,stock,forex',
            'symbol' => 'required|string|max:20',
            'order_type' => 'required|string|in:limit,market',
            'side' => 'required|string|in:buy,sell',
            'quantity' => 'nullable|numeric|min:0.00000001',
            'price' => 'nullable|numeric|min:0.00000001',
            'amount' => 'required|numeric|min:1',
            'leverage' => 'nullable|numeric|min:1|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        
        // Check if user has sufficient trading balance
        if ($request->amount > $user->trading_balance) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient trading balance. You need at least $' . number_format($request->amount, 2) . ' in your trading balance.'
            ], 400);
        }

        try {
            // For limit orders, validate quantity and price
            if ($request->order_type === 'limit') {
                if (!$request->quantity || !$request->price) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Price and quantity are required for limit orders.'
                    ], 400);
                }
            }

            $liveTrade = LiveTrade::create([
                'user_id' => $user->id,
                'asset_type' => $request->asset_type,
                'symbol' => $request->symbol,
                'order_type' => $request->order_type,
                'side' => $request->side,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'amount' => $request->amount,
                'leverage' => $request->leverage ?? 1.00,
                'status' => 'pending'
            ]);

            // Deduct amount from trading balance
            $user->decrement('trading_balance', $request->amount);

            return response()->json([
                'success' => true,
                'message' => 'Trade order placed successfully!',
                'trade' => $liveTrade
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to place trade: ' . $e->getMessage()
            ], 500);
        }
    }

    public function cancel(LiveTrade $liveTrade)
    {
        if ($liveTrade->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access to this trade.'
            ], 403);
        }

        if (!$liveTrade->isPending()) {
            return response()->json([
                'success' => false,
                'message' => 'Only pending trades can be cancelled.'
            ], 400);
        }

        try {
            $liveTrade->update(['status' => 'cancelled']);
            
            // Refund the amount to trading balance
            $user = Auth::user();
            $user->increment('trading_balance', $liveTrade->amount);

            return response()->json([
                'success' => true,
                'message' => 'Trade cancelled successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel trade: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getPrice(Request $request)
    {
        $assetType = $request->input('asset_type');
        $symbol = $request->input('symbol');
        
        if ($assetType === 'crypto' || $assetType === 'stock') {
            $asset = Asset::where('type', $assetType)
                ->where('symbol', $symbol)
                ->first();
                
            if ($asset) {
                return response()->json([
                    'success' => true,
                    'price' => $asset->current_price,
                    'change_24h' => $asset->price_change_24h
                ]);
            }
        } else {
            // For forex, return a mock price
            $mockPrice = rand(100, 200) / 100;
            return response()->json([
                'success' => true,
                'price' => $mockPrice,
                'change_24h' => rand(-50, 50) / 10
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Asset not found'
        ], 404);
    }
    
    /**
     * Refresh all asset prices with real-time data
     */
    public function refreshPrices(Request $request)
    {
        try {
            $priceService = new \App\Services\AssetPriceService();
            
            // Update crypto prices
            $priceService->updateCryptoPrices();
            
            // Update stock prices
            $priceService->updateStockPrices();
            
            return response()->json([
                'success' => true,
                'message' => 'Asset prices refreshed successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to refresh prices: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Show trading history with open and closed trades
     */
    public function history()
    {
        $user = Auth::user();
        
        $openTrades = LiveTrade::where('user_id', $user->id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $closedTrades = LiveTrade::where('user_id', $user->id)
            ->whereIn('status', ['filled', 'cancelled'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('dashboard.live-trading.history', compact('openTrades', 'closedTrades'));
    }
}
