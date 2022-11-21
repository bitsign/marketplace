@extends('admin.layout.app')
@section('content')
@include ('admin/layout/page-header',['page_title'=>$page_title])
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header">
                {{$page_title}}
            </div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-lg-12">
                        @include('layout/messages')
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped" id="datatable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>{{ __('admin.name') }}</th>
                                    <th>{{ __('admin.active') }}?</th>
                                    <th class="text-end">{{ __('admin.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!empty($manufacturers))
                                @foreach ($manufacturers as $manufacturer)
                                <tr>
                                    <td>{{ $manufacturer['id'] }}</td>
                                    <td>
                                        <a href="{{ route('manufacturers.edit',$manufacturer['id']) }}">
                                            {{ $manufacturer['name'] }}
                                        </a>
                                    </td>
                                    <td>
                                        {!! $manufacturer['active'] == 1 ? "<span class='badge bg-success'>".__('yes')."</span>" : "<span class='badge bg-danger'>".__('no')."</span>" !!}
                                    </td>
                                    <td>
                                        <div class="btn-group" style="float:right">
                                            <a class="btn btn-primary btn-xs" href="{{ route('manufacturers.edit',$manufacturer['id']) }}"><i class="bi bi-tools"></i></a>
                                            <form action="{{ route('manufacturers.destroy', $manufacturer) }}" method="post">
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
                                <td colspan="5">{{ __('admin.no_data') }}</td>
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
