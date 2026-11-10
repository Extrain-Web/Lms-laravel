<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Academic Transcript - {{ $result->student_name }} ({{ $result->roll_no }})</title>
    <link rel="icon" type="image/png" href="/favicon.png?v=2">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico?v=2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
        }
        body {
            font-family: 'Plus Jakarta Sans', 'Hind Siliguri', sans-serif;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .font-serif-formal {
            font-family: 'Cormorant Garamond', Georgia, serif;
        }
        .a4-sheet {
            width: 100%;
            max-width: 210mm;
            min-height: 266mm;
        }
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .a4-sheet {
                max-width: 100% !important;
                min-height: 268mm !important;
                box-shadow: none !important;
                margin: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 py-5 px-3 sm:px-6">

    <!-- Screen-Only Action Bar -->
    <div class="no-print max-w-[210mm] mx-auto mb-4 bg-slate-900 text-white px-4 sm:px-5 py-3 rounded-2xl shadow-lg flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-2.5 text-xs sm:text-sm">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
            <span class="font-bold">Official A4 Transcript Preview</span>
            <span class="hidden sm:inline text-slate-400 text-xs font-mono">• {{ $result->roll_no }}</span>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('results.index', ['roll_no' => $result->roll_no]) }}" class="px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold transition flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left text-[11px]"></i>
                <span>Back to Portal</span>
            </a>
            <button type="button" onclick="downloadTranscriptPdf()" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                <i class="fa-solid fa-download text-[11px]"></i>
                <span>Download PDF</span>
            </button>
            <button type="button" onclick="window.print()" class="px-4 py-2 rounded-xl bg-slate-700 hover:bg-slate-600 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                <i class="fa-solid fa-print text-[11px]"></i>
                <span>Print</span>
            </button>
        </div>
    </div>

    @php
        $orgTitle = $settings['footerBrandTitle'] ?? 'National Youth Development Platform';
        $instituteTitle = $result->institute_name ?: ($settings['instituteName'] ?? 'Saikat Computer & Training Jubo Songhoton');
        $accreditationText = $settings['footerAccreditationBadge'] ?? 'Govt. Reg. Affiliated Technical Directorate';
        $logoBadgeText = $settings['headerLogoText'] ?? 'NYD';
        $branchName = $result->center ?: $instituteTitle;
        $verifyUrl = route('results.index', ['roll_no' => $result->roll_no]);
        $qrSrc = $inlinedQr ?? ($result->qr_url ?: ('https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=' . urlencode($verifyUrl)));
        $logoSrc = $inlinedLogo ?? ($settings['headerLogoImage'] ?? '');
        $photoSrc = $inlinedPhoto ?? $result->photo;
    @endphp

    <!-- Printable A4 Transcript Sheet -->
    <div id="a4TranscriptSheet" class="a4-sheet mx-auto bg-white {{ !empty($isDownload) ? 'p-0 border-0' : 'shadow-2xl p-2 sm:p-3 print:p-0 border border-slate-300 print:border-0' }}">
        <!-- Outer Formal Double Border -->
        <div class="h-full min-h-[264mm] border-[2.5px] border-emerald-950 p-1 relative flex flex-col justify-between">
            <div class="h-full min-h-[260mm] border border-emerald-800/50 px-6 py-5 sm:px-8 sm:py-6 relative flex flex-col justify-between overflow-hidden">

                <!-- Subtle Corner Ornaments -->
                <div class="pointer-events-none absolute top-2 left-2 w-4 h-4 border-t-2 border-l-2 border-amber-600/70"></div>
                <div class="pointer-events-none absolute top-2 right-2 w-4 h-4 border-t-2 border-r-2 border-amber-600/70"></div>
                <div class="pointer-events-none absolute bottom-2 left-2 w-4 h-4 border-b-2 border-l-2 border-amber-600/70"></div>
                <div class="pointer-events-none absolute bottom-2 right-2 w-4 h-4 border-b-2 border-r-2 border-amber-600/70"></div>

                <!-- Faint Background Watermark -->
                <div class="pointer-events-none absolute inset-0 flex items-center justify-center opacity-[0.035] select-none">
                    <div class="w-80 h-80 rounded-full border-[12px] border-emerald-950 flex flex-col items-center justify-center text-center p-6">
                        <span class="text-6xl font-black tracking-widest text-emerald-950">{{ $logoBadgeText }}</span>
                        <span class="text-xs font-extrabold uppercase tracking-[0.25em] text-emerald-950 mt-2">Verified Academic Record</span>
                    </div>
                </div>

                <!-- TOP & MIDDLE CONTENT GROUP -->
                <div class="relative z-10 space-y-5">

                    <!-- 1. FORMAL ENGLISH INSTITUTIONAL HEADER -->
                    <header class="pb-4 border-b-2 border-emerald-950 relative">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4 min-w-0">
                                @if(!empty($logoSrc))
                                    <img src="{{ $logoSrc }}" alt="{{ $logoBadgeText }}" class="h-16 w-auto max-w-[96px] object-contain rounded-lg border border-slate-200 p-1 bg-white shrink-0">
                                @else
                                    <div class="w-16 h-16 rounded-xl bg-emerald-950 text-white border-2 border-amber-500/60 flex flex-col items-center justify-center shrink-0 shadow-xs">
                                        <span class="font-black text-xl tracking-wider leading-none">{{ $logoBadgeText }}</span>
                                        <span class="text-[7px] uppercase tracking-[0.2em] text-amber-300 font-bold mt-1">Portal</span>
                                    </div>
                                @endif

                                <div class="min-w-0">
                                    <p class="text-[9.5px] font-extrabold uppercase tracking-[0.16em] text-emerald-800">
                                        {{ $accreditationText }}
                                    </p>
                                    <h1 class="text-xl sm:text-[22px] font-black text-slate-950 uppercase tracking-tight leading-tight mt-0.5">
                                        {{ $orgTitle }}
                                    </h1>
                                    <p class="text-xs font-bold text-slate-800 mt-0.5">
                                        Affiliated Institute: {{ $instituteTitle }}
                                    </p>
                                    <p class="text-[10px] text-slate-500 mt-0.5">
                                        Approved under Technical &amp; Vocational Education Framework, Government of Bangladesh
                                    </p>
                                </div>
                            </div>

                            <!-- QR Verification Block -->
                            <div class="shrink-0 text-center bg-slate-50 border border-slate-300 rounded-lg p-1.5">
                                <img src="{{ $qrSrc }}" alt="Verification QR" class="w-16 h-16 mx-auto bg-white p-0.5 border border-slate-200">
                                <span class="text-[8px] font-mono font-extrabold text-emerald-900 tracking-wider block mt-1">SCAN TO VERIFY</span>
                            </div>
                        </div>
                        <div class="absolute bottom-0.5 left-0 right-0 h-[1.5px] bg-amber-600/50"></div>
                    </header>

                    <!-- 2. DOCUMENT TITLE & REFERENCE STRIP -->
                    <section class="text-center space-y-2">
                        <div class="flex items-center justify-center gap-3">
                            <span class="h-px flex-1 bg-slate-300"></span>
                            <h2 class="font-serif-formal text-2xl font-bold tracking-wide text-slate-950 uppercase px-2">
                                Academic Transcript &amp; Provisional Marksheet
                            </h2>
                            <span class="h-px flex-1 bg-slate-300"></span>
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-2 bg-slate-900 text-white px-4 py-2 rounded-lg text-[10.5px]">
                            <div>
                                <span class="text-slate-400 uppercase tracking-wider font-semibold">Transcript ID:</span>
                                <strong class="font-mono text-white ml-1">{{ $result->roll_no }}</strong>
                            </div>
                            <div>
                                <span class="text-slate-400 uppercase tracking-wider font-semibold">Session:</span>
                                <strong class="text-white ml-1">{{ $result->session }} ({{ $result->exam_year }})</strong>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                <span class="font-extrabold tracking-wider text-emerald-300 uppercase">{{ $result->verification_status ?? 'VERIFIED & AUTHENTIC' }}</span>
                            </div>
                        </div>
                    </section>

                    <!-- 3. CANDIDATE & ACADEMIC PARTICULARS + PASSPORT PHOTO -->
                    <section class="grid grid-cols-12 gap-4 items-stretch">
                        <div class="col-span-9">
                            <table class="w-full h-full border-collapse border border-slate-300 text-[11px]">
                                <tbody>
                                    <tr>
                                        <th class="w-[32%] bg-slate-100/90 text-slate-700 font-bold text-left px-3 py-1.5 border border-slate-300 uppercase text-[10px] whitespace-nowrap">
                                            Student Name
                                        </th>
                                        <td class="px-3 py-1.5 border border-slate-300 font-extrabold text-slate-950 text-xs tracking-wide uppercase">
                                            {{ $result->student_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-slate-100/90 text-slate-700 font-bold text-left px-3 py-1.5 border border-slate-300 uppercase text-[10px] whitespace-nowrap">
                                            Roll Number
                                        </th>
                                        <td class="px-3 py-1.5 border border-slate-300 font-mono font-extrabold text-slate-950 whitespace-nowrap">
                                            {{ $result->roll_no }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-slate-100/90 text-slate-700 font-bold text-left px-3 py-1.5 border border-slate-300 uppercase text-[10px] whitespace-nowrap">
                                            Registration No
                                        </th>
                                        <td class="px-3 py-1.5 border border-slate-300 font-mono font-bold text-slate-900 whitespace-nowrap">
                                            {{ $result->reg_no }}
                                        </td>
                                    </tr>
                                    @if(!empty($result->father_name) && $result->father_name !== '-')
                                        <tr>
                                            <th class="bg-slate-100/90 text-slate-700 font-bold text-left px-3 py-1.5 border border-slate-300 uppercase text-[10px] whitespace-nowrap">
                                                Father's Name
                                            </th>
                                            <td class="px-3 py-1.5 border border-slate-300 font-semibold text-slate-800">
                                                {{ $result->father_name }}
                                            </td>
                                        </tr>
                                    @endif
                                    @if(!empty($result->mother_name) && $result->mother_name !== '-')
                                        <tr>
                                            <th class="bg-slate-100/90 text-slate-700 font-bold text-left px-3 py-1.5 border border-slate-300 uppercase text-[10px] whitespace-nowrap">
                                                Mother's Name
                                            </th>
                                            <td class="px-3 py-1.5 border border-slate-300 font-semibold text-slate-800">
                                                {{ $result->mother_name }}
                                            </td>
                                        </tr>
                                    @endif
                                    @if(!empty($result->course_code))
                                        <tr>
                                            <th class="bg-slate-100/90 text-slate-700 font-bold text-left px-3 py-1.5 border border-slate-300 uppercase text-[10px] whitespace-nowrap">
                                                Course Code
                                            </th>
                                            <td class="px-3 py-1.5 border border-slate-300 font-mono font-bold text-emerald-900 whitespace-nowrap">
                                                {{ $result->course_code }}
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th class="bg-slate-100/90 text-slate-700 font-bold text-left px-3 py-1.5 border border-slate-300 uppercase text-[10px] whitespace-nowrap">
                                            Course / Trade
                                        </th>
                                        <td class="px-3 py-1.5 border border-slate-300 font-bold text-slate-950">
                                            {{ $result->trade }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-slate-100/90 text-slate-700 font-bold text-left px-3 py-1.5 border border-slate-300 uppercase text-[10px] whitespace-nowrap">
                                            Branch / Center
                                        </th>
                                        <td class="px-3 py-1.5 border border-slate-300 font-semibold text-slate-800">
                                            {{ $branchName }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-slate-100/90 text-slate-700 font-bold text-left px-3 py-1.5 border border-slate-300 uppercase text-[10px] whitespace-nowrap">
                                            Issue Date
                                        </th>
                                        <td class="px-3 py-1.5 border border-slate-300 font-mono font-semibold text-slate-800 whitespace-nowrap">
                                            {{ $result->issue_date }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Framed Passport Photo -->
                        <div class="col-span-3 border border-slate-300 bg-slate-50/70 rounded-lg p-3 flex flex-col items-center justify-center text-center">
                            @if(!empty($photoSrc))
                                <img src="{{ $photoSrc }}" alt="{{ $result->student_name }}" class="w-32 h-40 object-cover object-top rounded-md border border-slate-300 bg-white shadow-2xs">
                            @else
                                <div class="w-32 h-40 rounded-md border border-dashed border-slate-300 bg-white flex flex-col items-center justify-center text-[10px] text-slate-400 p-2">
                                    <i class="fa-solid fa-user-tie text-3xl text-slate-300 mb-1.5"></i>
                                    <span>Candidate Photo</span>
                                </div>
                            @endif
                            <span class="text-[8.5px] font-bold uppercase tracking-wider text-slate-500 mt-2 block">
                                Candidate Photograph
                            </span>
                        </div>
                    </section>

                    <!-- 4. EXAMINATION RESULT SUMMARY KPI BAR (Clean, Non-Wrapping) -->
                    <section class="space-y-1.5">
                        <h3 class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-slate-600">
                            Examination Result Summary
                        </h3>
                        <div class="grid {{ !empty($result->result_score) ? 'grid-cols-4' : 'grid-cols-3' }} border border-emerald-950/30 rounded-lg overflow-hidden divide-x divide-slate-300 bg-emerald-50/40 text-center">
                            @if(!empty($result->result_score))
                                <div class="px-3 py-2.5">
                                    <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-500 block">Marks / Score</span>
                                    <strong class="text-base font-black text-slate-950 font-mono whitespace-nowrap mt-0.5 block">{{ $result->result_score }}</strong>
                                </div>
                            @endif
                            <div class="px-3 py-2.5">
                                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-500 block">CGPA (Scale 4.00)</span>
                                <strong class="text-base font-black text-emerald-900 font-mono whitespace-nowrap mt-0.5 block">{{ number_format($result->gpa, 2) }}</strong>
                            </div>
                            <div class="px-3 py-2.5">
                                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-500 block">Letter Grade</span>
                                <span class="inline-block mt-0.5 px-3 py-0.5 rounded bg-emerald-800 text-white font-mono font-black text-xs whitespace-nowrap">{{ $result->grade }}</span>
                            </div>
                            <div class="px-3 py-2.5">
                                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-500 block">Result Status</span>
                                <span class="inline-block mt-0.5 px-3 py-0.5 rounded bg-slate-900 text-emerald-300 font-extrabold text-[10px] tracking-wider uppercase whitespace-nowrap">PASSED</span>
                            </div>
                        </div>
                    </section>

                    <!-- 5. SUBJECT-WISE MARKSHEET OR FORMAL CERTIFICATION STATEMENT -->
                    @if(!empty($result->marks))
                        <section class="space-y-1.5">
                            <h3 class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-slate-600">
                                Subject-Wise Marksheet Breakdown
                            </h3>
                            <table class="w-full text-left text-[11px] border-collapse border border-slate-300">
                                <thead class="bg-slate-900 text-white font-bold uppercase tracking-wider text-[10px]">
                                    <tr>
                                        <th class="w-10 px-2.5 py-2 text-center border border-slate-600">SL</th>
                                        <th class="px-3 py-2 border border-slate-600">Subject / Module Name</th>
                                        <th class="w-24 px-3 py-2 text-center border border-slate-600">Full Marks</th>
                                        <th class="w-28 px-3 py-2 text-center border border-slate-600">Obtained</th>
                                        <th class="w-24 px-3 py-2 text-center border border-slate-600">Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($result->marks as $idx => $m)
                                        <tr class="{{ $idx % 2 === 1 ? 'bg-slate-50/80' : 'bg-white' }}">
                                            <td class="px-2.5 py-2 text-center font-mono text-slate-500 border border-slate-300">{{ str_pad((string)($idx + 1), 2, '0', STR_PAD_LEFT) }}</td>
                                            <td class="px-3 py-2 font-bold text-slate-900 border border-slate-300">{{ $m['subject'] }}</td>
                                            <td class="px-3 py-2 text-center font-mono text-slate-600 border border-slate-300">{{ $m['fullMarks'] ?? 100 }}</td>
                                            <td class="px-3 py-2 text-center font-mono font-bold text-slate-950 border border-slate-300">{{ $m['obtained'] }}</td>
                                            <td class="px-3 py-2 text-center font-bold text-emerald-800 border border-slate-300">{{ $m['grade'] }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="bg-emerald-50/70 font-black border-t-2 border-slate-900">
                                        <td colspan="2" class="px-3 py-2 uppercase text-[10.5px] text-slate-900 border border-slate-300">
                                            Cumulative Grade Point Average (CGPA)
                                        </td>
                                        <td colspan="2" class="px-3 py-2 text-center font-semibold text-slate-700 border border-slate-300">
                                            Evaluation Scale: 4.00
                                        </td>
                                        <td class="px-3 py-2 text-center font-mono text-xs border border-slate-300 text-emerald-950 whitespace-nowrap">
                                            {{ number_format($result->gpa, 2) }} ({{ $result->grade }})
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </section>
                    @else
                        <section class="border border-slate-300 bg-slate-50/60 rounded-lg p-4 space-y-1.5">
                            <h3 class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-emerald-900">
                                Official Certification Statement
                            </h3>
                            <p class="text-[11.5px] text-slate-700 leading-relaxed text-justify">
                                This is to certify that <strong class="text-slate-950">{{ $result->student_name }}</strong>, bearing Roll No. <strong class="font-mono text-slate-950">{{ $result->roll_no }}</strong> and Registration No. <strong class="font-mono text-slate-950">{{ $result->reg_no }}</strong>, has successfully fulfilled all prescribed theoretical, practical, and final assessment requirements for the program <strong class="text-slate-950">{{ $result->trade }}</strong> during the <strong class="text-slate-950">{{ $result->session }} ({{ $result->exam_year }})</strong> examination session conducted under <strong class="text-slate-950">{{ $branchName }}</strong>, achieving Grade <strong class="text-emerald-900">{{ $result->grade }}</strong> with a Cumulative GPA of <strong class="text-emerald-900">{{ number_format($result->gpa, 2) }} / 4.00</strong>.
                            </p>
                        </section>
                    @endif

                </div>

                <!-- BOTTOM ANCHORED SECTION: SIGNATURES & FOOTER -->
                <div class="relative z-10 space-y-5 pt-4">

                    <!-- 6. AUTHORIZED SIGNATURES & DIRECTORATE SEAL -->
                    <footer class="pt-6">
                        <div class="flex items-end justify-between gap-4 text-center text-xs">
                            <div class="w-44 space-y-1">
                                <div class="h-8"></div>
                                <div class="border-t border-slate-900 pt-1.5">
                                    <div class="font-extrabold text-slate-900 text-[11px]">Checked &amp; Verified By</div>
                                    <div class="text-[9.5px] text-slate-500">Exam Directorate Section</div>
                                </div>
                            </div>

                            <!-- Formal Double-Ring Stamp -->
                            <div class="w-24 h-24 rounded-full border-[3px] border-double border-emerald-900/70 bg-emerald-50/30 flex flex-col items-center justify-center text-emerald-950 uppercase text-center p-2 shrink-0">
                                <span class="text-[7px] font-bold tracking-widest text-emerald-800">{{ $logoBadgeText }}</span>
                                <span class="text-[8.5px] font-black leading-tight my-0.5">Official Directorate Seal</span>
                                <span class="text-[7px] font-mono font-bold text-emerald-800">Verified</span>
                            </div>

                            <div class="w-44 space-y-1">
                                <div class="h-8"></div>
                                <div class="border-t border-slate-900 pt-1.5">
                                    <div class="font-extrabold text-slate-900 text-[11px]">Controller of Examinations</div>
                                    <div class="text-[9.5px] text-slate-500">{{ $orgTitle }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-2 border-t border-slate-200 flex items-center justify-between text-[9px] text-slate-500 font-mono">
                            <span>Digitally Verifiable Record • Roll: {{ $result->roll_no }} • Reg: {{ $result->reg_no }}</span>
                            <span>Printed: {{ date('Y-m-d') }}</span>
                        </div>
                    </footer>

                </div>

            </div>
        </div>
    </div>

    <script>
        function downloadTranscriptPdf() {
            var element = document.getElementById('a4TranscriptSheet');
            if (!element || typeof html2pdf === 'undefined') {
                if (window.parent === window) {
                    window.print();
                }
                return Promise.resolve();
            }

            var safeRoll = @json(preg_replace('/[^A-Za-z0-9_-]+/', '-', $result->roll_no));
            var prevShadow = element.style.boxShadow;
            var prevBorder = element.style.borderWidth;
            var prevPadding = element.style.padding;
            element.style.boxShadow = 'none';
            element.style.borderWidth = '0px';
            element.style.padding = '0px';

            var opt = {
                margin: [4, 5, 4, 5],
                filename: 'Marksheet-' + safeRoll + '.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true, logging: false, backgroundColor: '#ffffff' },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            return html2pdf().set(opt).from(element).save().finally(function () {
                element.style.boxShadow = prevShadow;
                element.style.borderWidth = prevBorder;
                element.style.padding = prevPadding;
            });
        }

        window.addEventListener('load', function () {
            var isDownloadMode = @json(!empty($isDownload));
            setTimeout(function () {
                if (isDownloadMode) {
                    downloadTranscriptPdf().finally(function () {
                        if (window.parent && window.parent !== window) {
                            window.parent.postMessage({ type: 'marksheet-pdf-done' }, window.location.origin);
                        }
                    });
                } else {
                    window.print();
                }
            }, 350);
        });
    </script>
</body>
</html>
