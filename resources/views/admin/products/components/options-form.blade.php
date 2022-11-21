<form method="post" action="{{ route('products.save-attributes',$product) }}" class="form-horizontal" role="form" id="product_attributes_form">
@csrf
<input type="hidden" name="product_id" value="{{ $product['id'] }}">
<div class="col-md-12">
    <div class="options">
        <table class="table table-bordered options_table" id="version_{{ $product['id'] }}">
            <thead>
                <tr>
                    <th>{{ __('admin.type') }}</th>
                    <th>{{ __('admin.required') }}</th>
                    <th>{{ __('admin.option') }}</th>
                    <th>{{ __('admin.option_value') }}</th>
                    <th>{{ __('admin.price') }}</th>
                    <th>{{ __('admin.operations') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr data-row="0">
                    <td>
                        <select name="option_type[]" class="form-select" style="width: 250px;">
                            <option value="select">Dropdown</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="radio">Radio</option>
                            <option value="text">Text</option>
                        </select>
                    </td>
                    <td><input type="checkbox" name="required[]" value="1" checked>
                    <td>
                       <select name="attribute[]" class="form-select attribute" style="width: 250px;">
                        @foreach($attributes as $attribute)
                            <option value="{{ $attribute->id }}">{{ $attribute->translation->name }}</option>
                        @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="option[]" class="form-select attr_options" style="width: 250px;"></select>
                    </td>
                    <td><input type="number" name="price[]" value="" class="form-control"></td>
                    <td>
                        <span class="btn btn-danger btn-xs del" title="{{ __('delete') }}"><i class="bi bi-trash"></i></span>
                    </td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-primary add_option">
            <i class="bi bi-plus-circle"></i> {{ __('admin.add_option') }}
        </button>
        <hr>
        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> {{ __('admin.save') }}</button>
    </div>
</div>
</form>