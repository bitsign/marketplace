@extends('admin.layout.app')
@section('content')

@include ('admin/layout/page-header',['page_title'=>$page_title])
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header"><b>{{ $product['name'] ??  $page_title; }}</b></div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-lg-12">@include('layout/messages')</div>

                    <ul class="nav nav-pills" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true">
                                {{ __('admin.general_datas') }}
                            </button>
                        </li>
                        @if(!empty($product['id']))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false">
                                {{ __('admin.images') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab0-tab" data-bs-toggle="tab" data-bs-target="#tab0" type="button" role="tab" aria-controls="tab0" aria-selected="false">
                                {{ __('admin.attributes') }}
                            </button>
                        </li>
                        <!--li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab10-tab" data-bs-toggle="tab" data-bs-target="#tab10" type="button" role="tab" aria-controls="tab10" aria-selected="false">
                                {{-- __('admin.options') --}}
                            </button>
                        </li-->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3" type="button" role="tab" aria-controls="tab3" aria-selected="false">
                                {{ __('admin.attached_products') }}
                            </button>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab4-tab" data-bs-toggle="tab" data-bs-target="#tab4" type="button" role="tab" aria-controls="tab4" aria-selected="false">
                                {{ __('admin.documents') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab5-tab" data-bs-toggle="tab" data-bs-target="#tab5" type="button" role="tab" aria-controls="tab5" aria-selected="false">
                                {{ __('admin.comments') }}
                            </button>
                        </li> --}}
                        @endif
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active  py-3" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                            @include('admin.products.components.default-form')
                        </div>
                        <div class="tab-pane fade py-3" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                            @include('admin.products.components.images-form')
                        </div>
                        <div class="tab-pane fade py-3" id="tab0" role="tabpanel" aria-labelledby="tab0-tab">
                            @include('admin.products.components.attributes-form')
                        </div>
                        <!--div class="tab-pane fade py-3" id="tab10" role="tabpanel" aria-labelledby="tab10-tab">
                            {{-- @include('admin.products.components.options-form') --}}
                        </div-->
                        <div class="tab-pane fade py-3" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                            @include('admin.products.components.attached-prods-form')
                        </div>
                        <div class="tab-pane fade py-3" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
                            {{-- @include('admin.products.components.attached-docs-form')--}}
                        </div>
                        <div class="tab-pane fade py-3" id="tab5" role="tabpanel" aria-labelledby="tab5-tab">
                             {{-- @include('admin.products.components.comments-form')--}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
