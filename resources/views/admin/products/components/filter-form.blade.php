<div class="card shadow mb-2">
    <div class="card-header">
        <a class="btn btn-primary" data-bs-toggle="collapse" href="#filters" role="button" aria-expanded="{{ !empty(session('filter_product')) ? 'true' : 'false' }}" aria-controls="filters">{{ __('admin.filter') }}</a>
    </div>
    <div class="collapse {{ !empty(session('filter_product')) ? 'show' : '' }}" id="filters">
        <div class="card card-body">
        <form action="{{ route('products.index') }}" method='POST'>
            @csrf
            <div class="row mb-2">
                <label class="col-lg-2 text-end">{{ __('admin.product_number') }}</label>
                <div class="col-lg-8">
                    <input name="product_number" value="{{ session('filter_product_number') }}" type="text" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-lg-2 text-end">{{ __('admin.manufacturer') }}</label>
                <div class="col-lg-8">
                    {!! custom_select('manufacturers','manufacturer_id','id','name',false,false,session('filter_manufacturer'),[''=>__('all')]) !!}
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-lg-2 text-end">{{ __('admin.categories') }}</label>
                <div class="col-lg-8">
                    {!! category_select($categories,session('filter_categories') ?? array(),'multiple') !!}
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-lg-2 text-end">{{ __('admin.name') }}</label>
                <div class="col-lg-8">
                    <input name="name" type="text" value="{{ session('filter_name'); }}" class="form-control">
                </div>
            </div>

            <div class="row mb-2 ">
                <div class="col-lg-2 text-end">{{ __('admin.published') }}?</div>
                <div class="col-lg-8">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="published" value="0" id="published0" {{ session('filter_published') === 0 ? 'checked' : '' }}>
                      <label class="form-check-label" for="published0">{{ __('no') }}</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="published" value="1" id="published1">
                      <label class="form-check-label" for="published1" {{ session('filter_published') == 1 ? 'checked' : '' }}>{{ __('yes') }}</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="published" value="2" id="published2" {{ (session('filter_published') == 2 || empty(session('filter_published'))) ? 'checked' : '' }}>
                      <label class="form-check-label" for="published2">{{ __('all') }}</label>
                    </div>
                </div>
            </div>

            <div class="row mb-2 ">
                <div class="col-lg-2 text-end">{{ __('admin.buyable') }}?</div>
                <div class="col-lg-8">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="available" value="0" id="available0" {{ session('filter_available') == 0 ? 'checked' : '' }}>
                      <label class="form-check-label" for="available0">{{ __('no') }}</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="available" value="1" id="available1" {{ session('filter_available') == 1 ? 'checked' : '' }}>
                      <label class="form-check-label" for="available1">{{ __('yes') }}</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="available" value="2" id="available2" {{ session('filter_available') == 2 || empty(session('filter_available')) ? 'checked' : '' }}>
                      <label class="form-check-label" for="available2">{{ __('all') }}</label>
                    </div>
                </div>
            </div>

            <div class="row mb-2 ">
                <div class="col-lg-2 text-end">{{ __('admin.on_stock') }}?</div>
                <div class="col-lg-8">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="stock" value="0" id="stock0" {{ session('filter_stock') == 0 ? 'checked' : '' }}>
                      <label class="form-check-label" for="stock0">{{ __('no') }}</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="stock" value="1" id="stock1" {{ session('filter_stock') == 1 ? 'checked' : '' }}>
                      <label class="form-check-label" for="stock1">{{ __('yes') }}</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="stock" value="2" id="stock2" {{ session('filter_stock') == 2 || empty(session('filter_stock')) ? 'checked' : '' }}>
                      <label class="form-check-label" for="stock2">{{ __('all') }}</label>
                    </div>
                </div>
            </div>

            <div class="row mb-2 ">
                <div class="col-lg-2 text-end">{{ __('admin.featured') }}?</div>
                <div class="col-lg-8">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="featured" value="0" id="featured0" {{ session('filter_featured') == 0 ? 'checked' : '' }}>
                      <label class="form-check-label" for="featured0">{{ __('no') }}</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="featured" value="1" id="featured1" {{ session('filter_featured') == 1 ? 'checked' : '' }}>
                      <label class="form-check-label" for="featured1">{{ __('yes') }}</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="featured" value="2" id="featured2" {{ session('filter_featured') == 2 || empty(session('filter_featured')) ? 'checked' : '' }}>
                      <label class="form-check-label" for="featured2">{{ __('all') }}</label>
                    </div>
                </div>
            </div>

            <div class="row mb-2 ">
                <div class="col-lg-2 text-end">{{ __('free_shipping') }}?</div>
                <div class="col-lg-8">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="free_shipping" value="0" id="free_shipping0" {{ session('filter_free_shipping') == 0 ? 'checked' : '' }}>
                      <label class="form-check-label" for="free_shipping0">{{ __('no') }}</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="free_shipping" value="1" id="free_shipping1" {{ session('filter_free_shipping') == 1 ? 'checked' : '' }}>
                      <label class="form-check-label" for="free_shipping1">{{ __('yes') }}</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="free_shipping" value="2" id="free_shipping2" {{ session('filter_free_shipping') == 2 || empty(session('filter_free_shipping')) ? 'checked' : '' }}>
                      <label class="form-check-label" for="free_shipping2">{{ __('all') }}</label>
                    </div>
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-lg-2 text-end">
                    {{ __('admin.order_by') }}
                </label>
                <div class="col-lg-4">
                <select name="order_by" id="order_by" class="form-select float-end">
                    <option value="">
                        {{ __('default') }}
                    </option>
                    <option value="name_asc" {{  session('filter_order_by') == 'name_asc' ? 'selected' : '' }}>
                        {{ __('admin.order_by_asc',['name'=>__('admin.name')]) }}
                    </option>
                    <option value="name_desc" {{  session('filter_order_by') == 'name_desc' ? 'selected' : '' }}>
                        {{ __('admin.order_by_desc',['name'=>__('admin.name')]) }}
                    </option>
                    <option value="price_asc" {{  session('filter_order_by') == 'price_asc' ? 'selected' : '' }}>
                        {{ __('admin.order_by_asc',['name'=>__('Price')]) }}
                    </option>
                    <option value="price_desc" {{  session('filter_order_by') == 'price_desc' ? 'selected' : '' }}>
                        {{ __('admin.order_by_desc',['name'=>__('Price')]) }}
                    </option>
                    <option value="date_asc" {{  session('filter_order_by') == 'date_asc' ? 'selected' : '' }}>
                        {{ __('admin.order_by_asc',['name'=>__('Date')]) }}
                    </option>
                    <option value="date_desc" {{  session('filter_order_by') == 'date_desc' ? 'selected' : '' }}>
                        {{ __('admin.order_by_desc',['name'=>__('Date')]) }}
                    </option>
                    <option value="shipping_desc" {{  session('filter_order_by') == 'shipping_desc' ? 'selected' : '' }}>
                        {{ __('admin.order_by_desc',['name'=>__('admin.unique_transport')]) }}
                    </option>
                </select>
                </div>
                <div class="col-lg-2">
                    <select name="limit" class="form-select float-end">
                        <option value="50" {{  session('limit') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{  session('limit') == 100 ? 'selected' : '' }}>100</option>
                        <option value="200" {{  session('limit') == 200 ? 'selected' : '' }}>200</option>
                        <option value="999999" {{  session('limit') == 999999 ? 'selected' : '' }}>{{ __('all') }}</option>
                    </select>
                </div>
                <label class="col-lg-2">
                    {{ __('admin.founds_per_page') }}
                </label>
            </div>
            <div class="row mb-2">
                <div class="offset-lg-2 col-lg-2">
                    <button type="submit" name="filter" value="1" class="btn btn-primary">{{ __('search') }}</button>
                </div>
                <div class="col-lg-4">
                    <button type="submit" class="btn btn-warning" name="clear_filters" value="1">{{ __('admin.filter_reset') }}</button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
