<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogPostRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogPostController extends Controller
{
    public function index(Request $request): View
    {
        $query = BlogPost::with('category');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        if ($catId = $request->get('category_id')) {
            $query->where('blog_category_id', $catId);
        }

        $posts = $query->latest('published_at')->paginate(10)->withQueryString();
        $categories = BlogCategory::all();

        return view('admin.blog-posts.index', compact('posts', 'categories'));
    }

    public function create(): View
    {
        $categories = BlogCategory::all();

        return view('admin.blog-posts.create', compact('categories'));
    }

    public function store(BlogPostRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $slug = !empty($data['slug']) ? Str::slug($data['slug']) : Str::slug($data['title']);
        $originalSlug = $slug;
        $counter = 1;
        while (BlogPost::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }
        $data['slug'] = $slug;

        // Auto-generate SEO Meta Title & Description if empty
        if (empty($data['meta_title'])) {
            $data['meta_title'] = $data['title'];
        }
        if (empty($data['meta_description'])) {
            $source = !empty($data['excerpt']) ? $data['excerpt'] : (!empty($data['content']) ? strip_tags($data['content']) : '');
            $data['meta_description'] = Str::limit(trim(preg_replace('/\s+/', ' ', $source)), 155, '');
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('blog', 'public');
        }

        $data['is_published'] = $request->boolean('is_published', true);
        $data['published_at'] = $data['published_at'] ?? now();

        BlogPost::create($data);

        return redirect()->route('admin.blog-posts.index')->with('success', 'Article created successfully!');
    }

    public function edit(BlogPost $blogPost): View
    {
        $categories = BlogCategory::all();

        return view('admin.blog-posts.edit', compact('blogPost', 'categories'));
    }

    public function update(BlogPostRequest $request, BlogPost $blogPost): RedirectResponse
    {
        $data = $request->validated();

        if (!empty($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        } else {
            $data['slug'] = Str::slug($data['title']);
        }

        // Auto-generate SEO Meta Title & Description if empty
        if (empty($data['meta_title'])) {
            $data['meta_title'] = $data['title'];
        }
        if (empty($data['meta_description'])) {
            $source = !empty($data['excerpt']) ? $data['excerpt'] : (!empty($data['content']) ? strip_tags($data['content']) : '');
            $data['meta_description'] = Str::limit(trim(preg_replace('/\s+/', ' ', $source)), 155, '');
        }

        if ($request->hasFile('cover_image')) {
            if ($blogPost->cover_image && !str_starts_with($blogPost->cover_image, 'http') && Storage::disk('public')->exists($blogPost->cover_image)) {
                Storage::disk('public')->delete($blogPost->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('blog', 'public');
        }

        $data['is_published'] = $request->boolean('is_published', true);

        $blogPost->update($data);

        return redirect()->route('admin.blog-posts.index')->with('success', 'Article updated successfully!');
    }

    public function destroy(BlogPost $blogPost): RedirectResponse
    {
        if ($blogPost->cover_image && !str_starts_with($blogPost->cover_image, 'http') && Storage::disk('public')->exists($blogPost->cover_image)) {
            Storage::disk('public')->delete($blogPost->cover_image);
        }

        $blogPost->delete();

        return redirect()->route('admin.blog-posts.index')->with('success', 'Article deleted successfully!');
    }
}
