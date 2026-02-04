@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="mb-3">Create an Account</h2>

                        <form method="POST" action="{{ route('register.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="name">Name</label>
                                <input class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       type="text"
                                       value="{{ old('name') }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       type="email"
                                       value="{{ old('email') }}"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="password">Password</label>
                                <input class="form-control @error('password') is-invalid @enderror"
                                       id="password"
                                       name="password"
                                       type="password"
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="password_confirmation">Confirm Password</label>
                                <input class="form-control"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       type="password"
                                       required>
                            </div>

                            <button class="btn btn-primary w-100" type="submit">Register</button>
                        </form>

                        <p class="text-center mt-3 mb-0">
                            Already have an account? <a href="{{ route('login') }}">Login</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
