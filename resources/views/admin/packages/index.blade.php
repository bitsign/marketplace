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
                        <table class="table table-striped table-hover sortable">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.sort_order') }}</th>
                                    <th>{{ __('admin.name') }}</th>
                                    <th>{{ __('admin.products') }}</th>
                                    <th>{{ __('price') }}</th>
                                    <th class="text-end">{{ __('admin.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(count($packages) > 0)
                                @foreach ($packages as $package)
                                <tr id="item-{{$package->id}}">
                                    <td><a class="handle1 btn btn-primary btn-xs"><i class="bi bi-arrow-down-up"></i></a></td>
                                    <td>
                                        <a href="{{ route('packages.edit',$package->id) }}">
                                            {{ $package->name }}
                                        </a>
                                    </td>
                                    <td>{{ $package->product_nr == 0 ? __('admin.unlimited') : $package->product_nr }}</td>
                                    <td>{{ $package->action_price!=0 ? $package->action_price : $package->price}}</td>
                                    <td>
                                        <div class="btn-group" style="float:right">
                                            <a class="btn btn-primary btn-xs" href="{{ route('packages.edit',$package->id) }}"><i class="bi bi-tools"></i></a>
                                            <form action="{{ route('packages.destroy', $package->id) }}" method="post">
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