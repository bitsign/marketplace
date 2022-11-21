@extends('admin.layout.app')
@section('content')
@include ('admin/layout/page-header',['page_title'=>$page_title])
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header">{{$page_title}}</div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-lg-12">@include('layout/messages')</div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="datatable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th width="250px">{{ __('admin.title') }}</th>
                                    <th>Url</th>
                                    <th class="text-end">{{ __('admin.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($terms))
                                @foreach ($terms as $term)
                                <tr>
                                    <td>{{ $term['id'] }}</td>
                                    <td><a href="terms/{{ $term['id'] }}">{{ $term['name'] }}</a></td>
                                    <td>{{ $term['url'] }}</td>
                                    <td>
                                        <div class="btn-group" style="float:right">
                                            <a class="btn btn-primary btn-xs" href="terms/{{ $term['id'] }}"><i class="bi bi-tools"></i></a>
                                            <form action="{{ route('terms.destroy', $term) }}" method="post">
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
