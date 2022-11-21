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
                    <form method="post" action="{{ route('currencies.store') }}" class="form-horizontal" role="form" id="currencies_form">
                        @csrf

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.name') }} <code>*</code></label>
                            <div class="col-lg-8">
                                <input name="name" type="text" value="" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.code') }} <code>*</code></label>
                            <div class="col-lg-8">
                                <input name="code" type="text" value="" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.symbol') }} <code>*</code></label>
                            <div class="col-lg-8">
                                <input name="symbol" type="text" value="" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.format') }} <code>*</code></label>
                            <div class="col-lg-8">
                                <input name="format" type="text" value="" class="form-control" placeholder="Ex. $1,0.00" required>
                                <div class="help-block">
                                    <a href="https://lyften.com/projects/laravel-currency/doc/formatting.html" target="_blank" class="text-primary">{{ __('admin.description') }}</a>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.exchange_rate') }} <code>*</code></label>
                            <div class="col-lg-8">
                                <input name="exchange_rate" type="text" value="" class="form-control" required>
                                <div class="form-text">{{ __('admin.exchange_rate_default') }}</div>
                            </div>
                        </div> --}}

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.active') }}</label>
                            <div class="col-lg-8">
                                <input type="checkbox" data-onstyle="success" data-offstyle="danger"
                                    data-size="mini" data-on="{{ __('yes') }}" data-off="{{ __('no') }}"
                                    data-toggle="toggle" name="active" value="1" checked />
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
