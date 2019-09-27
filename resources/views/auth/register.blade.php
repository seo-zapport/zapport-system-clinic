@extends('layouts.app')
@section('title', '| Register User')
@section('register', 'active')
{{-- @section('dash-title', 'Register New Usersdfsdf') --}}
@section('heading-title')
    <i class="fas fa-user-edit"></i> Register User
@endsection
@section('dash-content')
<div class="container">
    <div class="row justify-content-center">
        <div class="signin-container">
            {{-- <div class="sigin-info">
                <div class="slogan">
                    Curabitur, Tempus, Lectus
                </div>
                <ul>
                    <li>Convallis quis ac lectus</li>
                    <li>Consectetur adipiscing elit</li>
                    <li>Vivamus magna justo</li>
                    <li>Curabitur non nulla sit amet</li>
                </ul>
            </div> --}}
            <div class="signin-form">
                <div class="zp-bg-clan p-1"></div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="signin-text">
                        <span>Register new user</span>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-form-label text-md-right">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
