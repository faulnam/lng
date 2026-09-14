@extends('layouts.app')

@section('meta_title', $child->title . ' — ' . $parent->title . ' — ' . \App\Models\SiteSetting::get('company_name', 'PT Nusantara LNG Energi'))
@section('meta_description', $child->excerpt ?: 'Explore ' . $child->title . ' supply infrastructure by PT Nusantara LNG Energi.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('{{ app_image($child->image, 'images/lng/iso_tanks.jpg') }}');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="text-[9px] sm:text-[10px] md:text-xs uppercase tracking-wider md:tracking-widest2 text-gray-300 font-medium flex flex-wrap items-center justify-center gap-1.5 sm:gap-2 leading-relaxed">
                <a href="{{ url('/services') }}" class="hover:underline">Products &amp; Solutions</a>
                <span>&bull;</span>
                <a href="{{ url('/services/' . $parent->slug) }}" class="hover:underline">{{ $parent->title }}</a>
                <span>&bull;</span>
                <span class="text-white">{{ $child->title }}</span>
            </div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase">
                {{ $child->title }}
            </h1>
            @if($child->excerpt)
                <p class="text-neutral-300 text-xs md:text-sm max-w-2xl mx-auto leading-relaxed">
                    {{ $child->excerpt }}
                </p>
            @endif
        </div>
    </section>

    <!-- Sub-Services Navigation Tabs -->
    @if(isset($siblings) && $siblings->count())
        <section class="bg-neutral-bg border-b border-neutral-200 sticky top-16 z-30">
            <div class="max-w-7xl mx-auto px-6 md:px-12 flex items-center gap-2 md:gap-4 overflow-x-auto py-4 text-xs uppercase tracking-wider font-semibold whitespace-nowrap scrollbar-none">
                <a href="{{ url('/services/' . $parent->slug) }}" 
                   class="px-4 py-2 border border-neutral-300 text-neutral-600 hover:border-black hover:text-black transition-colors">
                    All {{ $parent->title }}
                </a>
                @foreach($siblings as $sibling)
                    <a href="{{ url('/services/' . $parent->slug . '/' . $sibling->slug) }}" 
                       class="px-4 py-2 border transition-colors {{ $sibling->id === $child->id ? 'border-black bg-black text-white' : 'border-neutral-300 text-neutral-600 hover:border-black hover:text-black' }}">
                        {{ $sibling->title }}
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Filtered Projects Grid -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 space-y-12">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-neutral-200 pb-6">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black">
                        {{ $child->title }} Operations
                    </h2>
                    <p class="text-neutral-body text-xs mt-1">
                        Showing {{ $projects->total() }} infrastructure and supply operations
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($projects as $project)
                    @include('partials.project-card', ['project' => $project])
                @empty
                    <div class="col-span-3 text-center py-16 text-neutral-400 text-sm">
                        No operations currently listed under {{ $child->title }}.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($projects->hasPages())
                <div class="pt-8 flex justify-center">
                    {{ $projects->links() }}
                </div>
            @endif

        </div>
    </section>

    <!-- CTA Section -->
    @include('partials.cta-section')

@endsection
