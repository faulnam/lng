@extends('layouts.admin')

@section('title', 'Manage Hero Slides')
@section('page_title', 'Hero Slides & Banners')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-neutral-900 border border-neutral-800 p-4">
        <form action="{{ route('admin.hero-slides.index') }}" method="GET" class="flex items-center gap-3 flex-1">
            <select name="page_filter" class="bg-neutral-950 border border-neutral-800 text-white text-xs px-3 py-2 focus:outline-none focus:border-white">
                <option value="">All Pages</option>
                <option value="home" {{ request('page_filter') === 'home' ? 'selected' : '' }}>Homepage</option>
                <option value="about" {{ request('page_filter') === 'about' ? 'selected' : '' }}>About Us</option>
                <option value="services" {{ request('page_filter') === 'services' ? 'selected' : '' }}>Services</option>
                <option value="clients" {{ request('page_filter') === 'clients' ? 'selected' : '' }}>Clients</option>
                <option value="blog" {{ request('page_filter') === 'blog' ? 'selected' : '' }}>Blog</option>
                <option value="contact" {{ request('page_filter') === 'contact' ? 'selected' : '' }}>Contact</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-neutral-800 text-white hover:bg-neutral-700 text-xs font-semibold uppercase tracking-wider">
                Filter Page
            </button>
            @if(request('page_filter'))
                <a href="{{ route('admin.hero-slides.index') }}" class="text-xs text-neutral-400 hover:text-white underline">Reset</a>
            @endif
        </form>

        <a href="{{ route('admin.hero-slides.create') }}" class="px-4 py-2.5 bg-white text-black hover:bg-neutral-200 text-xs font-bold uppercase tracking-wider transition-colors inline-block text-center">
            + Add Hero Slide
        </a>
    </div>

    <div class="bg-neutral-900 border border-neutral-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-neutral-300">
                <thead class="bg-neutral-950 text-neutral-400 uppercase tracking-wider text-[10px] border-b border-neutral-800">
                    <tr>
                        <th class="py-3.5 px-4">Image</th>
                        <th class="py-3.5 px-4">Target Page</th>
                        <th class="py-3.5 px-4">Title / Headline</th>
                        <th class="py-3.5 px-4 text-center">Order</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800">
                    @forelse($slides as $slide)
                        <tr class="hover:bg-neutral-800/50 transition-colors">
                            <td class="py-3 px-4 w-20">
                                <div class="w-16 h-10 bg-neutral-800 overflow-hidden border border-neutral-700">
                                    @if($slide->image)
                                        <img src="{{ app_image($slide->image, 'images/lng/carrier.jpg') }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-[9px] text-neutral-500">NO IMG</div>
                                    @endif
                                </div>
                            </td>

                            <td class="py-3 px-4 font-bold text-white uppercase text-[11px]">
                                {{ $slide->page }}
                            </td>

                            <td class="py-3 px-4 text-neutral-300">
                                <div>{{ $slide->title ?: '—' }}</div>
                                @if($slide->subtitle)
                                    <div class="text-[10px] text-neutral-500">{{ $slide->subtitle }}</div>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-center text-neutral-400">
                                {{ $slide->order }}
                            </td>

                            <td class="py-3 px-4 text-center">
                                @if($slide->is_active)
                                    <span class="inline-block bg-emerald-950 text-emerald-400 text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider border border-emerald-800">Active</span>
                                @else
                                    <span class="inline-block bg-neutral-800 text-neutral-500 text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider">Inactive</span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-right space-x-2">
                                <a href="{{ route('admin.hero-slides.edit', $slide) }}" class="text-neutral-300 hover:text-white font-semibold underline text-[11px]">Edit</a>
                                
                                <form action="{{ route('admin.hero-slides.destroy', $slide) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this hero slide?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 text-[11px] underline ml-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-neutral-500 text-xs">
                                No hero slides registered yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($slides->hasPages())
            <div class="p-4 border-t border-neutral-800">
                {{ $slides->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
