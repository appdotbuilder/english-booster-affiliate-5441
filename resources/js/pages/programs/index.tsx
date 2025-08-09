import React, { useState } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import { Program, PaginatedData } from '@/types';

interface Props {
    programs: PaginatedData<Program>;
    program_types: Record<string, string>;
    filters: {
        search?: string;
        type?: string;
    };
    ref?: string;
}

export default function ProgramsIndex({ programs, program_types, filters, ref }: Props) {
    const [search, setSearch] = useState(filters.search || '');
    const [type, setType] = useState(filters.type || 'all');

    const handleFilter = () => {
        router.get('/programs', {
            search: search || undefined,
            type: type !== 'all' ? type : undefined,
            ref: ref || undefined,
        }, {
            preserveState: true,
        });
    };

    const handleReset = () => {
        setSearch('');
        setType('all');
        router.get('/programs', {
            ref: ref || undefined,
        });
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
            <Head title="English Programs - English Booster" />
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
                            {ref && (
                                <div className="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-3 py-1 rounded-full text-sm font-medium">
                                    🎯 Referred by affiliate
                                </div>
                            )}
                        </div>
                    </div>
                </header>

                <main className="mx-auto max-w-7xl px-6 py-8">
                    {/* Page Header */}
                    <div className="mb-8">
                        <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                            📚 English Programs
                        </h1>
                        <p className="text-gray-600 dark:text-gray-300">
                            Discover our comprehensive English learning programs designed for all ages and skill levels.
                        </p>
                    </div>

                    {/* Filters */}
                    <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-8">
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label htmlFor="search" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Search Programs
                                </label>
                                <input
                                    id="search"
                                    type="text"
                                    value={search}
                                    onChange={(e) => setSearch(e.target.value)}
                                    placeholder="Search by name or description..."
                                    className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                />
                            </div>
                            <div>
                                <label htmlFor="type" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Program Type
                                </label>
                                <select
                                    id="type"
                                    value={type}
                                    onChange={(e) => setType(e.target.value)}
                                    className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                >
                                    <option value="all">All Types</option>
                                    {Object.entries(program_types).map(([key, label]) => (
                                        <option key={key} value={key}>{label}</option>
                                    ))}
                                </select>
                            </div>
                            <div className="flex items-end space-x-2">
                                <button
                                    onClick={handleFilter}
                                    className="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                                >
                                    🔍 Filter
                                </button>
                                <button
                                    onClick={handleReset}
                                    className="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors"
                                >
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>

                    {/* Programs Grid */}
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {programs.data.map((program) => (
                            <div key={program.id} className="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                                {program.image_url && (
                                    <img
                                        src={program.image_url}
                                        alt={program.name}
                                        className="w-full h-48 object-cover"
                                    />
                                )}
                                <div className="p-6">
                                    <div className="flex items-center justify-between mb-3">
                                        <span className="inline-block bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs px-2 py-1 rounded-full">
                                            {program_types[program.type]}
                                        </span>
                                        <span className="text-sm text-gray-500 dark:text-gray-400">
                                            ⏱️ {program.duration}
                                        </span>
                                    </div>
                                    
                                    <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-2">
                                        {program.name}
                                    </h3>
                                    
                                    <p className="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-3">
                                        {program.description}
                                    </p>

                                    {program.features && program.features.length > 0 && (
                                        <div className="mb-4">
                                            <div className="flex flex-wrap gap-1">
                                                {program.features.slice(0, 3).map((feature, index) => (
                                                    <span
                                                        key={index}
                                                        className="inline-block bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-xs px-2 py-1 rounded"
                                                    >
                                                        ✅ {feature}
                                                    </span>
                                                ))}
                                            </div>
                                        </div>
                                    )}

                                    <div className="flex items-center justify-between">
                                        <div className="text-2xl font-bold text-green-600 dark:text-green-400">
                                            {formatPrice(program.price)}
                                        </div>
                                        <Link
                                            href={`/programs/${program.id}${ref ? `?ref=${ref}` : ''}`}
                                            className="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors"
                                        >
                                            View Details
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>

                    {/* Empty State */}
                    {programs.data.length === 0 && (
                        <div className="text-center py-12">
                            <div className="text-6xl mb-4">📚</div>
                            <h3 className="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                No programs found
                            </h3>
                            <p className="text-gray-600 dark:text-gray-300 mb-4">
                                Try adjusting your search or filter criteria.
                            </p>
                            <button
                                onClick={handleReset}
                                className="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                            >
                                Show All Programs
                            </button>
                        </div>
                    )}

                    {/* Pagination */}
                    {programs.data.length > 0 && (programs.prev_page_url || programs.next_page_url) && (
                        <div className="mt-8 flex items-center justify-center space-x-4">
                            {programs.prev_page_url && (
                                <Link
                                    href={programs.prev_page_url}
                                    className="px-4 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                >
                                    ← Previous
                                </Link>
                            )}
                            <span className="text-gray-600 dark:text-gray-300">
                                Page {programs.current_page} of {programs.last_page}
                            </span>
                            {programs.next_page_url && (
                                <Link
                                    href={programs.next_page_url}
                                    className="px-4 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                >
                                    Next →
                                </Link>
                            )}
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