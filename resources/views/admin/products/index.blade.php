@extends('admin.layout.app')
@section('content')
@include ('admin/layout/page-header',['page_title'=>$page_title])
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">

        @include('admin.products.components.filter-form')

        <div class="card shadow">
            <div class="card-header">
                {{ $page_title }}
            </div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-lg-12">
                        @include('layout/messages')
                    </div>
                    <div class="table-responsive">
                        <form action="{{ route('products.export') }}" method="post">
                        @csrf
                        <table class="table table-striped table-hover" id="product_list">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" name="select_all" id="product_list_select_all" class="" onclick="$(this).closest('table').find('input[type=checkbox]').prop('checked',$(this).prop('checked'));">
                                    </th>
                                    <th>Id</th>
                                    <th>{{ __('admin.product_name') }}</th>
                                    <th>{{ __('admin.product_number') }}</th>
                                    <th>{{ __('admin.category') }}</th>
                                    <th>{{ __('admin.published') }}?</th>
                                    <th>{{ __('admin.featured') }}?</th>
                                    <th>{{ __('admin.created') }}</th>
                                    <th>{{ __('admin.updated') }}</th>
                                    <th class="text-end">{{ __('admin.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!empty($products))
                                @foreach ($products as $product)
                                <tr id="item-{{ $product['id'] }}">
                                    <td><input type="checkbox" name="product_ids[]" value="{{ $product['id'] }}"></td>
                                    <td>{{ $product['id'] }}</td>
                                    <td>
                                        <a href="{{ route('products.edit',$product['id']) }}">
                                            {{ Str::words($product['name'], 3, '...') }}
                                        </a>
                                    </td>
                                    <td>{{ $product['product_number'] }}</td>
                                    <td>
                                        {!! $product['category_name'] ?? '' !!}
                                    </td>
                                    <td>
                                        {!! $product['published'] == 1 ? "<span class='badge bg-success'>".__('yes')."</span>" : "<span class='badge bg-success'>".__('no')."</span>" !!}
                                    </td>
                                    <td>
                                        {!! $product['featured'] == 1 ? "<span class='badge bg-success'>".__('yes')."</span>" : ""!!}
                                    </td>
                                    <td>{{ $product['created_at'] }}</td>
                                    <td>{{ $product['updated_at'] }}</td>
                                    <td>
                                        <div class="btn-group" style="float:right">
                                            <a class="btn btn-primary btn-xs" href="{{ route('products.edit',$product['id']) }}">
                                                <i class="bi bi-tools"></i>
                                            </a>
                                            <a class="btn btn-danger btn-xs" href="{{ route('products.delete', $product['id']) }}" onclick="return confirm('{{ __('admin.msg_are_you_sure') }}')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="7">{{ __('admin.no_data') }}</td>
                            </tr>
                            @endif
                            </tbody>

                        </table>
                        
                        <div class="pagination my-4">
                            {{ $products->links() }}
                        </div>
                        <button type="submit" class="btn btn-primary btn-xs">{{ __('admin.export') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
