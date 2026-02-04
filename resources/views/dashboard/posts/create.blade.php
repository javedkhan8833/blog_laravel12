@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-3">Create Post</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.posts.store') }}">
                    @csrf
                    @include('dashboard.posts._form', ['categories' => $categories])

                    <button class="btn btn-primary" type="submit">Publish</button>
                    <a class="btn btn-outline-secondary" href="{{ route('dashboard.index') }}">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
