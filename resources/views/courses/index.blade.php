@extends('layouts.app')

@section('title', ($settings['coursesPageTitle'] ?? 'Technical & Vocational Training Programs') . ' - National Youth Platform')

@section('content')
<div 
    class="w-full min-h-screen bg-[#F8FAFC]"
    x-data="{
        searchQuery: new URLSearchParams(window.location.search).get('search') || '',
        selectedCategory: new URLSearchParams(window.location.search).get('category') || 'all',
        selectedDuration: 'all',
        subsidizedOnly: false,
        sortBy: 'recommended',
        viewMode: 'grid',
        courses: @js($allCourses),
        categoryGroups: {
            'ict': ['ict-digital', 'ict-digital-engineering'],
            'electrical': ['electrical-power', 'electrical-industrial-power'],
            'welding': ['welding-fabrication', 'mechanical-gas-welding'],
            'hvac': ['mechanical-climate', 'refrigeration-hvac', 'refrigeration-ac-hvac'],
            'auto': ['automobile-mechanics', 'automobile-driving-tech'],
            'garments': ['garments-apparel', 'garments-fashion-apparel'],
            'agro': ['agriculture-livestock', 'modern-agriculture-dairy'],
            'hospitality': ['hospitality-tourism', 'hospitality-culinary', 'hospitality-culinary-arts']
        },

        resolveCategoryMatch(slugA, slugB) {
            if (slugA === slugB) return true;
            for (const aliases of Object.values(this.categoryGroups)) {
                if (aliases.includes(slugA) && aliases.includes(slugB)) {
                    return true;
                }
            }
            return false;
        },

        get filteredCourses() {
            let result = this.courses.filter(course => {
                // Search query matching
                if (this.searchQuery.trim()) {
                    const q = this.searchQuery.toLowerCase().trim();
                    const titleMatch = (course.title || '').toLowerCase().includes(q);
                    const descMatch = (course.short_description || course.overview || '').toLowerCase().includes(q);
                    const catMatch = (course.category || '').toLowerCase().includes(q);
                    const centerMatch = (course.centers || '').toLowerCase().includes(q);
                    if (!titleMatch && !descMatch && !catMatch && !centerMatch) {
                        return false;
                    }
                }

                // Category filter (supports seeded and admin-created category slug variants)
                if (this.selectedCategory !== 'all') {
                    const catSlug = course.category_slug || (course.category || '').toLowerCase().replace(/[^a-z0-9]+/g, '-');
                    if (!this.resolveCategoryMatch(catSlug, this.selectedCategory) && course.category !== this.selectedCategory) {
                        return false;
                    }
                }

                // Duration filter
                if (this.selectedDuration !== 'all') {
                    if (!(course.duration || '').toLowerCase().includes(this.selectedDuration.toLowerCase())) {
                        return false;
                    }
                }

                // Subsidized filter
                if (this.subsidizedOnly) {
                    const feeStr = (course.fee || '').toLowerCase();
                    const isSub = course.is_subsidized === true || course.is_subsidized === 1 || course.is_subsidized === '1' || feeStr.includes('subsidized') || feeStr.includes('free');
                    if (!isSub) {
                        return false;
                    }
                }

                return true;
            });

            // Sorting
            switch (this.sortBy) {
                case 'seats-asc':
                    result.sort((a, b) => (Number(a.seats_remaining) || 0) - (Number(b.seats_remaining) || 0));
                    break;
                case 'hours-desc':
                    result.sort((a, b) => (Number(b.total_hours) || 0) - (Number(a.total_hours) || 0));
                    break;
                case 'hours-asc':
                    result.sort((a, b) => (Number(a.total_hours) || 0) - (Number(b.total_hours) || 0));
                    break;
                case 'title-asc':
                    result.sort((a, b) => (a.title || '').localeCompare(b.title || ''));
                    break;
                case 'recommended':
                default:
                    result.sort((a, b) => (b.featured ? 1 : 0) - (a.featured ? 1 : 0));
                    break;
            }

            return result;
        },

        get hasActiveFilters() {
            return this.searchQuery.trim() !== '' || this.selectedCategory !== 'all' || this.selectedDuration !== 'all' || this.subsidizedOnly;
        },

        clearFilters() {
            this.searchQuery = '';
            this.selectedCategory = 'all';
            this.selectedDuration = 'all';
            this.subsidizedOnly = false;
            this.sortBy = 'recommended';
        }
    }"
