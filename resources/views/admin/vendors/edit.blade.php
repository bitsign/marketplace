@extends('admin.layout.app')
@section('content')
@include ('admin/layout/page-header', ['page_title' => $page_title])
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header">{{ $page_title }}</div>
            <div class="card-body">
                <div class="row no-gutters">
                    <div class="col-lg-6">
                    <form method="post" action="{{ route('vendors.update', $vendor) }}" class="form-horizontal" role="form"
                        id="vendor_form">
                        @method('PUT')
                        @csrf
                        <fieldset>
                            @include('layout/messages')
                            <legend>{{ __('admin.account_informations') }}</legend>
                            <div class="mb-2 row">
                                <label class="col-lg-3 text-lg-end">{{ __('admin.language') }} <code>*</code></label>
                                <div class="col-lg-9">
                                    <select name="lang" class="form-select" required>
                                        @foreach (config('app.available_locales') as $key => $lang)
                                        <option value="{{ $lang }}"  @selected($vendor['lang'] == $lang)>
                                            {{ $key }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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
                            <!--div class="row mb-2">
                                <label class="col-lg-3 text-end">{{ __('admin.group') }}</label>
                                <div class="col-lg-9">
                                    {{-- custom_select('vendors_groups','group_id','id','title',$vendor['group_id']) --}}
                                </div>
                            </div-->
                            <div class="mb-3 row">
                                <label class="col-lg-3 text-lg-end">{{ __('admin.active') }}?</label>
                                <div class="col-lg-9">
                                    <input type="checkbox" data-onstyle="success" data-offstyle="danger"
                                        data-size="mini" data-on="{{ __('yes') }}" data-off="{{ __('no') }}"
                                        data-toggle="toggle" name="active" value="1"
                                        {{ !empty($vendor['active']) ? 'checked' : '' }} />
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-lg-3 text-end">Stripe ID</label>
                                <div class="col-lg-9">
                                    <input name="stripe_id" type="text" value="{{ $vendor['stripe_id'] }}" class="form-control">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>{{ __('admin.billing_info') }}</legend>
                            <div class="row mb-2">
                                <label class="col-lg-3 text-end">{{ __('admin.billing_name') }} <code>*</code></label>
                                <div class="col-lg-9">
                                    <input name="company_name" value="{{ $vendor['company_name'] }}" type="text"
                                        id="company_name" class="form-control" required>
                                </div>
                            </div>
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
                        
                        <fieldset>
                            <legend>Admin {{ __('note') }}</legend>
                            <div class="row mb-2 ">
                                <label class="col-lg-3 text-end">{{ __('note') }}</label>
                                <div class="col-lg-9">
                                    <input name="admin_note" value="{{ $vendor['admin_note'] }}" type="text"
                                        id="admin_note" class="form-control">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-lg-3 text-end"></label>
                                <div class="col-lg-9">
                                    <button type="submit" class="btn btn-primary">{{ __('admin.save') }}</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                    </div>
                    <div class="col-lg-6">
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

                            {{-- <div class="row mb-2">
                                <div class="col-lg-9">
                                    <button type="submit" class="btn btn-primary">{{ __('admin.save') }}</button>
                                </div>
                            </div> --}}
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
