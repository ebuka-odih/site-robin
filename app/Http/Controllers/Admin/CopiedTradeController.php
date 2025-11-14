<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CopiedTrade;
use Illuminate\Http\Request;

class CopiedTradeController extends Controller
{
    public function index()
    {
        $copiedTrades = CopiedTrade::with(['user', 'copy_trader'])->orderBy('created_at','desc')->paginate(20);
        return view('admin.copy-trade.index', compact('copiedTrades'));
    }

    public function editPnl(Request $request, $id)
    {
        $request->validate([
            'trade_count' => 'required|integer|min:0',
            'win' => 'required|integer|min:0',
            'loss' => 'required|integer|min:0',
            'pnl' => 'required|numeric',
        ]);

        $copiedTrade = CopiedTrade::findOrFail($id);
        
        // Calculate the PnL difference to add to user's account
        $oldPnL = $copiedTrade->pnl ?? 0;
        $newPnL = $request->pnl;
        $pnlDifference = $newPnL - $oldPnL;
        
        // Update the copied trade performance metrics
        $copiedTrade->update([
            'trade_count' => $request->trade_count,
            'win' => $request->win,
            'loss' => $request->loss,
            'pnl' => $request->pnl,
        ]);
        
        // Add PnL difference to user's trading account balance
        if ($pnlDifference != 0) {
            $user = $copiedTrade->user;
            $user->balance += $pnlDifference;
            $user->save();
            
            // Log the balance adjustment
            \Log::info("User {$user->id} balance adjusted by \${$pnlDifference} for copied trade {$copiedTrade->id}. New balance: \${$user->balance}");
        }

        return redirect()->back()->with('success', 'Performance metrics updated successfully! ' . 
            ($pnlDifference != 0 ? "User balance adjusted by $" . number_format($pnlDifference, 2) : ""));
    }

    public function activate($id)
    {
        $copiedTrade = CopiedTrade::findOrFail($id);
        $copiedTrade->update(['status' => 1]);
        
        // Send notification to user
        $copiedTrade->user->createNotification(
            'copy_trade_started',
            'Copy Trade Started',
            "Your copy trade with {$copiedTrade->copy_trader->name} has been started by admin.",
            [
                'copied_trade_id' => $copiedTrade->id,
                'trader_name' => $copiedTrade->copy_trader->name,
                'amount' => $copiedTrade->amount
            ]
        );
        
        return redirect()->back()->with('success', 'Copied trade activated successfully!');
    }

    public function deactivate($id)
    {
        $copiedTrade = CopiedTrade::findOrFail($id);
        
        // Transfer PnL to user's trading balance when stopping
        if ($copiedTrade->status == 1 && ($copiedTrade->pnl ?? 0) > 0) {
            $user = $copiedTrade->user;
            $pnlAmount = $copiedTrade->pnl;
            $user->balance += $pnlAmount;
            $user->save();
            
            // Reset PnL to 0 after transfer
            $copiedTrade->update([
                'status' => 0,
                'pnl' => 0,
                'stopped_at' => now()
            ]);
            
            // Send notification to user
            $copiedTrade->user->createNotification(
                'copy_trade_stopped',
                'Copy Trade Stopped',
                "Your copy trade with {$copiedTrade->copy_trader->name} has been stopped. PnL of $" . number_format($pnlAmount, 2) . " has been transferred to your balance.",
                [
                    'copied_trade_id' => $copiedTrade->id,
                    'trader_name' => $copiedTrade->copy_trader->name,
                    'amount' => $copiedTrade->amount,
                    'pnl_transferred' => $pnlAmount
                ]
            );
            
            \Log::info("Copied trade {$id} stopped. PnL of \${$pnlAmount} transferred to user {$user->id} balance. New balance: \${$user->balance}");
            
            return redirect()->back()->with('success', "Copied trade stopped successfully! PnL of $" . number_format($pnlAmount, 2) . " transferred to user's trading balance.");
        } else {
            $copiedTrade->update([
                'status' => 0,
                'stopped_at' => now()
            ]);
            
            // Send notification to user
            $copiedTrade->user->createNotification(
                'copy_trade_stopped',
                'Copy Trade Stopped',
                "Your copy trade with {$copiedTrade->copy_trader->name} has been stopped.",
                [
                    'copied_trade_id' => $copiedTrade->id,
                    'trader_name' => $copiedTrade->copy_trader->name,
                    'amount' => $copiedTrade->amount
                ]
            );
            
            return redirect()->back()->with('success', 'Copied trade stopped successfully!');
        }
    }

    public function destroy($id)
    {
        $copiedTrade = CopiedTrade::findOrFail($id);
        
        // Return the amount to user's balance if the trade was active
        if ($copiedTrade->status == 1) {
            $user = $copiedTrade->user;
            $user->balance += $copiedTrade->amount;
            $user->save();
        }
        
        $copiedTrade->delete();
        
        return redirect()->back()->with('success', 'Copied trade deleted successfully!');
    }
}
