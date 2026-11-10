<!DOCTYPE html>
<html lang="en" class="bg-slate-50 overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directorate Control Center - National Youth Platform Admin</title>
    <link rel="icon" type="image/png" href="/favicon.png?v=2">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico?v=2">
    <link rel="apple-touch-icon" href="/favicon.png?v=2">
    
    <!-- Google Fonts: Hind Siliguri (Universal clean font) -->
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
                    },
                    fontSize: {
                        'xs': ['0.875rem', { lineHeight: '1.35rem' }],    // 14px
                        'sm': ['1rem', { lineHeight: '1.5rem' }],         // 16px
                        'base': ['1.125rem', { lineHeight: '1.75rem' }],  // 18px
                        'lg': ['1.25rem', { lineHeight: '1.85rem' }],     // 20px
                        'xl': ['1.375rem', { lineHeight: '1.95rem' }],    // 22px
                        '2xl': ['1.625rem', { lineHeight: '2.2rem' }],    // 26px
                        '3xl': ['2rem', { lineHeight: '2.5rem' }],        // 32px
                    }
                }
            }
        }
    </script>
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        html, body {
            overflow-x: hidden !important;
            max-width: 100vw;
            width: 100%;
        }
        html { font-size: 16px; }
        body { 
            font-family: 'Hind Siliguri', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        /* Sleek modern scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #f8fafc; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased flex flex-col justify-between text-base overflow-x-hidden w-full max-w-full" x-data="{
    sidebarOpen: false,
    activeTab: '{{ $activeTab ?? 'overview' }}',
    setTab(tab) {
        this.activeTab = tab;
        this.sidebarOpen = false;
        if (window.history && window.history.replaceState) {
            window.history.replaceState(null, '', '/admin?tab=' + tab);
        }
    },
    
    // Hero Slide Modals & State
    isHeroSlideModalOpen: false,
    isEditHeroSlideModalOpen: false,
    editingHeroSlide: {},
    openEditHeroSlide(slide) {
        this.editingHeroSlide = Object.assign({}, slide);
        this.isEditHeroSlideModalOpen = true;
    },

    // Course Modals & State
    isCourseModalOpen: false,
    isEditCourseModalOpen: false,
    editingCourse: {},
    openEditCourse(course) {
        this.editingCourse = Object.assign({}, course);
        if (Array.isArray(course.learning_outcomes)) {
            this.editingCourse.learning_outcomes_text = course.learning_outcomes.join('\n');
        } else {
            this.editingCourse.learning_outcomes_text = course.learning_outcomes || '';
        }
        if (Array.isArray(course.career_opportunities)) {
            this.editingCourse.career_opportunities_text = course.career_opportunities.join('\n');
        } else {
            this.editingCourse.career_opportunities_text = course.career_opportunities || '';
        }
        if (Array.isArray(course.curriculum)) {
            this.editingCourse.curriculum_text = course.curriculum.map(m => m.title || m).join('\n');
        } else {
            this.editingCourse.curriculum_text = course.curriculum || '';
        }
        this.isEditCourseModalOpen = true;
    },

    // Result Modals & State
    isResultModalOpen: {{ $errors->any() && (old('roll_no') || old('student_name')) ? 'true' : 'false' }},
    isEditResultModalOpen: false,
    editingResult: {},
    includeResultMarks: false,
    resultMarks: [],
    addResultMarkRow() {
        this.includeResultMarks = true;
        this.resultMarks.push({ subject: '', fullMarks: 100, obtained: 80, grade: 'A+' });
    },
    loadSampleResultMarks() {
        this.includeResultMarks = true;
        this.resultMarks = [
            { subject: 'Theoretical Knowledge & Concepts', fullMarks: 100, obtained: 85, grade: 'A+' },
            { subject: 'Practical Trade Workshop Performance', fullMarks: 100, obtained: 90, grade: 'A+' },
            { subject: 'Continuous Assessment & Viva Voce', fullMarks: 100, obtained: 88, grade: 'A+' }
        ];
    },
    removeResultMarkRow(index) {
        this.resultMarks.splice(index, 1);
        if (this.resultMarks.length === 0) {
            this.includeResultMarks = false;
        }
    },
    includeEditResultMarks: false,
    openEditResult(result) {
        this.editingResult = Object.assign({}, result);
        if (Array.isArray(this.editingResult.marks) && this.editingResult.marks.length > 0) {
            this.editingResult.marks = JSON.parse(JSON.stringify(this.editingResult.marks));
            this.includeEditResultMarks = true;
        } else {
            this.editingResult.marks = [];
            this.includeEditResultMarks = false;
        }
        this.isEditResultModalOpen = true;
    },
    addEditResultMarkRow() {
        this.includeEditResultMarks = true;
        if (!Array.isArray(this.editingResult.marks)) {
            this.editingResult.marks = [];
        }
        this.editingResult.marks.push({ subject: '', fullMarks: 100, obtained: 80, grade: 'A+' });
    },
    loadSampleEditResultMarks() {
        this.includeEditResultMarks = true;
        this.editingResult.marks = [
            { subject: 'Theoretical Knowledge & Concepts', fullMarks: 100, obtained: 85, grade: 'A+' },
            { subject: 'Practical Trade Workshop Performance', fullMarks: 100, obtained: 90, grade: 'A+' },
            { subject: 'Continuous Assessment & Viva Voce', fullMarks: 100, obtained: 88, grade: 'A+' }
        ];
    },
    removeEditResultMarkRow(index) {
        this.editingResult.marks.splice(index, 1);
        if (this.editingResult.marks.length === 0) {
            this.includeEditResultMarks = false;
        }
    },

    // Admission Modals & State
    isAdmissionModalOpen: false,
    editingAdmission: {},
    openEditAdmission(adm) {
        this.editingAdmission = Object.assign({}, adm);
        this.isAdmissionModalOpen = true;
    },

    // Resource Modals & State
    isResourceModalOpen: false,
    isEditResourceModalOpen: false,
    editingResource: {},
    openEditResource(res) {
        this.editingResource = Object.assign({}, res);
        this.isEditResourceModalOpen = true;
    },

    // Gallery Modals & State
    isGalleryModalOpen: false,
    isEditGalleryModalOpen: false,
    editingGallery: {},
    openEditGallery(item) {
        this.editingGallery = Object.assign({}, item);
        if (!this.editingGallery.description && this.editingGallery.caption) {
            this.editingGallery.description = this.editingGallery.caption;
        }
        this.isEditGalleryModalOpen = true;
    },

    // Testimonial Modals & State
    isTestimonialModalOpen: false,
    isEditTestimonialModalOpen: false,
    editingTestimonial: {},
    removeTestimonialAvatar: false,
    openEditTestimonial(testi) {
        this.editingTestimonial = Object.assign({}, testi);
        this.removeTestimonialAvatar = false;
        this.isEditTestimonialModalOpen = true;
    },

    // CMS Sub-Tab state
    cmsTab: '{{ $subTab ?? 'home' }}',

    // Dynamic Social Media Links State
    socialLinks: {{ json_encode($settings['socialLinksArray'] ?? []) }},
    socialPlatformOptions: {
        'Facebook': { icon: 'fa-brands fa-facebook-f', color: 'hover:bg-blue-600' },
        'YouTube': { icon: 'fa-brands fa-youtube', color: 'hover:bg-red-600' },
        'LinkedIn': { icon: 'fa-brands fa-linkedin-in', color: 'hover:bg-sky-600' },
        'Instagram': { icon: 'fa-brands fa-instagram', color: 'hover:bg-pink-600' },
        'Twitter / X': { icon: 'fa-brands fa-x-twitter', color: 'hover:bg-slate-800' },
        'WhatsApp': { icon: 'fa-brands fa-whatsapp', color: 'hover:bg-emerald-600' },
        'TikTok': { icon: 'fa-brands fa-tiktok', color: 'hover:bg-slate-900' },
        'Telegram': { icon: 'fa-brands fa-telegram', color: 'hover:bg-sky-500' },
        'Website': { icon: 'fa-solid fa-globe', color: 'hover:bg-emerald-600' }
    },
    addSocialLink() {
        this.socialLinks.push({
            platform: 'Facebook',
            icon: 'fa-brands fa-facebook-f',
            url: 'https://',
            color: 'hover:bg-blue-600'
        });
    },
    updateSocialPlatform(index, platform) {
        const meta = this.socialPlatformOptions[platform] || { icon: 'fa-solid fa-globe', color: 'hover:bg-emerald-600' };
        this.socialLinks[index].platform = platform;
        this.socialLinks[index].icon = meta.icon;
        this.socialLinks[index].color = meta.color;
    },
    removeSocialLink(index) {
        this.socialLinks.splice(index, 1);
    },

    // Global Delete Confirmation Modal State
    isDeleteConfirmOpen: false,
    deleteTargetUrl: '',
    deleteItemTitle: '',
    deleteItemType: '',
    openDeleteModal(url, title, type = 'Record') {
        this.deleteTargetUrl = url;
        this.deleteItemTitle = title;
        this.deleteItemType = type;
        this.isDeleteConfirmOpen = true;
    },
    closeDeleteModal() {
        this.isDeleteConfirmOpen = false;
        this.deleteTargetUrl = '';
        this.deleteItemTitle = '';
    }
}">

    <!-- Top Full-Width Directorate Header Bar (Light Clean SaaS Theme) -->
    <header class="w-full max-w-full bg-white border-b border-slate-200/90 sticky top-0 z-40 shadow-xs overflow-x-clip">
        <div class="w-full max-w-full px-2.5 sm:px-6 py-2 sm:py-2.5 flex items-center justify-between gap-1.5 sm:gap-3">
            
            <!-- Left Branding & Mobile Hamburger Toggle -->
            <div class="flex items-center gap-1.5 sm:gap-3 min-w-0 flex-1">
                <button 
                    type="button" 
                    @click="sidebarOpen = !sidebarOpen" 
                    class="lg:hidden p-1.5 sm:p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition shrink-0"
                    aria-label="Toggle navigation"
                >
                    <i class="fa-solid fa-bars text-base sm:text-lg"></i>
                </button>

                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-1.5 sm:gap-2.5 group min-w-0">
                    @if(!empty($settings['headerLogoImage']))
                        <img src="{{ $settings['headerLogoImage'] }}" alt="Logo" class="h-8 sm:h-10 w-auto max-w-[90px] object-contain rounded-lg group-hover:scale-105 transition-transform shrink-0">
                    @else
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white font-black text-[11px] sm:text-sm shadow-xs group-hover:scale-105 transition-transform shrink-0">
                            {{ $settings['headerLogoText'] ?? 'NYD' }}
                        </div>
                    @endif
                    <div class="flex flex-col min-w-0">
                        <div class="flex items-center gap-1.5 sm:gap-2">
                            <span class="text-xs sm:text-base md:text-lg font-bold text-slate-900 tracking-tight leading-tight truncate">Admin Directorate</span>
                            <span class="hidden sm:inline-flex bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs px-2 py-0.5 rounded-full font-semibold shrink-0">
                                Control Center
                            </span>
                        </div>
                        <span class="hidden sm:block text-[11px] sm:text-xs text-slate-500 font-normal truncate max-w-[180px] sm:max-w-xs md:max-w-none">
                            {{ $settings['instituteName'] }}
                        </span>
                    </div>
                </a>
            </div>

            <!-- Right Header Actions (Light Clean Layout) -->
            <div class="flex items-center gap-1 sm:gap-2.5 shrink-0">
                <a 
                    href="{{ route('home') }}" 
                    target="_blank" 
                    class="flex items-center justify-center gap-1.5 p-1.5 sm:px-3 sm:py-1.5 rounded-xl bg-slate-100 hover:bg-emerald-50 border border-slate-200/90 hover:border-emerald-200 text-slate-700 hover:text-emerald-800 text-xs sm:text-sm font-semibold transition shrink-0"
                    title="Open live public website in new tab"
                >
                    <i class="fa-solid fa-arrow-up-right-from-square text-emerald-600 text-xs"></i>
                    <span class="hidden sm:inline">Live Website</span>
                </a>

                <div class="flex items-center gap-2 pl-1 sm:pl-2.5 border-l border-slate-200 shrink-0">
                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-[11px] sm:text-xs shadow-xs shrink-0">
                        AD
                    </div>
                    <div class="hidden md:flex flex-col text-left">
                        <span class="text-xs font-bold text-slate-800 leading-tight">{{ auth()->user()->name ?? 'Administrator' }}</span>
                        <span class="text-[11px] text-slate-500 font-mono leading-tight">{{ auth()->user()->email ?? 'admin@jubounnayon.com' }}</span>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="inline shrink-0 m-0">
                    @csrf
                    <button 
                        type="submit" 
                        class="p-1.5 sm:p-2 rounded-xl text-rose-600 hover:text-rose-700 hover:bg-rose-50 border border-transparent hover:border-rose-200 transition text-sm flex items-center justify-center shrink-0" 
                        title="Sign Out"
                    >
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </button>
                </form>
            </div>

        </div>

        <!-- Mobile Horizontal Tab Quick Swiper (For fast, smooth mobile access) -->
        <div class="lg:hidden w-full max-w-full overflow-x-auto no-scrollbar border-t border-slate-200/80 bg-slate-50 px-2 py-1.5 flex items-center gap-1.5 scroll-smooth overscroll-x-contain">
            <button 
                type="button" 
                @click="setTab('overview')" 
                :class="activeTab === 'overview' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-700 border border-slate-200'" 
                class="px-3 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition shadow-2xs shrink-0"
            >
                <i class="fa-solid fa-chart-pie mr-1"></i> Overview
            </button>
            <button 
                type="button" 
                @click="setTab('courses')" 
                :class="activeTab === 'courses' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-700 border border-slate-200'" 
                class="px-3 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition shadow-2xs shrink-0"
            >
                <i class="fa-solid fa-book-open mr-1"></i> Courses ({{ $stats['totalCourses'] }})
            </button>
            <button 
                type="button" 
                @click="setTab('results')" 
                :class="activeTab === 'results' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-700 border border-slate-200'" 
                class="px-3 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition shadow-2xs shrink-0"
            >
                <i class="fa-solid fa-award mr-1"></i> Results ({{ $stats['totalResults'] }})
            </button>
            <button 
                type="button" 
                @click="setTab('admissions')" 
                :class="activeTab === 'admissions' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-700 border border-slate-200'" 
                class="px-3 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition shadow-2xs shrink-0"
            >
                <i class="fa-solid fa-user-check mr-1"></i> Admissions ({{ $stats['pendingAdmissions'] }})
            </button>
            <button 
                type="button" 
                @click="setTab('inquiries')" 
                :class="activeTab === 'inquiries' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-700 border border-slate-200'" 
                class="px-3 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition shadow-2xs shrink-0"
            >
                <i class="fa-solid fa-envelope mr-1"></i> Inquiries ({{ $stats['newInquiries'] }})
            </button>
            <button 
                type="button" 
                @click="setTab('resources')" 
                :class="activeTab === 'resources' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-700 border border-slate-200'" 
                class="px-3 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition shadow-2xs shrink-0"
            >
                <i class="fa-solid fa-folder-open mr-1"></i> Resources ({{ $resources->count() }})
            </button>
            <button 
                type="button" 
                @click="setTab('gallery')" 
                :class="activeTab === 'gallery' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-700 border border-slate-200'" 
                class="px-3 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition shadow-2xs shrink-0"
            >
                <i class="fa-solid fa-images mr-1"></i> Gallery ({{ $gallery->count() }})
            </button>
            <button 
                type="button" 
                @click="setTab('testimonials')" 
                :class="activeTab === 'testimonials' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-700 border border-slate-200'" 
                class="px-3 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition shadow-2xs shrink-0"
            >
                <i class="fa-solid fa-comment-dots mr-1"></i> Testimonials ({{ $testimonials->count() }})
            </button>
            <button 
                type="button" 
                @click="setTab('settings')" 
                :class="activeTab === 'settings' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-700 border border-slate-200'" 
                class="px-3 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition shadow-2xs shrink-0"
            >
                <i class="fa-solid fa-gear mr-1"></i> Site CMS & Settings
            </button>
        </div>
    </header>

    <!-- Main Edge-to-Edge Layout: Wider Sidebar (w-80 / 320px) as requested -->
    <div class="w-full max-w-full flex flex-1 min-h-[calc(100vh-61px)] min-w-0 overflow-x-hidden">
        
        <!-- Mobile Sidebar Backdrop Overlay -->
        <div 
            x-show="sidebarOpen" 
            x-cloak 
            @click="sidebarOpen = false" 
            class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-xs lg:hidden transition-opacity"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        ></div>

        <!-- Left Sidebar Navigation (Increased width to w-80 / 320px) -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed lg:sticky top-[61px] left-0 z-50 w-80 h-[calc(100vh-61px)] bg-white border-r border-slate-200/90 flex flex-col justify-between transition-transform duration-300 ease-in-out shrink-0 overflow-y-auto shadow-lg lg:shadow-none"
        >
            <div class="p-3.5 space-y-1">
                <!-- Mobile Drawer Close Header -->
                <div class="lg:hidden flex items-center justify-between pb-3 mb-2 border-b border-slate-100">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Navigation Menu</span>
                    <button type="button" @click="sidebarOpen = false" class="p-1 rounded-lg text-slate-400 hover:text-slate-700">
                        <i class="fa-solid fa-xmark text-base"></i>
                    </button>
                </div>

                <div class="px-3 py-1.5 text-xs font-bold tracking-wider uppercase text-slate-400">
                    Management Modules
                </div>

                <!-- Navigation Tabs -->
                <button 
                    type="button" 
                    @click="setTab('overview')"
                    :class="activeTab === 'overview' ? 'bg-emerald-50 text-emerald-800 font-bold border-l-4 border-emerald-600 shadow-2xs' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900 font-medium'"
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm transition text-left cursor-pointer"
                >
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-chart-pie text-base" :class="activeTab === 'overview' ? 'text-emerald-600' : 'text-slate-400'"></i>
                        <span>Dashboard Overview</span>
                    </div>
                </button>

                <button 
                    type="button" 
                    @click="setTab('courses')"
                    :class="activeTab === 'courses' ? 'bg-emerald-50 text-emerald-800 font-bold border-l-4 border-emerald-600 shadow-2xs' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900 font-medium'"
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm transition text-left cursor-pointer"
                >
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-book-open text-base" :class="activeTab === 'courses' ? 'text-emerald-600' : 'text-slate-400'"></i>
                        <span>Courses & Trades</span>
                    </div>
                    <span class="text-xs bg-slate-100 text-slate-700 font-semibold px-2 py-0.5 rounded-full border border-slate-200">
                        {{ $stats['totalCourses'] }}
                    </span>
                </button>

                <button 
                    type="button" 
                    @click="setTab('results')"
                    :class="activeTab === 'results' ? 'bg-emerald-50 text-emerald-800 font-bold border-l-4 border-emerald-600 shadow-2xs' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900 font-medium'"
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm transition text-left cursor-pointer"
                >
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-award text-base" :class="activeTab === 'results' ? 'text-emerald-600' : 'text-slate-400'"></i>
                        <span>Results & Marksheets</span>
                    </div>
                    <span class="text-xs bg-slate-100 text-slate-700 font-semibold px-2 py-0.5 rounded-full border border-slate-200">
                        {{ $stats['totalResults'] }}
                    </span>
                </button>

                <button 
                    type="button" 
                    @click="setTab('admissions')"
                    :class="activeTab === 'admissions' ? 'bg-emerald-50 text-emerald-800 font-bold border-l-4 border-emerald-600 shadow-2xs' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900 font-medium'"
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm transition text-left cursor-pointer"
                >
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-user-check text-base" :class="activeTab === 'admissions' ? 'text-emerald-600' : 'text-slate-400'"></i>
                        <span>Admissions / Trainees</span>
                    </div>
                    @if($stats['pendingAdmissions'] > 0)
                        <span class="text-xs bg-amber-100 text-amber-800 font-bold px-2 py-0.5 rounded-full border border-amber-200">
                            {{ $stats['pendingAdmissions'] }} New
                        </span>
                    @else
                        <span class="text-xs bg-slate-100 text-slate-600 font-semibold px-2 py-0.5 rounded-full">
                            {{ $admissions->count() }}
                        </span>
                    @endif
                </button>

                <button 
                    type="button" 
                    @click="setTab('inquiries')"
                    :class="activeTab === 'inquiries' ? 'bg-emerald-50 text-emerald-800 font-bold border-l-4 border-emerald-600 shadow-2xs' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900 font-medium'"
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm transition text-left cursor-pointer"
                >
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-envelope-open-text text-base" :class="activeTab === 'inquiries' ? 'text-emerald-600' : 'text-slate-400'"></i>
                        <span>Contact Inquiries</span>
                    </div>
                    @if($stats['newInquiries'] > 0)
                        <span class="text-xs bg-blue-100 text-blue-800 font-bold px-2 py-0.5 rounded-full border border-blue-200">
                            {{ $stats['newInquiries'] }}
                        </span>
                    @endif
                </button>

                <button 
                    type="button" 
                    @click="setTab('resources')"
                    :class="activeTab === 'resources' ? 'bg-emerald-50 text-emerald-800 font-bold border-l-4 border-emerald-600 shadow-2xs' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900 font-medium'"
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm transition text-left cursor-pointer"
                >
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-folder-open text-base" :class="activeTab === 'resources' ? 'text-emerald-600' : 'text-slate-400'"></i>
                        <span>Resources & Downloads</span>
                    </div>
                    <span class="text-xs bg-slate-100 text-slate-600 font-semibold px-2 py-0.5 rounded-full">
                        {{ $resources->count() }}
                    </span>
                </button>

                <button 
                    type="button" 
                    @click="setTab('gallery')"
                    :class="activeTab === 'gallery' ? 'bg-emerald-50 text-emerald-800 font-bold border-l-4 border-emerald-600 shadow-2xs' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900 font-medium'"
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm transition text-left cursor-pointer"
                >
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-images text-base" :class="activeTab === 'gallery' ? 'text-emerald-600' : 'text-slate-400'"></i>
                        <span>Photo Gallery</span>
                    </div>
                    <span class="text-xs bg-slate-100 text-slate-600 font-semibold px-2 py-0.5 rounded-full">
                        {{ $gallery->count() }}
                    </span>
                </button>

                <button 
                    type="button" 
                    @click="setTab('testimonials')"
                    :class="activeTab === 'testimonials' ? 'bg-emerald-50 text-emerald-800 font-bold border-l-4 border-emerald-600 shadow-2xs' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900 font-medium'"
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm transition text-left cursor-pointer"
                >
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-comment-dots text-base" :class="activeTab === 'testimonials' ? 'text-emerald-600' : 'text-slate-400'"></i>
                        <span>Testimonials (Alumni)</span>
                    </div>
                    <span class="text-xs bg-slate-100 text-slate-600 font-semibold px-2 py-0.5 rounded-full">
                        {{ $testimonials->count() }}
                    </span>
                </button>

                <button 
                    type="button" 
                    @click="setTab('settings')"
                    :class="activeTab === 'settings' ? 'bg-emerald-50 text-emerald-800 font-bold border-l-4 border-emerald-600 shadow-2xs' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900 font-medium'"
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm transition text-left cursor-pointer"
                >
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-sliders text-base" :class="activeTab === 'settings' ? 'text-emerald-600' : 'text-slate-400'"></i>
                        <span>A-Z Site Content & CMS</span>
                    </div>
                </button>
            </div>

            <!-- Sidebar Bottom Info -->
            <div class="p-4 border-t border-slate-200/90 bg-slate-50 text-xs text-slate-500">
                <div class="flex items-center justify-between font-semibold text-slate-700 mb-1">
                    <span>Active Session</span>
                    <span class="text-emerald-700">{{ $settings['currentSession'] }}</span>
                </div>
                <p class="text-[11px] text-slate-400 truncate">{{ $settings['instituteName'] }}</p>
            </div>
        </aside>

        <!-- Right Content Main Arena -->
        <main class="flex-1 w-full max-w-full min-w-0 p-2.5 sm:p-5 lg:p-6 overflow-x-hidden space-y-4">
            
            <!-- Global Flash Messages (English, Dismissible) -->
            @if($errors->any())
                <div x-data="{ show: true }" x-show="show" class="bg-rose-50 border border-rose-200 text-rose-900 px-4 py-3.5 rounded-2xl text-sm shadow-2xs space-y-2">
                    <div class="flex items-center justify-between font-bold text-rose-800">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                            <span>Please check the errors below before submitting:</span>
                        </div>
                        <button type="button" @click="show = false" class="text-rose-700 hover:text-rose-900 font-bold">✕</button>
                    </div>
                    <ul class="list-disc list-inside text-xs font-semibold text-rose-700 pl-2 space-y-1">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="bg-emerald-50 border border-emerald-200 text-emerald-900 px-4 py-3 rounded-2xl flex items-center justify-between text-sm font-semibold shadow-2xs">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-600"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" @click="show = false" class="text-emerald-700 hover:text-emerald-900">✕</button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" class="bg-rose-50 border border-rose-200 text-rose-900 px-4 py-3 rounded-2xl flex items-center justify-between text-sm font-semibold shadow-2xs">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" @click="show = false" class="text-rose-700 hover:text-rose-900">✕</button>
                </div>
            @endif

            <!-- ==========================================
                 TAB 1: OVERVIEW & SYSTEM METRICS
                 ========================================== -->
            <div x-show="activeTab === 'overview'" class="space-y-4">
                
                <!-- Metric Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                    
                    <div class="bg-white p-3.5 sm:p-4 rounded-2xl border border-slate-200/90 shadow-2xs flex items-center justify-between gap-2">
                        <div class="min-w-0">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block truncate">Active Courses</span>
                            <h3 class="text-2xl sm:text-3xl font-bold text-slate-800 mt-0.5">{{ $stats['totalCourses'] }}</h3>
                            <span class="text-xs text-emerald-700 font-semibold flex items-center gap-1 mt-0.5">
                                <i class="fa-solid fa-circle-check text-[10px]"></i> Live on Catalog
                            </span>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-lg shrink-0">
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                    </div>

                    <div class="bg-white p-3.5 sm:p-4 rounded-2xl border border-slate-200/90 shadow-2xs flex items-center justify-between gap-2">
                        <div class="min-w-0">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block truncate">Verified Results</span>
                            <h3 class="text-2xl sm:text-3xl font-bold text-slate-800 mt-0.5">{{ $stats['totalResults'] }}</h3>
                            <span class="text-xs text-blue-700 font-semibold flex items-center gap-1 mt-0.5">
                                <i class="fa-solid fa-qrcode text-[10px]"></i> QR Authenticated
                            </span>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-lg shrink-0">
                            <i class="fa-solid fa-award"></i>
                        </div>
                    </div>

                    <div class="bg-white p-3.5 sm:p-4 rounded-2xl border border-slate-200/90 shadow-2xs flex items-center justify-between gap-2">
                        <div class="min-w-0">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block truncate">Admissions</span>
                            <h3 class="text-2xl sm:text-3xl font-bold text-amber-700 mt-0.5">{{ $stats['pendingAdmissions'] }}</h3>
                            <span class="text-xs text-amber-700 font-semibold flex items-center gap-1 mt-0.5">
                                <i class="fa-solid fa-clock text-[10px]"></i> Pending Review
                            </span>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-lg shrink-0">
                            <i class="fa-solid fa-user-check"></i>
                        </div>
                    </div>

                    <div class="bg-white p-3.5 sm:p-4 rounded-2xl border border-slate-200/90 shadow-2xs flex items-center justify-between gap-2">
                        <div class="min-w-0">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block truncate">New Inquiries</span>
                            <h3 class="text-2xl sm:text-3xl font-bold text-slate-800 mt-0.5">{{ $stats['newInquiries'] }}</h3>
                            <span class="text-xs text-purple-700 font-semibold flex items-center gap-1 mt-0.5">
                                <i class="fa-solid fa-envelope text-[10px]"></i> From Contact Form
                            </span>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center text-lg shrink-0">
                            <i class="fa-solid fa-envelope-open-text"></i>
                        </div>
                    </div>

                </div>

                <!-- Quick Action Shortcuts Bar -->
                <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-2xs flex flex-wrap items-center justify-between gap-3">
                    <span class="text-sm font-bold text-slate-700">Quick Administrative Actions:</span>
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button" @click="isCourseModalOpen = true" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs sm:text-sm flex items-center gap-1.5 transition">
                            <i class="fa-solid fa-plus text-xs"></i>
                            <span>Add New Course</span>
                        </button>
                        <button type="button" @click="isResultModalOpen = true" class="px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs sm:text-sm flex items-center gap-1.5 transition">
                            <i class="fa-solid fa-user-graduate text-xs"></i>
                            <span>Upload Student Result</span>
                        </button>
                        <button type="button" @click="isResourceModalOpen = true" class="px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs sm:text-sm flex items-center gap-1.5 transition">
                            <i class="fa-solid fa-upload text-xs"></i>
                            <span>Upload Document</span>
                        </button>
                    </div>
                </div>

                <!-- Two-Column Recent Activity Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    
                    <!-- Recent Online Admissions -->
                    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
                        <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-user-plus text-emerald-600"></i>
                                <h4 class="font-bold text-slate-800 text-sm sm:text-base">Recent Online Applications</h4>
                            </div>
                            <button type="button" @click="setTab('admissions')" class="text-xs font-semibold text-emerald-700 hover:underline">
                                View All ({{ $admissions->count() }}) &rarr;
                            </button>
                        </div>
                        <div class="divide-y divide-slate-100">
                            @forelse($admissions->take(4) as $adm)
                                <div class="p-3.5 flex items-center justify-between gap-3 hover:bg-slate-50/80 transition">
                                    <div>
                                        <h5 class="text-sm font-bold text-slate-800">{{ $adm->full_name }}</h5>
                                        <p class="text-xs text-slate-500">{{ $adm->trade }} • <span class="font-mono">{{ $adm->phone }}</span></p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs px-2.5 py-0.5 rounded-full font-semibold {{ $adm->status === 'Approved' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-amber-50 text-amber-800 border border-amber-200' }}">
                                            {{ $adm->status }}
                                        </span>
                                        <button type="button" @click="openEditAdmission({{ json_encode($adm) }})" class="p-1 rounded-md text-blue-600 hover:bg-blue-50 text-xs">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="p-6 text-center text-xs text-slate-400">No applications received yet.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Recent Contact Inquiries -->
                    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
                        <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-comments text-blue-600"></i>
                                <h4 class="font-bold text-slate-800 text-sm sm:text-base">Recent Contact Inquiries</h4>
                            </div>
                            <button type="button" @click="setTab('inquiries')" class="text-xs font-semibold text-blue-700 hover:underline">
                                View All ({{ $inquiries->count() }}) &rarr;
                            </button>
                        </div>
                        <div class="divide-y divide-slate-100">
                            @forelse($inquiries->take(4) as $inq)
                                <div class="p-3.5 flex items-center justify-between gap-3 hover:bg-slate-50/80 transition">
                                    <div class="min-w-0 flex-1">
                                        <h5 class="text-sm font-bold text-slate-800">{{ $inq->name }}</h5>
                                        <p class="text-xs text-slate-500 truncate">{{ $inq->message }}</p>
                                    </div>
                                    <span class="text-xs px-2.5 py-0.5 rounded-full font-semibold shrink-0 {{ $inq->status === 'Replied' ? 'bg-emerald-50 text-emerald-800' : 'bg-blue-50 text-blue-800' }}">
                                        {{ $inq->status }}
                                    </span>
                                </div>
                            @empty
                                <div class="p-6 text-center text-xs text-slate-400">No contact inquiries yet.</div>
                            @endforelse
                        </div>
                    </div>

                </div>

            </div>

            <!-- ==========================================
                 TAB 2: COURSES & TRADES (FULL CRUD & EDIT)
                 ========================================== -->
            <div x-show="activeTab === 'courses'" class="space-y-4">
                <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-2xs flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Vocational Courses & Trades</h3>
                        <p class="text-xs text-slate-500">Add, edit, upload thumbnails, and manage all active training programs across your website.</p>
                    </div>
                    <button type="button" @click="isCourseModalOpen = true" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm flex items-center justify-center gap-1.5 transition shadow-xs">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Add New Course</span>
                    </button>
                </div>

                <!-- Responsive Courses Table -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
                    <div class="overflow-x-auto w-full overscroll-x-contain pb-1">
                        <table class="w-full min-w-[760px] text-left text-sm">
                            <thead class="bg-slate-50 text-slate-500 font-semibold uppercase text-xs border-b border-slate-200/80">
                                <tr>
                                    <th class="py-3.5 px-4 min-w-[240px] whitespace-nowrap">Course Title & Category</th>
                                    <th class="py-3.5 px-4 whitespace-nowrap">Duration & Seats</th>
                                    <th class="py-3.5 px-4 whitespace-nowrap">Fee Structure</th>
                                    <th class="py-3.5 px-4 text-center whitespace-nowrap">Featured</th>
                                    <th class="py-3.5 px-4 text-right whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium">
                                @forelse($courses as $course)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="py-3.5 px-4 min-w-[240px]">
                                            <div class="font-bold text-slate-800 text-sm sm:text-base leading-snug">{{ $course->title }}</div>
                                            <div class="text-xs text-slate-500 flex flex-wrap items-center gap-1.5 mt-1">
                                                <span class="bg-slate-100 text-slate-700 px-2 py-0.5 rounded-md font-medium text-[11px]">{{ $course->category }}</span>
                                                @if($course->badge)
                                                    <span class="text-emerald-700 font-semibold text-[11px]">• {{ $course->badge }}</span>
                                                @endif
                                                @if($course->is_subsidized)
                                                    <span class="bg-emerald-50 text-emerald-800 text-[10px] font-bold px-1.5 py-0.5 rounded border border-emerald-200">Subsidized</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 text-xs text-slate-600 font-mono whitespace-nowrap">
                                            <div class="font-semibold text-slate-700">{{ $course->duration }}</div>
                                            <div class="text-slate-400">{{ $course->seats }} Seats Total</div>
                                        </td>
                                        <td class="py-3.5 px-4 text-xs font-semibold text-slate-700 whitespace-nowrap">
                                            {{ $course->fee }}
                                        </td>
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                            @if($course->featured)
                                                <span class="text-xs bg-emerald-50 text-emerald-800 px-2.5 py-0.5 rounded-full font-semibold border border-emerald-200">Yes</span>
                                            @else
                                                <span class="text-xs text-slate-400">No</span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-1.5">
                                                <!-- Edit Button (As Requested by User) -->
                                                <button 
                                                    type="button" 
                                                    @click="openEditCourse({{ json_encode($course) }})" 
                                                    class="p-2 rounded-lg text-blue-600 hover:text-blue-800 hover:bg-blue-50 transition" 
                                                    title="Edit Course Details"
                                                >
                                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                                </button>

                                                <a href="{{ route('courses.show', $course->slug) }}" target="_blank" class="p-2 rounded-lg text-slate-500 hover:text-emerald-700 hover:bg-slate-100 transition" title="View Public Page">
                                                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                                </a>

                                                <button 
                                                    type="button" 
                                                    @click="openDeleteModal('{{ route('admin.courses.delete', $course->id) }}', '{{ addslashes($course->title) }}', 'Course Program')" 
                                                    class="p-2 rounded-lg text-rose-500 hover:text-rose-700 hover:bg-rose-50 transition" 
                                                    title="Delete Course"
                                                >
                                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-slate-400 text-xs">No courses registered yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ==========================================
                 TAB 3: RESULTS & MARKSHEET (FULL CRUD & EDIT)
                 ========================================== -->
            <div x-show="activeTab === 'results'" class="space-y-4">
                <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-2xs flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Student Results & Marksheet Records</h3>
                        <p class="text-xs text-slate-500">Every record added here is immediately verifiable online and generates an A4 printable transcript.</p>
                    </div>
                    <button type="button" @click="isResultModalOpen = true" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm flex items-center justify-center gap-1.5 transition shadow-xs">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Upload Student Result</span>
                    </button>
                </div>

                <!-- Results Table -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
                    <div class="overflow-x-auto w-full overscroll-x-contain pb-1">
                        <table class="w-full min-w-[760px] text-left text-sm">
                            <thead class="bg-slate-50 text-slate-500 font-semibold uppercase text-xs border-b border-slate-200/80">
                                <tr>
                                    <th class="py-3.5 px-4 min-w-[220px] whitespace-nowrap">Student & Trade</th>
                                    <th class="py-3.5 px-4 whitespace-nowrap">Roll & Registration</th>
                                    <th class="py-3.5 px-4 whitespace-nowrap">Session & Year</th>
                                    <th class="py-3.5 px-4 text-center whitespace-nowrap">GPA / Grade</th>
                                    <th class="py-3.5 px-4 text-right whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium">
                                @forelse($results as $res)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="py-3.5 px-4 min-w-[240px]">
                                            <div class="flex items-center gap-3">
                                                @if(!empty($res->photo))
                                                    <img src="{{ $res->photo }}" alt="{{ $res->student_name }}" class="w-10 h-11 rounded-xl object-cover object-top border border-slate-200 shrink-0 shadow-2xs">
                                                @else
                                                    <div class="w-10 h-11 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 shrink-0">
                                                        <i class="fa-solid fa-user text-sm"></i>
                                                    </div>
                                                @endif
                                                <div class="min-w-0">
                                                    <div class="font-bold text-slate-800 text-sm sm:text-base">{{ $res->student_name }}</div>
                                                    <div class="text-xs text-slate-500 flex flex-wrap items-center gap-1.5 mt-0.5">
                                                        @if(!empty($res->course_code))
                                                            <span class="font-mono font-bold text-[10px] px-1.5 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200">{{ $res->course_code }}</span>
                                                        @endif
                                                        <span>{{ $res->trade }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 font-mono text-xs text-slate-700 whitespace-nowrap">
                                            <span class="font-bold text-slate-900">{{ $res->roll_no }}</span>
                                            <div class="text-slate-400">{{ $res->reg_no }}</div>
                                        </td>
                                        <td class="py-3.5 px-4 text-xs text-slate-600 whitespace-nowrap">
                                            <div>{{ $res->session }}</div>
                                            <div class="text-slate-400">Exam: {{ $res->exam_year }}</div>
                                        </td>
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                            <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 font-mono inline-block">
                                                @if(!empty($res->result_score)){{ $res->result_score }} • @endif GPA {{ number_format($res->gpa, 2) }} ({{ $res->grade }})
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-1.5">
                                                <!-- Edit Result Button -->
                                                <button 
                                                    type="button" 
                                                    @click="openEditResult({{ json_encode($res) }})" 
                                                    class="p-2 rounded-lg text-blue-600 hover:text-blue-800 hover:bg-blue-50 transition" 
                                                    title="Edit Student Result"
                                                >
                                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                                </button>

                                                <a href="{{ route('results.print', $res->roll_no) }}" target="_blank" class="p-2 rounded-lg text-slate-600 hover:text-emerald-700 hover:bg-slate-100 transition" title="Print A4 Marksheet">
                                                    <i class="fa-solid fa-print text-xs"></i>
                                                </a>

                                                <button 
                                                    type="button" 
                                                    @click="openDeleteModal('{{ route('admin.results.delete', $res->id) }}', '{{ addslashes($res->student_name) }} (Roll: {{ $res->roll_no }})', 'Student Academic Result')" 
                                                    class="p-2 rounded-lg text-rose-500 hover:text-rose-700 hover:bg-rose-50 transition" 
                                                    title="Delete Record"
                                                >
                                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-slate-400 text-xs">No student results recorded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ==========================================
                 TAB 4: ADMISSIONS / APPLICATIONS
                 ========================================== -->
            <div x-show="activeTab === 'admissions'" class="space-y-4">
                <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-2xs flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Student Admissions & Enrollment Requests</h3>
                        <p class="text-xs text-slate-500">Live admission applications submitted online by prospective students. Clicking 'Approve' assigns an official Roll No automatically.</p>
                    </div>
                    <span class="text-xs bg-slate-100 text-slate-700 font-semibold px-3 py-1.5 rounded-xl border border-slate-200">
                        Total Applications: {{ $admissions->count() }}
                    </span>
                </div>

                <!-- Admissions Table -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
                    <div class="overflow-x-auto w-full overscroll-x-contain pb-1">
                        <table class="w-full min-w-[800px] text-left text-sm">
                            <thead class="bg-slate-50 text-slate-500 font-semibold uppercase text-xs border-b border-slate-200/80">
                                <tr>
                                    <th class="py-3.5 px-4 min-w-[200px] whitespace-nowrap">Applicant Name</th>
                                    <th class="py-3.5 px-4 whitespace-nowrap">Contact Info</th>
                                    <th class="py-3.5 px-4 min-w-[200px] whitespace-nowrap">Selected Trade & Hub</th>
                                    <th class="py-3.5 px-4 text-center whitespace-nowrap">Status / Roll</th>
                                    <th class="py-3.5 px-4 text-right whitespace-nowrap">Approval Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium">
                                @forelse($admissions as $adm)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="py-3.5 px-4 font-bold text-slate-800 text-sm sm:text-base min-w-[200px]">
                                            {{ $adm->full_name }}
                                        </td>
                                        <td class="py-3.5 px-4 text-xs font-mono text-slate-600 whitespace-nowrap">
                                            <div>{{ $adm->phone }}</div>
                                            <div class="text-slate-400 font-sans">{{ $adm->email }}</div>
                                        </td>
                                        <td class="py-3.5 px-4 text-xs text-slate-700 min-w-[200px]">
                                            <div class="font-semibold">{{ $adm->trade }}</div>
                                            <div class="text-slate-400">{{ $adm->district }} Center</div>
                                        </td>
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                            @if($adm->status === 'Approved')
                                                <span class="text-xs bg-emerald-50 text-emerald-800 border border-emerald-200 font-semibold px-2.5 py-0.5 rounded-full inline-block">
                                                    Approved
                                                </span>
                                                <div class="text-[11px] font-mono font-bold text-emerald-700 mt-0.5">{{ $adm->assigned_roll }}</div>
                                            @else
                                                <span class="text-xs bg-amber-50 text-amber-800 border border-amber-200 font-semibold px-2.5 py-0.5 rounded-full inline-block">
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-1.5">
                                                <!-- Review / Edit Modal Button -->
                                                <button 
                                                    type="button" 
                                                    @click="openEditAdmission({{ json_encode($adm) }})" 
                                                    class="p-2 rounded-lg text-blue-600 hover:text-blue-800 hover:bg-blue-50 transition" 
                                                    title="Review & Edit Application"
                                                >
                                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                                </button>

                                                @if($adm->status !== 'Approved')
                                                    <form action="{{ route('admin.admissions.status', $adm->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="status" value="Approved">
                                                        <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition shadow-2xs" title="Approve & Generate Roll">
                                                            Approve
                                                        </button>
                                                    </form>
                                                @endif
                                                <button 
                                                    type="button" 
                                                    @click="openDeleteModal('{{ route('admin.admissions.delete', $adm->id) }}', '{{ addslashes($adm->full_name) }} (Trade: {{ addslashes($adm->trade) }})', 'Admission Application')" 
                                                    class="p-2 rounded-lg text-rose-500 hover:text-rose-700 hover:bg-rose-50 transition" 
                                                    title="Delete Application"
                                                >
                                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-slate-400 text-xs">No trainee applications submitted yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ==========================================
                 TAB 5: CONTACT INQUIRIES
                 ========================================== -->
            <div x-show="activeTab === 'inquiries'" class="space-y-4">
                <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-2xs flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Public Contact Messages & Inquiries</h3>
                        <p class="text-xs text-slate-500">Messages and inquiries sent by visitors and trainees through the Contact Us form.</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
                    <div class="overflow-x-auto w-full overscroll-x-contain pb-1">
                        <table class="w-full min-w-[700px] text-left text-sm">
                            <thead class="bg-slate-50 text-slate-500 font-semibold uppercase text-xs border-b border-slate-200/80">
                                <tr>
                                    <th class="py-3.5 px-4 min-w-[200px] whitespace-nowrap">Sender & Contact</th>
                                    <th class="py-3.5 px-4 min-w-[260px] whitespace-nowrap">Subject & Message</th>
                                    <th class="py-3.5 px-4 text-center whitespace-nowrap">Status</th>
                                    <th class="py-3.5 px-4 text-right whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium">
                                @forelse($inquiries as $inq)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="py-3.5 px-4 min-w-[200px]">
                                            <div class="font-bold text-slate-800 text-sm sm:text-base">{{ $inq->name }}</div>
                                            <div class="text-xs text-slate-500">{{ $inq->email }} • <span class="font-mono">{{ $inq->phone }}</span></div>
                                        </td>
                                        <td class="py-3.5 px-4 min-w-[260px] max-w-md">
                                            <div class="font-semibold text-slate-800 text-xs sm:text-sm">{{ $inq->subject }}</div>
                                            <div class="text-xs text-slate-500 line-clamp-2 mt-0.5">{{ $inq->message }}</div>
                                        </td>
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                            <span class="text-xs px-2.5 py-0.5 rounded-full font-semibold {{ $inq->status === 'Replied' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-blue-50 text-blue-800 border border-blue-200' }}">
                                                {{ $inq->status }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-1.5">
                                                @if($inq->status !== 'Replied')
                                                    <form action="{{ route('admin.inquiries.status', $inq->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="status" value="Replied">
                                                        <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition" title="Mark as Replied">
                                                            Mark Replied
                                                        </button>
                                                    </form>
                                                @endif
                                                <button 
                                                    type="button" 
                                                    @click="openDeleteModal('{{ route('admin.inquiries.delete', $inq->id) }}', 'Inquiry from {{ addslashes($inq->name) }} ({{ addslashes($inq->subject) }})', 'Contact Message')" 
                                                    class="p-2 rounded-lg text-rose-500 hover:text-rose-700 hover:bg-rose-50 transition" 
                                                    title="Delete Message"
                                                >
                                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-slate-400 text-xs">No contact messages received yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ==========================================
                 TAB 6: RESOURCES & DOWNLOADS (FULL CRUD & EDIT)
                 ========================================== -->
            <div x-show="activeTab === 'resources'" class="space-y-4">
                <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-2xs flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Academic Resources & Downloadable Files</h3>
                        <p class="text-xs text-slate-500">Upload and organize syllabus documents, admission circulars, and class routines for download.</p>
                    </div>
                    <button type="button" @click="isResourceModalOpen = true" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm flex items-center justify-center gap-1.5 transition shadow-xs">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Upload Document</span>
                    </button>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
                    <div class="overflow-x-auto w-full overscroll-x-contain pb-1">
                        <table class="w-full min-w-[650px] text-left text-sm">
                            <thead class="bg-slate-50 text-slate-500 font-semibold uppercase text-xs border-b border-slate-200/80">
                                <tr>
                                    <th class="py-3.5 px-4 min-w-[240px] whitespace-nowrap">Title & Category</th>
                                    <th class="py-3.5 px-4 whitespace-nowrap">File Type</th>
                                    <th class="py-3.5 px-4 whitespace-nowrap">File Size</th>
                                    <th class="py-3.5 px-4 text-right whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium">
                                @forelse($resources as $res)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="py-3.5 px-4 min-w-[240px]">
                                            <div class="font-bold text-slate-800 text-sm sm:text-base">{{ $res->title }}</div>
                                            <div class="text-xs text-slate-500">{{ $res->category }}</div>
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <span class="text-xs font-semibold px-2.5 py-0.5 rounded-md bg-slate-100 text-slate-700 uppercase font-mono">
                                                {{ $res->file_type }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-xs font-mono text-slate-600 whitespace-nowrap">
                                            {{ $res->file_size }}
                                        </td>
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-1.5">
                                                <!-- Edit Resource Button -->
                                                <button 
                                                    type="button" 
                                                    @click="openEditResource({{ json_encode($res) }})" 
                                                    class="p-2 rounded-lg text-blue-600 hover:text-blue-800 hover:bg-blue-50 transition" 
                                                    title="Edit Resource"
                                                >
                                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                                </button>

                                                <a href="{{ $res->download_url }}" target="_blank" class="p-2 rounded-lg text-emerald-600 hover:bg-emerald-50 transition" title="Download">
                                                    <i class="fa-solid fa-download text-xs"></i>
                                                </a>

                                                <button 
                                                    type="button" 
                                                    @click="openDeleteModal('{{ route('admin.resources.delete', $res->id) }}', '{{ addslashes($res->title) }}', 'Academic Resource File')" 
                                                    class="p-2 rounded-lg text-rose-500 hover:text-rose-700 hover:bg-rose-50 transition" 
                                                    title="Delete Resource"
                                                >
                                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-slate-400 text-xs">No resources uploaded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ==========================================
                 TAB 7: PHOTO GALLERY (FULL CRUD & EDIT)
                 ========================================== -->
            <div x-show="activeTab === 'gallery'" class="space-y-4">
                <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-2xs flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Campus Photo Gallery</h3>
                        <p class="text-xs text-slate-500">Upload and manage campus photographs showcased in the public photo gallery.</p>
                    </div>
                    <button type="button" @click="isGalleryModalOpen = true" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm flex items-center justify-center gap-1.5 transition shadow-xs">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Add Gallery Photo</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3.5 sm:gap-4">
                    @forelse($gallery as $img)
                        <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/90 shadow-2xs group relative flex flex-col justify-between">
                            <div class="relative h-40 w-full overflow-hidden bg-slate-100">
                                <img src="{{ $img->image_url }}" alt="{{ $img->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute top-2 left-2">
                                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-slate-900/80 text-white backdrop-blur-xs">
                                        {{ $img->category }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-3 flex items-start justify-between gap-2">
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-xs font-bold text-slate-800 truncate" title="{{ $img->title }}">{{ $img->title }}</h4>
                                    @if($img->description || $img->caption)
                                        <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5" title="{{ $img->description ?? $img->caption }}">{{ $img->description ?? $img->caption }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center gap-1 shrink-0 pt-0.5">
                                    <!-- Edit Photo Button -->
                                    <button 
                                        type="button" 
                                        @click="openEditGallery({{ json_encode($img) }})" 
                                        class="p-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition" 
                                        title="Edit Photo"
                                    >
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </button>

                                    <button 
                                        type="button" 
                                        @click="openDeleteModal('{{ route('admin.gallery.delete', $img->id) }}', '{{ addslashes($img->title) }}', 'Gallery Photo')" 
                                        class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition shrink-0" 
                                        title="Delete Image"
                                    >
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-8 text-center text-slate-400 text-xs">No gallery photos added yet.</div>
                    @endforelse
                </div>
            </div>

            <!-- ==========================================
                 TAB 7.5: TESTIMONIALS (STUDENT SUCCESS STORIES)
                 ========================================== -->
            <div x-show="activeTab === 'testimonials'" class="space-y-4">
                <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Student Testimonials & Alumni Success</h3>
                        <p class="text-xs text-slate-500">Manage verified student reviews displayed on the public homepage. Add, edit ratings, photos, and quotes.</p>
                    </div>
                    <button 
                        type="button" 
                        @click="isTestimonialModalOpen = true" 
                        class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs sm:text-sm transition flex items-center justify-center gap-2 shadow-xs shrink-0"
                    >
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Add New Testimonial</span>
                    </button>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-2xs">
                    <div class="overflow-x-auto w-full overscroll-x-contain pb-1">
                        <table class="w-full min-w-[850px] text-left border-collapse text-sm">
                            <thead>
                                <tr class="bg-slate-50/80 border-b border-slate-200/80 text-xs font-bold uppercase tracking-wider text-slate-600">
                                    <th class="py-3.5 px-4 min-w-[200px] whitespace-nowrap">Trainee / Graduate</th>
                                    <th class="py-3.5 px-4 min-w-[180px] whitespace-nowrap">Trade / Course</th>
                                    <th class="py-3.5 px-4 whitespace-nowrap">District & Batch</th>
                                    <th class="py-3.5 px-4 whitespace-nowrap">Rating</th>
                                    <th class="py-3.5 px-4 min-w-[220px] whitespace-nowrap">Student Feedback Quote</th>
                                    <th class="py-3.5 px-4 text-right whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                                @forelse($testimonials as $testi)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="py-3.5 px-4 min-w-[200px]">
                                            <div class="flex items-center gap-3">
                                                @if(!empty($testi->avatar))
                                                    <div class="w-10 h-10 rounded-full overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                                                        <img src="{{ $testi->avatar }}" alt="{{ $testi->name }}" class="w-full h-full object-cover object-top">
                                                    </div>
                                                @else
                                                    <div class="w-10 h-10 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold text-xs flex items-center justify-center shrink-0">
                                                        {{ strtoupper(\Illuminate\Support\Str::substr(preg_replace('/\s+/', '', $testi->name ?: 'AL'), 0, 2)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <span class="font-bold text-slate-900 block leading-tight">{{ $testi->name }}</span>
                                                    <span class="text-[11px] text-emerald-700 font-semibold flex items-center gap-1">
                                                        <i class="fa-solid fa-circle-check text-[10px]"></i> Verified Alumni
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 font-semibold text-slate-800 text-xs min-w-[180px]">
                                            {{ $testi->course }}
                                        </td>
                                        <td class="py-3.5 px-4 text-xs text-slate-500 whitespace-nowrap">
                                            <div>{{ $testi->district ?? 'N/A' }}</div>
                                            <div class="text-[11px] text-slate-400 font-mono">{{ $testi->batch ?? 'Batch 2026' }}</div>
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <div class="flex items-center text-amber-400 text-xs">
                                                @for($i = 0; $i < ($testi->rating ?? 5); $i++)
                                                    <i class="fa-solid fa-star"></i>
                                                @endfor
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 text-xs text-slate-600 min-w-[220px] max-w-xs truncate" title="{{ $testi->quote }}">
                                            &ldquo;{{ $testi->quote }}&rdquo;
                                        </td>
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-1.5">
                                                <!-- Edit Testimonial -->
                                                <button 
                                                    type="button" 
                                                    @click="openEditTestimonial({{ json_encode($testi) }})" 
                                                    class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-xl transition" 
                                                    title="Edit Testimonial"
                                                >
                                                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                                                </button>

                                                <!-- Delete Testimonial (Custom Modal Trigger) -->
                                                <button 
                                                    type="button" 
                                                    @click="openDeleteModal('{{ route('admin.testimonials.delete', $testi->id) }}', '{{ addslashes($testi->name) }} ({{ addslashes($testi->course) }})', 'Student Testimonial')" 
                                                    class="p-2 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-xl transition" 
                                                    title="Delete Testimonial"
                                                >
                                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-10 text-center text-slate-400 text-xs">
                                            No student testimonials found. Click "+ Add New Testimonial" above to create one.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ==========================================
                 TAB 8: SITE SETTINGS & A-Z CONTENT CMS
                 ========================================== -->
            <div x-show="activeTab === 'settings'" class="space-y-5">
                
                <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[11px] sm:text-xs font-bold uppercase tracking-wider whitespace-nowrap shrink-0">A-Z Full CMS</span>
                            <h3 class="text-base sm:text-lg font-bold text-slate-800 leading-snug">Website Content Management System</h3>
                        </div>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Live edit every single word, header logo, opening/closing status, social links, hero backgrounds, and footer details.</p>
                    </div>

                    <a 
                        href="{{ route('home') }}" 
                        target="_blank" 
                        class="w-full sm:w-auto px-4 py-2.5 sm:py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold flex items-center justify-center gap-2 transition shrink-0"
                    >
                        <i class="fa-solid fa-arrow-up-right-from-square text-emerald-600"></i>
                        <span>View Live Public Site</span>
                    </a>
                </div>

                <!-- Page-by-Page CMS Tab Navigation Bar -->
                <div class="bg-white p-1.5 sm:p-2 rounded-2xl border border-slate-200/90 shadow-2xs">
                    <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar py-0.5 text-xs sm:text-sm font-semibold overscroll-x-contain">
                        <button 
                            type="button" 
                            @click="cmsTab = 'home'" 
                            :class="cmsTab === 'home' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-transparent text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                            class="px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl transition flex items-center gap-2 shrink-0 whitespace-nowrap font-bold"
                        >
                            <i class="fa-solid fa-house text-xs"></i>
                            <span>Home Page</span>
                        </button>

                        <button 
                            type="button" 
                            @click="cmsTab = 'courses'" 
                            :class="cmsTab === 'courses' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-transparent text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                            class="px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl transition flex items-center gap-2 shrink-0 whitespace-nowrap font-bold"
                        >
                            <i class="fa-solid fa-graduation-cap text-xs"></i>
                            <span>Courses Page</span>
                        </button>

                        <button 
                            type="button" 
                            @click="cmsTab = 'results'" 
                            :class="cmsTab === 'results' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-transparent text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                            class="px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl transition flex items-center gap-2 shrink-0 whitespace-nowrap font-bold"
                        >
                            <i class="fa-solid fa-file-circle-check text-xs"></i>
                            <span>Results Page</span>
                        </button>

                        <button 
                            type="button" 
                            @click="cmsTab = 'gallery'" 
                            :class="cmsTab === 'gallery' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-transparent text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                            class="px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl transition flex items-center gap-2 shrink-0 whitespace-nowrap font-bold"
                        >
                            <i class="fa-solid fa-images text-xs"></i>
                            <span>Gallery Page</span>
                        </button>

                        <button 
                            type="button" 
                            @click="cmsTab = 'resources'" 
                            :class="cmsTab === 'resources' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-transparent text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                            class="px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl transition flex items-center gap-2 shrink-0 whitespace-nowrap font-bold"
                        >
                            <i class="fa-solid fa-folder-open text-xs"></i>
                            <span>Resources Page</span>
                        </button>

                        <button 
                            type="button" 
                            @click="cmsTab = 'contact'" 
                            :class="cmsTab === 'contact' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-transparent text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                            class="px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl transition flex items-center gap-2 shrink-0 whitespace-nowrap font-bold"
                        >
                            <i class="fa-solid fa-envelope text-xs"></i>
                            <span>Contact Page</span>
                        </button>

                        <button 
                            type="button" 
                            @click="cmsTab = 'global'" 
                            :class="cmsTab === 'global' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-transparent text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                            class="px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl transition flex items-center gap-2 shrink-0 whitespace-nowrap font-bold"
                        >
                            <i class="fa-solid fa-sliders text-xs"></i>
                            <span>Header, Footer & Global</span>
                        </button>
                    </div>
                </div>

                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4 sm:space-y-5">
                    @csrf
                    <input type="hidden" name="current_cms_tab" :value="cmsTab">

                    <!-- ====================================================
                         SUB-TAB: HOME PAGE CMS
                         ==================================================== -->
                    <div x-show="cmsTab === 'home'" class="space-y-4 sm:space-y-5">
                        
                        <!-- SECTION 0: Dynamic Hero Slider Slides (Unlimited Slides) -->
                        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-slate-200/90 shadow-2xs space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-2 text-slate-800 font-bold text-sm">
                                        <i class="fa-solid fa-images text-emerald-600 shrink-0"></i>
                                        <span>Hero Carousel Slider Management</span>
                                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200 whitespace-nowrap shrink-0">
                                            {{ $heroSlides->count() }} Slides
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-0.5">Manage slides, background images, titles, subtitles, and CTA buttons on homepage carousel.</p>
                                </div>
                                <button 
                                    type="button" 
                                    @click="isHeroSlideModalOpen = true" 
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 sm:py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition shrink-0"
                                >
                                    <i class="fa-solid fa-plus text-xs"></i>
                                    <span>Add New Slide</span>
                                </button>
                            </div>

                            <!-- Slides List Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @forelse($heroSlides as $slide)
                                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-emerald-300 transition-all duration-200 space-y-3 flex flex-col justify-between">
                                        <div>
                                            <!-- Top Image & Status -->
                                            <div class="relative h-32 w-full rounded-lg overflow-hidden bg-slate-900 mb-3 border border-slate-200">
                                                <img src="{{ $slide->bg_image }}" alt="{{ $slide->title }}" class="w-full h-full object-cover">
                                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>
                                                <div class="absolute top-2 left-2 flex items-center gap-1.5">
                                                    <span class="px-2 py-0.5 rounded-md bg-slate-950/80 text-white text-[10px] font-bold">
                                                        Slide #{{ $slide->order ?? 1 }}
                                                    </span>
                                                    @if($slide->is_active)
                                                        <span class="px-2 py-0.5 rounded-md bg-emerald-500 text-slate-950 text-[10px] font-bold">Active</span>
                                                    @else
                                                        <span class="px-2 py-0.5 rounded-md bg-slate-600 text-white text-[10px] font-bold">Inactive</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="space-y-1">
                                                <div class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider">{{ $slide->badge }}</div>
                                                <h4 class="text-sm font-bold text-slate-900 leading-snug line-clamp-1">{{ $slide->title }}</h4>
                                                <p class="text-xs text-slate-500 line-clamp-2">{{ $slide->subtitle }}</p>
                                            </div>

                                            <div class="flex flex-wrap items-center gap-2 pt-2 text-[11px] text-slate-500 font-medium">
                                                <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200"><i class="fa-regular fa-clock text-emerald-600 mr-1"></i>{{ $slide->duration }}</span>
                                                <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200"><i class="fa-solid fa-award text-amber-500 mr-1"></i>{{ $slide->highlight }}</span>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="pt-2 border-t border-slate-100 flex items-center justify-between">
                                            <span class="text-[11px] text-slate-400">Btn: {{ $slide->btn1_text }}</span>
                                            <div class="flex items-center gap-1.5">
                                                <button 
                                                    type="button" 
                                                    @click="openEditHeroSlide({{ json_encode($slide) }})" 
                                                    class="p-1.5 rounded-lg text-blue-600 hover:bg-blue-50 text-xs font-semibold"
                                                    title="Edit Slide"
                                                >
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <button 
                                                    type="button" 
                                                    @click="openDeleteModal('/admin/hero-slides/{{ $slide->id }}/delete', '{{ addslashes($slide->title) }}', 'Hero Slide')" 
                                                    class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 text-xs font-semibold"
                                                    title="Delete Slide"
                                                >
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-span-full text-center py-8 text-xs text-slate-400">
                                        No slides added yet. Click "+ Add New Slide" to add your first hero carousel slide.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <!-- SECTION 3: Hero Section Content & Background Image -->
                        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-slate-200/90 shadow-2xs space-y-4">
                            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 text-slate-800 font-bold text-sm">
                                <i class="fa-solid fa-wand-magic-sparkles text-emerald-600 shrink-0"></i>
                                <span>Homepage Hero Section Content & Background Image</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 text-xs font-semibold text-slate-700">
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Hero Badge Tag *</label>
                                    <input type="text" name="heroBadge" value="{{ $settings['heroBadge'] ?? '' }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Duration Tag *</label>
                                    <input type="text" name="heroDuration" value="{{ $settings['heroDuration'] ?? '' }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Highlight Badge *</label>
                                    <input type="text" name="heroHighlight" value="{{ $settings['heroHighlight'] ?? '' }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>

                            <div class="text-xs font-semibold text-slate-700">
                                <label class="block uppercase tracking-wider mb-1">Hero Main Title Headline *</label>
                                <input type="text" name="heroTitle" value="{{ $settings['heroTitle'] ?? '' }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-emerald-500">
                            </div>

                            <div class="text-xs font-semibold text-slate-700">
                                <label class="block uppercase tracking-wider mb-1">Hero Subtitle Paragraph *</label>
                                <textarea name="heroSubtitle" rows="2" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">{{ $settings['heroSubtitle'] ?? '' }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 text-xs font-semibold text-slate-700">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                    <div>
                                        <label class="block uppercase tracking-wider mb-1">Button 1 Text</label>
                                        <input type="text" name="heroPrimaryBtnText" value="{{ $settings['heroPrimaryBtnText'] ?? 'Explore Programs' }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                                    </div>
                                    <div>
                                        <label class="block uppercase tracking-wider mb-1">Button 1 Link</label>
                                        <input type="text" name="heroPrimaryBtnLink" value="{{ $settings['heroPrimaryBtnLink'] ?? '/courses' }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono text-xs focus:ring-2 focus:ring-emerald-500">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                    <div>
                                        <label class="block uppercase tracking-wider mb-1">Button 2 Text</label>
                                        <input type="text" name="heroSecondaryBtnText" value="{{ $settings['heroSecondaryBtnText'] ?? 'Apply for Admission' }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                                    </div>
                                    <div>
                                        <label class="block uppercase tracking-wider mb-1">Button 2 Link</label>
                                        <input type="text" name="heroSecondaryBtnLink" value="{{ $settings['heroSecondaryBtnLink'] ?? '/register' }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono text-xs focus:ring-2 focus:ring-emerald-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Hero Background Photo Upload -->
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 space-y-3">
                                <div class="text-xs font-bold text-slate-800 uppercase tracking-wider">Hero Background Wallpaper Image</div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-center">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">Upload Local Image File</label>
                                        <input type="file" name="hero_bg_image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">Or Direct Image URL</label>
                                        <input type="text" name="heroBgImage" value="{{ $settings['heroBgImage'] ?? '' }}" placeholder="https://..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono text-xs focus:ring-2 focus:ring-emerald-500">
                                    </div>
                                </div>
                                @if(!empty($settings['heroBgImage']))
                                    <div class="flex flex-wrap items-center gap-3 pt-1">
                                        <span class="text-[11px] text-slate-400">Current Hero Background Preview:</span>
                                        <img src="{{ $settings['heroBgImage'] }}" alt="Hero Background Preview" class="h-10 w-24 object-cover rounded-lg border border-slate-300">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- SECTION 4: 4 Impact Stats Cards & Bottom Platform Badge -->
                        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-slate-200/90 shadow-2xs space-y-4">
                            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 text-slate-800 font-bold text-sm">
                                <i class="fa-solid fa-chart-pie text-emerald-600 shrink-0"></i>
                                <span>Impact Metrics Counters (4 Cards below Hero)</span>
                            </div>

                            <!-- Card 1 -->
                            <div class="p-3 sm:p-3.5 rounded-xl bg-emerald-50/40 border border-emerald-100 space-y-2.5">
                                <span class="text-xs font-bold text-emerald-800 block">Stat Card 1 (Trainees Counter)</span>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 text-xs font-semibold text-slate-700">
                                    <div>
                                        <label class="block mb-1">Number</label>
                                        <input type="text" name="stat1Number" value="{{ $settings['stat1Number'] ?? '1,500+' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Title</label>
                                        <input type="text" name="stat1Title" value="{{ $settings['stat1Title'] ?? 'Certified Trainees' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Subtext</label>
                                        <input type="text" name="stat1Subtext" value="{{ $settings['stat1Subtext'] ?? 'Govt-recognized technical and ICT graduates' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Top Badge</label>
                                        <input type="text" name="stat1Badge" value="{{ $settings['stat1Badge'] ?? 'Verified Diplomas' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2 -->
                            <div class="p-3 sm:p-3.5 rounded-xl bg-blue-50/40 border border-blue-100 space-y-2.5">
                                <span class="text-xs font-bold text-blue-800 block">Stat Card 2 (Courses Counter)</span>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 text-xs font-semibold text-slate-700">
                                    <div>
                                        <label class="block mb-1">Number</label>
                                        <input type="text" name="stat2Number" value="{{ $settings['stat2Number'] ?? '150+' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Title</label>
                                        <input type="text" name="stat2Title" value="{{ $settings['stat2Title'] ?? 'Industry Courses' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Subtext</label>
                                        <input type="text" name="stat2Subtext" value="{{ $settings['stat2Subtext'] ?? 'Hands-on trades, engineering & digital programs' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Top Badge</label>
                                        <input type="text" name="stat2Badge" value="{{ $settings['stat2Badge'] ?? 'Practical Syllabus' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3 -->
                            <div class="p-3 sm:p-3.5 rounded-xl bg-purple-50/40 border border-purple-100 space-y-2.5">
                                <span class="text-xs font-bold text-purple-800 block">Stat Card 3 (Branches Counter)</span>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 text-xs font-semibold text-slate-700">
                                    <div>
                                        <label class="block mb-1">Number</label>
                                        <input type="text" name="stat3Number" value="{{ $settings['stat3Number'] ?? '64+' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Title</label>
                                        <input type="text" name="stat3Title" value="{{ $settings['stat3Title'] ?? 'Regional Branches' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Subtext</label>
                                        <input type="text" name="stat3Subtext" value="{{ $settings['stat3Subtext'] ?? 'Accredited training centers nationwide' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Top Badge</label>
                                        <input type="text" name="stat3Badge" value="{{ $settings['stat3Badge'] ?? 'Across Bangladesh' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                </div>
                            </div>

                            <!-- Card 4 -->
                            <div class="p-3 sm:p-3.5 rounded-xl bg-amber-50/40 border border-amber-100 space-y-2.5">
                                <span class="text-xs font-bold text-amber-800 block">Stat Card 4 (Employment Rate)</span>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 text-xs font-semibold text-slate-700">
                                    <div>
                                        <label class="block mb-1">Number</label>
                                        <input type="text" name="stat4Number" value="{{ $settings['stat4Number'] ?? '94.2%' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Title</label>
                                        <input type="text" name="stat4Title" value="{{ $settings['stat4Title'] ?? 'Employment Rate' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Subtext</label>
                                        <input type="text" name="stat4Subtext" value="{{ $settings['stat4Subtext'] ?? 'Active placement and startup support for youth' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Top Badge</label>
                                        <input type="text" name="stat4Badge" value="{{ $settings['stat4Badge'] ?? 'Self-Reliance' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                </div>
                            </div>

                            <div class="text-xs font-semibold text-slate-700">
                                <label class="block uppercase tracking-wider mb-1">Bottom Centered Platform Badge Pill</label>
                                <input type="text" name="statBottomBadge" value="{{ $settings['statBottomBadge'] ?? 'National Youth Development Platform' }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                            </div>
                        </div>

                        <!-- SECTION 5: About Section & 3 Core Highlights -->
                        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-slate-200/90 shadow-2xs space-y-4">
                            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 text-slate-800 font-bold text-sm">
                                <i class="fa-solid fa-circle-info text-emerald-600"></i>
                                <span>About Directorate Section & 3 Core Highlights</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-semibold text-slate-700">
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Section Badge Tag *</label>
                                    <input type="text" name="aboutBadge" value="{{ $settings['aboutBadge'] ?? '' }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Main Heading Title *</label>
                                    <input type="text" name="aboutTitle" value="{{ $settings['aboutTitle'] ?? '' }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-bold focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>

                            <div class="text-xs font-semibold text-slate-700">
                                <label class="block uppercase tracking-wider mb-1">About Long Description *</label>
                                <textarea name="aboutDescription" rows="3" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">{{ $settings['aboutDescription'] ?? '' }}</textarea>
                            </div>

                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 space-y-3">
                                <div class="text-xs font-bold text-slate-800 uppercase tracking-wider">About Section Visual Photo</div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-center">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">Upload New Photo File</label>
                                        <input type="file" name="about_image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">Or Photo URL</label>
                                        <input type="text" name="aboutImage" value="{{ $settings['aboutImage'] ?? '' }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono text-xs focus:ring-2 focus:ring-emerald-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Floating Experience Badge on Image -->
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2">
                                <div class="text-xs font-bold text-slate-800 uppercase tracking-wider">Top-Right Floating Experience Badge (Over Image)</div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs font-semibold text-slate-700">
                                    <div>
                                        <label class="block mb-1">Metric Number</label>
                                        <input type="text" name="aboutExpNumber" value="{{ $settings['aboutExpNumber'] ?? '15+' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 font-bold focus:ring-2 focus:ring-emerald-500">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Badge Title</label>
                                        <input type="text" name="aboutExpBadge" value="{{ $settings['aboutExpBadge'] ?? 'Years of Excellence' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Badge Subtext</label>
                                        <input type="text" name="aboutExpSub" value="{{ $settings['aboutExpSub'] ?? 'Technical Education' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                                    </div>
                                </div>
                            </div>

                            <!-- 3 Pillars (Matching Image 4) -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs font-semibold text-slate-700">
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2">
                                    <span class="font-bold text-slate-800 block">Feature Card 1 (Shield)</span>
                                    <input type="text" name="aboutPillar1Title" value="{{ $settings['aboutPillar1Title'] ?? 'Government-Accredited Curriculum' }}" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-300 text-xs font-bold">
                                    <textarea name="aboutPillar1Desc" rows="2" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-300 text-xs">{{ $settings['aboutPillar1Desc'] ?? 'Nationally recognized diplomas and certificates valid for civil service, private sector, and overseas jobs.' }}</textarea>
                                </div>
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2">
                                    <span class="font-bold text-slate-800 block">Feature Card 2 (Lab)</span>
                                    <input type="text" name="aboutPillar2Title" value="{{ $settings['aboutPillar2Title'] ?? '80% Practical Lab Workshops' }}" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-300 text-xs font-bold">
                                    <textarea name="aboutPillar2Desc" rows="2" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-300 text-xs">{{ $settings['aboutPillar2Desc'] ?? 'Real-world training in modern computer labs, electrical workshops, and industrial engineering suites.' }}</textarea>
                                </div>
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2">
                                    <span class="font-bold text-slate-800 block">Feature Card 3 (Career)</span>
                                    <input type="text" name="aboutPillar3Title" value="{{ $settings['aboutPillar3Title'] ?? 'Career Placement & Youth Loan Linkage' }}" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-300 text-xs font-bold">
                                    <textarea name="aboutPillar3Desc" rows="2" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-300 text-xs">{{ $settings['aboutPillar3Desc'] ?? 'Direct internship opportunities, freelance mentorship, and easy-term youth entrepreneurship loan guidance.' }}</textarea>
                                </div>
                            </div>

                            <!-- Bottom Row Settings -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs font-semibold text-slate-700">
                                <div>
                                    <label class="block mb-1">Bottom Left Accreditation Tag</label>
                                    <input type="text" name="aboutFooterLeft" value="{{ $settings['aboutFooterLeft'] ?? 'Registered Institute • Government Affiliated' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                                </div>
                                <div>
                                    <label class="block mb-1">Bottom Right CTA Text</label>
                                    <input type="text" name="aboutFooterRightText" value="{{ $settings['aboutFooterRightText'] ?? 'Explore All Trade Programs' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                                </div>
                                <div>
                                    <label class="block mb-1">Bottom Right CTA Link</label>
                                    <input type="text" name="aboutFooterRightLink" value="{{ $settings['aboutFooterRightLink'] ?? '/courses' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 font-mono text-xs">
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 6: Chairman's Speech Section & Photo -->
                        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-slate-200/90 shadow-2xs space-y-4">
                            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 text-slate-800 font-bold text-sm">
                                <i class="fa-solid fa-user-tie text-emerald-600"></i>
                                <span>Chairman's Speech Section & Executive Portrait</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs font-semibold text-slate-700">
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Chairman Full Name *</label>
                                    <input type="text" name="chairmanName" value="{{ $settings['chairmanName'] ?? 'Shariyat Ullah Saikat' }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-bold focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Official Designation *</label>
                                    <input type="text" name="chairmanDesignation" value="{{ $settings['chairmanDesignation'] ?? 'Chairman & Academic Director' }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Organization *</label>
                                    <input type="text" name="chairmanOrg" value="{{ $settings['chairmanOrg'] ?? 'Saikat Computer & Training Jubo Songhoton' }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs font-semibold text-slate-700">
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Section Badge Tag</label>
                                    <input type="text" name="chairmanBadge" value="{{ $settings['chairmanBadge'] ?? 'Executive Leadership & Academic Vision' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block uppercase tracking-wider mb-1">Section Title</label>
                                    <input type="text" name="chairmanTitle" value="{{ $settings['chairmanTitle'] ?? "Chairman's Speech" }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-bold focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>

                            <div class="text-xs font-semibold text-slate-700">
                                <label class="block uppercase tracking-wider mb-1">Speech Quotation Paragraph 1 *</label>
                                <textarea name="chairmanQuote1" rows="3" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">{{ $settings['chairmanQuote1'] ?? '' }}</textarea>
                            </div>

                            <div class="text-xs font-semibold text-slate-700">
                                <label class="block uppercase tracking-wider mb-1">Speech Quotation Paragraph 2 *</label>
                                <textarea name="chairmanQuote2" rows="2" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">{{ $settings['chairmanQuote2'] ?? '' }}</textarea>
                            </div>

                            <!-- Chairman Portrait Upload -->
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 space-y-3">
                                <div class="text-xs font-bold text-slate-800 uppercase tracking-wider">Chairman Official Portrait Headshot Photo</div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-center">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">Upload Portrait Photo File</label>
                                        <input type="file" name="chairman_image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">Or Photo URL Path</label>
                                        <input type="text" name="chairmanImage" value="{{ $settings['chairmanImage'] ?? '' }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono text-xs focus:ring-2 focus:ring-emerald-500">
                                    </div>
                                </div>
                                @if(!empty($settings['chairmanImage']))
                                    <div class="flex items-center gap-3 pt-1">
                                        <span class="text-[11px] text-slate-400">Current Portrait Preview:</span>
                                        <img src="{{ $settings['chairmanImage'] }}" alt="Chairman Preview" class="h-12 w-10 object-cover object-top rounded-lg border border-slate-300">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- SECTION 7: Homepage Admission / Announcement Popup Modal -->
                        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-slate-200/90 shadow-2xs space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-100">
                                <div class="flex items-center gap-2.5 text-slate-800 font-bold text-sm">
                                    <i class="fa-solid fa-window-restore text-emerald-600 shrink-0"></i>
                                    <span>Homepage Admission / Announcement Popup Modal System</span>
                                </div>
                                <label class="flex items-center gap-2 cursor-pointer shrink-0">
                                    <input type="checkbox" name="popupEnabled" value="1" {{ !empty($settings['popupEnabled']) ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded">
                                    <span class="text-xs font-bold text-slate-700">Enable Popup on Homepage</span>
                                </label>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs font-semibold text-slate-700">
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Popup Title</label>
                                    <input type="text" name="popupTitle" value="{{ $settings['popupTitle'] ?? 'Admissions Open - Batch 2026' }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Popup Badge Tag</label>
                                    <input type="text" name="popupBadge" value="{{ $settings['popupBadge'] ?? 'Limited Seats Available' }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>

                            <div class="text-xs font-semibold text-slate-700">
                                <label class="block uppercase tracking-wider mb-1">Popup Message Description</label>
                                <textarea name="popupMessage" rows="2" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">{{ $settings['popupMessage'] ?? '' }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-center">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Upload Popup Banner Image File</label>
                                    <input type="file" name="popup_image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Or Popup Image URL</label>
                                    <input type="text" name="popupImage" value="{{ $settings['popupImage'] ?? '' }}" placeholder="https://..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm font-mono focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs font-semibold text-slate-700">
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Action Button Text</label>
                                    <input type="text" name="popupButtonText" value="{{ $settings['popupButtonText'] ?? 'Apply For Admission' }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Action Button URL</label>
                                    <input type="text" name="popupButtonUrl" value="{{ $settings['popupButtonUrl'] ?? '/register' }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm font-mono focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ====================================================
                         SUB-TAB: COURSES PAGE CMS
                         ==================================================== -->
                    <div x-show="cmsTab === 'courses'" class="space-y-4 sm:space-y-5">
                        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-slate-200/90 shadow-2xs space-y-4">
                            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 text-slate-800 font-bold text-sm">
                                <i class="fa-solid fa-graduation-cap text-emerald-600 shrink-0"></i>
                                <span>Courses Page Header & Call-to-Action Content</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4 text-xs font-semibold text-slate-700">
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Courses Page Badge Tag</label>
                                    <input type="text" name="coursesPageBadge" value="{{ $settings['coursesPageBadge'] ?? 'Admission Open • Academic Session 2026' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block uppercase tracking-wider mb-1">Courses Page Main Title Headline *</label>
                                    <input type="text" name="coursesPageTitle" value="{{ $settings['coursesPageTitle'] ?? 'Technical & Vocational Training Programs' }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-bold focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>

                            <div class="text-xs font-semibold text-slate-700">
                                <label class="block uppercase tracking-wider mb-1">Courses Page Subtitle Paragraph</label>
                                <textarea name="coursesPageSubtitle" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">{{ $settings['coursesPageSubtitle'] ?? 'Choose from government-subsidized, high-impact certification courses with 100% practical lab workstations, certified instructors, and national employment support.' }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 text-xs font-semibold text-slate-700">
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Popular Search Keywords (Comma Separated)</label>
                                    <input type="text" name="coursesPagePopularKeywords" value="{{ $settings['coursesPagePopularKeywords'] ?? 'Graphic Design, Electrical, RAC Servicing, Welding, Tailoring' }}" placeholder="e.g. Graphic Design, Electrical, RAC..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Courses Hero Background Image URL</label>
                                    <input type="text" name="coursesPageHeroBg" value="{{ $settings['coursesPageHeroBg'] ?? 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=2000&auto=format&fit=crop' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>

                            <div class="text-xs font-semibold text-slate-700">
                                <label class="block uppercase tracking-wider mb-1">Or Upload Hero Background Image from Device</label>
                                <input type="file" name="courses_hero_bg_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                            </div>

                            <div class="pt-4 border-t border-slate-100 space-y-3">
                                <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Bottom Call-to-Action (CTA) Counseling Banner</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 text-xs font-semibold text-slate-700">
                                    <div>
                                        <label class="block uppercase tracking-wider mb-1">Banner Title</label>
                                        <input type="text" name="coursesPageCtaTitle" value="{{ $settings['coursesPageCtaTitle'] ?? 'Not Sure Which Technical Program Fits Your Career?' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-bold focus:ring-2 focus:ring-emerald-500">
                                    </div>
                                    <div>
                                        <label class="block uppercase tracking-wider mb-1">Counseling Helpline Hotline</label>
                                        <input type="text" name="coursesPageHelplinePhone" value="{{ $settings['coursesPageHelplinePhone'] ?? '+880 1700-000000' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                    </div>
                                </div>
                                <div class="text-xs font-semibold text-slate-700">
                                    <label class="block uppercase tracking-wider mb-1">Banner Subtitle Description</label>
                                    <input type="text" name="coursesPageCtaSubtitle" value="{{ $settings['coursesPageCtaSubtitle'] ?? 'Speak directly with our regional academic advisors to learn about trade prospects, government loan opportunities for graduates, and practical lab schedules in your district.' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ====================================================
                         SUB-TAB: RESULTS PAGE CMS
                         ==================================================== -->
                    <div x-show="cmsTab === 'results'" class="space-y-4 sm:space-y-5">
                        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-slate-200/90 shadow-2xs space-y-4">
                            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 text-slate-800 font-bold text-sm">
                                <i class="fa-solid fa-file-circle-check text-emerald-600 shrink-0"></i>
                                <span>Results Page Header & Verification Helpdesk Content</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4 text-xs font-semibold text-slate-700">
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Results Page Badge Tag</label>
                                    <input type="text" name="resultsPageBadge" value="{{ $settings['resultsPageBadge'] ?? 'Official Central Registry & Transcript Verification' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block uppercase tracking-wider mb-1">Results Page Main Title Headline *</label>
                                    <input type="text" name="resultsPageTitle" value="{{ $settings['resultsPageTitle'] ?? 'Exam Result & Transcript Verification' }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-bold focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>

                            <div class="text-xs font-semibold text-slate-700">
                                <label class="block uppercase tracking-wider mb-1">Results Page Subtitle Paragraph</label>
                                <textarea name="resultsPageSubtitle" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">{{ $settings['resultsPageSubtitle'] ?? 'Instantly verify official transcripts, marksheets, and accredited certifications issued across all 64 district branches nationwide.' }}</textarea>
                            </div>

                            <div class="pt-4 border-t border-slate-100 grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 text-xs font-semibold text-slate-700">
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Instructions Card Title</label>
                                    <input type="text" name="resultsInstructionTitle" value="{{ $settings['resultsInstructionTitle'] ?? 'Instructions for Result Verification' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Helpline Support Note</label>
                                    <input type="text" name="resultsHelplineText" value="{{ $settings['resultsHelplineText'] ?? 'For transcript corrections or missing marksheet inquiries, contact Academic Controller Secretariat.' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>

                            <div class="text-xs font-semibold text-slate-700">
                                <label class="block uppercase tracking-wider mb-1">Instructions Description</label>
                                <textarea name="resultsInstructionText" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">{{ $settings['resultsInstructionText'] ?? 'Enter student roll number or registration number exactly as printed on the admit card or provisional certificate.' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ====================================================
                         SUB-TAB: GALLERY PAGE CMS
                         ==================================================== -->
                    <div x-show="cmsTab === 'gallery'" class="space-y-4 sm:space-y-5">
                        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-slate-200/90 shadow-2xs space-y-4">
                            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 text-slate-800 font-bold text-sm">
                                <i class="fa-solid fa-images text-emerald-600 shrink-0"></i>
                                <span>Campus Photo Gallery Header Content</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4 text-xs font-semibold text-slate-700">
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Gallery Page Badge Tag</label>
                                    <input type="text" name="galleryPageBadge" value="{{ $settings['galleryPageBadge'] ?? 'Campus & Technical Training Gallery' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block uppercase tracking-wider mb-1">Gallery Page Main Title Headline *</label>
                                    <input type="text" name="galleryPageTitle" value="{{ $settings['galleryPageTitle'] ?? 'Visual Glimpses of Vocational Excellence' }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-bold focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>

                            <div class="text-xs font-semibold text-slate-700">
                                <label class="block uppercase tracking-wider mb-1">Gallery Page Subtitle Paragraph</label>
                                <textarea name="galleryPageSubtitle" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">{{ $settings['galleryPageSubtitle'] ?? 'Take a visual tour across our computer labs, industrial automation workshops, heavy fabrication bays, and nationwide youth convocation ceremonies.' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ====================================================
                         SUB-TAB: RESOURCES PAGE CMS
                         ==================================================== -->
                    <div x-show="cmsTab === 'resources'" class="space-y-4 sm:space-y-5">
                        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-slate-200/90 shadow-2xs space-y-4">
                            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 text-slate-800 font-bold text-sm">
                                <i class="fa-solid fa-folder-open text-emerald-600 shrink-0"></i>
                                <span>Academic Resources & Downloads Header Content</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4 text-xs font-semibold text-slate-700">
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Resources Page Badge Tag</label>
                                    <input type="text" name="resourcesPageBadge" value="{{ $settings['resourcesPageBadge'] ?? 'Official Academic & Technical Downloads' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block uppercase tracking-wider mb-1">Resources Page Main Title Headline *</label>
                                    <input type="text" name="resourcesPageTitle" value="{{ $settings['resourcesPageTitle'] ?? 'Official Syllabus, Guidelines & Downloads' }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-bold focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>

                            <div class="text-xs font-semibold text-slate-700">
                                <label class="block uppercase tracking-wider mb-1">Resources Page Subtitle Paragraph</label>
                                <textarea name="resourcesPageSubtitle" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">{{ $settings['resourcesPageSubtitle'] ?? 'Access and download official technical curriculum syllabi, examination routines, offline admission forms, and practical workshop manuals.' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ====================================================
                         SUB-TAB: CONTACT PAGE CMS
                         ==================================================== -->
                    <div x-show="cmsTab === 'contact'" class="space-y-4 sm:space-y-5">
                        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-slate-200/90 shadow-2xs space-y-4">
                            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 text-slate-800 font-bold text-sm">
                                <i class="fa-solid fa-envelope text-emerald-600 shrink-0"></i>
                                <span>Contact Page Header & Office Information</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4 text-xs font-semibold text-slate-700">
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Contact Page Badge Tag</label>
                                    <input type="text" name="contactPageBadge" value="{{ $settings['contactPageBadge'] ?? 'Official Central Directorate & 64 District Network' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block uppercase tracking-wider mb-1">Contact Page Main Title Headline *</label>
                                    <input type="text" name="contactPageTitle" value="{{ $settings['contactPageTitle'] ?? 'Contact Academic Directorate' }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-bold focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>

                            <div class="text-xs font-semibold text-slate-700">
                                <label class="block uppercase tracking-wider mb-1">Contact Page Subtitle Paragraph</label>
                                <textarea name="contactPageSubtitle" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">{{ $settings['contactPageSubtitle'] ?? 'Connect directly with our central secretariat or regional hubs for admission counseling, certificate verification, and affiliation inquiries.' }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 text-xs font-semibold text-slate-700 pt-4 border-t border-slate-100 items-start">
                                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2">
                                    <div class="text-xs font-bold text-slate-800">Active Opening & Closing Hours</div>
                                    <div class="text-xs text-slate-600">
                                        Status: <span class="font-bold {{ ($settings['officeStatus'] ?? 'open') === 'open' ? 'text-emerald-700' : 'text-rose-700' }}">{{ ($settings['officeStatus'] ?? 'open') === 'open' ? ($settings['officeOpenLabel'] ?? 'Open Today') : ($settings['officeClosedLabel'] ?? 'Closed Today') }}</span><br>
                                        Schedule: <span class="font-semibold">{{ $settings['officeWeeklyDays'] ?? 'Sun - Thu (Fri - Sat Closed)' }}</span> • {{ $settings['officeOpeningTime'] ?? '9:00 AM' }} - {{ $settings['officeClosingTime'] ?? '5:00 PM' }}
                                    </div>
                                    <button type="button" @click="cmsTab = 'global'" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 hover:text-emerald-800 hover:underline pt-1">
                                        <span>Edit Open/Closed Status & Time in Header/Footer Tab</span>
                                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                    </button>
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Google Maps Embed URL / Iframe Link</label>
                                    <input type="text" name="contactMapEmbedUrl" value="{{ $settings['contactMapEmbedUrl'] ?? '' }}" placeholder="https://maps.google.com/..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono text-xs focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ====================================================
                         SUB-TAB: HEADER, FOOTER & GLOBAL CMS
                         ==================================================== -->
                    <div x-show="cmsTab === 'global'" class="space-y-4 sm:space-y-5">
                        
                        <!-- SECTION 1: General Institute Identity & Central Contacts -->
                        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-slate-200/90 shadow-2xs space-y-4">
                            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 text-slate-800 font-bold text-sm">
                                <i class="fa-solid fa-building-columns text-emerald-600 shrink-0"></i>
                                <span>General Institute Identity & Central Contacts</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4 text-xs font-semibold text-slate-700">
                                <div class="md:col-span-2">
                                    <label class="block uppercase tracking-wider mb-1">Institute Official Name *</label>
                                    <input type="text" name="instituteName" value="{{ $settings['instituteName'] }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-semibold focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Active Academic Session *</label>
                                    <input type="text" name="currentSession" value="{{ $settings['currentSession'] }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-semibold focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 text-xs font-semibold text-slate-700">
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Central Helpline Phone *</label>
                                    <input type="text" name="helplinePhone" value="{{ $settings['helplinePhone'] }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Support Email Address *</label>
                                    <input type="email" name="helplineEmail" value="{{ $settings['helplineEmail'] }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>

                            <div class="text-xs font-semibold text-slate-700">
                                <label class="block uppercase tracking-wider mb-1">Headquarters Campus Address</label>
                                <input type="text" name="headquartersAddress" value="{{ $settings['headquartersAddress'] ?? '' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                            </div>
                        </div>

                        <!-- SECTION 2: Opening / Closing Status & Office Time (Footer & Contact Page) -->
                        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-slate-200/90 shadow-2xs space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-100">
                                <div class="flex items-center gap-2.5 text-slate-800 font-bold text-sm">
                                    <i class="fa-regular fa-clock text-emerald-600 shrink-0"></i>
                                    <span>Office Opening / Closing Status & Time Schedule</span>
                                </div>
                                <span class="text-[11px] font-semibold text-slate-400">Displayed in Footer & Contact Page</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 text-xs font-semibold text-slate-700">
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Institute Open / Closed Status *</label>
                                    <select name="officeStatus" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-bold focus:ring-2 focus:ring-emerald-500">
                                        <option value="open" {{ ($settings['officeStatus'] ?? 'open') === 'open' ? 'selected' : '' }}>🟢 Open (Active Operations)</option>
                                        <option value="closed" {{ ($settings['officeStatus'] ?? 'open') === 'closed' ? 'selected' : '' }}>🔴 Closed (Off Hours / Holiday)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Open Badge Label</label>
                                    <input type="text" name="officeOpenLabel" value="{{ $settings['officeOpenLabel'] ?? 'Open Today' }}" placeholder="e.g. Open Today" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Closed Badge Label</label>
                                    <input type="text" name="officeClosedLabel" value="{{ $settings['officeClosedLabel'] ?? 'Closed Today' }}" placeholder="e.g. Closed Today" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 text-xs font-semibold text-slate-700">
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Opening Time *</label>
                                    <input type="text" name="officeOpeningTime" value="{{ $settings['officeOpeningTime'] ?? '9:00 AM' }}" placeholder="e.g. 9:00 AM" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-mono focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Closing Time *</label>
                                    <input type="text" name="officeClosingTime" value="{{ $settings['officeClosingTime'] ?? '5:00 PM' }}" placeholder="e.g. 5:00 PM" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-mono focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Weekly Working Days & Off Day *</label>
                                    <input type="text" name="officeWeeklyDays" value="{{ $settings['officeWeeklyDays'] ?? 'Sun - Thu (Fri - Sat Closed)' }}" placeholder="e.g. Sun - Thu (Fri - Sat Closed)" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 3: Header Logo, Brand Texts & Navigation Menu -->
                        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-slate-200/90 shadow-2xs space-y-4">
                            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 text-slate-800 font-bold text-sm">
                                <i class="fa-solid fa-heading text-emerald-600 shrink-0"></i>
                                <span>Header Logo Image, Brand Name & Menu Labels</span>
                            </div>

                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 space-y-3">
                                <div class="text-xs font-bold text-slate-800 uppercase tracking-wider">Website Logo Image or Text Badge</div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 items-start text-xs font-semibold text-slate-700">
                                    <div>
                                        <label class="block mb-1">Logo Short Badge Text (If no image)</label>
                                        <input type="text" name="headerLogoText" value="{{ $settings['headerLogoText'] ?? 'NYD' }}" placeholder="e.g. NYD" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm font-bold focus:ring-2 focus:ring-emerald-500">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Upload Custom Logo Image</label>
                                        <input type="file" name="header_logo_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Or Logo Image URL</label>
                                        <input type="text" name="headerLogoImage" value="{{ $settings['headerLogoImage'] ?? '' }}" placeholder="/uploads/... or https://..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono text-xs focus:ring-2 focus:ring-emerald-500">
                                    </div>
                                </div>
                                @if(!empty($settings['headerLogoImage']))
                                    <div class="flex flex-wrap items-center justify-between gap-3 pt-1 border-t border-slate-200/60">
                                        <div class="flex items-center gap-3">
                                            <span class="text-[11px] text-slate-500">Current Logo:</span>
                                            <img src="{{ $settings['headerLogoImage'] }}" alt="Header Logo Preview" class="h-9 w-auto max-w-[120px] object-contain rounded-lg border border-slate-300 bg-white p-1">
                                        </div>
                                        <label class="flex items-center gap-1.5 cursor-pointer text-xs font-semibold text-rose-600">
                                            <input type="checkbox" name="remove_header_logo" value="1" class="w-3.5 h-3.5 text-rose-600 rounded">
                                            <span>Remove Logo Image (Revert to Text Badge)</span>
                                        </label>
                                    </div>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 text-xs font-semibold text-slate-700">
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Header Title (Main Part) *</label>
                                    <input type="text" name="headerTitleMain" value="{{ $settings['headerTitleMain'] ?? 'National Youth' }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-bold focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Header Highlight Word (Green)</label>
                                    <input type="text" name="headerTitleHighlight" value="{{ $settings['headerTitleHighlight'] ?? 'Dev' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-bold text-emerald-700 focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Header Subtitle Text</label>
                                    <input type="text" name="headerSubtitle" value="{{ $settings['headerSubtitle'] ?? 'Technical Institute' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>

                            <div class="pt-3 border-t border-slate-100 space-y-2.5">
                                <span class="text-xs font-bold text-slate-800 uppercase tracking-wider block">Header Navigation & Action Button Labels</span>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 text-xs font-semibold text-slate-700">
                                    <div>
                                        <label class="block mb-1">Menu 1 (Home)</label>
                                        <input type="text" name="navHomeText" value="{{ $settings['navHomeText'] ?? 'Home' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Menu 2 (Courses)</label>
                                        <input type="text" name="navCoursesText" value="{{ $settings['navCoursesText'] ?? 'Courses' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Menu 3 (Results)</label>
                                        <input type="text" name="navResultsText" value="{{ $settings['navResultsText'] ?? 'Exam Result' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Menu 4 (Gallery)</label>
                                        <input type="text" name="navGalleryText" value="{{ $settings['navGalleryText'] ?? 'Gallery' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Menu 5 (Resources)</label>
                                        <input type="text" name="navResourcesText" value="{{ $settings['navResourcesText'] ?? 'Resources' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Menu 6 (Contact)</label>
                                        <input type="text" name="navContactText" value="{{ $settings['navContactText'] ?? 'Contact Us' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Login Button</label>
                                        <input type="text" name="headerLoginText" value="{{ $settings['headerLoginText'] ?? 'Login' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Register Button</label>
                                        <input type="text" name="headerRegisterText" value="{{ $settings['headerRegisterText'] ?? 'Register' }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 4: Dynamic Social Media Manager (Add, Edit, Delete Platforms) -->
                        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-slate-200/90 shadow-2xs space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 pb-3 border-b border-slate-100">
                                <div>
                                    <div class="flex items-center gap-2 text-slate-800 font-bold text-sm">
                                        <i class="fa-solid fa-share-nodes text-emerald-600 shrink-0"></i>
                                        <span>Dynamic Social Media Channels</span>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-0.5">Add, edit, or remove social media icons displayed across your website footer.</p>
                                </div>
                                <button 
                                    type="button" 
                                    @click="addSocialLink()" 
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition shrink-0"
                                >
                                    <i class="fa-solid fa-plus text-xs"></i>
                                    <span>Add Social Media</span>
                                </button>
                            </div>

                            <input type="hidden" name="socialLinks" :value="JSON.stringify(socialLinks)">

                            <div class="space-y-2.5">
                                <template x-for="(soc, idx) in socialLinks" :key="idx">
                                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/90 flex flex-col sm:flex-row sm:items-center gap-2.5">
                                        <div class="flex items-center gap-2.5 sm:w-48 shrink-0">
                                            <div class="w-9 h-9 rounded-lg bg-slate-900 text-white flex items-center justify-center text-sm shrink-0">
                                                <i :class="soc.icon || 'fa-solid fa-globe'"></i>
                                            </div>
                                            <select 
                                                :value="soc.platform" 
                                                @change="updateSocialPlatform(idx, $event.target.value)"
                                                class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500"
                                            >
                                                <option value="Facebook">Facebook</option>
                                                <option value="YouTube">YouTube</option>
                                                <option value="LinkedIn">LinkedIn</option>
                                                <option value="Instagram">Instagram</option>
                                                <option value="Twitter / X">Twitter / X</option>
                                                <option value="WhatsApp">WhatsApp</option>
                                                <option value="TikTok">TikTok</option>
                                                <option value="Telegram">Telegram</option>
                                                <option value="Website">Website / Portal</option>
                                            </select>
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <input 
                                                type="url" 
                                                x-model="soc.url" 
                                                placeholder="https://facebook.com/yourpage" 
                                                class="w-full px-3.5 py-2 rounded-xl border border-slate-300 bg-white font-mono text-xs focus:ring-2 focus:ring-emerald-500"
                                            >
                                        </div>

                                        <button 
                                            type="button" 
                                            @click="removeSocialLink(idx)" 
                                            class="w-full sm:w-auto px-3 py-2 rounded-xl text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-200 text-xs font-bold flex items-center justify-center gap-1.5 transition shrink-0"
                                            title="Remove Social Channel"
                                        >
                                            <i class="fa-solid fa-trash-can"></i>
                                            <span class="sm:hidden">Remove</span>
                                        </button>
                                    </div>
                                </template>

                                <div x-show="socialLinks.length === 0" class="text-center py-6 bg-slate-50 rounded-xl border border-dashed border-slate-300 text-xs text-slate-400">
                                    No social media channels configured. Click "+ Add Social Media" to add Facebook, YouTube, Instagram, etc.
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 5: Top Breaking Notice Marquee & Emergency Alert -->
                        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-slate-200/90 shadow-2xs space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-100">
                                <div class="flex items-center gap-2.5 text-slate-800 font-bold text-sm">
                                    <i class="fa-solid fa-bullhorn text-amber-500 shrink-0"></i>
                                    <span>Top Emergency Alert Bar & Breaking Notice</span>
                                </div>
                                <label class="flex items-center gap-2 cursor-pointer shrink-0">
                                    <input type="checkbox" name="urgentNoticeEnabled" value="1" {{ !empty($settings['urgentNoticeEnabled']) ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded">
                                    <span class="text-xs font-bold text-slate-700">Show Alert Notice in Top Bar</span>
                                </label>
                            </div>

                            <div class="text-xs font-semibold text-slate-700">
                                <label class="block uppercase tracking-wider mb-1">Ticker Announcement Text</label>
                                <input type="text" name="tickerText" value="{{ $settings['tickerText'] ?? '' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs font-semibold text-slate-700">
                                <div class="md:col-span-2">
                                    <label class="block uppercase tracking-wider mb-1">Header Notice Banner Message</label>
                                    <input type="text" name="emergencyNoticeText" value="{{ $settings['emergencyNoticeText'] ?? '' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Notice Click Link (URL)</label>
                                    <input type="text" name="emergencyNoticeLink" value="{{ $settings['emergencyNoticeLink'] ?? '/results' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 6: Full Website Footer Content & Attribution -->
                        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-slate-200/90 shadow-2xs space-y-4">
                            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 text-slate-800 font-bold text-sm">
                                <i class="fa-solid fa-shoe-prints text-emerald-600 shrink-0"></i>
                                <span>Website Footer Content, Headings & Copyright</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 text-xs font-semibold text-slate-700">
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Footer Brand Heading Title *</label>
                                    <input type="text" name="footerBrandTitle" value="{{ $settings['footerBrandTitle'] ?? 'National Youth Development' }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-bold focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Footer Brand Subtitle</label>
                                    <input type="text" name="footerBrandSubtitle" value="{{ $settings['footerBrandSubtitle'] ?? 'Technical Training Platform' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 text-xs font-semibold text-slate-700">
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Footer Verification / Accreditation Badge</label>
                                    <input type="text" name="footerAccreditationBadge" value="{{ $settings['footerAccreditationBadge'] ?? 'Govt. Reg. Affiliated Technical Directorate' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Social Section Heading</label>
                                    <input type="text" name="footerSocialHeading" value="{{ $settings['footerSocialHeading'] ?? 'Official Channels' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>

                            <div class="text-xs font-semibold text-slate-700">
                                <label class="block uppercase tracking-wider mb-1">Footer Mission Statement / Description Paragraph</label>
                                <textarea name="footerDescription" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500">{{ $settings['footerDescription'] ?? '' }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs font-semibold text-slate-700">
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Column 2 Title</label>
                                    <input type="text" name="footerCol2Title" value="{{ $settings['footerCol2Title'] ?? 'Academic Programs' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Column 3 Title</label>
                                    <input type="text" name="footerCol3Title" value="{{ $settings['footerCol3Title'] ?? 'Portal Verification' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Column 4 Title</label>
                                    <input type="text" name="footerCol4Title" value="{{ $settings['footerCol4Title'] ?? 'Central Directorate' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs font-semibold text-slate-700 pt-2 border-t border-slate-100">
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Footer Copyright Text</label>
                                    <input type="text" name="footerCopyright" value="{{ $settings['footerCopyright'] ?? 'National Youth Development Platform. All rights reserved.' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Supervised Label</label>
                                    <input type="text" name="footerSupervisedLabel" value="{{ $settings['footerSupervisedLabel'] ?? 'Supervised by' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block uppercase tracking-wider mb-1">Supervised Organization Name</label>
                                    <input type="text" name="footerSupervisedOrg" value="{{ $settings['footerSupervisedOrg'] ?? ($settings['instituteName'] ?? 'Saikat Computer & Training Jubo Songhoton') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Final Save Button -->
                    <div class="sticky bottom-3 sm:bottom-4 z-20 bg-white/95 backdrop-blur-md p-3 sm:p-4 rounded-2xl border border-slate-200/90 shadow-lg flex items-center justify-between gap-3 sm:gap-4">
                        <div class="text-xs text-slate-500 font-medium hidden sm:block">
                            Changes saved here immediately update the live public website and portals.
                        </div>
                        <button type="submit" class="w-full sm:w-auto px-6 sm:px-8 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm transition shadow-md hover:shadow-lg flex items-center justify-center gap-2.5">
                            <i class="fa-solid fa-floppy-disk text-base"></i>
                            <span>Save & Publish All Website Content</span>
                        </button>
                    </div>

                </form>
            </div>

        </main>
    </div>

    <!-- ==========================================
         MODAL 1: ADD NEW COURSE
         ========================================== -->
    <div x-show="isCourseModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-900/40 backdrop-blur-xs">
        <div @click.away="isCourseModalOpen = false" class="bg-white rounded-3xl p-5 sm:p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-slate-200 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-900">Add New Vocational Course</h3>
                <button type="button" @click="isCourseModalOpen = false" class="text-slate-400 hover:text-slate-600 text-lg">✕</button>
            </div>

            <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3 text-sm">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Course Title *</label>
                    <input type="text" name="title" required placeholder="e.g. Electrical House Wiring & Solar Automation" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Category *</label>
                        <select name="category" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold focus:ring-2 focus:ring-emerald-500">
                            <option value="ICT & Digital Engineering">ICT & Digital Engineering</option>
                            <option value="Electrical & Industrial Power">Electrical & Industrial Power</option>
                            <option value="Mechanical & Gas Welding">Mechanical & Gas Welding</option>
                            <option value="Refrigeration & AC (HVAC)">Refrigeration & AC (HVAC)</option>
                            <option value="Automobile & Driving Tech">Automobile & Driving Tech</option>
                            <option value="Garments & Fashion Apparel">Garments & Fashion Apparel</option>
                            <option value="Modern Agriculture & Dairy">Modern Agriculture & Dairy</option>
                            <option value="Hospitality & Culinary Arts">Hospitality & Culinary Arts</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Duration *</label>
                        <input type="text" name="duration" required placeholder="e.g. 6 Months (360 Hours)" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Total Seats *</label>
                        <input type="number" name="seats" value="30" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Fee Structure *</label>
                        <input type="text" name="fee" value="BDT 1,000 (Govt Subsidized)" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Level *</label>
                        <input type="text" name="level" value="Beginner to Advanced" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Badge Tag</label>
                        <input type="text" name="badge" placeholder="e.g. Most Popular / High Demand" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Upload Thumbnail Image File</label>
                        <input type="file" name="thumbnail_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Or Thumbnail Image URL</label>
                    <input type="text" name="image" placeholder="https://images.unsplash.com/..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Total Practical Hours</label>
                        <input type="number" name="total_hours" value="360" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Available Seats Left</label>
                        <input type="number" name="seats_remaining" value="8" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Class Schedule</label>
                        <input type="text" name="schedule" value="Friday & Saturday (Morning & Evening Batches)" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Regional Training Centers</label>
                        <input type="text" name="centers" value="Available across all 64 District Regional Hubs" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Short Description (Card Summary) *</label>
                    <textarea name="short_description" rows="2" placeholder="Brief summary of skills learned..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Full Course Overview & Description *</label>
                    <textarea name="overview" rows="3" required placeholder="Comprehensive hands-on training covering..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">Comprehensive government-certified vocational curriculum designed for immediate industrial employment, freelancing competence, and technical mastery.</textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Core Competencies & Learning Outcomes (One bullet outcome per line)</label>
                    <textarea name="learning_outcomes_text" rows="3" placeholder="Hands-on practical workshop execution&#10;100% verified certification credential&#10;Industry standard safety compliance" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Target Career Paths (One career role per line)</label>
                    <textarea name="career_opportunities_text" rows="2" placeholder="Junior Technical Specialist&#10;Freelance Technician&#10;Assistant Engineer" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Course Syllabus & Curriculum Modules (One module title per line)</label>
                    <textarea name="curriculum_text" rows="3" placeholder="Module 1: Fundamental Safety & Tool Handling&#10;Module 2: Practical Industrial Lab Exercises&#10;Module 3: Project Work & Final Certification" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div class="flex flex-wrap items-center gap-6 pt-1">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="featured" id="featured" value="1" checked class="w-4 h-4 text-emerald-600 rounded">
                        <label for="featured" class="text-xs font-semibold text-slate-700 cursor-pointer">Feature on Homepage</label>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_subsidized" id="is_subsidized" value="1" checked class="w-4 h-4 text-emerald-600 rounded">
                        <label for="is_subsidized" class="text-xs font-semibold text-slate-700 cursor-pointer">Government Subsidized (Govt Aid)</label>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="isCourseModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-semibold">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold shadow-xs">Publish Course</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==========================================
         MODAL 1.1: EDIT COURSE (DYNAMIC EDIT)
         ========================================== -->
    <div x-show="isEditCourseModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-900/40 backdrop-blur-xs">
        <div @click.away="isEditCourseModalOpen = false" class="bg-white rounded-3xl p-5 sm:p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-slate-200 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Edit Vocational Course</h3>
                    <p class="text-xs text-slate-500">Update course details, fees, seats, or replace the thumbnail image.</p>
                </div>
                <button type="button" @click="isEditCourseModalOpen = false" class="text-slate-400 hover:text-slate-600 text-lg">✕</button>
            </div>

            <form :action="'/admin/courses/' + editingCourse.id + '/update'" method="POST" enctype="multipart/form-data" class="space-y-3 text-sm">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Course Title *</label>
                    <input type="text" name="title" :value="editingCourse.title" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Category *</label>
                        <select name="category" x-model="editingCourse.category" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold focus:ring-2 focus:ring-emerald-500">
                            <option value="ICT & Digital Engineering">ICT & Digital Engineering</option>
                            <option value="Electrical & Industrial Power">Electrical & Industrial Power</option>
                            <option value="Mechanical & Gas Welding">Mechanical & Gas Welding</option>
                            <option value="Refrigeration & AC (HVAC)">Refrigeration & AC (HVAC)</option>
                            <option value="Automobile & Driving Tech">Automobile & Driving Tech</option>
                            <option value="Garments & Fashion Apparel">Garments & Fashion Apparel</option>
                            <option value="Modern Agriculture & Dairy">Modern Agriculture & Dairy</option>
                            <option value="Hospitality & Culinary Arts">Hospitality & Culinary Arts</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Duration *</label>
                        <input type="text" name="duration" :value="editingCourse.duration" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Total Seats *</label>
                        <input type="number" name="seats" :value="editingCourse.seats" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Fee Structure *</label>
                        <input type="text" name="fee" :value="editingCourse.fee" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Level *</label>
                        <input type="text" name="level" :value="editingCourse.level || 'Beginner to Advanced'" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Badge Tag</label>
                        <input type="text" name="badge" :value="editingCourse.badge" placeholder="e.g. Most Popular" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Upload New Thumbnail Image</label>
                        <input type="file" name="thumbnail_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Or Thumbnail Image URL</label>
                    <input type="text" name="image" :value="editingCourse.image" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Total Practical Hours</label>
                        <input type="number" name="total_hours" :value="editingCourse.total_hours || 360" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Available Seats Left</label>
                        <input type="number" name="seats_remaining" :value="editingCourse.seats_remaining || 8" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Class Schedule</label>
                        <input type="text" name="schedule" :value="editingCourse.schedule || 'Friday & Saturday (Morning & Evening Batches)'" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Regional Training Centers</label>
                        <input type="text" name="centers" :value="editingCourse.centers || 'Available across all 64 District Regional Hubs'" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Short Description (Card Summary) *</label>
                    <textarea name="short_description" rows="2" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500" x-text="editingCourse.short_description"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Full Course Overview & Description *</label>
                    <textarea name="overview" rows="3" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500" x-text="editingCourse.overview"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Core Competencies & Learning Outcomes (One bullet outcome per line)</label>
                    <textarea name="learning_outcomes_text" rows="3" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-emerald-500" :value="editingCourse.learning_outcomes_text"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Target Career Paths (One career role per line)</label>
                    <textarea name="career_opportunities_text" rows="2" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-emerald-500" :value="editingCourse.career_opportunities_text"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Course Syllabus & Curriculum Modules (One module title per line)</label>
                    <textarea name="curriculum_text" rows="3" placeholder="Module 1: ...&#10;Module 2: ..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-emerald-500" :value="editingCourse.curriculum_text"></textarea>
                </div>

                <div class="flex flex-wrap items-center gap-6 pt-1">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="featured" id="edit_featured" value="1" :checked="editingCourse.featured" class="w-4 h-4 text-emerald-600 rounded">
                        <label for="edit_featured" class="text-xs font-semibold text-slate-700 cursor-pointer">Feature on Homepage</label>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_subsidized" id="edit_is_subsidized" value="1" :checked="editingCourse.is_subsidized" class="w-4 h-4 text-emerald-600 rounded">
                        <label for="edit_is_subsidized" class="text-xs font-semibold text-slate-700 cursor-pointer">Government Subsidized (Govt Aid)</label>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="isEditCourseModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-semibold">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold shadow-xs">Update Course</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Datalist for Quick Course Name Autocomplete -->
    <datalist id="courseNamesList">
        @foreach($courses as $c)
            <option value="{{ $c->title }}">
        @endforeach
    </datalist>

    <!-- ==========================================
         MODAL 2: ADD STUDENT RESULT
         ========================================== -->
    <div x-show="isResultModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-900/40 backdrop-blur-xs">
        <div @click.away="isResultModalOpen = false" class="bg-white rounded-3xl p-5 sm:p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-slate-200 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-900">Upload Certified Student Result</h3>
                <button type="button" @click="isResultModalOpen = false" class="text-slate-400 hover:text-slate-600 text-lg">✕</button>
            </div>

            <form action="{{ route('admin.results.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3 text-sm">
                @csrf

                <!-- Student Photo Upload Box -->
                <div class="p-3.5 rounded-2xl bg-emerald-50/50 border border-emerald-200/80 space-y-2.5">
                    <div class="text-xs font-bold text-emerald-900 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-camera text-emerald-600"></i>
                        <span>Student Passport Photo (Shown on Public Result Page & Marksheet)</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-center">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Upload Photo from Device</label>
                            <input type="file" name="photo_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Or Direct Photo URL</label>
                            <input type="text" name="photo" value="{{ old('photo') }}" placeholder="https://... or /uploads/..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono text-xs bg-white focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Student Roll No *</label>
                        <input type="text" name="roll_no" value="{{ old('roll_no') }}" required placeholder="e.g. 1151489 or NYD-2026-1055" class="w-full px-3.5 py-2 rounded-xl border {{ $errors->has('roll_no') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300' }} font-mono font-bold focus:ring-2 focus:ring-emerald-500">
                        @error('roll_no')
                            <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Registration No *</label>
                        <input type="text" name="reg_no" value="{{ old('reg_no') }}" required placeholder="e.g. 11500902026331489" class="w-full px-3.5 py-2 rounded-xl border {{ $errors->has('reg_no') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300' }} font-mono font-bold focus:ring-2 focus:ring-emerald-500">
                        @error('reg_no')
                            <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Student Full Name *</label>
                        <input type="text" name="student_name" value="{{ old('student_name') }}" required placeholder="e.g. Moyazzem Hossain" class="w-full px-3.5 py-2 rounded-xl border {{ $errors->has('student_name') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-300' }} font-semibold focus:ring-2 focus:ring-emerald-500">
                        @error('student_name')
                            <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Course Code</label>
                        <input type="text" name="course_code" value="{{ old('course_code') }}" placeholder="e.g. D25596" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono font-bold focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Course Name (Trade) *</label>
                        <input type="text" name="trade" list="courseNamesList" value="{{ old('trade') }}" required placeholder="e.g. Diploma in Welding Engineering" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Branch / Center Name *</label>
                        <input type="text" name="center" value="{{ old('center', $settings['instituteName'] ?? 'Saikat Technical Training Center') }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Father's Name (Optional)</label>
                        <input type="text" name="father_name" value="{{ old('father_name') }}" placeholder="e.g. Md. Shahidul Islam" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Mother's Name (Optional)</label>
                        <input type="text" name="mother_name" value="{{ old('mother_name') }}" placeholder="e.g. Rashida Begum" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Result / Score</label>
                        <input type="text" name="result_score" value="{{ old('result_score') }}" placeholder="e.g. 75" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono font-bold focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">GPA (Out of 4) *</label>
                        <input type="number" step="0.01" name="gpa" value="{{ old('gpa', '3.85') }}" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono font-bold focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Grade *</label>
                        <input type="text" name="grade" value="{{ old('grade', 'A+') }}" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono font-bold focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Session *</label>
                        <input type="text" name="session" value="{{ old('session', 'Jan-Jun 2026') }}" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Exam Year *</label>
                        <input type="text" name="exam_year" value="{{ old('exam_year', '2026') }}" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Institute Name *</label>
                        <input type="text" name="institute_name" value="{{ old('institute_name', $settings['instituteName'] ?? 'Saikat Computer & Training Jubo Songhoton') }}" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Issue Date *</label>
                        <input type="date" name="issue_date" value="{{ old('issue_date', date('Y-m-d')) }}" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <!-- Subject-Wise Marksheet Breakdown (Optional Toggle) -->
                <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200 space-y-3">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <label class="flex items-start gap-2.5 cursor-pointer select-none">
                            <input 
                                type="checkbox" 
                                name="include_marks" 
                                value="1" 
                                x-model="includeResultMarks" 
                                @change="if(includeResultMarks && resultMarks.length === 0) addResultMarkRow()" 
                                class="w-4 h-4 mt-0.5 text-emerald-600 rounded focus:ring-emerald-500"
                            >
                            <div>
                                <span class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fa-solid fa-list-check text-emerald-600"></i>
                                    <span>Include Subject-Wise Marksheet Details (Optional)</span>
                                </span>
                                <span class="text-[11px] text-slate-500 block">Leave unchecked if you only want to show Result & Grade (nothing extra will appear).</span>
                            </div>
                        </label>

                        <div x-show="includeResultMarks" x-cloak class="flex items-center gap-1.5">
                            <button type="button" @click="loadSampleResultMarks()" class="text-[11px] font-semibold text-slate-600 bg-white hover:bg-slate-100 border border-slate-300 px-2 py-1 rounded-lg transition cursor-pointer">
                                Sample Rows
                            </button>
                            <button type="button" @click="addResultMarkRow()" class="text-xs font-bold text-emerald-700 bg-emerald-100/70 hover:bg-emerald-100 border border-emerald-300 px-2.5 py-1 rounded-lg transition flex items-center gap-1 cursor-pointer">
                                <i class="fa-solid fa-plus text-[10px]"></i>
                                <span>Add Subject</span>
                            </button>
                        </div>
                    </div>

                    <div x-show="includeResultMarks" x-cloak class="space-y-2 pt-1">
                        <template x-for="(item, idx) in resultMarks" :key="idx">
                            <div class="grid grid-cols-12 gap-2 items-center bg-white p-2.5 rounded-xl border border-slate-200 text-xs shadow-2xs">
                                <div class="col-span-12 sm:col-span-5">
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-0.5">Subject Name</label>
                                    <input type="text" :name="'marks[' + idx + '][subject]'" x-model="item.subject" :required="includeResultMarks" :disabled="!includeResultMarks" placeholder="e.g. Theoretical Knowledge" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-300 font-semibold text-xs focus:ring-1 focus:ring-emerald-500">
                                </div>
                                <div class="col-span-4 sm:col-span-2">
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-0.5 text-center">Full</label>
                                    <input type="number" :name="'marks[' + idx + '][fullMarks]'" x-model="item.fullMarks" :required="includeResultMarks" :disabled="!includeResultMarks" class="w-full px-2 py-1.5 rounded-lg border border-slate-300 font-mono text-center text-xs">
                                </div>
                                <div class="col-span-4 sm:col-span-2">
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-0.5 text-center">Obtained</label>
                                    <input type="number" :name="'marks[' + idx + '][obtained]'" x-model="item.obtained" :required="includeResultMarks" :disabled="!includeResultMarks" class="w-full px-2 py-1.5 rounded-lg border border-slate-300 font-mono font-bold text-center text-xs">
                                </div>
                                <div class="col-span-3 sm:col-span-2">
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-0.5 text-center">Grade</label>
                                    <input type="text" :name="'marks[' + idx + '][grade]'" x-model="item.grade" :required="includeResultMarks" :disabled="!includeResultMarks" class="w-full px-2 py-1.5 rounded-lg border border-slate-300 font-mono font-bold text-center text-xs">
                                </div>
                                <div class="col-span-1 flex items-end justify-center pt-3">
                                    <button type="button" @click="removeResultMarkRow(idx)" class="text-rose-500 hover:text-rose-700 hover:bg-rose-50 p-1.5 rounded-md transition cursor-pointer" title="Remove Subject">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="isResultModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-semibold">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold shadow-xs">Save Result & Marksheet</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==========================================
         MODAL 2.1: EDIT STUDENT RESULT
         ========================================== -->
    <div x-show="isEditResultModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-900/40 backdrop-blur-xs">
        <div @click.away="isEditResultModalOpen = false" class="bg-white rounded-3xl p-5 sm:p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-slate-200 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Edit Student Result & Marksheet</h3>
                    <p class="text-xs text-slate-500">Update student photo, course code, score, grade, or verification details.</p>
                </div>
                <button type="button" @click="isEditResultModalOpen = false" class="text-slate-400 hover:text-slate-600 text-lg">✕</button>
            </div>

            <form :action="'/admin/results/' + editingResult.id + '/update'" method="POST" enctype="multipart/form-data" class="space-y-3 text-sm">
                @csrf

                <!-- Student Photo Edit Box with Live Preview -->
                <div class="p-3.5 rounded-2xl bg-emerald-50/50 border border-emerald-200/80 space-y-3">
                    <div class="flex items-center justify-between gap-2">
                        <div class="text-xs font-bold text-emerald-900 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fa-solid fa-camera text-emerald-600"></i>
                            <span>Student Passport Photo</span>
                        </div>
                        <template x-if="editingResult.photo">
                            <label class="flex items-center gap-1.5 cursor-pointer text-[11px] font-bold text-rose-600">
                                <input type="checkbox" name="remove_photo" value="1" class="w-3.5 h-3.5 text-rose-600 rounded">
                                <span>Remove Photo</span>
                            </label>
                        </template>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <div class="w-16 h-20 rounded-xl border border-slate-300 bg-white overflow-hidden flex items-center justify-center shrink-0 shadow-2xs">
                            <template x-if="editingResult.photo">
                                <img :src="editingResult.photo" class="w-full h-full object-cover object-top" alt="Student">
                            </template>
                            <template x-if="!editingResult.photo">
                                <i class="fa-solid fa-user text-slate-300 text-2xl"></i>
                            </template>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 w-full">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Upload New Photo File</label>
                                <input type="file" name="photo_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 cursor-pointer">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Or Photo URL</label>
                                <input type="text" name="photo" :value="editingResult.photo" placeholder="https://... or /uploads/..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono text-xs bg-white focus:ring-2 focus:ring-emerald-500">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Student Roll No *</label>
                        <input type="text" name="roll_no" :value="editingResult.roll_no" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono font-bold focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Registration No *</label>
                        <input type="text" name="reg_no" :value="editingResult.reg_no" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono font-bold focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Student Full Name *</label>
                        <input type="text" name="student_name" :value="editingResult.student_name" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Course Code</label>
                        <input type="text" name="course_code" :value="editingResult.course_code" placeholder="e.g. D25596" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono font-bold focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Course Name (Trade) *</label>
                        <input type="text" name="trade" list="courseNamesList" :value="editingResult.trade" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Branch / Center Name *</label>
                        <input type="text" name="center" :value="editingResult.center" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Father's Name (Optional)</label>
                        <input type="text" name="father_name" :value="editingResult.father_name" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Mother's Name (Optional)</label>
                        <input type="text" name="mother_name" :value="editingResult.mother_name" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Result / Score</label>
                        <input type="text" name="result_score" :value="editingResult.result_score" placeholder="e.g. 75" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono font-bold focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">GPA *</label>
                        <input type="number" step="0.01" name="gpa" :value="editingResult.gpa" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono font-bold focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Grade *</label>
                        <input type="text" name="grade" :value="editingResult.grade" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono font-bold focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Session *</label>
                        <input type="text" name="session" :value="editingResult.session" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Exam Year *</label>
                        <input type="text" name="exam_year" :value="editingResult.exam_year" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Institute Name *</label>
                        <input type="text" name="institute_name" :value="editingResult.institute_name" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Issue Date *</label>
                        <input type="date" name="issue_date" :value="editingResult.issue_date" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <!-- Subject-Wise Marksheet Breakdown (Optional Toggle for Edit) -->
                <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200 space-y-3">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <label class="flex items-start gap-2.5 cursor-pointer select-none">
                            <input 
                                type="checkbox" 
                                name="include_marks" 
                                value="1" 
                                x-model="includeEditResultMarks" 
                                @change="if(includeEditResultMarks && (!editingResult.marks || editingResult.marks.length === 0)) addEditResultMarkRow()" 
                                class="w-4 h-4 mt-0.5 text-emerald-600 rounded focus:ring-emerald-500"
                            >
                            <div>
                                <span class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fa-solid fa-list-check text-emerald-600"></i>
                                    <span>Include Subject-Wise Marksheet Details (Optional)</span>
                                </span>
                                <span class="text-[11px] text-slate-500 block">Uncheck to hide/remove the subject breakdown table for this student.</span>
                            </div>
                        </label>

                        <div x-show="includeEditResultMarks" x-cloak class="flex items-center gap-1.5">
                            <button type="button" @click="loadSampleEditResultMarks()" class="text-[11px] font-semibold text-slate-600 bg-white hover:bg-slate-100 border border-slate-300 px-2 py-1 rounded-lg transition cursor-pointer">
                                Sample Rows
                            </button>
                            <button type="button" @click="addEditResultMarkRow()" class="text-xs font-bold text-emerald-700 bg-emerald-100/70 hover:bg-emerald-100 border border-emerald-300 px-2.5 py-1 rounded-lg transition flex items-center gap-1 cursor-pointer">
                                <i class="fa-solid fa-plus text-[10px]"></i>
                                <span>Add Subject</span>
                            </button>
                        </div>
                    </div>

                    <div x-show="includeEditResultMarks" x-cloak class="space-y-2 pt-1">
                        <template x-for="(item, idx) in (editingResult.marks || [])" :key="idx">
                            <div class="grid grid-cols-12 gap-2 items-center bg-white p-2.5 rounded-xl border border-slate-200 text-xs shadow-2xs">
                                <div class="col-span-12 sm:col-span-5">
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-0.5">Subject Name</label>
                                    <input type="text" :name="'marks[' + idx + '][subject]'" x-model="item.subject" :required="includeEditResultMarks" :disabled="!includeEditResultMarks" placeholder="Subject title" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-300 font-semibold text-xs focus:ring-1 focus:ring-emerald-500">
                                </div>
                                <div class="col-span-4 sm:col-span-2">
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-0.5 text-center">Full</label>
                                    <input type="number" :name="'marks[' + idx + '][fullMarks]'" x-model="item.fullMarks" :required="includeEditResultMarks" :disabled="!includeEditResultMarks" class="w-full px-2 py-1.5 rounded-lg border border-slate-300 font-mono text-center text-xs">
                                </div>
                                <div class="col-span-4 sm:col-span-2">
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-0.5 text-center">Obtained</label>
                                    <input type="number" :name="'marks[' + idx + '][obtained]'" x-model="item.obtained" :required="includeEditResultMarks" :disabled="!includeEditResultMarks" class="w-full px-2 py-1.5 rounded-lg border border-slate-300 font-mono font-bold text-center text-xs">
                                </div>
                                <div class="col-span-3 sm:col-span-2">
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-0.5 text-center">Grade</label>
                                    <input type="text" :name="'marks[' + idx + '][grade]'" x-model="item.grade" :required="includeEditResultMarks" :disabled="!includeEditResultMarks" class="w-full px-2 py-1.5 rounded-lg border border-slate-300 font-mono font-bold text-center text-xs">
                                </div>
                                <div class="col-span-1 flex items-end justify-center pt-3">
                                    <button type="button" @click="removeEditResultMarkRow(idx)" class="text-rose-500 hover:text-rose-700 hover:bg-rose-50 p-1.5 rounded-md transition cursor-pointer" title="Remove Subject">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="isEditResultModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-semibold">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold shadow-xs">Update Result</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==========================================
         MODAL 3: UPLOAD RESOURCE / DOCUMENT
         ========================================== -->
    <div x-show="isResourceModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-900/40 backdrop-blur-xs">
        <div @click.away="isResourceModalOpen = false" class="bg-white rounded-3xl p-5 sm:p-6 w-full max-w-lg border border-slate-200 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-900">Upload Resource / Document</h3>
                <button type="button" @click="isResourceModalOpen = false" class="text-slate-400 hover:text-slate-600 text-lg">✕</button>
            </div>

            <form action="{{ route('admin.resources.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3 text-sm">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Document Title *</label>
                    <input type="text" name="title" required placeholder="e.g. 2026 Diploma Final Exam Routine" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Category *</label>
                        <select name="category" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold focus:ring-2 focus:ring-emerald-500">
                            <option value="Syllabus">Course Syllabus</option>
                            <option value="Notices">Notices & Circulars</option>
                            <option value="Forms">Admission Forms</option>
                            <option value="Routines">Exam Routines</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Select File to Upload</label>
                        <input type="file" name="resource_file" accept=".pdf,.doc,.docx,.zip,.xls,.xlsx" class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Or Direct Download URL</label>
                    <input type="text" name="download_url" placeholder="https://... or leave empty if uploading file" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="isResourceModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-semibold">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold shadow-xs">Publish Document</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==========================================
         MODAL 3.1: EDIT RESOURCE / DOCUMENT
         ========================================== -->
    <div x-show="isEditResourceModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-900/40 backdrop-blur-xs">
        <div @click.away="isEditResourceModalOpen = false" class="bg-white rounded-3xl p-5 sm:p-6 w-full max-w-lg border border-slate-200 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-900">Edit Academic Resource</h3>
                <button type="button" @click="isEditResourceModalOpen = false" class="text-slate-400 hover:text-slate-600 text-lg">✕</button>
            </div>

            <form :action="'/admin/resources/' + editingResource.id + '/update'" method="POST" enctype="multipart/form-data" class="space-y-3 text-sm">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Document Title *</label>
                    <input type="text" name="title" :value="editingResource.title" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Category *</label>
                        <select name="category" x-model="editingResource.category" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold focus:ring-2 focus:ring-emerald-500">
                            <option value="Syllabus">Course Syllabus</option>
                            <option value="Notices">Notices & Circulars</option>
                            <option value="Forms">Admission Forms</option>
                            <option value="Routines">Exam Routines</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Upload New File</label>
                        <input type="file" name="resource_file" accept=".pdf,.doc,.docx,.zip,.xls,.xlsx" class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Or Download URL</label>
                    <input type="text" name="download_url" :value="editingResource.download_url" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="isEditResourceModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-semibold">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold shadow-xs">Update Resource</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==========================================
         MODAL 4: ADD GALLERY PHOTO
         ========================================== -->
    <div x-show="isGalleryModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-900/40 backdrop-blur-xs">
        <div @click.away="isGalleryModalOpen = false" class="bg-white rounded-3xl p-5 sm:p-6 w-full max-w-lg border border-slate-200 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Add Campus Gallery Photo</h3>
                    <p class="text-xs text-slate-500">Upload photo, choose or create category, and write photo description.</p>
                </div>
                <button type="button" @click="isGalleryModalOpen = false" class="text-slate-400 hover:text-slate-600 text-lg">✕</button>
            </div>

            <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3 text-sm">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Photo Title *</label>
                    <input type="text" name="title" required placeholder="e.g. Modern Computer Lab Hands-On Session" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Category Selector with New Category Adder -->
                <div x-data="{ customCategory: false }">
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-semibold text-slate-700 uppercase">Category *</label>
                        <button 
                            type="button" 
                            @click="customCategory = !customCategory" 
                            class="text-xs font-bold text-emerald-600 hover:text-emerald-700 transition"
                        >
                            <span x-show="!customCategory">+ Add New Category</span>
                            <span x-show="customCategory">← Choose Existing</span>
                        </button>
                    </div>

                    <!-- Existing Categories Dropdown -->
                    <div x-show="!customCategory">
                        <select name="category" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold focus:ring-2 focus:ring-emerald-500">
                            @foreach(($galleryCategories ?? ['Computer Labs', 'Workshops & Trades', 'Campus Events', 'Graduation Ceremonies']) as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Custom Category Input -->
                    <div x-show="customCategory">
                        <input 
                            type="text" 
                            name="new_category" 
                            placeholder="Type new category name (e.g. Electrical Lab, Robotics...)" 
                            class="w-full px-3.5 py-2 rounded-xl border border-emerald-400 bg-emerald-50/30 font-semibold focus:ring-2 focus:ring-emerald-500 text-xs sm:text-sm"
                        >
                    </div>
                </div>

                <!-- Description / Caption Field -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Photo Description / Details</label>
                    <textarea 
                        name="description" 
                        rows="3" 
                        placeholder="Provide details about the lab equipment, workshop session, or campus event..." 
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500"
                    ></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Upload Photo File from Device</label>
                    <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Or Photo URL / Path</label>
                    <input type="text" name="image_url" placeholder="/images/gallery-1.jpg or https://..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="isGalleryModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-semibold">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold shadow-xs">Add Image</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==========================================
         MODAL 4.1: EDIT GALLERY PHOTO
         ========================================== -->
    <div x-show="isEditGalleryModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-900/40 backdrop-blur-xs">
        <div @click.away="isEditGalleryModalOpen = false" class="bg-white rounded-3xl p-5 sm:p-6 w-full max-w-lg border border-slate-200 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Edit Gallery Photo</h3>
                    <p class="text-xs text-slate-500">Update photo title, category, description, or replace photo image.</p>
                </div>
                <button type="button" @click="isEditGalleryModalOpen = false" class="text-slate-400 hover:text-slate-600 text-lg">✕</button>
            </div>

            <form :action="'/admin/gallery/' + editingGallery.id + '/update'" method="POST" enctype="multipart/form-data" class="space-y-3 text-sm">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Photo Title *</label>
                    <input type="text" name="title" :value="editingGallery.title" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Category Selector with New Category Adder -->
                <div x-data="{ customCategory: false }">
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-semibold text-slate-700 uppercase">Category *</label>
                        <button 
                            type="button" 
                            @click="customCategory = !customCategory" 
                            class="text-xs font-bold text-emerald-600 hover:text-emerald-700 transition"
                        >
                            <span x-show="!customCategory">+ Add New Category</span>
                            <span x-show="customCategory">← Choose Existing</span>
                        </button>
                    </div>

                    <!-- Existing Categories Dropdown -->
                    <div x-show="!customCategory">
                        <select name="category" x-model="editingGallery.category" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold focus:ring-2 focus:ring-emerald-500">
                            @foreach(($galleryCategories ?? ['Computer Labs', 'Workshops & Trades', 'Campus Events', 'Graduation Ceremonies']) as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Custom Category Input -->
                    <div x-show="customCategory">
                        <input 
                            type="text" 
                            name="new_category" 
                            placeholder="Type new category name..." 
                            class="w-full px-3.5 py-2 rounded-xl border border-emerald-400 bg-emerald-50/30 font-semibold focus:ring-2 focus:ring-emerald-500 text-xs sm:text-sm"
                        >
                    </div>
                </div>

                <!-- Description / Caption Field -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Photo Description / Details</label>
                    <textarea 
                        name="description" 
                        rows="3" 
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500" 
                        x-model="editingGallery.description"
                    ></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Upload New Image File</label>
                    <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Or Photo URL</label>
                    <input type="text" name="image_url" :value="editingGallery.image_url" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="isEditGalleryModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-semibold">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold shadow-xs">Update Photo</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==========================================
         MODAL 5: EDIT / REVIEW ADMISSION APPLICATION
         ========================================== -->
    <div x-show="isAdmissionModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-900/40 backdrop-blur-xs">
        <div @click.away="isAdmissionModalOpen = false" class="bg-white rounded-3xl p-5 sm:p-6 w-full max-w-lg border border-slate-200 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Review Trainee Application</h3>
                    <p class="text-xs text-slate-500">Manage enrollment status, assign roll, or update contact info.</p>
                </div>
                <button type="button" @click="isAdmissionModalOpen = false" class="text-slate-400 hover:text-slate-600 text-lg">✕</button>
            </div>

            <form :action="'/admin/admissions/' + editingAdmission.id + '/update'" method="POST" class="space-y-3 text-sm">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Applicant Full Name *</label>
                    <input type="text" name="full_name" :value="editingAdmission.full_name" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Mobile Phone *</label>
                        <input type="text" name="phone" :value="editingAdmission.phone" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Email Address *</label>
                        <input type="email" name="email" :value="editingAdmission.email" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Target Trade *</label>
                        <input type="text" name="trade" :value="editingAdmission.trade" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-semibold">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">District Hub *</label>
                        <input type="text" name="district" :value="editingAdmission.district" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-semibold">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Admission Status *</label>
                        <select name="status" x-model="editingAdmission.status" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold focus:ring-2 focus:ring-emerald-500">
                            <option value="Pending">Pending Review</option>
                            <option value="Approved">Approved (Enrolled)</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Assigned Student Roll</label>
                        <input type="text" name="assigned_roll" :value="editingAdmission.assigned_roll" placeholder="Auto-generated if Approved" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Internal Notes</label>
                    <textarea name="notes" rows="2" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500" x-text="editingAdmission.notes"></textarea>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="isAdmissionModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-semibold">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold shadow-xs">Save Application Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==========================================
         MODAL 6: ADD NEW TESTIMONIAL
         ========================================== -->
    <div x-show="isTestimonialModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-900/40 backdrop-blur-xs">
        <div @click.away="isTestimonialModalOpen = false" class="bg-white rounded-3xl p-5 sm:p-6 w-full max-w-lg border border-slate-200 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Add Student Testimonial</h3>
                    <p class="text-xs text-slate-500">Publish graduate reviews on the public homepage with photo and rating.</p>
                </div>
                <button type="button" @click="isTestimonialModalOpen = false" class="text-slate-400 hover:text-slate-600 text-lg">✕</button>
            </div>

            <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3 text-sm">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Student Full Name *</label>
                        <input type="text" name="name" required placeholder="e.g. Sumaiya Yasmin" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Trade / Course Program *</label>
                        <input type="text" name="course" required placeholder="e.g. Computer Office Application" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">District / Hub</label>
                        <input type="text" name="district" placeholder="e.g. Tangail District Hub" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Batch</label>
                        <input type="text" name="batch" placeholder="e.g. Batch 42" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Rating *</label>
                        <select name="rating" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold focus:ring-2 focus:ring-emerald-500">
                            <option value="5">★★★★★ (5 Stars)</option>
                            <option value="4">★★★★☆ (4 Stars)</option>
                            <option value="3">★★★☆☆ (3 Stars)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Student Feedback Quote *</label>
                    <textarea name="quote" rows="3" required placeholder="Before enrolling at Saikat Computer & Training Jubo Songhoton..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-center">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Upload Student Photo (Optional)</label>
                        <input type="file" name="avatar_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Or Photo URL (Optional)</label>
                        <input type="text" name="avatar" placeholder="Leave blank for no photo" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono text-xs focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="isTestimonialModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-semibold">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold shadow-xs">Publish Testimonial</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==========================================
         MODAL 7: EDIT TESTIMONIAL
         ========================================== -->
    <div x-show="isEditTestimonialModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-900/40 backdrop-blur-xs">
        <div @click.away="isEditTestimonialModalOpen = false" class="bg-white rounded-3xl p-5 sm:p-6 w-full max-w-lg border border-slate-200 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Edit Student Testimonial</h3>
                    <p class="text-xs text-slate-500">Update feedback text, rating, or replace the alumni photo.</p>
                </div>
                <button type="button" @click="isEditTestimonialModalOpen = false" class="text-slate-400 hover:text-slate-600 text-lg">✕</button>
            </div>

            <form :action="'/admin/testimonials/' + editingTestimonial.id + '/update'" method="POST" enctype="multipart/form-data" class="space-y-3 text-sm">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Student Full Name *</label>
                        <input type="text" name="name" :value="editingTestimonial.name" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Trade / Course Program *</label>
                        <input type="text" name="course" :value="editingTestimonial.course" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">District / Hub</label>
                        <input type="text" name="district" :value="editingTestimonial.district" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Batch</label>
                        <input type="text" name="batch" :value="editingTestimonial.batch" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Rating *</label>
                        <select name="rating" x-model="editingTestimonial.rating" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold focus:ring-2 focus:ring-emerald-500">
                            <option value="5">★★★★★ (5 Stars)</option>
                            <option value="4">★★★★☆ (4 Stars)</option>
                            <option value="3">★★★☆☆ (3 Stars)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Student Feedback Quote *</label>
                    <textarea name="quote" rows="3" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500" x-text="editingTestimonial.quote"></textarea>
                </div>

                <div class="space-y-2.5 p-3 rounded-2xl bg-slate-50 border border-slate-200/80">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-center">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Upload Photo (Optional)</label>
                            <input type="file" name="avatar_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Or Photo URL (Optional)</label>
                            <input type="text" name="avatar" x-model="editingTestimonial.avatar" placeholder="Leave blank for no photo" :disabled="removeTestimonialAvatar" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono text-xs bg-white disabled:bg-slate-100 focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>
                    <template x-if="editingTestimonial.avatar">
                        <label class="inline-flex items-center gap-2 text-xs font-semibold text-rose-600 cursor-pointer select-none pt-1">
                            <input type="checkbox" name="remove_avatar" value="1" x-model="removeTestimonialAvatar" class="w-4 h-4 text-rose-600 rounded">
                            <span>Remove current photo</span>
                        </label>
                    </template>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="isEditTestimonialModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-semibold">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold shadow-xs">Update Testimonial</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==========================================
         MODAL 8: ADD NEW HERO SLIDE
         ========================================== -->
    <div x-show="isHeroSlideModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-900/40 backdrop-blur-xs">
        <div @click.away="isHeroSlideModalOpen = false" class="bg-white rounded-3xl p-5 sm:p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-slate-200 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Add New Hero Carousel Slide</h3>
                    <p class="text-xs text-slate-500">Configure slide background image, headlines, badges, and call-to-action buttons.</p>
                </div>
                <button type="button" @click="isHeroSlideModalOpen = false" class="text-slate-400 hover:text-slate-600 text-lg">✕</button>
            </div>

            <form action="{{ route('admin.hero_slides.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3 text-sm">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Badge Tag</label>
                        <input type="text" name="badge" placeholder="e.g. Govt Accredited Institute" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Duration Tag</label>
                        <input type="text" name="duration" placeholder="e.g. Year-Round Programs" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Highlight Badge</label>
                        <input type="text" name="highlight" placeholder="e.g. 100% Certified Diplomas" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Slide Main Headline Title *</label>
                    <input type="text" name="title" required placeholder="e.g. Empowering National Youth Through Technical Mastery" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-bold focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Slide Subtitle Paragraph *</label>
                    <textarea name="subtitle" rows="2" required placeholder="Transforming potential into professional excellence..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-center">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Upload Background Photo</label>
                        <input type="file" name="bg_image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Or Direct Photo URL</label>
                        <input type="text" name="bg_image" placeholder="https://images.unsplash.com/..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono text-xs focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Btn 1 Text</label>
                            <input type="text" name="btn1_text" value="Explore Programs" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Btn 1 Link</label>
                            <input type="text" name="btn1_link" value="/courses" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-mono text-xs">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Btn 2 Text</label>
                            <input type="text" name="btn2_text" value="Apply for Admission" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Btn 2 Link</label>
                            <input type="text" name="btn2_link" value="/register" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-mono text-xs">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Sort Order</label>
                        <input type="number" name="order" value="1" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono text-xs focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div class="flex items-center gap-2 pt-6">
                        <input type="checkbox" name="is_active" id="slide_active_new" value="1" checked class="w-4 h-4 text-emerald-600 rounded">
                        <label for="slide_active_new" class="text-xs font-semibold text-slate-700 cursor-pointer">Active in Homepage Slider</label>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="isHeroSlideModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-semibold">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold shadow-xs">Publish Slide</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==========================================
         MODAL 9: EDIT HERO SLIDE
         ========================================== -->
    <div x-show="isEditHeroSlideModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-900/40 backdrop-blur-xs">
        <div @click.away="isEditHeroSlideModalOpen = false" class="bg-white rounded-3xl p-5 sm:p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-slate-200 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Edit Hero Carousel Slide</h3>
                    <p class="text-xs text-slate-500">Update slide headlines, background wallpaper, CTA buttons, or toggle visibility.</p>
                </div>
                <button type="button" @click="isEditHeroSlideModalOpen = false" class="text-slate-400 hover:text-slate-600 text-lg">✕</button>
            </div>

            <form :action="'/admin/hero-slides/' + editingHeroSlide.id + '/update'" method="POST" enctype="multipart/form-data" class="space-y-3 text-sm">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Badge Tag</label>
                        <input type="text" name="badge" :value="editingHeroSlide.badge" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Duration Tag</label>
                        <input type="text" name="duration" :value="editingHeroSlide.duration" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Highlight Badge</label>
                        <input type="text" name="highlight" :value="editingHeroSlide.highlight" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Slide Main Headline Title *</label>
                    <input type="text" name="title" :value="editingHeroSlide.title" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-bold focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Slide Subtitle Paragraph *</label>
                    <textarea name="subtitle" rows="2" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500" x-text="editingHeroSlide.subtitle"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-center">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Upload New Background Photo</label>
                        <input type="file" name="bg_image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Or Photo URL</label>
                        <input type="text" name="bg_image" :value="editingHeroSlide.bg_image" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono text-xs focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Btn 1 Text</label>
                            <input type="text" name="btn1_text" :value="editingHeroSlide.btn1_text" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Btn 1 Link</label>
                            <input type="text" name="btn1_link" :value="editingHeroSlide.btn1_link" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-mono text-xs">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Btn 2 Text</label>
                            <input type="text" name="btn2_text" :value="editingHeroSlide.btn2_text" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Btn 2 Link</label>
                            <input type="text" name="btn2_link" :value="editingHeroSlide.btn2_link" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-mono text-xs">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Sort Order</label>
                        <input type="number" name="order" :value="editingHeroSlide.order" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-mono text-xs focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div class="flex items-center gap-2 pt-6">
                        <input type="checkbox" name="is_active" id="slide_active_edit" value="1" :checked="editingHeroSlide.is_active" class="w-4 h-4 text-emerald-600 rounded">
                        <label for="slide_active_edit" class="text-xs font-semibold text-slate-700 cursor-pointer">Active in Homepage Slider</label>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="isEditHeroSlideModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-semibold">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold shadow-xs">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==========================================
         GLOBAL CUSTOM MODAL: CONFIRM DELETE
         (REPLACES UGLY BROWSER CONFIRM DIALOG)
         ========================================== -->
    <div 
        x-show="isDeleteConfirmOpen" 
        x-cloak 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs transition-opacity"
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div 
            @click.away="closeDeleteModal()" 
            class="bg-white rounded-3xl p-6 sm:p-7 w-full max-w-md border border-slate-200 shadow-2xl space-y-5 text-center transform transition-all"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
        >
            <!-- Warning Icon Badge -->
            <div class="mx-auto w-14 h-14 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 text-2xl shadow-xs">
                <i class="fa-solid fa-trash-can"></i>
            </div>

            <!-- Modal Body -->
            <div class="space-y-2">
                <h3 class="text-xl font-bold text-slate-900">Confirm Record Deletion</h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                    Are you sure you want to permanently delete this <span class="font-bold text-slate-700" x-text="deleteItemType"></span> from the database?
                </p>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-xs sm:text-sm font-bold text-slate-800 break-words" x-text="deleteItemTitle"></div>
                <p class="text-xs text-rose-600 font-semibold flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-circle-exclamation text-xs"></i>
                    <span>This action is immediate and cannot be undone.</span>
                </p>
            </div>

            <!-- Action Buttons -->
            <form :action="deleteTargetUrl" method="POST" class="flex items-center justify-center gap-3 pt-2">
                @csrf
                <button 
                    type="button" 
                    @click="closeDeleteModal()" 
                    class="w-1/2 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs sm:text-sm transition"
                >
                    Cancel
                </button>
                <button 
                    type="submit" 
                    class="w-1/2 px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs sm:text-sm transition shadow-xs flex items-center justify-center gap-2"
                >
                    <i class="fa-solid fa-trash-can text-xs"></i>
                    <span>Yes, Delete</span>
                </button>
            </form>
        </div>
    </div>

</body>
</html>
