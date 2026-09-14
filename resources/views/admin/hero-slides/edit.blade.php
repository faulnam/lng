@extends('layouts.admin')

@section('title', 'Edit Hero Slide')
@section('page_title', 'Edit Hero Slide')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    
    <div>
        <a href="{{ route('admin.hero-slides.index') }}" class="text-xs text-neutral-400 hover:text-white uppercase tracking-wider flex items-center gap-1">
            <span>&larr; Back to Hero Slides</span>
        </a>
    </div>

    <form action="{{ route('admin.hero-slides.update', $heroSlide) }}" method="POST" enctype="multipart/form-data" class="bg-neutral-900 border border-neutral-800 p-6 md:p-8 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="page" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Target Page <span class="text-red-500">*</span>
                </label>
                <select id="page" name="page" required class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white">
                    <option value="home" {{ old('page', $heroSlide->page) === 'home' ? 'selected' : '' }}>Homepage</option>
                    <option value="about" {{ old('page', $heroSlide->page) === 'about' ? 'selected' : '' }}>About Us</option>
                    <option value="services" {{ old('page', $heroSlide->page) === 'services' ? 'selected' : '' }}>Services</option>
                    <option value="clients" {{ old('page', $heroSlide->page) === 'clients' ? 'selected' : '' }}>Clients</option>
                    <option value="awards" {{ old('page', $heroSlide->page) === 'awards' ? 'selected' : '' }}>Awards</option>
                    <option value="blog" {{ old('page', $heroSlide->page) === 'blog' ? 'selected' : '' }}>Blog</option>
                    <option value="contact" {{ old('page', $heroSlide->page) === 'contact' ? 'selected' : '' }}>Contact</option>
                    <option value="career" {{ old('page', $heroSlide->page) === 'career' ? 'selected' : '' }}>Career</option>
                </select>
            </div>

            <div>
                <label for="image" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Replace Background Image
                </label>
                <input type="file" 
                       id="image" 
                       name="image" 
                       accept="image/*"
                       class="w-full bg-neutral-950 border border-neutral-800 text-neutral-300 text-xs px-4 py-3 focus:outline-none focus:border-white file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-neutral-800 file:text-white hover:file:bg-neutral-700">
            </div>
        </div>

        @if($heroSlide->image)
            <div class="space-y-1">
                <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300">Current Image</label>
                <div class="w-48 h-24 bg-neutral-950 border border-neutral-800 overflow-hidden">
                    <img src="{{ app_image($heroSlide->image, 'images/lng/carrier.jpg') }}" class="w-full h-full object-cover">
                </div>
            </div>
        @endif

        <div>
            <label for="title" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Headline Title (Optional)
            </label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   value="{{ old('title', $heroSlide->title) }}" 
                   class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
        </div>

        <div>
            <label for="subtitle" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Subtitle / Description (Optional)
            </label>
            <input type="text" 
                   id="subtitle" 
                   name="subtitle" 
                   value="{{ old('subtitle', $heroSlide->subtitle) }}" 
                   class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="button_text" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Call To Action Button Text
                </label>
                <input type="text" 
                       id="button_text" 
                       name="button_text" 
                       value="{{ old('button_text', $heroSlide->button_text) }}" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
            </div>

            <div>
                <label for="button_link" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Button Target Link
                </label>
                <input type="text" 
                       id="button_link" 
                       name="button_link" 
                       value="{{ old('button_link', $heroSlide->button_link) }}" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
            <div>
                <label for="order" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Sort Order
                </label>
                <input type="number" 
                       id="order" 
                       name="order" 
                       value="{{ old('order', $heroSlide->order) }}" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
            </div>

            <div>
                <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Status
                </label>
                <label class="flex items-center gap-2 pt-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $heroSlide->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded-none accent-black bg-neutral-950 border-neutral-800">
                    <span class="text-xs text-white">Active</span>
                </label>
            </div>
        </div>

        <div class="pt-6 border-t border-neutral-800 flex items-center justify-end gap-4">
            <a href="{{ route('admin.hero-slides.index') }}" class="px-6 py-3 border border-neutral-700 text-neutral-300 hover:text-white text-xs uppercase tracking-wider">
                Cancel
            </a>
            <button type="submit" class="px-8 py-3 bg-white text-black hover:bg-neutral-200 text-xs uppercase tracking-widest2 font-bold transition-colors">
                Update Hero Slide &rarr;
            </button>
        </div>

    </form>
</div>
@endsection
