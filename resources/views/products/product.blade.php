@extends('layout.page')
@section('content')
<section id="products" class="products">
    <div class="container" data-aos="fade-up">
        <div class="row mb-3">
            <div class="col-lg-12">@include('layout/messages')</div>

            <div class="col-md-6" id="lightgallery">
                <div class="main_image mb-3">
                    <a
                      href="{{ url('files/products/large') }}/{{ !empty($main_image->filename) ? $main_image->filename : 'no-image.png' }}"
                      title="{{ $main_image->title ?? '' }}"
                    >
                        <img src="{{ url('files/products/medium') }}/{{ !empty($main_image->filename) ? $main_image->filename : 'no-image.png' }}" class="card-img-top" title="{{ $main_image->title ?? '' }}" alt="{{ $main_image->name ?? '' }}">
                    </a>
                </div>
                @if (!empty($gallery))
                    <div class="row">
                    @foreach ($gallery as $g)
                        <div class="col-md-2 m-1">
                            <a
                              href="{{ url('files/products/large') }}/{{ !empty($g->filename) ? $g->filename : 'no-image.png' }}"
                              title="{{ $g->title ?? '' }}"
                            >
                                <img src="{{ url('files/products/small') }}/{{ !empty($g->filename) ? $g->filename : 'no-image.png' }}" class="card-img-top" title="{{ $g->title }}" alt="{{ $main_image->name }}">
                            </a>
                        </div>
                    @endforeach
                    </div>
                @endif
            </div>
            <div class="col-md-6">

                <h1 class="mb-3">{{ $product->name }}</h1>

                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item w-50"><b>{{ __('product_number') }}</b></li>
                  <li class="list-group-item w-50">{{ $product->product_number }}</li>
                </ul>
                
                @if(!empty($product->manufacturer->name))
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item w-50"><b>{{ __('manufacturer') }}</b></li>
                  <li class="list-group-item w-50">{{ $product->manufacturer->name }}</li>
                </ul>
                @endif

                @if($product->weight != 0)
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item w-50"><b>{{ __('weight') }}</b></li>
                  <li class="list-group-item w-50">{{ $product->weight }} g</li>
                </ul>
                @endif

                @if($product->shipping_cost != 0)
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item w-50"><b>{{ __('shipping_cost') }}</b></li>
                  <li class="list-group-item w-50">{{ currency($product->shipping_cost) }}</li>
                </ul>
                @endif

                @if($product->warranty != 0)
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item w-50"><b>{{ __('warranty') }}</b></li>
                  <li class="list-group-item w-50">{{ $product->warranty }} {{ __('month') }}</li>
                </ul>
                @endif

                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item w-50"><b>{{ __('stock') }}</b></li>
                  <li class="list-group-item w-50">{{ $product->stock }} {{ __('unit.unit_'.$product->unit_id) }}</li>
                </ul>

                @if($product->action_price != 0)
                    <h6 class="my-3 text-decoration-line-through">{{ __('price') }}: {{ currency($product->price) }}</h6>
                    <h4 class="my-3 text-success">{{ __('action_price') }}: {{ currency($product->action_price) }}</h4>
                @else
                    <h4 class="my-3 text-success">{{ __('price') }}: {{ currency($product->price) }}</h4>
                @endif

                <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @if(!empty($attributes))
                        @foreach($attributes as $attr_id => $att)
                            @foreach($att['options'] as $opt)
                                @if(!empty($opt['value']) && is_array($opt['value']) && !empty($opt['type']))

                                    @if($opt['type'] == 'radio')
                                        @foreach($opt['value'] as $val)
                                            <input name="options-{{ $attr_id }}" type="radio" class="btn-check" id="btn-check-{{ $val }}" autocomplete="off">
                                            <label class="btn btn-outline-secondary mb-1" for="btn-check-{{ $val }}">{{ $val }}</label>
                                        @endforeach
                                    @endif

                                @elseif(is_array(@$opt['value']))
                                    {{ $opt['name'] }}: 
                                    <select name="option[{{ $opt['name'] }}]" required class="form-select mb-2">
                                        @foreach($opt['value'] as $okey => $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    {{ $opt['name'] }}: {{ $opt['value'] ?? '' }}<br>
                                @endif
                            @endforeach
                        @endforeach
                    @endif

                    <input type="hidden" value="{{ $product->id }}" name="id">
                    <input type="hidden" value="{{ $product->name }}" name="name">
                    <input type="hidden" value="{{ $product->product_number }}" name="product_number">
                    <input type="hidden" value="{{ $product->action_price != 0 ? $product->action_price : $product->price }}" name="price">
                    <input type="hidden" value="{{ !empty($main_image->filename) ? $main_image->filename : 'no-image.png' }}"  name="image">
                    <input type="hidden" value="{{ $product->shipping_cost != 0 ? $product->shipping_cost : "" }}" name="shipping_cost">
                    <input type="hidden" value="{{ $product->unit_id != 0 ? __('unit.unit_'.$product->unit_id) : __('unit.unit_1') }}" name="unit">
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" value="1" min="1" name="quantity">
                        <button class="btn btn-success btn-block text-center">{{ __('add_to_cart_button') }}</button>
                    </div>
                </form>

            </div>
            <div class="col-md-12">
                <h2>{{ __('description') }}</h2>
                {!! $product->details !!}
            </div>

         </div>

         @if(!empty($attached_products))
             <h3>{{ __('related_products') }}</h3>
             <div class="row py-3">
                @include('products.list',['products'=>$attached_products])
             </div>
         @endif
    </div>
</section>
@endsection
