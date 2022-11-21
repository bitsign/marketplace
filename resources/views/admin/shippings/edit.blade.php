@extends('admin.layout.app')
@section('content')

@include ('admin/layout/page-header',['page_title'=>$page_title])
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header"><b>{{ $page_title }}</b></div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">

                    <div class="col-lg-12">@include('layout/messages')</div>

                    <form method="post" action="{{ route('shipping-methods.update',$shippingMethod) }}" class="form-horizontal" role="form" id="shipping_form">
                        @method('PUT')
                        @csrf

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.title') }} <code>*</code></label>
                            <div class="col-lg-10">
                                @foreach (config('app.available_locales') as $lang)
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"><img src="{{ url('assets/img/' . $lang . '.png') }}"
                                                width="18px"></span>
                                        <input name="translations[name][{{ $lang }}]" type="text"
                                            value="{{ $translations['name'][$lang] ?? '' }}" class="form-control" required>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.id') }} <code>*</code></label>
                            <div class="col-lg-10">
                                <input name="code" type="text" value="{{ $shippingMethod['code'] }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.shipping_cost') }}</label>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    <div class="accordion mb-3" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <label 
                                                    class="accordion-button p-2 {{ empty($shippingMethod->value) ? 'collapsed' : '' }}" 
                                                    aria-expanded="{{ !empty($shippingMethod->value) ? 'true' : 'false' }}"
                                                    type="button" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#collapseOne"  
                                                    aria-controls="collapseOne">
                                                    <input type="radio" class="me-2" name="shipping_charge_method" value="fixed_fee" {{ !empty($shippingMethod->value) ? 'checked' : '' }}>
                                                    {{ __('admin.fixed_shipping_cost') }}
                                                </label>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse {{ !empty($shippingMethod->value) ? 'show' : '' }}" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="input-group">
                                                        <input name="value" type="text" value="{{ $shippingMethod['value'] }}" class="form-control">
                                                        <span class="input-group-text">{{ config('currency.default') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwo">
                                                <label 
                                                    class="accordion-button p-2 {{ empty($shippingMethod->weight_interval) ? 'collapsed' : '' }}" 
                                                    type="button" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#collapseTwo" 
                                                    aria-expanded="{{ !empty($shippingMethod->weight_interval) ? 'true' : 'false' }}" 
                                                    aria-controls="collapseTwo">
                                                        <input type="radio" class="me-2" name="shipping_charge_method" value="weight_interval" {{ !empty($shippingMethod->weight_interval) ? 'checked' : '' }}>
                                                        {{ __('admin.weight_interval_cost') }}
                                                </label>
                                            </h2>
                                            @php
                                                $weight_intervals = !empty($shippingMethod->weight_interval) ? json_decode($shippingMethod->weight_interval,true) : array();
                                            @endphp
                                            <div id="collapseTwo" class="accordion-collapse collapse {{ !empty($shippingMethod->weight_interval) ? 'show' : '' }}" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-hover" id="weight_intervals_form">
                                                        <tr>
                                                            <th>{{ __('admin.weight_limit') }}</th>
                                                            <th>{{ __('admin.shipping_cost') }}</th>
                                                            <th>{{ __('admin.operations') }}</th>
                                                        </tr>
                                                        @if(!empty($weight_intervals))
                                                        @for ($i=0; $i<count($weight_intervals['limit']); $i++)
                                                        <tr>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text" name="weight_interval[limit][]" class="form-control" value="{{ $weight_intervals['limit'][$i] }}">
                                                                    <span class="input-group-text">g</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text" name="weight_interval[cost][]" class="form-control" value="{{ $weight_intervals['cost'][$i] }}">
                                                                    <span class="input-group-text">{{ config('currency.default') }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="btn btn-danger btn-xs del" title="Intervallum törlése"><i class="bi bi-trash"></i></span>
                                                            </td>
                                                        </tr>
                                                        @endfor
                                                        @else
                                                        <tr>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text" name="weight_interval[limit][]" class="form-control" value="">
                                                                    <span class="input-group-text">g</span>
                                                                </div>
                                                                
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text" name="weight_interval[cost][]" class="form-control" value="">
                                                                    <span class="input-group-text">{{ config('currency.default') }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="btn btn-danger btn-xs del" title="Intervallum törlése"><i class="bi bi-trash"></i></span>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    </table>
                                                    <button type="button" class="btn btn-info text-white" id="add_weight_interval"><i class="bi bi-plus"></i> {{ __('admin.new_interval') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <label 
                                                    class="accordion-button p-2 {{ empty($shippingMethod->price_interval) ? 'collapsed' : '' }}" 
                                                    type="button" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#collapseThree" 
                                                    aria-expanded="{{ !empty($shippingMethod->price_interval) ? 'true' : 'false' }}" 
                                                    aria-controls="collapseThree">
                                                    <input type="radio" class="me-2" name="shipping_charge_method" value="price_interval" {{ !empty($shippingMethod->price_interval) ? 'checked' : '' }}>
                                                    {{ __('admin.price_interval_cost') }}
                                                </label>
                                            </h2>
                                            @php
                                                $price_intervals = !empty($shippingMethod->price_interval) ? json_decode($shippingMethod->price_interval,true) : array();
                                            @endphp
                                            <div id="collapseThree" class="accordion-collapse collapse {{ !empty($shippingMethod->price_interval) ? 'show' : '' }}" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-hover" id="payment_intervals_form">
                                                        <tr>
                                                            <th>{{ __('admin.price_limit') }}</th>
                                                            <th>{{ __('admin.shipping_cost') }}</th>
                                                            <th>{{ __('admin.operations') }}</th>
                                                        </tr>
                                                        @if(!empty($price_intervals))
                                                        @for ($j=0; $j<count($price_intervals['limit']); $j++)
                                                        <tr>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text" name="price_interval[limit][]" class="form-control" value="{{ $price_intervals['limit'][$j] }}">
                                                                    <span class="input-group-text">{{ config('currency.default') }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text" name="price_interval[cost][]" class="form-control" value="{{ $price_intervals['cost'][$j] }}">
                                                                    <span class="input-group-text">{{ config('currency.default') }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="btn btn-danger btn-xs del" title="Intervallum törlése"><i class="bi bi-trash"></i></span>
                                                            </td>
                                                        </tr>
                                                        @endfor
                                                        @else
                                                        <tr>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text" name="price_interval[limit][]" class="form-control" value="">
                                                                    <span class="input-group-text">{{ config('currency.default') }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text" name="price_interval[cost][]" class="form-control" value="">
                                                                    <span class="input-group-text">{{ config('currency.default') }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="btn btn-danger btn-xs del" title="Intervallum törlése"><i class="bi bi-trash"></i></span>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    </table>
                                                    <button type="button" class="btn btn-info text-white" id="add_payment_interval"><i class="bi bi-plus"></i> {{ __('admin.new_interval') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingFour">
                                                <label
                                                    class="accordion-button p-2 {{ empty($shippingMethod->free) ? 'collapsed' : '' }}"
                                                    type="button" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#headingFour" 
                                                    aria-expanded="{{ !empty($shippingMethod->free) ? 'true' : 'false' }}" 
                                                    aria-controls="headingFour"> 
                                                    <input type="radio" class="me-2" name="shipping_charge_method" value="free_shipping" {{ !empty($shippingMethod->free) ? 'checked' : '' }}>
                                                    {{ __('admin.free_shipping_cost') }}
                                                </label>
                                            </h2>
                                            <div id="headingFour" class="accordion-collapse collapse {{ !empty($shippingMethod->free) ? 'show' : '' }}" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    {{ __('admin.no_shipping_cost') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        @foreach (config('app.available_locales') as $lang)
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.description') }} <img
                                    src="{{ url('assets/img/' . $lang . '.png') }}" width="18px"></label>
                            <div class="col-lg-10">
                                <textarea class="editor form-control" name="translations[description][{{ $lang }}]" rows="10" cols="80">{{ $translations['description'][$lang] ?? '' }}</textarea>
                            </div>
                        </div>
                        @endforeach

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.active') }}?</label>
                            <div class="col-lg-10">
                                <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="Igen" data-off="Nem" data-toggle="toggle" name="active" value="1" {{ !empty($shippingMethod['active']) || empty($shippingMethod['id']) ? 'checked' : '' }}/>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.possible_payments') }}</label>
                            <div class="col-lg-10">
                                {!! custom_select('payment_methods','possible_payments[]','code','name',false,true,json_decode($shippingMethod['possible_payments'],true)) !!}
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.possible_countries') }}</label>
                            <div class="col-lg-10">
                                <select name="possible_countries[]" class="form-select select2" multiple>
                                    @php 
                                        $possible_countries = $shippingMethod['possible_countries'] != '' ? json_decode($shippingMethod['possible_countries'],true) : []
                                    @endphp
                                    @foreach($countries as $country)
                                    <option value="{{ $country->id }}" @selected(in_array($country->id, $possible_countries))>
                                        {{ app()->getLocale() == 'en' ? $country->name : $country->native }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.sort_order') }}</label>
                            <div class="col-lg-10">
                                <input name="sort" value="{{ $shippingMethod['sort'] ??  0 }}" type="text" class="form-control">
                            </div>
                        </div>
                        <hr />
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"></label>
                            <div class="col-lg-9">
                                <button type="submit" class="btn btn-primary">{{ __('admin.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
