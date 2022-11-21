<footer id="footer" class="footer bg-dark text-white">

    <div class="footer-content">
        <div class="container py-5">
            <div class="row">

                <div class="col-lg-4 col-md-6 footer-links">
                    <h4 class="mb-3">{{ __('useful_links') }}</h4>
                    <ul>
                        @foreach($info_menu as $info_page)
                        @php  
                        if($info_page->translation === NULL)
                            continue;
                        $url = $info_page->type == 'page' 
                                ? app()->getLocale() . '/' . __('routes.page') . '/' . $info_page->translation->url 
                                : app()->getLocale() . '/' . __('routes.' . $info_page->type); 
                        @endphp
                        <li><i class="bi bi-chevron-right"></i> <a href="{{ url($url) }}">{{ $info_page->translation->name }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6 footer-links">
                    <h4 class="mb-3">{{ __('pages') }}</h4>
                    <ul>
                        @foreach($foot_pages as $page)
                        @php  
                         if($page->translation === NULL)
                            continue;
                        $url = $page->type == 'page' 
                                ? app()->getLocale() . '/' . __('routes.page') . '/' . $page->translation->url 
                                : app()->getLocale() . '/' . __('routes.' . $page->type); 
                        @endphp
                        <li><i class="bi bi-chevron-right"></i> <a href="{{ url($url) }}">{{ $page->translation->name }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="footer-info">
                        <h3>{{ SHOP_NAME }}</h3>
                        <p>
                            {{ SHOP_ADDRESS }} <br>
                            <strong>{{ __('phone') }}:</strong> {{ SHOP_PHONE }}<br>
                            <strong>{{ __('email') }}:</strong> {{ SHOP_MAIL }}<br>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        &copy; {{ date('Y') > 2022 ? "2022 - {date('Y')}" : '2022' }}. {{ __('all_rights')}} <a class="text-white" href="{{ url('/') }}">{{ SHOP_NAME }}</a>
        @if(config('app.env') == 'local')
        <br>
        <small class="text-muted">Test mode - Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</small>
        @endif
    </div>
</footer>
