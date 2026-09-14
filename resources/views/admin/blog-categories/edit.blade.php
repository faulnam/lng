@extends('layouts.admin')

@section('title', 'Edit Blog Category: ' . $blogCategory->title)
@section('page_title', 'Edit Blog Category')

@section('content')
<div class="max-w-xl mx-auto space-y-6" x-data="blogCategoryEditForm()">
    
    <div>
        <a href="{{ route('admin.blog-categories.index') }}" class="text-xs text-neutral-400 hover:text-white uppercase tracking-wider flex items-center gap-1">
            <span>&larr; Back to Categories</span>
        </a>
    </div>

    <form action="{{ route('admin.blog-categories.update', $blogCategory) }}" method="POST" class="bg-neutral-900 border border-neutral-800 p-6 md:p-8 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Category Title <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   x-model="title"
                   @input="onTitleInput()"
                   value="{{ old('title', $blogCategory->title) }}" 
                   required 
                   class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
        </div>

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
                   value="{{ old('slug', $blogCategory->slug) }}" 
                   class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
            <div class="flex items-center justify-between text-[10px] text-neutral-500 mt-1">
                <span>Slug URL untuk filter kategori artikel.</span>
                <button type="button" @click="syncSlug()" class="text-accent hover:underline">Re-sync</button>
            </div>
        </div>

        <div class="pt-6 border-t border-neutral-800 flex items-center justify-end gap-4">
            <a href="{{ route('admin.blog-categories.index') }}" class="px-6 py-3 border border-neutral-700 text-neutral-300 hover:text-white text-xs uppercase tracking-wider">
                Cancel
            </a>
            <button type="submit" class="px-8 py-3 bg-white text-black hover:bg-neutral-200 text-xs uppercase tracking-widest2 font-bold transition-colors">
                Update Category &rarr;
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
    function blogCategoryEditForm() {
        return {
            title: @json(old('title', $blogCategory->title ?? '')),
            slug: @json(old('slug', $blogCategory->slug ?? '')),
            isSlugCustom: @json(old('slug', $blogCategory->slug) ? true : false),

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
</script>
@endpush
