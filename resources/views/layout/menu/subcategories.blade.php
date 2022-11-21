<ul class="">
@foreach($childs as $child)
    @if(empty($child->translation->name))
        @continue
    @endif
    @php
        //$category_url = count($child->children) ? __('routes.categories') : __('routes.products');
        $category_url = __('routes.products');
        $url = $child->translation->url ?? '';
    @endphp
   <li>
        <a class="" title="{{ $child->translation->name }}" href="{{ url(app()->getLocale().'/'.$category_url.'/'.$url) }}" data-url="{{ $child->translation->url }}">
            {{ $child->translation->name }}
        </a>
        {!! count($child->children) ? '<i class="bi bi-chevron-right"></i>' :'' !!}
        @if(count($child->children))
            @include('layout.menu.subcategories',['childs' => $child->children,'depth'=>$child->depth])
        @endif
   </li>
@endforeach
</ul>
