@extends('admin.layout.app')
@section('content')
    @include ('admin/layout/page-header', ['page_title' => $page_title])
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header"><b>{{ $page_title }}</b></div>
                <div class="card-body">
                    <div class="row no-gutters align-items-center">

                        <div class="col-lg-12">@include('layout/messages')</div>

                        @if ($edit === true)
                            <form method="post" action="{{ route('banners.update', $banner) }}" class="form-horizontal"
                                role="form" id="banner_form">
                                @method('PUT')
                        @else
                            <form method="post" action="{{ route('banners.store') }}" class="form-horizontal"
                                role="form" id="banner_form">
                        @endif

                        @csrf
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.type') }} <code>*</code></label>
                            <div class="col-lg-8">
                                <select name="group_id" class="form-control" required>
                                    <option value="">{{ __('please_select') }}...</option>
                                    @foreach ($banner_groups as $type)
                                        <option value="{{ $type->id }}" @selected($type->id == @$banner['group_id'])>
                                            {{ $type->title }}
                                        </option>
                                    @endforeach
                                </select>
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
                            <label class="col-lg-2 text-lg-end">{{ __('admin.content') }}</label>
                            <div class="col-lg-8">
                                @foreach (config('app.available_locales') as $lang)
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"><img src="{{ url('assets/img/' . $lang . '.png') }}"
                                                width="18px"></span>
                                        <input name="translations[description][{{ $lang }}]" type="text"
                                            value="{{ $translations['description'][$lang] ?? '' }}" class="form-control" required>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-lg-2 text-lg-end">Link</label>
                            <div class="col-lg-8">
                                @foreach (config('app.available_locales') as $lang)
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"><img src="{{ url('assets/img/' . $lang . '.png') }}"
                                                width="18px"></span>
                                        <input name="translations[url][{{ $lang }}]" type="text"
                                            value="{{ $translations['url'][$lang] ?? '' }}" class="form-control">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.image') }}</label>
                            <div class="col-lg-8">
                                <div class="input-group col-lg-12">
                                    <input id="fieldID" type="text" value="{{ $banner['image'] ?? '' }}"
                                        name="image" class="form-control" required>
                                    <span class="input-group-btn">
                                        <a class="btn btn-primary iframe-btn" type="button"
                                            href="{{ URL::to('/assets/admin/plugins/filemanager/dialog.php') }}?type=2&fldr=banners&subfolder=&field_id=fieldID">{{ __('admin.select_image') }}</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-2">
                            <label class="col-lg-2 text-lg-end">Alt tag</label>
                            <div class="col-lg-8">
                                @foreach (config('app.available_locales') as $lang)
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"><img src="{{ url('assets/img/' . $lang . '.png') }}"
                                                width="18px"></span>
                                        <input name="translations[alt][{{ $lang }}]" type="text"
                                            value="{{ $translations['alt'][$lang] ?? '' }}" class="form-control">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.active') }}?</label>
                            <div class="col-lg-8">
                                <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini"
                                    data-on="{{ __('yes') }}" data-off="{{ __('no') }}" data-toggle="toggle"
                                    name="active" value="1"
                                    {{ @!empty($banner['active']) || empty($banner['id']) ? 'checked' : '' }} />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.sort_order') }}</label>
                            <div class="col-lg-8">
                                <input name="sort" value="{{ $banner['sort'] ?? 0 }}" type="text"
                                    class="form-control" placeholder="Sorrend">
                            </div>
                        </div>
                        <hr />
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"></label>
                            <div class="col-lg-9">
                                <button type="submit"
                                    class="btn btn-primary">{{ $edit === false ? __('admin.upload') : __('admin.save') }}</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
