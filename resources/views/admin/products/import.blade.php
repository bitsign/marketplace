@extends('admin.layout.app')
@section('content')
@include ('admin/layout/page-header',['page_title'=>$page_title])
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header">
                {{ $page_title }}
            </div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-lg-12">
                        @include('layout/messages')
                    </div>
                    <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" id="fileUploadForm">
                        @csrf
                        <input type="file" name="file" class="form-control">
                        <br>
                        <button class="btn btn-success">{{ __('admin.product_import') }}</button>
                    
                        {{-- <div class="form-group mt-3">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                            </div>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>

        <div class="card shadow mt-3">
            <div class="card-header">
                {{ __('admin.import_translations') }}
                <form action="{{ route('products.export-tr') }}" method="post" class="float-end">
                @csrf
                <button type="submit" class="btn btn-info text-white btn-xs">{{ __('admin.export_translations') }}</button>
                </form>
            </div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <form action="{{ route('products.import-tr') }}" method="POST" enctype="multipart/form-data" id="fileUploadForm" class="float-start">
                        @csrf
                        <input type="file" name="file" class="form-control">
                        <br>
                        <button class="btn btn-primary">{{ __('admin.import_translations') }}</button>
                    </form>
                    
                </div>
            </div>
            <div class="card-footer">
                
            </div>
        </div>
    </div>
</div>
@endsection