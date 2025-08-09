import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import { Program, User } from '@/types';

interface Props {
    program: Program;
    affiliate?: User;
    ref?: string;
}

interface RegistrationFormData {
    name: string;
    email: string;
    phone: string;
    address: string;
    age: string;
    motivation: string;
    learning_goals: string;
    previous_experience: string;
    referral_code: string;
    [key: string]: string;
}

export default function RegistrationCreate({ program, affiliate, ref }: Props) {
    const { data, setData, post, processing, errors } = useForm<RegistrationFormData>({
        name: '',
        email: '',
        phone: '',
        address: '',
        age: '',
        motivation: '',
        learning_goals: '',
        previous_experience: '',
        referral_code: ref || '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(`/programs/${program.id}/register`);
    };

    const formatPrice = (price: number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(price);
    };

    return (
        <>
            <Head title={`Register for ${program.name} - English Booster`} />
            <div className="min-h-screen bg-gray-50 dark:bg-gray-900">
                {/* Header */}
                <header className="bg-white dark:bg-gray-800 shadow-sm">
                    <div className="mx-auto max-w-7xl px-6 py-4">
                        <div className="flex items-center justify-between">
                            <Link href="/" className="flex items-center space-x-2">
                                <div className="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-indigo-600 text-white font-bold text-sm">
                                    EB
                                </div>
                                <span className="text-lg font-bold text-gray-900 dark:text-white">English Booster</span>
                            </Link>
                            <Link 
                                href={`/programs/${program.id}${ref ? `?ref=${ref}` : ''}`}
                                className="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
                            >
                                ← Back to Program
                            </Link>
                        </div>
                    </div>
                </header>

                <main className="mx-auto max-w-4xl px-6 py-8">
                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        {/* Registration Form */}
                        <div className="lg:col-span-2">
                            <div className="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                                <h1 className="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                                    🎯 Register for {program.name}
                                </h1>

                                {affiliate && (
                                    <div className="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-6">
                                        <div className="flex items-center">
                                            <div className="flex-shrink-0">
                                                <span className="text-green-600 dark:text-green-400 text-lg">🎉</span>
                                            </div>
                                            <div className="ml-3">
                                                <h3 className="text-sm font-medium text-green-800 dark:text-green-200">
                                                    Referred by {affiliate.name}
                                                </h3>
                                                <p className="text-sm text-green-700 dark:text-green-300">
                                                    You're registering through an affiliate referral. Both you and the affiliate may receive benefits!
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                )}

                                <form onSubmit={handleSubmit} className="space-y-6">
                                    {/* Personal Information */}
                                    <div>
                                        <h3 className="text-lg font-medium text-gray-900 dark:text-white mb-4">
                                            👤 Personal Information
                                        </h3>
                                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label htmlFor="name" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    Full Name *
                                                </label>
                                                <input
                                                    id="name"
                                                    type="text"
                                                    value={data.name}
                                                    onChange={(e) => setData('name', e.target.value)}
                                                    className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                                    required
                                                />
                                                {errors.name && <p className="text-red-500 text-sm mt-1">{errors.name}</p>}
                                            </div>
                                            <div>
                                                <label htmlFor="email" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    Email Address *
                                                </label>
                                                <input
                                                    id="email"
                                                    type="email"
                                                    value={data.email}
                                                    onChange={(e) => setData('email', e.target.value)}
                                                    className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                                    required
                                                />
                                                {errors.email && <p className="text-red-500 text-sm mt-1">{errors.email}</p>}
                                            </div>
                                        </div>
                                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                            <div>
                                                <label htmlFor="phone" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    Phone Number
                                                </label>
                                                <input
                                                    id="phone"
                                                    type="tel"
                                                    value={data.phone}
                                                    onChange={(e) => setData('phone', e.target.value)}
                                                    className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                                />
                                                {errors.phone && <p className="text-red-500 text-sm mt-1">{errors.phone}</p>}
                                            </div>
                                            <div>
                                                <label htmlFor="age" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    Age
                                                </label>
                                                <input
                                                    id="age"
                                                    type="number"
                                                    min="5"
                                                    max="100"
                                                    value={data.age}
                                                    onChange={(e) => setData('age', e.target.value)}
                                                    className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                                />
                                                {errors.age && <p className="text-red-500 text-sm mt-1">{errors.age}</p>}
                                            </div>
                                        </div>
                                        <div className="mt-4">
                                            <label htmlFor="address" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Address
                                            </label>
                                            <textarea
                                                id="address"
                                                rows={3}
                                                value={data.address}
                                                onChange={(e) => setData('address', e.target.value)}
                                                className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                                placeholder="Your full address..."
                                            />
                                            {errors.address && <p className="text-red-500 text-sm mt-1">{errors.address}</p>}
                                        </div>
                                    </div>

                                    {/* Learning Information */}
                                    <div>
                                        <h3 className="text-lg font-medium text-gray-900 dark:text-white mb-4">
                                            📚 Learning Information
                                        </h3>
                                        <div className="space-y-4">
                                            <div>
                                                <label htmlFor="motivation" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    What motivates you to learn English?
                                                </label>
                                                <textarea
                                                    id="motivation"
                                                    rows={3}
                                                    value={data.motivation}
                                                    onChange={(e) => setData('motivation', e.target.value)}
                                                    className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                                    placeholder="Share your motivation for learning English..."
                                                />
                                                {errors.motivation && <p className="text-red-500 text-sm mt-1">{errors.motivation}</p>}
                                            </div>
                                            <div>
                                                <label htmlFor="learning_goals" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    What are your learning goals?
                                                </label>
                                                <textarea
                                                    id="learning_goals"
                                                    rows={3}
                                                    value={data.learning_goals}
                                                    onChange={(e) => setData('learning_goals', e.target.value)}
                                                    className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                                    placeholder="What do you want to achieve with this program?"
                                                />
                                                {errors.learning_goals && <p className="text-red-500 text-sm mt-1">{errors.learning_goals}</p>}
                                            </div>
                                            <div>
                                                <label htmlFor="previous_experience" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    Previous English Learning Experience
                                                </label>
                                                <textarea
                                                    id="previous_experience"
                                                    rows={3}
                                                    value={data.previous_experience}
                                                    onChange={(e) => setData('previous_experience', e.target.value)}
                                                    className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                                    placeholder="Tell us about your previous English learning experience..."
                                                />
                                                {errors.previous_experience && <p className="text-red-500 text-sm mt-1">{errors.previous_experience}</p>}
                                            </div>
                                        </div>
                                    </div>

                                    {/* Referral Code */}
                                    <div>
                                        <h3 className="text-lg font-medium text-gray-900 dark:text-white mb-4">
                                            🎁 Referral Information
                                        </h3>
                                        <div>
                                            <label htmlFor="referral_code" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Referral Code (Optional)
                                            </label>
                                            <input
                                                id="referral_code"
                                                type="text"
                                                value={data.referral_code}
                                                onChange={(e) => setData('referral_code', e.target.value)}
                                                className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                                placeholder="Enter referral code if you have one"
                                                readOnly={!!ref}
                                            />
                                            {errors.referral_code && <p className="text-red-500 text-sm mt-1">{errors.referral_code}</p>}
                                            {ref && (
                                                <p className="text-green-600 dark:text-green-400 text-sm mt-1">
                                                    ✅ Referral code automatically applied
                                                </p>
                                            )}
                                        </div>
                                    </div>

                                    {/* Submit Button */}
                                    <div className="pt-6 border-t border-gray-200 dark:border-gray-700">
                                        <button
                                            type="submit"
                                            disabled={processing}
                                            className="w-full inline-flex justify-center items-center px-6 py-3 bg-blue-600 text-white text-lg font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                                        >
                                            {processing ? 'Submitting...' : '🎯 Complete Registration'}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {/* Program Summary */}
                        <div className="space-y-6">
                            <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    📋 Program Summary
                                </h3>
                                <div className="space-y-3">
                                    <h4 className="font-medium text-gray-900 dark:text-white">
                                        {program.name}
                                    </h4>
                                    <div className="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                                        <div className="flex justify-between">
                                            <span>Duration:</span>
                                            <span className="font-medium">{program.duration}</span>
                                        </div>
                                        <div className="flex justify-between">
                                            <span>Type:</span>
                                            <span className="font-medium capitalize">{program.type}</span>
                                        </div>
                                        <div className="flex justify-between items-center pt-2 border-t">
                                            <span>Price:</span>
                                            <span className="text-lg font-bold text-green-600 dark:text-green-400">
                                                {formatPrice(program.price)}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {affiliate && (
                                <div className="bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800 p-6">
                                    <h3 className="text-lg font-semibold text-green-800 dark:text-green-200 mb-2">
                                        🎉 Affiliate Referral
                                    </h3>
                                    <div className="text-sm text-green-700 dark:text-green-300 space-y-1">
                                        <p><strong>Referred by:</strong> {affiliate.name}</p>
                                        <p><strong>Code:</strong> {affiliate.referral_code}</p>
                                    </div>
                                </div>
                            )}

                            <div className="bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800 p-6">
                                <h3 className="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-2">
                                    ℹ️ What's Next?
                                </h3>
                                <div className="text-sm text-blue-700 dark:text-blue-300 space-y-2">
                                    <p>1. Complete this registration form</p>
                                    <p>2. Receive confirmation email</p>
                                    <p>3. Get payment instructions</p>
                                    <p>4. Start your English journey!</p>
                                </div>
                            </div>
                        </div>
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