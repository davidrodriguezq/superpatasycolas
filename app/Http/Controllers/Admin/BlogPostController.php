<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogPostRequest;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('author')
            ->latest()
            ->paginate(15);

        return view('admin.blog-posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog-posts.create');
    }

    public function store(StoreBlogPostRequest $request)
    {
        $slug      = $this->generateUniqueSlug($request->title);
        $imagePath = null;

        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('blog', 'public');
        }

        BlogPost::create([
            'user_id'        => Auth::id(),
            'title'          => $request->title,
            'slug'           => $slug,
            'content'        => $request->content,
            'featured_image' => $imagePath,
            'is_published'   => $request->boolean('is_published'),
        ]);

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Artículo creado correctamente.');
    }

    public function edit(BlogPost $blogPost)
    {
        return view('admin.blog-posts.edit', compact('blogPost'));
    }

    public function update(StoreBlogPostRequest $request, BlogPost $blogPost)
    {
        $imagePath = $blogPost->featured_image;

        if ($request->hasFile('featured_image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('featured_image')->store('blog', 'public');
        }

        $slug = $blogPost->slug;
        if ($request->title !== $blogPost->title) {
            $slug = $this->generateUniqueSlug($request->title, $blogPost->id);
        }

        $blogPost->update([
            'title'          => $request->title,
            'slug'           => $slug,
            'content'        => $request->content,
            'featured_image' => $imagePath,
            'is_published'   => $request->boolean('is_published'),
        ]);

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Artículo actualizado correctamente.');
    }

    public function destroy(BlogPost $blogPost)
    {
        if ($blogPost->featured_image) {
            Storage::disk('public')->delete($blogPost->featured_image);
        }

        $blogPost->delete();

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Artículo eliminado correctamente.');
    }

    private function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $slug     = Str::slug($title);
        $original = $slug;
        $i        = 1;

        while (
            BlogPost::where('slug', $slug)
                ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = $original . '-' . $i;
            $i++;
        }

        return $slug;
    }
}
