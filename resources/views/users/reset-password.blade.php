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
                            <h5 class="card-title text-center pb-0 fs-4">{{ __('new_password') }}</h5>
                        </div>
                        @include('layout.messages')
                        <form method="POST" action="{{ route('password.update') }}" class="row g-3">
                        @csrf
                            <div class="col-12">
                                <label class="form-label">{{ __('email') }}</label>
                                <div class="input-group has-validation">
                                    <input type="email" class="form-control" name="email" value="{{ old('email',request()->email) }}" required autofocus>
                                    <input type="hidden" name="token" value="{{ request()->route('token') }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">{{ __('password') }}</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">{{ __('confirm_password') }}</label>
                                <input id="password_confirmation" class="form-control"
                                    type="password"
                                    name="password_confirmation" required>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">{{ __('Reset Password') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection