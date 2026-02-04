<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\CategoryService;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostManageController extends Controller
{
    public function __construct(
        private PostService $postService,
        private CategoryService $categoryService
    ) {
    }

    public function index()
    {
        $posts = $this->postService->listForUser(auth()->id());

        return view('dashboard.index', compact('posts'));
    }

    public function create()
    {
        $categories = $this->categoryService->listForSelect();

        return view('dashboard.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validatePost($request);

        $this->postService->createForUser($data, auth()->id());

        return redirect()
            ->route('dashboard.index')
            ->with('status', 'Post created.');
    }

    public function edit(Post $post)
    {
        $this->postService->ensureOwner($post, auth()->id());

        $categories = $this->categoryService->listForSelect();

        return view('dashboard.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $this->postService->ensureOwner($post, auth()->id());

        $data = $this->validatePost($request);

        $this->postService->update($post, $data);

        return redirect()
            ->route('dashboard.index')
            ->with('status', 'Post updated.');
    }

    public function destroy(Post $post)
    {
        $this->postService->ensureOwner($post, auth()->id());
        $this->postService->delete($post);

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
}
