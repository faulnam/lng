@extends('layouts.app')

@section('meta_title', 'Our Clients — ' . \App\Models\SiteSetting::get('company_name', 'Metrix Interior Architecture'))
@section('meta_description', 'Discover the distinguished clients and global brands that have partnered with Metrix Interior Architecture.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">Collaborations</div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase">
                Our Clients
            </h1>
            <div class="min-h-[40px] flex items-center justify-center text-neutral-300 text-xs md:text-sm max-w-xl mx-auto"
                 x-data="{
                    text: '',
                    phrases: [
                        'Collaborating with visionary developers and global hospitality leaders.',
                        'Over 60+ distinguished brand partners across 5 countries.',
                        'Building enduring spatial legacies and commercial success.',
                        'Trusted by industry pioneers in retail, dining, and workplace design.'
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
                    <span x-text="text">We have had the privilege to collaborate with visionary developers, global hospitality brands, and leading restaurateurs across Asia and beyond.</span><span class="inline-block w-0.5 h-4 bg-white ml-1 align-middle animate-cursor"></span>
                </p>
            </div>
        </div>
    </section>

    <!-- Clients Grid -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <div class="eyebrow">Trust &amp; Partnership</div>
                <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black">Distinguished Partners</h2>
            </div>

            <!-- Grid of Logos -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                @forelse($clients as $client)
                    <div class="group border border-neutral-200 p-8 h-36 flex flex-col items-center justify-center hover:border-black transition-all bg-white text-center">
                        @if($client->logo)
                            <img src="{{ app_image($client->logo) }}" 
                                 alt="{{ $client->name }}" 
                                 title="{{ $client->name }}"
                                 loading="lazy"
                                 class="max-h-12 max-w-full object-contain grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                        @endif
                        <div class="mt-2 text-[11px] font-semibold uppercase tracking-wider text-neutral-600 group-hover:text-black transition-colors">
                            {{ $client->name }}
                        </div>
                    </div>
                @empty
                    <div class="col-span-6 text-center py-12 text-neutral-400 text-sm">
                        Client logos will appear here.
                    </div>
                @endforelse
            </div>

        </div>
    </section>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
