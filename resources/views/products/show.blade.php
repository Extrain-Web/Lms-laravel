<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product['name'] ?? 'Product Details' }} - Pure Sip</title>
    {{-- Tailwind CSS CDN অথবা আপনার Vite অ্যাসেট --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f4faf4] selection:bg-[#183928] selection:text-white antialiased">

@if(empty($product))
    {{-- Product Not Found Screen --}}
    <main class="min-h-screen flex flex-col items-center justify-center p-6 text-center">
        <h2 class="text-2xl font-bold text-[#183928] mb-2">Product Not Found!</h2>
        <p class="text-gray-600 mb-6 text-sm">Please select the correct product from the homepage.</p>
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-bold text-white bg-[#183928] px-6 py-3 rounded-xl shadow-md hover:bg-emerald-950 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Back to Homepage</span>
        </a>
    </main>
@else
    {{-- Product Details Screen --}}
    <main class="min-h-screen py-10 px-4 sm:px-6 lg:px-12">
        <div class="max-w-6xl mx-auto space-y-8">
            
            {{-- Back Button --}}
            <div>
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-bold text-[#183928] bg-white px-5 py-2.5 rounded-full shadow-sm hover:shadow hover:bg-emerald-50 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Back to Homepage</span>
                </a>
            </div>

            {{-- Main Product Card --}}
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden grid grid-cols-1 lg:grid-cols-12 gap-8 p-6 sm:p-10">
                
                {{-- Left Side: Product Image & Badges --}}
                <div class="lg:col-span-5 space-y-6">
                    <div class="relative w-full aspect-[3/4] rounded-2xl overflow-hidden shadow-md bg-gray-50 border border-emerald-900/10">
                        <img 
                            src="{{ asset($product['image'] ?? '') }}" 
                            alt="{{ $product['name'] ?? '' }}" 
                            class="w-full h-full object-cover object-center"
                        >
                        <div class="absolute top-4 right-4 bg-[#183928] text-white text-xs font-bold px-3.5 py-1.5 rounded-full shadow">
                            Price: {{ $product['price'] ?? '' }}
                        </div>
                    </div>

                    {{-- Highlighted Feature Badges --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3.5 bg-[#eef7ef] rounded-xl border border-emerald-900/10 flex items-center gap-2.5">
                            <svg class="w-5 h-5 text-[#183928]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span class="text-xs font-bold text-[#183928]">100% Safe</span>
                        </div>
                        <div class="p-3.5 bg-[#eef7ef] rounded-xl border border-emerald-900/10 flex items-center gap-2.5">
                            <svg class="w-5 h-5 text-[#183928]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            <span class="text-xs font-bold text-[#183928]">Natural Ingredients</span>
                        </div>
                    </div>
                </div>

                {{-- Right Side: Detailed Description & Benefits --}}
                <div class="lg:col-span-7 space-y-6 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="space-y-1">
                            <span class="text-xs font-extrabold text-[#e0564c] tracking-widest uppercase">
                                Pure Sip Beverage
                            </span>
                            <h1 class="text-3xl sm:text-4xl font-black text-[#112318] tracking-tight">
                                {{ $product['name'] ?? '' }}
                            </h1>
                            <p class="text-sm font-semibold text-emerald-800">
                                {{ $product['tagline'] ?? '' }}
                            </p>
                        </div>

                        {{-- Price & Packaging Info --}}
                        <div class="flex items-center gap-4 py-2 border-y border-gray-100">
                            <div class="text-2xl font-black text-[#183928]">
                                {{ $product['price'] ?? '' }} <span class="text-xs text-gray-500 font-normal">/ per pack</span>
                            </div>
                            <div class="text-xs font-semibold text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                                Packaging: Premium Chilled Pouch
                            </div>
                        </div>

                        {{-- Short Description --}}
                        <p class="text-gray-700 text-sm sm:text-base leading-relaxed">
                            {{ $product['shortDescription'] ?? '' }}
                        </p>

                        {{-- Used Ingredients --}}
                        <div class="space-y-2 pt-2">
                            <h3 class="text-sm font-bold text-[#112318] flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                <span>Used Natural Ingredients:</span>
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                @foreach($product['ingredients'] ?? [] as $ing)
                                    <div class="p-2.5 bg-gray-50 rounded-lg border border-gray-100 text-xs">
                                        <p class="font-bold text-[#183928]">{{ $ing['name'] }}</p>
                                        <p class="text-gray-500 text-[11px]">{{ $ing['desc'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Health Benefits --}}
                        <div class="space-y-2 pt-2">
                            <h3 class="text-sm font-bold text-[#112318] flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Health Benefits:</span>
                            </h3>
                            <ul class="space-y-1.5 text-xs sm:text-sm text-gray-700">
                                @foreach($product['benefits'] ?? [] as $b)
                                    <li class="flex items-start gap-2">
                                        <span class="text-emerald-600 font-bold">•</span>
                                        <span>{{ $b }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    {{-- Manufacturer & Helpline --}}
                    <div class="bg-[#183928] text-white p-5 rounded-2xl space-y-3 mt-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[11px] text-emerald-200">Prepared & Marketed by:</p>
                                <p class="text-xs font-bold">{{ $product['manufacturer'] ?? 'Pure Sip Beverage' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[11px] text-emerald-200">Storage Method:</p>
                                <p class="text-xs font-semibold">Keep in Refrigerator</p>
                            </div>
                        </div>
                        <div class="pt-2 border-t border-white/10 flex items-center justify-between text-xs">
                            <span class="flex items-center gap-1.5 text-emerald-100">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                Helpline & Dealership:
                            </span>
                            <span class="font-bold tracking-wider">{{ $product['helpline'] ?? '+880 1XXX-XXXXXX' }}</span>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </main>
@endif

</body>
</html>