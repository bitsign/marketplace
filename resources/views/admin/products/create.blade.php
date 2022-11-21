@extends('admin.layout.app')
@section('content')

@include ('admin/layout/page-header',['page_title'=>$page_title])
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header"><b>{{ $product['name'] ??  $page_title; }}</b></div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-lg-12">@include('layout/messages')</div>
                    <form method="post" action="{{ route('products.store') }}" class="form-horizontal" role="form" id="product_form">
                        @csrf
                        <div class="row py-3">
                            <div class="col-md-12">
                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end">{{ __('admin.categories') }} *</label>
                                    <div class="col-lg-10">
                                        {!! category_select($categories,[],'multiple','required') !!}
                                        <i class="help-block">{{ __('admin.select_category_info') }}</i>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end" for="product_number">{{ __('admin.product_number') }} *</label>
                                    <div class="col-lg-4">
                                        <input name="product_number" value="{{ old('product_number') }}" type="text" class="form-control input-sm" required/>
                                    </div>
                                    <label class="col-lg-2 text-lg-end">{{ __('admin.manufacturer') }}</label>
                                    <div class="col-lg-4">
                                        {!! custom_select('manufacturers','manufacturer_id','id','name',false,false,'',[''=>__('none')]) !!}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end" for="price">{{ __('admin.price') }} *</label>
                                    <div class="col-lg-2">
                                        <input name="price" value="{{ old('price') }}" type="number" class="form-control input-sm" required placeholder="{{ __('admin.price') }}" />
                                    </div>
                                    <div class="col-lg-2">
                                        <input name="action_price" value="{{ old('action_price') }}" type="number" class="form-control input-sm" placeholder="{{ __('admin.action_price') }}" />
                                    </div>
                                
                                    <label class="col-lg-2 text-lg-end">{{ __('admin.action_price_temp') }}</label>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <input name="action_start_date" value="{{ old('action_start_date') }}" type="text" class="form-control input-sm datepicker" placeholder="{{ __('admin.action_start_date') }}" autocomplete="off" />
                                            <input name="action_end_date" value="{{ old('action_end_date') }}" type="text" class="form-control input-sm datepicker" placeholder="{{ __('admin.action_end_date') }}" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end" for="stock">{{ __('admin.stock') }}</label>
                                    <div class="col-lg-4">
                                        <input name="stock" value="{{ old('stock') ?? 0 }}" type="text" class="form-control input-sm"/>
                                    </div>
                                    <label class="col-lg-2 text-lg-end">{{ __('admin.weight') }} (g)</label>
                                    <div class="col-lg-4">
                                        <input name="weight" value="{{ old('weight') ?? 0 }}" type="text" class="form-control input-sm"/>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end">{{ __('admin.shipping_cost') }}</label>
                                    <div class="col-lg-4">
                                        <input name="shipping_cost" value="{{ old('shipping_cost') ?? 0 }}" type="number" class="form-control input-sm" placeholder="">
                                    </div>
                                    <label class="col-lg-2 text-lg-end">{{ __('admin.warranty') }} ({{ __('admin.month') }})</label>
                                    <div class="col-lg-4">
                                        <input name="warranty" value="{{ old('warranty') ?? 0 }}" type="number" class="form-control input-sm" />
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end">{{ __('admin.unit') }}</label>
                                    <div class="col-lg-4">
                                        <select name="unit_id" class="form-select">
                                            @foreach($units as $unit)
                                                <option value="{{ $unit->id }}" @selected(old('unit_id'))>
                                                    {{ __('unit.'.$unit->key_name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label class="col-lg-2 text-lg-end">{{ __('admin.reward_points') }}</label>
                                    <div class="col-lg-4">
                                        <input name="reward" value="0" type="number" class="form-control input-sm" />
                                    </div>
                                </div>

                                <div class="mb-3 row ">
                                    <label class="col-lg-2 text-lg-end"></label>
                                    <div class="col-lg-10">
                                        <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="{{ __('admin.published') }}" data-off="{{ __('admin.not') }} {{ __('admin.published') }}" data-toggle="toggle" name="published" value="1" checked/>

                                        <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="{{ __('admin.buyable') }}" data-off="{{ __('admin.not') }} {{ __('admin.buyable') }}" data-toggle="toggle" name="available" value="1" checked />

                                        <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="{{ __('admin.featured') }}" data-off="{{ __('admin.not') }} {{ __('admin.featured') }}" data-toggle="toggle" name="featured" value="1" />

                                        <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="{{ __('admin.free_shipping') }}" data-off="{{ __('admin.not') }} {{ __('admin.free_shipping') }}" data-toggle="toggle" name="free_shipping" value="1" />
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end" for="name">{{ __('admin.product_name') }} *</label>
                                    <div class="col-lg-10">
                                        @foreach(config('app.available_locales') as $lang)
                                        <div class="input-group mb-1">
                                            <span class="input-group-text"><img src="{{ url('assets/img/'.$lang.'.png') }}" width="18px"></span>
                                            <input name="name[{{ $lang }}]" type="text" value="{{ old('name['.$lang.']') }}" class="form-control" required>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end">{{ __('admin.short_description') }}</label>
                                    <div class="col-lg-10">
                                        @foreach(config('app.available_locales') as $lang)
                                        <div class="input-group mb-1">
                                            <span class="input-group-text"><img src="{{ url('assets/img/'.$lang.'.png') }}" width="18px"></span>
                                            <textarea name="short_details[{{ $lang }}]" rows="3" class="form-control">{{ old('short_details['.$lang.']') }}</textarea>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                @foreach(config('app.available_locales') as $lang)
                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end">{{ __('admin.content') }} <img src="{{ url('assets/img/'.$lang.'.png') }}" width="18px"></label>
                                    <div class="col-lg-10">
                                        <textarea id="editor1" class="editor" name="details[{{ $lang }}]">{{ old('details['.$lang.']') }}</textarea>
                                    </div>
                                </div>
                                @endforeach

                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end">{{ __('admin.meta_description') }}</label>
                                    <div class="col-lg-10">
                                        @foreach(config('app.available_locales') as $lang)
                                        <div class="input-group mb-1">
                                            <span class="input-group-text"><img src="{{ url('assets/img/'.$lang.'.png') }}" width="18px"></span>
                                            <input name="meta_description[{{ $lang }}]" type="text" value="{{ old('meta_description['.$lang.']') }}" class="form-control">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end">{{ __('admin.meta_keywords') }}</label>
                                    <div class="col-lg-10">
                                        @foreach(config('app.available_locales') as $lang)
                                        <div class="input-group mb-1">
                                            <span class="input-group-text"><img src="{{ url('assets/img/'.$lang.'.png') }}" width="18px"></span>
                                            <input name="meta_keywords[{{ $lang }}]" type="text" value="{{ old('meta_keywords['.$lang.']') }}" class="form-control">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end">{{ __('admin.meta_title') }}</label>
                                    <div class="col-lg-10">
                                        @foreach(config('app.available_locales') as $lang)
                                        <div class="input-group mb-1">
                                            <span class="input-group-text"><img src="{{ url('assets/img/'.$lang.'.png') }}" width="18px"></span>
                                            <input name="meta_title[{{ $lang }}]" type="text" value="{{ old('meta_title['.$lang.']') }}" class="form-control">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="mb-3 row">
                                <div class="col-lg-offset-1 col-lg-8">
                                    <button type="submit" class="btn btn-primary">{{ __('admin.save') }}</button>
                                </div>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection