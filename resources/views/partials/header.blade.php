<header x-data="{ 
            scrolled: false, 
            mobileMenuOpen: false, 
            servicesDropdown: false,
            openSubmenu: null
        }" 
        x-init="
            scrolled = window.pageYOffset > 40; 
            window.addEventListener('scroll', () => { scrolled = window.pageYOffset > 40 });
        "
        :class="scrolled 
            ? 'bg-white/95 backdrop-blur-md text-black shadow-sm border-b border-gray-100 py-4' 
            : 'bg-gradient-to-b from-black/80 via-black/40 to-transparent text-white py-6'"
        class="fixed top-0 left-0 w-full z-50 transition-all duration-300">
    
    <div class="max-w-7xl mx-auto px-6 md:px-12 flex items-center justify-between">
        
        <!-- Brand Logo -->
        <a href="{{ url('/') }}" class="group flex items-center gap-3 tracking-widest2 uppercase font-bold text-base md:text-lg transition-colors">
            <!-- Stylized Minimalist Emblem -->
            <div :class="scrolled ? 'bg-black text-white' : 'bg-white text-black'" 
                 class="w-8 h-8 flex items-center justify-center font-bold text-xs tracking-tighter transition-colors duration-300">
                N
            </div>
            <span class="font-extrabold tracking-[0.22em] text-xs md:text-sm">NUSANTARA LNG</span>
        </a>

        <!-- Desktop Navigation Menu (Strict 5-Item Structure) -->
        <nav class="hidden lg:flex items-center gap-8 text-[11px] uppercase tracking-widest font-medium">
            <a href="{{ url('/') }}" 
               class="transition-colors duration-200 hover:text-accent {{ request()->is('/') ? 'text-accent font-semibold' : '' }}">
                Home
            </a>

            <a href="{{ url('/about-us') }}" 
               class="transition-colors duration-200 hover:text-accent {{ request()->is('about-us*') ? 'text-accent font-semibold' : '' }}">
                About
            </a>

            <!-- Products Dropdown (2-Level Hierarchy) -->
            <div class="relative" 
                 @mouseenter="servicesDropdown = true" 
                 @mouseleave="servicesDropdown = false; openSubmenu = null">
                
                <a href="{{ url('/services') }}" 
                   class="inline-flex items-center gap-1 transition-colors duration-200 hover:text-accent py-2 {{ request()->is('services*') || request()->is('products*') ? 'text-accent font-semibold' : '' }}">
                    <span>Products</span>
                    <svg class="w-3 h-3 transition-transform duration-200" :class="servicesDropdown ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </a>

                <!-- Level 1 Dropdown Menu -->
                <div x-show="servicesDropdown" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-2"
                     x-cloak
                     class="absolute top-full right-0 mt-0 w-80 bg-white text-black shadow-2xl border border-gray-100 py-3 z-50">
                    
                    @if(isset($navServices) && $navServices->count())
                        @foreach($navServices as $parentService)
                            @if($parentService->children->count())
                                <!-- Parent with Children -->
                                <div class="relative" 
                                     @mouseenter="openSubmenu = '{{ $parentService->slug }}'" 
                                     @mouseleave="openSubmenu = null">
                                    <a href="{{ url('/services/' . $parentService->slug) }}" 
                                       class="flex items-center justify-between px-5 py-2.5 text-[11px] uppercase tracking-wider text-gray-800 hover:bg-neutral-50 hover:text-accent transition-colors font-medium">
                                        <span>{{ $parentService->title }}</span>
                                        <svg class="w-3 h-3 text-gray-400 transform transition-transform duration-150" :class="openSubmenu === '{{ $parentService->slug }}' ? '-translate-x-1 text-accent' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                    </a>

                                    <!-- Level 2 Sub-Dropdown (Flyout to Left to prevent viewport overflow) -->
                                    <div x-show="openSubmenu === '{{ $parentService->slug }}'"
                                         x-transition:enter="transition ease-out duration-150"
                                         x-transition:enter-start="opacity-0 translate-x-1"
                                         x-transition:enter-end="opacity-100 translate-x-0"
                                         x-transition:leave="transition ease-in duration-100"
                                         x-transition:leave-start="opacity-100 translate-x-0"
                                         x-transition:leave-end="opacity-0 translate-x-1"
                                         class="absolute top-0 right-full mr-1 w-72 bg-white text-black shadow-2xl border border-gray-100 py-3 z-50">
                                        <div class="px-5 py-1 text-[9px] uppercase tracking-widest text-neutral-400 font-bold border-b border-neutral-100 mb-2">
                                            {{ $parentService->title }}
                                        </div>
                                        @foreach($parentService->children as $childService)
                                            <a href="{{ url('/services/' . $parentService->slug . '/' . $childService->slug) }}" 
                                               class="block px-5 py-2 text-[11px] uppercase tracking-wider text-gray-700 hover:bg-neutral-50 hover:text-accent transition-colors">
                                                {{ $childService->title }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <!-- Parent without Children -->
                                <a href="{{ url('/services/' . $parentService->slug) }}" 
                                   class="block px-5 py-2.5 text-[11px] uppercase tracking-wider text-gray-800 hover:bg-neutral-50 hover:text-accent transition-colors font-medium">
                                    {{ $parentService->title }}
                                </a>
                            @endif
                        @endforeach
                    @else
                        <a href="{{ url('/services') }}" class="block px-5 py-2.5 text-[11px] uppercase tracking-wider text-gray-800 hover:bg-neutral-50">All Products & Lines</a>
                    @endif
                </div>
            </div>

            <a href="{{ url('/our-blog') }}" 
               class="transition-colors duration-200 hover:text-accent {{ request()->is('our-blog*') || request()->is('blog*') ? 'text-accent font-semibold' : '' }}">
                Blog
            </a>

            <a href="{{ url('/contact-us') }}" 
               class="transition-colors duration-200 hover:text-accent {{ request()->is('contact-us*') || request()->is('contact*') ? 'text-accent font-semibold' : '' }}">
                Contact
            </a>
        </nav>

        <!-- Mobile Menu Hamburger Button -->
        <div class="lg:hidden flex items-center">
            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                    type="button" 
                    class="p-2 transition-colors focus:outline-none"
                    :class="scrolled ? 'text-black' : 'text-white'"
                    aria-label="Toggle Navigation Menu">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

    </div>

    <!-- Mobile Drawer Overlay & Nav -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         x-cloak
         class="lg:hidden bg-black text-white px-6 py-8 border-t border-neutral-800 space-y-4 max-h-[85vh] overflow-y-auto">
        
        <a href="{{ url('/') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-widest2 py-2 border-b border-neutral-800 hover:text-accent">Home</a>
        <a href="{{ url('/about-us') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-widest2 py-2 border-b border-neutral-800 hover:text-accent">About</a>

        <!-- Mobile Products Accordion -->
        <div x-data="{ mobileServicesOpen: false }" class="border-b border-neutral-800 py-2">
            <button @click="mobileServicesOpen = !mobileServicesOpen" class="w-full flex items-center justify-between text-xs uppercase tracking-widest2 hover:text-accent">
                <span>Products</span>
                <svg class="w-4 h-4 transition-transform" :class="mobileServicesOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div x-show="mobileServicesOpen" x-cloak class="pl-4 pt-3 space-y-3">
                <a href="{{ url('/services') }}" @click="mobileMenuOpen = false" class="block text-[11px] uppercase tracking-wider text-neutral-400 hover:text-white">All Products & Lines</a>
                @if(isset($navServices) && $navServices->count())
                    @foreach($navServices as $pService)
                        <div x-data="{ subOpen: false }" class="space-y-2">
                            <div class="flex items-center justify-between">
                                <a href="{{ url('/services/' . $pService->slug) }}" @click="mobileMenuOpen = false" class="text-[11px] uppercase tracking-wider text-neutral-300 hover:text-white font-medium">
                                    {{ $pService->title }}
                                </a>
                                @if($pService->children->count())
                                    <button @click="subOpen = !subOpen" class="p-1 text-neutral-400">
                                        <svg class="w-3 h-3 transition-transform" :class="subOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                @endif
                            </div>
                            @if($pService->children->count())
                                <div x-show="subOpen" x-cloak class="pl-4 space-y-2 border-l border-neutral-800">
                                    @foreach($pService->children as $cService)
                                        <a href="{{ url('/services/' . $pService->slug . '/' . $cService->slug) }}" @click="mobileMenuOpen = false" class="block text-[10px] uppercase tracking-wider text-neutral-400 hover:text-accent">
                                            {{ $cService->title }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <a href="{{ url('/our-blog') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-widest2 py-2 border-b border-neutral-800 hover:text-accent">Blog</a>
        <a href="{{ url('/contact-us') }}" @click="mobileMenuOpen = false" class="block text-xs uppercase tracking-widest2 py-2 hover:text-accent">Contact</a>
    </div>

</header>
