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
                                    <th>{{ __('code') }}</th>
                                    <th>{{ __('value') }}</th>
                                    <th>{{ __('info') }}</th>
                                    <th class="text-end">{{ __('admin.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(count($settings) > 0)
                                @foreach ($settings as $setting)
                                <tr>
                                    <td>{{ $setting->key }}</td>
                                    <td style="word-break: break-all;">{{ $setting->value }}</td>
                                    <td>
                                        @if(!empty($setting['description']))
                                        <button type="button" class="btn btn-default" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $setting['description'] }}">
                                            <i class="bi bi-info-circle text-primary"></i>
                                        </button>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" style="float:right">
                                            <a class="btn btn-primary btn-xs" href="{{ route('settings.edit',$setting->id) }}"><i class="bi bi-tools"></i></a>
                                            <form action="{{ route('settings.destroy', $setting->id) }}" method="post">
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