@extends('layouts.auth')
@section('title', 'Login')
@section('content')
    <div class="card-header"><h4>{{ __('Login') }}</h4></div>
    <div class="card-body">
        <div class="success"></div>
        <div class="error"></div>

        <form method="POST" class="loginform" class="needs-validation" action="{{ route('postLogin') }}">
            @csrf
            <div class="form-group">
                <label for="email">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" class="form-control three-space-validation @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus >
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
            <div class="d-block">
                <label for="password" class="control-label">{{ __('Password') }}</label>
                @if (Route::has('password.request'))
                    <div class="float-right">
                        <a href="{{ route('password.request') }}" class="text-small">
                            {{ __(' Forgot Password?') }}
                        </a>
                    </div>
                @endif
            </div>
            <input id="password" type="password" class="form-control  @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me" {{ old('remember') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="remember-me">{{ __('Remember Me') }}</label>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block basicbtn" tabindex="4">
                    {{ __('Login') }}
                </button>
            </div>
        </form>
        <div class="simple-footer">
            {{ __('Copyright') }} &copy; {{ env('APP_NAME') }} {{ date('Y') }}
        </div>

    </div>
@endsection
@section('end_body')
    <script src="{{ asset('assets/js/input-validation.js') }}"></script>
@endsection