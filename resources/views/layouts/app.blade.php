<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Primary Meta Tags -->
    <title>@yield('meta_title', \App\Models\SiteSetting::get('site_title', 'PT Nusantara LNG Energi — Integrated Liquefied Natural Gas Supply & Cryogenic Logistics'))</title>
    <meta name="title" content="@yield('meta_title', \App\Models\SiteSetting::get('site_title', 'PT Nusantara LNG Energi — Integrated Liquefied Natural Gas Supply & Cryogenic Logistics'))">
    <meta name="description" content="@yield('meta_description', \App\Models\SiteSetting::get('meta_description_default', 'PT Nusantara LNG Energi provides world-class liquefied natural gas (LNG) bulk supply, cryogenic ISO tank virtual pipelines, regasification terminals, and marine bunkering solutions.'))">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ \App\Models\SiteSetting::get('company_name', 'PT Nusantara LNG Energi') }}">
    <meta property="og:title" content="@yield('meta_title', \App\Models\SiteSetting::get('site_title', 'PT Nusantara LNG Energi'))">
    <meta property="og:description" content="@yield('meta_description', \App\Models\SiteSetting::get('meta_description_default', 'Integrated LNG Supply & Cryogenic Infrastructure in Indonesia.'))">
    <meta property="og:image" content="@yield('meta_image', asset('images/lng/carrier.jpg'))">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('meta_title', \App\Models\SiteSetting::get('site_title', 'PT Nusantara LNG Energi'))">
    <meta name="twitter:description" content="@yield('meta_description', \App\Models\SiteSetting::get('meta_description_default', 'Integrated LNG Supply & Cryogenic Infrastructure in Indonesia.'))">
    <meta name="twitter:image" content="@yield('meta_image', asset('images/lng/carrier.jpg'))">

    <!-- Favicon (Stylized N Emblem) -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' fill='%23000'/><text y='65' x='22' font-size='56' fill='%23fff' font-family='sans-serif' font-weight='bold'>N</text></svg>">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Swiper.js CSS (via CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Tailwind CSS (CDN Runtime Engine with Custom Theme) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#0A0A0A",
                        secondary: "#111111",
                        accent: "#B08D57",
                        "accent-dark": "#967543",
                        "neutral-body": "#6B7280",
                        "neutral-bg": "#F8F9FA",
                        "neutral-dark": "#0A0A0A",
                    },
                    fontFamily: {
                        sans: ["Inter", "system-ui", "-apple-system", "sans-serif"],
                        display: ["Inter", "sans-serif"],
                    },
                    letterSpacing: {
                        widest2: "0.25em",
                        widest3: "0.35em",
                    },
                }
            }
        }
    </script>

    <!-- Custom & Animation CSS Rules -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ file_exists(public_path('css/app.css')) ? filemtime(public_path('css/app.css')) : time() }}">

    <!-- Alpine.js (via CDN) -->
    <script defer src="https://unpkg.com/alpinejs@3.14.3/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="bg-white text-[#111111] font-sans antialiased selection:bg-black selection:text-white flex flex-col min-h-screen">
    
    <!-- Flash Messages / Notification Banner -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
             class="fixed bottom-6 right-6 z-50 bg-black text-white px-6 py-4 rounded-none shadow-2xl flex items-center gap-4 text-xs tracking-wider uppercase border border-neutral-800 transition-all">
            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>{{ session('success') }}</span>
            <button @click="show = false" class="text-neutral-400 hover:text-white ml-2 text-sm">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
             class="fixed bottom-6 right-6 z-50 bg-red-950 text-red-200 px-6 py-4 rounded-none shadow-2xl flex items-center gap-4 text-xs tracking-wider uppercase border border-red-800 transition-all">
            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            <span>{{ session('error') }}</span>
            <button @click="show = false" class="text-neutral-400 hover:text-white ml-2 text-sm">&times;</button>
        </div>
    @endif

    <!-- 1. Global Navigation Header -->
    @include('partials.header')

    <!-- 2. Main Page Content Container -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- 3. Global Footer -->
    @include('partials.footer')

    <!-- 4. Interactive AI Chatbot Widget (Powered by Gemini) -->
    @include('partials.chatbot')

    <!-- Swiper.js JS (via CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
