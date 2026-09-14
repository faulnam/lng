@extends('layouts.app')

@section('meta_title', 'Energy Insights & Market Publications — ' . \App\Models\SiteSetting::get('company_name', 'PT Nusantara LNG Energi'))
@section('meta_description', 'Read the latest global LNG market insights, cryogenic technology briefings, decarbonization analyses, and corporate offtake updates from PT Nusantara LNG Energi.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('/images/lng/carrier.jpg');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">Intelligence &amp; Publications</div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase">
                Energy Insights
            </h1>
            <div class="min-h-[40px] flex items-center justify-center text-neutral-300 text-xs md:text-sm max-w-xl mx-auto"
                 x-data="{
                    text: '',
                    phrases: [
                        'Global gas market dynamics and regional offtake demand.',
                        'Decarbonization policies, migas regulation, and energy transition.',
                        'Cryogenic engineering innovations and SIGTTO marine safety standards.',
                        'Corporate supply agreements and infrastructure milestones.'
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
                    <span x-text="text">Stay informed with our global gas market intelligence, regulatory analysis, and decarbonization outlooks.</span><span class="inline-block w-0.5 h-4 bg-white ml-1 align-middle animate-cursor"></span>
                </p>
            </div>
        </div>
    </section>

    <!-- Category Pill Filter Tabs -->
    @if(isset($categories) && $categories->count())
        <section class="bg-neutral-bg border-b border-neutral-200 sticky top-16 z-30">
            <div class="max-w-7xl mx-auto px-6 md:px-12 flex items-center gap-2 md:gap-3 overflow-x-auto py-4 text-xs uppercase tracking-wider font-semibold whitespace-nowrap scrollbar-none">
                <a href="{{ url('/our-blog') }}" 
                   class="px-4 py-2 border transition-colors {{ !$currentCategory ? 'border-black bg-black text-white' : 'border-neutral-300 text-neutral-600 hover:border-black hover:text-black' }}">
                    All Publications
                </a>
                @foreach($categories as $cat)
                    <a href="{{ url('/our-blog?category=' . $cat->slug) }}" 
                       class="px-4 py-2 border transition-colors {{ $currentCategory && $currentCategory->id === $cat->id ? 'border-black bg-black text-white' : 'border-neutral-300 text-neutral-600 hover:border-black hover:text-black' }}">
                        {{ $cat->title }} ({{ $cat->posts_count }})
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Blog Articles Grid -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-neutral-200 pb-6">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black">
                        {{ $currentCategory ? $currentCategory->title : 'Latest Publications' }}
                    </h2>
                    <p class="text-neutral-body text-xs mt-1">
                        Showing {{ $posts->total() }} industry briefings
                    </p>
                </div>
            </div>

            <!-- Articles Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($posts as $post)
                    <article class="group bg-white border border-neutral-200 flex flex-col justify-between overflow-hidden hover:border-black transition-all">
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
                    <div class="col-span-3 text-center py-16 text-neutral-400 text-sm">
                        No articles found in this category.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($posts->hasPages())
                <div class="pt-8 flex justify-center">
                    {{ $posts->links() }}
                </div>
            @endif

        </div>
    </section>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
