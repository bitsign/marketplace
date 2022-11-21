@extends('layout.page')
@section('content')
<section class="section profile">
    <div class="container">
    <div class="row my-3">
        @include('layout.messages')
 
        @include('vendors.sidebar')

        <div class="col-md-9">
            <div class="card border-0">
                <div class="card-body pt-3">
                   @if(count($sales) > 0)
                    <table class="table table-striped table-bordered table-hover" id="orders_table">
                        <thead>
                            <tr>
                            <th>#ID</th>
                            <th>{{ __('date') }}</th>
                            <th>{{ __('total') }}</th>
                            <th>{{ __('admin.shipping') }}</th>
                            <th>{{ __('status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($sales as $o)
                            @php $status = json_decode($o->statuses->translations,true) @endphp
                            <tr>
                            <td>{{ $o['id'] }}</td>
                            <td>{{ $o['created_at'] }}</td>
                            <td>{{ currency_format($o['total'],$o['currency']) }}</td>
                            <td>{{ currency_format($o['shipping_cost'],$o['currency']) }}</td>
                            <td>
                                <span class="badge" style="background-color:{!! $o->statuses->color !!};">{{ $status[$o['lang']] }}</span>
                            </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                    {{ __('No Data') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection
