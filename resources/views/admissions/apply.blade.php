@extends('layouts.app')

@section('title', 'Trainee Registration & Admission - National Youth Platform')

@section('content')
<div class="min-h-screen bg-slate-50 text-slate-800 antialiased flex flex-col justify-between pb-12">
    
    <!-- Top Banner Header -->
    <section class="relative bg-slate-950 text-white overflow-hidden py-12 sm:py-14 border-b border-slate-800">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/70 via-slate-900/90 to-slate-950 z-0"></div>
        <div class="relative z-10 max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-14">
            <div class="max-w-3xl space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs sm:text-sm font-bold">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <span>Trainee Enrollment Portal • Batch 2026</span>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white tracking-tight leading-tight">
                    Apply for Government Subsidized Technical Courses
                </h1>
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed font-normal">
                    Join over 1,500+ successful graduates nationwide. Complete your registration to secure an accredited trade diploma seat for Batch 2026.
                </p>
            </div>
        </div>
    </section>

    <!-- Main Registration Shell -->
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-14 py-8 sm:py-12 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            
            <!-- Left Column: Registration Form -->
            <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/90 shadow-xl space-y-6">
                
                <div class="pb-4 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-800">Student Trainee Registration</h2>
                        <p class="text-xs text-slate-500 mt-0.5 font-normal">Please provide authentic details as per your NID or Academic Certificate</p>
                    </div>
                    <span class="bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-semibold px-3 py-1 rounded-full uppercase">
                        Free Application
                    </span>
                </div>

                <form action="{{ route('register.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Full Name (As per NID / Certificate) *
                        </label>
                        <input type="text" name="full_name" required placeholder="e.g. Kamrul Ahsan" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm sm:text-base focus:outline-hidden focus:ring-2 focus:ring-emerald-500 font-medium">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs sm:text-sm font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                Active Mobile Number *
                            </label>
                            <input type="tel" name="phone" required placeholder="017XXXXXXXX" class="w-full px-4 py-3 rounded-xl border border-slate-300 font-mono text-sm sm:text-base focus:outline-hidden focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs sm:text-sm font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                Email Address *
                            </label>
                            <input type="email" name="email" required placeholder="name@example.com" class="w-full px-4 py-3 rounded-xl border border-slate-300 font-mono text-sm sm:text-base focus:outline-hidden focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs sm:text-sm font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                Target Vocational Trade *
                            </label>
                            <select name="trade" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm sm:text-base focus:outline-hidden focus:ring-2 focus:ring-emerald-500 font-semibold">
                                @foreach($courses as $c)
                                    <option value="{{ $c->title }}" {{ request('trade') == $c->title ? 'selected' : '' }}>
                                        {{ $c->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs sm:text-sm font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                District Hub Location *
                            </label>
                            <select name="district" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm sm:text-base focus:outline-hidden focus:ring-2 focus:ring-emerald-500 font-semibold">
                                <option value="Dhaka">Dhaka Regional Complex</option>
                                <option value="Chittagong">Chattogram Division Hub</option>
                                <option value="Rajshahi">Rajshahi Regional Campus</option>
                                <option value="Khulna">Khulna Vocational Center</option>
                                <option value="Sylhet">Sylhet Skill Development Hub</option>
                                <option value="Barishal">Barishal Technical Center</option>
                                <option value="Rangpur">Rangpur District Center</option>
                                <option value="Mymensingh">Mymensingh Vocational Hub</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Educational Background / Note (Optional)
                        </label>
                        <textarea name="notes" rows="2" placeholder="e.g. Completed SSC in Science in 2024, eager to learn web development." class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm sm:text-base focus:outline-hidden focus:ring-2 focus:ring-emerald-500"></textarea>
                    </div>

                    <div class="flex items-start gap-2 pt-1">
                        <input type="checkbox" required id="agree" checked class="w-4 h-4 text-emerald-600 rounded mt-1">
                        <label for="agree" class="text-xs text-slate-600 leading-snug cursor-pointer font-normal">
                            I declare that the information provided above is true and authentic. I agree to abide by the codes of conduct of the National Youth Platform.
                        </label>
                    </div>

                    <button type="submit" class="w-full py-4 rounded-xl sm:rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm sm:text-base shadow-md shadow-emerald-600/25 transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-user-plus"></i>
                        <span>Submit Trainee Registration</span>
                    </button>
                </form>

            </div>

            <!-- Right Column: Benefits Sidebar -->
            <div class="lg:col-span-5 space-y-6">
                
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs space-y-5">
                    <h3 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-3">
                        Why Train With National Youth Platform?
                    </h3>

                    <div class="space-y-4 text-xs sm:text-sm">
                        <div class="flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-certificate text-base"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800">100% Verified Certificates</h4>
                                <p class="text-slate-500 text-xs mt-0.5 font-normal">Nationally accredited certificates accepted for government, private, and overseas employment.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-laptop text-base"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800">80% Practical Hands-On Labs</h4>
                                <p class="text-slate-500 text-xs mt-0.5 font-normal">Learn on high-end Core-i7 workstations, industrial machinery, and HVAC test rigs.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-award text-base"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800">Govt Scholarships & Stipends</h4>
                                <p class="text-slate-500 text-xs mt-0.5 font-normal">Eligible trainees receive toolkits and subsidized tuition fees under youth development quotas.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-briefcase text-base"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800">National Job Network</h4>
                                <p class="text-slate-500 text-xs mt-0.5 font-normal">Direct hiring partnerships with leading domestic companies and international recruitment agencies.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hotline Card -->
                <div class="bg-slate-950 text-white rounded-3xl p-6 border border-slate-800 space-y-3">
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider block">Admission Helpline</span>
                    <h4 class="text-xl font-mono font-black text-white">+880 1712-345678</h4>
                    <p class="text-xs text-slate-400">Available Sunday to Thursday, 9:00 AM - 5:00 PM for all admission inquiries.</p>
                </div>

            </div>

        </div>
    </div>

</div>
@endsection
