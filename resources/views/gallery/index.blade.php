@extends('layouts.app')

@section('title', 'Campus & Technical Training Gallery - National Youth Platform')

@section('content')
<div class="w-full bg-[#F8FAFC] py-8 sm:py-12">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-14 space-y-8" x-data="{ selectedImage: null }">
        
        <!-- Header Banner -->
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs sm:text-sm font-bold shadow-sm">
                <i class="fa-solid fa-camera text-emerald-600"></i>
                <span>{{ $settings['galleryPageBadge'] ?? 'Campus & Technical Training Gallery' }}</span>
            </div>

            <h1 class="text-2xl sm:text-4xl md:text-5xl font-black text-slate-900 tracking-tight">
                {{ $settings['galleryPageTitle'] ?? 'Visual Glimpses of Vocational Excellence' }}
            </h1>

            <p class="text-xs sm:text-base md:text-lg text-slate-600 font-normal leading-relaxed max-w-2xl mx-auto">
                {{ $settings['galleryPageSubtitle'] ?? 'Take a visual tour across our computer labs, industrial automation workshops, heavy fabrication bays, and nationwide youth convocation ceremonies.' }}
            </p>
        </div>

        <!-- Category Tabs -->
        <div class="flex flex-wrap items-center justify-center gap-2">
            <a href="{{ route('gallery.index') }}" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition {{ !request('category') || request('category') === 'all' ? 'bg-slate-900 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-100' }}">
                All Media ({{ $items->count() }})
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('gallery.index', ['category' => $cat]) }}" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition {{ request('category') === $cat ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-100' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        <!-- Gallery Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @foreach($items as $item)
                @php
                    $displayDesc = $item->description ?: $item->caption;
                @endphp
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden group cursor-pointer hover:shadow-xl transition-all duration-300" @click="selectedImage = { url: {{ json_encode($item->image_url) }}, title: {{ json_encode($item->title) }}, caption: {{ json_encode($displayDesc) }}, cat: {{ json_encode($item->category) }} }">
                    <div class="relative h-60 overflow-hidden bg-slate-100">
                        <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-5">
                            <span class="text-white text-xs font-bold flex items-center gap-2">
                                <i class="fa-solid fa-expand text-emerald-400"></i> Click to Zoom Fullscreen
                            </span>
                        </div>
                        <span class="absolute top-3.5 left-3.5 bg-slate-950/80 backdrop-blur-md text-emerald-400 text-xs font-black px-3 py-1 rounded-full uppercase border border-emerald-400/20">
                            {{ $item->category }}
                        </span>
                    </div>
                    <div class="p-5 sm:p-6 space-y-1.5">
                        <h3 class="font-extrabold text-base sm:text-lg text-slate-900 group-hover:text-emerald-600 transition">{{ $item->title }}</h3>
                        <p class="text-xs sm:text-sm text-slate-500 line-clamp-2 leading-relaxed">{{ $displayDesc }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Lightbox Zoom Modal -->
        <div x-show="selectedImage" x-cloak class="fixed inset-0 z-50 bg-black/90 backdrop-blur-md flex items-center justify-center p-4">
            <div @click.away="selectedImage = null" class="max-w-4xl w-full bg-slate-950 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl">
                <div class="relative h-[65vh] bg-black flex items-center justify-center">
                    <img :src="selectedImage?.url" alt="" class="max-w-full max-h-full object-contain">
                    <button type="button" @click="selectedImage = null" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-slate-900/80 text-white flex items-center justify-center hover:bg-rose-600 transition">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
                <div class="p-6 bg-slate-900 text-white space-y-2">
                    <span class="text-xs text-emerald-400 font-bold uppercase tracking-wider" x-text="selectedImage?.cat"></span>
                    <h3 class="text-xl font-black" x-text="selectedImage?.title"></h3>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed" x-text="selectedImage?.caption"></p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
