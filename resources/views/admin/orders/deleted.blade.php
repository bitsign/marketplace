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
                        <table class="table table-striped table-bordered table-hover" id="orders_table">
                            <thead>
                                <tr>
                                <th>#ID</th>
                                <th>{{ __('admin.name') }}</th>
                                <th>{{ __('address') }}</th>
                                <th>{{ __('date') }}</th>
                                <th>{{ __('total') }}</th>
                                <th>{{ __('admin.shipping') }}</th>
                                <th class="text-end">{{ __('admin.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!empty($orders))
                                @foreach($orders as $o)
                                    <tr>
                                    <td>{{ $o['id'] }}</td>
                                    <td>{{ !empty($o->user->name) ?$o->user->name : "Törölt felhasználó" }}
                                        {{ $o->user->phone }}<br />
                                        {{ $o->user->email }}<br />
                                    </td>
                                    <td>
                                        <span class="text-success">
                                            {{ $o->user->zip }}, {{ $o->user->city }},
                                            {{ $o->user->location }}
                                            {{ $o->user->state }}
                                        </span>
                                    </td>
                                    <td>{{ $o['created_at'] }}</td>
                                    <td>{{ number_format($o['total']) }}</td>
                                    <td>{{ number_format($o['shipping_cost']) }}</td>
                                    <td>
                                        <div class="btn-group" style="float:right">
                                            <a class="btn btn-xs btn-info" href="{{ route('orders.edit',$o['id']) }}">
                                                <i class="bi bi-tools"></i>
                                            </a>
                                            <form action="{{ route('orders.destroy', $o->id) }}" method="post">
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

                        <div class="card-footer">
                            <form>
                                <input type="hidden" name="export" value="1" />
                                <button class="btn btn-primary" type="submit">{{ __('admin.export_orders') }}</button>
                            </form>
                        </div>
                        <div class="pagination my-4">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
