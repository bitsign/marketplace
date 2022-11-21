@extends('layout.page')
@section('content')
<section id="login" class="login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card my-3">
                    <div class="card-body">
                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">{{ __('vendor_login') }}</h5>
                        </div>
                        @include('layout.messages')
                        <form action="{{ route('vendor.login') }}" method="post" class="row g-3">
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
                                    <div class="small"></div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 control">
                                    <div class="float-end small">
                                        <a href="{{ route('vendor.forgot-password') }}" title="{{ __('forgot-password') }}">
                                            {{ __('forgot_password') }}?
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card my-3">
                    <div class="card-body">
                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">{{ __('vendor_register') }}</h5>
                        </div>
                        @include('layout.messages')
                        <form action="{{ route('vendor.register') }}" method="post" class="row g-3">
                        @csrf
                        <div class="col-12">
                            <label for="yourName" class="form-label">{{ __('name') }}</label>
                            <input type="text" name="name" class="form-control" id="yourName" value="{{ old('name') }}" required>
                        </div>

                        <div class="col-12">
                            <label for="yourEmail" class="form-label">{{ __('email') }}</label>
                            <input type="email" name="email" class="form-control" id="yourEmail" value="{{ old('email') }}" required>
                        </div>

                        <div class="col-12">
                            <label for="yourPassword" class="form-label">{{ __('password') }}</label>
                            <input type="password" name="password" class="form-control" id="yourPassword" required="">
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required="">
                                <label class="form-check-label" for="acceptTerms">
                                {!!
                                    __('I agree to the :terms_of_service and :privacy_policy',
                                        [
                                            'terms_of_service' => '<a href="'.url(app()->getLocale().'/'.__('routes.page').'/'.__('routes.terms')).'">'.__('terms_of_service').'</a>',
                                            'privacy_policy'   => '<a href="'.url(app()->getLocale().'/'.__('routes.page').'/'.__('routes.privacy_policy')).'">'.__('privacy_policy').'</a>'
                                        ]
                                    ) 
                                !!}
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit">{{ __('i_register') }}</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
