@extends('layout.page')
@section('content')
<section class="section profile">
    <div class="container">
    <div class="row my-3">
        @include('layout.messages')
        <div class="col-xl-12">
            <div class="card border-0">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit" aria-selected="true" role="tab">{{ __('my_profile') }}</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-orders" aria-selected="false" tabindex="-1" role="tab">{{ __('my_orders') }}</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-wishlist" aria-selected="false" tabindex="-1" role="tab">{{ __('wishlist') }}</button>
                        </li>
                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade profile-edit pt-3 active show" id="profile-edit" role="tabpanel">
                            <!-- Profile Edit Form -->
                            <form action="{{ route(__('routes.profile')) }}" method="POST">
                            @csrf
                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end">{{ __('admin.name') }} <code>*</code></label>
                                    <div class="col-lg-9">
                                        <input name="name" type="text" value="{{ $user['name'] }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end">{{ __('email') }} <code>*</code></label>
                                    <div class="col-lg-9">
                                        <input name="email" type="text" value="{{ $user['email'] }}"
                                            class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end">{{ __('phone') }}</label>
                                    <div class="col-lg-9">
                                        <input name="phone" type="text" value="{{ $user['phone'] }}"
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
                                    <label class="col-lg-3 text-end">{{ __('admin.billing_name') }} <code>*</code></label>
                                    <div class="col-lg-9">
                                        <input name="billing_name" value="{{ $user['billing_name'] }}" type="text"
                                            id="billing_name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end">{{ __('country') }} <code>*</code></label>
                                    <div class="col-lg-9">
                                        <input name="country"
                                            value="{{ $user['country'] != '' ? $user['country'] : 'Magyarország' }}"
                                            type="text" id="country" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end">{{ __('state') }} <code>*</code></label>
                                    <div class="col-lg-9">
                                        <input name="state" value="{{ $user['state'] }}" type="text" id="state"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end">{{ __('zip') }}<code>*</code></label>
                                    <div class="col-lg-9">
                                        <input name="zip" value="{{ $user['zip'] }}" type="number" id="zip"
                                            class="form-control" required>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end">{{ __('city') }} <code>*</code></label>
                                    <div class="col-lg-9">
                                        <input name="city" value="{{ $user['city'] }}" type="text" id="city"
                                            class="form-control" required>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end">{{ __('address') }} <code>*</code></label>
                                    <div class="col-lg-9" id="city_container">
                                        <input name="address" value="{{ $user['address'] }}" type="text"
                                            id="address" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end">{{ __('vat_number') }}</label>
                                    <div class="col-lg-9">
                                        <input type="text" name="vat_number" class="form-control"
                                            value="{{ $user['vat_number'] }}">
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend class="offset-md-2">{{ __('admin.shipping_info') }}</legend>

                                <div class="row mb-2">
                                    <div class="form-check mb-2 offset-md-2">
                                        <input type="checkbox" class="form-check-input" id="same-address" {{ isset(Auth::user()->state2) ? '' : 'checked' }}>
                                        <label class="form-check-label" for="same-address">{{ __('same_as_billing_data') }}</label>
                                    </div>
                                </div>
                                <div class="same_as_billing mb-3" {!! isset(Auth::user()->state2) ? '' : 'style="display:none"' !!}>
                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end">{{ __('state') }}</label>
                                    <div class="col-lg-9">
                                        <input name="state2" value="{{ $user['state2'] }}" type="text"
                                            id="state2" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end">{{ __('zip') }}</label>
                                    <div class="col-lg-9">
                                        <input name="zip2" value="{{ $user['zip2'] }}" type="number" id="zip2"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end">{{ __('city') }}</label>
                                    <div class="col-lg-9">
                                        <input name="city2" value="{{ $user['city2'] }}" type="text"
                                            id="city2" class="form-control">
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end">{{ __('address') }}</label>
                                    <div class="col-lg-9" id="city_container">
                                        <input name="address2" value="{{ $user['address2'] }}" type="text"
                                            id="address2" class="form-control">
                                    </div>
                                </div>
                                </div>
                            </fieldset>

                                <div class="offset-md-3">
                                    <button type="submit" class="btn btn-primary">{{ __('admin.save') }}</button>
                                </div>
                            </form><!-- End Profile Edit Form -->

                        </div>

                        <div class="tab-pane fade pt-3" id="profile-orders" role="tabpanel">
                            @if(count($orders) > 0)
                            <table class="table table-striped table-bordered table-hover" id="orders_table">
                                <thead>
                                    <tr>
                                    <th>#ID</th>
                                    <th>{{ __('date') }}</th>
                                    <th>{{ __('total') }}</th>
                                    <th>{{ __('admin.shipping') }}</th>
                                    <th>{{ __('status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $o)
                                    @php $status = json_decode($o->statuses->translations,true) @endphp
                                    <tr>
                                    <td>{{ $o['id'] }}</td>
                                    <td>{{ $o['created_at'] }}</td>
                                    <td>{{ currency_format($o['total'],$o['currency']) }}</td>
                                    <td>{{ currency_format($o['shipping_cost'],$o['currency']) }}</td>
                                    <td>
                                        <span class="badge" style="background-color:{!! $o->statuses->color !!};">{{ $status[$o['lang']] }}</span>
                                    </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @else
                            {{ __('no_orders') }}
                            @endif
                        </div>

                        <div class="tab-pane fade pt-3" id="profile-wishlist" role="tabpanel">

                        </div>
                    </div><!-- End Bordered Tabs -->
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection
