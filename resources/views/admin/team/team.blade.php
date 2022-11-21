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
                        <table class="table table-striped sortable table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.sort_order') }}</th>
                                    <th>{{ __('admin.name') }}</th>
                                    <th>{{ __('admin.active') }}?</th>
                                    <th class="text-end">{{ __('admin.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!empty($teams))
                                @foreach ($teams as $team)
                                <tr id="item-{{ $team['id'] }}">
                                    <td><a class="handle1 btn btn-primary btn-xs"><i class="bi bi-arrow-down-up"></i></a></td>
                                    <td>{{ $team['name'] }}</td>
                                    <td>{!! $team['active'] == 1 ? "<span class='badge bg-success'>". __('yes') ."</span>" : "<span class='badge bg-danger'>".__('no')."</span>" !!}</td>
                                    <td>
                                        <div class="btn-group" style="float:right">
                                            <a class="btn btn-primary btn-xs" href="team/{{ $team['id'] }}"><i class="bi bi-tools"></i></a>
                                            <form action="{{ route('team.destroy', $team) }}" method="post">
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
                                <td colspan="4">{{ __('admin.no_data') }}</td>
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
