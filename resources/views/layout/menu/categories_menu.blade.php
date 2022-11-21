<nav class="navigation bg-primary">
    <div class="d-xl-flex align-items-center justify-content-between">

        <a class="btn btn-primary text-white d-xl-none catalog_btn float-start">
            <span class="bi bi-list"></span> {{ __('categories') }}
        </a>

        <a class="btn btn-primary text-white d-xl-none pages_btn float-end">
            <span class="bi bi-list"></span> {{ __('pages') }}
        </a>

        {{-- <div class="category_menu" id="category_menu">
            <ul>
                @foreach ($categories as $category)
                    @if (empty($category->translation->name))
                        @continue
                    @endif
                    @php
                        $prefix = app()->getLocale();
                        //$category_url = count($category->children) ? __('routes.categories') : __('routes.products');
                        $category_url = __('routes.products');
                    @endphp
                    <li class="{{ request()->segment(3) == $category->translation->url ? 'active' : '' }}">
                        <a class="" href="{{ url($prefix . '/' . $category_url . '/' . $category->translation->url) }}"
                            title="{{ $category->translation->name }}">
                            {{ $category->translation->name }}
                        </a>
                        {!! count($category->children) ? '<i class="bi bi-chevron-down"></i>' : '' !!}
                        @if (count($category->children))
                            @include('layout.menu.subcategories', [
                                'childs' => $category->children,
                                'depth' => $category->depth,
                            ])
                        @endif
                    </li>
                @endforeach
            </ul>
        </div> --}}

        <div class="pages_menu m-auto" id="pages_menu">
            <ul>
                @foreach ($pages_menu as $key => $menu)
                    @php
                        if($menu->translation === NULL)
                            continue;
                        $active = ''; $disabled = '';
                        $name = !empty($menu->translation->menu_title) ? $menu->translation->menu_title : $menu->translation->name;
                        $url = $menu->type == 'page' 
                            ? app()->getLocale() . '/' . __('routes.page') . '/' . $menu->translation->url 
                            : app()->getLocale() . '/' . __('routes.' . $menu->type);
                        $active = request()->segment(2) == $menu->translation->url ? 'active' : '';
                        if (count($menu->children) > 0)
                            $active = "pe-none";
                    @endphp
                    <li class="">
                        <a class="{{ $active }} text-white" href="{{ $url }}" tabindex="-1" aria-disabled="true">
                            {{ $name }}
                        </a>
                        {!! count($menu->children) > 0 ? '<span class="bi bi-chevron-down"></span>' : '' !!}
                        @if (count($menu->children) > 0)
                            @include('layout.menu.subpages', ['childs' => $menu->children])
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

    </div>
</nav>
