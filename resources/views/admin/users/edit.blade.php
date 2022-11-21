@extends('admin.layout.app')
@section('content')
@include ('admin/layout/page-header', ['page_title' => $page_title])
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header">{{ $page_title }}</div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <form method="post" action="{{ route('users.update', $user) }}" class="form-horizontal" role="form"
                        id="user_form">
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
                                        <option value="{{ $lang }}"  @selected($user['lang'] == $lang)>
                                            {{ $key }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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
                            <!--div class="row mb-2">
                                <label class="col-lg-3 text-end">{{ __('admin.group') }}</label>
                                <div class="col-lg-9">
                                    {{-- custom_select('users_groups','group_id','id','title',$user['group_id']) --}}
                                </div>
                            </div-->
                            <div class="mb-3 row">
                                <label class="col-lg-3 text-lg-end">{{ __('admin.active') }}?</label>
                                <div class="col-lg-9">
                                    <input type="checkbox" data-onstyle="success" data-offstyle="danger"
                                        data-size="mini" data-on="{{ __('yes') }}" data-off="{{ __('no') }}"
                                        data-toggle="toggle" name="active" value="1"
                                        {{ !empty($user['active']) ? 'checked' : '' }} />
                                </div>
                            </div>
                            <!--div class="row mb-2">
                                <label class="col-lg-3 text-end">{{ __('admin.discount') }}</label>
                                <div class="col-lg-9">
                                    <input name="discount" type="text" value="{{ $user['discount'] }}" class="form-control">
                                </div>
                            </div-->
                        </fieldset>
                        <fieldset>
                            <legend>{{ __('admin.billing_info') }}</legend>
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
                                <label class="col-lg-3 text-end">{{ __('company_vat_number') }}</label>
                                <div class="col-lg-9">
                                    <input type="text" name="vat_number" class="form-control"
                                        value="{{ $user['vat_number'] }}">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>{{ __('admin.shipping_info') }}</legend>
                            <div class="row mb-2">
                                <label class="col-lg-3 text-end">{{ __('country') }}</label>
                                <div class="col-lg-9">
                                    <input name="country2"
                                        value="{{ $user['country2'] != '' ? $user['country2'] : 'Magyarország' }}"
                                        type="text" id="country2" class="form-control">
                                </div>
                            </div>
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
                        </fieldset>
                        <fieldset>
                            <legend>Admin {{ __('note') }}</legend>
                            <div class="row mb-2 ">
                                <label class="col-lg-3 text-end">{{ __('note') }}</label>
                                <div class="col-lg-9">
                                    <input name="admin_note" value="{{ $user['admin_note'] }}" type="text"
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
