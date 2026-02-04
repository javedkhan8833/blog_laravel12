@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="mb-3">Welcome Back</h2>

                        <form method="POST" action="{{ route('login.store') }}">
                            @csrf

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

                            <div class="form-check mb-3">
                                <input class="form-check-input" id="remember" name="remember" type="checkbox" value="1" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>

                            <button class="btn btn-primary w-100" type="submit">Login</button>
                        </form>

                        <p class="text-center mt-3 mb-0">
                            New here? <a href="{{ route('register') }}">Create an account</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
