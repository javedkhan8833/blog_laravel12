@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <section class="hero py-5 mb-4">
        <div class="container">
            <h1 class="display-5 fw-bold">Welcome to the Blog</h1>
            <p class="lead mb-0">Short reads, big ideas. Fresh posts from our authors.</p>
        </div>
    </section>

    <div class="container">
        <div class="row g-4">
            @forelse ($posts as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                            </h5>
                            @if ($post->category)
                                <p class="mb-2">
                                    <span class="badge bg-secondary text-capitalize">{{ $post->category->name }}</span>
                                </p>
                            @endif
                            <p class="card-text text-muted mb-3">
                                {{ $post->excerpt ?? Str::limit(strip_tags($post->body), 120) }}
                            </p>
                            <small class="text-muted">
                                {{ optional($post->published_at)->format('M d, Y') }}
                            </small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">No posts yet.</div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
