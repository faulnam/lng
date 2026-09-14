@extends('layouts.admin')

@section('title', 'Manage Projects')
@section('page_title', 'Projects & Portfolio')

@section('content')
<div class="space-y-6">
    
    <!-- Top Action & Filter Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-neutral-900 border border-neutral-800 p-4">
        
        <!-- Search & Category Filters -->
        <form action="{{ route('admin.projects.index') }}" method="GET" class="flex flex-wrap items-center gap-3 flex-1">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   placeholder="Search project title, client, or location..." 
                   class="bg-neutral-950 border border-neutral-800 text-white text-xs px-3.5 py-2 w-full md:w-64 focus:outline-none focus:border-white transition-colors placeholder:text-neutral-500">

            <select name="service_id" class="bg-neutral-950 border border-neutral-800 text-white text-xs px-3 py-2 focus:outline-none focus:border-white">
                <option value="">All Services</option>
                @foreach($services as $srv)
                    <option value="{{ $srv->id }}" {{ request('service_id') == $srv->id ? 'selected' : '' }}>
                        {{ $srv->title }}
                    </option>
                @endforeach
            </select>

            <select name="status" class="bg-neutral-950 border border-neutral-800 text-white text-xs px-3 py-2 focus:outline-none focus:border-white">
                <option value="">All Status</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-neutral-800 text-white hover:bg-neutral-700 text-xs font-semibold uppercase tracking-wider">
                Filter
            </button>

            @if(request()->hasAny(['search', 'service_id', 'status']))
                <a href="{{ route('admin.projects.index') }}" class="text-xs text-neutral-400 hover:text-white underline">Reset</a>
            @endif
        </form>

        <!-- Create Button -->
        <div>
            <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-black hover:bg-neutral-200 text-xs font-bold uppercase tracking-wider transition-colors">
                <span>+ Create Project</span>
            </a>
        </div>

    </div>

    <!-- Projects Table -->
    <div class="bg-neutral-900 border border-neutral-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-neutral-300">
                <thead class="bg-neutral-950 text-neutral-400 uppercase tracking-wider text-[10px] border-b border-neutral-800">
                    <tr>
                        <th class="py-3.5 px-4">Thumbnail</th>
                        <th class="py-3.5 px-4">Project Title</th>
                        <th class="py-3.5 px-4">Service Category</th>
                        <th class="py-3.5 px-4">Location / Year</th>
                        <th class="py-3.5 px-4 text-center">Featured</th>
                        <th class="py-3.5 px-4 text-center">Recent</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800">
                    @forelse($projects as $project)
                        <tr class="hover:bg-neutral-800/50 transition-colors">
                            
                            <!-- Thumbnail -->
                            <td class="py-3 px-4 w-16">
                                <div class="w-12 h-10 bg-neutral-800 overflow-hidden border border-neutral-700">
                                    @if($project->cover_image)
                                        <img src="{{ app_image($project->cover_image, 'images/lng/carrier.jpg') }}" 
                                             alt="{{ $project->title }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-[9px] text-neutral-500">NO IMG</div>
                                    @endif
                                </div>
                            </td>

                            <!-- Title -->
                            <td class="py-3 px-4 font-semibold text-white">
                                <a href="{{ route('admin.projects.edit', $project) }}" class="hover:text-accent transition-colors">
                                    {{ $project->title }}
                                </a>
                                @if($project->client)
                                    <div class="text-[10px] text-neutral-400 font-normal">Client: {{ $project->client }}</div>
                                @endif
                            </td>

                            <!-- Service -->
                            <td class="py-3 px-4 text-neutral-300">
                                {{ $project->service ? $project->service->title : '—' }}
                            </td>

                            <!-- Location / Year -->
                            <td class="py-3 px-4 text-neutral-400 text-[11px]">
                                {{ $project->location ?: '—' }} {{ $project->year ? "({$project->year})" : '' }}
                            </td>

                            <!-- Featured Toggle Badge -->
                            <td class="py-3 px-4 text-center">
                                @if($project->is_featured)
                                    <span class="inline-block bg-accent/20 text-accent text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider">Yes</span>
                                @else
                                    <span class="text-neutral-600 text-[10px]">—</span>
                                @endif
                            </td>

                            <!-- Recent Toggle Badge -->
                            <td class="py-3 px-4 text-center">
                                @if($project->is_recent)
                                    <span class="inline-block bg-neutral-700 text-white text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider">Yes</span>
                                @else
                                    <span class="text-neutral-600 text-[10px]">—</span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="py-3 px-4">
                                <span class="inline-block text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider {{ $project->status === 'published' ? 'bg-emerald-950 text-emerald-400 border border-emerald-800' : 'bg-yellow-950 text-yellow-400 border border-yellow-800' }}">
                                    {{ $project->status }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="py-3 px-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ url('/portfolio/' . $project->slug) }}" target="_blank" class="text-neutral-400 hover:text-white text-[11px] underline" title="Preview Live">View</a>
                                <a href="{{ route('admin.projects.edit', $project) }}" class="text-neutral-300 hover:text-white font-semibold text-[11px] underline">Edit</a>
                                
                                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this project? This will also remove its gallery images.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 text-[11px] underline ml-2">Delete</button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-neutral-500 text-xs">
                                No projects found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($projects->hasPages())
            <div class="p-4 border-t border-neutral-800">
                {{ $projects->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
