<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<base href="{{ url('/') }}" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="{{ $meta_description ?? META_DESCRIPTION }}">
<meta name="keywords" content="{{ $meta_keywords ?? META_KEYWORDS  }}">
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title" content="{{ isset($meta_title) ? $meta_title.' | ' : ''  }} {{ SHOP_NAME }}" />
<meta property="og:description" content="{{ $meta_description ?? META_DESCRIPTION }}" />
<meta property="og:image" content="{{ !empty($og_image) ? url($og_image) : url('assets/img/logo_fb.png') }}" />
<meta property="og:image:type" content="image/jpeg" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ isset($meta_title) ? $meta_title.' | ' : ''}} {{ SHOP_NAME }}</title>
<!-- Favicons -->
<link href="{{ asset('img/favicon.ico') }}" rel="icon">

<!-- Vendor CSS Files -->
<link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">

<!-- Dynamic CSS Files -->
@if (isset($css) && (!empty($css)))
@foreach ($css as $style)
<link rel="stylesheet" href="{{ strpos($style,'http:') === false && strpos($style,'https:') === false ? url('assets/css/'.$style):$style }}">
@endforeach
@endif

<!-- Theme CSS File -->
<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<script>
var base_url = "{{ url('/').'/' }}";
var current_locale = "{{ app()->getLocale() }}";
</script>
</head>
<body class="{{ !empty($body_class) ? $body_class : '' }}">

    @include('layout.header')

    <main id="main">
        @include('layout.breadcrumbs')
        @yield('content')
    </main>

    @include('layout.footer')

    <div class="to_top" id="gotoTop">
        <div class="d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></div>
    </div>

    <script type="text/javascript" src="{{ asset('vendor/jquery/jquery-3.6.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jquery/jquery-migrate-3.4.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
    @if (app()->getLocale() != 'en')
        <script type="text/javascript" src="{{ asset('vendor/bootstrap-select/js/i18n/defaults-'.app()->getLocale().'_'.strtoupper(app()->getLocale()).'.js') }}"></script>
    @endif

    @if (isset($js) && (!empty($js)))
        @foreach ($js as $script)
    <script src="{{ strpos($script,'http') === false ? url('assets/js/'.$script):$script; }}"></script>
        @endforeach
    @endif

    <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>

    @if(!isset($_COOKIE['policy_cookie']))
    <div id="cookiePol">
        <div class="container">
            <div class="cookie_text">
                {{ __('cookie_text',['Shop_name'=>SHOP_NAME]) }}
                <a href="{{ url(app()->getLocale().'/'.__('routes.privacy_policy')) }}" target="_blank">{{ __('details') }}</a>
                <a id="accept" href="#"> OK </a>
            </div>
        </div>
    </div>
    @endif
</body>
</html>
