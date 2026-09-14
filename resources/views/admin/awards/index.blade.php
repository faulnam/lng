@extends('layouts.admin')

@section('title', 'Manage Awards & Publications')
@section('page_title', 'Awards & Publications')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-neutral-900 border border-neutral-800 p-4">
        <form action="{{ route('admin.awards.index') }}" method="GET" class="flex items-center gap-3 flex-1">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   placeholder="Search award title..." 
                   class="bg-neutral-950 border border-neutral-800 text-white text-xs px-3.5 py-2 w-full md:w-64 focus:outline-none focus:border-white transition-colors placeholder:text-neutral-500">
            <button type="submit" class="px-4 py-2 bg-neutral-800 text-white hover:bg-neutral-700 text-xs font-semibold uppercase tracking-wider">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.awards.index') }}" class="text-xs text-neutral-400 hover:text-white underline">Reset</a>
            @endif
        </form>

        <a href="{{ route('admin.awards.create') }}" class="px-4 py-2.5 bg-white text-black hover:bg-neutral-200 text-xs font-bold uppercase tracking-wider transition-colors inline-block text-center">
            + Add Award / Press
        </a>
    </div>

    <div class="bg-neutral-900 border border-neutral-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-neutral-300">
                <thead class="bg-neutral-950 text-neutral-400 uppercase tracking-wider text-[10px] border-b border-neutral-800">
                    <tr>
                        <th class="py-3.5 px-4">Image</th>
                        <th class="py-3.5 px-4">Title</th>
                        <th class="py-3.5 px-4">Date</th>
                        <th class="py-3.5 px-4 text-center">Order</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800">
                    @forelse($awards as $award)
                        <tr class="hover:bg-neutral-800/50 transition-colors">
                            <td class="py-3 px-4 w-16">
                                <div class="w-12 h-10 bg-neutral-800 overflow-hidden border border-neutral-700">
                                    @if($award->image)
                                        <img src="{{ app_image($award->image, 'images/lng/carrier.jpg') }}" alt="{{ $award->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-[9px] text-neutral-500">NO IMG</div>
                                    @endif
                                </div>
                            </td>

                            <td class="py-3 px-4 font-semibold text-white">
                                {{ $award->title }}
                                @if($award->external_link)
                                    <div class="text-[10px] text-neutral-400 font-normal">
                                        <a href="{{ $award->external_link }}" target="_blank" class="hover:underline">Link &rarr;</a>
                                    </div>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-neutral-400">
                                {{ $award->published_date ? $award->published_date->format('M Y') : '—' }}
                            </td>

                            <td class="py-3 px-4 text-center text-neutral-400">
                                {{ $award->order }}
                            </td>

                            <td class="py-3 px-4 text-center">
                                @if($award->is_active)
                                    <span class="inline-block bg-emerald-950 text-emerald-400 text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider border border-emerald-800">Active</span>
                                @else
                                    <span class="inline-block bg-neutral-800 text-neutral-500 text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider">Inactive</span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-right space-x-2">
                                <a href="{{ url('/awards-publications/' . $award->slug) }}" target="_blank" class="text-neutral-400 hover:text-white underline text-[11px]">View</a>
                                <a href="{{ route('admin.awards.edit', $award) }}" class="text-neutral-300 hover:text-white font-semibold underline text-[11px]">Edit</a>
                                
                                <form action="{{ route('admin.awards.destroy', $award) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this award?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 text-[11px] underline ml-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-neutral-500 text-xs">
                                No awards found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($awards->hasPages())
            <div class="p-4 border-t border-neutral-800">
                {{ $awards->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
