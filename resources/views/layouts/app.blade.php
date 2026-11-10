<!DOCTYPE html>
<html lang="en" class="scroll-smooth" x-data="{ lang: 'en' }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'National Youth Dev - Technical Institute')</title>
    <link rel="icon" type="image/png" href="/favicon.png?v=2">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico?v=2">
    <link rel="apple-touch-icon" href="/favicon.png?v=2">
    
    <!-- Google Fonts: Hind Siliguri (Smooth universal font) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Hind Siliguri"', 'sans-serif'],
                        bangla: ['"Hind Siliguri"', 'sans-serif'],
                    },
                    fontSize: {
                        '2xs': ['0.8125rem', { lineHeight: '1.25rem' }],  // 13px
                        'xs': ['0.875rem', { lineHeight: '1.35rem' }],    // 14px (was 12px)
                        'sm': ['1rem', { lineHeight: '1.5rem' }],         // 16px (was 14px)
                        'base': ['1.125rem', { lineHeight: '1.75rem' }],  // 18px (was 16px)
                        'lg': ['1.25rem', { lineHeight: '1.85rem' }],     // 20px (was 18px)
                        'xl': ['1.375rem', { lineHeight: '1.95rem' }],    // 22px (was 20px)
                        '2xl': ['1.625rem', { lineHeight: '2.2rem' }],    // 26px (was 24px)
                        '3xl': ['2rem', { lineHeight: '2.5rem' }],        // 32px (was 30px)
                        '4xl': ['2.5rem', { lineHeight: '3rem' }],        // 40px (was 36px)
                        '5xl': ['3.25rem', { lineHeight: '3.75rem' }],    // 52px (was 48px)
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome 6 & Lucide Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        html {
            font-size: 16.5px;
        }
        body { 
            font-family: 'Hind Siliguri', sans-serif; 
            letter-spacing: -0.01em;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
    @stack('styles')
</head>
<body class="font-sans bg-[#F8FAFC] text-slate-800 antialiased min-h-screen flex flex-col justify-between text-base">

    <!-- Top Navigation Bar (100% Dynamic from Admin Dashboard CMS) -->
    <header class="w-full bg-white border-b border-slate-200/80 sticky top-0 z-50">
        @auth
            @php
                $navUser = auth()->user();
                $navIsAdmin = $navUser->isAdmin();
                $navDashboardUrl = $navIsAdmin ? route('admin.dashboard') : route('student.dashboard');
                $navRoleLabel = $navIsAdmin ? 'Admin Directorate' : ('Student • ' . ($navUser->student_roll ?: 'Trainee'));
                $navInitials = strtoupper(\Illuminate\Support\Str::substr(preg_replace('/\s+/', '', $navUser->name ?: 'NY'), 0, 2));
            @endphp
        @endauth
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-14 py-3.5 sm:py-4 flex items-center justify-between gap-3" x-data="{ isMobileOpen: false, userMenuOpen: false }">
            
            <!-- Dynamic Logo & Branding -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group min-w-0">
                @if(!empty($settings['headerLogoImage']))
                    <img src="{{ $settings['headerLogoImage'] }}" alt="{{ $settings['headerTitleMain'] ?? 'Logo' }}" class="h-10 sm:h-11 w-auto max-w-[140px] object-contain rounded-xl group-hover:scale-105 transition-transform shrink-0">
                @else
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white font-extrabold text-sm sm:text-base shadow-sm group-hover:scale-105 transition-transform shrink-0">
                        {{ $settings['headerLogoText'] ?? 'NYD' }}
                    </div>
                @endif
                <div class="flex flex-col min-w-0">
                    <span class="text-base sm:text-lg md:text-xl font-bold tracking-tight text-slate-900 leading-tight truncate">
                        {{ $settings['headerTitleMain'] ?? 'National Youth' }}
                        @if(!empty($settings['headerTitleHighlight']))
                            <span class="text-emerald-600">{{ $settings['headerTitleHighlight'] }}</span>
                        @endif
                    </span>
                    @if(!empty($settings['headerSubtitle']))
                        <span class="text-[11px] sm:text-xs font-semibold text-slate-400 tracking-wider uppercase mt-0.5 truncate">
                            {{ $settings['headerSubtitle'] }}
                        </span>
                    @endif
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden lg:flex items-center gap-3 xl:gap-5 text-[15px] font-medium text-slate-600">
                <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2 {{ request()->routeIs('home') ? 'text-emerald-700 bg-emerald-50/90 font-semibold' : 'hover:text-slate-900 hover:bg-slate-50 font-medium' }}">
                    <span>{{ $settings['navHomeText'] ?? 'Home' }}</span>
                </a>
                <a href="{{ route('courses.index') }}" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2 {{ request()->routeIs('courses.*') ? 'text-emerald-700 bg-emerald-50/90 font-semibold' : 'hover:text-slate-900 hover:bg-slate-50 font-medium' }}">
                    <span>{{ $settings['navCoursesText'] ?? 'Courses' }}</span>
                </a>
                <a href="{{ route('results.index') }}" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2 {{ request()->routeIs('results.*') ? 'text-emerald-700 bg-emerald-50/90 font-semibold' : 'hover:text-slate-900 hover:bg-slate-50 font-medium' }}">
                    <span>{{ $settings['navResultsText'] ?? 'Exam Result' }}</span>
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                </a>
                <a href="{{ route('gallery.index') }}" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2 {{ request()->routeIs('gallery.*') ? 'text-emerald-700 bg-emerald-50/90 font-semibold' : 'hover:text-slate-900 hover:bg-slate-50 font-medium' }}">
                    <span>{{ $settings['navGalleryText'] ?? 'Gallery' }}</span>
                </a>
                <a href="{{ route('resources.index') }}" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2 {{ request()->routeIs('resources.*') ? 'text-emerald-700 bg-emerald-50/90 font-semibold' : 'hover:text-slate-900 hover:bg-slate-50 font-medium' }}">
                    <span>{{ $settings['navResourcesText'] ?? 'Resources' }}</span>
                </a>
                <a href="{{ route('contact.index') }}" class="px-3.5 py-2 rounded-xl transition flex items-center gap-2 {{ request()->routeIs('contact.*') ? 'text-emerald-700 bg-emerald-50/90 font-semibold' : 'hover:text-slate-900 hover:bg-slate-50 font-medium' }}">
                    <span>{{ $settings['navContactText'] ?? 'Contact Us' }}</span>
                </a>
            </nav>

            <!-- Right Actions: Guest Login/Register OR Logged-In User Dropdown -->
            <div class="hidden sm:flex items-center gap-3 shrink-0">
                @guest
                    <a href="{{ route('login') }}" class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-800 text-sm font-semibold px-4 py-2.5 rounded-xl transition">
                        <i class="fa-solid fa-arrow-right-to-bracket text-slate-600 text-xs"></i>
                        <span>{{ $settings['headerLoginText'] ?? 'Login' }}</span>
                    </a>

                    <a href="{{ route('register') }}" class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition shadow-xs">
                        <i class="fa-solid fa-user-plus text-xs"></i>
                        <span>{{ $settings['headerRegisterText'] ?? 'Register' }}</span>
                    </a>
                @else
                    <div class="relative" @click.away="userMenuOpen = false" @keydown.escape.window="userMenuOpen = false">
                        <button
                            type="button"
                            @click="userMenuOpen = !userMenuOpen"
                            class="flex items-center gap-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-200/90 hover:border-emerald-300 pl-2 pr-3 py-1.5 rounded-2xl transition shadow-2xs cursor-pointer"
                            aria-expanded="false"
                            :aria-expanded="userMenuOpen.toString()"
                        >
                            <div class="relative w-8 h-8 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center font-bold text-xs shadow-2xs shrink-0">
                                {{ $navInitials }}
                                <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-emerald-400 border-2 border-white"></span>
                            </div>
                            <div class="text-left leading-tight min-w-0">
                                <span class="block text-xs sm:text-[13px] font-bold text-slate-900 max-w-[135px] truncate">
                                    {{ $navUser->name }}
                                </span>
                                <span class="block text-[10px] font-bold text-emerald-700 uppercase tracking-wider">
                                    {{ $navIsAdmin ? 'Administrator' : 'Student Portal' }}
                                </span>
                            </div>
                            <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200 ml-0.5" :class="userMenuOpen ? 'rotate-180 text-emerald-600' : ''"></i>
                        </button>

                        <!-- Account Dropdown Menu -->
                        <div
                            x-show="userMenuOpen"
                            x-cloak
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                            class="absolute right-0 mt-2.5 w-64 bg-white rounded-2xl border border-slate-200 shadow-2xl overflow-hidden z-50"
                        >
                            <!-- User Summary Header -->
                            <div class="bg-slate-50/90 border-b border-slate-200/80 px-4 py-3 space-y-1">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-xs font-extrabold text-slate-900 truncate">{{ $navUser->name }}</span>
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase tracking-wider {{ $navIsAdmin ? 'bg-slate-900 text-emerald-400' : 'bg-emerald-100 text-emerald-800' }}">
                                        {{ $navIsAdmin ? 'Admin' : 'Student' }}
                                    </span>
                                </div>
                                <p class="text-[11px] text-slate-500 truncate">{{ $navUser->email ?: $navRoleLabel }}</p>
                            </div>

                            <!-- Menu Options -->
                            <div class="p-1.5 space-y-1">
                                <a
                                    href="{{ $navDashboardUrl }}"
                                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-slate-800 hover:bg-emerald-50 hover:text-emerald-800 transition"
                                >
                                    <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-200/70 flex items-center justify-center shrink-0">
                                        <i class="fa-solid {{ $navIsAdmin ? 'fa-sliders' : 'fa-graduation-cap' }} text-xs"></i>
                                    </span>
                                    <div class="min-w-0">
                                        <span class="block leading-tight">{{ $navIsAdmin ? 'Admin Dashboard' : 'Student Dashboard' }}</span>
                                        <span class="block text-[10px] font-medium text-slate-400">{{ $navIsAdmin ? 'Control Center & CMS' : 'Courses & Marksheet' }}</span>
                                    </div>
                                </a>

                                @if(!$navIsAdmin)
                                    <a
                                        href="{{ route('student.dashboard', ['tab' => 'marksheet']) }}"
                                        class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition"
                                    >
                                        <span class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                                            <i class="fa-solid fa-file-lines text-xs"></i>
                                        </span>
                                        <span>My Marksheet &amp; Transcript</span>
                                    </a>
                                @endif

                                <div class="border-t border-slate-100 my-1"></div>

                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-rose-600 hover:bg-rose-50 transition text-left cursor-pointer"
                                    >
                                        <span class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 border border-rose-200/70 flex items-center justify-center shrink-0">
                                            <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                                        </span>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="flex items-center gap-2 lg:hidden shrink-0">
                <button
                    @click="isMobileOpen = !isMobileOpen"
                    class="p-2 text-slate-700 hover:bg-slate-100 rounded-xl transition"
                    aria-label="Open menu"
                >
                    <i class="fa-solid" :class="isMobileOpen ? 'fa-xmark text-xl' : 'fa-bars text-xl'"></i>
                </button>
            </div>

            <!-- Mobile Dropdown Menu -->
            <div x-show="isMobileOpen" x-cloak @click.away="isMobileOpen = false" class="lg:hidden absolute top-full left-0 w-full bg-white border-b border-slate-200 shadow-xl px-6 py-4 flex flex-col gap-2 z-50">
                <a href="{{ route('home') }}" class="px-4 py-2.5 rounded-xl text-slate-800 font-semibold hover:bg-slate-50">{{ $settings['navHomeText'] ?? 'Home' }}</a>
                <a href="{{ route('courses.index') }}" class="px-4 py-2.5 rounded-xl text-slate-800 font-semibold hover:bg-slate-50">{{ $settings['navCoursesText'] ?? 'Courses' }}</a>
                <a href="{{ route('results.index') }}" class="px-4 py-2.5 rounded-xl text-slate-800 font-semibold hover:bg-slate-50 flex items-center justify-between">
                    <span>{{ $settings['navResultsText'] ?? 'Exam Result' }}</span>
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                </a>
                <a href="{{ route('gallery.index') }}" class="px-4 py-2.5 rounded-xl text-slate-800 font-semibold hover:bg-slate-50">{{ $settings['navGalleryText'] ?? 'Gallery' }}</a>
                <a href="{{ route('resources.index') }}" class="px-4 py-2.5 rounded-xl text-slate-800 font-semibold hover:bg-slate-50">{{ $settings['navResourcesText'] ?? 'Resources' }}</a>
                <a href="{{ route('contact.index') }}" class="px-4 py-2.5 rounded-xl text-slate-800 font-semibold hover:bg-slate-50">{{ $settings['navContactText'] ?? 'Contact Us' }}</a>
                @guest
                    <div class="pt-2 border-t border-slate-100 flex gap-2">
                        <a href="{{ route('login') }}" class="flex-1 text-center bg-slate-100 py-2.5 rounded-xl font-semibold text-sm text-slate-800">{{ $settings['headerLoginText'] ?? 'Login' }}</a>
                        <a href="{{ route('register') }}" class="flex-1 text-center bg-emerald-600 py-2.5 rounded-xl font-semibold text-sm text-white">{{ $settings['headerRegisterText'] ?? 'Register' }}</a>
                    </div>
                @else
                    <div class="pt-3 mt-1 border-t border-slate-200 space-y-2.5">
                        <div class="flex items-center gap-3 px-3 py-2 rounded-xl bg-slate-50 border border-slate-200/80">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center font-bold text-xs shrink-0">
                                {{ $navInitials }}
                            </div>
                            <div class="min-w-0">
                                <span class="block text-sm font-bold text-slate-900 truncate">{{ $navUser->name }}</span>
                                <span class="block text-[11px] font-semibold text-emerald-700">{{ $navRoleLabel }}</span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ $navDashboardUrl }}" class="flex-1 text-center bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 px-3 rounded-xl font-semibold text-sm flex items-center justify-center gap-1.5">
                                <i class="fa-solid {{ $navIsAdmin ? 'fa-sliders' : 'fa-graduation-cap' }} text-xs"></i>
                                <span>Dashboard</span>
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="flex-1 m-0">
                                @csrf
                                <button type="submit" class="w-full text-center bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 py-2.5 px-3 rounded-xl font-semibold text-sm flex items-center justify-center gap-1.5 cursor-pointer">
                                    <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

        </div>
    </header>

    <!-- Floating Toast Notification Popups (English, Auto-Dismiss, Modern SaaS) -->
    @if(session('success'))
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => show = false, 6000)"
            x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed top-20 inset-x-4 sm:inset-x-auto sm:right-6 z-50 sm:max-w-md sm:w-full shadow-2xl rounded-2xl bg-white border border-emerald-200 p-4 flex items-start gap-3"
            role="alert"
        >
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100 text-lg">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="flex-1 min-w-0 pt-0.5">
                <h4 class="text-sm font-bold text-slate-900 leading-tight">Success Notification</h4>
                <p class="text-xs text-slate-600 mt-0.5 leading-relaxed font-normal">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg transition shrink-0">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => show = false, 8000)"
            x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed top-20 inset-x-4 sm:inset-x-auto sm:right-6 z-50 sm:max-w-md sm:w-full shadow-2xl rounded-2xl bg-white border border-rose-200 p-4 flex items-start gap-3"
            role="alert"
        >
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 border border-rose-100 text-lg">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div class="flex-1 min-w-0 pt-0.5">
                <h4 class="text-sm font-bold text-slate-900 leading-tight">Attention</h4>
                <p class="text-xs text-slate-600 mt-0.5 leading-relaxed font-normal">{{ session('error') }}</p>
            </div>
            <button @click="show = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg transition shrink-0">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
    @endif

    <!-- Main Content Slot -->
    <main class="flex-1">

        @yield('content')
    </main>

    <!-- Footer (Clean Institutional 3-Column Layout, 100% Dynamic CMS) -->
    <footer class="w-full bg-slate-950 text-slate-300 border-t border-slate-800 pt-10 sm:pt-12 pb-6">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-14">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-10 pb-8 border-b border-slate-800/80">

                <!-- Column 1: Brand & Social Links -->
                <div class="lg:col-span-5 space-y-4">
                    <div class="flex items-center gap-3">
                        @if(!empty($settings['headerLogoImage']))
                            <img src="{{ $settings['headerLogoImage'] }}" alt="{{ $settings['footerBrandTitle'] ?? 'Logo' }}" class="h-12 w-auto max-w-[140px] object-contain rounded-xl bg-white/10 p-1 shrink-0">
                        @else
                            <div class="w-11 h-11 rounded-xl bg-emerald-600 flex items-center justify-center text-white font-black text-sm shrink-0">
                                {{ $settings['headerLogoText'] ?? 'NYD' }}
                            </div>
                        @endif
                        <div>
                            <span class="text-lg sm:text-xl font-bold text-white tracking-tight leading-tight block">
                                {{ $settings['footerBrandTitle'] ?? 'National Youth Development' }}
                            </span>
                            <span class="text-xs font-semibold text-emerald-400 uppercase tracking-wider block mt-0.5">
                                {{ $settings['footerBrandSubtitle'] ?? 'Technical Training Platform' }}
                            </span>
                        </div>
                    </div>

                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed max-w-md">
                        {{ $settings['footerDescription'] ?? 'A premier technical institute dedicated to empowering youth through practical engineering, computer sciences, and vocational training.' }}
                    </p>

                    @if(!empty($settings['socialLinksArray']))
                        <div class="flex flex-wrap items-center gap-2 pt-1">
                            @foreach($settings['socialLinksArray'] as $soc)
                                @if(!empty($soc['url']))
                                    <a href="{{ $soc['url'] }}" target="_blank" rel="noopener noreferrer" title="{{ $soc['platform'] ?? 'Social Link' }}" class="w-9 h-9 rounded-lg bg-slate-900 {{ $soc['color'] ?? 'hover:bg-emerald-600' }} hover:text-white text-slate-400 border border-slate-800 flex items-center justify-center transition">
                                        <i class="{{ $soc['icon'] ?? 'fa-solid fa-globe' }} text-xs"></i>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Column 2: Quick Links (Single Clean Line per Link) -->
                <div class="lg:col-span-3 space-y-3.5">
                    <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-white block">
                        {{ $settings['footerCol3Title'] ?? 'Quick Links' }}
                    </span>
                    <ul class="space-y-2 text-xs sm:text-sm font-medium text-slate-300">
                        <li><a href="{{ route('home') }}" class="hover:text-emerald-400 transition">Home</a></li>
                        <li><a href="{{ route('courses.index') }}" class="hover:text-emerald-400 transition">All Courses</a></li>
                        <li><a href="{{ route('results.index') }}" class="hover:text-emerald-400 transition">Exam Result</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-emerald-400 transition">Online Admission</a></li>
                        <li><a href="{{ route('gallery.index') }}" class="hover:text-emerald-400 transition">Photo Gallery</a></li>
                        <li><a href="{{ route('resources.index') }}" class="hover:text-emerald-400 transition">Resources &amp; Forms</a></li>
                        <li><a href="{{ route('contact.index') }}" class="hover:text-emerald-400 transition">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Column 3: Contact & Office Hours -->
                <div class="lg:col-span-4 space-y-3.5">
                    <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-white block">
                        {{ $settings['footerCol4Title'] ?? 'Contact Directorate' }}
                    </span>
                    <div class="space-y-2.5 text-xs sm:text-sm text-slate-300">
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-location-dot text-emerald-400 mt-1 shrink-0 text-xs"></i>
                            <span class="leading-snug">{{ $settings['headquartersAddress'] ?? 'Youth Bhaban Complex, Mirpur-2, Dhaka-1216, Bangladesh' }}</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-phone text-emerald-400 shrink-0 text-xs"></i>
                            <a href="tel:{{ $settings['helplinePhone'] ?? '+8801712345678' }}" class="font-semibold text-white hover:text-emerald-400 transition">{{ $settings['helplinePhone'] ?? '+880 1712-345678' }}</a>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-envelope text-emerald-400 shrink-0 text-xs"></i>
                            <a href="mailto:{{ $settings['helplineEmail'] ?? 'support@jubounnayon.com' }}" class="hover:text-emerald-400 transition break-all">{{ $settings['helplineEmail'] ?? 'support@jubounnayon.com' }}</a>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i class="fa-regular fa-clock text-emerald-400 mt-1 shrink-0 text-xs"></i>
                            <div class="leading-snug text-xs">
                                <span>{{ $settings['officeWeeklyDays'] ?? 'Sun - Thu (Fri - Sat Closed)' }}</span>
                                <span class="block text-slate-200 font-semibold mt-0.5">
                                    {{ $settings['officeOpeningTime'] ?? '9:00 AM' }} – {{ $settings['officeClosingTime'] ?? '5:00 PM' }}
                                    @if(($settings['officeStatus'] ?? 'open') === 'open')
                                        <span class="text-emerald-400 font-semibold ml-1.5">• {{ $settings['officeOpenLabel'] ?? 'Open Today' }}</span>
                                    @else
                                        <span class="text-rose-400 font-semibold ml-1.5">• {{ $settings['officeClosedLabel'] ?? 'Closed Today' }}</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright & Back to Top -->
            @php
                $rawCopyright = trim((string) ($settings['footerCopyright'] ?? 'National Youth Development Platform. All rights reserved.'));
                $formattedCopyright = preg_match('/^(?:©|&copy;|\x{00A9})/iu', $rawCopyright)
                    ? $rawCopyright
                    : ('© ' . date('Y') . ' ' . $rawCopyright);
            @endphp
            <div class="pt-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-400 text-center sm:text-left">
                <p>{{ $formattedCopyright }}</p>
                <div class="flex items-center gap-3">
                    @if(!empty($settings['footerSupervisedOrg']))
                        <span>{{ $settings['footerSupervisedLabel'] ?? 'Supervised by' }} <strong class="text-slate-200">{{ $settings['footerSupervisedOrg'] }}</strong></span>
                    @endif
                    <button type="button" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })" class="px-2.5 py-1.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-slate-300 border border-slate-800 transition cursor-pointer" title="Back to top">
                        <i class="fa-solid fa-arrow-up text-xs"></i>
                    </button>
                </div>
            </div>

        </div>
    </footer>

    @stack('scripts')
</body>
</html>
