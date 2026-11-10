@extends('layouts.app')

@section('title', 'National Youth Dev - Technical Institute | Empowering Youth Across Bangladesh')

@section('content')

<!-- 1. Hero Slider Section (Dynamic from Database & CMS) -->
<section 
    class="relative w-full overflow-hidden h-[520px] sm:h-[560px] md:h-[590px] lg:h-[610px] flex items-center bg-slate-900"
    x-data="{
        current: 0,
        slides: @js($heroSlides),
        timer: null
    }"
    x-init="
        if (slides && slides.length > 1) {
            timer = setInterval(() => { current = (current + 1) % slides.length }, 5500);
        }
    "
>
    <!-- Background Image -->
    <template x-for="(slide, idx) in slides" :key="idx">
        <div 
            x-show="current === idx" 
            x-transition:enter="transition-opacity duration-700 ease-in-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="absolute inset-0 w-full h-full z-0"
        >
            <img :src="slide.bg_image || 'https://images.unsplash.com/photo-1571260899304-425eee4c7efc?q=80&w=1600&auto=format&fit=crop'" :alt="slide.title" class="w-full h-full object-cover">
        </div>
    </template>

    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-950/70 to-slate-950/30 z-10"></div>
    <div class="absolute inset-0 bg-slate-950/20 z-10"></div>

    <!-- Content: Smooth & Comfortable -->
    <div class="relative z-20 max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-14 w-full flex flex-col justify-center">
        <div class="max-w-2xl space-y-4 sm:space-y-5" x-show="slides && slides.length > 0">
            
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs sm:text-sm font-semibold backdrop-blur-md" x-show="slides[current].badge">
                <i class="fa-solid fa-shield-halved text-emerald-400 text-xs"></i>
                <span x-text="slides[current].badge"></span>
            </div>

            <!-- Title: Smooth font-bold -->
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white tracking-tight leading-tight">
                <span x-text="slides[current].title"></span>
            </h1>

            <!-- Subtitle -->
            <p class="text-xs sm:text-sm md:text-base text-slate-200 leading-relaxed max-w-xl font-normal">
                <span x-text="slides[current].subtitle"></span>
            </p>

            <!-- Highlights Pill -->
            <div class="flex flex-wrap items-center gap-2.5 text-xs sm:text-sm text-slate-200 pt-1">
                <span class="flex items-center gap-1.5 bg-white/10 px-3 py-1.5 rounded-xl border border-white/15 backdrop-blur-xs font-medium" x-show="slides[current].duration">
                    <i class="fa-regular fa-clock text-emerald-400"></i>
                    <span x-text="slides[current].duration"></span>
                </span>
                <span class="flex items-center gap-1.5 bg-white/10 px-3 py-1.5 rounded-xl border border-white/15 backdrop-blur-xs font-medium" x-show="slides[current].highlight">
                    <i class="fa-solid fa-award text-amber-400"></i>
                    <span x-text="slides[current].highlight"></span>
                </span>
            </div>

            <!-- Buttons -->
            <div class="flex flex-wrap items-center gap-3 pt-2">
                <a :href="slides[current].btn1_link || '{{ route('courses.index') }}'" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs sm:text-sm px-6 py-3 rounded-xl transition shadow-md shadow-emerald-900/30">
                    <span x-text="slides[current].btn1_text || 'Explore Programs'"></span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
                <a :href="slides[current].btn2_link || '{{ route('register') }}'" class="inline-flex items-center gap-2 bg-white/15 hover:bg-white/25 text-white border border-white/25 font-semibold text-xs sm:text-sm px-6 py-3 rounded-xl transition backdrop-blur-md">
                    <span x-text="slides[current].btn2_text || 'Apply for Admission'"></span>
                </a>
            </div>

        </div>

        <!-- Slide Indicators -->
        <div class="flex items-center gap-2 mt-8 sm:mt-10" x-show="slides && slides.length > 1">
            <template x-for="(slide, idx) in slides" :key="idx">
                <button 
                    type="button" 
                    @click="current = idx" 
                    :class="current === idx ? 'w-8 bg-emerald-400' : 'w-2 bg-white/40 hover:bg-white/70'" 
                    class="h-2 rounded-full transition-all duration-300"
                    :aria-label="'Slide ' + (idx + 1)"
                ></button>
            </template>
        </div>
    </div>
</section>

