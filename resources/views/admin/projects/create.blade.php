@extends('layouts.admin')

@section('title', 'Create New Project')
@section('page_title', 'Create Project')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="projectForm()">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.projects.index') }}" class="text-xs text-neutral-400 hover:text-white uppercase tracking-wider flex items-center gap-1">
            <span>&larr; Back to Projects</span>
        </a>
    </div>

    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="bg-neutral-900 border border-neutral-800 p-6 md:p-8 space-y-8" id="projectForm">
        @csrf

        <!-- Section 1: Core Information -->
        <div class="space-y-6">
            <h3 class="text-xs uppercase tracking-widest2 font-bold text-white border-b border-neutral-800 pb-3">
                1. Project Information
            </h3>

            <div>
                <label for="title" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Project Title <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       x-model="title"
                       @input="onTitleInput()"
                       required 
                       placeholder="e.g. Bontang LNG Marine Terminal Expansion" 
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
                           placeholder="bontang-lng-marine-terminal-expansion" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                    <div class="flex items-center justify-between text-[10px] text-neutral-500 mt-1">
                        <span>Terisi otomatis dari judul proyek untuk struktur tautan web.</span>
                        <button type="button" @click="syncSlug()" class="text-accent hover:underline flex items-center gap-1">
                            Sync dari Judul
                        </button>
                    </div>
                </div>

                <div>
                    <label for="service_id" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        Service Category <span class="text-red-500">*</span>
                    </label>
                    <select id="service_id" name="service_id" required class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white">
                        <option value="">Select Category</option>
                        @foreach($services as $parent)
                            <optgroup label="{{ $parent->title }}">
                                <option value="{{ $parent->id }}" {{ old('service_id') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->title }} (Main Category)
                                </option>
                                @foreach($parent->children as $child)
                                    <option value="{{ $child->id }}" {{ old('service_id') == $child->id ? 'selected' : '' }}>
                                        &nbsp;&nbsp;— {{ $child->title }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="client" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        Client / Owner
                    </label>
                    <input type="text" 
                           id="client" 
                           name="client" 
                           value="{{ old('client') }}" 
                           placeholder="e.g. PT Badak NGL / Pertamina" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                </div>

                <div>
                    <label for="location" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        Location
                    </label>
                    <input type="text" 
                           id="location" 
                           name="location" 
                           value="{{ old('location') }}" 
                           placeholder="e.g. East Kalimantan, Indonesia" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                </div>

                <div>
                    <label for="size" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        Capacity / Scale
                    </label>
                    <input type="text" 
                           id="size" 
                           name="size" 
                           value="{{ old('size') }}" 
                           placeholder="e.g. 22.5 MTPA / 4 Storage Tanks" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="year" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        Completion Year
                    </label>
                    <input type="text" 
                           id="year" 
                           name="year" 
                           value="{{ old('year', date('Y')) }}" 
                           placeholder="2026" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
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
                    <label for="status" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        Publish Status
                    </label>
                    <select id="status" name="status" class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white">
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
            </div>

            <!-- Description (Rich Text Editor) -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300">
                        Project Narrative &amp; Technical Scope
                    </label>
                    <span class="text-[10px] text-neutral-500">Teks ini juga menjadi sumber auto-generate SEO Meta Description</span>
                </div>
                <div id="quillEditor" class="bg-neutral-950 text-white min-h-[160px] border border-neutral-800">
                    {!! old('description') !!}
                </div>
                <input type="hidden" name="description" id="descriptionInput" value="{{ old('description') }}">
            </div>
        </div>

        <!-- Section 2: Media & Gallery Uploads -->
        <div class="space-y-6">
            <h3 class="text-xs uppercase tracking-widest2 font-bold text-white border-b border-neutral-800 pb-3">
                2. Visual Media &amp; Gallery
            </h3>

            <div>
                <label for="cover_image" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Main Cover Image (Banner &amp; Card Thumbnail)
                </label>
                <input type="file" 
                       id="cover_image" 
                       name="cover_image" 
                       accept="image/*"
                       class="w-full bg-neutral-950 border border-neutral-800 text-neutral-300 text-xs px-4 py-3 focus:outline-none focus:border-white file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-neutral-800 file:text-white hover:file:bg-neutral-700">
                <p class="text-[10px] text-neutral-500 mt-1">Recommended size: 1920x1080 (landscape, JPEG/PNG/WebP, max 10MB)</p>
            </div>

            <div>
                <label for="gallery_images" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Multi Gallery Photos (Upload multiple images)
                </label>
                <input type="file" 
                       id="gallery_images" 
                       name="gallery_images[]" 
                       multiple 
                       accept="image/*"
                       class="w-full bg-neutral-950 border border-neutral-800 text-neutral-300 text-xs px-4 py-3 focus:outline-none focus:border-white file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-neutral-800 file:text-white hover:file:bg-neutral-700">
                <p class="text-[10px] text-neutral-500 mt-1">Select multiple files at once. You can also add more photos later in edit mode.</p>
            </div>
        </div>

        <!-- Section 3: Visibility Flags & SEO -->
        <div class="space-y-6">
            <h3 class="text-xs uppercase tracking-widest2 font-bold text-white border-b border-neutral-800 pb-3">
                3. Display Options &amp; SEO
            </h3>

            <div class="flex flex-wrap gap-8">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="w-4 h-4 rounded-none accent-black bg-neutral-950 border-neutral-800">
                    <div>
                        <div class="text-xs font-semibold text-white">Featured Project</div>
                        <div class="text-[10px] text-neutral-400">Display this project in the Homepage Hero Slider</div>
                    </div>
                </label>

                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_recent" value="1" {{ old('is_recent', 1) ? 'checked' : '' }} class="w-4 h-4 rounded-none accent-black bg-neutral-950 border-neutral-800">
                    <div>
                        <div class="text-xs font-semibold text-white">Recent Projects Grid</div>
                        <div class="text-[10px] text-neutral-400">Display this project on the Homepage 3x3 Recent Grid</div>
                    </div>
                </label>
            </div>

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
                           placeholder="Defaults to Project Title if empty" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                    <div class="flex items-center justify-between text-[10px] text-neutral-500 mt-1">
                        <span>Otomatis sinkron dengan Judul Proyek.</span>
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
                              placeholder="Otomatis diambil dari deskripsi proyek untuk Google..." 
                              class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-2.5 focus:outline-none focus:border-white transition-colors"></textarea>
                    <div class="flex items-center justify-between text-[10px] text-neutral-500 mt-1">
                        <span>Ringkasan untuk hasil pencarian Google.</span>
                        <span :class="metaDescription.length > 160 ? 'text-amber-400 font-semibold' : 'text-neutral-500'" x-text="metaDescription.length + '/160 karakter'"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-6 border-t border-neutral-800 flex items-center justify-end gap-4">
            <a href="{{ route('admin.projects.index') }}" class="px-6 py-3 border border-neutral-700 text-neutral-300 hover:text-white text-xs uppercase tracking-wider">
                Cancel
            </a>
            <button type="submit" class="px-8 py-3 bg-white text-black hover:bg-neutral-200 text-xs uppercase tracking-widest2 font-bold transition-colors">
                Save &amp; Publish Project &rarr;
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
    function projectForm() {
        return {
            title: @json(old('title', '')),
            slug: @json(old('slug', '')),
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

            syncSlug() {
                this.slug = this.generateSlug(this.title);
                this.isSlugCustom = false;
            },

            syncMetaTitle() {
                this.metaTitle = this.title;
                this.isMetaTitleCustom = false;
            },

            updateMetaDescriptionFromText(text) {
                if (!this.isMetaDescriptionCustom) {
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
                placeholder: 'Write the project narrative, operational scope, and technical specs...',
                modules: {
                    toolbar: [
                        [{ 'header': [2, 3, false] }],
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['link', 'clean']
                    ]
                }
            });

            var form = document.getElementById('projectForm');
            var descriptionInput = document.getElementById('descriptionInput');

            quill.on('text-change', function() {
                var text = quill.getText();
                var alpineComponent = document.querySelector('[x-data]')?._x_dataStack?.[0];
                if (alpineComponent && typeof alpineComponent.updateMetaDescriptionFromText === 'function') {
                    alpineComponent.updateMetaDescriptionFromText(text);
                }
            });

            form.addEventListener('submit', function () {
                descriptionInput.value = quill.root.innerHTML;
            });
        }
    });
</script>
@endpush
