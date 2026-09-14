@extends('layouts.admin')

@section('title', 'Edit Blog Article: ' . $blogPost->title)
@section('page_title', 'Edit Blog Article')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="blogPostEditForm()">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.blog-posts.index') }}" class="text-xs text-neutral-400 hover:text-white uppercase tracking-wider flex items-center gap-1">
            <span>&larr; Back to Articles</span>
        </a>
        <a href="{{ url('/our-blog/' . $blogPost->slug) }}" target="_blank" class="text-xs text-accent hover:underline uppercase tracking-wider">
            View Live Article &rarr;
        </a>
    </div>

    <form action="{{ route('admin.blog-posts.update', $blogPost) }}" method="POST" enctype="multipart/form-data" class="bg-neutral-900 border border-neutral-800 p-6 md:p-8 space-y-6" id="blogForm">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Article Title <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   x-model="title"
                   @input="onTitleInput()"
                   value="{{ old('title', $blogPost->title) }}" 
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
                       value="{{ old('slug', $blogPost->slug) }}" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                <div class="flex items-center justify-between text-[10px] text-neutral-500 mt-1">
                    <span>Slug URL untuk tautan artikel.</span>
                    <button type="button" @click="syncSlug()" class="text-accent hover:underline flex items-center gap-1">
                        Re-sync dari Judul
                    </button>
                </div>
            </div>

            <div>
                <label for="blog_category_id" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Category
                </label>
                <select id="blog_category_id" name="blog_category_id" class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white">
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('blog_category_id', $blogPost->blog_category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->title }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="author" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Author Name
                </label>
                <input type="text" 
                       id="author" 
                       name="author" 
                       value="{{ old('author', $blogPost->author) }}" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
            </div>

            <div>
                <label for="published_at" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Publication Date
                </label>
                <input type="date" 
                       id="published_at" 
                       name="published_at" 
                       value="{{ old('published_at', $blogPost->published_at ? $blogPost->published_at->format('Y-m-d') : '') }}" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="excerpt" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300">
                    Article Summary / Excerpt Quote
                </label>
                <span class="text-[10px] text-neutral-500">Kutipan singkat untuk kartu artikel</span>
            </div>
            <textarea id="excerpt" 
                      name="excerpt" 
                      x-model="excerpt"
                      rows="2" 
                      class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-2.5 focus:outline-none focus:border-white transition-colors">{{ old('excerpt', $blogPost->excerpt) }}</textarea>
        </div>

        <div>
            <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Full Article Content <span class="text-red-500">*</span>
            </label>
            <div id="quillEditor" class="bg-neutral-950 text-white min-h-[220px] border border-neutral-800">
                {!! old('content', $blogPost->content) !!}
            </div>
            <input type="hidden" name="content" id="contentInput" value="{{ old('content', $blogPost->content) }}">
        </div>

        <div class="space-y-3">
            @if($blogPost->cover_image)
                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-1">
                        Current Cover Image
                    </label>
                    <div class="w-44 h-24 bg-neutral-950 border border-neutral-800 overflow-hidden">
                        <img src="{{ app_image($blogPost->cover_image, 'images/lng/carrier.jpg') }}" class="w-full h-full object-cover">
                    </div>
                </div>
            @endif

            <div>
                <label for="cover_image" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    {{ $blogPost->cover_image ? 'Replace Cover Image' : 'Upload Cover Image' }}
                </label>
                <input type="file" 
                       id="cover_image" 
                       name="cover_image" 
                       accept="image/*"
                       class="w-full bg-neutral-950 border border-neutral-800 text-neutral-300 text-xs px-4 py-3 focus:outline-none focus:border-white file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-neutral-800 file:text-white hover:file:bg-neutral-700">
            </div>
        </div>

        <div>
            <label class="flex items-center gap-2 cursor-pointer pt-2">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $blogPost->is_published) ? 'checked' : '' }} class="w-4 h-4 rounded-none accent-black bg-neutral-950 border-neutral-800">
                <span class="text-xs text-white">Publish Article (Visible on public blog)</span>
            </label>
        </div>

        <!-- SEO Metadata Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-neutral-800">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="meta_title" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300">
                        SEO Meta Title
                    </label>
                    <span class="inline-flex items-center gap-1 text-[10px] font-medium px-2 py-0.5 border"
                          :class="isMetaTitleCustom ? 'text-neutral-400 bg-neutral-800/60 border-neutral-700' : 'text-accent bg-accent/10 border-accent/20'">
                        <span x-show="!isMetaTitleCustom">✨ Auto-Generated</span>
                        <span x-show="isMetaTitleCustom">✍️ Manual / Saved</span>
                    </span>
                </div>
                <input type="text" 
                       id="meta_title" 
                       name="meta_title" 
                       x-model="metaTitle"
                       @input="isMetaTitleCustom = true"
                       value="{{ old('meta_title', $blogPost->meta_title) }}" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                <div class="flex items-center justify-between text-[10px] text-neutral-500 mt-1">
                    <span>Judul meta untuk pencarian Google.</span>
                    <button type="button" @click="syncMetaTitle()" class="text-accent hover:underline flex items-center gap-1">
                        Re-sync dari Judul
                    </button>
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="meta_description" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300">
                        SEO Meta Description
                    </label>
                    <span class="inline-flex items-center gap-1 text-[10px] font-medium px-2 py-0.5 border"
                          :class="isMetaDescriptionCustom ? 'text-neutral-400 bg-neutral-800/60 border-neutral-700' : 'text-accent bg-accent/10 border-accent/20'">
                        <span x-show="!isMetaDescriptionCustom">✨ Auto-Generated</span>
                        <span x-show="isMetaDescriptionCustom">✍️ Manual / Saved</span>
                    </span>
                </div>
                <textarea id="meta_description" 
                          name="meta_description" 
                          x-model="metaDescription"
                          @input="isMetaDescriptionCustom = true"
                          rows="2" 
                          class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-2.5 focus:outline-none focus:border-white transition-colors">{{ old('meta_description', $blogPost->meta_description) }}</textarea>
                <div class="flex items-center justify-between text-[10px] text-neutral-500 mt-1">
                    <span>Ringkasan untuk hasil pencarian Google.</span>
                    <span :class="metaDescription.length > 160 ? 'text-amber-400 font-semibold' : 'text-neutral-500'" x-text="metaDescription.length + '/160 karakter'"></span>
                </div>
            </div>
        </div>

        <div class="pt-6 border-t border-neutral-800 flex items-center justify-end gap-4">
            <a href="{{ route('admin.blog-posts.index') }}" class="px-6 py-3 border border-neutral-700 text-neutral-300 hover:text-white text-xs uppercase tracking-wider">
                Cancel
            </a>
            <button type="submit" class="px-8 py-3 bg-white text-black hover:bg-neutral-200 text-xs uppercase tracking-widest2 font-bold transition-colors">
                Update Article &rarr;
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
    function blogPostEditForm() {
        return {
            title: @json(old('title', $blogPost->title ?? '')),
            slug: @json(old('slug', $blogPost->slug ?? '')),
            excerpt: @json(old('excerpt', $blogPost->excerpt ?? '')),
            metaTitle: @json(old('meta_title', $blogPost->meta_title ?? '')),
            metaDescription: @json(old('meta_description', $blogPost->meta_description ?? '')),
            isSlugCustom: @json(old('slug', $blogPost->slug) ? true : false),
            isMetaTitleCustom: @json(old('meta_title', $blogPost->meta_title) ? true : false),
            isMetaDescriptionCustom: @json(old('meta_description', $blogPost->meta_description) ? true : false),

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
                if (!this.isMetaTitleCustom) {
                    this.metaTitle = this.title;
                }
            },

            syncSlug() {
                this.slug = this.generateSlug(this.title);
                this.isSlugCustom = false;
            },

            syncMetaTitle() {
                this.metaTitle = this.title;
                this.isMetaTitleCustom = false;
            }
        };
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (typeof Quill !== 'undefined') {
            var quill = new Quill('#quillEditor', {
                theme: 'snow',
                placeholder: 'Write the comprehensive article content...',
                modules: {
                    toolbar: [
                        [{ 'header': [2, 3, false] }],
                        ['bold', 'italic', 'underline', 'blockquote'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['link', 'clean']
                    ]
                }
            });

            var form = document.getElementById('blogForm');
            var contentInput = document.getElementById('contentInput');

            form.addEventListener('submit', function () {
                contentInput.value = quill.root.innerHTML;
            });
        }
    });
</script>
@endpush
