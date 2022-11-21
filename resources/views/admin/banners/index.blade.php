@extends('admin.layout.app')
@section('content')
    @include ('admin/layout/page-header', ['page_title' => $page_title])
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header">{{ $page_title }}</div>
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-lg-12">@include('layout/messages')</div>
                        <div class="table-responsive">
                            <table class="table table-striped sortable table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin.sort_order') }}</th>
                                        <th width="250px">{{ __('admin.title') }}</th>
                                        <th>{{ __('admin.active') }}?</th>
                                        <th>{{ __('admin.image') }}</th>
                                        <th class="text-end">{{ __('admin.operations') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($banners))
                                        @foreach ($banners as $banner)
                                            <tr id="item-{{ $banner['id'] }}">
                                                <td><a class="handle1 btn btn-primary btn-xs"><i
                                                            class="bi bi-arrow-down-up"></i></a></td>
                                                <td><a href="{{ url('admin/banners/'.$banner['id']) }}">{{ $banner['title'] }}</a></td>
                                                <td>
                                                    {!! $banner['active'] == 1
                                                        ? '<span class="badge bg-success">' . __('yes') . '</span>'
                                                        : '<span class="badge bg-danger">' . __('no') . '</span>' !!}
                                                </td>
                                                <td><img src="{{ url('files/editor/' . $banner['image']) }}"
                                                        width="70px"></td>
                                                <td>
                                                    <div class="btn-group" style="float:right">
                                                        <a class="btn btn-primary btn-xs"
                                                            href="banners/{{ $banner['id'] }}"><i
                                                                class="bi bi-tools"></i></a>
                                                        <form action="{{ route('banners.destroy', $banner) }}"
                                                            method="post">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger btn-xs"
                                                                id="delete"
                                                                onclick="return confirm('{{ __('admin.msg_are_you_sure') }}')">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7">{{ __('admin.no_data') }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
