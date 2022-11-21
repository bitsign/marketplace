@php $payment = json_decode($order->payment_method->translations,true) @endphp
<h2>{{ __('billing_data') }}</h2>
@if(!empty($order->user->vat_number))
<b>{{ __('vat_number') }}      : </b> {{ $order->user->vat_number }}<br>
@endif
<b>{{ __('name') }}            : </b> {{ $order->user->billing_name ?? $order->user->name }}<br>
<b>{{ __('country') }}         : </b> {{ $order->user->country }}<br>
<b>{{ __('state') }}           : </b> {{ $order->user->state }}<br>
<b>{{ __('zip') }}             : </b> {{ $order->user->zip }}<br>
<b>{{ __('city') }}            : </b> {{ $order->user->city }}<br>
<b>{{ __('address') }}         : </b> {{ $order->user->address }}
<h2>{{ __('payment') }} : {{ $payment['name'][app()->getLocale()] }}</h2>