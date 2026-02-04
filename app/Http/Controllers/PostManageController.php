<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostManageController extends Controller
{
    public function index()
    {
        $posts = Post::query()
            ->where('user_id', auth()->id())
            ->with('category')
            ->latest()
            ->get();

        return view('dashboard.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('dashboard.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validatePost($request);
        if (empty($data['published_at'])) {
            $data['published_at'] = now();
        }
        $data['user_id'] = auth()->id();
        $data['slug'] = $this->makeUniqueSlug($data['title']);

        Post::create($data);

        return redirect()
            ->route('dashboard.index')
            ->with('status', 'Post created.');
    }

    public function edit(Post $post)
    {
        $this->authorizeOwner($post);

        $categories = Category::orderBy('name')->get();

        return view('dashboard.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorizeOwner($post);

        $data = $this->validatePost($request);
        if (empty($data['published_at'])) {
            $data['published_at'] = now();
        }
        $data['slug'] = $this->makeUniqueSlug($data['title'], $post->id);

        $post->update($data);

        return redirect()
            ->route('dashboard.index')
            ->with('status', 'Post updated.');
    }

    public function destroy(Post $post)
    {
        $this->authorizeOwner($post);
        $post->delete();

        return redirect()
            ->route('dashboard.index')
            ->with('status', 'Post deleted.');
    }

    private function validatePost(Request $request): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'published_at' => ['nullable', 'date'],
        ]);
    }

    private function makeUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 2;

        while (
            Post::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function authorizeOwner(Post $post): void
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
