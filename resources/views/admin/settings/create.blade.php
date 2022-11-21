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
                    <form method="post" action="{{ route('settings.store') }}" class="form-horizontal" role="form" id="settings_form">
                        @csrf

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('key') }} <code>*</code></label>
                            <div class="col-lg-8">
                                <input name="key" type="text" value="" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('value') }} <code>*</code></label>
                            <div class="col-lg-8">
                                <input name="value" type="text" value="" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('description') }}</label>
                            <div class="col-lg-8">
                                <input name="description" type="text" value="" class="form-control">
                            </div>
                        </div>

                        <hr />
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"></label>
                            <div class="col-lg-9">
                                <button type="submit" class="btn btn-primary">{{ __('admin.upload') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
