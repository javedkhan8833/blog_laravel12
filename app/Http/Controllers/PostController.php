<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;

class PostController extends Controller
{
    public function __construct(private PostService $postService)
    {
    }

    public function index()
    {
        $posts = $this->postService->listPublishedPaginated(6);

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $post = $this->postService->loadForShow($post);

        return view('posts.show', compact('post'));
    }
}
