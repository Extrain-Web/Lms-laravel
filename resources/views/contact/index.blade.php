@extends('layouts.app')

@section('title', 'Contact Academic Directorate - National Youth Platform')

@section('content')
<div class="w-full bg-[#F8FAFC] min-h-screen pb-16">
    
    <!-- Top Banner -->
    <section class="bg-slate-900 text-white border-b border-slate-800 py-10 sm:py-14">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-14">
            <div class="max-w-3xl space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs sm:text-sm font-bold">
                    <i class="fa-solid fa-headset"></i>
                    <span>{{ $settings['contactPageBadge'] ?? 'Official Central Directorate & 64 District Network' }}</span>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                    {{ $settings['contactPageTitle'] ?? 'Contact Academic Directorate' }}
                </h1>
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed font-normal">
                    {{ $settings['contactPageSubtitle'] ?? 'Connect directly with our central secretariat or regional hubs for admission counseling, certificate verification, and affiliation inquiries.' }}
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content Grid -->
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-14 py-10 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
        
        <!-- Left Column: Info & Hubs -->
        <div class="lg:col-span-5 space-y-6">
            
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm space-y-6">
                <h2 class="text-xl font-black text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2.5">
                    <i class="fa-solid fa-building text-emerald-600"></i>
                    <span>Central Secretariat</span>
                </h2>

                <div class="space-y-4 text-xs sm:text-sm">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-location-dot text-base"></i>
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block">Headquarters Address</span>
                            <span class="text-slate-500 mt-0.5 block">{{ $settings['headquartersAddress'] ?? 'Youth Bhaban Complex, Mirpur-2, Dhaka-1216, Bangladesh' }}</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-phone text-base"></i>
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block">Helpdesk Numbers</span>
                            <a href="tel:{{ $settings['helplinePhone'] ?? '+8801712345678' }}" class="text-emerald-700 font-mono font-bold mt-0.5 block hover:underline">{{ $settings['helplinePhone'] ?? '+880 1712-345678' }}</a>
                            <span class="text-[11px] text-slate-400">Toll-free student support helpline</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-envelope text-base"></i>
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block">Electronic Mail</span>
                            <a href="mailto:{{ $settings['helplineEmail'] ?? 'info@nationalyouthplatform.gov.bd' }}" class="text-slate-600 font-mono mt-0.5 block hover:underline">{{ $settings['helplineEmail'] ?? 'info@nationalyouthplatform.gov.bd' }}</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                            <i class="fa-regular fa-clock text-base"></i>
                        </div>
                        <div class="space-y-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-bold text-slate-900">Academic Hours</span>
                                @if(($settings['officeStatus'] ?? 'open') === 'open')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[11px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        {{ $settings['officeOpenLabel'] ?? 'Open Today' }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-rose-50 text-rose-700 border border-rose-200 text-[11px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        {{ $settings['officeClosedLabel'] ?? 'Closed Today' }}
                                    </span>
                                @endif
                            </div>
                            <span class="text-slate-600 font-medium block">{{ $settings['officeWeeklyDays'] ?? 'Sun - Thu (Fri - Sat Closed)' }}</span>
                            <span class="text-emerald-700 font-bold block">{{ $settings['officeOpeningTime'] ?? '9:00 AM' }} - {{ $settings['officeClosingTime'] ?? '5:00 PM' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Urgent Certificate Verification Box -->
            <div class="bg-slate-950 text-white rounded-3xl p-6 sm:p-8 border border-slate-800 space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-xs font-bold uppercase">
                    Verification Desk
                </div>
                <h3 class="text-lg font-black text-white">Need Urgent Certificate Verification?</h3>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    Embassies, employers, and government departments can immediately verify graduate credentials using our digital search database.
                </p>
                <div class="pt-1">
                    <a href="{{ route('results.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition">
                        <i class="fa-solid fa-qrcode"></i>
                        <span>Search Results Online</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- Right Column: Inquiry Message Form -->
        <div class="lg:col-span-7">
            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/90 shadow-sm space-y-6">
                <div class="pb-3 border-b border-slate-100">
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900">Send an Official Inquiry</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Our academic counseling officers will respond within 24 business hours.</p>
                </div>

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs sm:text-sm font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Full Name *
                            </label>
                            <input type="text" name="name" required placeholder="e.g. Kamrul Ahsan" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm sm:text-base focus:outline-hidden focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs sm:text-sm font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Phone Number *
                            </label>
                            <input type="tel" name="phone" required placeholder="017XXXXXXXX" class="w-full px-4 py-3 rounded-xl border border-slate-300 font-mono text-sm sm:text-base focus:outline-hidden focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs sm:text-sm font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Email Address *
                            </label>
                            <input type="email" name="email" required placeholder="name@example.com" class="w-full px-4 py-3 rounded-xl border border-slate-300 font-mono text-sm sm:text-base focus:outline-hidden focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs sm:text-sm font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Inquiry Category *
                            </label>
                            <select name="inquiry_type" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm sm:text-base focus:outline-hidden focus:ring-2 focus:ring-emerald-500 font-semibold">
                                <option value="Admission & Scholarship">Admission & Scholarship</option>
                                <option value="Certificate Verification">Certificate Verification</option>
                                <option value="New Center Affiliation">New Center Affiliation</option>
                                <option value="General Query">General Query</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            District / Division
                        </label>
                        <input type="text" name="district" placeholder="e.g. Dhaka, Chittagong, Sylhet" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm sm:text-base focus:outline-hidden focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Detailed Message *
                        </label>
                        <textarea name="message" rows="4" required placeholder="Please write your query with full details..." class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm sm:text-base focus:outline-hidden focus:ring-2 focus:ring-emerald-500"></textarea>
                    </div>

                    <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-xl sm:rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm sm:text-base shadow-md transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Transmit Inquiry Message</span>
                    </button>
                </form>
            </div>
        </div>

    </div>

</div>
@endsection
