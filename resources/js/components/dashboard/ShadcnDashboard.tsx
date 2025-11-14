import React, { useState } from 'react';
import { Line, LineChart, ResponsiveContainer, Tooltip, XAxis, YAxis } from 'recharts';

interface PortfolioData {
  date: string;
  value: number;
}

interface BalanceCard {
  title: string;
  value: string;
  change: string;
  isPositive: boolean;
}

interface ActivityItem {
  id: number;
  type: string;
  title: string;
  time: string;
  amount: string;
  isPositive: boolean;
}

interface AccountTab {
  id: string;
  label: string;
  balance: string;
  change: string;
  isPositive: boolean;
}

const ShadcnDashboard: React.FC = () => {
  const [timeRange, setTimeRange] = useState<string>('1M');
  const [selectedAccount, setSelectedAccount] = useState<string>('investing');

  const accountTabs: AccountTab[] = [
    { id: 'investing', label: 'Investing', balance: '$12.14', change: '+0.33% past month', isPositive: true },
    { id: 'retirement', label: 'Retirement', balance: '$18,932.22', change: '+0.21% past quarter', isPositive: true },
    { id: 'credit', label: 'Credit Card', balance: '$620.48', change: '-0.18% past month', isPositive: false },
  ];

  const activeAccount = accountTabs.find((tab) => tab.id === selectedAccount) ?? accountTabs[0];

  const portfolioData: PortfolioData[] = [
    { date: 'Jan', value: 8000 },
    { date: 'Feb', value: 9500 },
    { date: 'Mar', value: 11000 },
    { date: 'Apr', value: 10500 },
    { date: 'May', value: 12000 },
    { date: 'Jun', value: 12500 },
    { date: 'Jul', value: 12600 },
    { date: 'Aug', value: 12650 },
    { date: 'Sep', value: 12660 },
    { date: 'Oct', value: 15000 },
    { date: 'Nov', value: 15000 },
    { date: 'Dec', value: 15000 },
  ];

  const balanceCards: BalanceCard[] = [
    { title: 'Portfolio Balance', value: activeAccount.balance, change: activeAccount.change, isPositive: activeAccount.isPositive },
    { title: 'Buying Power', value: '$12.14', change: '+$0.04 today', isPositive: true },
    { title: 'Cash', value: '$8,210.50', change: '+1.2% this week', isPositive: true },
    { title: 'Rewards', value: '2 offers', change: '+1 new offer', isPositive: true },
  ];

  const recentActivity: ActivityItem[] = [
    { id: 1, type: 'deposit', title: 'Deposit', time: '2 hours ago', amount: '+$1,000.00', isPositive: true },
    { id: 2, type: 'trade', title: 'Trade Profit', time: '5 hours ago', amount: '+$150.75', isPositive: true },
    { id: 3, type: 'copy', title: 'Copy Trade', time: '1 day ago', amount: '+$75.25', isPositive: true },
  ];

  const timeRanges = ['1D', '1W', '1M', '3M', '1Y', 'All'];

  return (
    <div className="min-h-screen bg-[#010101] text-white px-4 py-6 md:px-8">
      <div className="mx-auto max-w-6xl space-y-8">
        <div>
          <p className="text-sm font-medium text-[#08f58d]">Smart Trader</p>
          <h1 className="text-3xl font-semibold tracking-tight">Welcome back, User</h1>
          <p className="text-gray-400">Keep watching your money work.</p>
        </div>

        <div className="grid gap-4 md:grid-cols-3">
          {accountTabs.map((tab) => {
            const isActive = tab.id === activeAccount.id;
            return (
              <button
                key={tab.id}
                onClick={() => setSelectedAccount(tab.id)}
                className={`rounded-3xl border px-5 py-4 text-left transition-colors ${
                  isActive ? 'border-[#1fff9c] bg-[#071c11]' : 'border-[#181818] bg-[#070707] hover:bg-[#0b0b0b]'
                }`}
              >
                <div className="flex items-start justify-between">
                  <div>
                    <p className="text-sm text-gray-400">{tab.label}</p>
                    <p className="text-3xl font-semibold text-white">{tab.balance}</p>
                    <p className={`text-xs ${tab.isPositive ? 'text-green-400' : 'text-red-400'}`}>{tab.change}</p>
                  </div>
                  <div
                    className={`flex h-10 w-10 items-center justify-center rounded-full border ${
                      isActive ? 'border-[#1fff9c] text-[#1fff9c]' : 'border-[#2c2c2c] text-gray-400'
                    }`}
                  >
                    {isActive ? (
                      <svg className="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M5 13l4 4L19 7" />
                      </svg>
                    ) : (
                      <svg className="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 5v14m7-7H5" />
                      </svg>
                    )}
                  </div>
                </div>
              </button>
            );
          })}
        </div>

        <div className="rounded-[32px] bg-[#050505] text-white shadow-[0_0_60px_rgba(0,0,0,0.45)]">
          <div className="flex flex-col gap-4 px-6 pb-2 pt-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
              <p className="text-sm uppercase text-gray-400">Balance</p>
              <p className="text-4xl font-semibold">{activeAccount.balance}</p>
              <p className={`text-sm ${activeAccount.isPositive ? 'text-green-400' : 'text-red-400'}`}>{activeAccount.change}</p>
            </div>
            <button className="self-start rounded-full bg-[#c6ff00] px-5 py-2 text-sm font-semibold text-black">
              Offers
            </button>
          </div>

          <div className="relative h-72 w-full">
            <div className="pointer-events-none absolute inset-0 top-2 flex items-center justify-center">
              <div className="h-[90%] w-[94%] rounded-[30px] border border-[#0f0f0f]" />
            </div>
            <ResponsiveContainer width="100%" height="100%">
              <LineChart data={portfolioData} margin={{ top: 12, left: 0, right: 20, bottom: 0 }}>
                <XAxis dataKey="date" stroke="#404040" tick={{ fontSize: 12 }} axisLine={false} tickLine={false} />
                <YAxis stroke="#404040" tick={{ fontSize: 12 }} axisLine={false} tickLine={false} hide />
                <Tooltip
                  contentStyle={{ backgroundColor: '#0d0d0d', borderRadius: 14, border: '1px solid #1fff9c' }}
                  itemStyle={{ color: '#e5ffe5' }}
                  labelStyle={{ color: '#9ca3af' }}
                />
                <Line type="monotone" dataKey="value" stroke="#00ff5f" strokeWidth={3} dot={false} activeDot={{ r: 6 }} />
              </LineChart>
            </ResponsiveContainer>
          </div>

          <div className="flex flex-wrap gap-2 px-6 pb-6">
            {timeRanges.map((range) => {
              const isActive = range === timeRange;
              return (
                <button
                  key={range}
                  onClick={() => setTimeRange(range)}
                  className={`rounded-full px-4 py-1 text-xs font-semibold ${
                    isActive ? 'bg-[#00ff5f] text-black' : 'bg-[#0f0f0f] text-gray-300'
                  }`}
                >
                  {range}
                </button>
              );
            })}
          </div>
        </div>

        <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
          {balanceCards.map((card, index) => (
            <div key={index} className="rounded-3xl border border-[#151515] bg-[#050505] p-5">
              <p className="text-xs uppercase text-gray-500">{card.title}</p>
              <p className="text-2xl font-semibold text-white">{card.value}</p>
              <p className={`text-xs ${card.isPositive ? 'text-green-400' : 'text-red-400'}`}>{card.change}</p>
            </div>
          ))}
        </div>

        <div className="rounded-3xl border border-[#151515] bg-[#050505] p-6">
          <div className="mb-4 flex flex-wrap items-center justify-between gap-3">
            <h3 className="text-lg font-semibold text-white">Recent Activity</h3>
            <button className="text-sm text-gray-400 hover:text-white">View all</button>
          </div>
          <div className="space-y-4">
            {recentActivity.map((activity) => (
              <div key={activity.id} className="flex items-center justify-between border-b border-[#101010] pb-4 last:border-b-0 last:pb-0">
                <div className="flex items-center gap-3">
                  <div
                    className={`flex h-10 w-10 items-center justify-center rounded-full ${
                      activity.type === 'deposit' ? 'bg-green-500/20 text-green-300' : 'bg-blue-500/20 text-blue-200'
                    }`}
                  >
                    {activity.type === 'deposit' && (
                      <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 5v14m7-7H5" />
                      </svg>
                    )}
                    {activity.type === 'trade' && (
                      <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M3 3h18v4H3zm3 4v14h12V7" />
                      </svg>
                    )}
                    {activity.type === 'copy' && (
                      <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                      </svg>
                    )}
                  </div>
                  <div>
                    <p className="text-sm font-medium text-white">{activity.title}</p>
                    <p className="text-xs text-gray-500">{activity.time}</p>
                  </div>
                </div>
                <span className={`text-sm font-semibold ${activity.isPositive ? 'text-green-400' : 'text-red-400'}`}>{activity.amount}</span>
              </div>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
};

export default ShadcnDashboard;
