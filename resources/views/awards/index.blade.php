@extends('layouts.app')

@section('meta_title', 'Awards & Publications — ' . \App\Models\SiteSetting::get('company_name', 'Metrix Interior Architecture'))
@section('meta_description', 'Explore the international awards, design accolades, and global media publications recognizing Metrix Interior Architecture.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2000&auto=format&fit=crop');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">Recognition &amp; Honors</div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase">
                Awards &amp; Publications
            </h1>
            <div class="min-h-[40px] flex items-center justify-center text-neutral-300 text-xs md:text-sm max-w-xl mx-auto"
                 x-data="{
                    text: '',
                    phrases: [
                        'Celebrating international milestones and design excellence.',
                        'Honored by premier global architectural institutions.',
                        'Featured across esteemed architectural publications worldwide.',
                        'Two decades of recognized distinction and design leadership.'
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
                    <span x-text="text">Celebrating global milestones, architectural excellence, and international accolades awarded to our creative studio.</span><span class="inline-block w-0.5 h-4 bg-white ml-1 align-middle animate-cursor"></span>
                </p>
            </div>
        </div>
    </section>

    <!-- Awards Grid -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-neutral-200 pb-6">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black">
                        Accolades &amp; Press Features
                    </h2>
                    <p class="text-neutral-body text-xs mt-1">
                        Showing {{ $awards->total() }} published recognitions
                    </p>
                </div>
            </div>

            <!-- Awards Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($awards as $award)
                    <article class="group bg-white border border-neutral-200 flex flex-col justify-between overflow-hidden hover:border-black transition-all">
                        <a href="{{ url('/awards-publications/' . $award->slug) }}" class="block overflow-hidden aspect-[16/11] bg-neutral-900">
                            <img src="{{ app_image($award->image, 'images/lng/carrier.jpg') }}" 
                                 alt="{{ $award->title }}" 
                                 loading="lazy"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        </a>

                        <div class="p-6 space-y-3 flex-1 flex flex-col justify-between">
                            <div class="space-y-2">
                                <div class="eyebrow text-[10px] text-accent font-semibold">
                                    {{ $award->published_date ? $award->published_date->format('F Y') : 'Recognition' }}
                                </div>
                                <h3 class="text-base font-bold text-black group-hover:text-accent transition-colors leading-snug">
                                    <a href="{{ url('/awards-publications/' . $award->slug) }}">
                                        {{ $award->title }}
                                    </a>
                                </h3>
                                @if($award->description)
                                    <p class="text-xs text-neutral-body line-clamp-3 leading-relaxed">
                                        {{ $award->description }}
                                    </p>
                                @endif
                            </div>

                            <div class="pt-4 border-t border-neutral-100 flex items-center justify-between text-[10px] uppercase tracking-wider text-neutral-400">
                                <span>Press &bull; Honor</span>
                                <span class="group-hover:text-black font-semibold transition-colors">View Details &rarr;</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 text-center py-16 text-neutral-400 text-sm">
                        No awards currently listed.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($awards->hasPages())
                <div class="pt-8 flex justify-center">
                    {{ $awards->links() }}
                </div>
            @endif

        </div>
    </section>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
