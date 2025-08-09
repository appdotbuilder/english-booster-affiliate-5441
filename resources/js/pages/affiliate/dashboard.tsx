import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import { User, Referral, Payout } from '@/types';

interface Props {
    affiliate: User & {
        referrals: Referral[];
        payouts: Payout[];
    };
    stats: {
        total_clicks: number;
        today_clicks: number;
        total_referrals: number;
        completed_referrals: number;
        pending_referrals: number;
        total_earnings: number;
        pending_earnings: number;
        available_balance: number;
        total_payouts: number;
        conversion_rate: number;
    };

    referral_link: string;
}

export default function AffiliateDashboard({ affiliate, stats, referral_link }: Props) {
    const [copiedLink, setCopiedLink] = useState(false);

    const copyReferralLink = () => {
        navigator.clipboard.writeText(referral_link);
        setCopiedLink(true);
        setTimeout(() => setCopiedLink(false), 2000);
    };

    const formatCurrency = (amount: number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(amount);
    };

    return (
        <>
            <Head title="Affiliate Dashboard - English Booster" />
            <div className="min-h-screen bg-gray-50 dark:bg-gray-900">
                {/* Header */}
                <header className="bg-white dark:bg-gray-800 shadow-sm">
                    <div className="mx-auto max-w-7xl px-6 py-4">
                        <div className="flex items-center justify-between">
                            <div className="flex items-center space-x-3">
                                <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-indigo-600 text-white font-bold">
                                    EB
                                </div>
                                <div>
                                    <h1 className="text-lg font-bold text-gray-900 dark:text-white">
                                        English Booster
                                    </h1>
                                    <p className="text-sm text-gray-600 dark:text-gray-300">
                                        Affiliate Dashboard
                                    </p>
                                </div>
                            </div>
                            <div className="flex items-center space-x-4">
                                <div className="text-right">
                                    <p className="text-sm text-gray-600 dark:text-gray-300">Welcome back,</p>
                                    <p className="font-medium text-gray-900 dark:text-white">{affiliate.name}</p>
                                </div>
                                <div className="h-8 w-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                    <span className="text-blue-600 dark:text-blue-400 font-medium text-sm">
                                        {affiliate.name.charAt(0).toUpperCase()}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <main className="mx-auto max-w-7xl px-6 py-8">
                    {/* Welcome Section */}
                    <div className="mb-8">
                        <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                            🎯 Your Affiliate Dashboard
                        </h2>
                        <p className="text-gray-600 dark:text-gray-300">
                            Track your performance, manage referrals, and grow your earnings.
                        </p>
                    </div>

                    {/* Stats Grid */}
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                            <div className="flex items-center">
                                <div className="flex-shrink-0">
                                    <span className="text-2xl">👆</span>
                                </div>
                                <div className="ml-4">
                                    <p className="text-sm text-gray-600 dark:text-gray-300">Total Clicks</p>
                                    <p className="text-2xl font-bold text-gray-900 dark:text-white">
                                        {stats.total_clicks.toLocaleString()}
                                    </p>
                                    <p className="text-xs text-blue-600 dark:text-blue-400">
                                        +{stats.today_clicks} today
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                            <div className="flex items-center">
                                <div className="flex-shrink-0">
                                    <span className="text-2xl">👥</span>
                                </div>
                                <div className="ml-4">
                                    <p className="text-sm text-gray-600 dark:text-gray-300">Referrals</p>
                                    <p className="text-2xl font-bold text-gray-900 dark:text-white">
                                        {stats.total_referrals}
                                    </p>
                                    <p className="text-xs text-green-600 dark:text-green-400">
                                        {stats.conversion_rate}% conversion
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                            <div className="flex items-center">
                                <div className="flex-shrink-0">
                                    <span className="text-2xl">💰</span>
                                </div>
                                <div className="ml-4">
                                    <p className="text-sm text-gray-600 dark:text-gray-300">Total Earnings</p>
                                    <p className="text-2xl font-bold text-green-600 dark:text-green-400">
                                        {formatCurrency(stats.total_earnings)}
                                    </p>
                                    <p className="text-xs text-gray-600 dark:text-gray-300">
                                        {stats.completed_referrals} completed
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                            <div className="flex items-center">
                                <div className="flex-shrink-0">
                                    <span className="text-2xl">💳</span>
                                </div>
                                <div className="ml-4">
                                    <p className="text-sm text-gray-600 dark:text-gray-300">Available Balance</p>
                                    <p className="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                        {formatCurrency(stats.available_balance)}
                                    </p>
                                    <p className="text-xs text-gray-600 dark:text-gray-300">
                                        Ready for payout
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        {/* Referral Link */}
                        <div className="lg:col-span-2">
                            <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    🔗 Your Referral Link
                                </h3>
                                <div className="flex items-center space-x-3">
                                    <input
                                        type="text"
                                        value={referral_link}
                                        readOnly
                                        className="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm"
                                    />
                                    <button
                                        onClick={copyReferralLink}
                                        className="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium"
                                    >
                                        {copiedLink ? '✅ Copied!' : '📋 Copy'}
                                    </button>
                                </div>
                                <div className="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                    <p className="text-sm text-blue-800 dark:text-blue-200">
                                        <strong>Your Referral Code:</strong> {affiliate.referral_code}
                                    </p>
                                    <p className="text-sm text-blue-700 dark:text-blue-300 mt-1">
                                        Share this link to earn {affiliate.commission_rate}% commission on every successful registration!
                                    </p>
                                </div>
                            </div>

                            {/* Recent Referrals */}
                            <div className="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    📊 Recent Referrals
                                </h3>
                                {affiliate.referrals.length > 0 ? (
                                    <div className="overflow-x-auto">
                                        <table className="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                            <thead>
                                                <tr>
                                                    <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                        Customer
                                                    </th>
                                                    <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                        Program
                                                    </th>
                                                    <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                        Status
                                                    </th>
                                                    <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                        Commission
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody className="divide-y divide-gray-200 dark:divide-gray-700">
                                                {affiliate.referrals.slice(0, 5).map((referral) => (
                                                    <tr key={referral.id}>
                                                        <td className="px-4 py-3">
                                                            <div>
                                                                <p className="text-sm font-medium text-gray-900 dark:text-white">
                                                                    {referral.customer_name}
                                                                </p>
                                                                <p className="text-sm text-gray-500 dark:text-gray-400">
                                                                    {referral.customer_email}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td className="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                                            {referral.program?.name}
                                                        </td>
                                                        <td className="px-4 py-3">
                                                            <span className={`inline-flex px-2 py-1 text-xs font-medium rounded-full ${
                                                                referral.status === 'completed' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' :
                                                                referral.status === 'pending' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' :
                                                                'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200'
                                                            }`}>
                                                                {referral.status}
                                                            </span>
                                                        </td>
                                                        <td className="px-4 py-3 text-sm font-medium text-green-600 dark:text-green-400">
                                                            {referral.commission_amount ? formatCurrency(referral.commission_amount) : '-'}
                                                        </td>
                                                    </tr>
                                                ))}
                                            </tbody>
                                        </table>
                                    </div>
                                ) : (
                                    <div className="text-center py-8">
                                        <span className="text-4xl mb-2 block">📋</span>
                                        <p className="text-gray-600 dark:text-gray-300">No referrals yet</p>
                                        <p className="text-sm text-gray-500 dark:text-gray-400">Start sharing your referral link to see results here!</p>
                                    </div>
                                )}
                            </div>
                        </div>

                        {/* Sidebar */}
                        <div className="space-y-6">
                            {/* Account Info */}
                            <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    👤 Account Info
                                </h3>
                                <div className="space-y-3 text-sm">
                                    <div>
                                        <p className="text-gray-600 dark:text-gray-300">Name:</p>
                                        <p className="font-medium text-gray-900 dark:text-white">{affiliate.name}</p>
                                    </div>
                                    <div>
                                        <p className="text-gray-600 dark:text-gray-300">Email:</p>
                                        <p className="font-medium text-gray-900 dark:text-white">{affiliate.email}</p>
                                    </div>
                                    <div>
                                        <p className="text-gray-600 dark:text-gray-300">Commission Rate:</p>
                                        <p className="font-medium text-blue-600 dark:text-blue-400">{affiliate.commission_rate}%</p>
                                    </div>
                                    <div>
                                        <p className="text-gray-600 dark:text-gray-300">Status:</p>
                                        <span className={`inline-flex px-2 py-1 text-xs font-medium rounded-full ${
                                            affiliate.is_active 
                                                ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' 
                                                : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200'
                                        }`}>
                                            {affiliate.is_active ? 'Active' : 'Inactive'}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {/* Quick Actions */}
                            <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    ⚡ Quick Actions
                                </h3>
                                <div className="space-y-3">
                                    <a
                                        href="/programs"
                                        className="block w-full px-4 py-2 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium"
                                    >
                                        📚 Browse Programs
                                    </a>
                                    <a
                                        href={`mailto:?subject=Learn English with English Booster&body=Hey! I found this great English course platform. Check it out: ${referral_link}`}
                                        className="block w-full px-4 py-2 bg-green-600 text-white text-center rounded-lg hover:bg-green-700 transition-colors text-sm font-medium"
                                    >
                                        📧 Share via Email
                                    </a>
                                    <a
                                        href={`https://wa.me/?text=Learn English with English Booster! ${referral_link}`}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="block w-full px-4 py-2 bg-green-500 text-white text-center rounded-lg hover:bg-green-600 transition-colors text-sm font-medium"
                                    >
                                        📱 Share on WhatsApp
                                    </a>
                                </div>
                            </div>

                            {/* Performance Summary */}
                            <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    📈 Performance Summary
                                </h3>
                                <div className="space-y-3 text-sm">
                                    <div className="flex justify-between">
                                        <span className="text-gray-600 dark:text-gray-300">Pending Earnings:</span>
                                        <span className="font-medium text-yellow-600 dark:text-yellow-400">
                                            {formatCurrency(stats.pending_earnings)}
                                        </span>
                                    </div>
                                    <div className="flex justify-between">
                                        <span className="text-gray-600 dark:text-gray-300">Total Payouts:</span>
                                        <span className="font-medium text-gray-900 dark:text-white">
                                            {formatCurrency(stats.total_payouts)}
                                        </span>
                                    </div>
                                    <div className="flex justify-between">
                                        <span className="text-gray-600 dark:text-gray-300">Pending Referrals:</span>
                                        <span className="font-medium text-orange-600 dark:text-orange-400">
                                            {stats.pending_referrals}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </>
    );
}