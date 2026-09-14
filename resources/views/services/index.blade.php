@extends('layouts.app')

@section('meta_title', 'Products & Solutions — ' . \App\Models\SiteSetting::get('company_name', 'PT Nusantara LNG Energi'))
@section('meta_description', 'Explore our comprehensive LNG product lines, bulk cargo supply, cryogenic ISO tank virtual pipelines, coastal regasification terminals, and marine bunkering solutions.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('/images/lng/carrier.jpg');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">Products &amp; Business Lines</div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase">
                Products &amp; Solutions
            </h1>
            <div class="min-h-[40px] flex items-center justify-center text-neutral-300 text-xs md:text-sm max-w-xl mx-auto"
                 x-data="{
                    text: '',
                    phrases: [
                        'Reliable large-scale bulk LNG offtake under FOB and DES contracts.',
                        'Multimodal ISO tank virtual pipeline distribution across the archipelago.',
                        'Low-emission maritime bunkering complying with IMO 2030/2050 standards.',
                        'Turnkey coastal regasification terminal and FSRU infrastructure.'
                    ],
                    phraseIndex: 0,
                    charIndex: 0,
                    isDeleting: false,
                    typeSpeed: 50,
                    deleteSpeed: 25,
                    pauseTime: 2000,
                    init() { this.type(); },
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
                    <span x-text="text">From bulk cargo shipping to virtual pipeline delivery, we provide tailored end-to-end cryogenic gas solutions.</span><span class="inline-block w-0.5 h-4 bg-white ml-1 align-middle animate-cursor"></span>
                </p>
            </div>
        </div>
    </section>

    <!-- Products Overview & Categories List -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-24">
            
            @foreach($services as $index => $service)
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start pt-12 {{ $index > 0 ? 'border-t border-neutral-200' : '' }}">
                    
                    <!-- Left Column: Service Title & Intro -->
                    <div class="lg:col-span-5 space-y-6">
                        <div class="text-3xl font-extrabold text-neutral-300">0{{ $index + 1 }}</div>
                        <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-black">
                            {{ $service->title }}
                        </h2>
                        @if($service->excerpt)
                            <p class="text-neutral-body text-xs md:text-sm leading-relaxed">
                                {{ $service->excerpt }}
                            </p>
                        @endif
                        @if($service->description)
                            <div class="text-neutral-500 text-xs leading-relaxed">
                                {!! $service->description !!}
                            </div>
                        @endif

                        <div class="pt-4">
                            <a href="{{ url('/services/' . $service->slug) }}" class="btn-dark">
                                View {{ $service->title }} &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- Right Column: Sub-Services Grid or Gallery Preview -->
                    <div class="lg:col-span-7">
                        @if($service->children->count())
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($service->children as $child)
                                    <a href="{{ url('/services/' . $service->slug . '/' . $child->slug) }}" 
                                       class="group p-6 bg-neutral-bg border border-neutral-200 hover:border-black transition-all flex flex-col justify-between h-44">
                                        <div class="space-y-2">
                                            <div class="eyebrow text-[10px] text-accent">Lini Bisnis</div>
                                            <h3 class="text-sm font-bold text-black uppercase tracking-wider group-hover:text-accent transition-colors">
                                                {{ $child->title }}
                                            </h3>
                                            @if($child->excerpt)
                                                <p class="text-xs text-neutral-body line-clamp-2 leading-relaxed">
                                                    {{ $child->excerpt }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="text-[10px] uppercase tracking-widest font-semibold text-black flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                                            <span>Explore Solutions</span>
                                            <span>&rarr;</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <!-- Single Category Showcase Card -->
                            <div class="relative aspect-[16/9] bg-neutral-900 overflow-hidden border border-neutral-200">
                                <img src="{{ app_image($service->image, 'images/lng/terminal.jpg') }}" 
                                     alt="{{ $service->title }}" 
                                     class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center p-8 text-center">
                                    <a href="{{ url('/services/' . $service->slug) }}" class="btn-outline">
                                        Discover {{ $service->title }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            @endforeach

        </div>
    </section>

    <!-- Featured Projects Grid Showcase -->
    @if(isset($featuredProjects) && $featuredProjects->count())
        <section class="py-20 md:py-28 bg-neutral-bg border-t border-neutral-200">
            <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="space-y-2">
                        <div class="eyebrow">Portfolio Preview</div>
                        <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black">Key Infrastructure &amp; Solutions</h2>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($featuredProjects as $p)
                        @include('partials.project-card', ['project' => $p])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
