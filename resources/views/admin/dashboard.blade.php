@extends('layouts.admin')

@section('title', 'Dashboard Overview')
@section('page_title', 'Dashboard Overview')

@section('content')
<div class="space-y-8">
    
    <!-- Welcome Header -->
    <div class="bg-neutral-900 border border-neutral-800 p-6 md:p-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                Welcome back, {{ auth()->user()->name }}!
            </h2>
            <p class="text-xs text-neutral-400 mt-1">
                Here is a summary of your LNG corporate profile contents, product lines, and commercial inquiries.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.projects.create') }}" class="px-4 py-2.5 bg-white text-black hover:bg-neutral-200 text-[11px] uppercase tracking-wider font-semibold transition-colors">
                + New Product Line
            </a>
            <a href="{{ route('admin.settings.edit') }}" class="px-4 py-2.5 border border-neutral-700 text-neutral-300 hover:text-white hover:border-neutral-500 text-[11px] uppercase tracking-wider transition-colors">
                Edit Settings
            </a>
        </div>
    </div>

    <!-- 8 Analytical Counter Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
        
        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Products &amp; Lines</div>
            <div class="text-3xl font-bold text-white">{{ $stats['projects'] }}</div>
            <a href="{{ route('admin.projects.index') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Manage Products &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Product Categories</div>
            <div class="text-3xl font-bold text-white">{{ $stats['services'] }}</div>
            <a href="{{ route('admin.services.index') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Manage Hierarchy &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Strategic Offtakers</div>
            <div class="text-3xl font-bold text-white">{{ $stats['clients'] }}</div>
            <a href="{{ route('admin.clients.index') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Manage Offtakers &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Accreditations</div>
            <div class="text-3xl font-bold text-white">{{ $stats['awards'] }}</div>
            <a href="{{ url('/admin/awards') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">View Awards &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Energy Articles</div>
            <div class="text-3xl font-bold text-white">{{ $stats['posts'] }}</div>
            <a href="{{ url('/admin/blog-posts') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Manage Articles &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Job Vacancies</div>
            <div class="text-3xl font-bold text-white">{{ $stats['vacancies'] }}</div>
            <a href="{{ url('/admin/job-vacancies') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Manage Careers &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Commercial Inquiries</div>
            <div class="text-3xl font-bold {{ $stats['unread_messages'] > 0 ? 'text-accent' : 'text-white' }}">
                {{ $stats['unread_messages'] }}
            </div>
            <a href="{{ url('/admin/messages') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Open Inbox &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Subscribers</div>
            <div class="text-3xl font-bold text-white">{{ $stats['subscribers'] }}</div>
            <a href="{{ url('/admin/subscribers') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">View Subscribers &rarr;</a>
        </div>

    </div>

    <!-- Recent Data Tables (2 Columns) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Recent Products -->
        <div class="bg-neutral-900 border border-neutral-800 p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-neutral-800 pb-3">
                <h3 class="text-xs uppercase tracking-widest font-bold text-white">Recent Products &amp; Lines</h3>
                <a href="{{ route('admin.projects.index') }}" class="text-[10px] text-neutral-400 hover:text-white uppercase tracking-wider">View All</a>
            </div>

            <div class="space-y-3">
                @forelse($recentProjects as $p)
                    <div class="flex items-center justify-between p-3 bg-neutral-950/60 border border-neutral-800/80 text-xs">
                        <div class="flex items-center gap-3 truncate">
                            <div class="w-10 h-10 bg-neutral-800 overflow-hidden shrink-0">
                                @if($p->cover_image)
                                    <img src="{{ str_starts_with($p->cover_image, 'http') ? $p->cover_image : asset('storage/' . $p->cover_image) }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="truncate">
                                <a href="{{ route('admin.projects.edit', $p) }}" class="font-medium text-white hover:text-accent truncate block">
                                    {{ $p->title }}
                                </a>
                                <span class="text-[10px] text-neutral-500">{{ $p->service->title ?? 'General' }}</span>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 text-[9px] uppercase tracking-wider font-semibold {{ $p->status === 'published' ? 'bg-emerald-950 text-emerald-400 border border-emerald-800' : 'bg-neutral-800 text-neutral-400' }}">
                            {{ $p->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-xs text-neutral-500 py-4 text-center">No products created yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Messages / Inquiries -->
        <div class="bg-neutral-900 border border-neutral-800 p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-neutral-800 pb-3">
                <h3 class="text-xs uppercase tracking-widest font-bold text-white">Recent Inquiries</h3>
                <a href="{{ route('admin.messages.index') }}" class="text-[10px] text-neutral-400 hover:text-white uppercase tracking-wider">View All</a>
            </div>

            <div class="space-y-3">
                @forelse($recentMessages as $m)
                    <div class="p-3 bg-neutral-950/60 border border-neutral-800/80 text-xs space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-white">{{ $m->name }}</span>
                            <span class="text-[10px] text-neutral-500">{{ $m->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-neutral-400 text-[11px] truncate">{{ $m->message }}</p>
                    </div>
                @empty
                    <p class="text-xs text-neutral-500 py-4 text-center">No messages received yet.</p>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
