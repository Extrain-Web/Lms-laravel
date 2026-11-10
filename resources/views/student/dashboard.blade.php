<!DOCTYPE html>
<html lang="en" class="h-full bg-[#F8FAFC]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Learning Portal - {{ $settings['footerBrandTitle'] }}</title>
    <link rel="icon" type="image/png" href="/favicon.png?v=2">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico?v=2">
    <link rel="apple-touch-icon" href="/favicon.png?v=2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', '"Hind Siliguri"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        @media print {
            .no-print { display: none !important; }
            body { background: #ffffff !important; }
        }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-800 flex flex-col justify-between" x-data="{ 
    activeTab: '{{ $activeTab }}',
    isAdmitModalOpen: false
}">

    @php
        $verifyUrl = !empty($displayRoll) ? route('results.index', ['roll_no' => $displayRoll]) : route('results.index');
        $qrSrc = ($studentResult && !empty($studentResult->qr_url))
            ? $studentResult->qr_url
            : ('https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($verifyUrl));
        $branchLabel = $studentResult->center ?? ($admission->district ?? $settings['instituteName']);
        $sessionLabel = $studentResult->session ?? $settings['currentSession'];
    @endphp

    <!-- Student Portal Header Bar -->
    <header class="bg-slate-950 text-white border-b border-slate-800 sticky top-0 z-40 no-print">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 py-3.5 flex items-center justify-between gap-3">
            
            <a href="{{ route('home') }}" class="flex items-center gap-3 min-w-0">
                @if(!empty($settings['headerLogoImage']))
                    <img src="{{ $settings['headerLogoImage'] }}" alt="{{ $settings['headerLogoText'] }}" class="h-10 w-auto max-w-[110px] object-contain rounded-xl bg-white/10 p-1 shrink-0">
                @else
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white font-black text-sm shadow-xs shrink-0">
                        {{ $settings['headerLogoText'] }}
                    </div>
                @endif
                <div class="flex flex-col min-w-0">
                    <span class="text-sm sm:text-base font-extrabold tracking-tight text-white leading-tight flex items-center gap-2 truncate">
                        <span class="truncate">Student Learning Portal</span>
                        <span class="hidden sm:inline-block bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 text-[10px] px-2 py-0.5 rounded-full font-mono uppercase font-black shrink-0">
                            Trainee
                        </span>
                    </span>
                    <span class="text-[11px] sm:text-xs text-slate-400 font-medium truncate">
                        {{ $settings['instituteName'] }}
                    </span>
                </div>
            </a>

            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                @if($user->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="hidden md:flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-600/20 border border-emerald-500/40 text-emerald-300 hover:bg-emerald-600/30 text-xs font-bold transition">
                        <i class="fa-solid fa-sliders text-xs"></i>
                        <span>Back to Admin</span>
                    </a>
                @endif

                <a
                    href="{{ route('home') }}"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-900 border border-slate-700/80 text-slate-300 hover:text-white hover:bg-slate-800 text-xs font-bold transition"
                    title="View Public Website"
                >
                    <i class="fa-solid fa-arrow-up-right-from-square text-emerald-400 text-xs"></i>
                    <span class="hidden sm:inline">Public Portal</span>
                </a>

                <div class="flex items-center gap-2.5 pl-2.5 sm:pl-3 border-l border-slate-800">
                    @if($studentResult && !empty($studentResult->photo))
                        <img src="{{ $studentResult->photo }}" alt="{{ $studentName }}" class="w-8 h-8 rounded-full object-cover object-top border border-emerald-400/60 shrink-0">
                    @else
                        <div class="w-8 h-8 rounded-full bg-emerald-600 text-white font-black flex items-center justify-center text-xs shadow-inner shrink-0">
                            {{ $userInitials }}
                        </div>
                    @endif
                    <div class="hidden md:flex flex-col text-left leading-tight">
                        <span class="text-xs font-bold text-slate-100 max-w-[140px] truncate">{{ $studentName }}</span>
                        <span class="text-[10px] text-emerald-400 font-mono">
                            {{ $displayRoll ?? $user->email }}
                        </span>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="inline m-0">
                    @csrf
                    <button
                        type="submit"
                        class="p-2 rounded-xl text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 transition cursor-pointer"
                        title="Logout"
                    >
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </button>
                </form>
            </div>

        </div>
    </header>

    <!-- Main Student Shell -->
    <main class="max-w-[1240px] w-full mx-auto px-4 sm:px-8 py-6 sm:py-8 space-y-6 sm:space-y-8 flex-1" :class="isAdmitModalOpen ? 'no-print' : ''">
        
        <!-- Welcome Student Banner -->
        <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-emerald-950 text-white rounded-3xl p-6 sm:p-8 shadow-xl border border-slate-800 relative overflow-hidden no-print">
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4 min-w-0">
                    @if($studentResult && !empty($studentResult->photo))
                        <img src="{{ $studentResult->photo }}" alt="{{ $studentName }}" class="w-16 h-20 sm:w-20 sm:h-24 rounded-2xl object-cover object-top border-2 border-emerald-400/50 bg-slate-900 shadow-lg shrink-0">
                    @endif
                    <div class="space-y-2 min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 text-[11px] font-extrabold uppercase tracking-wider">
                                @if($studentResult)
                                    Result Published &amp; Verified
                                @elseif($admission)
                                    {{ $admission->status }} Trainee
                                @else
                                    Registered Student Account
                                @endif
                            </span>
                            @if($user->isAdmin())
                                <span class="px-2.5 py-1 rounded-full bg-amber-500/20 border border-amber-400/40 text-amber-300 text-[10px] font-bold uppercase tracking-wider">
                                    Admin Preview Mode
                                </span>
                            @endif
                            <span class="text-xs text-slate-300 font-medium">{{ $sessionLabel }}</span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-black text-white leading-tight truncate">
                            {{ $studentName }}
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                            @if($tradeName)
                                Enrolled Program: <strong class="text-emerald-400">{{ $tradeName }}</strong>
                                @if($enrolledCourse && !empty($enrolledCourse->duration))
                                    ({{ $enrolledCourse->duration }})
                                @endif
                                • {{ $branchLabel }}
                            @else
                                Welcome to your Student Learning Portal at <strong class="text-emerald-400">{{ $settings['instituteName'] }}</strong>.
                            @endif
                        </p>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/15 space-y-2 shrink-0 text-xs min-w-[240px]">
                    <div class="flex justify-between gap-6">
                        <span class="text-slate-300">Roll No:</span>
                        <span class="font-mono font-bold text-white">{{ $displayRoll ?? 'Pending Assignment' }}</span>
                    </div>
                    <div class="flex justify-between gap-6">
                        <span class="text-slate-300">Registration:</span>
                        <span class="font-mono font-bold text-white">{{ $studentResult->reg_no ?? 'Pending Issuance' }}</span>
                    </div>
                    <div class="flex justify-between gap-6">
                        <span class="text-slate-300">Academic Result:</span>
                        @if($studentResult)
                            <span class="font-bold text-emerald-400">GPA {{ number_format($studentResult->gpa, 2) }} ({{ $studentResult->grade }})</span>
                        @else
                            <span class="font-bold text-amber-300">Not Published Yet</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Navigation Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 no-print border-b border-slate-200">
            <button
                type="button"
                @click="activeTab = 'courses'"
                :class="activeTab === 'courses' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                class="flex items-center gap-2 px-4 sm:px-5 py-2.5 sm:py-3 rounded-2xl font-bold text-xs sm:text-sm transition shrink-0 cursor-pointer"
            >
                <i class="fa-solid fa-book-open text-emerald-500"></i>
                <span>Overview &amp; My Course</span>
            </button>

            <button
                type="button"
                @click="activeTab = 'marksheet'"
                :class="activeTab === 'marksheet' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                class="flex items-center gap-2 px-4 sm:px-5 py-2.5 sm:py-3 rounded-2xl font-bold text-xs sm:text-sm transition shrink-0 cursor-pointer"
            >
                <i class="fa-solid fa-award text-emerald-500"></i>
                <span>Marksheet &amp; Transcript</span>
            </button>

            <button
                type="button"
                @click="activeTab = 'exams'"
                :class="activeTab === 'exams' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                class="flex items-center gap-2 px-4 sm:px-5 py-2.5 sm:py-3 rounded-2xl font-bold text-xs sm:text-sm transition shrink-0 cursor-pointer"
            >
                <i class="fa-solid fa-folder-open text-emerald-500"></i>
                <span>Admit Card &amp; Resources</span>
            </button>

            <button
                type="button"
                @click="activeTab = 'idcard'"
                :class="activeTab === 'idcard' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                class="flex items-center gap-2 px-4 sm:px-5 py-2.5 sm:py-3 rounded-2xl font-bold text-xs sm:text-sm transition shrink-0 cursor-pointer"
            >
                <i class="fa-solid fa-id-card text-emerald-500"></i>
                <span>Digital Trainee ID Card</span>
            </button>
        </div>

        <!-- TAB 1: OVERVIEW & MY COURSE -->
        <div x-show="activeTab === 'courses'" class="space-y-6 no-print">

            <!-- Quick Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs space-y-1.5">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Trade / Program</span>
                    <p class="text-sm font-extrabold text-slate-900 leading-snug">{{ $tradeName ?? 'Not Assigned Yet' }}</p>
                    @if($studentResult && !empty($studentResult->course_code))
                        <span class="inline-block text-[11px] font-mono font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">Code: {{ $studentResult->course_code }}</span>
                    @endif
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs space-y-1.5">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Duration &amp; Level</span>
                    <p class="text-sm font-extrabold text-slate-900">{{ $enrolledCourse->duration ?? 'Official Batch Track' }}</p>
                    <span class="text-xs text-slate-500 block">{{ $enrolledCourse->level ?? 'Accredited Training' }}</span>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs space-y-1.5">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Academic Standing</span>
                    @if($studentResult)
                        <p class="text-base font-black text-emerald-700">GPA {{ number_format($studentResult->gpa, 2) }} ({{ $studentResult->grade }})</p>
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700">
                            <i class="fa-solid fa-circle-check"></i> {{ $studentResult->verification_status ?? 'VERIFIED & AUTHENTIC' }}
                        </span>
                    @else
                        <p class="text-sm font-extrabold text-amber-600">In Training / Pending</p>
                        <span class="text-xs text-slate-500 block">Result awaits publication</span>
                    @endif
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs space-y-1.5">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Campus / Center</span>
                    <p class="text-sm font-extrabold text-slate-900 leading-snug">{{ $branchLabel }}</p>
                    <span class="text-xs text-slate-500 block">Session: {{ $sessionLabel }}</span>
                </div>
            </div>

            <!-- Student Profile Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs space-y-4">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-lg sm:text-xl font-black text-slate-900">Student Profile &amp; Account Information</h2>
                        <p class="text-xs text-slate-500">Official trainee record synchronized with the central platform database.</p>
                    </div>
                    @if($studentResult)
                        <button type="button" @click="activeTab = 'marksheet'" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition flex items-center gap-1.5 cursor-pointer">
                            <i class="fa-solid fa-award"></i>
                            <span>View Transcript</span>
                        </button>
                    @endif
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-xs sm:text-sm">
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70">
                        <span class="text-[11px] font-bold uppercase text-slate-400 block">Full Name</span>
                        <strong class="text-slate-900">{{ $studentName }}</strong>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70">
                        <span class="text-[11px] font-bold uppercase text-slate-400 block">Official Roll Number</span>
                        <strong class="font-mono text-slate-900">{{ $displayRoll ?? 'Pending Assignment' }}</strong>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70">
                        <span class="text-[11px] font-bold uppercase text-slate-400 block">Account Email / Phone</span>
                        <strong class="text-slate-900 break-all">{{ $admission->email ?? $user->email }}</strong>
                        @if(!empty($user->phone) || !empty($admission->phone))
                            <span class="block text-xs text-slate-500 mt-0.5">{{ $user->phone ?? $admission->phone }}</span>
                        @endif
                    </div>
                    @if($studentResult && !empty($studentResult->father_name) && $studentResult->father_name !== '-')
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70">
                            <span class="text-[11px] font-bold uppercase text-slate-400 block">Father's Name</span>
                            <strong class="text-slate-900">{{ $studentResult->father_name }}</strong>
                        </div>
                    @endif
                    @if($studentResult && !empty($studentResult->mother_name) && $studentResult->mother_name !== '-')
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70">
                            <span class="text-[11px] font-bold uppercase text-slate-400 block">Mother's Name</span>
                            <strong class="text-slate-900">{{ $studentResult->mother_name }}</strong>
                        </div>
                    @endif
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70">
                        <span class="text-[11px] font-bold uppercase text-slate-400 block">Registration / Year</span>
                        <strong class="font-mono text-slate-900">
                            {{ $studentResult->reg_no ?? 'Pending Issuance' }}
                            @if($studentResult && !empty($studentResult->exam_year))
                                ({{ $studentResult->exam_year }})
                            @endif
                        </strong>
                    </div>
                </div>
            </div>

            <!-- Real Course Curriculum Modules from Database -->
            @if($enrolledCourse)
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                        <div class="space-y-1">
                            <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Assigned Course Syllabus</span>
                            <h2 class="text-xl sm:text-2xl font-black text-slate-900">{{ $enrolledCourse->title }}</h2>
                            @if(!empty($enrolledCourse->overview))
                                <p class="text-xs sm:text-sm text-slate-600 max-w-3xl leading-relaxed">{{ $enrolledCourse->overview }}</p>
                            @endif
                        </div>
                        <a href="{{ route('courses.show', $enrolledCourse->slug) }}" class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs flex items-center gap-2 shrink-0 transition">
                            <span>Full Course Details</span>
                            <i class="fa-solid fa-arrow-right text-[11px]"></i>
                        </a>
                    </div>

                    @if(!empty($enrolledCourse->curriculum) && is_array($enrolledCourse->curriculum))
                        <div class="space-y-3">
                            <h3 class="font-extrabold text-slate-900 text-xs sm:text-sm uppercase tracking-wider">Course Curriculum Modules</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($enrolledCourse->curriculum as $idx => $module)
                                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                                        <div class="flex items-start gap-2.5">
                                            <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white text-[11px] font-black flex items-center justify-center shrink-0 mt-0.5">
                                                {{ $idx + 1 }}
                                            </span>
                                            <h4 class="font-bold text-slate-900 text-sm leading-snug">
                                                {{ $module['title'] ?? ('Module ' . ($idx + 1)) }}
                                            </h4>
                                        </div>
                                        @if(!empty($module['topics']) && is_array($module['topics']))
                                            <ul class="space-y-1 pl-8 text-xs text-slate-600 list-disc">
                                                @foreach($module['topics'] as $topic)
                                                    <li>{{ $topic }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(!empty($enrolledCourse->certification))
                        <div class="p-4 rounded-2xl bg-emerald-50/70 border border-emerald-200 flex items-center gap-3 text-xs sm:text-sm text-emerald-950">
                            <i class="fa-solid fa-certificate text-emerald-600 text-lg shrink-0"></i>
                            <div>
                                <span class="font-bold block">Accredited Certification</span>
                                <span class="text-slate-700">{{ $enrolledCourse->certification }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            @elseif($availableCourses->isNotEmpty())
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs space-y-4">
                    <div class="flex items-center justify-between gap-2">
                        <div>
                            <h2 class="text-lg font-black text-slate-900">Available Accredited Courses</h2>
                            <p class="text-xs text-slate-500">Explore our vocational &amp; technical training programs.</p>
                        </div>
                        <a href="{{ route('courses.index') }}" class="text-xs font-bold text-emerald-700 hover:underline">View All Courses →</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                        @foreach($availableCourses as $c)
                            <a href="{{ route('courses.show', $c->slug) }}" class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/60 border border-slate-200 hover:border-emerald-300 transition flex items-start justify-between gap-3">
                                <div class="space-y-1">
                                    <span class="text-[10px] font-bold uppercase text-emerald-700">{{ $c->category }}</span>
                                    <h4 class="font-bold text-slate-900 text-sm">{{ $c->title }}</h4>
                                    <p class="text-xs text-slate-500">{{ $c->duration }} • {{ $c->fee }}</p>
                                </div>
                                <i class="fa-solid fa-arrow-right text-slate-400 text-xs mt-1"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- TAB 2: OFFICIAL MARKSHEET & TRANSCRIPT -->
        <div x-show="activeTab === 'marksheet'" class="space-y-6">
            @if($studentResult)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 no-print">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-black text-slate-900">Official Academic Transcript</h2>
                        <p class="text-xs sm:text-sm text-slate-500">Certified examination record verified against the central platform registry.</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2.5">
                        <button
                            type="button"
                            onclick="window.print()"
                            class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs sm:text-sm flex items-center gap-2 shadow-xs transition cursor-pointer"
                        >
                            <i class="fa-solid fa-print text-emerald-400"></i>
                            <span>Quick Print</span>
                        </button>
                        <a
                            href="{{ route('results.print', $studentResult->roll_no) }}"
                            target="_blank"
                            class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs sm:text-sm flex items-center gap-2 shadow-xs transition"
                        >
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            <span>Print A4 Transcript</span>
                        </a>
                        <a
                            href="{{ route('results.print', ['roll_no' => $studentResult->roll_no, 'download' => 1]) }}"
                            target="_blank"
                            class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm flex items-center gap-2 shadow-xs transition"
                        >
                            <i class="fa-solid fa-download"></i>
                            <span>Download PDF</span>
                        </a>
                    </div>
                </div>

                <!-- Marksheet Card -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-lg space-y-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-5 border-b border-slate-200 pb-5">
                        <div class="flex items-start gap-4">
                            @if(!empty($studentResult->photo))
                                <img src="{{ $studentResult->photo }}" alt="{{ $studentResult->student_name }}" class="w-16 h-20 rounded-xl object-cover object-top border border-slate-300 shrink-0">
                            @endif
                            <div class="space-y-1">
                                <span class="text-xs font-mono font-bold text-emerald-700">
                                    ROLL: {{ $studentResult->roll_no }} • REG: {{ $studentResult->reg_no }}
                                </span>
                                <h3 class="text-xl font-black text-slate-900">{{ $studentResult->student_name }}</h3>
                                <p class="text-xs text-slate-600 font-semibold">{{ $studentResult->trade }}</p>
                                <p class="text-xs text-slate-500">
                                    @if(!empty($studentResult->father_name) && $studentResult->father_name !== '-')
                                        Father: {{ $studentResult->father_name }} •
                                    @endif
                                    Session: {{ $studentResult->session }} ({{ $studentResult->exam_year }})
                                </p>
                            </div>
                        </div>

                        <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 text-left md:text-right shrink-0">
                            <span class="text-xs font-bold text-slate-500 block">Final Academic Result</span>
                            <span class="text-2xl font-black text-emerald-800 block mt-0.5">
                                @if(!empty($studentResult->result_score)){{ $studentResult->result_score }} | @endif
                                GPA {{ number_format($studentResult->gpa, 2) }} ({{ $studentResult->grade }})
                            </span>
                            <span class="text-[11px] font-extrabold text-emerald-700 block mt-0.5">
                                {{ $studentResult->verification_status ?? 'VERIFIED & AUTHENTIC' }}
                            </span>
                        </div>
                    </div>

                    @if(!empty($marksList) && $marksSummary)
                        <div class="space-y-2.5">
                            <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Subject-Wise Marksheet Details</h4>
                            <div class="overflow-x-auto border border-slate-200 rounded-2xl">
                                <table class="w-full min-w-[520px] text-left text-xs sm:text-sm">
                                    <thead class="bg-slate-900 text-white font-bold uppercase text-[11px]">
                                        <tr>
                                            <th class="py-3 px-4">Subject / Module</th>
                                            <th class="py-3 px-4 text-center">Full Marks</th>
                                            <th class="py-3 px-4 text-center">Obtained</th>
                                            <th class="py-3 px-4 text-center">Grade</th>
                                            <th class="py-3 px-4 text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 font-medium bg-white">
                                        @foreach($marksList as $sub)
                                            <tr class="hover:bg-slate-50">
                                                <td class="py-3 px-4 font-bold text-slate-900">{{ $sub['subject'] ?? $sub['name'] ?? '' }}</td>
                                                <td class="py-3 px-4 text-center font-mono text-slate-600">{{ $sub['fullMarks'] ?? 100 }}</td>
                                                <td class="py-3 px-4 text-center font-mono font-extrabold text-slate-900">{{ $sub['obtained'] ?? $sub['obtainedMarks'] ?? 0 }}</td>
                                                <td class="py-3 px-4 text-center font-black text-emerald-700">{{ $sub['grade'] ?? 'A+' }}</td>
                                                <td class="py-3 px-4 text-center">
                                                    <span class="text-[10px] font-black bg-emerald-50 text-emerald-800 px-2.5 py-0.5 rounded-md border border-emerald-300">PASSED</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-slate-900 text-white font-bold text-xs sm:text-sm">
                                        <tr>
                                            <td class="py-3.5 px-4">Total Academic Evaluation</td>
                                            <td class="py-3.5 px-4 text-center font-mono">{{ $marksSummary['full'] }}</td>
                                            <td class="py-3.5 px-4 text-center text-emerald-400 font-mono font-black">
                                                {{ $marksSummary['obtained'] }} ({{ $marksSummary['percentage'] }}%)
                                            </td>
                                            <td class="py-3.5 px-4 text-center text-emerald-400 font-black">
                                                GPA {{ number_format($studentResult->gpa, 2) }}
                                            </td>
                                            <td class="py-3.5 px-4 text-center text-emerald-400 font-black">PASSED</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 grid grid-cols-2 sm:grid-cols-4 gap-3 text-center text-xs">
                            <div>
                                <span class="text-slate-500 block font-semibold">Result / Score</span>
                                <strong class="text-base font-black text-slate-900">{{ $studentResult->result_score ?: 'Verified' }}</strong>
                            </div>
                            <div>
                                <span class="text-slate-500 block font-semibold">CGPA (4.00)</span>
                                <strong class="text-base font-black text-emerald-700">{{ number_format($studentResult->gpa, 2) }}</strong>
                            </div>
                            <div>
                                <span class="text-slate-500 block font-semibold">Letter Grade</span>
                                <strong class="text-base font-black text-slate-900">{{ $studentResult->grade }}</strong>
                            </div>
                            <div>
                                <span class="text-slate-500 block font-semibold">Evaluation</span>
                                <strong class="text-base font-black text-emerald-700">PASSED</strong>
                            </div>
                        </div>
                    @endif

                    <!-- Verification Footer -->
                    <div class="pt-4 border-t border-dashed border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                        <div class="flex items-center gap-3">
                            <img src="{{ $qrSrc }}" alt="QR" class="w-14 h-14 rounded-lg border border-slate-200 p-0.5 bg-white shrink-0">
                            <div>
                                <p class="font-bold text-slate-900">Central Registry Authenticated</p>
                                <p class="text-[11px] text-slate-500">Issue Date: {{ $studentResult->issue_date }} • {{ $branchLabel }}</p>
                            </div>
                        </div>
                        <div class="text-center sm:text-right">
                            <div class="font-bold text-slate-900">Controller of Examinations</div>
                            <span class="text-[11px] text-slate-500">{{ $settings['footerBrandTitle'] }}</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200 shadow-xs text-center space-y-3 no-print">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-amber-50 text-amber-600 border border-amber-200 flex items-center justify-center text-2xl">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">No Examination Result Published Yet</h3>
                    <p class="text-xs sm:text-sm text-slate-600 max-w-md mx-auto">
                        Once the Examination Directorate publishes your official result for Roll <span class="font-mono font-bold">{{ $displayRoll ?? 'Pending' }}</span>, your verified marksheet and A4 transcript will automatically appear here.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('results.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm transition">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <span>Search Verification Registry</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- TAB 3: ADMIT CARD & LEARNING RESOURCES -->
        <div x-show="activeTab === 'exams'" class="space-y-6 no-print">
            <!-- Admit Card Banner -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs space-y-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <span class="text-[11px] font-black text-emerald-700 uppercase tracking-wider">Official Trainee Document</span>
                        <h3 class="font-black text-slate-900 text-lg sm:text-xl mt-0.5">
                            Examination Admit Card ({{ $sessionLabel }})
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500">
                            Roll: <span class="font-mono font-bold text-slate-800">{{ $displayRoll ?? 'Pending' }}</span> • Center: {{ $branchLabel }}
                        </p>
                    </div>
                    <button
                        type="button"
                        @click="isAdmitModalOpen = true"
                        class="px-5 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm flex items-center justify-center gap-2 shrink-0 shadow-xs transition cursor-pointer"
                    >
                        <i class="fa-solid fa-id-card"></i>
                        <span>View &amp; Print Admit Card</span>
                    </button>
                </div>
            </div>

            <!-- Real Downloadable Resources from Admin CMS -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs space-y-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="font-black text-slate-900 text-lg">Official Notices, Syllabus &amp; Study Downloads</h3>
                        <p class="text-xs sm:text-sm text-slate-500">Latest circulars, exam schedules, curriculum handbooks, and official forms.</p>
                    </div>
                    <a href="{{ route('resources.index') }}" class="text-xs font-bold text-emerald-700 hover:underline shrink-0">Browse Full Archive →</a>
                </div>

                @if($resources->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                        @foreach($resources as $res)
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between gap-3">
                                <div class="min-w-0 space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-800 border border-emerald-200 text-[10px] font-bold uppercase">
                                            {{ $res->category }}
                                        </span>
                                        <span class="text-[10px] font-mono text-slate-400">
                                            {{ $res->file_type }} • {{ $res->file_size }}
                                        </span>
                                    </div>
                                    <h4 class="font-bold text-slate-900 text-xs sm:text-sm leading-snug truncate" title="{{ $res->title }}">
                                        {{ $res->title }}
                                    </h4>
                                </div>
                                @if(!empty($res->download_url) && $res->download_url !== '#')
                                    <a
                                        href="{{ $res->download_url }}"
                                        target="_blank"
                                        download
                                        class="px-3 py-2 rounded-xl bg-slate-900 hover:bg-emerald-600 text-white text-xs font-bold flex items-center gap-1.5 shrink-0 transition"
                                    >
                                        <i class="fa-solid fa-download text-[11px]"></i>
                                        <span>Download</span>
                                    </a>
                                @else
                                    <span class="px-3 py-2 rounded-xl bg-slate-100 text-slate-400 border border-slate-200 text-xs font-semibold flex items-center gap-1.5 shrink-0 cursor-not-allowed">
                                        <i class="fa-solid fa-clock text-[11px]"></i>
                                        <span>Pending File</span>
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-xs sm:text-sm text-slate-500">
                        No downloadable study materials or exam notices have been uploaded yet.
                    </div>
                @endif
            </div>
        </div>

        <!-- TAB 4: DIGITAL TRAINEE ID CARD (FRONT & BACK SMART ID) -->
        <div x-show="activeTab === 'idcard'" class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 no-print">
                <div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900">Official Digital Trainee ID Card</h2>
                    <p class="text-xs sm:text-sm text-slate-500">Dual-sided institutional credential with photo, particulars, and verification QR code.</p>
                </div>

                <button
                    type="button"
                    onclick="window.print()"
                    class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm flex items-center justify-center gap-2 shadow-xs transition cursor-pointer"
                >
                    <i class="fa-solid fa-print"></i>
                    <span>Print Student ID Card</span>
                </button>
            </div>

            <!-- Dual Side ID Card Container -->
            <div class="max-w-4xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch">

                <!-- FRONT SIDE -->
                <div class="bg-white rounded-2xl shadow-xl border border-slate-300/90 overflow-hidden flex flex-col justify-between relative min-h-[295px] print:shadow-none print:break-inside-avoid">
                    <!-- Top Brand Ribbon -->
                    <div class="bg-gradient-to-r from-slate-950 via-emerald-950 to-emerald-900 text-white px-5 py-3.5 border-b-[3px] border-amber-500 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            @if(!empty($settings['headerLogoImage']))
                                <img src="{{ $settings['headerLogoImage'] }}" alt="{{ $settings['headerLogoText'] }}" class="h-10 w-auto max-w-[72px] object-contain rounded-lg bg-white p-1 shrink-0">
                            @else
                                <div class="w-10 h-10 rounded-xl bg-emerald-600 border border-emerald-400/50 flex items-center justify-center font-black text-sm text-white shrink-0 shadow-xs">
                                    {{ $settings['headerLogoText'] }}
                                </div>
                            @endif
                            <div class="min-w-0">
                                <span class="block text-[9px] font-bold uppercase tracking-[0.14em] text-emerald-300 leading-tight">
                                    {{ $settings['footerBrandTitle'] }}
                                </span>
                                <h4 class="text-xs font-extrabold uppercase tracking-tight text-white leading-snug mt-0.5">
                                    {{ $settings['instituteName'] }}
                                </h4>
                            </div>
                        </div>
                        <span class="text-[9px] bg-amber-400 text-slate-950 px-2.5 py-1 rounded-full font-black uppercase tracking-wider shrink-0">
                            Student ID
                        </span>
                    </div>

                    <!-- Card Front Body with subtle crest watermark -->
                    <div class="p-5 flex-1 flex items-center gap-4 relative overflow-hidden">
                        <div class="pointer-events-none absolute -right-8 -bottom-8 w-36 h-36 rounded-full border-8 border-emerald-950/[0.04] flex items-center justify-center select-none">
                            <span class="text-2xl font-black text-emerald-950/[0.05]">{{ $settings['headerLogoText'] }}</span>
                        </div>

                        <!-- Photo & Verified Pill -->
                        <div class="flex flex-col items-center gap-1.5 shrink-0 relative z-10">
                            @if($studentResult && !empty($studentResult->photo))
                                <img src="{{ $studentResult->photo }}" alt="{{ $studentName }}" class="w-24 h-28 rounded-xl object-cover object-top border-2 border-emerald-800/30 bg-slate-100 shadow-xs">
                            @else
                                <div class="w-24 h-28 rounded-xl bg-slate-100 border-2 border-dashed border-slate-300 flex flex-col items-center justify-center text-slate-400">
                                    <i class="fa-solid fa-user-tie text-3xl text-slate-300 mb-1"></i>
                                    <span class="text-[8px] font-bold uppercase">Photo</span>
                                </div>
                            @endif
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-[9px] font-extrabold uppercase tracking-wider">
                                <i class="fa-solid fa-circle-check text-emerald-600 text-[8px]"></i> Verified
                            </span>
                        </div>

                        <!-- Student Details -->
                        <div class="space-y-2 min-w-0 flex-1 relative z-10">
                            <div>
                                <h3 class="font-black text-slate-950 text-base sm:text-lg leading-tight uppercase">
                                    {{ $studentName }}
                                </h3>
                                <p class="text-xs text-emerald-700 font-bold leading-snug mt-0.5">
                                    {{ $tradeName ?? 'Vocational Training Program' }}
                                </p>
                            </div>

                            <div class="space-y-1 text-[11px] pt-1 border-t border-slate-200/80">
                                <div class="flex items-baseline gap-1.5">
                                    <span class="text-slate-500 font-semibold w-16 shrink-0">Roll No:</span>
                                    <strong class="font-mono text-slate-950 font-extrabold">{{ $displayRoll ?? 'Pending' }}</strong>
                                </div>
                                <div class="flex items-baseline gap-1.5">
                                    <span class="text-slate-500 font-semibold w-16 shrink-0">Reg No:</span>
                                    <strong class="font-mono text-slate-800 font-bold">{{ $studentResult->reg_no ?? 'Pending Issuance' }}</strong>
                                </div>
                                <div class="flex items-baseline gap-1.5">
                                    <span class="text-slate-500 font-semibold w-16 shrink-0">Session:</span>
                                    <span class="font-semibold text-slate-800">{{ $sessionLabel }}</span>
                                </div>
                                <div class="flex items-baseline gap-1.5">
                                    <span class="text-slate-500 font-semibold w-16 shrink-0">Center:</span>
                                    <span class="font-semibold text-slate-700 leading-snug">{{ $branchLabel }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Front Footer -->
                    <div class="bg-slate-50 border-t border-slate-200 px-5 py-2.5 flex items-center justify-between text-[10px]">
                        <span class="font-mono text-slate-500">
                            Issued: <strong class="text-slate-800">{{ $studentResult->issue_date ?? date('Y-m-d') }}</strong>
                        </span>
                        <div class="text-right leading-none">
                            <span class="block text-[9px] font-bold uppercase tracking-wider text-slate-700">Authorised Signatory</span>
                            <span class="block text-[8px] text-slate-400 mt-0.5">Examination Directorate</span>
                        </div>
                    </div>
                </div>

                <!-- BACK SIDE -->
                <div class="bg-white rounded-2xl shadow-xl border border-slate-300/90 overflow-hidden flex flex-col justify-between relative min-h-[295px] print:shadow-none print:break-inside-avoid">
                    <!-- Top Security Band -->
                    <div class="bg-slate-950 text-white px-5 py-3 flex items-center justify-between gap-2 text-[10px] font-mono">
                        <span class="uppercase tracking-wider font-bold text-slate-200">Official Credential • Back</span>
                        <span class="text-emerald-400 font-bold uppercase tracking-wider">{{ $settings['footerAccreditationBadge'] }}</span>
                    </div>

                    <!-- Card Back Body -->
                    <div class="p-5 flex-1 flex flex-col sm:flex-row items-center gap-5">
                        <div class="shrink-0 text-center">
                            <div class="p-2 rounded-xl border-2 border-slate-200 bg-white shadow-2xs inline-block">
                                <img src="{{ $qrSrc }}" alt="Verification QR" class="w-24 h-24">
                            </div>
                            <span class="block text-[8.5px] font-mono font-extrabold text-emerald-800 tracking-wider uppercase mt-1.5">
                                Scan to Verify Online
                            </span>
                        </div>

                        <div class="flex-1 space-y-2.5 text-[11px] text-slate-600">
                            <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1">
                                @if($studentResult && !empty($studentResult->father_name) && $studentResult->father_name !== '-')
                                    <div><span class="font-semibold text-slate-500">Father / Guardian:</span> <strong class="text-slate-900">{{ $studentResult->father_name }}</strong></div>
                                @endif
                                <div><span class="font-semibold text-slate-500">Helpline:</span> <strong class="font-mono text-emerald-800">{{ $settings['helplinePhone'] }}</strong></div>
                                <div><span class="font-semibold text-slate-500">Address:</span> <span class="text-slate-800">{{ $settings['headquartersAddress'] }}</span></div>
                            </div>

                            <p class="text-[10.5px] text-slate-500 leading-relaxed">
                                This digital identity card certifies that the bearer is an officially enrolled trainee. Verify authenticity anytime by scanning the QR code or visiting the central verification portal.
                            </p>
                        </div>
                    </div>

                    <!-- Card Back Footer -->
                    <div class="bg-emerald-950 text-emerald-100 px-5 py-2.5 flex items-center justify-between gap-2 text-[10px]">
                        <span class="font-semibold">{{ $settings['instituteName'] }}</span>
                        <span class="font-mono text-emerald-300 shrink-0">{{ $settings['helplineEmail'] }}</span>
                    </div>
                </div>

            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="text-center text-xs text-slate-400 py-6 border-t border-slate-200 no-print">
        {{ $settings['footerBrandTitle'] }} • Need help? {{ $settings['helplinePhone'] }}
    </footer>

    <!-- Custom Official Admit Card Preview Modal -->
    <div 
        x-show="isAdmitModalOpen" 
        x-cloak 
        @keydown.escape.window="isAdmitModalOpen = false"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
        role="dialog"
        aria-modal="true"
    >
        <div 
            x-show="isAdmitModalOpen"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="isAdmitModalOpen = false"
            class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs no-print"
        ></div>

        <div 
            x-show="isAdmitModalOpen"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
            class="relative w-full max-w-lg bg-white rounded-3xl border border-slate-200 shadow-2xl overflow-hidden z-10"
        >
            <div class="bg-slate-950 text-white px-6 py-4 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-9 h-9 rounded-xl bg-emerald-600 flex items-center justify-center font-black text-xs shrink-0">{{ $settings['headerLogoText'] }}</div>
                    <div class="min-w-0">
                        <h3 class="text-sm sm:text-base font-extrabold leading-tight truncate">Official Examination Admit Card</h3>
                        <p class="text-[11px] text-emerald-400 font-semibold truncate">{{ $settings['instituteName'] }}</p>
                    </div>
                </div>
                <button type="button" @click="isAdmitModalOpen = false" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition no-print cursor-pointer shrink-0">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <div class="flex items-center gap-4">
                    @if($studentResult && !empty($studentResult->photo))
                        <img src="{{ $studentResult->photo }}" alt="{{ $studentName }}" class="w-16 h-20 rounded-xl object-cover object-top border border-slate-300 shrink-0">
                    @endif
                    <div class="text-xs sm:text-sm space-y-0.5">
                        <h4 class="font-extrabold text-slate-900 text-base">{{ $studentName }}</h4>
                        <p class="font-mono font-bold text-emerald-700">Roll: {{ $displayRoll ?? 'Pending Assignment' }}</p>
                        <p class="text-slate-500 text-xs">{{ $sessionLabel }}</p>
                    </div>
                </div>

                <div class="border border-slate-200 rounded-2xl divide-y divide-slate-200/80 text-xs sm:text-sm overflow-hidden">
                    <div class="grid grid-cols-12 px-4 py-2.5 bg-slate-50">
                        <span class="col-span-5 text-slate-500 font-semibold">Registration No</span>
                        <span class="col-span-7 font-mono font-semibold text-slate-800">{{ $studentResult->reg_no ?? 'Pending Issuance' }}</span>
                    </div>
                    <div class="grid grid-cols-12 px-4 py-2.5 bg-white">
                        <span class="col-span-5 text-slate-500 font-semibold">Trade / Course</span>
                        <span class="col-span-7 font-semibold text-slate-800">{{ $tradeName ?? 'Not Assigned Yet' }}</span>
                    </div>
                    <div class="grid grid-cols-12 px-4 py-2.5 bg-slate-50">
                        <span class="col-span-5 text-slate-500 font-semibold">Exam Center</span>
                        <span class="col-span-7 font-semibold text-slate-800">{{ $branchLabel }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-2.5 pt-1 no-print">
                    <button type="button" onclick="window.print()" class="flex-1 py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm flex items-center justify-center gap-2 shadow-xs transition cursor-pointer">
                        <i class="fa-solid fa-print"></i>
                        <span>Print Admit Card</span>
                    </button>
                    <button type="button" @click="isAdmitModalOpen = false" class="py-2.5 px-5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs sm:text-sm transition cursor-pointer">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
