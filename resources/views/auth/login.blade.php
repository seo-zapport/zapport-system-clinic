@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="login-container">
                <div class="login-header">
                    <div class="login-logo text-center">
                        <img src="{{ asset('images/logo.png') }}" alt="">
                    </div>
                    {{--  <div class="slogan">
                        Curabitur, Tempus, Lectus
                    </div>  --}}
                </div>
                <div class="login-form">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="login-text">
                            <span>{{ __('Sign In') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row mb-0">
                            <button type="submit" class="btn btn-primary btn-block zp-rounded">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
{{--                                     <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a> --}}
                            @endif
                        </div>
                    </form>
                    @if (session('message'))
                        <div class="alert alert-danger alert-posts mt-3 mb-3">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
