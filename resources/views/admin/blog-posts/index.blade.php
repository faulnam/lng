@extends('layouts.admin')

@section('title', 'Manage Blog Articles')
@section('page_title', 'Blog & Insights Articles')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-neutral-900 border border-neutral-800 p-4">
        <form action="{{ route('admin.blog-posts.index') }}" method="GET" class="flex flex-wrap items-center gap-3 flex-1">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   placeholder="Search article title or author..." 
                   class="bg-neutral-950 border border-neutral-800 text-white text-xs px-3.5 py-2 w-full md:w-64 focus:outline-none focus:border-white transition-colors placeholder:text-neutral-500">

            <select name="category_id" class="bg-neutral-950 border border-neutral-800 text-white text-xs px-3 py-2 focus:outline-none focus:border-white">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->title }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 bg-neutral-800 text-white hover:bg-neutral-700 text-xs font-semibold uppercase tracking-wider">
                Filter
            </button>

            @if(request()->hasAny(['search', 'category_id']))
                <a href="{{ route('admin.blog-posts.index') }}" class="text-xs text-neutral-400 hover:text-white underline">Reset</a>
            @endif
        </form>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.blog-categories.index') }}" class="px-3 py-2.5 border border-neutral-700 text-neutral-300 hover:text-white text-xs uppercase tracking-wider">
                Categories
            </a>
            <a href="{{ route('admin.blog-posts.create') }}" class="px-4 py-2.5 bg-white text-black hover:bg-neutral-200 text-xs font-bold uppercase tracking-wider transition-colors inline-block text-center">
                + Write Article
            </a>
        </div>
    </div>

    <div class="bg-neutral-900 border border-neutral-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-neutral-300">
                <thead class="bg-neutral-950 text-neutral-400 uppercase tracking-wider text-[10px] border-b border-neutral-800">
                    <tr>
                        <th class="py-3.5 px-4">Cover</th>
                        <th class="py-3.5 px-4">Article Title</th>
                        <th class="py-3.5 px-4">Category</th>
                        <th class="py-3.5 px-4">Author / Date</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800">
                    @forelse($posts as $post)
                        <tr class="hover:bg-neutral-800/50 transition-colors">
                            <td class="py-3 px-4 w-16">
                                <div class="w-12 h-10 bg-neutral-800 overflow-hidden border border-neutral-700">
                                    @if($post->cover_image)
                                        <img src="{{ app_image($post->cover_image, 'images/lng/carrier.jpg') }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-[9px] text-neutral-500">NO IMG</div>
                                    @endif
                                </div>
                            </td>

                            <td class="py-3 px-4 font-semibold text-white">
                                <a href="{{ route('admin.blog-posts.edit', $post) }}" class="hover:text-accent transition-colors">
                                    {{ $post->title }}
                                </a>
                            </td>

                            <td class="py-3 px-4 text-neutral-400">
                                {{ $post->category ? $post->category->title : 'Uncategorized' }}
                            </td>

                            <td class="py-3 px-4 text-neutral-400 text-[11px]">
                                <div>{{ $post->author ?: 'Nusantara Energy Insights' }}</div>
                                <div class="text-[10px] text-neutral-500">{{ $post->published_at ? $post->published_at->format('M d, Y') : '—' }}</div>
                            </td>

                            <td class="py-3 px-4 text-center">
                                @if($post->is_published)
                                    <span class="inline-block bg-emerald-950 text-emerald-400 text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider border border-emerald-800">Published</span>
                                @else
                                    <span class="inline-block bg-neutral-800 text-neutral-500 text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider">Draft</span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-right space-x-2">
                                <a href="{{ url('/our-blog/' . $post->slug) }}" target="_blank" class="text-neutral-400 hover:text-white underline text-[11px]">View</a>
                                <a href="{{ route('admin.blog-posts.edit', $post) }}" class="text-neutral-300 hover:text-white font-semibold underline text-[11px]">Edit</a>
                                
                                <form action="{{ route('admin.blog-posts.destroy', $post) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this article?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 text-[11px] underline ml-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-neutral-500 text-xs">
                                No articles found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
            <div class="p-4 border-t border-neutral-800">
                {{ $posts->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
