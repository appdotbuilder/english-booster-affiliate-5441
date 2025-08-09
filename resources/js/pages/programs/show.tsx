import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Program } from '@/types';

interface Props {
    program: Program;
    related_programs: Program[];
    ref?: string;
}

export default function ProgramShow({ program, related_programs, ref }: Props) {
    const formatPrice = (price: number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(price);
    };

    const programTypeIcons = {
        online: '💻',
        offline: '🏕️',
        rombongan: '👥',
        cabang: '🏫',
    };

    const programTypeColors = {
        online: 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200',
        offline: 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
        rombongan: 'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200',
        cabang: 'bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200',
    };

    return (
        <>
            <Head title={`${program.name} - English Booster`} />
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
                            <div className="flex items-center space-x-4">
                                <Link 
                                    href={`/programs${ref ? `?ref=${ref}` : ''}`}
                                    className="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
                                >
                                    ← Back to Programs
                                </Link>
                                {ref && (
                                    <div className="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-3 py-1 rounded-full text-sm font-medium">
                                        🎯 Referred by affiliate
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </header>

                <main className="mx-auto max-w-4xl px-6 py-8">
                    {/* Program Header */}
                    <div className="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                        {program.image_url && (
                            <div className="h-64 bg-gradient-to-r from-blue-500 to-indigo-600 relative">
                                <img
                                    src={program.image_url}
                                    alt={program.name}
                                    className="w-full h-full object-cover"
                                />
                                <div className="absolute inset-0 bg-black bg-opacity-20"></div>
                            </div>
                        )}
                        
                        <div className="p-8">
                            <div className="flex items-center justify-between mb-6">
                                <div className="flex items-center space-x-3">
                                    <span className={`inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${programTypeColors[program.type as keyof typeof programTypeColors]}`}>
                                        {programTypeIcons[program.type as keyof typeof programTypeIcons]} {program.type === 'online' ? 'Online Programs' : 
                                         program.type === 'offline' ? 'Offline Programs (Pare)' :
                                         program.type === 'rombongan' ? 'Rombongan Programs' :
                                         'Cabang Programs'}
                                    </span>
                                    <span className="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                                        ⏱️ {program.duration}
                                    </span>
                                </div>
                            </div>

                            <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                                {program.name}
                            </h1>

                            <p className="text-gray-600 dark:text-gray-300 text-lg leading-relaxed mb-8">
                                {program.description}
                            </p>

                            {/* Features */}
                            {program.features && program.features.length > 0 && (
                                <div className="mb-8">
                                    <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                        ✨ What You'll Get
                                    </h3>
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        {program.features.map((feature, index) => (
                                            <div key={index} className="flex items-center space-x-2">
                                                <div className="h-2 w-2 bg-blue-600 rounded-full"></div>
                                                <span className="text-gray-700 dark:text-gray-300">{feature}</span>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            )}

                            {/* Price and CTA */}
                            <div className="border-t border-gray-200 dark:border-gray-700 pt-8">
                                <div className="flex items-center justify-between">
                                    <div>
                                        <span className="text-3xl font-bold text-green-600 dark:text-green-400">
                                            {formatPrice(program.price)}
                                        </span>
                                        <span className="text-gray-500 dark:text-gray-400 ml-2">
                                            / {program.duration}
                                        </span>
                                    </div>
                                    <Link
                                        href={`/programs/${program.id}/register${ref ? `?ref=${ref}` : ''}`}
                                        className="inline-flex items-center px-8 py-3 bg-blue-600 text-white text-lg font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl"
                                    >
                                        🎯 Register Now
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Program Details */}
                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
                        <div className="lg:col-span-2 space-y-6">
                            {/* About This Program */}
                            <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                                <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                    📋 About This Program
                                </h3>
                                <div className="prose dark:prose-invert max-w-none">
                                    <p className="text-gray-600 dark:text-gray-300 leading-relaxed">
                                        {program.description}
                                    </p>
                                    
                                    {program.type === 'online' && (
                                        <div className="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                            <h4 className="font-medium text-blue-900 dark:text-blue-100 mb-2">💻 Online Learning Benefits</h4>
                                            <ul className="text-sm text-blue-800 dark:text-blue-200 space-y-1">
                                                <li>• Learn from anywhere, anytime</li>
                                                <li>• Interactive online platform</li>
                                                <li>• Recorded sessions for review</li>
                                                <li>• Digital certificates</li>
                                            </ul>
                                        </div>
                                    )}
                                    
                                    {program.type === 'offline' && (
                                        <div className="mt-4 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                            <h4 className="font-medium text-green-900 dark:text-green-100 mb-2">🏕️ Pare Camp Experience</h4>
                                            <ul className="text-sm text-green-800 dark:text-green-200 space-y-1">
                                                <li>• Full English immersion environment</li>
                                                <li>• Accommodation and meals included</li>
                                                <li>• Cultural activities and excursions</li>
                                                <li>• 24/7 English speaking practice</li>
                                            </ul>
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>

                        <div className="space-y-6">
                            {/* Quick Info */}
                            <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    📊 Quick Info
                                </h3>
                                <div className="space-y-3">
                                    <div className="flex justify-between">
                                        <span className="text-gray-600 dark:text-gray-300">Duration</span>
                                        <span className="font-medium text-gray-900 dark:text-white">
                                            {program.duration}
                                        </span>
                                    </div>
                                    <div className="flex justify-between">
                                        <span className="text-gray-600 dark:text-gray-300">Type</span>
                                        <span className="font-medium text-gray-900 dark:text-white capitalize">
                                            {program.type}
                                        </span>
                                    </div>
                                    <div className="flex justify-between">
                                        <span className="text-gray-600 dark:text-gray-300">Price</span>
                                        <span className="font-medium text-green-600 dark:text-green-400">
                                            {formatPrice(program.price)}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {/* Contact Info */}
                            <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    📞 Need Help?
                                </h3>
                                <div className="space-y-3 text-sm">
                                    <div className="flex items-center space-x-2">
                                        <span className="text-gray-600 dark:text-gray-300">📧 Email:</span>
                                        <span className="text-blue-600 dark:text-blue-400">admin@englishbooster.com</span>
                                    </div>
                                    <div className="flex items-center space-x-2">
                                        <span className="text-gray-600 dark:text-gray-300">📱 WhatsApp:</span>
                                        <span className="text-green-600 dark:text-green-400">+62 812-3456-7890</span>
                                    </div>
                                    <div className="flex items-center space-x-2">
                                        <span className="text-gray-600 dark:text-gray-300">⏰ Hours:</span>
                                        <span className="text-gray-900 dark:text-white">Mon-Fri 9AM-6PM</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Related Programs */}
                    {related_programs.length > 0 && (
                        <div className="mt-12">
                            <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                                🔗 Related Programs
                            </h2>
                            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                                {related_programs.map((relatedProgram) => (
                                    <div key={relatedProgram.id} className="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow overflow-hidden">
                                        <div className="p-6">
                                            <h3 className="font-semibold text-gray-900 dark:text-white mb-2">
                                                {relatedProgram.name}
                                            </h3>
                                            <p className="text-sm text-gray-600 dark:text-gray-300 mb-3">
                                                ⏱️ {relatedProgram.duration}
                                            </p>
                                            <div className="flex items-center justify-between">
                                                <span className="text-lg font-bold text-green-600 dark:text-green-400">
                                                    {formatPrice(relatedProgram.price)}
                                                </span>
                                                <Link
                                                    href={`/programs/${relatedProgram.id}${ref ? `?ref=${ref}` : ''}`}
                                                    className="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium"
                                                >
                                                    View Details →
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    )}
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