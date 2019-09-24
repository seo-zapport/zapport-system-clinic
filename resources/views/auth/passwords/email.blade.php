@extends('layouts.app')
@section('title', '| Reset User\'s Password')
@section('reset_pwd', 'active')
{{-- @section('dash-title', 'Reset User\'s Password') --}}
@section('dash-content')
@if (Gate::check('isAdmin'))
<div class="container">
    <div class="row justify-content-center">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="col-12 col-md-8">
            <div class="signin-container">
                <div class="sigin-info">
                    <div class="slogan">
                        Curabitur, Tempus, Lectus
                    </div>
                    <ul>
                        <li>Convallis quis ac lectus</li>
                        <li>Consectetur adipiscing elit</li>
                        <li>Vivamus magna justo</li>
                        <li>Curabitur non nulla sit amet</li>
                    </ul>
                </div>
                <div class="signin-form">

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="signin-text">
                            <span>Reset Password</span>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
