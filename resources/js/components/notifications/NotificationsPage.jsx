import React, { useState, useEffect } from 'react';

const NotificationsPage = ({ notifications: initialNotifications = [], csrfToken }) => {
    const [notifications, setNotifications] = useState(initialNotifications);
    const [activeTab, setActiveTab] = useState('all');
    const [loading, setLoading] = useState(false);

    // Filter notifications based on active tab
    const filteredNotifications = notifications.filter(notification => {
        if (activeTab === 'all') return true;
        if (activeTab === 'unread') return !notification.read_at;
        
        const typeMap = {
            'deposits': ['deposit', 'deposit_submitted', 'deposit_approved'],
            'withdrawals': ['withdrawal', 'withdrawal_submitted', 'withdrawal_approved'],
            'trading': ['trading', 'trade'],
            'system': ['system', 'account_reactivated', 'account_suspended']
        };
        
        return typeMap[activeTab]?.includes(notification.type) || false;
    });

    // Get notification icon based on type
    const getNotificationIcon = (type) => {
        const iconClasses = {
            'deposit': 'bg-green-600/20 text-green-400',
            'deposit_submitted': 'bg-green-600/20 text-green-400',
            'deposit_approved': 'bg-green-600/20 text-green-400',
            'withdrawal': 'bg-red-600/20 text-red-400',
            'withdrawal_submitted': 'bg-red-600/20 text-red-400',
            'withdrawal_approved': 'bg-red-600/20 text-red-400',
            'trading': 'bg-blue-600/20 text-blue-400',
            'copy_trade': 'bg-purple-600/20 text-purple-400',
            'copy_trade_started': 'bg-purple-600/20 text-purple-400',
            'bot_trade': 'bg-yellow-600/20 text-yellow-400',
            'bot_created': 'bg-yellow-600/20 text-yellow-400',
            'bot_started': 'bg-yellow-600/20 text-yellow-400',
            'system': 'bg-gray-600/20 text-gray-400',
            'account_reactivated': 'bg-green-600/20 text-green-400',
            'account_suspended': 'bg-red-600/20 text-red-400'
        };

        const bgClass = iconClasses[type] || 'bg-gray-600/20 text-gray-400';

        return (
            <div className={`flex h-10 w-10 items-center justify-center rounded-full ${bgClass}`}>
                {type?.includes('deposit') && (
                    <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 4v16m8-8H4" />
                    </svg>
                )}
                {type?.includes('withdrawal') && (
                    <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M20 12H4" />
                    </svg>
                )}
                {type === 'trading' && (
                    <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                )}
                {type?.includes('copy_trade') && (
                    <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                )}
                {type?.includes('bot') && (
                    <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                )}
                {(!type?.includes('deposit') && !type?.includes('withdrawal') && type !== 'trading' && !type?.includes('copy_trade') && !type?.includes('bot')) && (
                    <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                )}
            </div>
        );
    };

    // Get status badge
    const getStatusBadge = (data) => {
        if (!data?.status) return null;
        
        const statusColors = {
            'active': 'bg-yellow-100 text-yellow-800',
            'suspended': 'bg-orange-100 text-orange-800',
            'completed': 'bg-green-100 text-green-800',
            'pending': 'bg-yellow-100 text-yellow-800',
            'approved': 'bg-green-100 text-green-800',
            'rejected': 'bg-red-100 text-red-800'
        };

        const colorClass = statusColors[data.status.toLowerCase()] || 'bg-gray-100 text-gray-800';

        return (
            <span className={`px-2 py-1 rounded text-xs font-medium ${colorClass}`}>
                {data.status.charAt(0).toUpperCase() + data.status.slice(1)}
            </span>
        );
    };

    // Format time ago
    const formatTimeAgo = (dateString) => {
        if (!dateString) return 'Just now';
        
        const date = new Date(dateString);
        const now = new Date();
        const diffInSeconds = Math.floor((now - date) / 1000);
        
        if (diffInSeconds < 60) return 'Just now';
        if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} minutes ago`;
        if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)} hours ago`;
        if (diffInSeconds < 604800) return `${Math.floor(diffInSeconds / 86400)} days ago`;
        if (diffInSeconds < 2592000) return `${Math.floor(diffInSeconds / 604800)} weeks ago`;
        if (diffInSeconds < 31536000) return `${Math.floor(diffInSeconds / 2592000)} months ago`;
        return `${Math.floor(diffInSeconds / 31536000)} years ago`;
    };

    // Mark notification as read
    const markAsRead = async (id) => {
        try {
            const response = await fetch(`/user/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                },
            });

            if (response.ok) {
                setNotifications(notifications.map(n => 
                    n.id === id ? { ...n, read_at: new Date().toISOString() } : n
                ));
            }
        } catch (error) {
            console.error('Error marking notification as read:', error);
        }
    };

    // Delete notification
    const deleteNotification = async (id) => {
        try {
            const response = await fetch(`/user/notifications/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                },
            });

            if (response.ok) {
                setNotifications(notifications.filter(n => n.id !== id));
            }
        } catch (error) {
            console.error('Error deleting notification:', error);
        }
    };

    // Mark all as read
    const markAllAsRead = async () => {
        setLoading(true);
        try {
            const response = await fetch('/user/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                },
            });

            if (response.ok) {
                setNotifications(notifications.map(n => ({ ...n, read_at: n.read_at || new Date().toISOString() })));
            }
        } catch (error) {
            console.error('Error marking all as read:', error);
        } finally {
            setLoading(false);
        }
    };

    // Clear all notifications
    const clearAll = async () => {
        if (!window.confirm('Are you sure you want to clear all notifications? This action cannot be undone.')) {
            return;
        }

        setLoading(true);
        try {
            const response = await fetch('/user/notifications/clear-all', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                },
            });

            if (response.ok) {
                setNotifications([]);
            }
        } catch (error) {
            console.error('Error clearing all notifications:', error);
        } finally {
            setLoading(false);
        }
    };

    const tabs = [
        { id: 'all', label: 'All Notifications' },
        { id: 'unread', label: 'Unread' },
        { id: 'deposits', label: 'Deposits' },
        { id: 'withdrawals', label: 'Withdrawals' },
        { id: 'trading', label: 'Trading' },
        { id: 'system', label: 'System' }
    ];

    return (
        <div className="space-y-6 text-white">
            {/* Header */}
            <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <p className="text-[11px] uppercase tracking-[0.3em] text-[#08f58d]">Activity</p>
                    <h1 className="text-2xl font-semibold">Notifications</h1>
                    <p className="text-sm text-gray-400 mt-1">Stay updated with your account activities</p>
                </div>
                <div className="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                    <button
                        onClick={markAllAsRead}
                        disabled={loading}
                        className="px-4 py-2 text-sm bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        {loading ? 'Processing...' : 'Mark All as Read'}
                    </button>
                    <button
                        onClick={clearAll}
                        disabled={loading}
                        className="px-4 py-2 text-sm bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Clear All
                    </button>
                </div>
            </div>

            {/* Filter Tabs */}
            <div className="border-b border-[#1a1a1a]">
                <nav className="-mb-px flex space-x-8 overflow-x-auto">
                    {tabs.map(tab => (
                        <button
                            key={tab.id}
                            onClick={() => setActiveTab(tab.id)}
                            className={`py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition-colors ${
                                activeTab === tab.id
                                    ? 'border-[#08f58d] text-[#08f58d]'
                                    : 'border-transparent text-gray-400 hover:text-gray-300'
                            }`}
                        >
                            {tab.label}
                        </button>
                    ))}
                </nav>
            </div>

            {/* Notifications List */}
            <div className="space-y-4">
                {filteredNotifications.length > 0 ? (
                    filteredNotifications.map(notification => (
                        <div
                            key={notification.id}
                            className={`rounded-2xl border bg-[#050505] p-5 hover:border-[#08f58d]/30 transition-colors ${
                                !notification.read_at ? 'border-[#08f58d]/30 border-l-4 border-l-[#08f58d]' : 'border-[#1a1a1a]'
                            }`}
                        >
                            <div className="flex items-start gap-4">
                                {/* Icon */}
                                {getNotificationIcon(notification.type)}

                                {/* Content */}
                                <div className="flex-1 min-w-0">
                                    <div className="flex items-start justify-between gap-4">
                                        <div className="flex-1">
                                            <h3 className="text-base font-semibold text-white">{notification.title}</h3>
                                            <p className="text-sm text-gray-400 mt-1">{notification.message}</p>
                                            
                                            {/* Additional Data */}
                                            {notification.data && (
                                                <div className="mt-3 space-y-2">
                                                    {notification.data.amount && (
                                                        <p className="text-sm text-[#08f58d] font-medium">
                                                            Amount: ${parseFloat(notification.data.amount).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} {notification.data.currency || 'USD'}
                                                        </p>
                                                    )}
                                                    {getStatusBadge(notification.data)}
                                                </div>
                                            )}
                                        </div>
                                    </div>

                                    {/* Footer */}
                                    <div className="flex items-center justify-between mt-4 pt-4 border-t border-[#1a1a1a]">
                                        <div className="flex items-center gap-3">
                                            <span className="text-xs text-gray-500">
                                                {formatTimeAgo(notification.created_at)}
                                            </span>
                                            {!notification.read_at && (
                                                <span className="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    New
                                                </span>
                                            )}
                                        </div>
                                        
                                        <div className="flex items-center gap-2">
                                            {!notification.read_at && (
                                                <button
                                                    onClick={() => markAsRead(notification.id)}
                                                    className="px-3 py-1.5 text-xs bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                                                >
                                                    Mark Read
                                                </button>
                                            )}
                                            <button
                                                onClick={() => deleteNotification(notification.id)}
                                                className="px-3 py-1.5 text-xs bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                                            >
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ))
                ) : (
                    <div className="text-center py-12">
                        <div className="flex justify-center mb-4">
                            <div className="flex h-16 w-16 items-center justify-center rounded-full bg-[#1a1a1a]">
                                <svg className="h-8 w-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </div>
                        </div>
                        <h3 className="text-lg font-medium text-gray-400 mb-2">No notifications</h3>
                        <p className="text-gray-500">You're all caught up! New notifications will appear here.</p>
                    </div>
                )}
            </div>
        </div>
    );
};

export default NotificationsPage;



