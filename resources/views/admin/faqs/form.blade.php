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
                        <form method="post" action="{{ route('faqs.update',$faq) }}" class="form-horizontal" role="form" id="faq_form">
                            @method('PUT')
                        @else
                        <form method="post" action="{{ route('faqs.store') }}" class="form-horizontal" role="form" id="faq_form">
                        @endif
                        @csrf
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-end">{{ __('admin.question') }} <code>*</code></label>
                            <div class="col-lg-10">
                            @foreach (config('app.available_locales') as $lang)
                                <div class="input-group mb-1">
                                    <span class="input-group-text"><img src="{{ url('assets/img/' . $lang . '.png') }}"
                                            width="18px"></span>
                                    <input name="translations[name][{{ $lang }}]" type="text"
                                        value="{{ $translations['name'][$lang] ?? '' }}" class="form-control" required>
                                </div>
                            @endforeach
                            </div>
                        </div>
                        @foreach (config('app.available_locales') as $lang)
                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end">{{ __('admin.content') }} <img
                                        src="{{ url('assets/img/' . $lang . '.png') }}" width="18px"></label>
                                <div class="col-lg-10">
                                    <textarea id="editor1" class="editor form-control" name="translations[content][{{ $lang }}]" rows="10" cols="80" required>{{ $translations['content'][$lang] ?? '' }}</textarea>
                                </div>
                            </div>
                        @endforeach
                        <hr />
                        <div class="mb-3 row">
                            <label class="col-lg-2 col-form-label"></label>
                            <div class="col-lg-9">
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
