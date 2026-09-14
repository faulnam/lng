@extends('layouts.admin')

@section('title', 'Create Service Category')
@section('page_title', 'Create Service Category')

@section('content')
<div class="max-w-3xl mx-auto space-y-6" x-data="serviceForm()">
    
    <div>
        <a href="{{ route('admin.services.index') }}" class="text-xs text-neutral-400 hover:text-white uppercase tracking-wider flex items-center gap-1">
            <span>&larr; Back to Services</span>
        </a>
    </div>

    <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="bg-neutral-900 border border-neutral-800 p-6 md:p-8 space-y-6" id="serviceForm">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="title" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Service Title <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       x-model="title"
                       @input="onTitleInput()"
                       value="{{ old('title') }}" 
                       required 
                       placeholder="e.g. Small-Scale LNG Bunkering" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
            </div>

            <div>
                <label for="parent_id" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Parent Category <span class="text-neutral-500 font-normal lowercase">(optional)</span>
                </label>
                <select id="parent_id" name="parent_id" class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white">
                    <option value="">None (Top-Level Parent Service)</option>
                    @foreach($parentServices as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                            {{ $parent->title }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="slug" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300">
                        Slug (URL Key)
                    </label>
                    <span class="inline-flex items-center gap-1 text-[10px] font-medium px-2 py-0.5 border"
                          :class="isSlugCustom ? 'text-neutral-400 bg-neutral-800/60 border-neutral-700' : 'text-accent bg-accent/10 border-accent/20'">
                        <span x-show="!isSlugCustom">✨ Auto-Generated</span>
                        <span x-show="isSlugCustom">✍️ Manual</span>
                    </span>
                </div>
                <input type="text" 
                       id="slug" 
                       name="slug" 
                       x-model="slug"
                       @input="isSlugCustom = (slug.trim() !== '')"
                       placeholder="small-scale-lng-bunkering" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                <div class="flex items-center justify-between text-[10px] text-neutral-500 mt-1">
                    <span>Otomatis dari judul layanan.</span>
                    <button type="button" @click="syncSlug()" class="text-accent hover:underline">Sync</button>
                </div>
            </div>

            <div>
                <label for="order" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Sort Order
                </label>
                <input type="number" 
                       id="order" 
                       name="order" 
                       value="{{ old('order', 0) }}" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
            </div>

            <div>
                <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Status
                </label>
                <label class="flex items-center gap-2 pt-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} class="w-4 h-4 rounded-none accent-black bg-neutral-950 border-neutral-800">
                    <span class="text-xs text-white">Active in navigation</span>
                </label>
            </div>
        </div>

        <div>
            <label for="excerpt" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Short Excerpt / Summary
            </label>
            <textarea id="excerpt" 
                      name="excerpt" 
                      rows="2" 
                      placeholder="Brief overview of this service capability..." 
                      class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-2.5 focus:outline-none focus:border-white transition-colors">{{ old('excerpt') }}</textarea>
        </div>

        <div>
            <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Detailed Description (Optional)
            </label>
            <div id="quillEditor" class="bg-neutral-950 text-white min-h-[140px] border border-neutral-800">
                {!! old('description') !!}
            </div>
            <input type="hidden" name="description" id="descriptionInput" value="{{ old('description') }}">
        </div>

        <div>
            <label for="image" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Banner / Cover Image (Optional)
            </label>
            <input type="file" 
                   id="image" 
                   name="image" 
                   accept="image/*"
                   class="w-full bg-neutral-950 border border-neutral-800 text-neutral-300 text-xs px-4 py-3 focus:outline-none focus:border-white file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-neutral-800 file:text-white hover:file:bg-neutral-700">
        </div>

        <div class="pt-6 border-t border-neutral-800 flex items-center justify-end gap-4">
            <a href="{{ route('admin.services.index') }}" class="px-6 py-3 border border-neutral-700 text-neutral-300 hover:text-white text-xs uppercase tracking-wider">
                Cancel
            </a>
            <button type="submit" class="px-8 py-3 bg-white text-black hover:bg-neutral-200 text-xs uppercase tracking-widest2 font-bold transition-colors">
                Save Service &rarr;
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
    function serviceForm() {
        return {
            title: @json(old('title', '')),
            slug: @json(old('slug', '')),
            isSlugCustom: @json(old('slug') ? true : false),

            generateSlug(text) {
                return (text || '')
                    .toString()
                    .toLowerCase()
                    .trim()
                    .replace(/&/g, '-and-')
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/[\s-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            },

            onTitleInput() {
                if (!this.isSlugCustom) {
                    this.slug = this.generateSlug(this.title);
                }
            },

            syncSlug() {
                this.slug = this.generateSlug(this.title);
                this.isSlugCustom = false;
            }
        };
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (typeof Quill !== 'undefined') {
            var quill = new Quill('#quillEditor', {
                theme: 'snow',
                placeholder: 'Describe what this service entails...',
                modules: {
                    toolbar: [
                        [{ 'header': [2, 3, false] }],
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['clean']
                    ]
                }
            });

            var form = document.getElementById('serviceForm');
            var descriptionInput = document.getElementById('descriptionInput');

            form.addEventListener('submit', function () {
                descriptionInput.value = quill.root.innerHTML;
            });
        }
    });
</script>
@endpush
