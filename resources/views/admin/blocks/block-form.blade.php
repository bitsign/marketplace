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
                        <form method="post" action="{{ route('blocks.update',$block) }}" class="form-horizontal" role="form" id="block_form">
                            @method('PUT')
                        @else
                        <form method="post" action="{{ route('blocks.store') }}" class="form-horizontal" role="form" id="block_form">
                        @endif
                        @csrf

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.name') }} <code>*</code></label>
                            <div class="col-lg-8">
                                <input name="name" type="text" value="{{ !empty($block['name']) ? $block['name'] : old('name') }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.title') }} <code>*</code></label>
                            <div class="col-lg-8">
                                @foreach (config('app.available_locales') as $lang)
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"><img src="{{ url('assets/img/' . $lang . '.png') }}"
                                                width="18px"></span>
                                        <input name="translations[title][{{ $lang }}]" type="text"
                                            value="{{ $translations['title'][$lang] ?? '' }}" class="form-control" required>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.content') }} <code>*</code></label>
                            <div class="col-lg-8">
                                @foreach (config('app.available_locales') as $lang)
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"><img src="{{ url('assets/img/' . $lang . '.png') }}"
                                                width="18px"></span>
                                        <input name="translations[content][{{ $lang }}]" type="text"
                                            value="{{ $translations['content'][$lang] ?? '' }}" class="form-control">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.image') }}</label>
                            <div class="col-lg-8">
                                <div class="input-group col-lg-12">
                                    <input id="fieldID" type="text" value="{{ !empty($block['image']) ? $block['image'] : old('image') }}" name="image" class="form-control">
                                    <span class="input-group-btn">
                                    <a class="btn btn-primary iframe-btn" type="button" href="{{ URL::to('/assets/admin/plugins/filemanager/dialog.php') }}?type=1&subfolder=&field_id=fieldID">{{ __('admin.select_image') }}</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.active') }}?</label>
                            <div class="col-lg-8">
                                <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="{{ __('yes') }}" data-off="{{ __('no') }}" data-toggle="toggle" name="active" value="1" {{ !empty($block['active']) || empty($block['id']) ? 'checked' : '' }}/>
                            </div>
                        </div>
                        <hr />
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"></label>
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
