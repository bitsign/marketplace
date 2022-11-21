@extends('layout.page')
@section('content')
<section id="login" class="login">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex justify-content-center py-4">
                    <a href="{{ url(app()->getLocale()) }}" class="logo d-flex align-items-center w-auto">
                        <img src="{{ asset('img/logo.png') }}" alt="{{ SHOP_NAME }}">
                    </a>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">{{ __('login') }}</h5>
                        </div>
                        @include('layout.messages')
                        @if (empty(session('wait_time')))
                        <form action="{{ route('login.login') }}" method="post" class="row g-3">
                            @csrf
                            <div class="col-12">
                                <label class="form-label">{{ __('email') }}</label>
                                <div class="input-group has-validation">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">{{ __('password') }}</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">{{ __('remember_me') }}</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">{{ __('login') }}</button>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 control">
                                    <div class="small">
                                        {{ __('if_not_registered') }}
                                        <a href="{{ route(__('routes.register')) }}" title="{{ __('register') }}">
                                            {{ __('create_account') }}
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 control">
                                    <div class="float-end small">
                                        <a href="{{ route(__('routes.forgot-password')) }}" title="{{ __('forgot-password') }}">
                                            {{ __('forgot_password') }}?
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @else
                            @php
                            $wait_time = session('wait_time');
                            session()->forget('wait_time');
                            header("Refresh:".$wait_time."; url=".url()->current());
                            @endphp
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
