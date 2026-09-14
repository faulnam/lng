@extends('layouts.app')

@section('meta_title', ($post->meta_title ?: $post->title) . ' — ' . \App\Models\SiteSetting::get('company_name', 'PT Nusantara LNG Energi'))
@section('meta_description', $post->meta_description ?: strip_tags(Str::limit($post->excerpt ?: $post->content, 160)))

@section('content')

    <!-- Hero Header -->
    <section class="pt-36 md:pt-44 pb-12 bg-white">
        <div class="max-w-4xl mx-auto px-6 text-center space-y-4">
            @if($post->category)
                <div class="eyebrow text-accent">
                    <a href="{{ url('/our-blog?category=' . $post->category->slug) }}" class="hover:underline">
                        {{ $post->category->title }}
                    </a>
                </div>
            @endif

            <h1 class="text-2xl md:text-4xl lg:text-5xl font-bold tracking-tight text-black leading-tight">
                {{ $post->title }}
            </h1>

            <div class="flex items-center justify-center gap-4 text-xs uppercase tracking-wider text-neutral-400 pt-2">
                <span>By {{ $post->author ?: 'Nusantara LNG Editorial' }}</span>
                <span>&bull;</span>
                <span>{{ $post->published_at ? $post->published_at->format('F d, Y') : $post->created_at->format('F d, Y') }}</span>
            </div>
        </div>
    </section>

    <!-- Main Content & Sidebar Grid -->
    <section class="py-12 md:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
                
                <!-- Left Column: Article Body (8 cols) -->
                <div class="lg:col-span-8 space-y-8">
                    
                    <!-- Cover Image -->
                    @if($post->cover_image)
                        <div class="aspect-[16/9] overflow-hidden bg-neutral-900 border border-neutral-200">
                            <img src="{{ str_starts_with($post->cover_image, 'http') ? $post->cover_image : asset('storage/' . $post->cover_image) }}" 
                                 alt="{{ $post->title }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    @endif

                    <!-- Excerpt Highlight -->
                    @if($post->excerpt)
                        <div class="p-6 bg-neutral-bg border-l-2 border-black text-neutral-700 text-sm md:text-base font-medium italic leading-relaxed">
                            {{ $post->excerpt }}
                        </div>
                    @endif

                    <!-- Main Article Content -->
                    <div class="text-neutral-800 text-sm md:text-base leading-relaxed space-y-6 prose max-w-none">
                        {!! $post->content !!}
                    </div>

                    <!-- Article Navigation Prev/Next -->
                    <div class="pt-12 border-t border-neutral-200 grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @if($prevPost)
                            <a href="{{ url('/our-blog/' . $prevPost->slug) }}" class="group p-6 border border-neutral-200 hover:border-black transition-colors space-y-1 block">
                                <div class="text-[10px] uppercase tracking-widest text-neutral-400 flex items-center gap-1">
                                    <span>&larr;</span>
                                    <span>Previous Briefing</span>
                                </div>
                                <div class="text-xs md:text-sm font-bold text-black group-hover:text-accent transition-colors line-clamp-2">
                                    {{ $prevPost->title }}
                                </div>
                            </a>
                        @else
                            <div></div>
                        @endif

                        @if($nextPost)
                            <a href="{{ url('/our-blog/' . $nextPost->slug) }}" class="group p-6 border border-neutral-200 hover:border-black transition-colors space-y-1 block text-right">
                                <div class="text-[10px] uppercase tracking-widest text-neutral-400 flex items-center justify-end gap-1">
                                    <span>Next Briefing</span>
                                    <span>&rarr;</span>
                                </div>
                                <div class="text-xs md:text-sm font-bold text-black group-hover:text-accent transition-colors line-clamp-2">
                                    {{ $nextPost->title }}
                                </div>
                            </a>
                        @endif
                    </div>

                </div>

                <!-- Right Column: Sidebar (4 cols) -->
                <div class="lg:col-span-4 space-y-10">
                    
                    <!-- Categories Box -->
                    <div class="bg-neutral-bg p-8 border border-neutral-200 space-y-4">
                        <h3 class="text-xs uppercase tracking-widest2 font-bold text-black border-b border-neutral-200 pb-3">
                            Publication Categories
                        </h3>
                        <ul class="space-y-2 text-xs">
                            @foreach($categories as $cat)
                                <li>
                                    <a href="{{ url('/our-blog?category=' . $cat->slug) }}" 
                                       class="flex items-center justify-between py-1 text-neutral-600 hover:text-black transition-colors">
                                        <span>{{ $cat->title }}</span>
                                        <span class="text-neutral-400 text-[11px]">({{ $cat->posts_count }})</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Recent Articles Box -->
                    @if(isset($recentPosts) && $recentPosts->count())
                        <div class="bg-neutral-bg p-8 border border-neutral-200 space-y-6">
                            <h3 class="text-xs uppercase tracking-widest2 font-bold text-black border-b border-neutral-200 pb-3">
                                Recent Publications
                            </h3>
                            <div class="space-y-4">
                                @foreach($recentPosts as $rec)
                                    <div class="space-y-1">
                                        <div class="text-[10px] uppercase tracking-wider text-neutral-400">
                                             {{ $rec->published_at ? $rec->published_at->format('M d, Y') : $rec->created_at->format('M d, Y') }}
                                        </div>
                                        <h4 class="text-xs font-bold text-black hover:text-accent transition-colors leading-snug">
                                            <a href="{{ url('/our-blog/' . $rec->slug) }}">
                                                {{ $rec->title }}
                                            </a>
                                        </h4>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </section>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
