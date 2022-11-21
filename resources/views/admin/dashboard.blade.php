@extends('admin.layout.app')
@section('content')
@include ('admin/layout/page-header',['page_title'=>$page_title])
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header">{{$page_title}}</div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-lg-12">@include('layout/messages')</div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
