@php
    $template =  'layout.page';
    $params   =  ['page_title'=>'429 '.__('Too Many Requests')];
@endphp
@extends($template,$params)
@section('content')
<div class="col-xl-12 col-md-6 my-4">
    <div class="card shadow mx-auto border-danger" style="width:33%">
        <div class="card-header">
            429
        </div>
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col-lg-12">
                    {{ __('auth.throttle',['seconds'=>60]) }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
