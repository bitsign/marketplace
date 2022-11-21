@extends('admin.layout.app')
@section('content')
    @include ('admin/layout/page-header', ['page_title' => $page_title])
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header">{{ $page_title }}</div>
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-lg-12">@include('layout/messages')</div>
                        @if ($edit === true)
                            <form method="post" action="{{ route('categories.update', $category) }}" class="form-horizontal"
                                role="form" id="category_form">
                                @method('PUT')
                            @else
                                <form method="post" action="{{ route('categories.store') }}" class="form-horizontal"
                                    role="form" id="category_form">
                        @endif
                        @csrf

                        <div class="row mb-2">
                            <label class="col-lg-2 text-end">{{ __('admin.parent_category') }}</label>
                            <div class="col-lg-10">
                                <select name="parent_id" class="form-select select2">
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ $parent == $cat->id || (empty($parent) && $cat->id == 1) ? 'selected' : '' }}>
                                            {{ $cat->translation->name ?? $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-end">{{ __('admin.active') }}?</label>
                            <div class="col-lg-8">
                                <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini"
                                    data-on="{{ __('yes') }}" data-off="{{ __('no') }}" data-toggle="toggle"
                                    name="active" value="1"
                                    {{ @!empty($category['active']) || empty($category['id']) ? 'checked' : '' }} />
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-lg-2 text-end">{{ __('admin.is_menu') }}?</label>
                            <div class="col-lg-10">
                                <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini"
                                    data-on="{{ __('yes') }}" data-off="{{ __('no') }}" data-toggle="toggle"
                                    name="show_as_menu" value="1"
                                    {{ @$category->show_as_menu == 1 || @$category->id == '' ? 'checked' : '' }} />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-end" for="name">{{ __('admin.name') }} <code>*</code></label>
                            <div class="col-lg-10">
                                @foreach (config('app.available_locales') as $lang)
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"><img src="{{ url('assets/img/' . $lang . '.png') }}"
                                                width="18px"></span>
                                        <input name="name[{{ $lang }}]" type="text"
                                            value="{{ $translations[$lang]['name'] ?? '' }}" class="form-control"
                                            required>
                                    </div>
                                    <input type="hidden" name="translation_id[{{ $lang }}]"
                                        value="{{ $translations[$lang]['id'] ?? '' }}">
                                @endforeach
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-lg-2 text-end">{{ __('admin.short_description') }}</label>
                            <div class="col-lg-10">
                                @foreach (config('app.available_locales') as $lang)
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"><img src="{{ url('assets/img/' . $lang . '.png') }}"
                                                width="18px"></span>
                                        <input name="short_description[{{ $lang }}]" type="text"
                                            value="{{ $translations[$lang]['short_description'] ?? '' }}"
                                            class="form-control" max='255'>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @foreach (config('app.available_locales') as $lang)
                            <div class="mb-2 row">
                                <label class="col-lg-2 text-end">{{ __('admin.description') }} <img
                                        src="{{ url('assets/img/' . $lang . '.png') }}" width="18px"></label>
                                <div class="col-lg-8">
                                    <textarea class="editor form-control" name="description[{{ $lang }}]" rows="10" cols="80">{{ $translations[$lang]['description'] ?? '' }}</textarea>
                                </div>
                            </div>
                        @endforeach

                        <div class="card mb-3">
                            <h5 class="card-header">{{ __('admin.seo_settings') }}</h5>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <label class="col-lg-2 text-end">{{ __('admin.meta_title') }}</label>
                                    <div class="col-lg-10">
                                        @foreach (config('app.available_locales') as $lang)
                                            <div class="input-group mb-1">
                                                <span class="input-group-text"><img
                                                        src="{{ url('assets/img/' . $lang . '.png') }}" width="18px"></span>
                                                <input name="meta_title[{{ $lang }}]" type="text"
                                                    value="{{ $translations[$lang]['meta_title'] ?? '' }}"
                                                    class="form-control">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <label class="col-lg-2 text-end">{{ __('admin.meta_description') }}</label>
                                    <div class="col-lg-10">
                                        @foreach (config('app.available_locales') as $lang)
                                            <div class="input-group mb-1">
                                                <span class="input-group-text"><img
                                                        src="{{ url('assets/img/' . $lang . '.png') }}"
                                                        width="18px"></span>
                                                <input name="meta_description[{{ $lang }}]" type="text"
                                                    value="{{ $translations[$lang]['meta_description'] ?? '' }}"
                                                    class="form-control">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <label class="col-lg-2 text-end">{{ __('admin.meta_keywords') }}</label>
                                    <div class="col-lg-10">
                                        @foreach (config('app.available_locales') as $lang)
                                            <div class="input-group mb-1">
                                                <span class="input-group-text"><img
                                                        src="{{ url('assets/img/' . $lang . '.png') }}"
                                                        width="18px"></span>
                                                <input name="meta_keywords[{{ $lang }}]" type="text"
                                                    value="{{ $translations[$lang]['meta_keywords'] ?? '' }}"
                                                    class="form-control">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>

                        @if ($edit !== false)
                            <div class="card mb-3">
                                <h5 class="card-header">{{ __('admin.sort_order') }}</h5>
                                <div class="card-body">
                                    <div class="row mb-2 ">
                                        <label class="col-sm-2 text-end"
                                            for="sibling_category">{{ __('admin.category') }}</label>
                                        <div class="col-sm-10">
                                            <select name="sibling_category" class="form-select select2">
                                                <option value="">{{ __('please_select') }}...</option>
                                                @foreach ($siblings as $sibling)
                                                    <option value="{{ $sibling->id }}">
                                                        {{ $sibling->translation->name ?? $sibling->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2 ">
                                        <label class="col-sm-2 text-end">{{ __('admin.position') }}</label>

                                        <div class="form-check col-lg-2 ms-2">
                                            <input class="form-check-input" type="radio" id="pos_before"
                                                name="category_position" value="before">
                                            <label class="form-check-label" for="pos_before">{{ __('after') }}</label>
                                        </div>

                                        <div class="form-check col-lg-2">
                                            <input class="form-check-input" type="radio" id="pos_after"
                                                name="category_position" value="after">
                                            <label class="form-check-label" for="pos_after">{{ __('before') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="card mb-3">
                            <h5 class="card-header">{{ __('admin.discount_settings') }}</h5>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <label class="col-lg-2 text-end">{{ __('admin.discount') }}(%)</label>
                                    <div class="col-lg-10">
                                        <input name="discount" type="text" value="{{ @$category['discount'] }}"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <h5 class="card-header">{{ __('admin.category') }} {{ __('admin.image') }}</h5>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <label class="col-lg-2 text-end">{{ __('admin.image') }}</label>
                                    <div class="col-lg-10">
                                        <div class="input-group col-lg-12">
                                            <input id="fieldID" type="text"
                                                value="{{ !empty($category['image']) ? $category['image'] : '' }}"
                                                name="image" class="form-control">
                                            <span class="input-group-btn">
                                                <a class="btn btn-primary iframe-btn" type="button"
                                                    href="{{ URL::to('/assets/admin/plugins/filemanager/dialog.php') }}?type=2&fldr=categories&field_id=fieldID">{{ __('admin.select_image') }}</a>
                                            </span>
                                        </div>
                                        @if (!empty($category['image']))
                                            <img src="{{ url('files/editor/' . $category['image']) }}" width="200px"
                                                class="img-fluid">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <h5 class="card-header">{{ __('admin.category_attributes') }}</h5>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <label class="col-lg-2 text-end">{{ __('admin.attributes') }}</label>
                                    <div class="col-lg-10">
                                        {!! custom_select(
                                            'attributes',
                                            'attribs[]',
                                            'id',
                                            'name',
                                            false,
                                            true,
                                            !empty($category['attributes']) ? explode(',', $category['attributes']) : '',
                                            ['' => __('please_select')],
                                            ['parent_id', 0],
                                        ) !!}
                                        <div class="small">{{ __('admin.cat_attr_info') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr />
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-end"></label>
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
