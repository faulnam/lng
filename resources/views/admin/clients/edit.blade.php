@extends('layouts.admin')

@section('title', 'Edit Client: ' . $client->name)
@section('page_title', 'Edit Client')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    
    <div>
        <a href="{{ route('admin.clients.index') }}" class="text-xs text-neutral-400 hover:text-white uppercase tracking-wider flex items-center gap-1">
            <span>&larr; Back to Clients</span>
        </a>
    </div>

    <form action="{{ route('admin.clients.update', $client) }}" method="POST" enctype="multipart/form-data" class="bg-neutral-900 border border-neutral-800 p-6 md:p-8 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Client / Company Name <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="{{ old('name', $client->name) }}" 
                   required 
                   class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
        </div>

        <div class="space-y-3">
            <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300">
                Current Logo
            </label>
            <div class="w-32 h-16 bg-white p-2 border border-neutral-700 flex items-center justify-center">
                @if($client->logo)
                    <img src="{{ app_image($client->logo) }}" 
                         alt="{{ $client->name }}" 
                         class="max-h-12 max-w-full object-contain">
                @else
                    <span class="text-xs text-neutral-400">No logo</span>
                @endif
            </div>

            <label for="logo" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 pt-2">
                Change Logo Image (Optional)
            </label>
            <input type="file" 
                   id="logo" 
                   name="logo" 
                   accept="image/*"
                   class="w-full bg-neutral-950 border border-neutral-800 text-neutral-300 text-xs px-4 py-3 focus:outline-none focus:border-white file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-neutral-800 file:text-white hover:file:bg-neutral-700">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="website_url" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Website URL (Optional)
                </label>
                <input type="url" 
                       id="website_url" 
                       name="website_url" 
                       value="{{ old('website_url', $client->website_url) }}" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
            </div>

            <div>
                <label for="order" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Sort Order
                </label>
                <input type="number" 
                       id="order" 
                       name="order" 
                       value="{{ old('order', $client->order) }}" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
            </div>
        </div>

        <div>
            <label class="flex items-center gap-2 cursor-pointer pt-2">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $client->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded-none accent-black bg-neutral-950 border-neutral-800">
                <span class="text-xs text-white">Active (Display in client logos grid)</span>
            </label>
        </div>

        <div class="pt-6 border-t border-neutral-800 flex items-center justify-end gap-4">
            <a href="{{ route('admin.clients.index') }}" class="px-6 py-3 border border-neutral-700 text-neutral-300 hover:text-white text-xs uppercase tracking-wider">
                Cancel
            </a>
            <button type="submit" class="px-8 py-3 bg-white text-black hover:bg-neutral-200 text-xs uppercase tracking-widest2 font-bold transition-colors">
                Update Client &rarr;
            </button>
        </div>

    </form>
</div>
@endsection
