@extends('admin.layout.app')
@section('content')
@include ('admin/layout/page-header',['page_title'=>$page_title])
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header"><b>{{ $page_title }}</b></div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">

                    <div class="col-lg-12">@include('layout/messages')</div>

                    @if($edit === true)
                        <form method="post" action="{{ route('terms.update',$term) }}" class="form-horizontal" role="form" id="term_form">
                        @method('PUT')
                    @else
                        <form method="post" action="{{ route('terms.store') }}" class="form-horizontal" role="form" id="term_form">
                    @endif

                    @csrf
                    <div class="mb-3 row">
                        <label class="col-lg-2 text-lg-end">{{ __('admin.name') }} <code>*</code></label>
                        <div class="col-lg-10">
                            @foreach(config('app.available_locales') as $lang)
                            <div class="input-group mb-1">
                                <span class="input-group-text"><img src="{{ url('assets/img/'.$lang.'.png') }}" width="18px"></span>
                                <input name="name[{{ $lang }}]" type="text" value="{{ !empty($terms[$lang]['name']) ? $terms[$lang]['name'] : '' }}" class="form-control" required>
                            </div>
                            <input type="hidden" name="id[{{ $lang }}]" value="{{ !empty($terms[$lang]['id']) ? $terms[$lang]['id'] : '' }}">
                            @endforeach
                        </div>
                    </div>
                    
                    <hr />
                    <div class="mb-3 row">
                        <label class="col-lg-2 text-lg-end"></label>
                        <div class="col-lg-9">
                            <button type="submit" class="btn btn-primary">{{ $edit === false ? __('admin.upload')  :  __('admin.save') }}</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
