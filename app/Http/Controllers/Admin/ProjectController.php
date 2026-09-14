<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectRequest;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects.
     */
    public function index(Request $request): View
    {
        $query = Project::with('service');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('client', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($serviceId = $request->get('service_id')) {
            $query->where('service_id', $serviceId);
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $projects = $query->orderBy('order')->latest()->paginate(10)->withQueryString();
        $services = Service::ordered()->get();

        return view('admin.projects.index', compact('projects', 'services'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create(): View
    {
        $services = Service::parents()->with(['children' => function ($q) {
            $q->ordered();
        }])->ordered()->get();

        return view('admin.projects.create', compact('services'));
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(ProjectRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Generate unique slug if not manually specified
        $slug = !empty($data['slug']) ? Str::slug($data['slug']) : Str::slug($data['title']);
        $originalSlug = $slug;
        $counter = 1;
        while (Project::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }
        $data['slug'] = $slug;

        // Auto-generate SEO Meta Title & Description if empty
        if (empty($data['meta_title'])) {
            $data['meta_title'] = $data['title'];
        }
        if (empty($data['meta_description'])) {
            $rawDesc = !empty($data['description']) ? strip_tags($data['description']) : '';
            $data['meta_description'] = Str::limit(trim(preg_replace('/\s+/', ' ', $rawDesc)), 155, '');
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('projects', 'public');
        }

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_recent'] = $request->boolean('is_recent');
        $data['order'] = $request->input('order', 0) ?? 0;

        $project = Project::create($data);

        // Handle multiple gallery images
        if ($request->hasFile('gallery_images')) {
            $order = 1;
            foreach ($request->file('gallery_images') as $file) {
                $path = $file->store('projects/gallery', 'public');
                ProjectImage::create([
                    'project_id' => $project->id,
                    'image_path' => $path,
                    'order' => $order++,
                ]);
            }
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully!');
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project): View
    {
        $project->load('images');
        $services = Service::parents()->with(['children' => function ($q) {
            $q->ordered();
        }])->ordered()->get();

        return view('admin.projects.edit', compact('project', 'services'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        $data = $request->validated();

        // Handle slug
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
            $rawDesc = !empty($data['description']) ? strip_tags($data['description']) : '';
            $data['meta_description'] = Str::limit(trim(preg_replace('/\s+/', ' ', $rawDesc)), 155, '');
        }

        // Handle cover image replacement
        if ($request->hasFile('cover_image')) {
            if ($project->cover_image && !str_starts_with($project->cover_image, 'http') && Storage::disk('public')->exists($project->cover_image)) {
                Storage::disk('public')->delete($project->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('projects', 'public');
        }

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_recent'] = $request->boolean('is_recent');
        $data['order'] = $request->input('order', 0) ?? 0;

        $project->update($data);

        // Handle additional gallery images upload
        if ($request->hasFile('gallery_images')) {
            $maxOrder = $project->images()->max('order') ?? 0;
            foreach ($request->file('gallery_images') as $file) {
                $maxOrder++;
                $path = $file->store('projects/gallery', 'public');
                ProjectImage::create([
                    'project_id' => $project->id,
                    'image_path' => $path,
                    'order' => $maxOrder,
                ]);
            }
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully!');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project): RedirectResponse
    {
        // Delete cover image
        if ($project->cover_image && !str_starts_with($project->cover_image, 'http') && Storage::disk('public')->exists($project->cover_image)) {
            Storage::disk('public')->delete($project->cover_image);
        }

        // Delete gallery images
        foreach ($project->images as $img) {
            if ($img->image_path && !str_starts_with($img->image_path, 'http') && Storage::disk('public')->exists($img->image_path)) {
                Storage::disk('public')->delete($img->image_path);
            }
        }

        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully!');
    }
}
