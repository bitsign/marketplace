@forelse($products as $product)
@php 
$discount = $product->action_price != 0 ? round((($product->price - $product->action_price)*100)/$product->price)  : '';
@endphp
@if($product->translation === NULL)
    @continue
@endif
<div class="col-md-{{ isset($col) ? $col : 4 }}">
    <div class="card mb-3">
        <div class="bg-image">
            <a href="{{ url(app()->getLocale().'/'.__('routes.product').'/'.$product->translation->url) }}" title="{{ $product->translation->name }}">
                <img src="{{ !empty($product->defaultImage->filename) ? url('files/products/small/'.$product->defaultImage->filename) : url('files/editor/no-image.jpg') }}" class="card-img-top" alt="{{ $product->translation->name }}">
            </a>
            @if(!empty($discount))
            <span class="badge bg-danger ms-2">-{{ $discount }}%</span>
            @endif
        </div>
        <div class="card-body">
            <h5 class="card-title mb-3">
                 <a href="{{ url(app()->getLocale().'/'.__('routes.product').'/'.$product->translation->url) }}">{{ $product->translation->name }}</a>
            </h5>
            <h6 class="mb-3">
                @if($product->action_price != 0)
                    <s>{{ currency($product->price) }}</s>
                    <strong class="ms-2 text-danger">{{ currency($product->action_price) }}</strong>
                @else
                    <b>{{ currency($product->price) }}</b>
                @endif
            </h6>
        </div>
    </div>
</div>
@empty
<div class="alert alert-info">
    {{ __('no_product') }}
</div>
@endforelse