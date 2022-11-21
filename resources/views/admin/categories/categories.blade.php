@extends('admin.layout.app')
@section('content')
    @include ('admin/layout/page-header', ['page_title' => $page_title])
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header">{{ $page_title }}</div>
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-lg-12">@include('layout/messages')</div>
                        <div class="table-responsive">

                        <?php
                        $traverse = function ($categories, $prefix = '-') use (&$traverse)
                        {
                            foreach ($categories as $category)
                            {
                                $name = $category->translation->name ?? $category->name;
                                ?>
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $prefix . $name }}</td>
                                    <td><?php echo $category->active == 1 ? '<span class="badge bg-success">' . __('yes') . '</span>' : '<span class="badge bg-danger">' . __('no') . '</span>'; ?></td>
                                    <td>{{ $category->discount }}</td>
                                    <td>
                                        <div class="btn-group" style="float:right">
                                            <a href="{{ route('categories.edit',$category->id) }}" class="btn btn-primary btn-xs">
                                                <i class="bi bi-tools"></i>
                                            </a>
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-xs" id="delete" onclick="return confirm('{{ __('admin.msg_are_you_sure_category') }}')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                            
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $traverse($category->children, $prefix.'—');
                            }
                        }
                        ?>

                            <table class="table table-striped sortable table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>{{ __('admin.name') }}</th>
                                        <th>{{ __('admin.active') }}</th>
                                        <th>{{ __('admin.discount') }}</th>
                                        <th class="text-end">{{ __('admin.operations') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {!! $traverse($categories) !!}
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--button type="button" class="btn btn-danger btn-xs" data-bs-toggle="modal"
        data-bs-target="#confirm_delete" data-id="{{-- $category->id --}}">
        <i class="bi bi-trash"></i>
    </button-->

    <div class="modal fade" id="confirm_delete" tabindex="-1" aria-labelledby="confirm_deleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ url('admin/categories/delete') }}" method="post">
                    @method('DELETE')
                    @csrf
                    <input name="category_id" type="hidden" value="" id="category_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirm_deleteLabel">{{ __('admin.delete_category') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4>{{ __('admin.confirm_delete_category') }}</h4>
                        <div class="form-check">
                            <input name="singe_delete" class="form-check-input" type="checkbox" value="1"
                                id="singe_delete" checked>
                            <label class="form-check-label" for="singe_delete">
                                {{ __('admin.yes_only_this') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input name="tree_delete" class="form-check-input" type="checkbox" value="1"
                                id="tree_delete">
                            <label class="form-check-label" for="tree_delete">
                                {{ __('admin.yes_all_subcategories') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input name="product_delete" class="form-check-input" type="checkbox" value="1"
                                id="product_delete">
                            <label class="form-check-label" for="product_delete">
                                {{ __('admin.yes_all_products') }}
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('cancel') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
