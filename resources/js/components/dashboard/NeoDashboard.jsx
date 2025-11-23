import React, { useState } from 'react';
import PortfolioChart from './PortfolioChart';
import AccountCards from './AccountCards';
import BalanceSection from './BalanceSection';
import BuyingPowerSection from './BuyingPowerSection';
import Watchlist from './Watchlist';
import RecentActivity from './RecentActivity';
import TradingViewNewsWidget from './TradingViewNewsWidget';
import { formatCurrency } from './utils';

const NeoDashboard = ({
    user = {},
    accountTabs = [],
    chartData = {},
    watchlist = [],
    activity = [],
    openTrades = [],
    news = [],
    routes = {},
}) => {
    // Find Investing, PNL, and Wallet Balance tabs from accountTabs
    const investingTab = accountTabs.find((tab) => tab.id === 'investing') || accountTabs[0] || {
        id: 'investing',
        label: 'Investing',
        balance: '$0.00',
        change: '+0.00%',
        isPositive: true,
    };
    const pnlTab = accountTabs.find((tab) => tab.id === 'pnl') || {
        id: 'pnl',
        label: 'PNL',
        balance: '$0.00',
        change: '+0.00%',
        isPositive: true,
    };
    const walletTab = accountTabs.find((tab) => tab.id === 'wallet') || {
        id: 'wallet',
        label: 'Wallet Balance',
        balance: '$0.00',
        change: '+0.00%',
        isPositive: true,
    };

    // Get total balance (from user.total_balance or sum all balances)
    const totalBalance = user.total_balance 
        ? formatCurrency(user.total_balance)
        : (investingTab.balance || accountTabs[0]?.balance || walletTab.balance || '$0.00');
    
    // Get profit from PNL tab
    const profit = pnlTab.balance || formatCurrency(user.pnl || 0);
    const profitChange = pnlTab.change || '+0.00%';
    const profitIsPositive = pnlTab.isPositive ?? true;
    
    const buyingPower = user.buying_power ?? formatCurrency(user.buying_power || 0);

    // Calculate portfolio value (balance + profit) for chart
    const portfolioValue = user.total_balance 
        ? user.total_balance 
        : (parseFloat(investingTab.balance?.replace(/[^0-9.-]+/g, '') || '0') + 
           parseFloat(user.pnl || 0) || 0);
    
    // Extract numeric balance for chart (use total portfolio value: balance + profit)
    const currentBalanceValue = typeof portfolioValue === 'number' 
        ? portfolioValue 
        : parseFloat(
            String(portfolioValue).replace(/[^0-9.-]+/g, '') || '0'
        ) || 0;

    // Timeframe buttons
    const timeframes = ['LIVE', '1D', '1W', '1M', '3M', 'YTD', '1Y'];

    // State for balance visibility
    const [isBalanceHidden, setIsBalanceHidden] = useState(false);

    // Toggle balance visibility
    const toggleBalanceVisibility = (e) => {
        e.stopPropagation();
        setIsBalanceHidden(!isBalanceHidden);
    };

    return (
        <div className="min-h-screen bg-black text-white px-2 sm:px-4 py-3 space-y-3 sm:space-y-4 w-full">
            {/* Header */}
            <div>
                <p className="text-xs font-semibold text-[#00ff63] uppercase tracking-widest">
                    Smart Trader
                </p>
                <h1 className="text-2xl font-bold text-white mt-0.5">
                    {user.greeting ??
                        `Welcome back, ${user.name ?? 'Trader'}!`}
                </h1>
            </div>

            {/* Investing and PNL Cards */}
            <AccountCards
                investingTab={investingTab}
                pnlTab={pnlTab}
                isBalanceHidden={isBalanceHidden}
                onToggleBalanceVisibility={toggleBalanceVisibility}
            />

            {/* BALANCE Section */}
            <BalanceSection
                totalBalance={totalBalance}
                isBalanceHidden={isBalanceHidden}
            />

            {/* Portfolio Chart Component */}
            <PortfolioChart
                chartData={chartData}
                currentBalance={currentBalanceValue}
                timeframes={timeframes}
            />

            {/* BUYING POWER Section */}
            <BuyingPowerSection
                buyingPower={buyingPower}
                isBalanceHidden={isBalanceHidden}
            />

            {/* WATCHLIST Section */}
            <Watchlist watchlist={watchlist} />

            {/* RECENT ACTIVITY Section */}
            <RecentActivity activity={activity} />

            {/* TradingView News Widget Section */}
            <TradingViewNewsWidget />
        </div>
    );
};

export default NeoDashboard;