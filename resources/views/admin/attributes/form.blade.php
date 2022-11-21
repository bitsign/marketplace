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
                            <form method="post" action="{{ route('attributes.update', $attribute) }}" class="form-horizontal"
                                role="form" id="attribute_form">
                                @method('PUT')
                            @else
                                <form method="post" action="{{ route('attributes.store') }}" class="form-horizontal"
                                    role="form" id="attribute_form">
                        @endif

                        @csrf
                        <div class="mb-3 row">
                            <label class="col-lg-2 col-form-label">{{ __('admin.name') }} <code>*</code></label>
                            <div class="col-lg-8">
                                @foreach (config('app.available_locales') as $lang)
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"><img src="{{ url('assets/img/' . $lang . '.png') }}"
                                                width="18px"></span>
                                        <input name="name[{{ $lang }}]" type="text"
                                            value="{{ $translations[$lang]['name'] ?? '' }}" class="form-control" required>
                                    </div>
                                    <input type="hidden" name="translation_id[{{ $lang }}]"
                                        value="{{ $translations[$lang]['id'] ?? '' }}">
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 control-label">{{ __('admin.parent_attribute') }} <code>*</code></label>
                            <div class="col-lg-8">
                                {!! custom_select(
                                    'attributes',
                                    'parent_id',
                                    'id',
                                    'name',
                                    false,
                                    false,
                                    $attribute['parent_id'] ?? '',
                                    [0 => __('admin.parent_attribute')],
                                    ['parent_id', 0],
                                ) !!}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 control-label">{{ __('admin.image') }}</label>
                            <div class="col-lg-8">
                                <div class="input-group col-lg-12">
                                    <input id="fieldID" type="text" value="{{ $attribute['image'] ?? '' }}"
                                        name="image" class="form-control btn-sm">
                                    <span class="input-group-btn">
                                        <a class="btn btn-primary iframe-btn" type="button"
                                            href="{{ url('assets/admin/plugins/filemanager/dialog.php?type=1&fldr=attribute_options&field_id=fieldID') }}">{{ __('admin.select_image') }}</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-lg-2 control-label">{{ __('admin.sort_order') }}</label>
                            <div class="col-lg-8">
                                <input name="sort" value="{{ $attribute['sort'] ?? 0 }}" type="text"
                                    class="form-control btn-sm">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-lg-2 control-label">{{ __('admin.filter') }}
                                {{ __('admin.attribute') }}?</label>
                            <div class="col-lg-8">
                                <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini"
                                    data-on="{{ __('yes') }}" data-off="{{ __('no') }}" data-toggle="toggle"
                                    name="is_filter" value="1"
                                    {{ @$attribute['is_filter'] == 1 || $edit === false ? 'checked' : '' }} />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-lg-2 control-label">{{ __('admin.visible_on_product_page') }}?</label>
                            <div class="col-lg-8">
                                <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini"
                                    data-on="{{ __('yes') }}" data-off="{{ __('no') }}" data-toggle="toggle"
                                    name="is_hidden" value="1"
                                    {{ @$attribute['is_hidden'] == 1 || $edit === false ? 'checked' : '' }} />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-lg-2 control-label">{{ __('admin.is_multiple') }}?</label>
                            <div class="col-lg-8">
                                <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini"
                                    data-on="{{ __('yes') }}" data-off="{{ __('no') }}" data-toggle="toggle"
                                    name="is_multiple" value="1"
                                    {{ @$attribute['is_multiple'] == 1 || $edit === false ? 'checked' : '' }} />
                            </div>
                        </div>
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

    @if ($edit !== false)
        <div class="row">
            <div class="col-xl-12 col-md-12 mb-4">
                <div class="card shadow">
                    <div class="card-header"><b>{{ __('admin.attribute_values') }}</b></div>
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <form action="{{ route('attributes.values', $attribute['id']) }}" method="POST"
                                id="attribute_values_form">
                                @csrf
                                <table class="table table-hover sortable_values datatable">
                                    <thead>
                                        <tr>
                                            <th>{{ __('admin.sort_order') }}</th>
                                            <th>ID</th>
                                            <th>{{ __('admin.name') }}</th>
                                            <th>{{ __('admin.image') }}</th>
                                            <th>Info
                                                <div class="btn btn-xs" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('admin.att_info_text') }}"><i
                                                        class="bi bi-info-circle text-primary"></i>
                                                </div>
                                            </th>
                                            <th>{{ __('admin.sort_order') }}</th>
                                            <th>{{ __('admin.operations') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($option_values->isNotEmpty())
                                            @foreach ($option_values as $ov)
                                                <tr id="item-{{ $ov->id }}">
                                                    <td><a class="handle1 btn btn-primary btn-xs"><i
                                                                class="bi bi-arrow-down-up"></i></a></td>
                                                    <td>{{ $ov->id }}</td>
                                                    <td>
                                                        <span class="hidden">{{ $ov->name }}</span>
                                                        @foreach (config('app.available_locales') as $lang)
                                                            <div class="input-group mb-1">
                                                                <span class="input-group-text"><img
                                                                        src="{{ url('assets/img/' . $lang . '.png') }}"
                                                                        width="18px"></span>
                                                                <input type="text" name="name[{{ $lang }}][]"
                                                                    class="form-control form-control-sm name_field"
                                                                    value="{{ $opt_translations[$ov->id][$lang]['name'] ?? '' }}"
                                                                    id="name-{{ $ov->id }}" required />
                                                            </div>
                                                            <input type="hidden"
                                                                name="opt_translation_id[{{ $lang }}][]"
                                                                value="{{ $opt_translations[$ov->id][$lang]['id'] ?? '' }}">
                                                        @endforeach
                                                        <input type="hidden" name="option_id[]"
                                                            value="{{ $ov->id ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <div class="input-group col-lg-12">
                                                            <input id="field-{{ $ov->id }}" type="text"
                                                                value="{{ $ov->image }}" name="image[]"
                                                                class="form-control form-control-sm">
                                                            <span class="input-group-btn">
                                                                <a class="btn btn-primary iframe-btn btn-sm"
                                                                    type="button"
                                                                    href="{{ url('assets/admin/plugins/filemanager/dialog.php?type=1&fldr=attribute_options&field_id=field-' . $ov->id) }}">{{ __('admin.select_image') }}</a>
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="hidden">{{ $ov->params }}</span>
                                                        <input type="text" name="params[]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $ov->params }}"
                                                            id="params-{{ $ov->id }}" />
                                                    </td>
                                                    <td>
                                                        <span class="hidden">{{ $ov->sort }}</span>
                                                        <input type="text" name="sort[]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $ov->sort }}" id="sort-{{ $ov->id }}">
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="btn btn-danger btn-xs del {{ $loop->index == 0 ? 'disabled' : '' }}"
                                                            title="" data-id="{{ $ov->id }}">
                                                            <i class="bi bi-trash"></i>
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td><a class="handle1 btn btn-primary btn-xs"><i
                                                            class="bi bi-arrow-down-up"></i></a></td>
                                                <td></td>
                                                <td>
                                                    @foreach (config('app.available_locales') as $lang)
                                                        <div class="input-group mb-1">
                                                            <span class="input-group-text"><img
                                                                    src="{{ url('assets/img/' . $lang . '.png') }}"
                                                                    width="18px"></span>
                                                            <input type="text" name="name[{{ $lang }}][]"
                                                                class="form-control form-control-sm name_field"
                                                                value="" id="name-{{ $loop->index }}" required />
                                                        </div>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <div class="input-group col-lg-12">
                                                        <input id="field-1" type="text" value=""
                                                            name="image[]" class="form-control opt_img">
                                                        <span class="input-group-btn">
                                                            <a class="btn btn-primary iframe-btn" type="button"
                                                                href="{{ url('assets/admin/plugins/filemanager/dialog.php?type=1&fldr=attribute_options&field_id=field-1') }}">{{ __('admin.select_image') }}</a>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="params[]" class="form-control"
                                                        value="" id="params">
                                                </td>
                                                <td>
                                                    <input type="text" name="sort[]" class="form-control"
                                                        value="" id="sort">
                                                </td>
                                                <td>
                                                    <span class="btn btn-danger btn-xs del disabled" title=""><i
                                                            class="bi bi-trash"></i></span>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <div class="box-footer clearfix">
                                    <button type="button" class="btn btn-primary" id="add_value"><i
                                            class="bi bi-plus"></i> {{ __('admin.new_value') }}</button>
                                    <button type="submit" class="btn btn-success"><i class="bi bi-save"></i>
                                        {{ __('admin.save') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
