<form method="post" action="{{ route('products.save-attributes',$product) }}" class="form-horizontal" role="form" id="product_attributes_form">
@csrf
<input type="hidden" name="product_id" value="{{ $product['id'] }}">
<div class="col-md-12">
    <div class="attributes">
    @if(!empty($category_attributes))
        <table class="table table-hover attributes_table" id="version_{{ $product['id'] }}">
            <thead>
                <tr>
                    <th>{{ __('admin.attribute') }}</th>
                    <th>{{ __('admin.attribute_values') }}</th>
                    <th>{{ __('admin.operations') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($category_attributes as $attribute_id => $attribute)
                @if(!empty($attribute))
                    @php
                        $group_name = $attribute['group_name'];
                        $multiple = $attribute['is_multiple'];
                    @endphp
                    @unset($attribute['group_name'])
                    @unset($attribute['is_multiple'])
                    <tr multiple="{{ $multiple }}">
                        <td colspan="3">
                            <b>{{ $group_name }}</b>
                            <input type="hidden" value="{{ $group_name }}" name="attributes[{{ $attribute_id }}][group_name]">
                            <input type="hidden" value="{{ $loop->index }}" name="attributes[{{ $attribute_id }}][order]">
                        </td>
                    </tr>
                    @foreach($attribute as $key => $attr)
                        @php
                            $multiple = $attr['is_multiple'];
                        @endphp
                        @unset($attr['is_multiple'])
                        <tr multiple="{{ $multiple }}">
                            <td>
                                {{ $attr['name'] }}
                                <input type="hidden" value="{{ $attr['name'] }}" name="attributes[{{ $attribute_id }}][options][{{ $key }}][name]">
                            </td>
                            <td>
                                @if(!empty($attr['values']))
                                @php
                                    $form_name = $multiple==0 ? 'attributes['.$attribute_id.'][options]['.$key.'][value]' : 'attributes['.$attribute_id.'][options]['.$key.'][value][]';
                                @endphp
                                <select name="{{ $form_name }}" class="form-select select2" {{ $multiple==1?'multiple':'' }}>
                                    @foreach($attr['values'] as $okey => $oval)
                                        @php
                                        $selected = "";

                                        if(isset($selected_attributes[$attribute_id]))
                                        {
                                            if(in_array($oval->id,$selected_attributes[$attribute_id]['options'][$attribute_id]['value']))
                                                $selected = 'selected';
                                        }
                                        @endphp
                                        <option value="{{ $okey }}" {{ $selected }}>
                                            {{ $oval->translation->name ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @else
                                    <input type="text" name="{{ $form_name }}" value="{{ $selected_attributes[$attribute_id]['options'][$key]['value'] ?? '' }}" class="form-control">
                                @endif
                            </td>
                            <td>
                                <span class="btn btn-danger btn-xs del" title="{{ __('delete') }}"><i class="bi bi-trash"></i></span>
                            </td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
            </tbody>
        </table>
        <hr>
            <button type="submit" class="btn btn-primary">{{ __('admin.save') }}</button>
        @else
            {{ __('admin.no_category_attributes') }}
        @endif
    </div>
</div>
</form>