<!-- 2. Impact Stats Section (4 Individual Cards Matching Images 1 & 2) -->
<section class="w-full max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-14 py-8 sm:py-12">
    <!-- 4 Individual SaaS Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
        
        <!-- Stat Card 1 -->
        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/90 shadow-xs hover:shadow-xl hover:border-emerald-500/40 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
            <div>
                <div class="flex items-center justify-between gap-3 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center transition-transform group-hover:scale-110 duration-300 shadow-xs shrink-0">
                        <i class="fa-solid fa-graduation-cap text-xl"></i>
                    </div>
                    <span class="text-[11px] font-semibold px-3 py-1 rounded-full border bg-emerald-50 text-emerald-700 border-emerald-200 shrink-0">
                        {{ $settings['stat1Badge'] ?? 'Verified Diplomas' }}
                    </span>
                </div>
                <div class="text-3xl sm:text-4xl font-bold text-slate-800 tracking-tight leading-none">
                    {{ $settings['stat1Number'] ?? '1,500+' }}
                </div>
                <div class="text-sm sm:text-base font-semibold text-slate-700 mt-2">
                    {{ $settings['stat1Title'] ?? 'Certified Trainees' }}
                </div>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    {{ $settings['stat1Subtext'] ?? 'Govt-recognized technical and ICT graduates' }}
                </p>
            </div>
            <div class="w-full h-1 bg-slate-100 rounded-full mt-6 overflow-hidden">
                <div class="h-full w-4/5 bg-emerald-500 rounded-full transition-all duration-500 group-hover:w-full"></div>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/90 shadow-xs hover:shadow-xl hover:border-blue-500/40 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
            <div>
                <div class="flex items-center justify-between gap-3 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center transition-transform group-hover:scale-110 duration-300 shadow-xs shrink-0">
                        <i class="fa-solid fa-book-open text-xl"></i>
                    </div>
                    <span class="text-[11px] font-semibold px-3 py-1 rounded-full border bg-blue-50 text-blue-700 border-blue-200 shrink-0">
                        {{ $settings['stat2Badge'] ?? 'Practical Syllabus' }}
                    </span>
                </div>
                <div class="text-3xl sm:text-4xl font-bold text-slate-800 tracking-tight leading-none">
                    {{ $settings['stat2Number'] ?? '150+' }}
                </div>
                <div class="text-sm sm:text-base font-semibold text-slate-700 mt-2">
                    {{ $settings['stat2Title'] ?? 'Industry Courses' }}
                </div>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    {{ $settings['stat2Subtext'] ?? 'Hands-on trades, engineering & digital programs' }}
                </p>
            </div>
            <div class="w-full h-1 bg-slate-100 rounded-full mt-6 overflow-hidden">
                <div class="h-full w-3/4 bg-blue-500 rounded-full transition-all duration-500 group-hover:w-full"></div>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/90 shadow-xs hover:shadow-xl hover:border-purple-500/40 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
            <div>
                <div class="flex items-center justify-between gap-3 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 border border-purple-100 text-purple-600 flex items-center justify-center transition-transform group-hover:scale-110 duration-300 shadow-xs shrink-0">
                        <i class="fa-solid fa-building-columns text-xl"></i>
                    </div>
                    <span class="text-[11px] font-semibold px-3 py-1 rounded-full border bg-purple-50 text-purple-700 border-purple-200 shrink-0">
                        {{ $settings['stat3Badge'] ?? 'Across Bangladesh' }}
                    </span>
                </div>
                <div class="text-3xl sm:text-4xl font-bold text-slate-800 tracking-tight leading-none">
                    {{ $settings['stat3Number'] ?? '64+' }}
                </div>
                <div class="text-sm sm:text-base font-semibold text-slate-700 mt-2">
                    {{ $settings['stat3Title'] ?? 'Regional Branches' }}
                </div>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    {{ $settings['stat3Subtext'] ?? 'Accredited training centers nationwide' }}
                </p>
            </div>
            <div class="w-full h-1 bg-slate-100 rounded-full mt-6 overflow-hidden">
                <div class="h-full w-2/3 bg-purple-500 rounded-full transition-all duration-500 group-hover:w-full"></div>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/90 shadow-xs hover:shadow-xl hover:border-amber-500/40 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
            <div>
                <div class="flex items-center justify-between gap-3 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center transition-transform group-hover:scale-110 duration-300 shadow-xs shrink-0">
                        <i class="fa-solid fa-chart-line text-xl"></i>
                    </div>
                    <span class="text-[11px] font-semibold px-3 py-1 rounded-full border bg-amber-50 text-amber-700 border-amber-200 shrink-0">
                        {{ $settings['stat4Badge'] ?? 'Self-Reliance' }}
                    </span>
                </div>
                <div class="text-3xl sm:text-4xl font-bold text-slate-800 tracking-tight leading-none">
                    {{ $settings['stat4Number'] ?? '94.2%' }}
                </div>
                <div class="text-sm sm:text-base font-semibold text-slate-700 mt-2">
                    {{ $settings['stat4Title'] ?? 'Employment Rate' }}
                </div>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    {{ $settings['stat4Subtext'] ?? 'Active placement and startup support for youth' }}
                </p>
            </div>
            <div class="w-full h-1 bg-slate-100 rounded-full mt-6 overflow-hidden">
                <div class="h-full w-11/12 bg-amber-500 rounded-full transition-all duration-500 group-hover:w-full"></div>
            </div>
        </div>

    </div>

    <!-- Centered Platform Badge (Matching Image 1 & 2) -->
    <div class="flex justify-center mt-8 sm:mt-10">
        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-emerald-200 bg-emerald-50 text-emerald-800 text-xs sm:text-sm font-semibold shadow-xs">
            <i class="fa-solid fa-graduation-cap text-emerald-600"></i>
            <span>{{ $settings['statBottomBadge'] ?? 'National Youth Development Platform' }}</span>
        </span>
    </div>
</section>

