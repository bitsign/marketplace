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
                        <form method="post" action="{{ route('team.update',$team) }}" class="form-horizontal" role="form" id="team_form">
                            @method('PUT')
                        @else
                        <form method="post" action="{{ route('team.store') }}" class="form-horizontal" role="form" id="team_form">
                        @endif
                        @csrf

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-end">{{ __('admin.name') }} <code>*</code></label>
                            <div class="col-lg-10">
                                <input name="name" type="text" value="{{ !empty($team['name']) ? $team['name'] : old('name') }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-end">{{ __('admin.occupation') }}</label>
                            <div class="col-lg-10">
                                @foreach (config('app.available_locales') as $lang)
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"><img src="{{ url('assets/img/' . $lang . '.png') }}"
                                                width="18px"></span>
                                        <input name="translations[occupation][{{ $lang }}]" type="text"
                                            value="{{ $translations['occupation'][$lang] ?? '' }}" class="form-control" required>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @foreach (config('app.available_locales') as $lang)
                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end">{{ __('admin.description') }} <img
                                        src="{{ url('assets/img/' . $lang . '.png') }}" width="18px"></label>
                                <div class="col-lg-10">
                                    <textarea class="editor form-control" name="translations[intro][{{ $lang }}]" rows="10" cols="80">{{ $translations['intro'][$lang] ?? '' }}</textarea>
                                </div>
                            </div>
                        @endforeach

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-end">Facebook link</label>
                            <div class="col-lg-10">
                                <input name="contact" type="text" value="{{ !empty($team['contact']) ? $team['contact'] : old('contact') }}" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 col-form-label">{{ __('admin.image') }}</label>
                            <div class="col-lg-10">
                                <div class="input-group col-lg-12">
                                    <input id="fieldID" type="text" value="{{ !empty($team['image']) ? $team['image'] : old('image') }}" name="image" class="form-control">
                                    <span class="input-group-btn">
                                    <a class="btn btn-primary iframe-btn" type="button" href="{{ URL::to('/assets/admin/plugins/filemanager/dialog.php') }}?type=1&subfolder=&field_id=fieldID">{{ __('admin.select_image') }}</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-lg-2  text-end">{{ __('admin.active') }}?</label>
                            <div class="col-lg-10">
                                <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="{{ __('yes') }}" data-off="{{ __('no') }}" data-toggle="toggle" name="active" value="1" {{ !empty($team['active']) || empty($team['id']) ? 'checked' : '' }}/>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-end">{{ __('admin.sort_order') }}</label>
                            <div class="col-lg-10">
                                <input name="sort" type="number" value="{{ !empty($team['sort']) ? $team['sort'] : old('sort') }}" class="form-control">
                            </div>
                        </div>
                        <hr />
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-end"></label>
                            <div class="col-lg-10">
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
