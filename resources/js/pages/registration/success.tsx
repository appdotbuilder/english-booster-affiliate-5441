import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Program, Referral, User } from '@/types';

interface Props {
    referral: Referral;
    program: Program;
    affiliate?: User;
}

export default function RegistrationSuccess({ referral, program, affiliate }: Props) {
    const formatPrice = (price: number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(price);
    };

    return (
        <>
            <Head title="Registration Successful - English Booster" />
            <div className="min-h-screen bg-gray-50 dark:bg-gray-900">
                {/* Header */}
                <header className="bg-white dark:bg-gray-800 shadow-sm">
                    <div className="mx-auto max-w-7xl px-6 py-4">
                        <Link href="/" className="flex items-center space-x-2">
                            <div className="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-indigo-600 text-white font-bold text-sm">
                                EB
                            </div>
                            <span className="text-lg font-bold text-gray-900 dark:text-white">English Booster</span>
                        </Link>
                    </div>
                </header>

                <main className="mx-auto max-w-4xl px-6 py-8">
                    <div className="text-center mb-8">
                        <div className="text-6xl mb-4">🎉</div>
                        <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                            Registration Successful!
                        </h1>
                        <p className="text-gray-600 dark:text-gray-300 text-lg">
                            Thank you for registering for {program.name}. We're excited to have you on board!
                        </p>
                    </div>

                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        {/* Registration Details */}
                        <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                            <h2 className="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                📋 Registration Details
                            </h2>
                            <div className="space-y-3">
                                <div className="flex justify-between">
                                    <span className="text-gray-600 dark:text-gray-300">Registration ID:</span>
                                    <span className="font-medium text-gray-900 dark:text-white">
                                        #{referral.id.toString().padStart(6, '0')}
                                    </span>
                                </div>
                                <div className="flex justify-between">
                                    <span className="text-gray-600 dark:text-gray-300">Student Name:</span>
                                    <span className="font-medium text-gray-900 dark:text-white">
                                        {referral.customer_name}
                                    </span>
                                </div>
                                <div className="flex justify-between">
                                    <span className="text-gray-600 dark:text-gray-300">Email:</span>
                                    <span className="font-medium text-gray-900 dark:text-white">
                                        {referral.customer_email}
                                    </span>
                                </div>
                                {referral.customer_phone && (
                                    <div className="flex justify-between">
                                        <span className="text-gray-600 dark:text-gray-300">Phone:</span>
                                        <span className="font-medium text-gray-900 dark:text-white">
                                            {referral.customer_phone}
                                        </span>
                                    </div>
                                )}
                                <div className="flex justify-between">
                                    <span className="text-gray-600 dark:text-gray-300">Status:</span>
                                    <span className="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                                        Pending Confirmation
                                    </span>
                                </div>
                                <div className="flex justify-between">
                                    <span className="text-gray-600 dark:text-gray-300">Registration Date:</span>
                                    <span className="font-medium text-gray-900 dark:text-white">
                                        {new Date(referral.created_at).toLocaleDateString('id-ID')}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {/* Program Details */}
                        <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                            <h2 className="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                📚 Program Details
                            </h2>
                            <div className="space-y-3">
                                <div>
                                    <span className="text-gray-600 dark:text-gray-300 text-sm">Program:</span>
                                    <p className="font-medium text-gray-900 dark:text-white text-lg">
                                        {program.name}
                                    </p>
                                </div>
                                <div className="flex justify-between">
                                    <span className="text-gray-600 dark:text-gray-300">Duration:</span>
                                    <span className="font-medium text-gray-900 dark:text-white">
                                        {program.duration}
                                    </span>
                                </div>
                                <div className="flex justify-between">
                                    <span className="text-gray-600 dark:text-gray-300">Type:</span>
                                    <span className="font-medium text-gray-900 dark:text-white capitalize">
                                        {program.type}
                                    </span>
                                </div>
                                <div className="flex justify-between items-center pt-2 border-t border-gray-200 dark:border-gray-600">
                                    <span className="text-gray-600 dark:text-gray-300">Price:</span>
                                    <span className="text-xl font-bold text-green-600 dark:text-green-400">
                                        {formatPrice(program.price)}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {/* Affiliate Information */}
                        {affiliate && (
                            <div className="lg:col-span-2">
                                <div className="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-6">
                                    <div className="flex items-start space-x-3">
                                        <div className="flex-shrink-0">
                                            <span className="text-green-600 dark:text-green-400 text-2xl">🎯</span>
                                        </div>
                                        <div>
                                            <h3 className="text-lg font-medium text-green-800 dark:text-green-200 mb-2">
                                                Affiliate Referral Bonus
                                            </h3>
                                            <p className="text-green-700 dark:text-green-300 mb-3">
                                                You were referred by <strong>{affiliate.name}</strong> using referral code <strong>{affiliate.referral_code}</strong>.
                                                You may be eligible for special benefits or discounts!
                                            </p>
                                            <div className="text-sm text-green-600 dark:text-green-400">
                                                <p>📧 Questions about your referral? Contact: {affiliate.email}</p>
                                                {affiliate.phone && <p>📱 WhatsApp: {affiliate.phone}</p>}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        )}

                        {/* Next Steps */}
                        <div className="lg:col-span-2">
                            <div className="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
                                <h3 className="text-xl font-semibold text-blue-800 dark:text-blue-200 mb-4">
                                    🚀 What's Next?
                                </h3>
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h4 className="font-medium text-blue-800 dark:text-blue-200 mb-2">
                                            1. Check Your Email
                                        </h4>
                                        <p className="text-blue-700 dark:text-blue-300 text-sm">
                                            We've sent a confirmation email to {referral.customer_email} with detailed payment instructions and program information.
                                        </p>
                                    </div>
                                    <div>
                                        <h4 className="font-medium text-blue-800 dark:text-blue-200 mb-2">
                                            2. Complete Payment
                                        </h4>
                                        <p className="text-blue-700 dark:text-blue-300 text-sm">
                                            Follow the payment instructions in your email to secure your spot in the program.
                                        </p>
                                    </div>
                                    <div>
                                        <h4 className="font-medium text-blue-800 dark:text-blue-200 mb-2">
                                            3. Prepare for Learning
                                        </h4>
                                        <p className="text-blue-700 dark:text-blue-300 text-sm">
                                            Once payment is confirmed, you'll receive access credentials and program materials.
                                        </p>
                                    </div>
                                    <div>
                                        <h4 className="font-medium text-blue-800 dark:text-blue-200 mb-2">
                                            4. Start Your Journey
                                        </h4>
                                        <p className="text-blue-700 dark:text-blue-300 text-sm">
                                            Begin your English learning adventure with English Booster!
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Contact Information */}
                    <div className="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            📞 Need Help?
                        </h3>
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                            <div className="text-center">
                                <div className="text-2xl mb-2">📧</div>
                                <p className="font-medium text-gray-900 dark:text-white">Email Support</p>
                                <p className="text-blue-600 dark:text-blue-400">admin@englishbooster.com</p>
                            </div>
                            <div className="text-center">
                                <div className="text-2xl mb-2">📱</div>
                                <p className="font-medium text-gray-900 dark:text-white">WhatsApp</p>
                                <p className="text-green-600 dark:text-green-400">+62 812-3456-7890</p>
                            </div>
                            <div className="text-center">
                                <div className="text-2xl mb-2">⏰</div>
                                <p className="font-medium text-gray-900 dark:text-white">Business Hours</p>
                                <p className="text-gray-600 dark:text-gray-300">Mon-Fri 9AM-6PM WIB</p>
                            </div>
                        </div>
                    </div>

                    {/* Action Buttons */}
                    <div className="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                        <Link
                            href={route('programs.index')}
                            className="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors"
                        >
                            📚 Browse More Programs
                        </Link>
                        <Link
                            href="/"
                            className="inline-flex items-center justify-center px-6 py-3 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors"
                        >
                            🏠 Return Home
                        </Link>
                    </div>
                </main>

                {/* Footer */}
                <footer className="border-t border-gray-200 dark:border-gray-700 mt-16 py-8">
                    <div className="mx-auto max-w-7xl px-6 text-center">
                        <p className="text-gray-600 dark:text-gray-300">
                            © 2024 English Booster. Empowering English learners worldwide.
                        </p>
                    </div>
                </footer>
            </div>
        </>
    );
}