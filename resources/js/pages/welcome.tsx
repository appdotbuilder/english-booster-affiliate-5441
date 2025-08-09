import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="English Booster - Affiliate Marketing Platform">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
                <meta name="description" content="Join English Booster's affiliate program and earn commissions promoting premium English courses. Online, offline, and specialized programs available." />
            </Head>
            <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
                {/* Navigation */}
                <header className="relative px-6 py-4">
                    <div className="mx-auto max-w-7xl">
                        <nav className="flex items-center justify-between">
                            <div className="flex items-center space-x-2">
                                <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-indigo-600 text-white font-bold text-lg">
                                    EB
                                </div>
                                <span className="text-xl font-bold text-gray-900 dark:text-white">English Booster</span>
                            </div>
                            <div className="flex items-center space-x-4">
                                <Link 
                                    href={route('programs.index')} 
                                    className="text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition-colors"
                                >
                                    Programs
                                </Link>
                                {auth.user ? (
                                    <Link
                                        href={route('dashboard')}
                                        className="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-lg"
                                    >
                                        Dashboard
                                    </Link>
                                ) : (
                                    <div className="flex items-center space-x-3">
                                        <Link
                                            href={route('login')}
                                            className="text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition-colors"
                                        >
                                            Login
                                        </Link>
                                        <Link
                                            href={route('register')}
                                            className="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-lg"
                                        >
                                            Join as Affiliate
                                        </Link>
                                    </div>
                                )}
                            </div>
                        </nav>
                    </div>
                </header>

                {/* Hero Section */}
                <main className="relative">
                    <div className="mx-auto max-w-7xl px-6 py-16 sm:py-24">
                        <div className="text-center">
                            <h1 className="text-4xl sm:text-6xl font-bold tracking-tight text-gray-900 dark:text-white">
                                🚀 <span className="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">English Booster</span>
                                <br />
                                Affiliate Platform
                            </h1>
                            <p className="mx-auto mt-6 max-w-2xl text-lg leading-8 text-gray-600 dark:text-gray-300">
                                Join our affiliate program and earn commissions promoting premium English courses. 
                                From online programs to intensive Pare camps - help students achieve their language goals while building your income.
                            </p>
                            <div className="mt-10 flex items-center justify-center gap-4">
                                {auth.user ? (
                                    <Link
                                        href={route('dashboard')}
                                        className="inline-flex items-center px-6 py-3 text-base font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-lg hover:shadow-xl transition-all"
                                    >
                                        Go to Dashboard
                                    </Link>
                                ) : (
                                    <>
                                        <Link
                                            href={route('register')}
                                            className="inline-flex items-center px-6 py-3 text-base font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-lg hover:shadow-xl transition-all"
                                        >
                                            🎯 Become an Affiliate
                                        </Link>
                                        <Link
                                            href={route('programs.index')}
                                            className="inline-flex items-center px-6 py-3 text-base font-medium text-blue-600 bg-white hover:bg-blue-50 rounded-lg border border-blue-200 hover:border-blue-300 transition-all"
                                        >
                                            📚 Browse Programs
                                        </Link>
                                    </>
                                )}
                            </div>
                        </div>

                        {/* Feature Cards */}
                        <div className="mt-20 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <div className="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-slate-700 hover:shadow-xl transition-shadow">
                                <div className="h-12 w-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                                    <span className="text-2xl">💰</span>
                                </div>
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">High Commission Rates</h3>
                                <p className="text-gray-600 dark:text-gray-300">Earn up to 25% commission on each successful referral. Premium programs offer higher rates.</p>
                            </div>

                            <div className="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-slate-700 hover:shadow-xl transition-shadow">
                                <div className="h-12 w-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4">
                                    <span className="text-2xl">📊</span>
                                </div>
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">Real-time Analytics</h3>
                                <p className="text-gray-600 dark:text-gray-300">Track clicks, conversions, and earnings in real-time. Complete transparency on your performance.</p>
                            </div>

                            <div className="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-slate-700 hover:shadow-xl transition-shadow">
                                <div className="h-12 w-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mb-4">
                                    <span className="text-2xl">🎓</span>
                                </div>
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">Diverse Programs</h3>
                                <p className="text-gray-600 dark:text-gray-300">Promote 20+ programs: Online courses, Pare camps, group programs, and specialized training.</p>
                            </div>

                            <div className="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-slate-700 hover:shadow-xl transition-shadow">
                                <div className="h-12 w-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center mb-4">
                                    <span className="text-2xl">🔗</span>
                                </div>
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">Easy Link Sharing</h3>
                                <p className="text-gray-600 dark:text-gray-300">Get your unique referral codes and program-specific links. Share anywhere, anytime.</p>
                            </div>

                            <div className="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-slate-700 hover:shadow-xl transition-shadow">
                                <div className="h-12 w-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center mb-4">
                                    <span className="text-2xl">💳</span>
                                </div>
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">Flexible Payouts</h3>
                                <p className="text-gray-600 dark:text-gray-300">Choose from bank transfer, PayPal, e-wallet, or crypto. Regular payout schedules available.</p>
                            </div>

                            <div className="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-slate-700 hover:shadow-xl transition-shadow">
                                <div className="h-12 w-12 bg-teal-100 dark:bg-teal-900 rounded-lg flex items-center justify-center mb-4">
                                    <span className="text-2xl">🎯</span>
                                </div>
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">Marketing Support</h3>
                                <p className="text-gray-600 dark:text-gray-300">Access marketing materials, program details, and promotional content to boost your success.</p>
                            </div>
                        </div>

                        {/* Program Categories */}
                        <div className="mt-20">
                            <div className="text-center mb-12">
                                <h2 className="text-3xl font-bold text-gray-900 dark:text-white mb-4">📚 Program Categories</h2>
                                <p className="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                                    Promote a wide range of English programs designed for different age groups and learning objectives.
                                </p>
                            </div>
                            
                            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <div className="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white">
                                    <div className="text-3xl mb-3">💻</div>
                                    <h3 className="text-xl font-bold mb-2">Online Programs</h3>
                                    <p className="text-blue-100 text-sm mb-3">Kids, Teen, TOEFL, Speaking Booster, Grammar Booster</p>
                                    <div className="text-lg font-semibold">8 Programs</div>
                                </div>

                                <div className="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white">
                                    <div className="text-3xl mb-3">🏕️</div>
                                    <h3 className="text-xl font-bold mb-2">Pare Camps</h3>
                                    <p className="text-green-100 text-sm mb-3">Intensive English immersion programs in Pare, Kediri</p>
                                    <div className="text-lg font-semibold">7 Programs</div>
                                </div>

                                <div className="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white">
                                    <div className="text-3xl mb-3">👥</div>
                                    <h3 className="text-xl font-bold mb-2">Group Programs</h3>
                                    <p className="text-purple-100 text-sm mb-3">English trips, workshops, and tutor visits</p>
                                    <div className="text-lg font-semibold">3 Programs</div>
                                </div>

                                <div className="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-6 text-white">
                                    <div className="text-3xl mb-3">🏫</div>
                                    <h3 className="text-xl font-bold mb-2">Branch Programs</h3>
                                    <p className="text-orange-100 text-sm mb-3">Age-specific programs from pre-school to high school</p>
                                    <div className="text-lg font-semibold">4 Programs</div>
                                </div>
                            </div>
                        </div>

                        {/* CTA Section */}
                        {!auth.user && (
                            <div className="mt-20 text-center bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-12">
                                <h2 className="text-3xl font-bold text-white mb-4">
                                    🌟 Ready to Start Earning?
                                </h2>
                                <p className="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
                                    Join hundreds of affiliates already earning commissions by promoting quality English education. 
                                    Start your affiliate journey today!
                                </p>
                                <Link
                                    href={route('register')}
                                    className="inline-flex items-center px-8 py-4 text-lg font-medium text-blue-600 bg-white hover:bg-blue-50 rounded-lg shadow-lg hover:shadow-xl transition-all"
                                >
                                    🚀 Join Now - It's Free
                                </Link>
                            </div>
                        )}
                    </div>
                </main>

                {/* Footer */}
                <footer className="border-t border-gray-200 dark:border-gray-700 py-12">
                    <div className="mx-auto max-w-7xl px-6">
                        <div className="text-center">
                            <div className="flex items-center justify-center space-x-2 mb-4">
                                <div className="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-indigo-600 text-white font-bold">
                                    EB
                                </div>
                                <span className="text-lg font-bold text-gray-900 dark:text-white">English Booster</span>
                            </div>
                            <p className="text-gray-600 dark:text-gray-300 mb-4">
                                Empowering English learners through quality education and affiliate partnerships.
                            </p>
                            <div className="flex items-center justify-center space-x-6 text-sm text-gray-500 dark:text-gray-400">
                                <Link href={route('programs.index')} className="hover:text-blue-600 transition-colors">
                                    Programs
                                </Link>
                                <span>•</span>
                                <span>Contact: admin@englishbooster.com</span>
                                <span>•</span>
                                <span>📱 +62 812-3456-7890</span>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}