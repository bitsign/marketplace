@extends('admin.layout.app')
@section('content')
@include ('admin/layout/page-header',['page_title'=>$page_title])
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">

        @include('admin.orders.filter-form')

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
                                <th>{{ __('status') }}</th>
                                <th>{{ __('admin.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!empty($orders))
                                @foreach($orders as $o)
                                    <tr>
                                    <td>{{ $o['id'] }}</td>
                                    <td>{{ !empty($o->name) ? $o->name : "Törölt felhasználó" }}
                                        {{ $o->phone }}<br />
                                        {{ $o->email }}<br />
                                    </td>
                                    <td>
                                        <span class="text-success">
                                            {{ $o->zip }}, {{ $o->city }},
                                            {{ $o->location }}
                                            {{ $o->state }}
                                        </span>
                                    </td>
                                    <td>{{ $o['created_at'] }}</td>
                                    <td>{{ currency_format($o['total'],$o['currency']) }}</td>
                                    <td>{{ currency_format($o['shipping_cost'],$o['currency']) }}</td>
                                    <td><span class="badge" style="background-color:{{ $o['color']}};">{{ $o['status_name']}}</span></td>
                                    <td>
                                        <a class="btn btn-xs btn-info" href="{{ route('orders.edit',$o['id']) }}">
                                            <i class="bi bi-tools"></i>
                                        </a>
                                        <a class="btn btn-xs btn-danger" onclick="javascript:return confirm('{{ __('admin.msg_are_you_sure') }}');" href="{{ route('orders.soft-delete',$o['id']) }}">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>

                        <div class="card-footer">
                            <!--form>
                                <input type="hidden" name="export" value="1" />
                                <button class="btn btn-primary" type="submit">{{ __('admin.export_orders') }}</button>
                            </form-->
                        </div>
                        <div class="pagination my-4">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
