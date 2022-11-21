@extends('layout.page')
@section('content')
<section id="register" class="register">
   <div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center justify-content-center">
            <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                    <img src="assets/img/logo.png" alt="">
                </a>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="pt-4 pb-2">
                        <h5 class="card-title text-center pb-0 fs-4">{{ __('register') }}</h5>
                    </div>
                    @include('layout.messages')
                    <form action="{{ route('register.save') }}" method="post" class="row g-3">
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
                    <div class="col-12">
                        <p class="small mb-0">{{ __('Already registered?') }} <a href="{{ route(__('routes.login')) }}">{{ __('login') }}</a></p>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
   </div>
</section>
@endsection
