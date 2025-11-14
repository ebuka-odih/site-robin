<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trade;
use App\Models\TradePair;
use App\Models\User;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    public function index()
    {
        $trades = Trade::all();
        $pairs = TradePair::all();
        $users = User::where('role', 'user')->get();
        return view('admin.trade.trade', compact('trades', 'pairs', 'users'));
    }

    public function store(Request $request)
    {

        $user = $request->get('user_id');
        $amount = $request->input('amount');

        $trade = Trade::create([
            'user_id' => $user,
            'amount' => $amount,
            'status' => 'open',
            'trade_pair_id' => $request->get('trade_pair_id'),
            'leverage' => $request->get('leverage'),
            'duration' => $request->get('duration'),
            'action_type' => $request->get('action_type'),
        ]);

        $user = User::findOrFail($user);
        $user->balance -= $trade->amount;
        $user->save();

        return redirect()->route('admin.openTrades')->with('success', 'Trade placed successfully!');
    }

    public function openTrades(){
        $trades = Trade::latest()->get();
        return view('admin.trade.open-trades', compact('trades'));
    }
    public function closedTrades(){
        $trades = Trade::orderBy('updated_at', 'desc')->get();
        return view('admin.trade.closed-trades', compact('trades'));
    }

    public function tradeHistory(){
        $openTrades = Trade::where('status', 'open')->latest()->get();
        $closedTrades = Trade::where('status', 'closed')->orderBy('updated_at', 'desc')->get();
        
        \Log::info('Trade History Data:', [
            'open_trades_count' => $openTrades->count(),
            'closed_trades_count' => $closedTrades->count(),
            'open_trades' => $openTrades->pluck('id', 'status'),
            'closed_trades' => $closedTrades->pluck('id', 'status')
        ]);
        
        return view('admin.trade.history', compact('openTrades', 'closedTrades'));
    }



    public function editPnl(Request $request, $id)
    {
        $request->validate([
            'profit_loss' => 'required|numeric'
        ]);

        $trade = Trade::findOrFail($id);
        $trade->profit_loss = $request->profit_loss;
        $trade->save();

        return response()->json(['success' => true, 'message' => 'PnL updated successfully']);
    }

    public function closeTrade(Request $request, $id)
    {
        $trade = Trade::findOrFail($id);
        
        if ($request->action == 'profit') {
            $trade->profit_loss = $request->get('profit_loss');
            $trade->status = 'closed';
            $trade->save();
            
            $user = User::find($trade->user_id);
            $user->balance += $trade->amount + $trade->profit_loss;
            $user->save();
        } else {
            $trade->profit_loss = $request->get('profit_loss');
            $trade->status = 'closed';
            $trade->save();
            
            $user = User::find($trade->user_id);
            $user->balance += $trade->amount + $trade->profit_loss;
            $user->save();
        }
        
        return redirect()->route('admin.closedTrades')->with('success', 'Trade closed successfully!');
    }

    public function destroy($id)
    {
        $trade = Trade::findOrFail($id);
        $trade->delete();
        return back()->with('success', 'Trade deleted successfully!');
    }

}
