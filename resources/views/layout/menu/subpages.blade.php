<ul class="">
@foreach($childs as $key => $menu)
     @php
        if($menu->translation === NULL)
            continue;
        $active = '';
        $name = !empty($menu->translation->menu_title) ? $menu->translation->menu_title : $menu->translation->name;
        $url = $menu->type == 'page' ? app()->getLocale() . '/' . __('routes.page') . '/' . $menu->translation->url : app()->getLocale() . '/' . __('routes.' . $menu->type);
        $active = request()->segment(2) == $menu->translation->url ? 'active' : '';
    @endphp
   <li>
        <a class="" title="{{ $name }}" href="{{ $url }}">
            {{ $name }}
        </a>
        {!! count($menu->children) ? '<i class="bi bi-chevron-right"></i>' :'' !!}
        @if(count($menu->children))
            @include('layout.menu.subpages',['childs' => $menu->children,'depth'=>$menu->depth])
        @endif
   </li>
@endforeach
</ul>
