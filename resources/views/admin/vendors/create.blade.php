@extends('admin.layout.app')
@section('content')
@include ('admin/layout/page-header', ['page_title' => $page_title])
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header">{{ $page_title }}</div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <form method="post" action="{{ route('vendors.store') }}" class="form-horizontal" role="form"
                        id="add_vendor_form">
                        @csrf
                        <fieldset>
                            @include('layout/messages')
                            <legend>{{ __('admin.account_informations') }}</legend>
                            <div class="mb-2 row">
                                <label class="col-lg-3 text-lg-end">{{ __('admin.language') }} <code>*</code></label>
                                <div class="col-lg-9">
                                    <select name="lang" class="form-select" required>
                                        @foreach (config('app.available_locales') as $key => $lang)
                                        <option value="{{ $lang }}")>
                                            {{ $key }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-lg-3 text-end">{{ __('admin.name') }} <code>*</code></label>
                                <div class="col-lg-9">
                                    <input name="name" type="text" value="{{ old('name') }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-lg-3 text-end">{{ __('email') }} <code>*</code></label>
                                <div class="col-lg-9">
                                    <input name="email" type="text" value="{{ old('email') }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-lg-3 text-end">{{ __('phone') }}</label>
                                <div class="col-lg-9">
                                    <input name="phone" type="text" value="{{ old('phone') }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-lg-3 text-end">{{ __('password') }} <code>*</code></label>
                                <div class="col-lg-9">
                                    <input name="password" type="password" value="" class="form-control"
                                        autocomplete="off" id="password">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-lg-3 text-end">{{ __('password_confirm') }} <code>*</code></label>
                                <div class="col-lg-9">
                                    <input name="confirm_password" type="password" value="" class="form-control"
                                        id="confirm_password" autocomplete="off">
                                </div>
                            </div>
                            <!--div class="row mb-2">
                                <label class="col-lg-3 text-end">{{ __('admin.group') }}</label>
                                <div class="col-lg-9">
                                    {{-- custom_select('vendors_groups','group_id','id','title',old('group_id')) --}}
                                </div>
                            </div-->
                            <div class="mb-3 row">
                                <label class="col-lg-3 text-lg-end">{{ __('admin.active') }}?</label>
                                <div class="col-lg-9">
                                    <input type="checkbox" data-onstyle="success" data-offstyle="danger"
                                        data-size="mini" data-on="Igen" data-off="Nem" data-toggle="toggle"
                                        name="active" value="1" checked />
                                </div>
                            </div>
                            <!--div class="row mb-2">
                                <label class="col-lg-3 text-end">{{ __('admin.discount') }}</label>
                                <div class="col-lg-9">
                                    <input name="discount" type="text" value="{{ old('discount') }}" class="form-control">
                                </div>
                            </div-->
                        </fieldset>
                        <fieldset>
                            <legend>{{ __('admin.billing_info') }}</legend>
                            <div class="row mb-2">
                                <label class="col-lg-3 text-end">{{ __('admin.billing_name') }} <code>*</code></label>
                                <div class="col-lg-9">
                                    <input name="company_name" value="{{ old('company_name') }}" type="text"
                                        id="company_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-lg-3 text-end">{{ __('country') }} <code>*</code></label>
                                <div class="col-lg-9">
                                    <input name="country" value="{{ SHOP_COUNTRY }}" type="text" id="country"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-lg-3 text-end">{{ __('state') }} <code>*</code></label>
                                <div class="col-lg-9">
                                    <input name="state" value="{{ old('state') }}" type="text" id="state"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-lg-3 text-end">{{ __('zip') }}<code>*</code></label>
                                <div class="col-lg-9">
                                    <input name="zip" value="{{ old('zip') }}" type="number" id="zip"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-lg-3 text-end">{{ __('city') }} <code>*</code></label>
                                <div class="col-lg-9">
                                    <input name="city" value="{{ old('city') }}" type="text" id="city"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-lg-3 text-end">{{ __('address') }} <code>*</code></label>
                                <div class="col-lg-9" id="city_container">
                                    <input name="address" value="{{ old('address') }}" type="text"
                                        id="address" class="form-control" required>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-lg-3 text-end">{{ __('vat_number') }}</label>
                                <div class="col-lg-9">
                                    <input type="text" name="vat_number" class="form-control"
                                        value="{{ old('vat_number') }}">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Admin {{ __('note') }}</legend>
                            <div class="row mb-2 ">
                                <label class="col-lg-3 text-end">{{ __('note') }}</label>
                                <div class="col-lg-9">
                                    <input name="admin_note" value="{{ old('admin_note') }}" type="text"
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
            </div>
        </div>
    </div>
    @endsection