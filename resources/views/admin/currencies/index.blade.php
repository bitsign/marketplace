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
                        <table class="table table-striped table-hover datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.name') }}</th>
                                    <th>{{ __('admin.code') }}</th>
                                    <th>{{ __('admin.symbol') }}</th>
                                    <th>{{ __('admin.format') }}</th>
                                    <th>{{ __('admin.exchange_rate') }}</th>
                                    <th>{{ __('admin.active') }}</th>
                                    <th>{{ __('admin.default') }}</th>
                                    <th class="text-end">{{ __('admin.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(count($currencies) > 0)
                                @foreach ($currencies as $currency)
                                    @if($currency->updated_at != $currency->created_at) 
                                        @php $last_update = $currency->updated_at; @endphp
                                    @endif
                                <tr {!! $currency->exchange_rate == 1 ? 'class="table-success"' : '' !!}>
                                    <td>{{ $currency->name }}</td>
                                    <td>{{ $currency->code }}</td>
                                    <td>{{ $currency->symbol }}</td>
                                    <td>{{ $currency->format }}</td>
                                    <td>{{ $currency->exchange_rate }}</td>
                                    <td>{!! $currency->active == 1
                                            ? '<span class="badge bg-success">' . __('yes') . '</span>'
                                            : '<span class="badge bg-danger">' . __('no') . '</span>' !!}
                                    </td>
                                    <td>{!! $currency->exchange_rate == 1
                                            ? '<span class="badge bg-success">' . __('admin.default') . '</span>'
                                            : '' !!}
                                    </td>
                                    <td>
                                        <div class="btn-group" style="float:right">
                                            <a class="btn btn-primary btn-xs" href="{{ route('currencies.edit',$currency->id) }}"><i class="bi bi-tools"></i></a>
                                            <form action="{{ route('currencies.destroy', $currency->id) }}" method="post">
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
                        @php 
                            $date = new Carbon\Carbon();
                        @endphp
                        @if($date->diffInMinutes($last_update) > 5)
                            <a href="{{ route('update-exchage-rates') }}" class="btn btn-warning mb-4">
                                {{ __('admin.update_exchange_rates') }}
                            </a>
                        @endif

                        <div class="alert alert-primary d-flex align-items-center" role="alert">
                           <i class="bi bi-info-circle text-primary"></i> 
                           <div class="ms-3">{!! __('admin.currency_text') !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection