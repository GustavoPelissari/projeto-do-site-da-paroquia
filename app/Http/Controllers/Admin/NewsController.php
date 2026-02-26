<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with('user');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by featured
        if ($request->filled('featured')) {
            $query->where('featured', $request->featured);
        }

        // Search in title and content
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                    ->orWhere('content', 'like', '%'.$request->search.'%');
            });
        }

        $news = $query->latest()->paginate(10);

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'summary' => 'nullable|string',
            'featured' => 'boolean',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'slug' => 'nullable|string|unique:news,slug',
            'meta_description' => 'nullable|string|max:160',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle the action button
        if ($request->has('action')) {
            $validated['status'] = $request->action === 'publish' ? 'published' : 'draft';
        }

        // Set published_at if publishing
        if ($validated['status'] === 'published' && ! $validated['published_at']) {
            $validated['published_at'] = now();
        }

        $validated['user_id'] = request()->user()->id;
        $validated['featured'] = $request->has('featured');

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        $news = News::create($validated);

        $message = $validated['status'] === 'published' ? 'Notícia publicada com sucesso!' : 'Notícia salva como rascunho!';

        return redirect()->route('admin.news.index')
            ->with('success', $message);
    }

    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'summary' => 'nullable|string',
            'featured' => 'boolean',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'slug' => 'nullable|string|unique:news,slug,'.$news->id,
            'meta_description' => 'nullable|string|max:160',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_image' => 'boolean',
        ]);

        // Handle the action button
        if ($request->has('action')) {
            $validated['status'] = $request->action === 'publish' ? 'published' : 'draft';
        }

        // Set published_at if publishing for the first time
        if ($validated['status'] === 'published' && ! $news->published_at && ! $validated['published_at']) {
            $validated['published_at'] = now();
        }

        $validated['featured'] = $request->has('featured');

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle image removal
        if ($request->has('remove_image') && $news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
            $validated['featured_image'] = null;
        }

        // Handle new featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        $news->update($validated);

        $message = $validated['status'] === 'published' ? 'Notícia atualizada e publicada!' : 'Notícia atualizada!';

        return redirect()->route('admin.news.edit', $news)
            ->with('success', $message);
    }

    public function destroy(News $news)
    {
        // Delete featured image if exists
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Notícia excluída com sucesso!');
    }
}
