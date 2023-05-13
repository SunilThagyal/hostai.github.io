@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="main-content">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-lg-6 offset-lg-3 col-xl-4">
                    <div class="card card-primary">
                        @if (Session::has('message'))
                            <h5 class=" {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</h5>
                        @endif
                        <div class="card-header">
                            <h4>{{ __('Login') }}</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email">{{ __('Email Address') }}</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" tabindex="1" required
                                        autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">{{ __('Password') }}</label>
                                        <div class="float-right">
                                            <a href="{{ route('password.request') }}" class="text-small">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        </div>
                                    </div>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        tabindex="2" required autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </form>
                            {{--  --}}
                            <div style="text-align:center;">
                                <a style="text-decoration:none" href="{{ route('privacy.policy') }}" class="text-small">
                                    {{ __('Privacy policy') }}
                                </a>
                            </div>
                            {{--  --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
