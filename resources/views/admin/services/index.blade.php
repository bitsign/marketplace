@extends('admin.layout.app')
@section('content')
@include ('admin/layout/page-header',['page_title'=>$page_title])
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <b>{{ $page_title }}</b>
            </div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-lg-12">
                        @include('layout/messages')
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped sortable table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.sort_order') }}</th>
                                    <th>{{ __('admin.name') }}</th>
                                    <th>{{ __('admin.active') }}?</th>
                                    <th>{{ __('admin.created') }}</th>
                                    <th>{{ __('admin.updated') }}</th>
                                    <th class="text-end">{{ __('admin.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!empty($services))
                                @foreach ($services as $service)
                                <tr id="item-{{$service->id}}">
                                    <td><a class="handle1 btn btn-primary btn-xs"><i class="bi bi-arrow-down-up"></i></a></td>
                                    <td><a href="{{ route('services.edit',$service->id) }}">{{ $service->name }}</a></td>
                                    <td>
                                        {!! $service->active == 1 ? '<span class="badge bg-success">'.__('yes').'</span>' : '<span class="badge bg-danger">'.__('no').'</span>' !!}
                                    </td>
                                    <td>{{ $service->created_at }}</td>
                                    <td>{{ $service->updated_at }}</td>
                                    <td>
                                        <div class="btn-group" style="float:right">
                                            <a class="btn btn-primary btn-xs" href="{{ route('services.edit',$service->id) }}"><i class="bi bi-tools"></i></a>
                                            <form action="{{ route('services.destroy', $service->id) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-xs" id="delete" onclick="return confirm('{{ __('admin.msg_are_you_sure') }}')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="9">{{ __('admin.no_data') }}</td>
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
