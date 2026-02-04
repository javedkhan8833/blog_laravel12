@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Your Posts</h2>
            <div>
                <a class="btn btn-outline-secondary me-2" href="{{ route('dashboard.categories.index') }}">Categories</a>
                <a class="btn btn-primary" href="{{ route('dashboard.posts.create') }}">New Post</a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                @if ($posts->isEmpty())
                    <p class="text-muted mb-0">You haven't written any posts yet.</p>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Published</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $post)
                                    <tr>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->category->name ?? '—' }}</td>
                                        <td>{{ optional($post->published_at)->format('M d, Y H:i') ?? 'Draft' }}</td>
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('posts.show', $post) }}">View</a>
                                            <a class="btn btn-sm btn-outline-primary" href="{{ route('dashboard.posts.edit', $post) }}">Edit</a>
                                            <form class="d-inline" method="POST" action="{{ route('dashboard.posts.destroy', $post) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Delete this post?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
