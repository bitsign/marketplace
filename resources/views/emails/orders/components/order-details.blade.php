<div class="table">
    <table>
        <thead>
            <tr>
                <th align="left">{{ __('product') }}</th>
                <th align="center">{{ __('quantity') }}</th>
                <th align="center">{{ __('price') }}</th>
                <th align="right">{{ __('subtotal') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->products as $product)
            <tr>
                <td align="left">
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
                <td align="center">{{ $product['qty'] }}</td>
                <td align="center">{{ currency($product['price']) }}</td>
                <td align="right">{{ currency($product['price']*$product['qty']) }}</td>
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td align="right">{{ __('shipping_cost') }}:</td>
                <td align="right">{{ $order->shipping_cost != 0 ? currency($order->shipping_cost) : __('free') }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td align="right">{{ __('total') }}:</td>
                <td align="right">{{ currency($order->total) }}</td>
            </tr>
        </tbody>
    </table>
</div>