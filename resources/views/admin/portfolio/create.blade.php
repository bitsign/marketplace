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
                    <form method="post" action="{{ route('portfolios.store') }}" class="form-horizontal" role="form" id="portfolio_form">
                        @csrf

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.title') }} <code>*</code></label>
                            <div class="col-lg-10">
                               @foreach (config('app.available_locales') as $lang)
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"><img src="{{ url('assets/img/' . $lang . '.png') }}"
                                                width="18px"></span>
                                        <input name="name[{{ $lang }}]" type="text" value="" class="form-control" required>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @foreach (config('app.available_locales') as $lang)
                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end">{{ __('admin.description') }} <img
                                        src="{{ url('assets/img/' . $lang . '.png') }}" width="18px"></label>
                                <div class="col-lg-10">
                                    <textarea class="editor form-control" name="description[{{ $lang }}]" rows="10" cols="80"></textarea>
                                </div>
                            </div>
                        @endforeach

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.image') }}</label>
                            <div class="col-lg-10">
                                <div class="input-group col-lg-12">
                                    <input id="fieldID" type="text" value="" name="image" class="form-control">
                                    <span class="input-group-btn">
                                        <a class="btn btn-primary iframe-btn" type="button" href="{{ URL::to('/assets/admin/plugins/filemanager/dialog.php') }}?type=1&fldr=portfolio&field_id=fieldID">{{ __('admin.select_image') }}</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.sort_order') }}</label>
                            <div class="col-lg-10">
                                <input name="sort" value="" type="number" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.meta_title') }}</label>
                            <div class="col-lg-10">
                                @foreach (config('app.available_locales') as $lang)
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"><img src="{{ url('assets/img/' . $lang . '.png') }}"
                                                width="18px"></span>
                                        <input name="meta_title[{{ $lang }}]" type="text" value="" class="form-control">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.meta_description') }}</label>
                            <div class="col-lg-10">
                                @foreach (config('app.available_locales') as $lang)
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"><img src="{{ url('assets/img/' . $lang . '.png') }}"
                                                width="18px"></span>
                                        <input name="meta_description[{{ $lang }}]" type="text" value="" class="form-control">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.meta_keywords') }}</label>
                            <div class="col-lg-10">
                                @foreach (config('app.available_locales') as $lang)
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"><img src="{{ url('assets/img/' . $lang . '.png') }}"
                                                width="18px"></span>
                                        <input name="meta_keywords[{{ $lang }}]" type="text" value="" class="form-control">
                                    </div>
                                @endforeach
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
