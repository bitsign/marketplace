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
                    <form method="post" action="{{ route('portfolios.update',$portfolio) }}" class="form-horizontal" role="form" id="portfolio_form">
                        @method('PUT')
                        @csrf

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.title') }} <code>*</code></label>
                            <div class="col-lg-10">
                               @foreach (config('app.available_locales') as $lang)
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"><img src="{{ url('assets/img/' . $lang . '.png') }}"
                                                width="18px"></span>
                                        <input name="name[{{ $lang }}]" type="text" value="{{ $translations[$lang]['name'] ?? '' }}" class="form-control" required>
                                        <input type="hidden" name="translation_id[{{ $lang }}]"
                                        value="{{ $translations[$lang]['id'] ?? '' }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @foreach (config('app.available_locales') as $lang)
                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end">{{ __('admin.description') }} <img
                                        src="{{ url('assets/img/' . $lang . '.png') }}" width="18px"></label>
                                <div class="col-lg-10">
                                    <textarea class="editor form-control" name="description[{{ $lang }}]" rows="10" cols="80">{{ $translations[$lang]['description'] ?? '' }}</textarea>
                                </div>
                            </div>
                        @endforeach

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.image') }}</label>
                            <div class="col-lg-10">
                                <div class="input-group col-lg-12">
                                    <input id="fieldID" type="text" value="{{ $portfolio->image }}" name="image" class="form-control">
                                    <span class="input-group-btn">
                                        <a class="btn btn-primary iframe-btn" type="button" href="{{ URL::to('/assets/admin/plugins/filemanager/dialog.php') }}?type=1&fldr=portfolio&field_id=fieldID">{{ __('admin.select_image') }}</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.sort_order') }}</label>
                            <div class="col-lg-10">
                                <input name="sort" value="{{ $portfolio->sort }}" type="number" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.meta_title') }}</label>
                            <div class="col-lg-10">
                                @foreach (config('app.available_locales') as $lang)
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"><img src="{{ url('assets/img/' . $lang . '.png') }}"
                                                width="18px"></span>
                                        <input name="meta_title[{{ $lang }}]" type="text" value="{{ $translations['meta_title'][$lang] ?? '' }}" class="form-control">
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
                                        <input name="meta_description[{{ $lang }}]" type="text" value="{{ $translations['meta_description'][$lang] ?? '' }}" class="form-control">
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
                                        <input name="meta_keywords[{{ $lang }}]" type="text" value="{{ $translations['meta_keywords'][$lang] ?? '' }}" class="form-control">
                                    </div>
                                @endforeach
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

<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header"><b>+ {{ __('admin.add_image') }}</b></div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                <form action="{{ url('admin/portfolio/upload-images/'.$portfolio->id) }}" class="form-horizontal" role="form" id="portfolio_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="col-lg-12">
                            <input id="file-1" type="file" multiple name="image[]" data-browse-on-zone-click="true">
                            max. 4mb
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-8">
                            <button type="submit" class="btn btn-primary">{{ __('admin.upload') }}</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if(count($images) > 0)
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header"><b>{{ __('admin.uploaded_images') }}</b></div>
            <div class="card-body">
                <div class="row align-items-center">
                    @foreach ($images as $img)
                    <div class="card m-2" style="width: 18rem;">
                        <div class="alert alert-success hidden" id="alerts_{{ $img['id'] }}" role="alert"></div>
                        <div class="alert alert-danger hidden" id="alertd_{{ $img['id'] }}" role="alert"></div>
                        <img class="" style="max-height:150px" src="{{ url('files/portfolio/thumbs/'.$img['image']) }}">
                        <div class="card-body">
                           <label for="default_{{ $img['id'] }}" class="label mt-2">
                                <input type="radio" name="default" class="set_default" id="default_{{ $img['id'] }}" {{ $img['featured'] == 1 ? " checked " : "" }} value="1">
                                {{ __('default') }}
                            </label>
                            <a class="btn btn-danger btn-xs float-end delete_image mt-2" 
                                id="delete_{{ $img['id'] }}" 
                                data-msg_confirm="{{ __('admin.msg_are_you_sure') }}"
                                href="#">
                                <i class="icon-trash icon-white"></i> {{ __('delete') }}
                            </a>
                            <hr>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="text" id="title_{{ $img['id'] }}" value="{{ $img['name'] }}" placeholder="{{ __('admin.title') }}" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <select class="form-select select2" name="tags[]" id="tags_{{ $img['id'] }}" multiple>
                                        <option value="" 
                                            {{ !empty(explode(',', $img['tags'])) ? '' : 'selected' }}>
                                            {{ __('tags') }}
                                        </option>
                                        @foreach($terms as $term)
                                            <option value="{{ $term->term_key }}" 
                                                {{ in_array($term->term_key, explode(',', $img['tags'])) ? 'selected' : '' }} 
                                                >
                                                {{ $term->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <button 
                                type="button" 
                                id="save_{{ $img['portfolio_id'] }}_{{ $img['id'] }}" 
                                class="save_image col-md-12 btn btn-primary"
                                data-msg_success="{{ __('admin.msg_updated', ['name' => __('admin.image')]) }}"
                                data-msg_danger="{{ __('admin.msg_no_change') }}">
                                {{ __('admin.save') }}
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
