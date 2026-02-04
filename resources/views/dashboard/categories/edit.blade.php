@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-3">Edit Category</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.categories.update', $category) }}">
                    @csrf
                    @method('PUT')
                    @include('dashboard.categories._form', ['category' => $category])

                    <button class="btn btn-primary" type="submit">Save</button>
                    <a class="btn btn-outline-secondary" href="{{ route('dashboard.categories.index') }}">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
