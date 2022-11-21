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
                        <form method="post" action="{{ route('statuses.update',$status) }}" class="form-horizontal" role="form" id="status_form">
                            @method('PUT')
                        @else
                        <form method="post" action="{{ route('statuses.store') }}" class="form-horizontal" role="form" id="status_form">
                        @endif
                        @csrf

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-end">{{ __('admin.name') }}</label>
                            <div class="col-lg-10">
                                @foreach (config('app.available_locales') as $lang)
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"><img src="{{ url('assets/img/' . $lang . '.png') }}"
                                                width="18px"></span>
                                        <input name="name[{{ $lang }}]" type="text"
                                            value="{{ $translations[$lang] ?? '' }}" class="form-control" required>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-end">{{ __('admin.color') }}</label>
                            <div class="col-lg-10">
                                <input type="color" class="form-control form-control-color" id="color" value="{{ !empty($status['color']) ? $status['color'] : old('color') }}" name="color">
                            </div>
                        </div>
                        <hr />
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-end"></label>
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary">{{ __('admin.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
