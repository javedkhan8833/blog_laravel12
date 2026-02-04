@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-4">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">Back to posts</a>
        </div>

        <article class="bg-white p-4 p-md-5 rounded shadow-sm">
            <h1 class="mb-2">{{ $post->title }}</h1>
            <p class="text-muted">
                {{ optional($post->published_at)->format('M d, Y') }}
                @if ($post->category)
                    &middot; {{ $post->category->name }}
                @endif
                @if($post->author)
                    &middot; {{ $post->author->name }}
                @endif
            </p>
            @if ($post->excerpt)
                <p class="lead">{{ $post->excerpt }}</p>
            @endif
            <div class="mt-4">
                {!! nl2br(e($post->body)) !!}
            </div>
        </article>
    </div>
@endsection
