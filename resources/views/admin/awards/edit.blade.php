@extends('layouts.admin')

@section('title', 'Edit Award: ' . $award->title)
@section('page_title', 'Edit Award / Publication')

@section('content')
<div class="max-w-3xl mx-auto space-y-6" x-data="awardEditForm()">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.awards.index') }}" class="text-xs text-neutral-400 hover:text-white uppercase tracking-wider flex items-center gap-1">
            <span>&larr; Back to Awards</span>
        </a>
    </div>

    <form action="{{ route('admin.awards.update', $award) }}" method="POST" enctype="multipart/form-data" class="bg-neutral-900 border border-neutral-800 p-6 md:p-8 space-y-6" id="awardForm">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Award / Publication Title <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   x-model="title"
                   @input="onTitleInput()"
                   value="{{ old('title', $award->title) }}" 
                   required 
                   class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="slug" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300">
                        Slug (URL Key)
                    </label>
                    <span class="inline-flex items-center gap-1 text-[10px] font-medium px-2 py-0.5 border"
                          :class="isSlugCustom ? 'text-neutral-400 bg-neutral-800/60 border-neutral-700' : 'text-accent bg-accent/10 border-accent/20'">
                        <span x-show="!isSlugCustom">✨ Auto-Generated</span>
                        <span x-show="isSlugCustom">✍️ Manual / Saved</span>
                    </span>
                </div>
                <input type="text" 
                       id="slug" 
                       name="slug" 
                       x-model="slug"
                       @input="isSlugCustom = true"
                       value="{{ old('slug', $award->slug) }}" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                <div class="flex items-center justify-between text-[10px] text-neutral-500 mt-1">
                    <span>Slug URL publikasi penghargaan.</span>
                    <button type="button" @click="syncSlug()" class="text-accent hover:underline">Re-sync</button>
                </div>
            </div>

            <div>
                <label for="published_date" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Date Received / Published
                </label>
                <input type="date" 
                       id="published_date" 
                       name="published_date" 
                       value="{{ old('published_date', $award->published_date ? $award->published_date->format('Y-m-d') : '') }}" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
            </div>
        </div>

        <div>
            <label for="external_link" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                External Publication URL (Optional)
            </label>
            <input type="url" 
                   id="external_link" 
                   name="external_link" 
                   value="{{ old('external_link', $award->external_link) }}" 
                   class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
        </div>

        <div>
            <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Description / Accolade Narrative
            </label>
            <div id="quillEditor" class="bg-neutral-950 text-white min-h-[140px] border border-neutral-800">
                {!! old('description', $award->description) !!}
            </div>
            <input type="hidden" name="description" id="descriptionInput" value="{{ old('description', $award->description) }}">
        </div>

        <div class="space-y-4">
            @if($award->image)
                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-1">
                        Current Image
                    </label>
                    <div class="w-32 h-20 bg-neutral-950 border border-neutral-800 overflow-hidden">
                        <img src="{{ app_image($award->image, 'images/lng/carrier.jpg') }}" class="w-full h-full object-cover">
                    </div>
                </div>
            @endif

            <div>
                <label for="image" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    {{ $award->image ? 'Replace Image' : 'Upload Image' }}
                </label>
                <input type="file" 
                       id="image" 
                       name="image" 
                       accept="image/*"
                       class="w-full bg-neutral-950 border border-neutral-800 text-neutral-300 text-xs px-4 py-3 focus:outline-none focus:border-white file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-neutral-800 file:text-white hover:file:bg-neutral-700">
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
                       value="{{ old('order', $award->order) }}" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
            </div>

            <div>
                <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Status
                </label>
                <label class="flex items-center gap-2 pt-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $award->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded-none accent-black bg-neutral-950 border-neutral-800">
                    <span class="text-xs text-white">Active (Display publicly)</span>
                </label>
            </div>
        </div>

        <div class="pt-6 border-t border-neutral-800 flex items-center justify-end gap-4">
            <a href="{{ route('admin.awards.index') }}" class="px-6 py-3 border border-neutral-700 text-neutral-300 hover:text-white text-xs uppercase tracking-wider">
                Cancel
            </a>
            <button type="submit" class="px-8 py-3 bg-white text-black hover:bg-neutral-200 text-xs uppercase tracking-widest2 font-bold transition-colors">
                Update Award &rarr;
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
    function awardEditForm() {
        return {
            title: @json(old('title', $award->title ?? '')),
            slug: @json(old('slug', $award->slug ?? '')),
            isSlugCustom: @json(old('slug', $award->slug) ? true : false),

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
                placeholder: 'Describe the accolade and project details...',
                modules: {
                    toolbar: [
                        [{ 'header': [2, 3, false] }],
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['link', 'clean']
                    ]
                }
            });

            var form = document.getElementById('awardForm');
            var descriptionInput = document.getElementById('descriptionInput');

            form.addEventListener('submit', function () {
                descriptionInput.value = quill.root.innerHTML;
            });
        }
    });
</script>
@endpush