>
    <!-- ==============================================================
         1. HERO HEADER WITH OVERLAY & SEARCH BAR (User Screenshot 1)
         ============================================================== -->
    <section class="w-full relative overflow-hidden py-14 sm:py-20 border-b border-slate-800 bg-slate-950 text-white">
        
        <!-- Background Image with Dark Professional Overlay -->
        <div class="absolute inset-0 z-0">
            <img 
                src="{{ $settings['coursesPageHeroBg'] ?? 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=2000&auto=format&fit=crop' }}" 
                alt="Technical Training Workshop" 
                class="w-full h-full object-cover object-center opacity-30"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/85 to-slate-950/90 backdrop-blur-[2px]"></div>
        </div>

        <!-- Ambient Glows -->
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none z-0"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-amber-500/15 rounded-full blur-3xl pointer-events-none z-0"></div>

        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-14 relative z-10 text-center max-w-4xl">
            
            <!-- Badge Tag -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs sm:text-sm font-bold mb-4 shadow-sm backdrop-blur-md">
                <i class="fa-solid fa-fire text-amber-400"></i>
                <span>{{ $settings['coursesPageBadge'] ?? 'Admission Open • Academic Session 2026' }}</span>
            </div>

            <!-- Main Headline -->
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black tracking-tight text-white leading-tight">
                {{ $settings['coursesPageTitle'] ?? 'Technical & Vocational Training Programs' }}
            </h1>

            <!-- Subtitle Description -->
            <p class="text-sm sm:text-base md:text-lg text-slate-200 mt-4 leading-relaxed max-w-2xl mx-auto font-normal">
                {{ $settings['coursesPageSubtitle'] ?? 'Choose from government-subsidized, high-impact certification courses with 100% practical lab workstations, certified instructors, and national employment support.' }}
            </p>

            <!-- Modern Search Bar Box -->
            <div class="mt-8 sm:mt-10 max-w-2xl mx-auto">
                <div class="relative flex items-center bg-white rounded-2xl shadow-2xl p-1.5 border border-white/20">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 ml-4 shrink-0 text-base"></i>
                    <input 
                        type="text" 
                        x-model="searchQuery" 
                        placeholder="Search trades (e.g., Graphic Design, RAC, Solar, Wiring)..." 
                        class="w-full px-3.5 py-3 text-slate-900 placeholder-slate-400 text-sm sm:text-base focus:outline-hidden bg-transparent"
                    >
                    <button 
                        type="button" 
                        x-show="searchQuery" 
                        @click="searchQuery = ''" 
                        class="p-2 text-slate-400 hover:text-slate-600 transition" 
                        aria-label="Clear search"
                    >
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                    <button 
                        type="button" 
                        class="px-5 sm:px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs sm:text-sm flex items-center gap-1.5 shadow-md shadow-emerald-900/30 transition shrink-0 cursor-pointer"
                    >
                        <span>Find Course</span>
                    </button>
                </div>

                <!-- Popular Keywords Row -->
                <div class="flex flex-wrap items-center justify-center gap-2 mt-3.5 text-xs text-slate-300">
                    <span class="font-semibold text-slate-400">Popular:</span>
                    @php
                        $popularKeywords = array_map('trim', explode(',', $settings['coursesPagePopularKeywords'] ?? 'Graphic Design, Electrical, RAC Servicing, Welding, Tailoring'));
                    @endphp
                    @foreach($popularKeywords as $kw)
                        <button 
                            type="button" 
                            @click="searchQuery = '{{ addslashes($kw) }}'" 
                            class="px-2.5 py-1 rounded-lg bg-white/10 hover:bg-white/20 text-slate-200 hover:text-white transition text-xs font-medium cursor-pointer"
                        >
                            {{ $kw }}
                        </button>
                    @endforeach
                </div>
            </div>

        </div>
    </section>

    <!-- ==============================================================
         2. MAIN COURSE DIRECTORY (User Screenshot 1 & 2)
         ============================================================== -->
    <main class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-14 py-10 sm:py-14 md:py-16">
        
        <!-- Category Filter: Wrapped Box Layout (Image 1 & 2) -->
        <div class="bg-white rounded-3xl border border-slate-200/90 p-5 sm:p-6 mb-8 shadow-xs">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3.5 pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-filter text-emerald-600 text-sm"></i>
                    <span class="text-xs sm:text-sm font-black text-slate-900 uppercase tracking-wider">
                        Filter by Trade Category
                    </span>
                </div>
                <span class="text-xs text-slate-500 font-medium">
                    Select a category to filter all matching training programs
                </span>
            </div>

            <div class="flex flex-wrap items-center gap-2 sm:gap-2.5">
                <!-- All Programs Button -->
                <button 
                    type="button" 
                    @click="selectedCategory = 'all'" 
                    class="text-xs sm:text-sm font-bold px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 cursor-pointer"
                    :class="selectedCategory === 'all' 
                        ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20 scale-102' 
                        : 'bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200 hover:border-slate-300 hover:text-slate-900'"
                >
                    <span>All Programs</span>
                    <span 
                        class="text-[11px] px-2 py-0.5 rounded-full font-extrabold"
                        :class="selectedCategory === 'all' ? 'bg-emerald-500 text-slate-950' : 'bg-white text-slate-600 border border-slate-200'"
                    >
                        {{ $allCourses->count() }}
                    </span>
                </button>

                <!-- Dynamic Categories Buttons -->
                @foreach($categories as $cat)
                    <button 
                        type="button" 
                        @click="selectedCategory = '{{ $cat['slug'] }}'" 
                        class="text-xs sm:text-sm font-bold px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 cursor-pointer"
                        :class="resolveCategoryMatch(selectedCategory, '{{ $cat['slug'] }}') 
                            ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20 scale-102' 
                            : 'bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200 hover:border-slate-300 hover:text-slate-900'"
                    >
                        <span>{{ $cat['name'] }}</span>
                        <span 
                            class="text-[11px] px-2 py-0.5 rounded-full font-extrabold"
                            :class="resolveCategoryMatch(selectedCategory, '{{ $cat['slug'] }}') ? 'bg-emerald-500 text-slate-950' : 'bg-white text-slate-600 border border-slate-200'"
                        >
                            {{ $cat['count'] }}
                        </span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Filter Controls & View Switcher Bar (Image 2) -->
        <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-5 mb-8 shadow-xs space-y-4">
            
            <!-- Top Row: Course Counter on Left, Reset & View Switcher on Right -->
            <div class="flex items-center justify-between gap-4 pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <span class="text-sm sm:text-base font-black text-slate-900">
                        Showing <span class="text-emerald-700 font-black" x-text="filteredCourses.length"></span> Course<span x-show="filteredCourses.length !== 1">s</span>
                    </span>
                    <span 
                        x-show="subsidizedOnly" 
                        class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800"
                    >
                        Subsidized Only
                    </span>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Reset Filters Button -->
                    <button 
                        type="button" 
                        x-show="hasActiveFilters" 
                        @click="clearFilters()" 
                        class="text-xs font-bold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-xl flex items-center gap-1.5 transition cursor-pointer"
                    >
                        <i class="fa-solid fa-rotate-left text-xs"></i>
                        <span>Reset Filters</span>
                    </button>

                    <!-- Grid vs List View Toggle -->
                    <div class="flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200">
                        <button 
                            type="button" 
                            @click="viewMode = 'grid'" 
                            class="p-1.5 rounded-lg transition cursor-pointer"
                            :class="viewMode === 'grid' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-800'"
                            aria-label="Grid View"
                            title="Grid View"
                        >
                            <i class="fa-solid fa-table-cells-large text-sm"></i>
                        </button>
                        <button 
                            type="button" 
                            @click="viewMode = 'list'" 
                            class="p-1.5 rounded-lg transition cursor-pointer"
                            :class="viewMode === 'list' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-800'"
                            aria-label="List View"
                            title="List View"
                        >
                            <i class="fa-solid fa-list text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bottom Row: Symmetrical 3-Column Filter Controls Grid (Image 2) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-center">
                
                <!-- Duration Dropdown -->
                <div>
                    <label class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-1">
                        DURATION
                    </label>
                    <select 
                        x-model="selectedDuration" 
                        class="w-full text-xs sm:text-sm font-semibold px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-800 focus:outline-hidden focus:border-emerald-500 cursor-pointer transition"
                    >
                        <option value="all">All Durations</option>
                        <option value="1 Month">1 Month Intensive</option>
                        <option value="3 Months">3 Months Diploma</option>
                        <option value="6 Months">6 Months Comprehensive</option>
                    </select>
                </div>

                <!-- Sort Dropdown -->
                <div>
                    <label class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-1">
                        SORT BY
                    </label>
                    <select 
                        x-model="sortBy" 
                        class="w-full text-xs sm:text-sm font-semibold px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-800 focus:outline-hidden focus:border-emerald-500 cursor-pointer transition"
                    >
                        <option value="recommended">Recommended</option>
                        <option value="seats-asc">Fewest Seats Remaining</option>
                        <option value="hours-desc">Highest Practical Hours</option>
                        <option value="hours-asc">Shortest Hours</option>
                        <option value="title-asc">Course Title (A-Z)</option>
                    </select>
                </div>

                <!-- Subsidized Only Toggle Button -->
                <div>
                    <label class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-1">
                        GOVT AID
                    </label>
                    <button 
                        type="button" 
                        @click="subsidizedOnly = !subsidizedOnly" 
                        class="w-full py-2.5 px-3.5 rounded-xl border text-xs sm:text-sm font-bold transition-all flex items-center justify-center gap-2 cursor-pointer"
                        :class="subsidizedOnly ? 'bg-emerald-600 text-white border-emerald-600 shadow-xs' : 'bg-slate-50 hover:bg-slate-100 text-slate-700 border-slate-200'"
                    >
                        <i class="fa-solid fa-circle-check text-sm" :class="subsidizedOnly ? 'text-white' : 'text-slate-400'"></i>
                        <span>Subsidized Only</span>
                    </button>
                </div>

            </div>
        </div>

        <!-- ==============================================================
             3. COURSES CONTAINER: GRID VIEW OR LIST VIEW
             ============================================================== -->
        
        <!-- GRID VIEW -->
        <div x-show="viewMode === 'grid' && filteredCourses.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            <template x-for="course in filteredCourses" :key="course.id">
                <div class="group bg-white rounded-3xl border border-slate-200 hover:border-emerald-500/50 shadow-xs hover:shadow-2xl hover:shadow-slate-200/70 transition-all duration-300 overflow-hidden flex flex-col justify-between">
                    <div>
                        <!-- Thumbnail Container -->
                        <div class="relative h-56 sm:h-64 w-full overflow-hidden bg-slate-900">
                            <img 
                                :src="course.image || 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=800&auto=format&fit=crop'" 
                                :alt="course.title" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent pointer-events-none"></div>

                            <!-- Top Badges -->
                            <div class="absolute top-4 left-4 right-4 flex items-center justify-between gap-2 pointer-events-none">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-white/95 text-slate-800 shadow-md backdrop-blur-md" x-text="course.category"></span>
                                <span class="text-xs font-extrabold px-3 py-1 rounded-full bg-emerald-500 text-slate-950 shadow-md">
                                    <span x-text="course.seats_remaining || 8"></span> Seats Left
                                </span>
                            </div>

                            <!-- Bottom Fee Pill -->
                            <div class="absolute bottom-4 left-4 right-4 pointer-events-none">
                                <span class="inline-block text-xs font-bold px-3.5 py-1.5 rounded-xl bg-slate-900/90 text-emerald-400 border border-emerald-400/20 backdrop-blur-md shadow-lg" x-text="course.fee || 'Govt Subsidized'"></span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <a :href="'/courses/' + course.slug">
                                <h3 class="text-lg sm:text-xl font-black text-slate-900 group-hover:text-emerald-700 transition-colors leading-snug" x-text="course.title"></h3>
                            </a>

                            <p class="text-xs sm:text-sm text-slate-600 mt-2.5 line-clamp-2 leading-relaxed" x-text="course.short_description || course.overview"></p>

                            <!-- Course Meta Key Facts -->
                            <div class="mt-5 pt-5 border-t border-slate-100 space-y-2.5 text-xs text-slate-600">
                                <div class="flex items-center gap-2">
                                    <i class="fa-regular fa-clock text-emerald-600 shrink-0 text-sm"></i>
                                    <span class="font-semibold text-slate-800">Duration:</span>
                                    <span><span x-text="course.duration"></span><span x-show="course.total_hours && !(course.duration || '').toLowerCase().includes('hour')" x-text="' (' + course.total_hours + ' Hours)'"></span></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-graduation-cap text-emerald-600 shrink-0 text-sm"></i>
                                    <span class="font-semibold text-slate-800">Eligibility:</span>
                                    <span class="truncate" x-text="course.prerequisites || 'Minimum SSC / Equivalent'"></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-map-pin text-emerald-600 shrink-0 text-sm"></i>
                                    <span class="font-semibold text-slate-800">Hubs:</span>
                                    <span class="truncate" x-text="course.centers || 'Available across 64 Regional Hubs'"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions Bar: View Details + Apply Now -->
                    <div class="p-6 pt-0 flex items-center gap-2.5">
                        <a :href="'/courses/' + course.slug" class="flex-1 py-3 px-4 rounded-xl border border-slate-200 hover:border-slate-300 bg-slate-50 hover:bg-slate-100 text-slate-800 font-bold text-xs sm:text-sm text-center transition">
                            View Details
                        </a>
                        <a :href="'/register?trade=' + encodeURIComponent(course.title)" class="flex-1 py-3 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs sm:text-sm text-center transition shadow-md shadow-emerald-900/20 flex items-center justify-center gap-1.5">
                            <span>Apply Now</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            </template>
        </div>

        <!-- LIST VIEW -->
        <div x-show="viewMode === 'list' && filteredCourses.length > 0" class="space-y-6">
            <template x-for="course in filteredCourses" :key="'list-' + course.id">
                <div class="group bg-white rounded-3xl border border-slate-200 hover:border-emerald-500/50 shadow-xs hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col md:flex-row items-stretch">
                    <!-- Thumbnail on Left -->
                    <div class="relative w-full md:w-80 lg:w-96 shrink-0 h-56 md:h-auto bg-slate-900 overflow-hidden">
                        <img 
                            :src="course.image || 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=800&auto=format&fit=crop'" 
                            :alt="course.title" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        >
                        <div class="absolute top-4 left-4">
                            <span class="text-xs font-extrabold px-3 py-1 rounded-full bg-emerald-500 text-slate-950 shadow-md">
                                <span x-text="course.seats_remaining || 8"></span> Seats Left
                            </span>
                        </div>
                    </div>

                    <!-- Details on Right -->
                    <div class="p-6 sm:p-8 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200" x-text="course.category"></span>
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-slate-900 text-emerald-400" x-text="course.fee || 'Govt Subsidized'"></span>
                            </div>

                            <a :href="'/courses/' + course.slug">
                                <h3 class="text-xl sm:text-2xl font-black text-slate-900 group-hover:text-emerald-700 transition-colors leading-snug" x-text="course.title"></h3>
                            </a>

                            <p class="text-sm text-slate-600 mt-2 leading-relaxed" x-text="course.short_description || course.overview"></p>

                            <!-- Fact Row -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-4 pt-4 border-t border-slate-100 text-xs sm:text-sm text-slate-600">
                                <div class="flex items-center gap-2">
                                    <i class="fa-regular fa-clock text-emerald-600 shrink-0"></i>
                                    <span><strong>Duration:</strong> <span x-text="course.duration"></span></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-graduation-cap text-emerald-600 shrink-0"></i>
                                    <span class="truncate"><strong>Eligibility:</strong> <span x-text="course.prerequisites || 'Minimum SSC / Equivalent'"></span></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-map-pin text-emerald-600 shrink-0"></i>
                                    <span class="truncate"><strong>Centers:</strong> <span x-text="course.centers || 'Available across 64 Regional Hubs'"></span></span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions: View Details + Apply -->
                        <div class="pt-2 flex flex-wrap items-center gap-3">
                            <a :href="'/courses/' + course.slug" class="py-2.5 px-5 rounded-xl border border-slate-200 hover:border-slate-300 bg-slate-50 hover:bg-slate-100 text-slate-800 font-bold text-xs sm:text-sm transition">
                                View Details
                            </a>
                            <a :href="'/register?trade=' + encodeURIComponent(course.title)" class="py-2.5 px-6 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs sm:text-sm transition shadow-md shadow-emerald-900/20 flex items-center gap-1.5">
                                <span>Apply for Admission</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- EMPTY STATE -->
        <div x-show="filteredCourses.length === 0" class="text-center py-16 sm:py-24 bg-white rounded-3xl border border-slate-200 p-8 max-w-xl mx-auto shadow-xs">
            <div class="w-16 h-16 rounded-3xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4 border border-slate-200">
                <i class="fa-solid fa-book-open text-2xl text-slate-400"></i>
            </div>
            <h3 class="text-xl sm:text-2xl font-black text-slate-900">
                No Matching Courses Found
            </h3>
            <p class="text-sm text-slate-600 mt-2 leading-relaxed">
                We couldn't find any technical trades matching your filter criteria. Try searching for a different keyword or reset filters.
            </p>
            <button 
                type="button" 
                @click="clearFilters()" 
                class="mt-6 px-6 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs sm:text-sm transition inline-flex items-center gap-2 cursor-pointer"
            >
                <i class="fa-solid fa-rotate-left text-xs"></i>
                <span>Reset All Filters</span>
            </button>
        </div>

        <!-- ==============================================================
             4. BOTTOM COUNSELING & SUPPORT BANNER (Matching Next.js & Screenshot)
             ============================================================== -->
        <div class="mt-14 sm:mt-20 rounded-3xl bg-gradient-to-r from-slate-950 via-slate-900 to-emerald-950 border border-slate-800 p-8 sm:p-12 text-white shadow-xl relative overflow-hidden">
            <div class="absolute -top-12 -right-12 w-48 h-48 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
                <div class="lg:col-span-8 space-y-3 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-xs font-bold">
                        <i class="fa-solid fa-award text-amber-400"></i>
                        <span>Free Academic & Trade Counseling</span>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                        {{ $settings['coursesPageCtaTitle'] ?? 'Not Sure Which Technical Trade is Best For You?' }}
                    </h3>
                    <p class="text-sm sm:text-base text-slate-300 leading-relaxed max-w-2xl">
                        {{ $settings['coursesPageCtaSubtitle'] ?? 'Speak directly with our regional academic advisors to learn about trade prospects, government loan opportunities for graduates, and practical lab schedules in your district.' }}
                    </p>
                </div>

                <div class="lg:col-span-4 flex flex-col sm:flex-row lg:flex-col items-center justify-center lg:items-end gap-3 shrink-0">
                    <a 
                        href="tel:{{ $settings['coursesPageHelplinePhone'] ?? '+8801700000000' }}" 
                        class="w-full sm:w-auto lg:w-full py-3.5 px-6 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm text-center shadow-lg shadow-emerald-900/40 transition flex items-center justify-center gap-2"
                    >
                        <i class="fa-solid fa-phone text-sm"></i>
                        <span>Call Hotline: {{ $settings['coursesPageHelplinePhone'] ?? '+880 1700-000000' }}</span>
                    </a>
                    <a 
                        href="/#notice-board" 
                        class="w-full sm:w-auto lg:w-full py-3 px-6 rounded-2xl bg-white/10 hover:bg-white/15 text-slate-200 border border-white/15 font-semibold text-xs sm:text-sm text-center transition"
                    >
                        Admission Circulars & Guidelines
                    </a>
                </div>
            </div>
        </div>

    </main>
</div>
@endsection
