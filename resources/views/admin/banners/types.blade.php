@extends('admin.layout.app')
@section('content')

    @include ('admin/layout/page-header', ['page_title' => $page_title])
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-3">
                <div class="card-header">{{ $page_title }} lista</div>
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-lg-12">@include('layout/messages')</div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cím</th>
                                        <th>Hosszúság (px)</th>
                                        <th>Szélesség (px)</th>
                                        <th class="text-right">Műveletek</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($banner_types))
                                        @foreach ($banner_types as $b)
                                            <tr>
                                                <td>{{ $b->id }}</td>
                                                <td>{{ $b->title }}</td>
                                                <td>{{ $b->width }}</td>
                                                <td>{{ $b->height }}</td>
                                                <td>
                                                    <div class="btn-group" style="float:right">
                                                        <a class="btn btn-success btn-xs"
                                                            href="{{ url('admin/banners/banner_types/false/' . $b->id) }}"><i
                                                                class="bi bi-tools"></i></a>
                                                        <a class="btn btn-danger btn-xs"
                                                            href="{{ url('admin/banners/banner_types/delete/' . $b->id) }}"
                                                            onclick="return confirm('Biztos hogy törlöd ezt a tartalom típust?');"><i
                                                                class="bi bi-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">Nincs adat</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-3 {{ $edit === false ? '' : 'border-success' }}">
                <div class="card-header">
                    {{ !empty($banner_type->title) ? $banner_type->title : 'Banner típus' }}
                    {{ $edit === false ? 'létrehozása' : 'szerkesztése' }}
                </div>
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        @if ($edit === true)
                            <form method="post" action="{{ url('/admin/banners/banner_types/update/' . $banner_type->id) }}"
                                class="form-horizontal" role="form" id="banner_type_form">
                            @else
                                <form method="post" action="{{ url('/admin/banners/banner_types/add/0') }}"
                                    class="form-horizontal" role="form" id="banner_type_form">
                        @endif
                        @csrf

                        <div class="mb-3 row">
                            <label class="col-lg-3 col-form-label">Banner típus neve*</label>
                            <div class="col-lg-9">
                                <input name="title" type="text" value="{{ @$banner_type->title }}"
                                    class="form-control" placeholder="Oldal típus neve">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-3 col-form-label">Szélesség*</label>
                            <div class="col-lg-9">
                                <input name="width" type="text" value="{{ @$banner_type->width }}"
                                    class="form-control" placeholder="px">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-3 col-form-label">Hosszúság</label>
                            <div class="col-lg-9">
                                <input name="height" type="text" value="{{ @$banner_type->height }}"
                                    class="form-control" placeholder="px">
                            </div>
                        </div>
                        <hr />
                        <div class="mb-3 row">
                            <label class="col-lg-3 col-form-label"></label>
                            <div class="col-lg-9">
                                <button type="submit"
                                    class="btn btn-primary">{{ $edit === false ? 'Feltölt' : 'Módosít' }}</button>
                                @if ($edit === true)
                                    <a href="{{ url('/admin/banners/banner_types/view/0') }}"
                                        class="btn btn-danger">Mégsem</a>
                                @endif
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
