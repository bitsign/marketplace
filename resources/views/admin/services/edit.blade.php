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

                        <form method="post" action="{{ route('services.update', $service) }}" class="form-horizontal"
                            role="form" id="service_form">
                            @method('PUT')
                            @csrf
                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end">{{ __('admin.title') }} <code>*</code></label>
                                <div class="col-lg-10">
                                    @foreach (config('app.available_locales') as $lang)
                                        <div class="input-group mb-1">
                                            <span class="input-group-text"><img src="{{ url('assets/img/' . $lang . '.png') }}"
                                                    width="18px"></span>
                                            <input name="name[{{ $lang }}]" type="text"
                                                value="{{ !empty($translations[$lang]['name']) ? $translations[$lang]['name'] : '' }}"
                                                class="form-control" required>
                                        </div>
                                        <input type="hidden" name="translation_id[{{ $lang }}]"
                                            value="{{ !empty($translations[$lang]['id']) ? $translations[$lang]['id'] : '' }}">
                                    @endforeach
                                </div>
                            </div>

                            @foreach (config('app.available_locales') as $lang)
                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end">{{ __('admin.content') }} <img
                                            src="{{ url('assets/img/' . $lang . '.png') }}" width="18px"></label>
                                    <div class="col-lg-10">
                                        <textarea id="editor1" class="editor form-control" name="content[{{ $lang }}]" rows="10" cols="80">{{ @!empty($translations[$lang]['content']) ? $translations[$lang]['content'] : '' }}</textarea>
                                    </div>
                                </div>
                            @endforeach


                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end">{{ __('admin.meta_description') }}</label>
                                <div class="col-lg-10">
                                    @foreach (config('app.available_locales') as $lang)
                                        <div class="input-group mb-1">
                                            <span class="input-group-text"><img src="{{ url('assets/img/' . $lang . '.png') }}"
                                                    width="18px"></span>
                                            <input name="meta_description[{{ $lang }}]" type="text"
                                                value="{{ !empty($translations[$lang]['meta_description']) ? $translations[$lang]['meta_description'] : '' }}"
                                                class="form-control">
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
                                            <input name="meta_keywords[{{ $lang }}]" type="text"
                                                value="{{ !empty($translations[$lang]['meta_keywords']) ? $translations[$lang]['meta_keywords'] : '' }}"
                                                class="form-control">
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end">{{ __('admin.menu_title') }}</label>
                                <div class="col-lg-10">
                                    @foreach (config('app.available_locales') as $lang)
                                        <div class="input-group mb-1">
                                            <span class="input-group-text"><img src="{{ url('assets/img/' . $lang . '.png') }}"
                                                    width="18px"></span>
                                            <input name="menu_title[{{ $lang }}]" type="text"
                                                value="{{ !empty($translations[$lang]['menu_title']) ? $translations[$lang]['menu_title'] : '' }}"
                                                class="form-control">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <hr>

                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end">{{ __('admin.image') }}</label>
                                <div class="col-lg-10">
                                    <div class="input-group col-lg-12">
                                        <input id="fieldID" type="text"
                                            value="{{ @!empty($service['image']) ? $service['image'] : '' }}"
                                            name="image" class="form-control">
                                        <span class="input-group-btn">
                                            <a class="btn btn-primary iframe-btn" type="button"
                                                href="{{ URL::to('/assets/admin/plugins/filemanager/dialog.php') }}?type=1&subfolder=&field_id=fieldID">{{ __('admin.select_image') }}</a>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end">{{ __('admin.active') }}?</label>
                                <div class="col-lg-10">
                                    <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini"
                                        data-on="{{ __('yes') }}" data-off="{{ __('no') }}" data-toggle="toggle"
                                        name="active" value="1"
                                        {{ !empty($service['active']) || empty($service['id']) ? 'checked' : '' }} />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end">{{ __('admin.sort_order') }}</label>
                                <div class="col-lg-10">
                                    <input name="sort" value="{{ $service['sort'] ?? 0 }}" type="text"
                                        class="form-control">
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
