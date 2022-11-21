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
                            <h5 class="card-title text-center pb-0 fs-4">{{ __('forgot_password') }}</h5>
                        </div>
                        @include('layout.messages')
                        <form action="{{ route('forgot-password') }}" method="post" class="row g-3">
                            @csrf
                            <div class="col-12">
                                <label class="form-label">{{ __('email') }}</label>
                                <div class="input-group has-validation">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">{{ __('new_password_button') }}</button>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 control"></div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 control">
                                    <div class="float-end small">
                                        <a href="{{ route(__('routes.login')) }}" title="{{ __('login') }}">
                                            <i class="bi bi-box-arrow-in-right"></i> {{ __('login') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
