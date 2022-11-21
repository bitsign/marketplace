<ul class="parent">
@foreach($categories as $category)
    @if(empty($category->translation->name))
        @continue
    @endif
    @php
        $prefix = app()->getLocale();
        //$category_url = count($category->children) ? __('routes.categories') : __('routes.products');
        $category_url = __('routes.products');
    @endphp
    <li class="{{ (request()->segment(3) == $category->translation->url) ? 'active' : '' }}">
        <a class="" href="{{ url($prefix.'/'.$category_url.'/'.$category->translation->url) }}" title="{{ $category->translation->name }}" data-url="{{ $category->translation->url }}">
            {{ $category->translation->name }}
        </a>
        {!! count($category->children) ? '<i class="bi bi-plus-square"></i>' :'' !!}
        @if(count($category->children))
            @include('categories.sidebar-subcategories',['childs' => $category->children,'depth'=>$category->depth])
        @endif
    </li>
@endforeach
</ul>