@extends('layouts.app')

@section('title', 'Academic & Technical Resource Repository - National Youth Platform')

@section('content')
<div class="w-full bg-[#F8FAFC] py-8 sm:py-12">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-14 space-y-8">
        
        <!-- Header Banner -->
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs sm:text-sm font-bold shadow-sm">
                <i class="fa-solid fa-file-pdf text-emerald-600"></i>
                <span>{{ $settings['resourcesPageBadge'] ?? 'Official Academic & Technical Downloads' }}</span>
            </div>

            <h1 class="text-2xl sm:text-4xl md:text-5xl font-black text-slate-900 tracking-tight">
                {{ $settings['resourcesPageTitle'] ?? 'Official Syllabus, Guidelines & Downloads' }}
            </h1>

            <p class="text-xs sm:text-base md:text-lg text-slate-600 font-normal leading-relaxed max-w-2xl mx-auto">
                {{ $settings['resourcesPageSubtitle'] ?? 'Access and download official technical curriculum syllabi, examination routines, offline admission forms, and practical workshop manuals.' }}
            </p>
        </div>

        <!-- Filter & Search Controls -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            
            <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                <a href="{{ route('resources.index') }}" class="px-3.5 py-2 rounded-xl text-xs sm:text-sm font-bold transition {{ !request('category') || request('category') === 'all' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    All Files ({{ $resources->total() }})
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('resources.index', ['category' => $cat]) }}" class="px-3.5 py-2 rounded-xl text-xs sm:text-sm font-bold transition {{ request('category') === $cat ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>

            <form action="{{ route('resources.index') }}" method="GET" class="w-full md:w-80 shrink-0">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search resources by title..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:outline-hidden focus:ring-2 focus:ring-emerald-500 font-medium">
                    <i class="fa-solid fa-search absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
                </div>
            </form>

        </div>

        <!-- Resources Cards List -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            @forelse($resources as $res)
                <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/90 shadow-sm hover:border-emerald-300 hover:shadow-md transition-all flex items-center justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl shrink-0 mt-0.5 border border-purple-100">
                            @if($res->file_type === 'PDF')
                                <i class="fa-solid fa-file-pdf"></i>
                            @elseif($res->file_type === 'DOCX')
                                <i class="fa-solid fa-file-word"></i>
                            @else
                                <i class="fa-solid fa-file-zipper"></i>
                            @endif
                        </div>
                        <div class="space-y-1.5">
                            <span class="text-[11px] font-bold text-emerald-700 uppercase tracking-wider bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded-md inline-block">
                                {{ $res->category }}
                            </span>
                            <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">
                                {{ $res->title }}
                            </h3>
                            <div class="flex items-center gap-3 text-xs text-slate-400 font-mono">
                                <span>Format: {{ $res->file_type }}</span>
                                <span>•</span>
                                <span>Size: {{ $res->file_size }}</span>
                            </div>
                        </div>
                    </div>

                    @if(!empty($res->download_url) && $res->download_url !== '#')
                        <a href="{{ $res->download_url }}" target="_blank" download class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-emerald-600 text-white font-bold text-xs transition shrink-0 flex items-center gap-2 shadow-xs">
                            <i class="fa-solid fa-download"></i>
                            <span class="hidden sm:inline">Download</span>
                        </a>
                    @else
                        <span class="px-3.5 py-2.5 rounded-xl bg-slate-100 text-slate-400 border border-slate-200 font-semibold text-xs shrink-0 flex items-center gap-1.5 cursor-not-allowed" title="File not uploaded yet">
                            <i class="fa-solid fa-file-circle-xmark"></i>
                            <span class="hidden sm:inline">Not Uploaded</span>
                        </span>
                    @endif
                </div>
            @empty
                <div class="col-span-2 text-center py-16 bg-white rounded-3xl border border-slate-200">
                    <i class="fa-solid fa-folder-open text-4xl text-slate-300 mb-2"></i>
                    <h3 class="text-base font-bold text-slate-700">No resources found</h3>
                </div>
            @endforelse
        </div>

        <div>
            {{ $resources->links() }}
        </div>

    </div>
</div>
@endsection
