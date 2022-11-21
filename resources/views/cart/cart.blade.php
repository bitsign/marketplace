@extends('layout.page')
@section('content')
<section class="h-100">
    <div class="container py-5">
        @if ($message = Session::get('success'))
            <div class="p-4 mb-3 alert alert-success">
                {{ $message }}
            </div>
        @endif
        <div class="row d-flex justify-content-center my-4">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0">{{ __('cart') }}</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $cart_shipping_id = "";
                            $cart_payment_id = "";
                            $style = "";
                        @endphp
                        @foreach ($cartItems as $item)
                            <!-- Single item -->
                            <div class="row">
                                <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                    <!-- Image -->
                                    <div class="bg-image hover-overlay hover-zoom rounded">
                                        <img src="{{ url('files/products/small/') }}/{{ $item->attributes->image ?? 'no-image.png' }}"
                                            class="w-100" />
                                    </div>
                                    <!-- Image -->
                                </div>

                                <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                    <!-- Data -->
                                    <p><strong>{{ $item->name }}</strong></p>
                                    
                                    @if ($item->attributes->options)
                                        @foreach($item->attributes->options as $key => $value)
                                            {{ $key }}: {{ $value }}<br>
                                        @endforeach
                                    @endif

                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" value="{{ $item->id }}" name="id">
                                        <button type="submit" class="btn btn-danger btn-sm me-1 mb-2"
                                            data-mdb-toggle="tooltip" title="Remove item">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                    <!-- Data -->
                                </div>

                                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                    <!-- Quantity -->
                                    <form action="{{ route('cart.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <div class="d-flex mb-4" style="max-width: 300px">
                                            <div class="input-group">
                                                <button class="btn btn-primary"
                                                    onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                    <i class="bi bi-dash-lg"></i>
                                                </button>
                                                <input name="quantity" value="{{ $item->quantity }}" type="number" class="form-control" min="1" />
                                                <button class="btn btn-primary"
                                                    onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                    <i class="bi bi-plus-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- Quantity -->

                                    <!-- Price -->
                                    <p class="text-start text-md-center">
                                        <strong>{{ currency($item->price) }}</strong>
                                    </p>
                                    <!-- Price -->
                                </div>
                            </div>
                            <!-- Single item -->

                            <hr class="my-4" />
                        @endforeach

                        @if (Cart::isEmpty() === false)
                        <form action="{{ url(app()->getLocale() . '/checkout') }}" method="POST">
                            @csrf
                            <h4 class="mb-3">{{ __('shipping_methods') }}</h4>

                            <div class="my-3">
                                @foreach ($transportOptions as $to)
                                @php $tr_translation = json_decode($to['translations'],true) @endphp
                                    <div class="form-check">
                                        <input id="transport_{{ $to['id'] }}" name="shipping" type="radio"
                                            class="form-check-input shopping_method"
                                            {{ $to['name'] == $selected_shipping ? 'checked' : '' }} required
                                            value="{{ $to['code'] }}"
                                            data-possible_payments = "{{ implode("|",json_decode($to['possible_payments'],true)) }}"
                                            data-id = "{{ $to['id'] }}"
                                            data-name = "{{ $to['name'] }}"
                                            >
                                        <label class="form-check-label"
                                            for="transport_{{ $to['id'] }}">{{ $tr_translation['name'][app()->getLocale()] }} 
                                            {{ $to['value'] != 0 ? '(+'.currency($to['value']).')' : '' }}
                                            <span class="badge rounded-pill bg-info" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-html="true" title="{{ $tr_translation['description'][app()->getLocale()] }}">
                                                i
                                            </span>
                                        </label>
                                    </div>
                                    @php
                                        if($selected_shipping==$to['name'])
                                            $visible_payments = json_decode($to['possible_payments'],true);
                                    @endphp
                                @endforeach
                            </div>

                            <hr class="my-4">

                            <h4 class="mb-3">{{ __('payment_methods') }}</h4>

                            <div class="payment_methods my-3">
                                <div class="payments_loading"></div>
                                @foreach ($paymentModes as $pm)
                                    @php
                                        $style = 'display:none;';
                                        if(!empty($visible_payments))
                                        {
                                            if(in_array($pm['code'], $visible_payments))
                                                $style = "";
                                            else
                                                $style = 'display:none;';

                                        }
                                        $pm_translation = json_decode($pm['translations'],true)
                                    @endphp
                                    <div class="form-check payment_method" id="payment_{{ $pm['code'] }}" style="{{ $style }}">
                                        <input name="payment" type="radio" id="payment-{{ $pm['code'] }}"
                                            class="form-check-input"
                                            {{ $pm['name'] == $selected_payment ? 'checked' : '' }} required
                                            value="{{ $pm['code'] }}">
                                        <label class="form-check-label" for="payment-{{ $pm['code'] }}">{{ $pm_translation['name'][app()->getLocale()] }}
                                            <span class="badge rounded-pill bg-info" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-html="true" title="{{ $pm_translation['description'][app()->getLocale()] }}">
                                                i
                                            </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <hr class="my-4">
                            <button type="submit" class="btn btn-success float-end">
                                {{ __('go_to_checkout') }}
                            </button>
                        </form>
                        @endif

                        @if (Cart::isEmpty())
                            <div class="alert alert-info">{{ __('empty_cart') }}</div>

                            <a href="{{ url(app()->getLocale()) }}"
                                class="btn btn-primary">{{ __('continue_shopping') }}</a>
                        @else
                            <form action="{{ route('cart.clear') }}" method="POST" class="float-start">
                                @csrf
                                <button class="btn btn-warning"><i class="bi bi-trash"></i>
                                    {{ __('delete_cart') }}</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0">{{ __('order_summary') }}</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                {{ __('products') }} ({{ Cart::getTotalQuantity() }} {{ __('unit.unit_1') }})
                                <span>{{ currency(Cart::getSubTotal()) }}</span>
                            </li>

                            @foreach (Cart::getConditions() as $condition)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    {{ $condition->getName() }}
                                    <span>{{ currency($condition->getValue()) }}</span>
                                </li>
                            @endforeach
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                <div>
                                    <strong>{{ __('total') }}</strong>
                                    <strong>
                                        <p class="mb-0">({{ __('including VAT') }})</p>
                                    </strong>
                                </div>
                                <span><strong>{{ currency(Cart::getTotal()) }}</strong></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection
