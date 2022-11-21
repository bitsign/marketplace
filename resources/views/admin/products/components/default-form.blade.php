<form method="post" action="{{ route('products.update',$product) }}" class="form-horizontal" role="form" id="product_form">
    @method('PUT')
    @csrf
    <div class="row py-3">
        <div class="col-md-12">
            <div class="mb-3 row">
                <label class="col-lg-2 text-lg-end">{{ __('admin.categories') }} *</label>
                <div class="col-lg-10">
                    {!! category_select($categories,!empty($product['categories']) ? explode(',',$product['categories']) : array(),'multiple','required') !!}
                    <i class="help-block">{{ __('admin.select_category_info') }}</i>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-lg-2 text-lg-end" for="product_number">{{ __('admin.product_number') }} *</label>
                <div class="col-lg-4">
                    <input name="product_number" value="{{ $product['product_number'] ?? old('product_number') }}" type="text" class="form-control input-sm" required/>
                </div>
                <label class="col-lg-2 text-lg-end">{{ __('admin.manufacturer') }}</label>
                <div class="col-lg-4">
                    {!! custom_select('manufacturers','manufacturer_id','id','name',false,false,@$product['manufacturer_id'],[''=>__('none')]) !!}
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-lg-2 text-lg-end" for="price">{{ __('admin.price') }} *</label>
                <div class="col-lg-2">
                    <input name="price" value="{{ $product['price'] }}" type="number" class="form-control input-sm" required placeholder="{{ __('admin.price') }}" />
                </div>
                <div class="col-lg-2">
                    <input name="action_price" value="{{ $product['action_price'] ?? '' }}" type="number" class="form-control input-sm" placeholder="{{ __('admin.action_price') }}" />
                </div>

                <label class="col-lg-2 text-lg-end">{{ __('admin.action_price_temp') }}</label>
                <div class="col-lg-4">
                    <div class="input-group">
                        <input name="action_start_date" value="{{ $product['action_start_date'] ?? '' }}" type="text" class="form-control input-sm datepicker" placeholder="{{ __('admin.action_start_date') }}" autocomplete="off" />
                        <input name="action_end_date" value="{{ $product['action_end_date'] ?? '' }}" type="text" class="form-control input-sm datepicker" placeholder="{{ __('admin.action_end_date') }}" autocomplete="off" />
                    </div>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-lg-2 text-lg-end" for="stock">{{ __('admin.stock') }}</label>
                <div class="col-lg-4">
                    <input name="stock" value="{{ $product['stock'] ?? old('stock') }}" type="text" class="form-control input-sm"/>
                </div>
                <label class="col-lg-2 text-lg-end">{{ __('admin.weight') }} (g)</label>
                <div class="col-lg-4">
                    <input name="weight" value="{{ $product['weight'] ?? old('weight') }}" type="text" class="form-control input-sm" required/>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-lg-2 text-lg-end">{{ __('admin.shipping_cost') }}</label>
                <div class="col-lg-4">
                    <input name="shipping_cost" value="{{ $product['shipping_cost'] ?? old('shipping_cost') }}" type="number" class="form-control input-sm" placeholder="">
                </div>
                <label class="col-lg-2 text-lg-end">{{ __('admin.warranty') }} ({{ __('admin.month') }})</label>
                <div class="col-lg-4">
                    <input name="warranty" value="{{ $product['warranty'] ?? old('warranty') }}" type="number" class="form-control input-sm" />
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-lg-2 text-lg-end">{{ __('admin.unit') }}</label>
                <div class="col-lg-4">
                    <select name="unit_id" class="form-select">
                        @foreach($units as $unit)
                        <option value="{{ $unit->id }}" @selected($unit->id==$product->unit_id)>
                            {{ __('unit.'.$unit->key_name) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <label class="col-lg-2 text-lg-end">{{ __('admin.reward_points') }}</label>
                <div class="col-lg-4">
                    <input name="reward" value="{{ $product['reward'] ?? 0 }}" type="number" class="form-control input-sm" />
                </div>
            </div>

            <div class="mb-3 row ">
                <label class="col-lg-2 text-lg-end"></label>
                <div class="col-lg-10">
                    <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="{{ __('admin.published') }}" data-off="{{ __('admin.not') }} {{ __('admin.published') }}" data-toggle="toggle" name="published" value="1" {{ @$product['published'] == 1 || @$product['id'] == "" ? 'checked' : '' }}/>

                    <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="{{ __('admin.buyable') }}" data-off="{{ __('admin.not') }} {{ __('admin.buyable') }}" data-toggle="toggle" name="available" value="1" {{ @$product['available'] == 1 || @$product['id'] == "" ? 'checked' : '' }} />

                    <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="{{ __('admin.featured') }}" data-off="{{ __('admin.not') }} {{ __('admin.featured') }}" data-toggle="toggle" name="featured" value="1" {{ @$product['featured'] == 1 ? 'checked' : '' }} />

                    <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="{{ __('admin.free_shipping') }}" data-off="{{ __('admin.not') }} {{ __('admin.free_shipping') }}" data-toggle="toggle" name="free_shipping" value="1" {{ @$product['free_shipping'] == 1 || @$product['id'] == "" ? 'checked' : '' }}/>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-lg-2 text-lg-end" for="name">{{ __('admin.product_name') }} *</label>
                <div class="col-lg-10">
                    @foreach(config('app.available_locales') as $lang)
                    <div class="input-group mb-1">
                        <span class="input-group-text"><img src="{{ url('assets/img/'.$lang.'.png') }}" width="18px"></span>
                        <input name="name[{{ $lang }}]" type="text" value="{{ $translations[$lang]['name'] ?? '' }}" class="form-control" required>
                    </div>
                    <input type="hidden" name="translation_id[{{ $lang }}]" value="{{ $translations[$lang]['id'] ?? '' }}">
                    @endforeach
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-lg-2 text-lg-end">{{ __('admin.short_description') }}</label>
                <div class="col-lg-10">
                    @foreach(config('app.available_locales') as $lang)
                    <div class="input-group mb-1">
                        <span class="input-group-text"><img src="{{ url('assets/img/'.$lang.'.png') }}" width="18px"></span>
                        <textarea name="short_details[{{ $lang }}]" rows="3" class="form-control">{{ $translations[$lang]['short_details'] ?? "" }}</textarea>
                    </div>
                    @endforeach
                </div>
            </div>

            @foreach(config('app.available_locales') as $lang)
            <div class="mb-3 row">
                <label class="col-lg-2 text-lg-end">{{ __('admin.content') }} <img src="{{ url('assets/img/'.$lang.'.png') }}" width="18px"></label>
                <div class="col-lg-10">
                    <textarea id="editor1" class="editor" name="details[{{ $lang }}]">{{ $translations[$lang]['details'] ?? "" }}</textarea>
                </div>
            </div>
            @endforeach

            <div class="mb-3 row">
                <label class="col-lg-2 text-lg-end">{{ __('admin.meta_description') }}</label>
                <div class="col-lg-10">
                    @foreach(config('app.available_locales') as $lang)
                    <div class="input-group mb-1">
                        <span class="input-group-text"><img src="{{ url('assets/img/'.$lang.'.png') }}" width="18px"></span>
                        <input name="meta_description[{{ $lang }}]" type="text" value="{{ $translations[$lang]['meta_description'] ?? '' }}" class="form-control">
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
                        <input name="meta_keywords[{{ $lang }}]" type="text" value="{{ $translations[$lang]['meta_keywords'] ?? '' }}" class="form-control">
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
                        <input name="meta_title[{{ $lang }}]" type="text" value="{{ $translations[$lang]['meta_title'] ?? '' }}" class="form-control">
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
