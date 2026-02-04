@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-3">New Category</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.categories.store') }}">
                    @csrf
                    @include('dashboard.categories._form')

                    <button class="btn btn-primary" type="submit">Create</button>
                    <a class="btn btn-outline-secondary" href="{{ route('dashboard.categories.index') }}">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
