<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Trade;
use App\Models\TradePair;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get user's trades
        $trades = Trade::whereUserId($user->id)->latest()->get();
        $openTrades = $trades->filter(function($trade) {
            return $trade->status === 'open';
        });
        $closedTrades = $trades->filter(function($trade) {
            return $trade->status === 'closed';
        });
        
        // Get user's active subscriptions/plans
        $activePlans = $user->activeUserPlans()->with('plan')->get();
        $tradingPlans = $activePlans->filter(function($plan) {
            return $plan->plan && $plan->plan->type === 'trading';
        })->count();
        $signalPlans = $activePlans->filter(function($plan) {
            return $plan->plan && $plan->plan->type === 'signal';
        })->count();
        $stakingPlans = $activePlans->filter(function($plan) {
            return $plan->plan && $plan->plan->type === 'staking';
        })->count();
        $miningPlans = $activePlans->filter(function($plan) {
            return $plan->plan && $plan->plan->type === 'mining';
        })->count();
        
        // Get user's holdings data
        $holdings = $user->holdings()->with('asset')->get();
        $totalHoldingsValue = $holdings->sum('current_value');
        $totalInvestedInStocks = $holdings->sum('total_invested');
        $totalStockPnl = $holdings->sum('unrealized_pnl');
        $currentHoldingsValue = $holdings->sum('current_value');
        $investingChangePercent = $totalInvestedInStocks > 0
            ? (($currentHoldingsValue - $totalInvestedInStocks) / $totalInvestedInStocks) * 100
            : 0;
        
        // Get bot trading data
        $botTradings = $user->botTradings()->get();
        $activeBots = $botTradings->filter(function($bot) {
            return $bot->status === 'active';
        })->count();
        $totalBotProfit = $botTradings->sum('total_profit');
        
        // Calculate trading performance metrics
        $totalTrades = $trades->count();
        $winningTrades = $closedTrades->filter(function($trade) {
            return $trade->profit_loss > 0;
        })->count();
        $winRate = $totalTrades > 0 ? ($winningTrades / $totalTrades) * 100 : 0;
        $avgProfit = $closedTrades->count() > 0 ? $closedTrades->avg('profit_loss') : 0;
        
        // Get recent transactions
        $recentTransactions = $user->holdingTransactions()
            ->with('asset')
            ->latest()
            ->take(5)
            ->get();
        
        // Get copy trading data
        $copyTrades = $user->copiedTrades()->get();
        $activeCopyTrades = $copyTrades->filter(function($copy) {
            return $copy->status == 1;
        })->count();
        
        $topSymbols = [
            'AAPL', 'NVDA', 'AMZN', 'TSLA', 'MSFT',
            'META', 'GOOGL', 'NFLX', 'ADBE', 'PEP',
            'DIS', 'LLY', 'COST', 'BRK.A', 'JNJ'
        ];

        $stockAssets = Asset::where('type', 'stock')
            ->whereIn('symbol', $topSymbols)
            ->get()
            ->sortBy(function ($asset) use ($topSymbols) {
                return array_search($asset->symbol, $topSymbols);
            })
            ->values();
        $accountTabs = [
            [
                'id' => 'investing',
                'label' => 'Investing',
                'balance' => $user->formatAmount($totalInvestedInStocks),
                'change' => $totalInvestedInStocks > 0
                    ? sprintf('%+.2f%% overall', $investingChangePercent)
                    : 'No holdings yet',
                'isPositive' => $investingChangePercent >= 0,
            ],
            [
                'id' => 'pnl',
                'label' => 'PNL',
                'balance' => $user->formatAmount($totalStockPnl),
                'change' => $totalInvestedInStocks > 0
                    ? ($totalStockPnl >= 0 ? 'Total unrealized profit' : 'Total unrealized loss')
                    : 'No holdings yet',
                'isPositive' => $totalStockPnl >= 0,
            ],
            [
                'id' => 'wallet',
                'label' => 'Wallet Balance',
                'balance' => $user->formatAmount($user->balance ?? 0),
                'change' => 'Available to invest',
                'isPositive' => true,
            ],
        ];

        $dashboardData = [
            'user' => $user,
            'trades' => $trades,
            'openTrades' => $openTrades,
            'closedTrades' => $closedTrades,
            'totalTrades' => $totalTrades,
            'winningTrades' => $winningTrades,
            'winRate' => $winRate,
            'avgProfit' => $avgProfit,
            'activePlans' => $activePlans,
            'tradingPlans' => $tradingPlans,
            'signalPlans' => $signalPlans,
            'stakingPlans' => $stakingPlans,
            'miningPlans' => $miningPlans,
            'totalPlans' => $activePlans->count(),
            'holdings' => $holdings,
            'totalHoldingsValue' => $totalHoldingsValue,
            'botTradings' => $botTradings,
            'activeBots' => $activeBots,
            'totalBotProfit' => $totalBotProfit,
            'recentTransactions' => $recentTransactions,
            'copyTrades' => $copyTrades,
            'activeCopyTrades' => $activeCopyTrades,
            'stockAssets' => $stockAssets,
            'accountTabs' => $accountTabs,
        ];
        
        return view('dashboard.new-index', $dashboardData);
    }

    public function tradeHub()
    {
        $user = Auth::user();
        $stockAssets = Asset::where('type', 'stock')->orderByDesc('price_change_24h')->take(6)->get();
        $cryptoAssets = Asset::where('type', 'crypto')->orderByDesc('price_change_24h')->take(6)->get();
        return view('dashboard.nav.trade', compact('user', 'stockAssets', 'cryptoAssets'));
    }

    public function stocksDirectory()
    {
        $user = Auth::user();
        $stocks = Asset::where('type', 'stock')
            ->orderByDesc('market_cap')
            ->orderByDesc('price_change_24h')
            ->paginate(30);

        return view('dashboard.nav.stocks', compact('user', 'stocks'));
    }

    public function wallet()
    {
        $user = Auth::user();
        $recentTransactions = $user->holdingTransactions()->with('asset')->latest()->take(5)->get();
        return view('dashboard.nav.wallet', compact('user', 'recentTransactions'));
    }

    public function profileOverview()
    {
        $user = Auth::user();
        return view('dashboard.nav.profile', compact('user'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('dashboard.profile', compact('user'));
    }

    public function updateProfile(Request $request, $id)
    {
        $validated = $request->validate([
           'name' => 'nullable|string|max:255',
           'phone' => 'nullable|string|max:20',
           'telegram' => 'nullable|string|max:255',
           'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $user = User::findOrFail($id);
        
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            // Store new avatar
            $avatarPath = $request->file('avatar')->store('files', 'public');
            $validated['avatar'] = $avatarPath;
        }
        
        $user->update($validated);
        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('status', 'Password updated successfully!');
    }

    public function loading()
    {
        return view('dashboard.loading');
    }
}
