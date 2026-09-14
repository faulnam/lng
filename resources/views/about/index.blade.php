@extends('layouts.app')

@section('meta_title', 'About Us — ' . \App\Models\SiteSetting::get('company_name', 'PT Nusantara LNG Energi'))
@section('meta_description', \App\Models\PageContent::get('about_who_we_are_text'))

@section('content')

    <!-- 1. Hero Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-24 md:pt-48 md:pb-32 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('/images/lng/terminal.jpg');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-5xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">Corporate Profile</div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase">
                PT Nusantara LNG Energi
            </h1>
            <div class="min-h-[40px] flex items-center justify-center text-neutral-300 text-xs md:text-sm max-w-2xl mx-auto"
                 x-data="{
                    text: '',
                    phrases: [
                        '{{ addslashes(\App\Models\PageContent::get('home_hero_title', 'Powering Global Industry with Integrated LNG & Cryogenic Energy Infrastructure')) }}',
                        'Over 18 years of cryogenic engineering and operational safety excellence.',
                        'Reliable natural gas supply connecting energy corridors across Asia Pacific.',
                        'Accelerating sustainable industrial transition through cleaner energy.'
                    ],
                    phraseIndex: 0,
                    charIndex: 0,
                    isDeleting: false,
                    typeSpeed: 50,
                    deleteSpeed: 25,
                    pauseTime: 2000,
                    init() {
                        this.type();
                    },
                    type() {
                        const current = this.phrases[this.phraseIndex];
                        if (this.isDeleting) {
                            this.text = current.substring(0, this.charIndex - 1);
                            this.charIndex--;
                        } else {
                            this.text = current.substring(0, this.charIndex + 1);
                            this.charIndex++;
                        }
                        let speed = this.isDeleting ? this.deleteSpeed : this.typeSpeed;
                        if (!this.isDeleting && this.charIndex === current.length) {
                            speed = this.pauseTime;
                            this.isDeleting = true;
                        } else if (this.isDeleting && this.charIndex === 0) {
                            this.isDeleting = false;
                            this.phraseIndex = (this.phraseIndex + 1) % this.phrases.length;
                            speed = 350;
                        }
                        setTimeout(() => this.type(), speed);
                    }
                 }">
                <p class="leading-relaxed">
                    <span x-text="text">{{ \App\Models\PageContent::get('home_hero_title', 'Powering Global Industry with Integrated LNG & Cryogenic Energy Infrastructure') }}</span><span class="inline-block w-0.5 h-4 bg-white ml-1 align-middle animate-cursor"></span>
                </p>
            </div>
        </div>
    </section>

    <!-- 2. Who We Are & Our Mission Section -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                
                <!-- Who We Are -->
                <div class="space-y-6">
                    <div class="eyebrow text-accent font-semibold">About Company</div>
                    <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-black">
                        {{ \App\Models\PageContent::get('about_who_we_are_title', 'Who We Are') }}
                    </h2>
                    <div class="text-neutral-body text-xs md:text-sm leading-relaxed space-y-4">
                        <p>
                            {{ \App\Models\PageContent::get('about_who_we_are_text', 'PT Nusantara LNG Energi is an established energy infrastructure and liquefied natural gas provider with over 18 years of operational excellence in cryogenic transport and gas distribution.') }}
                        </p>
                        <p>
                            {{ \App\Models\PageContent::get('home_hero_description') }}
                        </p>
                    </div>
                </div>

                <!-- Our Mission -->
                <div class="space-y-6 lg:border-l lg:border-neutral-200 lg:pl-16">
                    <div class="eyebrow text-accent font-semibold">Strategic Vision</div>
                    <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-black">
                        {{ \App\Models\PageContent::get('about_mission_title', 'Our Strategic Mission') }}
                    </h2>
                    <div class="text-neutral-body text-xs md:text-sm leading-relaxed space-y-4">
                        <p>
                            {{ \App\Models\PageContent::get('about_mission_text', 'To deliver secure, competitive, and cleaner energy solutions through world-class cryogenic logistics, accelerating sustainable industrial growth and regional energy transition with zero-incident safety standards.') }}
                        </p>
                        <p>
                            We believe that energy security and environmental sustainability must go hand-in-hand. By operating specialized cryogenic logistics, we unlock natural gas access for archipelagic regions where conventional pipelines are economically or geographically unfeasible.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 3. Skills & Competencies Progress Bars with Animated Fill -->
    <section class="py-16 md:py-20 bg-neutral-bg border-y border-neutral-200"
             x-data="{ show: false }"
             x-init="setTimeout(() => show = true, 200)">
        <div class="max-w-5xl mx-auto px-6 space-y-10">
            <div class="text-center space-y-2">
                <div class="eyebrow">Technical Mastery</div>
                <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black">Core Capabilities &amp; Standards</h2>
            </div>

            <div class="space-y-6">
                @php
                    $skills = [
                        ['name' => 'Cryogenic Process Engineering & Liquefaction', 'percent' => 100],
                        ['name' => 'Small-Scale LNG & Virtual Pipeline Logistics', 'percent' => 100],
                        ['name' => 'Marine Bunkering & STS Transfer Operations', 'percent' => 100],
                        ['name' => 'Coastal Terminal & FSRU Regasification', 'percent' => 100],
                        ['name' => 'QHSE, SIGTTO Compliance & Process Safety', 'percent' => 100],
                    ];
                @endphp

                @foreach($skills as $skill)
                    <div class="space-y-2">
                        <div class="flex justify-between text-xs font-semibold uppercase tracking-wider text-black">
                            <span>{{ $skill['name'] }}</span>
                            <span>{{ $skill['percent'] }}%</span>
                        </div>
                        <div class="w-full bg-neutral-200 h-2 rounded-none overflow-hidden">
                            <div class="bg-black h-2 transition-all duration-1000 ease-out" 
                                 :style="show ? 'width: {{ $skill['percent'] }}%' : 'width: 0%'"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 4. 5 Integrated Solution Highlights / Icon Boxes -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            <div class="text-center space-y-3 max-w-2xl mx-auto">
                <div class="eyebrow">Integrated Portfolio</div>
                <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-black">End-to-End LNG Value Chain</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @php
                    $highlights = [
                        ['title' => 'Bulk LNG Supply', 'desc' => 'Large-scale FOB/DES cargo offtake with price formulas indexed to global energy benchmarks.'],
                        ['title' => 'Virtual Pipeline', 'desc' => 'Multimodal cryogenic ISO containers supplying off-grid smelters and industrial microgrids.'],
                        ['title' => 'Marine Bunkering', 'desc' => 'Eco-friendly ship-to-ship LNG refueling complying with IMO 2030/2050 sulfur regulations.'],
                        ['title' => 'Regas Terminals', 'desc' => 'FSRU management, coastal storage tank throughput, and high-pressure pipeline injection.'],
                        ['title' => 'Cryogenic EPC', 'desc' => 'Turnkey cryogenic engineering, HAZOP risk modeling, and boil-off gas reliquefaction skids.'],
                    ];
                @endphp

                @foreach($highlights as $item)
                    <div class="p-8 bg-neutral-bg border border-neutral-200 hover:border-black transition-all space-y-4 flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="w-8 h-0.5 bg-black group-hover:w-16 transition-all duration-300"></div>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-black">{{ $item['title'] }}</h3>
                            <p class="text-xs text-neutral-body leading-relaxed">{{ $item['desc'] }}</p>
                        </div>
                        <a href="{{ url('/services') }}" class="eyebrow text-[10px] text-black group-hover:text-accent font-semibold pt-4">
                            Learn More &rarr;
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 5. 4 Dark Stat Blocks with Animated Counters -->
    <section class="py-16 md:py-24 bg-black text-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-12 text-center divide-y md:divide-y-0 md:divide-x divide-neutral-800">
                
                <!-- Stat 1 -->
                @php
                    $partRaw = \App\Models\SiteSetting::get('associate_partners', '8');
                    $partNum = (int) preg_replace('/[^0-9]/', '', $partRaw) ?: 8;
                    $partSuf = preg_replace('/[0-9,]/', '', $partRaw) ?: '';
                @endphp
                <div class="pt-4 md:pt-0 px-4 space-y-2"
                     x-data="{
                        count: 0,
                        target: {{ $partNum }},
                        suffix: '{{ $partSuf }}',
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
                    <div class="text-4xl md:text-5xl font-bold text-white tracking-tight">
                        <span x-text="count.toLocaleString() + suffix">{{ $partRaw }}</span>
                    </div>
                    <div class="eyebrow-light text-[11px]">Cryogenic Vessels &amp; Terminals</div>
                </div>

                <!-- Stat 2 -->
                @php
                    $clRaw = \App\Models\SiteSetting::get('total_clients', '40+');
                    $clNum = (int) preg_replace('/[^0-9]/', '', $clRaw) ?: 40;
                    $clSuf = preg_replace('/[0-9,]/', '', $clRaw) ?: '+';
                @endphp
                <div class="pt-4 md:pt-0 px-4 space-y-2"
                     x-data="{
                        count: 0,
                        target: {{ $clNum }},
                        suffix: '{{ $clSuf }}',
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
                    <div class="text-4xl md:text-5xl font-bold text-white tracking-tight">
                        <span x-text="count.toLocaleString() + suffix">{{ $clRaw }}</span>
                    </div>
                    <div class="eyebrow-light text-[11px]">Industrial Offtakers</div>
                </div>

                <!-- Stat 3 -->
                @php
                    $tmRaw = \App\Models\SiteSetting::get('team_members_count', '150+');
                    $tmNum = (int) preg_replace('/[^0-9]/', '', $tmRaw) ?: 150;
                    $tmSuf = preg_replace('/[0-9,]/', '', $tmRaw) ?: '+';
                @endphp
                <div class="pt-4 md:pt-0 px-4 space-y-2"
                     x-data="{
                        count: 0,
                        target: {{ $tmNum }},
                        suffix: '{{ $tmSuf }}',
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
                    <div class="text-4xl md:text-5xl font-bold text-white tracking-tight">
                        <span x-text="count.toLocaleString() + suffix">{{ $tmRaw }}</span>
                    </div>
                    <div class="eyebrow-light text-[11px]">Specialists &amp; Engineers</div>
                </div>

                <!-- Stat 4 -->
                @php
                    $dayRaw = \App\Models\SiteSetting::get('days_of_work', '15M+');
                    $dayNum = (int) preg_replace('/[^0-9]/', '', $dayRaw) ?: 15;
                    $daySuf = preg_replace('/[0-9,]/', '', $dayRaw) ?: 'M+';
                @endphp
                <div class="pt-4 md:pt-0 px-4 space-y-2"
                     x-data="{
                        count: 0,
                        target: {{ $dayNum }},
                        suffix: '{{ $daySuf }}',
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
                    <div class="text-4xl md:text-5xl font-bold text-white tracking-tight">
                        <span x-text="count.toLocaleString() + suffix">{{ $dayRaw }}</span>
                    </div>
                    <div class="eyebrow-light text-[11px]">Safe Working Hours (Zero LTI)</div>
                </div>

            </div>
        </div>
    </section>

    <!-- 6. Selected Products & Solutions (4 Cards) -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="space-y-3">
                    <div class="eyebrow">Highlights</div>
                    <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-black">Featured Infrastructure &amp; Supply</h2>
                </div>
                <a href="{{ url('/services') }}" class="eyebrow text-black hover:text-accent font-semibold border-b border-black pb-1 inline-block">
                    View All Products &amp; Lines &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($highlightProjects as $project)
                    @include('partials.project-card', ['project' => $project])
                @endforeach
            </div>
        </div>
    </section>

    <!-- 7. CTA Section -->
    @include('partials.cta-section')

@endsection
