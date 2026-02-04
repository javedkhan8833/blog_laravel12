<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::query()
            ->whereNotNull('published_at')
            ->with(['author', 'category'])
            ->latest('published_at')
            ->paginate(6);

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $post->loadMissing(['author', 'category']);

        return view('posts.show', compact('post'));
    }
}
