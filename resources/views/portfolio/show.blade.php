@extends('layouts.app')

@section('meta_title', ($project->meta_title ?: $project->title) . ' — ' . \App\Models\SiteSetting::get('company_name', 'PT Nusantara LNG Energi'))
@section('meta_description', $project->meta_description ?: strip_tags(Str::limit($project->description, 160)))

@section('content')

    <!-- 1. Hero Cover Header -->
    <section class="relative bg-black text-white pt-36 pb-24 md:pt-48 md:pb-36 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-50 transition-transform duration-1000 scale-100" 
             style="background-image: url('{{ $project->cover_image ? (str_starts_with($project->cover_image, 'http') ? $project->cover_image : asset('storage/' . $project->cover_image)) : '/images/lng/carrier.jpg' }}');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-black/40"></div>

        <div class="relative z-10 max-w-5xl mx-auto px-6 text-center space-y-4">
            @if($project->service)
                <div class="eyebrow-light">
                    @if($project->service->parent)
                        <a href="{{ url('/services/' . $project->service->parent->slug) }}" class="hover:underline">{{ $project->service->parent->title }}</a> &bull;
                    @endif
                    <a href="{{ url('/portfolio-cat/' . $project->service->slug) }}" class="hover:underline">{{ $project->service->title }}</a>
                </div>
            @endif

            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase">
                {{ $project->title }}
            </h1>

            @if($project->location)
                <p class="text-neutral-300 text-xs md:text-sm tracking-wider uppercase">
                    {{ $project->location }}
                </p>
            @endif
        </div>
    </section>

    <!-- 2. Technical Information Bar & Overview -->
    <section class="py-16 md:py-20 bg-white border-b border-neutral-200">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                <!-- Left Details (7 cols: Narrative & Description) -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="eyebrow text-accent font-semibold">Technical Overview</div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black">
                        Supply Framework &amp; Operations
                    </h2>
                    <div class="text-neutral-body text-xs md:text-sm leading-relaxed space-y-4 prose max-w-none">
                        @if($project->description)
                            {!! $project->description !!}
                        @else
                            <p>
                                Engineered cryogenic infrastructure and reliable gas supply operations delivering dependable natural gas energy for utility offtakers and heavy manufacturing facilities.
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Right Metadata Sidebar (5 cols: Project Specs) -->
                <div class="lg:col-span-5 bg-neutral-bg p-8 border border-neutral-200 space-y-6">
                    <h3 class="text-xs uppercase tracking-widest2 font-bold text-black border-b border-neutral-200 pb-3">
                        Technical Specifications
                    </h3>

                    <div class="space-y-4 text-xs divide-y divide-neutral-200">
                        @if($project->client)
                            <div class="pt-3 first:pt-0 flex justify-between">
                                <span class="font-semibold text-neutral-500 uppercase tracking-wider text-[11px]">Offtaker / Partner:</span>
                                <span class="font-medium text-black text-right">{{ $project->client }}</span>
                            </div>
                        @endif

                        @if($project->location)
                            <div class="pt-3 flex justify-between">
                                <span class="font-semibold text-neutral-500 uppercase tracking-wider text-[11px]">Hub / Terminal Location:</span>
                                <span class="font-medium text-black text-right">{{ $project->location }}</span>
                            </div>
                        @endif

                        @if($project->size)
                            <div class="pt-3 flex justify-between">
                                <span class="font-semibold text-neutral-500 uppercase tracking-wider text-[11px]">Capacity / Volume:</span>
                                <span class="font-medium text-black text-right">{{ $project->size }}</span>
                            </div>
                        @endif

                        @if($project->year)
                            <div class="pt-3 flex justify-between">
                                <span class="font-semibold text-neutral-500 uppercase tracking-wider text-[11px]">Operational Since:</span>
                                <span class="font-medium text-black text-right">{{ $project->year }}</span>
                            </div>
                        @endif

                        @if($project->service)
                            <div class="pt-3 flex justify-between">
                                <span class="font-semibold text-neutral-500 uppercase tracking-wider text-[11px]">Business Line:</span>
                                <a href="{{ url('/portfolio-cat/' . $project->service->slug) }}" class="font-semibold text-accent hover:underline text-right">
                                    {{ $project->service->title }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 3. Photo Gallery Grid -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            <div class="space-y-2">
                <div class="eyebrow">Infrastructure Visuals</div>
                <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black">Operational Gallery</h2>
            </div>

            <!-- Gallery Grid (1 full cover image + 2 col images) -->
            <div class="space-y-6">
                @if($project->cover_image)
                    <div class="overflow-hidden bg-neutral-900 aspect-[16/9] border border-neutral-200">
                        <img src="{{ str_starts_with($project->cover_image, 'http') ? $project->cover_image : asset('storage/' . $project->cover_image) }}" 
                             alt="{{ $project->title }} Main View" 
                             loading="lazy"
                             class="w-full h-full object-cover">
                    </div>
                @endif

                @if($project->images->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($project->images as $image)
                            <div class="overflow-hidden bg-neutral-900 aspect-[4/3] border border-neutral-200 group">
                                <img src="{{ str_starts_with($image->image_path, 'http') ? $image->image_path : asset('storage/' . $image->image_path) }}" 
                                     alt="{{ $project->title }} Detail Photo" 
                                     loading="lazy"
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- 4. Prev / Next Navigation -->
    <section class="py-12 bg-neutral-950 text-white border-y border-neutral-800">
        <div class="max-w-7xl mx-auto px-6 md:px-12 flex items-center justify-between">
            @if($prevProject)
                <a href="{{ url('/portfolio/' . $prevProject->slug) }}" class="group flex items-center gap-3 text-left">
                    <span class="text-xl group-hover:-translate-x-1 transition-transform">&larr;</span>
                    <div>
                        <div class="text-[10px] uppercase tracking-widest text-neutral-400">Previous Line</div>
                        <div class="text-xs md:text-sm font-bold text-white group-hover:text-accent transition-colors">{{ $prevProject->title }}</div>
                    </div>
                </a>
            @else
                <div></div>
            @endif

            <a href="{{ url('/services') }}" class="text-xs uppercase tracking-widest2 text-neutral-400 hover:text-white border-b border-neutral-600 pb-1 hidden md:block">
                All Products &amp; Lines
            </a>

            @if($nextProject)
                <a href="{{ url('/portfolio/' . $nextProject->slug) }}" class="group flex items-center gap-3 text-right">
                    <div>
                        <div class="text-[10px] uppercase tracking-widest text-neutral-400">Next Line</div>
                        <div class="text-xs md:text-sm font-bold text-white group-hover:text-accent transition-colors">{{ $nextProject->title }}</div>
                    </div>
                    <span class="text-xl group-hover:translate-x-1 transition-transform">&rarr;</span>
                </a>
            @else
                <div></div>
            @endif
        </div>
    </section>

    <!-- 5. Related Products & Solutions -->
    @if(isset($relatedProjects) && $relatedProjects->count())
        <section class="py-20 md:py-28 bg-white">
            <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
                <div class="space-y-2">
                    <div class="eyebrow">Related Solutions</div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black">Explore Other Business Lines</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedProjects as $rel)
                        @include('partials.project-card', ['project' => $rel])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
