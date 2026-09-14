@extends('layouts.admin')

@section('title', 'Write New Blog Article')
@section('page_title', 'Write Blog Article')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="blogPostForm()">
    
    <div>
        <a href="{{ route('admin.blog-posts.index') }}" class="text-xs text-neutral-400 hover:text-white uppercase tracking-wider flex items-center gap-1">
            <span>&larr; Back to Articles</span>
        </a>
    </div>

    <form action="{{ route('admin.blog-posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-neutral-900 border border-neutral-800 p-6 md:p-8 space-y-6" id="blogForm">
        @csrf

        <div>
            <label for="title" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Article Title <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   x-model="title"
                   @input="onTitleInput()"
                   value="{{ old('title') }}" 
                   required 
                   placeholder="e.g. Advancing LNG Bunkering Infrastructure Across the Indonesian Archipelago" 
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
                        <span x-show="isSlugCustom">✍️ Manual Override</span>
                    </span>
                </div>
                <input type="text" 
                       id="slug" 
                       name="slug" 
                       x-model="slug"
                       @input="isSlugCustom = (slug.trim() !== '')"
                       placeholder="advancing-lng-bunkering-infrastructure" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                <div class="flex items-center justify-between text-[10px] text-neutral-500 mt-1">
                    <span>Terisi otomatis dari judul artikel untuk tautan ramah SEO.</span>
                    <button type="button" @click="syncSlug()" class="text-accent hover:underline flex items-center gap-1">
                        Sync dari Judul
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
                        <option value="{{ $cat->id }}" {{ old('blog_category_id') == $cat->id ? 'selected' : '' }}>
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
                       value="{{ old('author', 'Nusantara Energy Insights') }}" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
            </div>

            <div>
                <label for="published_at" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Publication Date
                </label>
                <input type="date" 
                       id="published_at" 
                       name="published_at" 
                       value="{{ old('published_at', date('Y-m-d')) }}" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="excerpt" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300">
                    Article Summary / Excerpt Quote
                </label>
                <span class="text-[10px] text-neutral-500">Kutipan singkat untuk kartu artikel &amp; referensi deskripsi SEO</span>
            </div>
            <textarea id="excerpt" 
                      name="excerpt" 
                      x-model="excerpt"
                      @input="onExcerptInput()"
                      rows="2" 
                      placeholder="Ringkasan singkat topik artikel..." 
                      class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-2.5 focus:outline-none focus:border-white transition-colors">{{ old('excerpt') }}</textarea>
        </div>

        <div>
            <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Full Article Content <span class="text-red-500">*</span>
            </label>
            <div id="quillEditor" class="bg-neutral-950 text-white min-h-[220px] border border-neutral-800">
                {!! old('content') !!}
            </div>
            <input type="hidden" name="content" id="contentInput" value="{{ old('content') }}">
        </div>

        <div>
            <label for="cover_image" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Main Cover Image
            </label>
            <input type="file" 
                   id="cover_image" 
                   name="cover_image" 
                   accept="image/*"
                   class="w-full bg-neutral-950 border border-neutral-800 text-neutral-300 text-xs px-4 py-3 focus:outline-none focus:border-white file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-neutral-800 file:text-white hover:file:bg-neutral-700">
        </div>

        <div>
            <label class="flex items-center gap-2 cursor-pointer pt-2">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', 1) ? 'checked' : '' }} class="w-4 h-4 rounded-none accent-black bg-neutral-950 border-neutral-800">
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
                        <span x-show="isMetaTitleCustom">✍️ Manual Override</span>
                    </span>
                </div>
                <input type="text" 
                       id="meta_title" 
                       name="meta_title" 
                       x-model="metaTitle"
                       @input="isMetaTitleCustom = (metaTitle.trim() !== '')"
                       placeholder="Defaults to Article Title if empty" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                <div class="flex items-center justify-between text-[10px] text-neutral-500 mt-1">
                    <span>Otomatis sinkron dengan Judul Artikel.</span>
                    <button type="button" @click="syncMetaTitle()" class="text-accent hover:underline flex items-center gap-1">
                        Sync dari Judul
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
                        <span x-show="isMetaDescriptionCustom">✍️ Manual Override</span>
                    </span>
                </div>
                <textarea id="meta_description" 
                          name="meta_description" 
                          x-model="metaDescription"
                          @input="isMetaDescriptionCustom = (metaDescription.trim() !== '')"
                          rows="2" 
                          placeholder="Otomatis diambil dari excerpt / konten artikel..." 
                          class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-2.5 focus:outline-none focus:border-white transition-colors"></textarea>
                <div class="flex items-center justify-between text-[10px] text-neutral-500 mt-1">
                    <span>Deskripsi untuk mesin pencari Google (150-160 karakter).</span>
                    <span :class="metaDescription.length > 160 ? 'text-amber-400 font-semibold' : 'text-neutral-500'" x-text="metaDescription.length + '/160 karakter'"></span>
                </div>
            </div>
        </div>

        <div class="pt-6 border-t border-neutral-800 flex items-center justify-end gap-4">
            <a href="{{ route('admin.blog-posts.index') }}" class="px-6 py-3 border border-neutral-700 text-neutral-300 hover:text-white text-xs uppercase tracking-wider">
                Cancel
            </a>
            <button type="submit" class="px-8 py-3 bg-white text-black hover:bg-neutral-200 text-xs uppercase tracking-widest2 font-bold transition-colors">
                Save &amp; Publish Article &rarr;
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
    function blogPostForm() {
        return {
            title: @json(old('title', '')),
            slug: @json(old('slug', '')),
            excerpt: @json(old('excerpt', '')),
            metaTitle: @json(old('meta_title', '')),
            metaDescription: @json(old('meta_description', '')),
            isSlugCustom: @json(old('slug') ? true : false),
            isMetaTitleCustom: @json(old('meta_title') ? true : false),
            isMetaDescriptionCustom: @json(old('meta_description') ? true : false),

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

            onExcerptInput() {
                if (!this.isMetaDescriptionCustom && this.excerpt) {
                    let clean = this.excerpt.replace(/<[^>]*>/g, '').replace(/\s+/g, ' ').trim();
                    this.metaDescription = clean.substring(0, 155);
                }
            },

            syncSlug() {
                this.slug = this.generateSlug(this.title);
                this.isSlugCustom = false;
            },

            syncMetaTitle() {
                this.metaTitle = this.title;
                this.isMetaTitleCustom = false;
            },

            updateMetaDescriptionFromQuill(text) {
                if (!this.isMetaDescriptionCustom && (!this.excerpt || this.excerpt.trim() === '')) {
                    let clean = (text || '').replace(/<[^>]*>/g, '').replace(/\s+/g, ' ').trim();
                    this.metaDescription = clean.substring(0, 155);
                }
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

            quill.on('text-change', function() {
                var text = quill.getText();
                var alpineComponent = document.querySelector('[x-data]')?._x_dataStack?.[0];
                if (alpineComponent && typeof alpineComponent.updateMetaDescriptionFromQuill === 'function') {
                    alpineComponent.updateMetaDescriptionFromQuill(text);
                }
            });

            form.addEventListener('submit', function () {
                contentInput.value = quill.root.innerHTML;
            });
        }
    });
</script>
@endpush
