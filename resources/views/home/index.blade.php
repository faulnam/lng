@extends('layouts.app')

@section('meta_title', \App\Models\SiteSetting::get('site_title', 'PT Nusantara LNG Energi — Integrated Liquefied Natural Gas Supply & Cryogenic Logistics'))
@section('meta_description', \App\Models\SiteSetting::get('meta_description_default'))

@section('content')

    <!-- 1. Hero Intro Header with Typewriter Effect and Animated Stats -->
    <section class="pt-32 md:pt-40 pb-16 md:pb-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left: Headline with Typewriter Effect & Narrative Description (7 cols) -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="min-h-[120px] md:min-h-[140px] flex items-center" 
                         x-data="{
                            text: '',
                            phrases: [
                                '{{ addslashes(\App\Models\PageContent::get('home_hero_title', 'Powering Global Industry with Integrated LNG & Cryogenic Energy Infrastructure')) }}',
                                'Reliable cryogenic supply chains for domestic utilities and global offtakers.',
                                'Pioneering virtual pipeline and ISO tank logistics across the archipelago.',
                                'Integrated clean energy and coastal regasification infrastructure.'
                            ],
                            phraseIndex: 0,
                            charIndex: 0,
                            isDeleting: false,
                            typeSpeed: 50,
                            deleteSpeed: 25,
                            pauseTime: 2200,
                            init() {
                                this.type();
                            },
                            type() {
                                const currentPhrase = this.phrases[this.phraseIndex];
                                if (this.isDeleting) {
                                    this.text = currentPhrase.substring(0, this.charIndex - 1);
                                    this.charIndex--;
                                } else {
                                    this.text = currentPhrase.substring(0, this.charIndex + 1);
                                    this.charIndex++;
                                }

                                let speed = this.isDeleting ? this.deleteSpeed : this.typeSpeed;

                                if (!this.isDeleting && this.charIndex === currentPhrase.length) {
                                    speed = this.pauseTime;
                                    this.isDeleting = true;
                                } else if (this.isDeleting && this.charIndex === 0) {
                                    this.isDeleting = false;
                                    this.phraseIndex = (this.phraseIndex + 1) % this.phrases.length;
                                    speed = 400;
                                }

                                setTimeout(() => this.type(), speed);
                            }
                         }">
                        <h1 class="text-2xl md:text-4xl lg:text-5xl font-bold tracking-tight text-black leading-tight">
                            <span x-text="text">{{ \App\Models\PageContent::get('home_hero_title', 'Powering Global Industry with Integrated LNG & Cryogenic Energy Infrastructure') }}</span><span class="inline-block w-[3px] h-7 md:h-10 bg-black ml-1.5 align-middle animate-cursor"></span>
                        </h1>
                    </div>
                    
                    <p class="text-neutral-body text-xs md:text-sm leading-relaxed max-w-2xl">
                        {{ \App\Models\PageContent::get('home_hero_description', 'PT Nusantara LNG Energi is an integrated liquefied natural gas (LNG) infrastructure and energy logistics corporation. We specialize in bulk LNG supply, virtual pipeline ISO tank distribution, coastal regasification terminals, and marine LNG bunkering. Our dependable cryogenic supply chain powers major electric utilities, smelters, and heavy industries across Southeast Asia and global trade corridors.') }}
                    </p>
                </div>

                <!-- Right: 2 Main Stat Numbers (5 cols - Clean Non-Colliding Layout with Smooth Counter Animation) -->
                <div class="lg:col-span-5 border-t lg:border-t-0 lg:border-l border-neutral-200 pt-8 lg:pt-0 lg:pl-10">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 lg:gap-10">
                        
                        <!-- Stat 1: Total LNG Supply Capacity -->
                        @php
                            $projRaw = \App\Models\SiteSetting::get('total_projects', '5.2 MTPA');
                            $projNum = (float) preg_replace('/[^0-9.]/', '', $projRaw) ?: 5.2;
                            $projSuf = preg_replace('/[0-9.,]/', '', $projRaw) ?: ' MTPA';
                        @endphp
                        <div class="space-y-2" 
                             x-data="{
                                count: 0,
                                target: {{ $projNum }},
                                suffix: '{{ $projSuf }}',
                                init() {
                                    let duration = 1600;
                                    let step = 25;
                                    let inc = this.target / (duration / step);
                                    let cur = 0;
                                    let timer = setInterval(() => {
                                        cur += inc;
                                        if (cur >= this.target) {
                                            this.count = this.target;
                                            clearInterval(timer);
                                        } else {
                                            this.count = Math.round(cur * 10) / 10;
                                        }
                                    }, step);
                                }
                             }">
                            <div class="text-3xl sm:text-4xl lg:text-5xl font-bold text-black tracking-tight whitespace-nowrap">
                                <span x-text="count + suffix">{{ $projRaw }}</span>
                            </div>
                            <div class="eyebrow text-[11px] leading-snug">
                                Annual LNG Offtake Capacity
                            </div>
                        </div>

                        <!-- Stat 2: Years Experience & Safety -->
                        @php
                            $expRaw = \App\Models\SiteSetting::get('years_experience', '18+');
                            $expNum = (int) preg_replace('/[^0-9]/', '', $expRaw) ?: 18;
                            $expSuf = preg_replace('/[0-9,]/', '', $expRaw) ?: '+';
                        @endphp
                        <div class="space-y-2"
                             x-data="{
                                count: 0,
                                target: {{ $expNum }},
                                suffix: '{{ $expSuf }}',
                                init() {
                                    let duration = 1600;
                                    let step = 25;
                                    let inc = this.target / (duration / step);
                                    let cur = 0;
                                    let timer = setInterval(() => {
                                        cur += inc;
                                        if (cur >= this.target) {
                                            this.count = this.target;
                                            clearInterval(timer);
                                        } else {
                                            this.count = Math.floor(cur);
                                        }
                                    }, step);
                                }
                             }">
                            <div class="text-3xl sm:text-4xl lg:text-5xl font-bold text-black tracking-tight whitespace-nowrap">
                                <span x-text="count.toLocaleString() + suffix">{{ $expRaw }}</span>
                            </div>
                            <div class="eyebrow text-[11px] leading-snug">
                                Years Operational Safety
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 2. Hero Slider (Featured LNG Infrastructure Carousel) -->
    <section class="relative">
        @include('partials.hero-slider', ['slides' => $heroSlides])
    </section>

    <!-- 3. Secondary Stats & Products Action -->
    <section class="py-16 md:py-24 bg-white border-b border-neutral-100">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="flex flex-col md:flex-row items-center justify-between gap-12">
                
                <!-- Secondary Stat Numbers with Animated Counters -->
                <div class="grid grid-cols-2 gap-12 md:gap-20 text-center md:text-left">
                    @php
                        $medRaw = \App\Models\SiteSetting::get('media_awards_count', '12');
                        $medNum = (int) preg_replace('/[^0-9]/', '', $medRaw) ?: 12;
                        $medSuf = preg_replace('/[0-9,]/', '', $medRaw) ?: '';
                    @endphp
                    <div x-data="{
                        count: 0,
                        target: {{ $medNum }},
                        suffix: '{{ $medSuf }}',
                        init() {
                            let duration = 1600;
                            let step = 25;
                            let inc = this.target / (duration / step);
                            let cur = 0;
                            let timer = setInterval(() => {
                                cur += inc;
                                if (cur >= this.target) {
                                    this.count = this.target;
                                    clearInterval(timer);
                                } else {
                                    this.count = Math.floor(cur);
                                }
                            }, step);
                        }
                    }">
                        <div class="text-3xl sm:text-4xl lg:text-5xl font-bold text-black tracking-tight whitespace-nowrap">
                            <span x-text="count.toLocaleString() + suffix">{{ $medRaw }}</span>
                        </div>
                        <div class="eyebrow mt-2 text-[11px]">
                            Export Destinations &amp; Terminals
                        </div>
                    </div>

                    @php
                        $cntRaw = \App\Models\SiteSetting::get('countries_served', '40+');
                        $cntNum = (int) preg_replace('/[^0-9]/', '', $cntRaw) ?: 40;
                        $cntSuf = preg_replace('/[0-9,]/', '', $cntRaw) ?: '+';
                    @endphp
                    <div x-data="{
                        count: 0,
                        target: {{ $cntNum }},
                        suffix: '{{ $cntSuf }}',
                        init() {
                            let duration = 1600;
                            let step = 25;
                            let inc = this.target / (duration / step);
                            let cur = 0;
                            let timer = setInterval(() => {
                                cur += inc;
                                if (cur >= this.target) {
                                    this.count = this.target;
                                    clearInterval(timer);
                                } else {
                                    this.count = Math.floor(cur);
                                }
                            }, step);
                        }
                    }">
                        <div class="text-3xl sm:text-4xl lg:text-5xl font-bold text-black tracking-tight whitespace-nowrap">
                            <span x-text="count.toLocaleString() + suffix">{{ $cntRaw }}</span>
                        </div>
                        <div class="eyebrow mt-2 text-[11px]">
                            Corporate &amp; Industrial Offtakers
                        </div>
                    </div>
                </div>

                <!-- View Products Button -->
                <div>
                    <a href="{{ url('/services') }}" class="btn-dark">
                        Explore Our Products
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- 4. Products / Business Lines Section (3x3 Grid) -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            
            <!-- Section Header -->
            <div class="space-y-3">
                <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-black">
                    {{ \App\Models\PageContent::get('home_recent_projects_eyebrow', 'Products & Business Lines') }}
                </h2>
                <p class="text-neutral-body text-xs md:text-sm">
                    {{ \App\Models\PageContent::get('home_recent_projects_subtitle', 'Engineered cryogenic solutions and flexible LNG supply agreements designed for utility and industrial offtakers.') }}
                </p>
            </div>

            <!-- 3x3 Project / Product Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($recentProjects as $project)
                    @include('partials.project-card', ['project' => $project])
                @empty
                    <div class="col-span-3 text-center py-12 text-neutral-400 text-sm">
                        No product lines available at this moment.
                    </div>
                @endforelse
            </div>

            <!-- Check All Products Button -->
            <div class="text-center pt-8">
                <a href="{{ url('/services') }}" class="btn-dark">
                    View All Products &amp; Solutions
                </a>
            </div>

        </div>
    </section>

    <!-- 5. Latest Insights Section (Energy Blog) -->
    <section class="py-20 md:py-28 bg-neutral-bg border-t border-neutral-200">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="space-y-3">
                    <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-black">
                        {{ \App\Models\PageContent::get('home_latest_insights_eyebrow', 'Energy Insights & Market Publications') }}
                    </h2>
                    <p class="text-neutral-body text-xs md:text-sm">
                        {{ \App\Models\PageContent::get('home_latest_insights_subtitle', 'Stay informed with our global gas market intelligence, regulatory analysis, and decarbonization outlooks.') }}
                    </p>
                </div>
                <a href="{{ url('/our-blog') }}" class="eyebrow text-black hover:text-accent font-semibold border-b border-black pb-1 inline-block self-start md:self-auto">
                    View All Publications &rarr;
                </a>
            </div>

            <!-- 3 Blog Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($latestPosts as $post)
                    <article class="group bg-white border border-neutral-200 flex flex-col justify-between overflow-hidden">
                        <a href="{{ url('/our-blog/' . $post->slug) }}" class="block overflow-hidden aspect-[16/10] bg-neutral-900">
                            <img src="{{ $post->cover_image ? (str_starts_with($post->cover_image, 'http') ? $post->cover_image : asset('storage/' . $post->cover_image)) : '/images/lng/carrier.jpg' }}" 
                                 alt="{{ $post->title }}" 
                                 loading="lazy"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        </a>
                        <div class="p-6 space-y-3 flex-1 flex flex-col justify-between">
                            <div class="space-y-2">
                                @if($post->category)
                                    <div class="eyebrow text-[10px] text-accent font-semibold">
                                        {{ $post->category->title }}
                                    </div>
                                @endif
                                <h3 class="text-base font-bold text-black group-hover:text-accent transition-colors line-clamp-2">
                                    <a href="{{ url('/our-blog/' . $post->slug) }}">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                @if($post->excerpt)
                                    <p class="text-xs text-neutral-body line-clamp-3 leading-relaxed">
                                        {{ $post->excerpt }}
                                    </p>
                                @endif
                            </div>
                            <div class="pt-4 border-t border-neutral-100 flex items-center justify-between text-[10px] uppercase tracking-wider text-neutral-400">
                                <span>{{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</span>
                                <span class="group-hover:text-black font-semibold transition-colors">Read Briefing &rarr;</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 text-center py-12 text-neutral-400 text-sm">
                        No articles published yet.
                    </div>
                @endforelse
            </div>

        </div>
    </section>

    <!-- 6. Strategic Offtakers & Partners (Marquee Track) -->
    <section class="py-20 md:py-28 bg-white border-t border-neutral-200 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            <div class="text-center space-y-2">
                <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black">
                    {{ \App\Models\PageContent::get('home_clients_eyebrow', 'Strategic Offtakers & Industry Affiliations') }}
                </h2>
                <div class="w-12 h-0.5 bg-black mx-auto"></div>
            </div>

            <!-- Running Marquee Track (Seamless Leftward Infinite Motion) -->
            <div class="relative w-full overflow-hidden mask-marquee py-4">
                @if($clients->count() > 0)
                    <div class="animate-marquee flex items-center gap-8 md:gap-12">
                        
                        <!-- First Track of Logos / Partner Names -->
                        @foreach($clients as $client)
                            <div class="flex-shrink-0 flex items-center justify-center p-4 h-20 w-48 md:w-56 border border-neutral-100 hover:border-neutral-400 bg-white transition-all shadow-sm group">
                                @if($client->logo)
                                    <img src="{{ str_starts_with($client->logo, 'http') ? $client->logo : asset('storage/' . $client->logo) }}" 
                                         alt="{{ $client->name }}" 
                                         title="{{ $client->name }}" 
                                         loading="lazy"
                                         class="max-h-10 max-w-full object-contain grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                                @else
                                    <span class="text-xs font-bold tracking-wider text-neutral-700 uppercase group-hover:text-black text-center">{{ $client->name }}</span>
                                @endif
                            </div>
                        @endforeach

                        <!-- Duplicate Track of Logos for Seamless Infinite Continuous Loop -->
                        @foreach($clients as $client)
                            <div class="flex-shrink-0 flex items-center justify-center p-4 h-20 w-48 md:w-56 border border-neutral-100 hover:border-neutral-400 bg-white transition-all shadow-sm group">
                                @if($client->logo)
                                    <img src="{{ str_starts_with($client->logo, 'http') ? $client->logo : asset('storage/' . $client->logo) }}" 
                                         alt="{{ $client->name }}" 
                                         title="{{ $client->name }}" 
                                         loading="lazy"
                                         class="max-h-10 max-w-full object-contain grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                                @else
                                    <span class="text-xs font-bold tracking-wider text-neutral-700 uppercase group-hover:text-black text-center">{{ $client->name }}</span>
                                @endif
                            </div>
                        @endforeach

                    </div>
                @else
                    <div class="text-center py-6 text-neutral-400 text-xs">
                        Offtakers and partners will be listed here.
                    </div>
                @endif
            </div>

            <!-- View About Us Link -->
            <div class="text-center pt-4">
                <a href="{{ url('/about-us') }}" class="eyebrow text-black hover:text-accent font-semibold border-b border-black pb-1 inline-block">
                    Learn More About Our Infrastructure &rarr;
                </a>
            </div>

        </div>
    </section>

    <!-- 7. Partner & Offtaker Testimonials Section -->
    @if(isset($testimonials) && $testimonials->count())
        <section class="py-20 md:py-28 bg-neutral-bg border-t border-neutral-200">
            <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-16">
                
                <div class="text-center space-y-3 max-w-2xl mx-auto">
                    <div class="eyebrow text-accent font-semibold">Institutional Endorsements</div>
                    <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-black">
                        What Our Offtakers &amp; Partners Say
                    </h2>
                    <div class="w-12 h-0.5 bg-black mx-auto"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($testimonials as $testi)
                        <div class="bg-white border border-neutral-200 p-8 flex flex-col justify-between space-y-6 hover:border-black transition-all group shadow-sm">
                            <div class="space-y-4">
                                <div class="flex items-center gap-1 text-amber-500 text-xs">
                                    @for($i = 0; $i < ($testi->rating ?? 5); $i++)
                                        <span>&#9733;</span>
                                    @endfor
                                </div>
                                <p class="text-neutral-700 text-xs md:text-sm leading-relaxed italic">
                                    &ldquo;{{ $testi->message }}&rdquo;
                                </p>
                            </div>

                            <div class="pt-4 border-t border-neutral-100 flex items-center gap-4">
                                @if($testi->photo)
                                    <img src="{{ str_starts_with($testi->photo, 'http') ? $testi->photo : asset('storage/' . $testi->photo) }}" 
                                         alt="{{ $testi->client_name }}" 
                                         class="w-10 h-10 rounded-full object-cover border border-neutral-200">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-black text-white flex items-center justify-center font-bold text-xs">
                                        {{ substr($testi->client_name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-xs font-bold text-black uppercase tracking-wider">{{ $testi->client_name }}</div>
                                    @if($testi->client_company)
                                        <div class="text-[11px] text-neutral-500">{{ $testi->client_company }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    <!-- 8. CTA Section -->
    @include('partials.cta-section')

@endsection
