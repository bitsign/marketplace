<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $page_title ?? '' }} | Admin</title>
    <link rel="icon" href="{{ asset('admin/images/favicon.ico') }}">
    <link href="{{ asset('admin/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/bootstrap-toggle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/fonts/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet">
    @if (isset($css) && (!empty($css)))
        @foreach ($css as $cs)
        <link rel="stylesheet" href="{{ strpos($cs,'http:') === false && strpos($cs,'https:') === false ? asset('admin/css/'.$cs):$cs }}">
        @endforeach
    @endif
    <link href="{{ asset('admin/css/common.css') }}" rel="stylesheet">
    <script>
        var base_url = "{{ url('/') }}/";
        var admin_locale = "{{ config('app.admin_locale') }}";
        var all = "{{ __('all') }}";
    </script>
    </head>
    <body class="">
       <div class="wrapper">

        @include('admin.layout.menu')

        <div id="content" class="d-flex flex-column h-100">
            <nav class="navbar navbar-expand-lg bg-primary">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="bi bi-text-left"></i>
                    <span></span>
                </button>

                <div class="btn-group ms-auto me-4">
                  <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                    <span class="mx-1">
                        <i class="bi bi-person"></i>
                        <span class="d-none d-sm-inline">{{ Auth::guard('admin')->user()->name ?? "" }}</span>
                    </span>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a href="{{ Auth::guard('admin')->user() !== NULL ? route('administrators.edit',Auth::guard('admin')->user()->id) : '' }}" class="dropdown-item btn btn-default btn-flat">
                            <i class="bi bi-person-fill"></i> {{ __('admin.account') }}
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">
                            <i class="bi bi-key"></i> {{ __('logout') }}
                        </a>
                    </li>
                  </ul>
                </div>
            </nav>

            <div class="content flex-shrink-0">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            @include('admin.layout.footer')

        </div>
    </div>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="bi bi-chevron-up"></i>
    </a>

    <script src="{{ asset('admin/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('admin/js/jquery-migrate-3.3.2.js') }}"></script>
    <script src="{{ asset('admin/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
    @if (config('app.admin_locale') != 'en')
        <script src="{{ asset('admin/plugins/bootstrap-fileinput/js/locales/'.config('app.admin_locale').'.js') }}"></script>
    @endif
    <script src="{{ asset('admin/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/fancybox/source/jquery.fancybox.pack.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.validate.min.js') }}"></script>
    @if (config('app.admin_locale') != 'en')
        <script src="{{ asset('admin/js/localization/messages_'.config('app.admin_locale').'.js') }}"></script>
    @endif
    <script src="{{ asset('admin/plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('admin/js/tinymce_settings.js') }}"></script>
    @if (config('app.admin_locale') != 'en')
        <script src="{{ asset('admin/plugins/tinymce/langs/'.config('app.admin_locale').'.js') }}"></script>
    @endif
    @if (isset($scripts) && (!empty($scripts)))
        @foreach ($scripts as $script)
        <script src="{{ strpos($script,'http:') === false && strpos($script,'https:') === false ? asset('admin/js/'.$script):$script; }}"></script>
        @endforeach
    @endif
    <script src="{{ asset('admin/js/common.js') }}"></script>
  </body>
</html>
