@if(!empty($attached_products))
    <h2 class="page-header">{{ __('admin.attached_products') }}:</h2>
    <form method="POST" action="{{ url('admin/products/update-attached-products') }}">
    @csrf
    @foreach ($attached_products as $p)
        <div class="row mb-3">
            <label class="col-lg-3">{{ $p->translation->name }}</label>
            <div class="col-lg-9">
            </div>
        </div>
    @endforeach
    <div class="col-lg-offset-2 col-lg-8">
        <input type="hidden" name="product_id" value="{{ $product['id'] }}">
        <input type="hidden" name="deleteall" value="1">
        <button type="submit" class="delete_att_products btn btn-xs btn-danger" id="deleteall_{{ $product['id'] }}">{{ __('delete') }}</button>
    </div>
    </form>
@endif

<h2 class="page-header">{{ __('admin.attach_products') }}</h2>
<form action="{{ url('admin/products/update-attached-products') }}" method="POST">
    @csrf
    <div class="row mb-3">
        <label class="col-lg-2">{{ __('admin.search_by_category') }}</label>
        <input type="hidden" name="product_id" value="{{ $product['id'] }}">
        <div class="col-lg-10">
            {!! category_select($categories,[],'','','search_by_category_id') !!}
        </div>
    </div>
    {{-- <div class="row mb-3">
        <label class="col-lg-2">{{ __('admin.search_by_sku') }}</label>
        <div class="col-lg-10">
            <input type="text" name="search_by_product_number" id="search_by_product_number" class="form-control input-sm"/>
        </div>
    </div> --}}
    <div class="row mb-3 hidden" id="search_results">
        <label class="col-lg-2">{{ __('admin.products') }}</label>
        <div class="col-lg-8" id="products">

        </div>
        <div class="clearfix"></div>
        <div class="col-lg-offset-2 col-lg-8">
            <button type="submit" class="btn btn-primary">{{ __('admin.save') }}</button>
        </div>
    </div>
</form>
