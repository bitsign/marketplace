@php $shipping = json_decode($order->shipping_method->translations,true) @endphp
<h2>{{ __('shipping_data') }}</h2>
@if(!empty($order->user->zip2) && !empty($order->user->address2))
<b>{{ __('name') }}             : </b> {{ $order->user->name }}<br>
<b>{{ __('country') }}          : </b> {{ $order->user->country2 }}<br>
<b>{{ __('state') }}            : </b> {{ $order->user->state2 }}<br>
<b>{{ __('zip') }}              : </b> {{ $order->user->zip2 }}<br>
<b>{{ __('city') }}             : </b> {{ $order->user->city2 }}<br>
<b>{{ __('address') }}          : </b> {{ $order->user->address2 }}
@else
<b>{{ __('name') }}             : </b> {{ $order->user->name }}<br>
<b>{{ __('country') }}          : </b> {{ $order->user->country }}<br>
<b>{{ __('state') }}            : </b> {{ $order->user->state }}<br>
<b>{{ __('zip') }}              : </b> {{ $order->user->zip }}<br>
<b>{{ __('city') }}             : </b> {{ $order->user->city }}<br>
<b>{{ __('address') }}          : </b> {{ $order->user->address }}
@endif
<h2>{{ __('shipping_mode') }} : {{ $shipping['name'][app()->getLocale()] }}</h2>