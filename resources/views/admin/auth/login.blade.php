<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-neutral-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Login — Nusantara LNG CMS</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
                    letterSpacing: {
                        widest2: "0.25em",
                        widest3: "0.35em",
                    },
                }
            }
        }
    </script>

    <!-- Compiled Tailwind CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ file_exists(public_path('css/app.css')) ? filemtime(public_path('css/app.css')) : time() }}">
</head>
<body class="h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-neutral-950 text-white font-sans antialiased selection:bg-white selection:text-black">

    <div class="max-w-md w-full space-y-8 bg-neutral-900 border border-neutral-800 p-8 md:p-10 shadow-2xl">
        
        <!-- Brand Header -->
        <div class="text-center space-y-3">
            <div class="w-10 h-10 bg-white text-black font-bold flex items-center justify-center text-sm tracking-tighter mx-auto">
                N
            </div>
            <h2 class="text-lg font-extrabold tracking-[0.25em] text-white uppercase">
                Nusantara LNG CMS
            </h2>
            <p class="text-xs text-neutral-400">
                Sign in to manage company profile, products, and insights
            </p>
        </div>

        <!-- Flash & Validation Errors -->
        @if(session('error'))
            <div class="bg-red-950/60 border border-red-800 text-red-300 p-4 text-xs">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-emerald-950/60 border border-emerald-800 text-emerald-300 p-4 text-xs">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-950/60 border border-red-800 text-red-300 p-4 text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Email Address
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       placeholder="name@example.com"
                       required 
                       autofocus 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3.5 focus:outline-none focus:border-white transition-colors">
            </div>

            <div>
                <label for="password" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Password
                </label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       placeholder="••••••••"
                       required 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3.5 focus:outline-none focus:border-white transition-colors">
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer text-neutral-400 hover:text-white">
                    <input type="checkbox" name="remember" class="w-4 h-4 bg-neutral-950 border-neutral-800 rounded-none accent-black">
                    <span>Remember me</span>
                </label>

                <a href="{{ url('/') }}" class="text-[11px] uppercase tracking-wider text-neutral-400 hover:text-white transition-colors">
                    &larr; Live Site
                </a>
            </div>

            <div>
                <button type="submit" class="w-full bg-white text-black hover:bg-neutral-200 text-xs uppercase tracking-widest2 py-4 font-bold transition-colors">
                    Sign In &rarr;
                </button>
            </div>
        </form>

    </div>

</body>
</html>
