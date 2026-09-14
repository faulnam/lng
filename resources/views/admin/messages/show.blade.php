@extends('layouts.admin')

@section('title', 'Message from ' . $message->name)
@section('page_title', 'Read Message')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.messages.index') }}" class="text-xs text-neutral-400 hover:text-white uppercase tracking-wider flex items-center gap-1">
            <span>&larr; Back to Inbox</span>
        </a>
        <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Delete this message?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-xs text-red-400 hover:text-red-300 uppercase tracking-wider underline">
                Delete Message
            </button>
        </form>
    </div>

    <div class="bg-neutral-900 border border-neutral-800 p-6 md:p-8 space-y-8">
        
        <!-- Header Info -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-neutral-800 pb-6">
            <div class="space-y-1">
                <h2 class="text-xl font-bold text-white">{{ $message->name }}</h2>
                @if($message->company)
                    <div class="text-xs text-accent font-semibold">{{ $message->company }}</div>
                @endif
                <div class="text-xs text-neutral-400">
                    <a href="mailto:{{ $message->email }}" class="underline hover:text-white">{{ $message->email }}</a>
                    @if($message->phone)
                        &bull; <span>{{ $message->phone }}</span>
                    @endif
                </div>
            </div>

            <div class="text-[11px] text-neutral-500 font-mono">
                Received: {{ $message->created_at->format('F d, Y H:i') }} ({{ $message->created_at->diffForHumans() }})
            </div>
        </div>

        <!-- Message Body -->
        <div class="space-y-3">
            <div class="text-[10px] uppercase tracking-widest text-neutral-500 font-bold">Inquiry Content:</div>
            <div class="p-6 bg-neutral-950 border border-neutral-800 text-sm text-neutral-200 leading-relaxed whitespace-pre-line font-mono">
                {{ $message->message }}
            </div>
        </div>

        <!-- Quick Reply Action -->
        <div class="pt-6 border-t border-neutral-800 flex items-center justify-between">
            <a href="mailto:{{ $message->email }}?subject=Re:%20LNG%20Commercial%20Inquiry%20from%20PT%20Nusantara%20LNG%20Energi" class="px-6 py-3 bg-white text-black hover:bg-neutral-200 text-xs uppercase tracking-widest font-bold transition-colors">
                Reply via Email &rarr;
            </a>

            @if($message->phone)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $message->phone) }}" target="_blank" class="px-4 py-3 border border-emerald-700 text-emerald-400 hover:bg-emerald-950 text-xs uppercase tracking-wider transition-colors">
                    Reply on WhatsApp
                </a>
            @endif
        </div>

    </div>
</div>
@endsection
