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
                    <form method="post" action="{{ route('administrators.store') }}" class="form-horizontal" role="form" id="page_form">
                        @csrf

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.group') }} <code>*</code></label>
                            <div class="col-lg-8">
                                <select name="group_id" class="form-select">
                                    <option value="0">Admin</option>
                                    <option value="1">Editor</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.name') }} <code>*</code></label>
                            <div class="col-lg-8">
                                <input name="name" type="text" value="" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('email') }} <code>*</code></label>
                            <div class="col-lg-8">
                                <input name="email" type="text" value="" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('password') }} <code>*</code></label>
                            <div class="col-lg-8">
                                <input name="password" type="password" value="" class="form-control" required>
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
