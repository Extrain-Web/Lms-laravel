@extends('layouts.app')

@section('title', 'Portal Access & Login - National Youth Development Platform')

@section('content')
<div x-data="{ 
    role: '{{ request('role') === 'admin' ? 'admin' : 'student' }}',
    identifier: @js(old('login_id', '')),
    password: '',
    showPassword: false,
    isForgotModalOpen: false,
    setRole(newRole) {
        this.role = newRole;
    }
}" class="min-h-screen bg-slate-50 text-slate-800 antialiased flex flex-col justify-between">

    <!-- Top Banner Header -->
    <section class="relative bg-slate-950 text-white overflow-hidden py-12 sm:py-14 border-b border-slate-800">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/70 via-slate-900/90 to-slate-950 z-0"></div>
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:16px_16px]"></div>

        <div class="relative z-10 max-w-[1240px] mx-auto px-6 text-center space-y-3">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold tracking-wide">
                <i class="fa-solid fa-shield-halved"></i>
                <span x-show="lang === 'en'">National Platform Authentication Gateway</span>
                <span x-show="lang === 'bn'">জাতীয় প্ল্যাটফর্ম নিরাপত্তা ও প্রবেশদ্বার</span>
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight text-white">
                <span x-show="lang === 'en'">Portal Access & Login</span>
                <span x-show="lang === 'bn'">পোর্টাল অ্যাক্সেস ও লগইন</span>
            </h1>
            <p class="text-sm sm:text-base text-slate-300 max-w-2xl mx-auto font-normal">
                <span x-show="lang === 'en'">Sign in to access your personalized Student Learning Dashboard or Central Directorate Admin Control Center.</span>
                <span x-show="lang === 'bn'">আপনার পারসোনালাইজড শিক্ষার্থী লার্নিং ড্যাশবোর্ড বা কেন্দ্রীয় অ্যাডমিন কন্ট্রোল সেন্টারে প্রবেশ করতে সাইন ইন করুন।</span>
            </p>
        </div>
    </section>

    <!-- Main Authentication Container -->
    <main class="max-w-[1080px] mx-auto w-full px-4 sm:px-8 py-10 sm:py-14 relative z-20">
        <div class="bg-white rounded-3xl shadow-xl border border-slate-200/90 overflow-hidden grid grid-cols-1 lg:grid-cols-12">
            
            <!-- Left Column: Form (7 cols) -->
            <div class="lg:col-span-7 p-6 sm:p-10 space-y-6">
                
                <!-- Role Switcher Tabs (2 Tabs: Student vs Admin) -->
                <div class="grid grid-cols-2 bg-slate-100 p-1.5 rounded-2xl gap-1.5 border border-slate-200">
                    <button
                        type="button"
                        @click="setRole('student')"
                        :class="role === 'student' ? 'bg-white text-emerald-700 shadow-xs border border-slate-200/80' : 'text-slate-600 hover:text-slate-900'"
                        class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl font-bold text-xs sm:text-sm transition cursor-pointer"
                    >
                        <i class="fa-solid fa-graduation-cap text-emerald-600"></i>
                        <span x-show="lang === 'en'">Student / Trainee</span>
                        <span x-show="lang === 'bn'">শিক্ষার্থী / ট্রেইনি</span>
                    </button>

                    <button
                        type="button"
                        @click="setRole('admin')"
                        :class="role === 'admin' ? 'bg-white text-emerald-700 shadow-xs border border-slate-200/80' : 'text-slate-600 hover:text-slate-900'"
                        class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl font-bold text-xs sm:text-sm transition cursor-pointer"
                    >
                        <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                        <span x-show="lang === 'en'">Central Admin</span>
                        <span x-show="lang === 'bn'">সেন্ট্রাল অ্যাডমিন</span>
                    </button>
                </div>

                <!-- Login Box Title -->
                <div class="space-y-1">
                    <h2 class="text-2xl font-black text-slate-900">
                        <template x-if="role === 'student'">
                            <span>
                                <span x-show="lang === 'en'">Trainee Portal Login</span>
                                <span x-show="lang === 'bn'">ট্রেইনি পোর্টাল লগইন</span>
                            </span>
                        </template>
                        <template x-if="role === 'admin'">
                            <span>
                                <span x-show="lang === 'en'">Central Admin Directorate</span>
                                <span x-show="lang === 'bn'">সেন্ট্রাল অ্যাডমিন কন্ট্রোল</span>
                            </span>
                        </template>
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 font-normal">
                        <template x-if="role === 'student'">
                            <span>
                                <span x-show="lang === 'en'">Enter your Roll, Registration Number or email to access your enrolled courses, syllabus, and marksheet.</span>
                                <span x-show="lang === 'bn'">আপনার কোর্স, সিলেবাস এবং মার্কশিট দেখতে রোল নম্বর, রেজিস্ট্রেশন বা ইমেইল দিয়ে প্রবেশ করুন।</span>
                            </span>
                        </template>
                        <template x-if="role === 'admin'">
                            <span>
                                <span x-show="lang === 'en'">Enter your official administrative email or ID and security password to manage institute operations.</span>
                                <span x-show="lang === 'bn'">ইনস্টিটিউট পরিচালনা করতে আপনার অফিশিয়াল অ্যাডমিন ইমেইল ও পাসওয়ার্ড প্রদান করুন।</span>
                            </span>
                        </template>
                    </p>
                </div>

                @if($errors->any())
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-2xl text-xs font-bold flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <!-- Identifier Input -->
                    <div class="space-y-1.5">
                        <label class="block text-xs sm:text-sm font-bold text-slate-800 uppercase tracking-wide">
                            <span x-show="role === 'student'">
                                <span x-show="lang === 'en'">Student Roll / Reg No or Email *</span>
                                <span x-show="lang === 'bn'">রোল / রেজিস্ট্রেশন বা ইমেইল *</span>
                            </span>
                            <span x-show="role === 'admin'">
                                <span x-show="lang === 'en'">Admin Email or Official ID *</span>
                                <span x-show="lang === 'bn'">অ্যাডমিন ইমেইল বা আইডি *</span>
                            </span>
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                name="login_id"
                                required
                                x-model="identifier"
                                :placeholder="role === 'student' ? 'e.g., NYD-2026-1042 or student@example.com' : 'e.g., admin@jubounnayon.com'"
                                class="w-full px-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-300 text-slate-900 font-semibold focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white text-sm sm:text-base transition"
                            />
                            <div class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                                <i :class="role === 'student' ? 'fa-solid fa-user' : 'fa-solid fa-envelope'"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs sm:text-sm font-bold text-slate-800 uppercase tracking-wide">
                                <span x-show="lang === 'en'">Password *</span>
                                <span x-show="lang === 'bn'">পাসওয়ার্ড *</span>
                            </label>
                            <button
                                type="button"
                                @click="isForgotModalOpen = true"
                                class="text-xs font-bold text-emerald-700 hover:text-emerald-800 underline cursor-pointer"
                            >
                                <span x-show="lang === 'en'">Forgot password?</span>
                                <span x-show="lang === 'bn'">পাসওয়ার্ড ভুলে গেছেন?</span>
                            </button>
                        </div>
                        <div class="relative">
                            <input
                                :type="showPassword ? 'text' : 'password'"
                                name="password"
                                required
                                x-model="password"
                                placeholder="Enter your password"
                                class="w-full px-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-300 text-slate-900 font-semibold focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:bg-white text-sm sm:text-base transition"
                            />
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition cursor-pointer"
                            >
                                <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between text-xs">
                        <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-emerald-600 rounded-sm">
                            <span x-show="lang === 'en'">Remember my session</span>
                            <span x-show="lang === 'bn'">লগইন মনে রাখুন</span>
                        </label>
                    </div>

                    <!-- Submit Action Button -->
                    <button
                        type="submit"
                        class="w-full mt-2 py-4 px-6 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-sm sm:text-base flex items-center justify-center gap-2.5 shadow-lg shadow-emerald-600/25 hover:shadow-xl transition-all cursor-pointer"
                    >
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        <span>
                            <span x-show="role === 'student'">
                                <span x-show="lang === 'en'">Sign In to Student Dashboard</span>
                                <span x-show="lang === 'bn'">শিক্ষার্থী ড্যাশবোর্ডে সাইন ইন</span>
                            </span>
                            <span x-show="role === 'admin'">
                                <span x-show="lang === 'en'">Sign In as Central Admin</span>
                                <span x-show="lang === 'bn'">সেন্ট্রাল অ্যাডমিন হিসেবে সাইন ইন</span>
                            </span>
                        </span>
                    </button>
                </form>

                <!-- Bottom Register Prompt -->
                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs sm:text-sm">
                    <span class="text-slate-500">
                        <span x-show="lang === 'en'">New trainee looking to enroll?</span>
                        <span x-show="lang === 'bn'">নতুন ভর্তি হতে আগ্রহী?</span>
                    </span>
                    <a
                        href="{{ route('admissions.apply') }}"
                        class="font-bold text-emerald-700 hover:text-emerald-800 underline flex items-center gap-1"
                    >
                        <span x-show="lang === 'en'">Create Student Account</span>
                        <span x-show="lang === 'bn'">ভর্তি আবেদন করুন</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

            </div>

            <!-- Right Column: Portal Info & Benefits (5 cols) -->
            <div class="lg:col-span-5 bg-gradient-to-br from-slate-950 via-slate-900 to-emerald-950 p-6 sm:p-10 text-white flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 flex items-center justify-center font-bold text-lg">
                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-black text-white leading-snug">
                        <span x-show="lang === 'en'">National Youth Development Portal</span>
                        <span x-show="lang === 'bn'">জাতীয় যুব উন্নয়ন ও প্রশিক্ষণ পোর্টাল</span>
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-normal">
                        <span x-show="lang === 'en'">Connecting students, vocational courses, and certified academic records under Saikat Computer & Training Jubo Songhoton.</span>
                        <span x-show="lang === 'bn'">সৈকত কম্পিউটার অ্যান্ড ট্রেনিং যুব সংগঠন পরিচালিত কারিগরি কোর্স ও সনদ ব্যবস্থার কেন্দ্রীয় পোর্টাল।</span>
                    </p>

                    <!-- Feature Points -->
                    <div class="space-y-3 pt-2 text-xs sm:text-sm text-slate-200">
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-400 shrink-0 mt-1"></i>
                            <span x-show="lang === 'en'">Interactive student dashboard with enrolled trade modules</span>
                            <span x-show="lang === 'bn'">ভর্তি হওয়া ট্রেড মডিউল ও সিলেবাস পর্যবেক্ষণ ড্যাশবোর্ড</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-400 shrink-0 mt-1"></i>
                            <span x-show="lang === 'en'">Central admin panel for 100% dynamic website control</span>
                            <span x-show="lang === 'bn'">ওয়েবসাইটের যাবতীয় কনটেন্ট ও ডেটা ডাইনামিক অ্যাডমিন কন্ট্রোল</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-400 shrink-0 mt-1"></i>
                            <span x-show="lang === 'en'">Authentic digital marksheet and certificate generation</span>
                            <span x-show="lang === 'bn'">নিরাপদ কিউআর কোড ভেরিফিকেশন সহ ডিজিটাল মার্কশিট ও সনদ</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-400 shrink-0 mt-1"></i>
                            <span x-show="lang === 'en'">Direct download of exam routines, notices, and toolkits</span>
                            <span x-show="lang === 'bn'">পরীক্ষার রুটিন, অ্যাডমিট কার্ড ও রিসোর্স সরাসরি ডাউনলোড</span>
                        </div>
                    </div>
                </div>

                <!-- Help & Support Footer -->
                <div class="pt-4 border-t border-slate-800 text-xs text-slate-400 space-y-1">
                    <p class="font-semibold text-slate-300">
                        <span x-show="lang === 'en'">Need authentication assistance?</span>
                        <span x-show="lang === 'bn'">সহায়তার প্রয়োজন?</span>
                    </p>
                    <p>Helpline: +880 1712-345678 (9 AM - 6 PM)</p>
                </div>
            </div>

        </div>
    </main>

    <!-- Subtle bottom note -->
    <footer class="text-center text-xs text-slate-400 pb-6">
        Protected by National Youth Technical Platform Security Protocols • Govt. Reg: 04.30.2600
    </footer>

    <!-- Custom Forgot Password Support Modal -->
    <div 
        x-show="isForgotModalOpen" 
        x-cloak 
        @keydown.escape.window="isForgotModalOpen = false"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
        role="dialog"
        aria-modal="true"
    >
        <div 
            x-show="isForgotModalOpen"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="isForgotModalOpen = false"
            class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs"
        ></div>

        <div 
            x-show="isForgotModalOpen"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
            class="relative w-full max-w-md bg-white rounded-3xl border border-slate-200 shadow-2xl overflow-hidden z-10"
        >
            <div class="h-1.5 w-full bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-500"></div>
            <div class="p-6 sm:p-7 space-y-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-600 flex items-center justify-center text-lg shrink-0">
                            <i class="fa-solid fa-key"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 leading-tight">
                                <span x-show="lang === 'en'">Password Recovery Helpdesk</span>
                                <span x-show="lang === 'bn'">পাসওয়ার্ড পুনরুদ্ধার সহায়তা</span>
                            </h3>
                            <p class="text-xs text-slate-500">Central Directorate Support</p>
                        </div>
                    </div>
                    <button type="button" @click="isForgotModalOpen = false" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition cursor-pointer">
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </button>
                </div>

                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    <span x-show="lang === 'en'">For security verification and password reset, please contact our central campus helpdesk with your Student Roll No or official ID.</span>
                    <span x-show="lang === 'bn'">পাসওয়ার্ড রিসেট করতে আপনার রোল নম্বর বা আইডিসহ নিচের হেল্পলাইন নম্বরে যোগাযোগ করুন।</span>
                </p>

                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 space-y-2 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-semibold">Helpline Phone</span>
                        <a href="tel:{{ $settings['helplinePhone'] ?? '+8801712345678' }}" class="font-mono font-bold text-emerald-700 hover:underline">{{ $settings['helplinePhone'] ?? '+880 1712-345678' }}</a>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-semibold">Support Email</span>
                        <a href="mailto:{{ $settings['helplineEmail'] ?? 'support@jubounnayon.com' }}" class="font-semibold text-slate-800 hover:underline">{{ $settings['helplineEmail'] ?? 'support@jubounnayon.com' }}</a>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-semibold">Office Hours</span>
                        <span class="font-semibold text-slate-700">{{ $settings['officeOpeningTime'] ?? '9:00 AM' }} – {{ $settings['officeClosingTime'] ?? '5:00 PM' }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-2.5 pt-1">
                    <a href="tel:{{ $settings['helplinePhone'] ?? '+8801712345678' }}" class="flex-1 py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm text-center shadow-xs transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-phone text-xs"></i>
                        <span>Call Helpdesk</span>
                    </a>
                    <button type="button" @click="isForgotModalOpen = false" class="flex-1 py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs sm:text-sm transition cursor-pointer">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
