@extends('admin.layout.app')
@section('content')
    @include ('admin/layout/page-header', ['page_title' => $page_title])
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <b>{{ __('status') }}</b>
                    <span class="float-end">
                        <strong>{{ __('admin.status') }}: </strong>
                        <span class="badge" style="background-color: {{ $status['color'] }}">
                            {{ $status['name'] }}
                        </span>
                    </span>
                </div>
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-lg-12">@include('layout/messages')</div>

                        <form method="post" action="{{ route('orders.update-status') }}" class="form-horizontal"
                            role="form">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end">{{ __('admin.status') }}</label>
                                <div class="col-lg-10">
                                    {!! custom_select('statuses', 'status', 'id', 'name', false, false, $status['id']); !!}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end">{{ __('message') }}</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" rows="3" name="admin_message"></textarea>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end"></label>
                                <div class="col-lg-10">
                                    <label>
                                        <input type="checkbox" name="send_status_alert">
                                        {{ __('admin.status_change_text') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-10 offset-lg-2">
                                <button type="submit" class="btn btn-primary">{{ __('admin.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <b>{{ $page_title }}</b>
                </div>
                <div class="card-body" id="invoice">
                    <div class="row no-gutters align-items-center">
                        <div class="card">
                            <div class="card-body">
                                <div class="container mb-5 mt-3">
                                    <div class="row d-flex align-items-baseline">
                                        <div class="col-xl-9">
                                            <p style="color: #7e8d9f;font-size: 20px;"><strong>ID: #{{ $order['id'] }}</strong></p>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-xl-8">
                                                <ul class="list-unstyled">
                                                    <li class="text-primary">
                                                        {{ $order->user->billing_name ?? $order->user->name }}
                                                    </li>
                                                    <li class="text-muted">{{ $order->user->zip }}, {{ $order->user->city }}, {{ $order->user->address }}
                                                    </li>
                                                    <li class="text-muted">{{ $order->user->state }}, {{ $order->user->country }}</li>
                                                    <li class="text-muted"><i class="bi bi-phone text-muted"></i> {{ $order->user->phone }}</li>
                                                </ul>
                                            </div>
                                            <div class="col-xl-4">
                                                <p class="text-primary">{{ __('admin.order') }}</p>
                                                <ul class="list-unstyled">
                                                    <li class="text-muted">
                                                        <span class="fw-bold">ID:</span> #{{ $order->id }}
                                                    </li>
                                                    <li class="text-muted">
                                                        <span class="fw-bold">{{ __('date',[],$order->lang) }}: </span>{{ $order->created_at }}
                                                    </li>
                                                    <li class="text-muted">
                                                        <span class="me-1 fw-bold">{{ __('admin.status',[],$order->lang) }}:</span>
                                                        @php $st_name = json_decode($status['translations'],true) @endphp
                                                        <span class="badge" style="background-color: {{ $status['color']; }}">
                                                            {{ $st_name[$order->lang] }}
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="row my-2 mx-1 justify-content-center">
                                            <table class="table table-striped table-borderless">
                                                <thead style="background-color:#84B0CA ;" class="text-white">
                                                    <tr>
                                                        <th scope="col">{{ __('product',[],$order->lang) }}</th>
                                                        <th scope="col">{{ __('quantity',[],$order->lang) }}</th>
                                                        <th scope="col">{{ __('price',[],$order->lang) }}</th>
                                                        <th scope="col">{{ __('subtotal',[],$order->lang) }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($order->products as $product)
                                                    <tr>
                                                        <td>
                                                            {{ $product['version_name'] }} <br>
                                                            @if(!empty($product['options']))
                                                                <small>
                                                                @php $options = json_decode($product['options'],true) @endphp
                                                                @foreach($options as $key => $value)
                                                                    {{ $key }}: {{ $value }}<br>
                                                                @endforeach
                                                                </small>
                                                            @endif
                                                        </td>
                                                        <td>{{ $product['qty'] }}</td>
                                                        <td>{{ currency($product['price']) }}</td>
                                                        <td>{{ currency($product['price']*$product['qty']) }}</td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td>{{ __('shipping_cost',[],$order->lang) }}:</td>
                                                        <td>{{ $order->shipping_cost != 0 ? currency($order->shipping_cost) : __('free',[],$order->lang) }}</td>
                                                    </tr>
                                                </tbody>

                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-8"></div>
                                            <div class="col-xl-3">
                                                <ul class="list-unstyled">
                                                    <li class="text-muted ms-3">
                                                        <span class="text-black me-4">{{ __('net_price',[],$order->lang) }}</span>
                                                        {{ currency(round($order->total/(1+VAT/100))) }}
                                                    </li>
                                                    <li class="text-muted ms-3 mt-2">
                                                        <span class="text-black me-4">{{ __('vat',[],$order->lang) }} ({{ VAT }}%)</span>
                                                        {{ currency(round($order->total-$order->total/(1+VAT/100))) }}
                                                    </li>
                                                </ul>
                                                <p class="text-black float-start">
                                                    <span class="text-black me-3">{{ __('total',[],$order->lang) }}</span> 
                                                    <span style="font-size: 25px;">{{ currency($order->total) }}</span>
                                                </p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-xl-10">
                                                <a href="{{ route('orders.invoice',$order->id) }}" class="btn btn-primary text-white" target="_blank">
                                                    <i class="bi bi-printer"></i> {{ __('print') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