<!-- 3. About Section (Smooth & Balanced - Matches Image 4 Exactly) -->
<section class="w-full max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-14 py-8 sm:py-14">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
        
        <!-- Left Visual with Floating Badges -->
        <div class="lg:col-span-5 relative">
            <div class="relative rounded-3xl overflow-hidden border border-slate-200/90 shadow-lg bg-slate-900 group">
                <img
                    src="{{ $settings['aboutImage'] ?? 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1200&auto=format&fit=crop' }}"
                    alt="Youth Skill Development Students"
                    class="w-full h-[400px] sm:h-[460px] object-cover group-hover:scale-105 transition-transform duration-700"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>

                <!-- Bottom Floating Summary Banner -->
                <div class="absolute bottom-5 left-5 right-5 bg-white/95 backdrop-blur-md rounded-2xl p-4 border border-white/50 shadow-md">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500 text-slate-950 font-bold flex items-center justify-center text-sm shadow-xs shrink-0">
                            <i class="fa-solid fa-award text-slate-950 text-base"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-800">
                                <span>National Technical Standards</span>
                            </div>
                            <div class="text-[11px] text-slate-500">
                                <span>Supervised by Senior Certified Instructors</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Floating Dark Badge (15+ Years of Excellence) -->
            <div class="absolute -top-3 -right-3 sm:-top-4 sm:-right-4 bg-slate-900 text-white px-4 py-3 rounded-2xl shadow-xl border border-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 font-bold flex items-center justify-center text-sm border border-emerald-500/30 shrink-0">
                    {{ $settings['aboutExpNumber'] ?? '15+' }}
                </div>
                <div>
                    <div class="text-xs font-bold text-white leading-tight">{{ $settings['aboutExpBadge'] ?? 'Years of Excellence' }}</div>
                    <div class="text-[11px] text-slate-400 leading-tight">{{ $settings['aboutExpSub'] ?? 'Technical Education' }}</div>
                </div>
            </div>
        </div>

        <!-- Right Text Content -->
        <div class="lg:col-span-7 space-y-5">
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                    <span>{{ $settings['aboutBadge'] ?? 'About National Youth Development' }}</span>
                </div>

                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-800 tracking-tight leading-snug">
                    <span>{{ $settings['aboutTitle'] ?? 'Bridging the Gap Between Technical Education & Real-World Careers' }}</span>
                </h2>

                <p class="text-sm sm:text-base text-slate-600 leading-relaxed font-normal">
                    {!! nl2br(e($settings['aboutDescription'] ?? 'The National Youth Development Technical Institute is dedicated to transforming ambitious youth into industry-ready professionals. Across 64 districts, we deliver standardized technical diplomas, ICT mastery, and self-employment initiatives.')) !!}
                </p>
            </div>

            <!-- 3 Stacked Full-Width Feature Cards (Matching Image 4) -->
            <div class="space-y-3 pt-1">
                <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/90 shadow-2xs hover:border-emerald-300 hover:shadow-md transition-all duration-300 flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center font-bold shrink-0">
                        <i class="fa-solid fa-shield-halved text-base"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm sm:text-base">
                            {{ $settings['aboutPillar1Title'] ?? 'Government-Accredited Curriculum' }}
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">
                            {{ $settings['aboutPillar1Desc'] ?? 'Nationally recognized diplomas and certificates valid for civil service, private sector, and overseas jobs.' }}
                        </p>
                    </div>
                </div>

                <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/90 shadow-2xs hover:border-emerald-300 hover:shadow-md transition-all duration-300 flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center font-bold shrink-0">
                        <i class="fa-solid fa-laptop-code text-base"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm sm:text-base">
                            {{ $settings['aboutPillar2Title'] ?? '80% Practical Lab Workshops' }}
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">
                            {{ $settings['aboutPillar2Desc'] ?? 'Real-world training in modern computer labs, electrical workshops, and industrial engineering suites.' }}
                        </p>
                    </div>
                </div>

                <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/90 shadow-2xs hover:border-emerald-300 hover:shadow-md transition-all duration-300 flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 border border-purple-100 flex items-center justify-center font-bold shrink-0">
                        <i class="fa-solid fa-briefcase text-base"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm sm:text-base">
                            {{ $settings['aboutPillar3Title'] ?? 'Career Placement & Youth Loan Linkage' }}
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">
                            {{ $settings['aboutPillar3Desc'] ?? 'Direct internship opportunities, freelance mentorship, and easy-term youth entrepreneurship loan guidance.' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Bottom Row: Registered Status & Link -->
            <div class="flex flex-wrap items-center justify-between gap-4 pt-3 border-t border-slate-100 text-xs sm:text-sm">
                <div class="flex items-center gap-2 font-semibold text-slate-600">
                    <i class="fa-regular fa-circle-check text-emerald-600 text-sm"></i>
                    <span>{{ $settings['aboutFooterLeft'] ?? 'Registered Institute • Government Affiliated' }}</span>
                </div>
                <a href="{{ $settings['aboutFooterRightLink'] ?? route('courses.index') }}" class="inline-flex items-center gap-1.5 font-bold text-emerald-700 hover:text-emerald-800 transition">
                    <span>{{ $settings['aboutFooterRightText'] ?? 'Explore All Trade Programs' }}</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

    </div>
</section>

<!-- 4. Course Categories Section (Exact Match to Picture 2 / CourseCategories.tsx) -->
<section class="w-full max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-14 py-12">
    <!-- Section Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 sm:mb-10">
        <div>
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold mb-3">
                <i class="fa-solid fa-wand-magic-sparkles text-emerald-600"></i>
                <span x-show="lang === 'en'">Browse By Trade Disciplines</span>
                <span x-show="lang === 'bn'">ট্রেড বিভাগ অনুযায়ী কোর্সসমূহ</span>
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-800 tracking-tight leading-snug">
                <span x-show="lang === 'en'">Explore Diverse Technical & Vocational Sectors</span>
                <span x-show="lang === 'bn'">কারিগরি ও কর্মমুখী ট্রেড ডিসিপ্লিনসমূহ</span>
            </h2>
            <p class="text-sm md:text-base text-slate-600 mt-2 max-w-2xl font-normal">
                <span x-show="lang === 'en'">Choose from government-standard training programs curated for immediate employment, enterprise incubation, and technical mastery.</span>
                <span x-show="lang === 'bn'">সরাসরি কর্মসংস্থান এবং আত্মকর্মসংস্থানের জন্য উপযোগী সরকার অনুমোদিত ব্যবহারিক কোর্স থেকে আপনার পছন্দের ট্রেড বেছে নিন।</span>
            </p>
        </div>

        <a
            href="{{ route('courses.index') }}"
            class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-emerald-700 hover:text-emerald-800 bg-white border border-slate-200 hover:border-emerald-300 px-5 py-2.5 rounded-xl transition shadow-xs shrink-0"
        >
            <span x-show="lang === 'en'">View All Programs</span>
            <span x-show="lang === 'bn'">সকল কোর্স দেখুন</span>
            <i class="fa-solid fa-arrow-right text-xs"></i>
        </a>
    </div>

    <!-- Categories Grid (4 Columns on Desktop, 2 on Tablet, 1 on Mobile) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
        
        <!-- Cat 1 -->
        <a href="{{ route('courses.index', ['category' => 'ict-digital']) }}" class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-emerald-500/50 hover:shadow-xl hover:shadow-slate-200/60 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center transition-transform group-hover:scale-110 duration-300 shadow-xs">
                        <i class="fa-solid fa-laptop text-xl"></i>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-50 group-hover:bg-emerald-50 flex items-center justify-center text-slate-400 group-hover:text-emerald-600 transition-colors">
                        <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-0.5 transition-transform"></i>
                    </div>
                </div>
                <h3 class="text-base font-bold text-slate-800 group-hover:text-emerald-700 transition-colors leading-snug">
                    ICT & Digital Engineering
                </h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed line-clamp-2">
                    Computer Office App, Graphics, Web Dev, Freelancing
                </p>
            </div>
            <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between">
                <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full border bg-blue-50 text-blue-700 border-blue-200">
                    24 Programs
                </span>
                <span class="text-xs font-semibold text-slate-400 group-hover:text-emerald-600 transition-colors">
                    Explore Trade &rarr;
                </span>
            </div>
        </a>

        <!-- Cat 2 -->
        <a href="{{ route('courses.index', ['category' => 'electrical-power']) }}" class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-emerald-500/50 hover:shadow-xl hover:shadow-slate-200/60 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center transition-transform group-hover:scale-110 duration-300 shadow-xs">
                        <i class="fa-solid fa-bolt text-xl"></i>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-50 group-hover:bg-emerald-50 flex items-center justify-center text-slate-400 group-hover:text-emerald-600 transition-colors">
                        <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-0.5 transition-transform"></i>
                    </div>
                </div>
                <h3 class="text-base font-bold text-slate-800 group-hover:text-emerald-700 transition-colors leading-snug">
                    Electrical & Industrial Power
                </h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed line-clamp-2">
                    House Wiring, Substation, Motor Automation, Solar Tech
                </p>
            </div>
            <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between">
                <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full border bg-amber-50 text-amber-700 border-amber-200">
                    18 Programs
                </span>
                <span class="text-xs font-semibold text-slate-400 group-hover:text-emerald-600 transition-colors">
                    Explore Trade &rarr;
                </span>
            </div>
        </a>

        <!-- Cat 3 -->
        <a href="{{ route('courses.index', ['category' => 'welding-fabrication']) }}" class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-emerald-500/50 hover:shadow-xl hover:shadow-slate-200/60 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-orange-50 border border-orange-100 text-orange-600 flex items-center justify-center transition-transform group-hover:scale-110 duration-300 shadow-xs">
                        <i class="fa-solid fa-wrench text-xl"></i>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-50 group-hover:bg-emerald-50 flex items-center justify-center text-slate-400 group-hover:text-emerald-600 transition-colors">
                        <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-0.5 transition-transform"></i>
                    </div>
                </div>
                <h3 class="text-base font-bold text-slate-800 group-hover:text-emerald-700 transition-colors leading-snug">
                    Mechanical & Gas Welding
                </h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed line-clamp-2">
                    TIG/MIG Welding, Machinist, Metal Fabrication, Lathe
                </p>
            </div>
            <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between">
                <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full border bg-orange-50 text-orange-700 border-orange-200">
                    12 Programs
                </span>
                <span class="text-xs font-semibold text-slate-400 group-hover:text-emerald-600 transition-colors">
                    Explore Trade &rarr;
                </span>
            </div>
        </a>

        <!-- Cat 4 -->
        <a href="{{ route('courses.index', ['category' => 'mechanical-climate']) }}" class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-emerald-500/50 hover:shadow-xl hover:shadow-slate-200/60 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-cyan-50 border border-cyan-100 text-cyan-600 flex items-center justify-center transition-transform group-hover:scale-110 duration-300 shadow-xs">
                        <i class="fa-solid fa-fan text-xl"></i>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-50 group-hover:bg-emerald-50 flex items-center justify-center text-slate-400 group-hover:text-emerald-600 transition-colors">
                        <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-0.5 transition-transform"></i>
                    </div>
                </div>
                <h3 class="text-base font-bold text-slate-800 group-hover:text-emerald-700 transition-colors leading-snug">
                    Refrigeration & AC (HVAC)
                </h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed line-clamp-2">
                    Split AC Servicing, Industrial Chiller, Fridge Repair
                </p>
            </div>
            <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between">
                <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full border bg-cyan-50 text-cyan-700 border-cyan-200">
                    10 Programs
                </span>
                <span class="text-xs font-semibold text-slate-400 group-hover:text-emerald-600 transition-colors">
                    Explore Trade &rarr;
                </span>
            </div>
        </a>

        <!-- Cat 5 -->
        <a href="{{ route('courses.index', ['category' => 'automobile-mechanics']) }}" class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-emerald-500/50 hover:shadow-xl hover:shadow-slate-200/60 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 border border-rose-100 text-rose-600 flex items-center justify-center transition-transform group-hover:scale-110 duration-300 shadow-xs">
                        <i class="fa-solid fa-car text-xl"></i>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-50 group-hover:bg-emerald-50 flex items-center justify-center text-slate-400 group-hover:text-emerald-600 transition-colors">
                        <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-0.5 transition-transform"></i>
                    </div>
                </div>
                <h3 class="text-base font-bold text-slate-800 group-hover:text-emerald-700 transition-colors leading-snug">
                    Automobile & Driving Tech
                </h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed line-clamp-2">
                    Engine Diagnostics, Commercial Driving, EV Maintenance
                </p>
            </div>
            <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between">
                <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full border bg-rose-50 text-rose-700 border-rose-200">
                    8 Programs
                </span>
                <span class="text-xs font-semibold text-slate-400 group-hover:text-emerald-600 transition-colors">
                    Explore Trade &rarr;
                </span>
            </div>
        </a>

        <!-- Cat 6 -->
        <a href="{{ route('courses.index', ['category' => 'garments-apparel']) }}" class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-emerald-500/50 hover:shadow-xl hover:shadow-slate-200/60 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 border border-purple-100 text-purple-600 flex items-center justify-center transition-transform group-hover:scale-110 duration-300 shadow-xs">
                        <i class="fa-solid fa-scissors text-xl"></i>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-50 group-hover:bg-emerald-50 flex items-center justify-center text-slate-400 group-hover:text-emerald-600 transition-colors">
                        <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-0.5 transition-transform"></i>
                    </div>
                </div>
                <h3 class="text-base font-bold text-slate-800 group-hover:text-emerald-700 transition-colors leading-snug">
                    Garments & Fashion Apparel
                </h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed line-clamp-2">
                    Industrial Sewing, Pattern Making, Quality Inspection
                </p>
            </div>
            <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between">
                <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full border bg-purple-50 text-purple-700 border-purple-200">
                    14 Programs
                </span>
                <span class="text-xs font-semibold text-slate-400 group-hover:text-emerald-600 transition-colors">
                    Explore Trade &rarr;
                </span>
            </div>
        </a>

        <!-- Cat 7 -->
        <a href="{{ route('courses.index', ['category' => 'agriculture-livestock']) }}" class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-emerald-500/50 hover:shadow-xl hover:shadow-slate-200/60 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center transition-transform group-hover:scale-110 duration-300 shadow-xs">
                        <i class="fa-solid fa-seedling text-xl"></i>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-50 group-hover:bg-emerald-50 flex items-center justify-center text-slate-400 group-hover:text-emerald-600 transition-colors">
                        <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-0.5 transition-transform"></i>
                    </div>
                </div>
                <h3 class="text-base font-bold text-slate-800 group-hover:text-emerald-700 transition-colors leading-snug">
                    Modern Agriculture & Dairy
                </h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed line-clamp-2">
                    Commercial Dairy, Poultry, Bio-Farming, Fishery
                </p>
            </div>
            <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between">
                <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full border bg-emerald-50 text-emerald-700 border-emerald-200">
                    16 Programs
                </span>
                <span class="text-xs font-semibold text-slate-400 group-hover:text-emerald-600 transition-colors">
                    Explore Trade &rarr;
                </span>
            </div>
        </a>

        <!-- Cat 8 -->
        <a href="{{ route('courses.index', ['category' => 'hospitality-tourism']) }}" class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-emerald-500/50 hover:shadow-xl hover:shadow-slate-200/60 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-teal-50 border border-teal-100 text-teal-600 flex items-center justify-center transition-transform group-hover:scale-110 duration-300 shadow-xs">
                        <i class="fa-solid fa-hotel text-xl"></i>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-50 group-hover:bg-emerald-50 flex items-center justify-center text-slate-400 group-hover:text-emerald-600 transition-colors">
                        <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-0.5 transition-transform"></i>
                    </div>
                </div>
                <h3 class="text-base font-bold text-slate-800 group-hover:text-emerald-700 transition-colors leading-snug">
                    Hospitality & Culinary Arts
                </h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed line-clamp-2">
                    Food Preparation, Front-Office, Tourism Management
                </p>
            </div>
            <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between">
                <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full border bg-teal-50 text-teal-700 border-teal-200">
                    8 Programs
                </span>
                <span class="text-xs font-semibold text-slate-400 group-hover:text-emerald-600 transition-colors">
                    Explore Trade &rarr;
                </span>
            </div>
        </a>

    </div>
</section>

<!-- 5. Featured Courses Section (Smooth & Eye-Friendly) -->
<section class="w-full max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-14 py-12">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 sm:mb-10">
        <div>
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold mb-3">
                <i class="fa-solid fa-fire text-amber-500"></i>
                <span x-show="lang === 'en'">High Demand Job-Ready Trades</span>
                <span x-show="lang === 'bn'">উচ্চ চাহিদাসম্পন্ন কারিগরি কোর্স</span>
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-800 tracking-tight leading-snug">
                <span x-show="lang === 'en'">Featured Vocational Programs</span>
                <span x-show="lang === 'bn'">জনপ্রিয় কর্মমুখী কোর্সসমূহ</span>
            </h2>
            <p class="text-sm md:text-base text-slate-600 mt-2 max-w-xl font-normal">
                <span x-show="lang === 'en'">Equipping youth with in-demand practical skills for domestic industries and international technical careers.</span>
                <span x-show="lang === 'bn'">দেশ-বিদেশের চাকরির বাজারে সর্বোচ্চ চাহিদাসম্পন্ন ব্যবহারিক কোর্সসমূহ।</span>
            </p>
        </div>

        <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-emerald-700 hover:text-emerald-800 bg-white border border-slate-200 hover:border-emerald-300 px-5 py-2.5 rounded-xl transition shadow-xs shrink-0">
            <span x-show="lang === 'en'">Browse All Courses</span>
            <span x-show="lang === 'bn'">সকল কোর্স দেখুন</span>
            <i class="fa-solid fa-arrow-right text-xs"></i>
        </a>
    </div>

    <!-- 6 Course Cards Grid: Unified Clean Design Matching Courses Page -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        @foreach(($featuredCourses ?? $courses ?? []) as $course)
            <div class="group bg-white rounded-3xl border border-slate-200 hover:border-emerald-500/50 shadow-xs hover:shadow-2xl hover:shadow-slate-200/70 transition-all duration-300 overflow-hidden flex flex-col justify-between">
                <div>
                    <!-- Thumbnail with Badges -->
                    <div class="relative h-56 sm:h-64 w-full overflow-hidden bg-slate-900">
                        <img 
                            src="{{ $course->image ?? $course->thumbnail ?? 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=800&auto=format&fit=crop' }}" 
                            alt="{{ $course->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent pointer-events-none"></div>
                        
                        <!-- Top Badges -->
                        <div class="absolute top-4 left-4 right-4 flex items-center justify-between gap-2 pointer-events-none">
                            <span class="text-xs font-bold px-3 py-1 rounded-full bg-white/95 text-slate-800 shadow-md backdrop-blur-md">
                                {{ $course->category }}
                            </span>
                            <span class="text-xs font-extrabold px-3 py-1 rounded-full bg-emerald-500 text-slate-950 shadow-md shrink-0">
                                {{ $course->seats_remaining ?? 8 }} Seats Left
                            </span>
                        </div>

                        <!-- Bottom Fee Pill -->
                        <div class="absolute bottom-4 left-4 right-4 pointer-events-none">
                            <span class="inline-block text-xs font-bold px-3.5 py-1.5 rounded-xl bg-slate-900/90 text-emerald-400 border border-emerald-400/20 backdrop-blur-md shadow-lg">
                                {{ $course->fee ?: 'Govt Subsidized' }}
                            </span>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6">
                        <a href="{{ route('courses.show', $course->slug) }}">
                            <h3 class="text-lg sm:text-xl font-black text-slate-900 group-hover:text-emerald-700 transition-colors leading-snug">
                                {{ $course->title }}
                            </h3>
                        </a>

                        <p class="text-xs sm:text-sm text-slate-600 mt-2.5 line-clamp-2 leading-relaxed">
                            {{ $course->short_description ?? $course->overview }}
                        </p>

                        <!-- Course Meta Key Facts -->
                        <div class="mt-5 pt-5 border-t border-slate-100 space-y-2.5 text-xs text-slate-600">
                            <div class="flex items-center gap-2 min-w-0">
                                <i class="fa-regular fa-clock text-emerald-600 shrink-0 text-sm"></i>
                                <span class="font-semibold text-slate-800 shrink-0">Duration:</span>
                                <span class="truncate">
                                    {{ $course->duration }}@if(!empty($course->total_hours) && !str_contains(strtolower((string)$course->duration), 'hour')) ({{ $course->total_hours }} Hours)@endif
                                </span>
                            </div>

                            <div class="flex items-center gap-2 min-w-0">
                                <i class="fa-solid fa-graduation-cap text-emerald-600 shrink-0 text-sm"></i>
                                <span class="font-semibold text-slate-800 shrink-0">Eligibility:</span>
                                <span class="truncate">{{ $course->prerequisites ?? 'Minimum SSC / Equivalent' }}</span>
                            </div>

                            <div class="flex items-center gap-2 min-w-0">
                                <i class="fa-solid fa-map-pin text-emerald-600 shrink-0 text-sm"></i>
                                <span class="font-semibold text-slate-800 shrink-0">Hubs:</span>
                                <span class="truncate">{{ $course->centers ?? 'Available across 64 Regional Hubs' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Actions Bar: 2 Side by Side Buttons -->
                <div class="p-6 pt-0 flex items-center gap-2.5">
                    <a 
                        href="{{ route('courses.show', $course->slug) }}" 
                        class="flex-1 py-3 px-4 rounded-xl border border-slate-200 hover:border-slate-300 bg-slate-50 hover:bg-slate-100 text-slate-800 font-bold text-xs sm:text-sm text-center transition"
                    >
                        View Details
                    </a>
                    <a 
                        href="{{ route('register', ['trade' => $course->title]) }}" 
                        class="flex-1 py-3 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs sm:text-sm text-center transition shadow-md shadow-emerald-900/20 flex items-center justify-center gap-1.5"
                    >
                        <span>Apply Now</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- 6. Certified Instructors Section -->
<section class="w-full max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-14 py-12">
    <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-semibold">
            <i class="fa-solid fa-user-graduate text-emerald-600"></i>
            <span x-show="lang === 'en'">Master Mentors</span>
            <span x-show="lang === 'bn'">দক্ষ প্রশিক্ষক ও মেন্টরবৃন্দ</span>
        </div>
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-800 tracking-tight">
            <span x-show="lang === 'en'">Learn From Industry Veterans</span>
            <span x-show="lang === 'bn'">অভিজ্ঞ শিক্ষক ও বিশেষজ্ঞদের সরাসরি দিকনির্দেশনা</span>
        </h2>
        <p class="text-xs sm:text-sm text-slate-500 font-normal">
            Dedicated vocational educators guiding you with hands-on lab projects and industry trade secrets.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        <!-- Instructor 1 -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs hover:shadow-xl transition-all duration-300 text-center space-y-4 group">
            <div class="w-32 h-32 mx-auto rounded-full overflow-hidden border-4 border-emerald-500/30 group-hover:border-emerald-500 transition-colors shadow-sm">
                <img src="/images/Efra Khan.jpg" alt="Shariyat Ullah Saikat" class="w-full h-full object-cover object-top">
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-800">Shariyat Ullah Saikat</h3>
                <p class="text-xs sm:text-sm font-semibold text-emerald-700 mt-0.5">Chairman & Academic Director</p>
            </div>
            <p class="text-xs text-slate-500 leading-relaxed font-normal">Senior vocational educator leading youth empowerment programs across Bangladesh.</p>
        </div>

        <!-- Instructor 2 -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs hover:shadow-xl transition-all duration-300 text-center space-y-4 group">
            <div class="w-32 h-32 mx-auto rounded-full overflow-hidden border-4 border-blue-500/30 group-hover:border-blue-500 transition-colors shadow-sm">
                <img src="/images/OMAYER RAHMAN.jpg" alt="Omayer Rahman" class="w-full h-full object-cover object-top">
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-800">Omayer Rahman</h3>
                <p class="text-xs sm:text-sm font-semibold text-blue-700 mt-0.5">Computer Office Programme</p>
            </div>
            <p class="text-xs text-slate-500 leading-relaxed font-normal">Certified database administrator & senior office application specialist.</p>
        </div>

        <!-- Instructor 3 -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs hover:shadow-xl transition-all duration-300 text-center space-y-4 group">
            <div class="w-32 h-32 mx-auto rounded-full overflow-hidden border-4 border-purple-500/30 group-hover:border-purple-500 transition-colors shadow-sm">
                <img src="/images/Shariful Islam Sampad.jpg" alt="Shariful Islam Sampad" class="w-full h-full object-cover object-top">
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-800">Shariful Islam Sampad</h3>
                <p class="text-xs sm:text-sm font-semibold text-purple-700 mt-0.5">Digital Marketing Specialist</p>
            </div>
            <p class="text-xs text-slate-500 leading-relaxed font-normal">Global marketplace coach specializing in freelance mentorship and digital branding.</p>
        </div>
    </div>
</section>

<!-- 7. Leadership Vision Section (Smooth) -->
<section class="w-full max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-14 py-12">
    <div class="text-center max-w-3xl mx-auto mb-8 sm:mb-12 space-y-3">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-semibold shadow-xs">
            <i class="fa-solid fa-award text-emerald-600"></i>
            <span>National Digital & ICT Leadership Vision</span>
        </div>

        <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-slate-800 tracking-tight">
            Thank you Prime Minister
        </h2>

        <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 text-xs sm:text-sm text-slate-600 font-medium">
            <span class="flex items-center gap-1.5">
                <i class="fa-regular fa-calendar text-emerald-600"></i>
                <span>Wednesday, 06 December, 2017</span>
            </span>
            <span class="hidden sm:inline text-slate-400">•</span>
            <span class="flex items-center gap-1.5">
                <i class="fa-solid fa-location-dot text-rose-500"></i>
                <span>Digital World-2017 Inauguration Ceremony, BICC, Dhaka</span>
            </span>
        </div>

        <div class="flex items-center justify-center gap-2 pt-1">
            <div class="w-12 h-1 bg-emerald-600 rounded-full"></div>
            <div class="w-3 h-1 bg-amber-500 rounded-full"></div>
            <div class="w-12 h-1 bg-emerald-600 rounded-full"></div>
        </div>
    </div>

    <!-- Leadership Vision Feature Box -->
    <div class="relative rounded-3xl sm:rounded-[36px] bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 border border-slate-800 shadow-2xl overflow-hidden p-6 sm:p-10 md:p-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            
            <!-- Left Portrait -->
            <div class="lg:col-span-5 flex flex-col items-center">
                <div class="w-full max-w-sm sm:max-w-md rounded-2xl sm:rounded-3xl overflow-hidden border border-white/10 shadow-2xl bg-slate-900/90 group">
                    <div class="relative w-full aspect-[5/3] overflow-hidden bg-slate-950">
                        <img src="/images/prime-minister.jpg" alt="Tarique Rahman - Prime Minister" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4 bg-slate-900/90 text-center">
                        <span class="text-xs font-semibold text-emerald-400 uppercase tracking-wider block">National Youth Transformation</span>
                        <span class="text-sm font-bold text-white mt-0.5 block">Digital World Leadership</span>
                    </div>
                </div>
            </div>

            <!-- Right Quote -->
            <div class="lg:col-span-7 space-y-5 text-slate-200">
                <div class="relative p-6 sm:p-8 rounded-3xl bg-white/[0.04] border border-white/10 backdrop-blur-xs space-y-4">
                    <i class="fa-solid fa-quote-left text-3xl text-emerald-500/30"></i>
                    <p class="text-base sm:text-lg text-slate-100 leading-relaxed italic font-normal">
                        &ldquo;Our vision is clear: we must transform Bangladesh into a knowledge-based economy. To achieve this, our youth must be equipped with world-class technical education, ICT engineering skills, and vocational mastery.&rdquo;
                    </p>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-normal">
                        Under national digital development frameworks, Saikat Computer and Training Jubo Songhoton aligns every curriculum to ensure youth across all 64 districts gain accredited employment and self-reliance.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 8. Chairman's Speech Section (Exact Frame: aspect-[4/5] object-top - HEAD NEVER CUT OFF!) -->
<section class="w-full max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-14 py-10 sm:py-14 md:py-16">
    <div class="text-center max-w-3xl mx-auto mb-8 sm:mb-12 space-y-3">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-semibold shadow-xs">
            <i class="fa-solid fa-shield-halved text-emerald-600"></i>
            <span>{{ $settings['chairmanBadge'] ?? 'Executive Leadership & Academic Vision' }}</span>
        </div>

        <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-slate-800 tracking-tight">
            {{ $settings['chairmanTitle'] ?? "Chairman's Speech" }}
        </h2>

        <p class="text-xs sm:text-sm md:text-base text-slate-600 font-normal max-w-xl mx-auto">
            {{ $settings['chairmanSubtitle'] ?? 'Message from the Chairman & Academic Director of Saikat Computer and Training Jubo Songhoton' }}
        </p>

        <div class="flex items-center justify-center gap-2 pt-1">
            <div class="w-12 h-1 bg-emerald-600 rounded-full"></div>
            <div class="w-3 h-1 bg-amber-500 rounded-full"></div>
            <div class="w-12 h-1 bg-emerald-600 rounded-full"></div>
        </div>
    </div>

    <!-- Main Chairman Speech Container (Exact Match to User Reference Image 4) -->
    <div class="relative rounded-3xl sm:rounded-[36px] bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 border border-slate-800 shadow-2xl overflow-hidden p-6 sm:p-10 md:p-12">
        
        <!-- Subtle Ambient Glows -->
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            
            <!-- Left Speech Column (7 cols) -->
            <div class="lg:col-span-7 space-y-6 order-2 lg:order-1">
                
                <!-- Quotation Box -->
                <div class="relative p-6 sm:p-8 rounded-3xl bg-white/[0.04] border border-white/10 backdrop-blur-xs space-y-5">
                    <span class="text-4xl sm:text-5xl text-amber-500/80 font-serif leading-none block">&ldquo;&rdquo;</span>
                    
                    <div class="space-y-4">
                        <p class="text-base sm:text-lg text-slate-100 leading-relaxed font-normal italic">
                            &ldquo;{{ $settings['chairmanQuote1'] ?? "Our paramount mission is to empower the young generation of Bangladesh with practical, industry-driven technical skills. In a rapidly transforming world, theoretical knowledge alone is never enough—every young student must master authentic hands-on competence in digital computing, modern engineering trades, and digital entrepreneurship." }}&rdquo;
                        </p>

                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-normal">
                            &ldquo;{{ $settings['chairmanQuote2'] ?? "Through government subsidized training programs, state-of-the-art laboratory facilities, and dedicated mentors, Saikat Computer and Training Jubo Songhoton remains relentlessly devoted to building a self-reliant, skilled, and employed youth workforce for our beloved nation." }}&rdquo;
                        </p>
                    </div>

                    <!-- Chairman Sign-off & Title Block (Exact Match to Image 4) -->
                    <div class="pt-5 mt-5 border-t border-white/10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h3 class="text-lg sm:text-xl font-bold text-white tracking-tight">
                                {{ $settings['chairmanName'] ?? 'Shariyat Ullah Saikat' }}
                            </h3>
                            <span class="text-xs sm:text-sm text-emerald-400 font-semibold block mt-0.5">
                                {{ $settings['chairmanDesignation'] ?? 'Chairman & Academic Director' }}
                            </span>
                        </div>

                        <div class="text-xs text-slate-400 font-normal">
                            {{ $settings['chairmanOrg'] ?? 'Saikat Computer & Training Jubo Songhoton' }}
                        </div>
                    </div>

                </div>

            </div>

            <!-- Right Executive Portrait: Full Natural Headshot with zero top clipping (Matches Image 4) -->
            <div class="lg:col-span-5 flex flex-col items-center order-1 lg:order-2">
                <div class="w-full max-w-sm sm:max-w-md rounded-3xl overflow-hidden bg-white p-2.5 sm:p-3 shadow-2xl border border-white/20 group">
                    <div class="relative w-full aspect-[4/5] rounded-2xl overflow-hidden bg-slate-100">
                        <img
                            src="{{ $settings['chairmanImage'] ?? '/images/Efra Khan.jpg' }}"
                            alt="{{ $settings['chairmanName'] ?? 'Shariyat Ullah Saikat' }} - Chairman"
                            class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500"
                        />
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- 9. Testimonials Section (Exact Match to Picture 4 / TestimonialsSection.tsx) -->
<section 
    class="w-full max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-14 py-12"
    x-data="{
        testimonials: @js((isset($testimonials) && $testimonials->isNotEmpty()) ? $testimonials->map(function($t) {
            return [
                'id' => $t->id,
                'name' => $t->name,
                'course' => $t->course,
                'district' => $t->district ?? 'National Hub',
                'batch' => $t->batch ?? 'Batch 2026',
                'quote' => $t->quote,
                'avatar' => $t->avatar ?: null,
                'rating' => $t->rating ?? 5,
            ];
        }) : [
            [
                'name' => 'Tanjila Akter',
                'course' => 'Computer Office Programme & Graphic Design',
                'district' => 'Tangail District Hub',
                'batch' => 'Batch 42',
                'quote' => 'Before enrolling at Saikat Computer & Training Jubo Songhoton, I had zero computing confidence. The instructors guided me through every step in the modern lab. Within 2 months of graduation, I started earning online and now support my entire family.',
                'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=300&q=80',
                'rating' => 5,
            ],
            [
                'name' => 'Mohammad Arif Hossain',
                'course' => 'Electrical House Wiring & Solar Installation',
                'district' => 'Cumilla Technical Complex',
                'batch' => 'Batch 38',
                'quote' => 'The practical safety protocols and solar inverter troubleshooting on physical test boards prepared me for real industrial challenges. My government-verified certificate gave building contractors the confidence to hire me directly.',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80',
                'rating' => 5,
            ],
            [
                'name' => 'Sumaiya Yasmin',
                'course' => 'Professional Dress Making, Tailoring & Boutique',
                'district' => 'Bogura Youth Training Center',
                'batch' => 'Batch 45',
                'quote' => 'I came to learn basic tailoring to support my family. Today, not only am I financially independent, but I have also established my own boutique that employs six young women from my village. The entrepreneurship classes were life changing.',
                'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=300&q=80',
                'rating' => 5,
            ],
            [
                'name' => 'Mehedi Hasan',
                'course' => 'Refrigeration & Air Conditioning (RAC) Servicing',
                'district' => 'Dhaka Central Heavy Workshop',
                'batch' => 'Batch 36',
                'quote' => 'A 3-month course in a private institute was out of my reach due to high tuition fees. Here, the government subsidy made the course virtually free while providing top-grade vacuum pumps, manifold gauges, and inverter split AC lab stations.',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=300&q=80',
                'rating' => 5,
            ],
            [
                'name' => 'Fatema Tuz Zohra',
                'course' => 'Digital Marketing, SEO & E-Commerce',
                'district' => 'Chattogram Regional Hub',
                'batch' => 'Batch 49',
                'quote' => 'Most courses only teach theory with slides. Here, our mentors set up live Facebook pixel tracking, Google Merchant accounts, and SEO tools directly on our workstations. I landed a remote marketing position right after graduation.',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80',
                'rating' => 5,
            ],
            [
                'name' => 'Rashedul Islam',
                'course' => 'Modern Dairy Farming, Poultry & Cattle Fattening',
                'district' => 'Rangpur Agro Development Farm',
                'batch' => 'Batch 31',
                'quote' => 'Before this course, my family suffered severe losses due to preventable cattle diseases and poor feed balance. The veterinary sessions, silage preservation methods, and youth loan counseling empowered me to build a profitable modern farm.',
                'avatar' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=300&q=80',
                'rating' => 5,
            ]
        ]),
        currentIndex: 0,
        next() {
            if (this.testimonials.length > 0) {
                this.currentIndex = (this.currentIndex + 1) % this.testimonials.length;
            }
        },
        prev() {
            if (this.testimonials.length > 0) {
                this.currentIndex = (this.currentIndex - 1 + this.testimonials.length) % this.testimonials.length;
            }
        }
    }"
>
    <!-- Header: Title on Left, 2 Slide Arrow Buttons on Right -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8 sm:mb-12">
        <div>
            <span class="text-xs font-semibold uppercase tracking-wider text-emerald-800 bg-emerald-50 px-3.5 py-1.5 rounded-full border border-emerald-200 inline-block">
                TESTIMONIALS
            </span>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-800 tracking-tight mt-3">
                <span x-show="lang === 'en'">What Our Students Say</span>
                <span x-show="lang === 'bn'">শিক্ষার্থীদের মতামত ও সাফল্যগাঁথা</span>
            </h2>
            <p class="text-sm sm:text-base text-slate-600 mt-1.5 max-w-xl font-normal">
                Real feedback from graduates across our technical and vocational training programs.
            </p>
        </div>

        <!-- 2 Slide Arrow Buttons -->
        <div class="flex items-center gap-2.5 shrink-0">
            <button
                type="button"
                @click="prev()"
                aria-label="Previous Testimonials"
                class="w-11 h-11 rounded-2xl bg-white border border-slate-200 hover:border-emerald-500 hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 flex items-center justify-center transition-all duration-200 shadow-xs active:scale-95 cursor-pointer"
            >
                <i class="fa-solid fa-chevron-left text-sm"></i>
            </button>
            <button
                type="button"
                @click="next()"
                aria-label="Next Testimonials"
                class="w-11 h-11 rounded-2xl bg-white border border-slate-200 hover:border-emerald-500 hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 flex items-center justify-center transition-all duration-200 shadow-xs active:scale-95 cursor-pointer"
            >
                <i class="fa-solid fa-chevron-right text-sm"></i>
            </button>
        </div>
    </div>

    <!-- 3 Testimonial Cards View -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="(item, i) in [0, 1, 2]" :key="i">
            <div 
                x-data="{ itemData() { return testimonials[(currentIndex + i) % testimonials.length]; } }" 
                class="h-full bg-white rounded-3xl border border-slate-200/90 hover:border-emerald-500/40 p-6 sm:p-7 shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col justify-between relative group"
            >
                <!-- Top Row: 5 Stars & Verified Alumni Badge -->
                <div>
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <div class="flex items-center gap-1 text-amber-400 text-xs">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>

                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-[11px] font-semibold border border-emerald-200">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-xs"></i>
                            <span>Verified Alumni</span>
                        </span>
                    </div>

                    <!-- Student Quote -->
                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed font-normal italic relative z-10 mb-6">
                        &ldquo;<span x-text="itemData().quote"></span>&rdquo;
                    </p>
                </div>

                <!-- Bottom Student Profile -->
                <div class="pt-4 border-t border-slate-100 flex items-center gap-3 mt-auto">
                    <template x-if="itemData().avatar">
                        <div class="w-12 h-12 rounded-full overflow-hidden bg-slate-100 shrink-0 border border-slate-200 shadow-xs">
                            <img
                                :src="itemData().avatar"
                                :alt="itemData().name"
                                class="w-full h-full object-cover object-top"
                            />
                        </div>
                    </template>
                    <template x-if="!itemData().avatar">
                        <div class="w-12 h-12 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold text-sm flex items-center justify-center shrink-0">
                            <span x-text="(itemData().name || 'AL').trim().split(/\s+/).map(p => p[0]).slice(0, 2).join('').toUpperCase()"></span>
                        </div>
                    </template>

                    <div class="min-w-0">
                        <h4 class="text-sm font-bold text-slate-800 truncate" x-text="itemData().name"></h4>
                        <p class="text-xs text-emerald-700 font-semibold truncate" x-text="itemData().course"></p>
                        <p class="text-[11px] text-slate-400 truncate flex items-center gap-1 mt-0.5 font-normal">
                            <i class="fa-solid fa-location-dot text-[10px]"></i>
                            <span x-text="itemData().district"></span>
                            <span>•</span>
                            <span x-text="itemData().batch"></span>
                        </p>
                    </div>
                </div>

            </div>
        </template>
    </div>

    <!-- Subtle Slide Indicator Dots -->
    <div class="flex items-center justify-center gap-2 mt-8">
        <template x-for="(t, idx) in testimonials" :key="idx">
            <button
                type="button"
                @click="currentIndex = idx"
                :class="currentIndex === idx ? 'w-6 bg-emerald-600' : 'w-2 bg-slate-300 hover:bg-slate-400'"
                class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                :aria-label="'Go to slide ' + (idx + 1)"
            ></button>
        </template>
    </div>
</section>

@if(!empty($settings['popupEnabled']))
<!-- Dynamic Announcement / Admission Popup Modal System -->
<div 
    x-data="{ 
        popupOpen: !sessionStorage.getItem('nyd_popup_dismissed'),
        closePopup() {
            this.popupOpen = false;
            sessionStorage.setItem('nyd_popup_dismissed', 'true');
        }
    }" 
    x-show="popupOpen" 
    x-cloak
    @keydown.escape.window="closePopup()"
    class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 sm:p-6"
    aria-labelledby="modal-title" 
    role="dialog" 
    aria-modal="true"
>
    <!-- Dark Backdrop with Blur -->
    <div 
        x-show="popupOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="closePopup()"
        class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs transition-opacity"
    ></div>

    <!-- Modal Card Box -->
    <div 
        x-show="popupOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="relative w-full max-w-lg bg-white rounded-3xl overflow-hidden shadow-2xl border border-slate-200/90 z-10 transition-all text-slate-800"
    >
        <!-- Modal Image Banner -->
        @if(!empty($settings['popupImage']))
            <div class="relative h-48 sm:h-52 w-full overflow-hidden bg-slate-900">
                <img 
                    src="{{ $settings['popupImage'] }}" 
                    alt="Notice Announcement" 
                    class="w-full h-full object-cover"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                
                <!-- Close Button over Image -->
                <button 
                    type="button" 
                    @click="closePopup()" 
                    class="absolute top-3.5 right-3.5 w-9 h-9 rounded-full bg-slate-950/60 hover:bg-slate-950 text-white flex items-center justify-center transition backdrop-blur-xs"
                    aria-label="Close"
                >
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        @else
            <div class="flex justify-end p-4 pb-0">
                <button 
                    type="button" 
                    @click="closePopup()" 
                    class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition"
                    aria-label="Close"
                >
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        @endif

        <!-- Modal Body Content -->
        <div class="p-6 sm:p-7 space-y-4">
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-semibold">
                        <i class="fa-solid fa-bullhorn text-emerald-600 text-[11px]"></i>
                        <span>{{ $settings['popupBadge'] ?? 'Official Notice' }}</span>
                    </span>
                    <span class="text-xs text-slate-400 font-medium">• Important Announcement</span>
                </div>

                <h3 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight leading-snug">
                    {{ $settings['popupTitle'] ?? 'Admissions Open - Batch 2026' }}
                </h3>

                <p class="text-sm text-slate-600 leading-relaxed font-normal">
                    {{ $settings['popupMessage'] ?? 'Govt-subsidized technical courses and vocational training programs are currently accepting applications. Register today to reserve your seat.' }}
                </p>
            </div>

            <!-- Modal Action Buttons -->
            <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row items-center gap-3">
                <a 
                    href="{{ $settings['popupButtonUrl'] ?? '/register' }}" 
                    class="w-full sm:flex-1 py-3 px-5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm text-center shadow-xs transition hover:shadow-md flex items-center justify-center gap-2"
                >
                    <span>{{ $settings['popupButtonText'] ?? 'Apply For Admission' }}</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
                
                <button 
                    type="button" 
                    @click="closePopup()" 
                    class="w-full sm:w-auto py-3 px-5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm text-center transition"
                >
                    Dismiss
                </button>
            </div>
        </div>

    </div>
</div>
@endif

@endsection
