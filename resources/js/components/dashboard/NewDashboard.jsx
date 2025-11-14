import React, { useState, useEffect } from 'react';

const NewDashboard = () => {
  // State for dashboard data
  const [dashboardData, setDashboardData] = useState({
    totalBalance: 0,
    walletBalance: 0,
    tradingBalance: 0,
    holdingsBalance: 0,
    stakingBalance: 0,
    profitBalance: 0,
    winRate: 0,
    totalTrades: 0,
    avgProfit: 0,
    totalPlans: 0,
    tradingPlans: 0,
    signalPlans: 0,
    stakingPlans: 0,
    miningPlans: 0,
    totalHoldingsValue: 0,
    holdingsCount: 0,
    recentTransactions: 0,
    activeBots: 0,
    totalBotProfit: 0,
    botCount: 0,
    activeCopyTrades: 0,
    copyTradeCount: 0
  });

  // State for trades data
  const [trades, setTrades] = useState({
    openTrades: [],
    closedTrades: []
  });

  // State for active tab
  const [activeTab, setActiveTab] = useState('openTrades');

  // Mock data initialization
  useEffect(() => {
    // In a real application, this data would come from an API
    setDashboardData({
      totalBalance: 12500.75,
      walletBalance: 3200.50,
      tradingBalance: 4500.25,
      holdingsBalance: 2800.00,
      stakingBalance: 1200.00,
      profitBalance: 800.00,
      winRate: 72.5,
      totalTrades: 128,
      avgProfit: 150.75,
      totalPlans: 5,
      tradingPlans: 2,
      signalPlans: 1,
      stakingPlans: 1,
      miningPlans: 1,
      totalHoldingsValue: 2800.00,
      holdingsCount: 7,
      recentTransactions: 12,
      activeBots: 3,
      totalBotProfit: 420.50,
      botCount: 5,
      activeCopyTrades: 2,
      copyTradeCount: 4
    });

    // Mock trades data
    setTrades({
      openTrades: [
        { id: 1, pair: 'BTC/USD', type: 'buy', amount: 0.5, leverage: 5, entryPrice: 42000, currentPnL: 125.75 },
        { id: 2, pair: 'ETH/USD', type: 'sell', amount: 2.3, leverage: 3, entryPrice: 2800, currentPnL: -45.20 },
        { id: 3, pair: 'SOL/USD', type: 'buy', amount: 15, leverage: 2, entryPrice: 120, currentPnL: 32.40 }
      ],
      closedTrades: [
        { id: 4, pair: 'ADA/USD', type: 'buy', amount: 1000, entryPrice: 0.52, exitPrice: 0.58, pnl: 60.00, date: '2023-06-15' },
        { id: 5, pair: 'DOT/USD', type: 'sell', amount: 50, entryPrice: 7.8, exitPrice: 7.2, pnl: -30.00, date: '2023-06-10' }
      ]
    });
  }, []);

  // Format currency
  const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
      minimumFractionDigits: 2
    }).format(amount);
  };

  // Format percentage
  const formatPercentage = (value) => {
    return value.toFixed(1) + '%';
  };

  return (
    <div className="space-y-6">
      {/* Page Header */}
      <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div>
          <h1 className="text-2xl font-bold text-white">Dashboard</h1>
          <p className="text-gray-400 mt-1">Welcome back, User!</p>
        </div>
      </div>

      {/* First Row: Balance & Trading Strength */}
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {/* Balance Card */}
        <div className="bg-gray-800 rounded-lg p-6 border border-gray-700 h-full">
          <div className="flex items-center justify-between mb-4">
            <h3 className="text-lg font-semibold text-white">Wallet Overview</h3>
            <div className="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
              <svg className="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
              </svg>
            </div>
          </div>

          {/* Total Balance */}
          <div className="mb-6">
            <div className="text-3xl font-bold text-white animate-pulse">{formatCurrency(dashboardData.totalBalance)}</div>
            <div className="text-sm text-gray-400">Total Portfolio Value</div>
          </div>

          {/* Balance Breakdown */}
          <div className="space-y-3 mb-4">
            <div className="flex justify-between items-center py-2 px-3 bg-gray-700 rounded-lg hover:bg-gray-600 transition-all duration-300 transform hover:scale-[1.02] cursor-pointer">
              <div className="flex items-center space-x-2">
                <div className="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                <span className="text-sm text-gray-300">Wallet Balance</span>
              </div>
              <span className="text-sm font-semibold text-white">{formatCurrency(dashboardData.walletBalance)}</span>
            </div>

            <div className="flex justify-between items-center py-2 px-3 bg-gray-700 rounded-lg hover:bg-gray-600 transition-all duration-300 transform hover:scale-[1.02] cursor-pointer">
              <div className="flex items-center space-x-2">
                <div className="w-3 h-3 bg-blue-500 rounded-full animate-pulse" style={{ animationDelay: '0.5s' }}></div>
                <span className="text-sm text-gray-300">Trading Balance</span>
              </div>
              <span className="text-sm font-semibold text-white">{formatCurrency(dashboardData.tradingBalance)}</span>
            </div>

            <div className="flex justify-between items-center py-2 px-3 bg-gray-700 rounded-lg hover:bg-gray-600 transition-all duration-300 transform hover:scale-[1.02] cursor-pointer">
              <div className="flex items-center space-x-2">
                <div className="w-3 h-3 bg-yellow-500 rounded-full animate-pulse" style={{ animationDelay: '1s' }}></div>
                <span className="text-sm text-gray-300">Holdings</span>
              </div>
              <span className="text-sm font-semibold text-white">{formatCurrency(dashboardData.holdingsBalance)}</span>
            </div>

            <div className="flex justify-between items-center py-2 px-3 bg-gray-700 rounded-lg hover:bg-gray-600 transition-all duration-300 transform hover:scale-[1.02] cursor-pointer">
              <div className="flex items-center space-x-2">
                <div className="w-3 h-3 bg-purple-500 rounded-full animate-pulse" style={{ animationDelay: '1.5s' }}></div>
                <span className="text-sm text-gray-300">Staking</span>
              </div>
              <span className="text-sm font-semibold text-white">{formatCurrency(dashboardData.stakingBalance)}</span>
            </div>

            <div className="flex justify-between items-center py-2 px-3 bg-gray-700 rounded-lg hover:bg-gray-600 transition-all duration-300 transform hover:scale-[1.02] cursor-pointer">
              <div className="flex items-center space-x-2">
                <div className="w-3 h-3 bg-emerald-500 rounded-full animate-pulse" style={{ animationDelay: '2s' }}></div>
                <span className="text-sm text-gray-300">Profit Balance</span>
              </div>
              <span className="text-sm font-semibold text-white">{formatCurrency(dashboardData.profitBalance)}</span>
            </div>
          </div>

          {/* Wallet Status */}
          <div className="border-t border-gray-700 pt-3">
            <div className="flex items-center justify-between text-xs">
              <span className="text-gray-400">Wallet Status</span>
              <span className="text-green-400 font-medium flex items-center">
                <span className="w-2 h-2 bg-green-400 rounded-full animate-pulse mr-1"></span>
                Active
              </span>
            </div>
            <div className="flex items-center justify-between text-xs mt-1">
              <span className="text-gray-400">Last Updated</span>
              <span className="text-gray-300">{new Date().toLocaleString()}</span>
            </div>
          </div>
        </div>

        {/* Trading Strength Card */}
        <div className="bg-gray-800 rounded-lg p-6 border border-gray-700 h-full flex flex-col">
          {/* Top Section: Trading Strength (Mobile: Full, Desktop: Top Half) */}
          <div className="lg:flex-1">
            <div className="flex items-center justify-between mb-4">
              <h3 className="text-lg font-semibold text-white">Trading Strength</h3>
              <div className="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center">
                <svg className="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                  <path fillRule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd"></path>
                </svg>
              </div>
            </div>
            <div className="mb-4">
              <div className="text-3xl font-bold text-purple-400">{formatPercentage(dashboardData.winRate)}</div>
              <div className="text-sm text-gray-400">
                {dashboardData.winRate >= 70 ? 'Strong Performance' : (dashboardData.winRate >= 50 ? 'Good Performance' : 'Learning Phase')}
              </div>
            </div>
            <div className="space-y-3">
              <div className="flex justify-between text-sm">
                <span className="text-gray-400">Win Rate</span>
                <span className="text-white">{formatPercentage(dashboardData.winRate)}</span>
              </div>
              <div className="flex justify-between text-sm">
                <span className="text-gray-400">Total Trades</span>
                <span className="text-white">{dashboardData.totalTrades}</span>
              </div>
              <div className="flex justify-between text-sm">
                <span className="text-gray-400">Avg. Profit</span>
                <span className={dashboardData.avgProfit >= 0 ? 'text-green-400' : 'text-red-400'}>
                  {dashboardData.avgProfit >= 0 ? '+' : ''}{formatCurrency(dashboardData.avgProfit)}
                </span>
              </div>
            </div>
          </div>

          {/* Bottom Section: Subscription State (Desktop Only) */}
          <div className="hidden lg:block lg:flex-1 lg:mt-6 lg:pt-6 lg:border-t lg:border-gray-700">
            <div className="flex items-center justify-between mb-3">
              <h4 className="text-sm font-semibold text-gray-300">Subscription Status</h4>
              <div className="w-6 h-6 bg-blue-500 rounded-lg flex items-center justify-center">
                <svg className="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                  <path fillRule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clipRule="evenodd"></path>
                </svg>
              </div>
            </div>
            <div className="space-y-2">
              <div className="flex justify-between text-xs">
                <span className="text-gray-400">Active Plans</span>
                <span className="text-green-400 font-semibold">{dashboardData.totalPlans}</span>
              </div>
              <div className="flex justify-between text-xs">
                <span className="text-gray-400">Premium Status</span>
                <span className="text-blue-400 font-semibold">{dashboardData.totalPlans > 0 ? 'Active' : 'Inactive'}</span>
              </div>
              <div className="flex justify-between text-xs">
                <span className="text-gray-400">Next Renewal</span>
                <span className="text-white">N/A</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Second Row: My Subscriptions */}
      <div className="mb-6 lg:hidden">
        {/* User Subscriptions Card */}
        <div className="bg-gray-800 rounded-lg p-6 border border-gray-700">
          <div className="flex items-center justify-between mb-4">
            <h3 className="text-lg font-semibold text-white">My Subscriptions</h3>
            <div className="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
              <svg className="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fillRule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clipRule="evenodd"></path>
              </svg>
            </div>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div className="flex justify-between text-sm">
              <span className="text-gray-400">Trading Plans</span>
              <span className="text-blue-400 font-semibold">{dashboardData.tradingPlans} Active</span>
            </div>
            <div className="flex justify-between text-sm">
              <span className="text-gray-400">Signal Plans</span>
              <span className="text-green-400 font-semibold">{dashboardData.signalPlans} Active</span>
            </div>
            <div className="flex justify-between text-sm">
              <span className="text-gray-400">Staking Plans</span>
              <span className="text-purple-400 font-semibold">{dashboardData.stakingPlans} Active</span>
            </div>
            <div className="flex justify-between text-sm">
              <span className="text-gray-400">Mining Plans</span>
              <span className="text-orange-400 font-semibold">{dashboardData.miningPlans} Active</span>
            </div>
          </div>
          <div className="mt-4 pt-3 border-t border-gray-700">
            <div className="flex justify-between text-sm">
              <span className="text-gray-400">Total Subscriptions</span>
              <span className="text-white font-semibold">{dashboardData.totalPlans} Active</span>
            </div>
          </div>
        </div>
      </div>

      {/* Second Row: Additional Insights */}
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {/* Holdings Overview */}
        <div className="bg-gray-800 rounded-lg p-6 border border-gray-700">
          <div className="flex items-center justify-between mb-4">
            <h3 className="text-lg font-semibold text-white">Holdings Overview</h3>
            <div className="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center">
              <svg className="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
              </svg>
            </div>
          </div>
          <div className="space-y-3">
            <div className="flex justify-between text-sm">
              <span className="text-gray-400">Total Value</span>
              <span className="text-white font-semibold">{formatCurrency(dashboardData.totalHoldingsValue)}</span>
            </div>
            <div className="flex justify-between text-sm">
              <span className="text-gray-400">Assets Held</span>
              <span className="text-white">{dashboardData.holdingsCount}</span>
            </div>
            <div className="flex justify-between text-sm">
              <span className="text-gray-400">Recent Activity</span>
              <span className="text-white">{dashboardData.recentTransactions}</span>
            </div>
          </div>
          <div className="mt-4 pt-3 border-t border-gray-700">
            <a href="#" className="text-blue-400 hover:text-blue-300 text-sm font-medium">
              View All Holdings →
            </a>
          </div>
        </div>

        {/* Bot Trading Overview */}
        <div className="bg-gray-800 rounded-lg p-6 border border-gray-700">
          <div className="flex items-center justify-between mb-4">
            <h3 className="text-lg font-semibold text-white">Bot Trading</h3>
            <div className="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center">
              <svg className="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fillRule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clipRule="evenodd"></path>
              </svg>
            </div>
          </div>
          <div className="space-y-3">
            <div className="flex justify-between text-sm">
              <span className="text-gray-400">Active Bots</span>
              <span className="text-white font-semibold">{dashboardData.activeBots}</span>
            </div>
            <div className="flex justify-between text-sm">
              <span className="text-gray-400">Total Profit</span>
              <span className={dashboardData.totalBotProfit >= 0 ? 'text-green-400' : 'text-red-400'} font-semibold>
                {dashboardData.totalBotProfit >= 0 ? '+' : ''}{formatCurrency(dashboardData.totalBotProfit)}
              </span>
            </div>
            <div className="flex justify-between text-sm">
              <span className="text-gray-400">Total Bots</span>
              <span className="text-white">{dashboardData.botCount}</span>
            </div>
          </div>
          <div className="mt-4 pt-3 border-t border-gray-700">
            <a href="#" className="text-purple-400 hover:text-purple-300 text-sm font-medium">
              Manage Bots →
            </a>
          </div>
        </div>

        {/* Copy Trading Overview */}
        <div className="bg-gray-800 rounded-lg p-6 border border-gray-700">
          <div className="flex items-center justify-between mb-4">
            <h3 className="text-lg font-semibold text-white">Copy Trading</h3>
            <div className="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
              <svg className="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fillRule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clipRule="evenodd"></path>
              </svg>
            </div>
          </div>
          <div className="space-y-3">
            <div className="flex justify-between text-sm">
              <span className="text-gray-400">Active Copies</span>
              <span className="text-white font-semibold">{dashboardData.activeCopyTrades}</span>
            </div>
            <div className="flex justify-between text-sm">
              <span className="text-gray-400">Total Copies</span>
              <span className="text-white">{dashboardData.copyTradeCount}</span>
            </div>
            <div className="flex justify-between text-sm">
              <span className="text-gray-400">Status</span>
              <span className="text-green-400 font-semibold">{dashboardData.activeCopyTrades > 0 ? 'Active' : 'Inactive'}</span>
            </div>
          </div>
          <div className="mt-4 pt-3 border-t border-gray-700">
            <a href="#" className="text-green-400 hover:text-green-300 text-sm font-medium">
              View Copy Trades →
            </a>
          </div>
        </div>
      </div>

      {/* Third Row: Trades Tabs */}
      <div className="bg-gray-800 rounded-lg border border-gray-700 mb-8">
        {/* Tabs Header */}
        <div className="border-b border-gray-700">
          <nav className="flex space-x-8 px-6" aria-label="Tabs">
            <button
              id="openTradesTab"
              className={`tab-button py-4 px-1 border-b-2 font-medium text-sm ${activeTab === 'openTrades' ? 'border-blue-500 text-blue-400' : 'border-transparent text-gray-400 hover:text-gray-300'}`}
              onClick={() => setActiveTab('openTrades')}
            >
              <div className="flex items-center space-x-2">
                <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clipRule="evenodd"></path>
                </svg>
                <span>Open Trades</span>
              </div>
            </button>
            <button
              id="closedTradesTab"
              className={`tab-button py-4 px-1 border-b-2 font-medium text-sm ${activeTab === 'closedTrades' ? 'border-blue-500 text-blue-400' : 'border-transparent text-gray-400 hover:text-gray-300'}`}
              onClick={() => setActiveTab('closedTrades')}
            >
              <div className="flex items-center space-x-2">
                <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd"></path>
                </svg>
                <span>Closed Trades</span>
              </div>
            </button>
          </nav>
        </div>

        {/* Tab Content */}
        <div className="p-6">
          {/* Open Trades Tab */}
          {activeTab === 'openTrades' && (
            <div id="openTradesContent" className="tab-content">
              <div className="overflow-x-auto">
                <table className="min-w-full divide-y divide-gray-700">
                  <thead className="bg-gray-700">
                    <tr>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Pair</th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Type</th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Amount</th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Leverage</th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Entry Price</th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Current P&L</th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Action</th>
                    </tr>
                  </thead>
                  <tbody className="bg-gray-800 divide-y divide-gray-700">
                    {trades.openTrades.length > 0 ? (
                      trades.openTrades.map((trade) => (
                        <tr key={trade.id}>
                          <td className="px-6 py-4 whitespace-nowrap text-sm text-white">
                            {trade.pair}
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap">
                            <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${trade.type === 'buy' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`}>
                              {trade.type.charAt(0).toUpperCase() + trade.type.slice(1)}
                            </span>
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap text-sm text-white">
                            {trade.amount}
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap text-sm text-white">
                            {trade.leverage}x
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap text-sm text-white">
                            {formatCurrency(trade.entryPrice)}
                          </td>
                          <td className={`px-6 py-4 whitespace-nowrap text-sm ${trade.currentPnL >= 0 ? 'text-green-400' : 'text-red-400'}`}>
                            {trade.currentPnL >= 0 ? '+' : ''}{formatCurrency(trade.currentPnL)}
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button className="text-red-400 hover:text-red-300">Close</button>
                          </td>
                        </tr>
                      ))
                    ) : (
                      <tr>
                        <td colSpan="7" className="px-6 py-12 text-center">
                          <div className="flex flex-col items-center space-y-3">
                            <svg className="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <div className="text-gray-400">
                              <p className="text-lg font-medium">No open trades</p>
                              <p className="text-sm">Start trading to see your open positions here</p>
                            </div>
                          </div>
                        </td>
                      </tr>
                    )}
                  </tbody>
                </table>
              </div>
            </div>
          )}

          {/* Closed Trades Tab */}
          {activeTab === 'closedTrades' && (
            <div id="closedTradesContent" className="tab-content">
              <div className="overflow-x-auto">
                <table className="min-w-full divide-y divide-gray-700">
                  <thead className="bg-gray-700">
                    <tr>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Pair</th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Type</th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Amount</th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Entry Price</th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Exit Price</th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">P&L</th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Date</th>
                    </tr>
                  </thead>
                  <tbody className="bg-gray-800 divide-y divide-gray-700">
                    {trades.closedTrades.length > 0 ? (
                      trades.closedTrades.map((trade) => (
                        <tr key={trade.id}>
                          <td className="px-6 py-4 whitespace-nowrap text-sm text-white">
                            {trade.pair}
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap">
                            <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${trade.type === 'buy' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`}>
                              {trade.type.charAt(0).toUpperCase() + trade.type.slice(1)}
                            </span>
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap text-sm text-white">
                            {trade.amount}
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap text-sm text-white">
                            {formatCurrency(trade.entryPrice)}
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap text-sm text-white">
                            {formatCurrency(trade.exitPrice)}
                          </td>
                          <td className={`px-6 py-4 whitespace-nowrap text-sm ${trade.pnl >= 0 ? 'text-green-400' : 'text-red-400'}`}>
                            {trade.pnl >= 0 ? '+' : ''}{formatCurrency(trade.pnl)}
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap text-sm text-white">
                            {trade.date}
                          </td>
                        </tr>
                      ))
                    ) : (
                      <tr>
                        <td colSpan="7" className="px-6 py-12 text-center">
                          <div className="flex flex-col items-center space-y-3">
                            <svg className="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div className="text-gray-400">
                              <p className="text-lg font-medium">No closed trades</p>
                              <p className="text-sm">Your completed trades will appear here</p>
                            </div>
                          </div>
                        </td>
                      </tr>
                    )}
                  </tbody>
                </table>
              </div>
            </div>
          )}
        </div>
      </div>

      {/* Bottom spacing for fixed menu */}
      <div className="h-20"></div>
    </div>
  );
};

export default NewDashboard;