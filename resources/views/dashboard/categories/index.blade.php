@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Categories</h2>
            <div>
                <a class="btn btn-outline-secondary me-2" href="{{ route('dashboard.index') }}">Back to posts</a>
                <a class="btn btn-primary" href="{{ route('dashboard.categories.create') }}">New Category</a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                @if ($categories->isEmpty())
                    <p class="text-muted mb-0">No categories yet. Create one to assign posts.</p>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Posts</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->slug }}</td>
                                        <td>{{ $category->posts_count }}</td>
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-outline-primary" href="{{ route('dashboard.categories.edit', $category) }}">Edit</a>
                                            <form class="d-inline" method="POST" action="{{ route('dashboard.categories.destroy', $category) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Delete this category?')">Delete</button>
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
