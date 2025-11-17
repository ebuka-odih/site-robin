<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Trade;
use App\Models\LiveTrade;
use App\Models\TradePair;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $completedLiveTrades = LiveTrade::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'filled', 'closed'])
            ->orderBy('created_at')
            ->get();

        $livePortfolio = [];
        foreach ($completedLiveTrades as $trade) {
            $symbol = strtoupper($trade->symbol);
            $quantity = (float) ($trade->quantity ?? 0);
            if ($quantity <= 0) {
                $priceForQuantity = (float) ($trade->price ?? $trade->entry_price ?? 0);
                if ($priceForQuantity > 0 && $trade->amount) {
                    $quantity = (float) $trade->amount / $priceForQuantity;
                }
            }
            if ($quantity <= 0) {
                continue;
            }
            $cost = (float) ($trade->amount ?? ($quantity * ($trade->price ?? $trade->entry_price ?? 0)));
            if (!isset($livePortfolio[$symbol])) {
                $livePortfolio[$symbol] = [
                    'symbol' => $symbol,
                    'quantity' => 0,
                    'cost' => 0,
                ];
            }
            if ($trade->side === 'buy') {
                $livePortfolio[$symbol]['quantity'] += $quantity;
                $livePortfolio[$symbol]['cost'] += $cost;
            } else {
                $existingQty = $livePortfolio[$symbol]['quantity'];
                if ($existingQty <= 0) {
                    continue;
                }
                $qtyToRemove = min($quantity, $existingQty);
                $avgCost = $livePortfolio[$symbol]['cost'] / max($existingQty, 0.0000001);
                $livePortfolio[$symbol]['quantity'] = max($existingQty - $qtyToRemove, 0);
                $livePortfolio[$symbol]['cost'] = max($livePortfolio[$symbol]['cost'] - ($avgCost * $qtyToRemove), 0);
            }
        }
        $livePortfolio = array_filter($livePortfolio, fn ($position) => $position['quantity'] > 0 && $position['cost'] > 0);

        if (!empty($livePortfolio)) {
            $symbols = array_keys($livePortfolio);
            $assetPrices = Asset::whereIn('symbol', $symbols)->get()->keyBy('symbol');
            $totalCostBasis = 0;
            $totalGain = 0;

            foreach ($livePortfolio as $symbol => &$position) {
                $assetPrice = optional($assetPrices->get($symbol))->current_price;
                $currentPrice = $assetPrice !== null
                    ? (float) $assetPrice
                    : ($position['quantity'] > 0 ? $position['cost'] / $position['quantity'] : 0);
                $position['current_value'] = $currentPrice * $position['quantity'];
                $position['gain'] = $position['current_value'] - $position['cost'];
                $position['gain_percent'] = $position['cost'] > 0
                    ? ($position['gain'] / $position['cost']) * 100
                    : 0;
                $totalCostBasis += $position['cost'];
                $totalGain += $position['gain'];
            }
            unset($position);

            $gainPercent = $totalCostBasis > 0 ? ($totalGain / $totalCostBasis) * 100 : 0;
            $investingBalanceRaw = $totalCostBasis;
            $investingBalanceFormatted = $user->formatAmount($investingBalanceRaw);
            $investingChangeText = sprintf('%s (%+.2f%%)', $user->formatAmount($totalGain), $gainPercent);
            $investingIsPositive = $totalGain >= 0;
        } else {
            $liveTradeInvested = LiveTrade::where('user_id', $user->id)
                ->where('side', 'buy')
                ->whereNotIn('status', ['cancelled'])
                ->sum('amount');
            $investingBalanceRaw = $liveTradeInvested;
            $investingBalanceFormatted = $user->formatAmount($investingBalanceRaw);
            $investingChangeText = $liveTradeInvested > 0 ? 'Total spent on orders' : 'No holdings yet';
            $investingIsPositive = true;
        }
        
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
        
        // Get recent transactions for activity feed
        $recentTransactions = $user->holdingTransactions()
            ->with('asset')
            ->latest()
            ->take(5)
            ->get();
        
        // Get recent activity (deposits, withdrawals, trades)
        $recentDeposits = $user->deposits()
            ->where('status', 1) // Only approved deposits
            ->latest()
            ->take(3)
            ->get()
            ->map(function($deposit) use ($user) {
                return [
                    'type' => 'deposit',
                    'title' => 'Deposit',
                    'amount' => $deposit->amount,
                    'formatted_amount' => $user->formatAmount($deposit->amount),
                    'created_at' => $deposit->created_at,
                    'time_ago' => $deposit->created_at->diffForHumans(),
                ];
            });
        
        $recentWithdrawals = $user->withdrawals()
            ->where('status', 1) // Only approved withdrawals
            ->latest()
            ->take(3)
            ->get()
            ->map(function($withdrawal) use ($user) {
                return [
                    'type' => 'withdrawal',
                    'title' => 'Withdrawal',
                    'amount' => -$withdrawal->amount,
                    'formatted_amount' => $user->formatAmount($withdrawal->amount),
                    'created_at' => $withdrawal->created_at,
                    'time_ago' => $withdrawal->created_at->diffForHumans(),
                ];
            });
        
        $recentClosedTrades = $closedTrades
            ->take(3)
            ->map(function($trade) use ($user) {
                return [
                    'type' => $trade->profit_loss >= 0 ? 'trade_profit' : 'trade_loss',
                    'title' => $trade->profit_loss >= 0 ? 'Trade Profit' : 'Trade Loss',
                    'amount' => $trade->profit_loss,
                    'formatted_amount' => $user->formatAmount(abs($trade->profit_loss)),
                    'created_at' => $trade->updated_at,
                    'time_ago' => $trade->updated_at->diffForHumans(),
                ];
            });
        
        // Combine and sort all activities by date
        $recentActivity = collect()
            ->merge($recentDeposits)
            ->merge($recentWithdrawals)
            ->merge($recentClosedTrades)
            ->sortByDesc('created_at')
            ->take(5)
            ->values();
        
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

        $preferredStocks = Asset::where('type', 'stock')
            ->whereIn('symbol', $topSymbols)
            ->get()
            ->sortBy(function ($asset) use ($topSymbols) {
                return array_search($asset->symbol, $topSymbols);
            })
            ->values();

        if ($preferredStocks->count() < 12) {
            $additionalNeeded = 12 - $preferredStocks->count();
            $additionalStocks = Asset::where('type', 'stock')
                ->whereNotIn('id', $preferredStocks->pluck('id'))
                ->orderByDesc('price_change_24h')
                ->take($additionalNeeded)
                ->get();

            $stockAssets = $preferredStocks->merge($additionalStocks);
        } else {
            $stockAssets = $preferredStocks;
        }
        $accountTabs = [
            [
                'id' => 'investing',
                'label' => 'Investing',
                'balance' => $investingBalanceFormatted,
                'change' => $investingChangeText,
                'isPositive' => $investingIsPositive,
            ],
            [
                'id' => 'pnl',
                'label' => 'PNL',
                'balance' => $user->formatAmount($user->profit ?? 0),
                'change' => ($user->profit ?? 0) >= 0 ? 'Total profit' : 'Total loss',
                'isPositive' => ($user->profit ?? 0) >= 0,
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
            'recentActivity' => $recentActivity,
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
        $stockAssets = Asset::where('type', 'stock')
            ->orderByDesc('price_change_24h')
            ->take(12)
            ->get();
        $cryptoAssets = Asset::where('type', 'crypto')
            ->orderByDesc('market_cap')
            ->take(12)
            ->get();
        $tradeHistory = LiveTrade::where('user_id', $user->id)
            ->latest()
            ->take(6)
            ->get();
        return view('dashboard.nav.trade', compact('user', 'stockAssets', 'cryptoAssets', 'tradeHistory'));
    }

    public function assetsDirectory(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');
        $type = $request->input('type', 'stock');
        if (!in_array($type, ['stock', 'crypto'])) {
            $type = 'stock';
        }

        $assets = Asset::where('type', $type)
            ->when($search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('symbol', 'like', '%' . $search . '%')
                      ->orWhere('name', 'like', '%' . $search . '%');
                });
            })
            ->orderByDesc('market_cap')
            ->orderByDesc('price_change_24h')
            ->paginate(30)
            ->appends([
                'search' => $search,
                'type' => $type,
            ]);

        return view('dashboard.nav.assets', [
            'user' => $user,
            'assets' => $assets,
            'search' => $search,
            'type' => $type,
        ]);
    }

    public function wallet()
    {
        $user = Auth::user();
        $portfolioTransactions = $user->holdingTransactions()
            ->with('asset')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($transaction) {
                $isBuy = strtolower($transaction->type ?? '') === 'buy';
                $amount = (float) ($transaction->total_amount ?? 0);

                return [
                    'label' => ucfirst($transaction->type ?? 'Trade'),
                    'subtext' => $transaction->asset->symbol ?? 'Portfolio',
                    'amount' => $isBuy ? -abs($amount) : abs($amount),
                    'timestamp' => $transaction->created_at,
                ];
            });

        $depositTransactions = $user->deposits()
            ->with('payment_method')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($deposit) {
                $methodLabel = optional($deposit->payment_method)->name
                    ?? Str::title($deposit->wallet_type ?? 'Wallet');

                return [
                    'label' => 'Deposit',
                    'subtext' => $methodLabel,
                    'amount' => (float) $deposit->amount,
                    'timestamp' => $deposit->created_at,
                ];
            });

        $withdrawalTransactions = $user->withdrawals()
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($withdrawal) {
                return [
                    'label' => 'Withdrawal',
                    'subtext' => Str::title($withdrawal->payment_method ?? 'Wallet'),
                    'amount' => -(float) $withdrawal->amount,
                    'timestamp' => $withdrawal->created_at,
                ];
            });

        $recentMovements = collect()
            ->merge($portfolioTransactions)
            ->merge($depositTransactions)
            ->merge($withdrawalTransactions)
            ->sortByDesc('timestamp')
            ->take(6)
            ->values();

        return view('dashboard.nav.wallet', [
            'user' => $user,
            'recentMovements' => $recentMovements,
        ]);
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
