<ul class="ajax_search_results">
@foreach($products as $product)

    @php
    $link = url(app()->getLocale().'/'.__('routes.product').'/'.$product['url']);
    if(empty($product['filename']) || !file_exists($_SERVER['DOCUMENT_ROOT'] . '/files/products/small/'.$product['filename']))
        $product['filename'] = 'no-image.png';
    $image_src = asset('/files/products/small/'.$product['filename']);
    $image  = ( ! empty($product['filename']) ) ? '<img src="'.$image_src.'" width="60" />' : '';

    //$prices = get_prices($product,true);
    @endphp
    <li>
        <a href="{{ $link }}">
            {{ $product['name'] }}
        </a>
    </li>
@endforeach
</ul>