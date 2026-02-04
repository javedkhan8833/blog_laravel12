@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-3">Edit Post</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.posts.update', $post) }}">
                    @csrf
                    @method('PUT')
                    @include('dashboard.posts._form', ['post' => $post, 'categories' => $categories])

                    <button class="btn btn-primary" type="submit">Save</button>
                    <a class="btn btn-outline-secondary" href="{{ route('dashboard.index') }}">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
