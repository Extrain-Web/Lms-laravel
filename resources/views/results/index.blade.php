@extends('layouts.app')

@section('title', 'Exam Result - ' . ($settings['instituteName'] ?? 'National Youth Development Platform'))

@section('content')
<div class="w-full bg-[#F8FAFC] min-h-screen pb-14">

    <!-- Clean Classic Institutional Header -->
    <section class="bg-slate-900 text-white border-b border-slate-800 py-9 sm:py-11">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center space-y-2">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white tracking-tight">
                {{ $settings['resultsPageTitle'] ?? 'Exam Result' }}
            </h1>
            <nav class="flex items-center justify-center gap-2 text-xs sm:text-sm text-slate-400">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <span>/</span>
                <span class="text-emerald-400 font-medium">Exam Result</span>
            </nav>
        </div>
    </section>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 pt-8 sm:pt-10 space-y-6">

        <!-- Search Card: Student Exam Result -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="bg-slate-50 border-b border-slate-200 px-5 sm:px-6 py-3.5">
                <h2 class="text-sm sm:text-base font-bold text-slate-900">Student Exam Result</h2>
            </div>

            <div class="p-5 sm:p-6 space-y-3.5">
                <form action="{{ route('results.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <input
                            id="rollNoSearchInput"
                            type="text"
                            name="roll_no"
                            value="{{ request('roll_no', isset($result) ? $result->roll_no : '') }}"
                            required
                            placeholder="Enter Student Roll No or Registration No"
                            class="w-full pl-10 pr-4 py-2.5 sm:py-3 rounded-lg border border-slate-300 font-mono text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600"
                        >
                        <i class="fa-solid fa-id-card absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                    </div>

                    <button type="submit" class="px-6 py-2.5 sm:py-3 rounded-lg bg-slate-900 hover:bg-emerald-700 text-white font-semibold text-sm flex items-center justify-center gap-2 transition shrink-0 cursor-pointer">
                        <span>Submit</span>
                    </button>
                </form>

                <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-1.5 text-xs text-slate-500">
                    <span>Enter the roll or registration number printed on your admit card.</span>
                    <span>
                        Helpline:
                        <a href="tel:{{ $settings['helplinePhone'] ?? '+8801712345678' }}" class="font-semibold text-emerald-700 hover:underline">
                            {{ $settings['helplinePhone'] ?? '+880 1712-345678' }}
                        </a>
                    </span>
                </div>
            </div>
        </div>

        <!-- Student Exam Result Output -->
        @if(isset($result))
            <div class="space-y-6" id="printableTranscript">

                <!-- CARD 1: Student Information -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
                    <div class="bg-slate-50 border-b border-slate-200 px-5 sm:px-6 py-3.5 flex items-center justify-between gap-2">
                        <h3 class="text-base sm:text-lg font-bold text-slate-900">Student Information</h3>
                        <span class="text-xs font-mono font-semibold text-slate-600">Session: {{ $result->session }}</span>
                    </div>

                    <div class="p-5 sm:p-6">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">

                            <!-- Left: Student Particulars Table -->
                            <div class="md:col-span-8 order-2 md:order-1">
                                <div class="border border-slate-200 rounded-lg overflow-hidden divide-y divide-slate-200 text-xs sm:text-sm">
                                    <div class="grid grid-cols-12 px-4 py-2.5 bg-white">
                                        <span class="col-span-5 sm:col-span-4 font-semibold text-slate-500">Student Name</span>
                                        <span class="col-span-7 sm:col-span-8 font-bold text-slate-900">{{ $result->student_name }}</span>
                                    </div>
                                    <div class="grid grid-cols-12 px-4 py-2.5 bg-slate-50">
                                        <span class="col-span-5 sm:col-span-4 font-semibold text-slate-500">Roll No</span>
                                        <span class="col-span-7 sm:col-span-8 font-mono font-bold text-slate-900">{{ $result->roll_no }}</span>
                                    </div>
                                    <div class="grid grid-cols-12 px-4 py-2.5 bg-white">
                                        <span class="col-span-5 sm:col-span-4 font-semibold text-slate-500">Registration No</span>
                                        <span class="col-span-7 sm:col-span-8 font-mono font-semibold text-slate-800 break-all">{{ $result->reg_no }}</span>
                                    </div>
                                    @if(!empty($result->course_code))
                                        <div class="grid grid-cols-12 px-4 py-2.5 bg-slate-50">
                                            <span class="col-span-5 sm:col-span-4 font-semibold text-slate-500">Course Code</span>
                                            <span class="col-span-7 sm:col-span-8 font-mono font-bold text-slate-900">{{ $result->course_code }}</span>
                                        </div>
                                    @endif
                                    <div class="grid grid-cols-12 px-4 py-2.5 {{ !empty($result->course_code) ? 'bg-white' : 'bg-slate-50' }}">
                                        <span class="col-span-5 sm:col-span-4 font-semibold text-slate-500">Course Name</span>
                                        <span class="col-span-7 sm:col-span-8 font-bold text-slate-800">{{ $result->trade }}</span>
                                    </div>
                                    <div class="grid grid-cols-12 px-4 py-2.5 {{ !empty($result->course_code) ? 'bg-slate-50' : 'bg-white' }}">
                                        <span class="col-span-5 sm:col-span-4 font-semibold text-slate-500">Branch Name</span>
                                        <span class="col-span-7 sm:col-span-8 font-semibold text-slate-800">{{ $result->center ?? $result->institute_name }}</span>
                                    </div>
                                    @if(!empty($result->father_name) && $result->father_name !== '-')
                                        <div class="grid grid-cols-12 px-4 py-2.5 bg-white">
                                            <span class="col-span-5 sm:col-span-4 font-semibold text-slate-500">Father's Name</span>
                                            <span class="col-span-7 sm:col-span-8 font-medium text-slate-700">{{ $result->father_name }}</span>
                                        </div>
                                    @endif
                                    @if(!empty($result->mother_name) && $result->mother_name !== '-')
                                        <div class="grid grid-cols-12 px-4 py-2.5 bg-slate-50">
                                            <span class="col-span-5 sm:col-span-4 font-semibold text-slate-500">Mother's Name</span>
                                            <span class="col-span-7 sm:col-span-8 font-medium text-slate-700">{{ $result->mother_name }}</span>
                                        </div>
                                    @endif
                                    <div class="grid grid-cols-12 px-4 py-2.5 bg-white">
                                        <span class="col-span-5 sm:col-span-4 font-semibold text-slate-500">Exam Year</span>
                                        <span class="col-span-7 sm:col-span-8 font-medium text-slate-700">{{ $result->exam_year }} ({{ $result->session }})</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Candidate Photo -->
                            <div class="md:col-span-4 order-1 md:order-2 flex flex-col items-center justify-center space-y-2">
                                <div class="w-36 h-44 sm:w-40 sm:h-48 rounded-lg border border-slate-300 bg-slate-50 overflow-hidden flex items-center justify-center">
                                    @if(!empty($result->photo))
                                        <img src="{{ $result->photo }}" alt="{{ $result->student_name }}" class="w-full h-full object-cover object-top">
                                    @else
                                        <div class="text-center p-4 text-slate-400 space-y-1.5">
                                            <i class="fa-solid fa-user-tie text-4xl text-slate-300"></i>
                                            <span class="text-[11px] font-semibold block text-slate-400">No Photo</span>
                                        </div>
                                    @endif
                                </div>
                                <span class="text-[11px] font-mono text-slate-500">Issue Date: {{ $result->issue_date }}</span>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- CARD 2: Result Information -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
                    <div class="bg-slate-50 border-b border-slate-200 px-5 sm:px-6 py-3.5 flex items-center justify-between">
                        <h3 class="text-base sm:text-lg font-bold text-slate-900">Result Information</h3>
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Passed</span>
                    </div>

                    <div class="p-5 sm:p-6 space-y-5">
                        <!-- Summary Table -->
                        <div class="border border-slate-200 rounded-lg overflow-hidden divide-y divide-slate-200 text-xs sm:text-sm">
                            <div class="grid grid-cols-12 px-4 py-3 bg-white items-center">
                                <span class="col-span-5 sm:col-span-4 font-semibold text-slate-600">Result</span>
                                <span class="col-span-7 sm:col-span-8 font-mono font-bold text-slate-900">
                                    @if(!empty($result->result_score))
                                        {{ $result->result_score }}
                                        <span class="text-xs font-normal text-slate-500 ml-1">(GPA: {{ number_format($result->gpa, 2) }} / 4.00)</span>
                                    @else
                                        GPA {{ number_format($result->gpa, 2) }} / 4.00
                                    @endif
                                </span>
                            </div>
                            <div class="grid grid-cols-12 px-4 py-3 bg-slate-50 items-center">
                                <span class="col-span-5 sm:col-span-4 font-semibold text-slate-600">Grade</span>
                                <span class="col-span-7 sm:col-span-8 font-mono font-bold text-emerald-800 text-base">
                                    {{ $result->grade }}
                                </span>
                            </div>
                        </div>

                        <!-- Optional Subject-Wise Marksheet Table -->
                        @if(!empty($result->marks))
                            <div class="space-y-2">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-600">Subject-Wise Marksheet Details</h4>
                                <div class="border border-slate-200 rounded-lg overflow-hidden">
                                    <div class="overflow-x-auto w-full">
                                        <table class="w-full min-w-[520px] text-left text-xs sm:text-sm">
                                            <thead class="bg-slate-900 text-white font-semibold uppercase tracking-wider text-xs">
                                                <tr>
                                                    <th class="px-4 py-2.5">Subject Name</th>
                                                    <th class="px-4 py-2.5 text-center">Full Marks</th>
                                                    <th class="px-4 py-2.5 text-center">Marks Obtained</th>
                                                    <th class="px-4 py-2.5 text-center">Letter Grade</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-200 bg-white">
                                                @foreach($result->marks as $m)
                                                    <tr class="hover:bg-slate-50">
                                                        <td class="px-4 py-2.5 font-semibold text-slate-800">{{ $m['subject'] }}</td>
                                                        <td class="px-4 py-2.5 text-center font-mono text-slate-600">{{ $m['fullMarks'] ?? 100 }}</td>
                                                        <td class="px-4 py-2.5 text-center font-mono font-bold text-slate-900">{{ $m['obtained'] }}</td>
                                                        <td class="px-4 py-2.5 text-center font-bold text-emerald-700">{{ $m['grade'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Print & Download Action Bar -->
                        <div 
                            class="pt-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4"
                            x-data="{
                                downloading: false,
                                downloadMarksheet(url) {
                                    if (this.downloading) return;
                                    this.downloading = true;
                                    let frame = document.getElementById('marksheetPdfFrame');
                                    if (!frame) {
                                        frame = document.createElement('iframe');
                                        frame.id = 'marksheetPdfFrame';
                                        frame.style.cssText = 'position:fixed;left:-9999px;top:0;width:900px;height:1300px;opacity:0;pointer-events:none;border:0;';
                                        document.body.appendChild(frame);
                                    }
                                    const timer = setTimeout(() => { this.downloading = false; }, 10000);
                                    const onDone = (e) => {
                                        if (e.origin === window.location.origin && e.data && e.data.type === 'marksheet-pdf-done') {
                                            clearTimeout(timer);
                                            this.downloading = false;
                                            window.removeEventListener('message', onDone);
                                        }
                                    };
                                    window.addEventListener('message', onDone);
                                    frame.src = url + (url.includes('?') ? '&' : '?') + '_t=' + Date.now();
                                }
                            }"
                        >
                            <div class="flex items-center gap-3">
                                <img src="{{ $result->qr_url ?? 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=' . urlencode(route('results.index', ['roll_no' => $result->roll_no])) }}" alt="QR" class="w-11 h-11 rounded border border-slate-200 p-0.5 bg-white shrink-0">
                                <div class="text-xs text-slate-500">
                                    <span class="font-semibold text-slate-800 block">{{ $result->institute_name ?: ($settings['instituteName'] ?? 'Saikat Computer & Training Jubo Songhoton') }}</span>
                                    <span>Roll: <strong class="font-mono text-slate-700">{{ $result->roll_no }}</strong></span>
                                </div>
                            </div>

                            <div class="w-full sm:w-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 shrink-0">
                                <a href="{{ route('results.print', $result->roll_no) }}" target="_blank" class="px-4 py-2.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs sm:text-sm transition flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-print"></i>
                                    <span>Print Marksheet</span>
                                </a>

                                <button
                                    type="button"
                                    @click="downloadMarksheet('{{ route('results.print', ['roll_no' => $result->roll_no, 'download' => 1]) }}')"
                                    :disabled="downloading"
                                    class="px-4 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 disabled:opacity-60 text-white font-semibold text-xs sm:text-sm transition flex items-center justify-center gap-2 cursor-pointer"
                                >
                                    <i class="fa-solid" :class="downloading ? 'fa-spinner fa-spin' : 'fa-download'"></i>
                                    <span x-text="downloading ? 'Downloading...' : 'Download PDF'"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endif

        <!-- Custom Verification Not-Found Popup Modal -->
        @if(!empty($notFoundError))
            <div
                x-data="{ open: true }"
                x-show="open"
                x-cloak
                @keydown.escape.window="open = false"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
                role="dialog"
                aria-modal="true"
                aria-labelledby="not-found-modal-title"
            >
                <div
                    x-show="open"
                    x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-150"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    @click="open = false"
                    class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs"
                ></div>

                <div
                    x-show="open"
                    x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                    class="relative w-full max-w-md bg-white rounded-2xl border border-slate-200 shadow-2xl overflow-hidden z-10"
                >
                    <div class="h-1.5 w-full bg-rose-600"></div>

                    <div class="p-6 text-center space-y-4">
                        <div class="w-12 h-12 mx-auto rounded-xl bg-rose-50 border border-rose-200 text-rose-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-file-circle-xmark"></i>
                        </div>

                        <div class="space-y-1.5">
                            <h3 id="not-found-modal-title" class="text-lg font-bold text-slate-900">
                                Result Not Found
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                {{ $notFoundError }}
                            </p>
                            @if(!empty($searchedTerm))
                                <div class="pt-1">
                                    <span class="inline-block px-3 py-1 rounded-lg bg-slate-100 border border-slate-200 font-mono text-xs font-semibold text-slate-800">
                                        Searched ID: {{ $searchedTerm }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs text-slate-600">
                            Helpline:
                            <a href="tel:{{ $settings['helplinePhone'] ?? '+8801712345678' }}" class="font-semibold text-emerald-700 hover:underline">
                                {{ $settings['helplinePhone'] ?? '+880 1712-345678' }}
                            </a>
                        </div>

                        <div class="flex items-center gap-2.5 pt-1">
                            <a
                                href="{{ route('results.index') }}"
                                class="flex-1 py-2.5 px-4 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs sm:text-sm transition text-center"
                            >
                                Reset
                            </a>
                            <button
                                type="button"
                                @click="open = false; $nextTick(() => { const el = document.getElementById('rollNoSearchInput'); if (el) { el.focus(); el.select(); } })"
                                class="flex-1 py-2.5 px-4 rounded-lg bg-slate-900 hover:bg-emerald-700 text-white font-semibold text-xs sm:text-sm transition cursor-pointer"
                            >
                                Try Again
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
