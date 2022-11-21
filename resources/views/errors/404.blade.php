@if(strpos($_SERVER['REQUEST_URI'],'admin') !== false)
    @php
        $template =  'admin.layout.app';
        $params   =  ['page_title'=>'404'];
        app()->setLocale(config('app.admin_locale'));
    @endphp
@else
    @php
        $template =  'layout.page';
        $params   = ['meta_title'=>'404'];
    @endphp
@endif

@extends($template,$params)

@section('content')

<div class="col-xl-12 col-md-6 my-4">
    <div class="card shadow mx-auto border-danger" style="width:33%">
        <div class="card-header">
            404
        </div>
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col-lg-12">
                    {{ __('Not Found') }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection




