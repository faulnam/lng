<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-neutral-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') — Nusantara LNG CMS</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Quill Rich Text Editor CSS (via CDN) -->
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

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

    <!-- Compiled CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ file_exists(public_path('css/app.css')) ? filemtime(public_path('css/app.css')) : time() }}">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.14.3/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="h-full font-sans bg-neutral-950 text-neutral-100 antialiased" x-data="{ sidebarOpen: false }">
    
    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false" 
         class="fixed inset-0 z-40 bg-black/80 lg:hidden" x-cloak></div>

    <div class="flex h-full">
        
        <!-- Sidebar Navigation -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed inset-y-0 left-0 z-50 w-64 bg-neutral-900 border-r border-neutral-800 flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto">
            
            <!-- Logo / Brand Header -->
            <div class="h-16 flex items-center justify-between px-6 border-b border-neutral-800">
                <a href="{{ url('/admin') }}" class="flex items-center gap-3">
                    <div class="w-7 h-7 bg-white text-black font-bold flex items-center justify-center text-xs tracking-tighter">
                        N
                    </div>
                    <span class="font-extrabold tracking-[0.18em] text-xs text-white">NUSANTARA CMS</span>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-neutral-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto text-xs font-medium">
                
                <div class="px-3 pb-2 text-[10px] uppercase tracking-widest text-neutral-500 font-semibold">Core</div>
                
                <a href="{{ url('/admin') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-none text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>Dashboard</span>
                </a>

                <div class="pt-5 px-3 pb-2 text-[10px] uppercase tracking-widest text-neutral-500 font-semibold">Content Management</div>

                <a href="{{ url('/admin/projects') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-none text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/projects*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <span>Products &amp; Lines</span>
                </a>

                <a href="{{ url('/admin/services') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-none text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/services*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    <span>Product Categories (2-Level)</span>
                </a>

                <a href="{{ url('/admin/clients') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-none text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/clients*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span>Strategic Offtakers &amp; Logos</span>
                </a>

                <a href="{{ url('/admin/blog-posts') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-none text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/blog-posts*') || request()->is('admin/blog-categories*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    <span>Energy Insights &amp; Articles</span>
                </a>

                <a href="{{ url('/admin/hero-slides') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-none text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/hero-slides*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Hero Banners</span>
                </a>

                <a href="{{ url('/admin/testimonials') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-none text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/testimonials*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    <span>Offtaker Endorsements</span>
                </a>

                <div class="pt-5 px-3 pb-2 text-[10px] uppercase tracking-widest text-neutral-500 font-semibold">Site Configuration</div>

                <a href="{{ url('/admin/settings') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-none text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/settings*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Site Settings (Stats &amp; Info)</span>
                </a>

                <a href="{{ url('/admin/page-contents') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-none text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/page-contents*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <span>Page Copywriting</span>
                </a>

                <a href="{{ url('/admin/messages') }}" 
                   class="flex items-center justify-between px-3 py-2.5 rounded-none text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/messages*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>Commercial Inquiries</span>
                    </div>
                    @php $unreadCount = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
                    @if($unreadCount > 0)
                        <span class="bg-accent text-black text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $unreadCount }}</span>
                    @endif
                </a>

                @if(auth()->check() && auth()->user()->isSuperAdmin())
                    <div class="pt-5 px-3 pb-2 text-[10px] uppercase tracking-widest text-neutral-500 font-semibold">User Administration</div>

                    <a href="{{ url('/admin/users') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-none text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors {{ request()->is('admin/users*') ? 'bg-neutral-800 text-white font-semibold' : '' }}">
                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span>Admin Users</span>
                    </a>
                @endif

            </nav>

            <!-- User Info / Bottom Section -->
            <div class="p-4 border-t border-neutral-800 flex items-center justify-between text-xs">
                <div class="truncate">
                    <div class="font-medium text-white truncate">{{ auth()->user()->name ?? 'Administrator' }}</div>
                    <div class="text-[10px] text-neutral-400 capitalize">{{ auth()->user()->role ?? 'super_admin' }}</div>
                </div>
                <form action="{{ url('/admin/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="p-1.5 text-neutral-400 hover:text-red-400 transition-colors" title="Sign Out">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>

        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-neutral-950">
            
            <!-- Topbar Header -->
            <header class="h-16 bg-neutral-900 border-b border-neutral-800 flex items-center justify-between px-6 z-10">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden text-neutral-400 hover:text-white p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <h1 class="text-sm font-semibold tracking-wider text-white uppercase">@yield('page_title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center gap-4 text-xs">
                    <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 border border-neutral-700 text-neutral-300 hover:border-neutral-500 hover:text-white transition-colors text-[11px] uppercase tracking-wider">
                        <span>View Live Site</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                </div>
            </header>

            <!-- Page Body -->
            <main class="flex-1 overflow-y-auto p-6 md:p-8">
                
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mb-6 bg-emerald-950/60 border border-emerald-800 text-emerald-300 px-4 py-3 text-xs uppercase tracking-wider flex items-center justify-between">
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-950/60 border border-red-800 text-red-300 px-4 py-3 text-xs uppercase tracking-wider flex items-center justify-between">
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 bg-red-950/60 border border-red-800 text-red-300 p-4 text-xs">
                        <p class="font-semibold uppercase tracking-wider mb-2">There were some errors with your submission:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>

        </div>

    </div>

    <!-- Quill Rich Text Editor Script (via CDN) -->
    <script src="https://cdn.quilljs.com/1.3.7/quill.js"></script>

    @stack('scripts')
</body>
</html>
