@extends('layouts.app')

@section('title', $course->title . ' - National Youth Dev')

@section('content')
<div class="bg-[#F8FAFC] min-h-screen pb-20">
    
    <!-- Top Banner: 100% Responsive Matching Next.js CourseDetailPage -->
    <div class="bg-slate-900 text-white border-b border-slate-800">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-14 py-8 sm:py-12 lg:py-16">
            
            <!-- Breadcrumb -->
            <nav class="flex flex-wrap items-center gap-2 text-xs sm:text-sm md:text-base font-semibold text-slate-400 mb-6 sm:mb-8">
                <a href="{{ route('home') }}" class="hover:text-white transition shrink-0">Home</a>
                <span>/</span>
                <a href="{{ route('courses.index') }}" class="hover:text-white transition shrink-0">Courses</a>
                <span>/</span>
                <span class="text-emerald-400 break-words">{{ $course->title }}</span>
            </nav>

            <div class="max-w-4xl">
                <!-- Badges -->
                <div class="flex flex-wrap items-center gap-2.5 sm:gap-3 mb-5">
                    <span class="text-xs sm:text-sm font-bold px-4 py-1.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">
                        {{ $course->category }}
                    </span>
                    <span class="text-xs sm:text-sm font-bold px-4 py-1.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-400/30 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-pulse"></span>
                        <span>{{ $course->seats_remaining ?? $course->seats }} Seats Left in Batch 2026</span>
                    </span>
                    @if($course->badge)
                        <span class="text-xs sm:text-sm font-bold px-4 py-1.5 rounded-full bg-blue-500/20 text-blue-300 border border-blue-400/30">
                            {{ $course->badge }}
                        </span>
                    @endif
                </div>

                <!-- Course Title -->
                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white tracking-tight leading-tight mb-5">
                    {{ $course->title }}
                </h1>

                <!-- Short Description -->
                <p class="text-base sm:text-lg md:text-xl text-slate-300 leading-relaxed font-normal">
                    {{ $course->short_description ?? $course->overview }}
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content Layout: 100% Responsive Grid -->
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-14 py-8 sm:py-12 lg:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            
            <!-- Left Column (7 Cols on desktop): Syllabus, Outcomes, Details -->
            <div class="lg:col-span-7 space-y-8 sm:space-y-10">
                
                <!-- Overview Card -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 md:p-10 border border-slate-200/90 shadow-xs">
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-slate-900 mb-5 flex items-center gap-3">
                        <i class="fa-solid fa-book-open text-emerald-600 shrink-0"></i>
                        <span>Program Comprehensive Overview</span>
                    </h2>
                    <p class="text-base sm:text-lg text-slate-700 leading-relaxed font-normal whitespace-pre-line">
                        {{ $course->overview }}
                    </p>
                </div>

                <!-- Learning Outcomes -->
                @if(!empty($course->learning_outcomes) && is_array($course->learning_outcomes))
                    <div class="bg-white rounded-3xl p-6 sm:p-8 md:p-10 border border-slate-200/90 shadow-xs">
                        <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                            <i class="fa-solid fa-circle-check text-emerald-600 shrink-0"></i>
                            <span>Core Competencies & Learning Outcomes</span>
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($course->learning_outcomes as $outcome)
                                <div class="flex items-start gap-3.5 p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-100 hover:border-emerald-200 transition">
                                    <i class="fa-solid fa-circle-check text-emerald-600 shrink-0 mt-1"></i>
                                    <span class="text-sm sm:text-base font-medium text-slate-800 leading-snug">
                                        {{ $outcome }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Complete Syllabus Breakdown (Modules) -->
                @if(!empty($course->curriculum) && is_array($course->curriculum))
                    <div class="bg-white rounded-3xl p-6 sm:p-8 md:p-10 border border-slate-200/90 shadow-xs">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                            <div>
                                <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-slate-900 flex items-center gap-3">
                                    <i class="fa-solid fa-award text-emerald-600 shrink-0"></i>
                                    <span>Curriculum & Modular Syllabus</span>
                                </h2>
                                <p class="text-sm sm:text-base text-slate-500 mt-1.5 font-medium">
                                    Total {{ $course->total_hours ?? 360 }} Practical Hours of Lab Practice & Applied Theory
                                </p>
                            </div>
                            <span class="text-xs sm:text-sm md:text-base font-bold text-slate-700 bg-slate-100 px-4 py-2 rounded-2xl border border-slate-200 self-start sm:self-auto">
                                {{ count($course->curriculum) }} Modules
                            </span>
                        </div>

                        <div class="space-y-5">
                            @foreach($course->curriculum as $index => $mod)
                                <div class="rounded-2xl border border-slate-200 overflow-hidden shadow-2xs">
                                    <div class="bg-slate-50/90 px-5 sm:px-7 py-4 border-b border-slate-200 flex flex-wrap items-center justify-between gap-3">
                                        <div class="flex items-center gap-3.5">
                                            <span class="w-9 h-9 rounded-xl bg-emerald-600 text-white font-bold text-sm sm:text-base flex items-center justify-center shrink-0">
                                                0{{ $index + 1 }}
                                            </span>
                                            <span class="text-base sm:text-lg md:text-xl font-bold text-slate-900">
                                                {{ $mod['title'] ?? $mod }}
                                            </span>
                                        </div>
                                        @if(isset($mod['hours']))
                                            <span class="text-xs sm:text-sm font-bold text-slate-600 bg-white px-3 py-1 rounded-xl border border-slate-200/80 shrink-0">
                                                {{ $mod['hours'] }} Hours
                                            </span>
                                        @endif
                                    </div>
                                    @if(isset($mod['topics']) && is_array($mod['topics']) && count($mod['topics']) > 0)
                                        <div class="p-5 sm:p-7 bg-white">
                                            <ul class="space-y-3">
                                                @foreach($mod['topics'] as $topic)
                                                    <li class="flex items-start gap-3.5 text-sm sm:text-base text-slate-700 leading-relaxed font-normal">
                                                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shrink-0 mt-2"></span>
                                                        <span>{{ $topic }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Target Career Paths -->
                @if(!empty($course->career_opportunities) && is_array($course->career_opportunities))
                    <div class="bg-white rounded-3xl p-6 sm:p-8 md:p-10 border border-slate-200/90 shadow-xs">
                        <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-slate-900 mb-5 flex items-center gap-3">
                            <i class="fa-solid fa-briefcase text-emerald-600 shrink-0"></i>
                            <span>Target Career Paths & Self-Employment</span>
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($course->career_opportunities as $career)
                                <div class="p-4 sm:p-5 rounded-2xl bg-emerald-50/70 border border-emerald-200/70 flex items-center gap-3.5">
                                    <span class="w-3 h-3 rounded-full bg-emerald-600 shrink-0"></span>
                                    <span class="text-sm sm:text-base font-semibold text-emerald-950 leading-snug">
                                        {{ $career }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            <!-- Right Column (5 Cols on desktop): Sticky on Large Screens -->
            <div class="lg:col-span-5 lg:sticky lg:top-24 space-y-6 w-full">
                
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xl overflow-hidden">
                    <!-- Thumbnail Container -->
                    <div class="relative h-60 sm:h-72 w-full bg-slate-900">
                        <img 
                            src="{{ $course->image ?? 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=800&auto=format&fit=crop' }}" 
                            alt="{{ $course->title }}"
                            class="w-full h-full object-cover"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent pointer-events-none"></div>
                        <div class="absolute bottom-4 left-5 right-5 flex items-center justify-between text-white pointer-events-none">
                            <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-emerald-400">Official Certification</span>
                            <span class="text-xs sm:text-sm font-bold bg-white/20 backdrop-blur-md px-3.5 py-1 rounded-xl">Batch 2026</span>
                        </div>
                    </div>

                    <!-- Pricing Header -->
                    <div class="p-6 sm:p-8 md:p-9">
                        <div class="mb-6 pb-6 border-b border-slate-100">
                            <span class="text-xs sm:text-sm text-slate-500 font-bold uppercase tracking-wider block">Official Training Fee</span>
                            <div class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-900 mt-1 leading-tight break-words">
                                {{ $course->fee }}
                            </div>
                            <div class="text-xs sm:text-sm md:text-base text-emerald-600 font-bold mt-2 flex items-center gap-2">
                                <i class="fa-solid fa-circle-check text-emerald-600 shrink-0"></i>
                                <span>No Hidden Exam, Lab or Certificate Charges</span>
                            </div>
                        </div>

                        <!-- Key Facts Stacked Cards -->
                        <div class="space-y-3.5 sm:space-y-4 mb-8">
                            <!-- Duration -->
                            <div class="flex items-start gap-4 p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-100">
                                <i class="fa-regular fa-clock text-emerald-600 text-xl shrink-0 mt-0.5"></i>
                                <div class="flex-1 min-w-0">
                                    <span class="text-xs sm:text-sm font-medium text-slate-500 uppercase tracking-wider block">Duration & Hours</span>
                                    <span class="text-base sm:text-lg font-bold text-slate-900 leading-snug mt-0.5 block break-words">
                                        {{ $course->duration }} ({{ $course->total_hours ?? 360 }} Practical Hours)
                                    </span>
                                </div>
                            </div>

                            <!-- Schedule -->
                            <div class="flex items-start gap-4 p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-100">
                                <i class="fa-regular fa-calendar text-blue-600 text-xl shrink-0 mt-0.5"></i>
                                <div class="flex-1 min-w-0">
                                    <span class="text-xs sm:text-sm font-medium text-slate-500 uppercase tracking-wider block">Class Schedule</span>
                                    <span class="text-base sm:text-lg font-bold text-slate-900 leading-snug mt-0.5 block break-words">
                                        {{ $course->schedule ?? 'Friday & Saturday (Morning & Evening Batches)' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Eligibility -->
                            <div class="flex items-start gap-4 p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-100">
                                <i class="fa-solid fa-graduation-cap text-purple-600 text-xl shrink-0 mt-0.5"></i>
                                <div class="flex-1 min-w-0">
                                    <span class="text-xs sm:text-sm font-medium text-slate-500 uppercase tracking-wider block">Minimum Eligibility</span>
                                    <span class="text-base sm:text-lg font-bold text-slate-900 leading-snug mt-0.5 block break-words">
                                        {{ $course->prerequisites ?? 'Minimum SSC or Equivalent (Any Discipline)' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Batch Seats -->
                            <div class="flex items-start gap-4 p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-100">
                                <i class="fa-solid fa-users text-amber-600 text-xl shrink-0 mt-0.5"></i>
                                <div class="flex-1 min-w-0">
                                    <span class="text-xs sm:text-sm font-medium text-slate-500 uppercase tracking-wider block">Batch Seats Availability</span>
                                    <span class="text-base sm:text-lg font-bold text-slate-900 leading-snug mt-0.5 block break-words">
                                        {{ $course->seats_remaining ?? 8 }} of {{ $course->seats }} Remaining (Admissions Closing Soon)
                                    </span>
                                </div>
                            </div>

                            <!-- Available Centers -->
                            <div class="flex items-start gap-4 p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-100">
                                <i class="fa-solid fa-map-pin text-rose-600 text-xl shrink-0 mt-0.5"></i>
                                <div class="flex-1 min-w-0">
                                    <span class="text-xs sm:text-sm font-medium text-slate-500 uppercase tracking-wider block">Available Training Hubs</span>
                                    <span class="text-base sm:text-lg font-bold text-slate-900 leading-snug mt-0.5 block break-words">
                                        {{ $course->centers ?? 'Available across all 64 District Regional Hubs' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-3.5">
                            <a 
                                href="{{ route('register', ['trade' => $course->title]) }}" 
                                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-base sm:text-lg py-4 rounded-2xl transition duration-200 shadow-xl shadow-emerald-600/25 flex items-center justify-center gap-2.5 group"
                            >
                                <span>Apply for Online Admission</span>
                                <i class="fa-solid fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                            </a>
                            <a 
                                href="{{ route('contact.index') }}" 
                                class="w-full bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-sm sm:text-base py-3.5 rounded-2xl transition flex items-center justify-center gap-2.5"
                            >
                                <i class="fa-solid fa-headset text-slate-600"></i>
                                <span>Consult Admission Officer</span>
                            </a>
                        </div>
                    </div>

                    <!-- Verified Certificate Footer -->
                    <div class="bg-slate-50 px-6 sm:px-8 py-4.5 border-t border-slate-100 flex items-center gap-3.5">
                        <i class="fa-solid fa-shield-halved text-emerald-600 text-xl shrink-0"></i>
                        <div class="text-xs sm:text-sm text-slate-700 leading-snug">
                            Graduates receive a <strong>Nationally Verified Technical Diploma</strong> with digital QR validation.
                        </div>
                    </div>
                </div>

                <!-- Helpline Advisory Box -->
                <div class="bg-slate-900 text-white p-6 sm:p-8 rounded-3xl border border-slate-800 shadow-lg">
                    <div class="flex items-center gap-3.5 mb-3">
                        <div class="w-11 h-11 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0 border border-emerald-400/20 text-lg">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <div class="text-sm sm:text-base font-bold text-white">Need Guidance on Choosing a Trade?</div>
                            <div class="text-xs sm:text-sm text-slate-400">Speak directly to an academic career advisor</div>
                        </div>
                    </div>
                    <p class="text-xs sm:text-sm md:text-base text-slate-300 leading-relaxed mt-3">
                        Call our national technical hotline at <strong class="text-emerald-400 font-mono text-base sm:text-lg">{{ $helplinePhone ?? '+880 1712-345678' }}</strong> (Saturday – Thursday, 9 AM – 5 PM).
                    </p>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
