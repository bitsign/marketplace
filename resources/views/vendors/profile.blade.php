@extends('layout.page')
@section('content')
<section class="section profile">
    <div class="container">
    <div class="row my-3">
        @include('layout.messages')
 
        @include('vendors.sidebar')

        <div class="col-md-9">
            <div class="card border-0">
                <div class="card-body pt-3">
                   <!-- Profile Edit Form -->
                    <form action="{{ route('vendor.profile') }}" method="POST">
                    @csrf
                        <div class="row mb-2">
                            <label class="col-lg-3 text-end">{{ __('admin.name') }} <code>*</code></label>
                            <div class="col-lg-9">
                                <input name="name" type="text" value="{{ $vendor['name'] }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-lg-3 text-end">{{ __('email') }} <code>*</code></label>
                            <div class="col-lg-9">
                                <input name="email" type="text" value="{{ $vendor['email'] }}"
                                    class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-lg-3 text-end">{{ __('phone') }}</label>
                            <div class="col-lg-9">
                                <input name="phone" type="text" value="{{ $vendor['phone'] }}"
                                    class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-lg-3 text-end">{{ __('password_new') }}</label>
                            <div class="col-lg-9">
                                <input name="password" type="password" value="" class="form-control"
                                    autocomplete="off" id="password">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-lg-3 text-end">{{ __('password_confirm') }}</label>
                            <div class="col-lg-9">
                                <input name="confirm_password" type="password" value="" class="form-control"
                                    id="confirm_password" autocomplete="off">
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="offset-md-2">{{ __('admin.billing_info') }}</legend>
                        <div class="row mb-2">
                            <label class="col-lg-3 text-end">{{ __('country') }} <code>*</code></label>
                            <div class="col-lg-9">
                                <input name="country"
                                    value="{{ $vendor['country'] != '' ? $vendor['country'] : 'Magyarország' }}"
                                    type="text" id="country" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-lg-3 text-end">{{ __('state') }} <code>*</code></label>
                            <div class="col-lg-9">
                                <input name="state" value="{{ $vendor['state'] }}" type="text" id="state"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-lg-3 text-end">{{ __('zip') }}<code>*</code></label>
                            <div class="col-lg-9">
                                <input name="zip" value="{{ $vendor['zip'] }}" type="number" id="zip"
                                    class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-lg-3 text-end">{{ __('city') }} <code>*</code></label>
                            <div class="col-lg-9">
                                <input name="city" value="{{ $vendor['city'] }}" type="text" id="city"
                                    class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-lg-3 text-end">{{ __('address') }} <code>*</code></label>
                            <div class="col-lg-9" id="city_container">
                                <input name="address" value="{{ $vendor['address'] }}" type="text"
                                    id="address" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-lg-3 text-end">{{ __('vat_number') }}</label>
                            <div class="col-lg-9">
                                <input type="text" name="vat_number" class="form-control"
                                    value="{{ $vendor['vat_number'] }}">
                            </div>
                        </div>
                    </fieldset>

                        <div class="offset-md-3">
                            <button type="submit" class="btn btn-primary">{{ __('admin.save') }}</button>
                        </div>
                    </form><!-- End Profile Edit Form -->
                    <fieldset>
                        <legend>{{ __('admin.subscription') }}</legend>
                        @if(!empty($package) && !empty($subscription))
                        <ul class="list-group">
                            <li class="list-group-item d-flex align-items-center">
                                {{ __('admin.package') }}:
                                <span class="badge bg-primary rounded-pill ms-2">{{ $package['name'] }}</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                Stripe ID:
                                <span class="badge bg-primary rounded-pill ms-2">{{ $subscription['stripe_id'] }}</span>
                                </li>
                            <li class="list-group-item d-flex align-items-center">
                                Stripe price:
                                <span class="badge bg-primary rounded-pill ms-2">{{ $subscription['stripe_price'] }}</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                Stripe Status:
                                <span class="badge bg-primary rounded-pill ms-2">{{ $subscription['stripe_status'] }}</span>
                            </li>
                        </ul>
                        @else

                        @endif
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection
