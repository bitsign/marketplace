<form method="post" action="<?php echo e(route('products.save-attributes',$product)); ?>" class="form-horizontal" role="form" id="product_attributes_form">
<?php echo csrf_field(); ?>
<input type="hidden" name="product_id" value="<?php echo e($product['id']); ?>">
<div class="col-md-12">
    <div class="attributes">
    <?php if(!empty($category_attributes)): ?>
        <table class="table table-hover attributes_table" id="version_<?php echo e($product['id']); ?>">
            <thead>
                <tr>
                    <th><?php echo e(__('admin.attribute')); ?></th>
                    <th><?php echo e(__('admin.attribute_values')); ?></th>
                    <th><?php echo e(__('admin.operations')); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $category_attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute_id => $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(!empty($attribute)): ?>
                    <?php
                        $group_name = $attribute['group_name'];
                        $multiple = $attribute['is_multiple'];
                    ?>
                    <?php unset($attribute['group_name']); ?>
                    <?php unset($attribute['is_multiple']); ?>
                    <tr multiple="<?php echo e($multiple); ?>">
                        <td colspan="3">
                            <b><?php echo e($group_name); ?></b>
                            <input type="hidden" value="<?php echo e($group_name); ?>" name="attributes[<?php echo e($attribute_id); ?>][group_name]">
                            <input type="hidden" value="<?php echo e($loop->index); ?>" name="attributes[<?php echo e($attribute_id); ?>][order]">
                        </td>
                    </tr>
                    <?php $__currentLoopData = $attribute; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $attr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $multiple = $attr['is_multiple'];
                        ?>
                        <?php unset($attr['is_multiple']); ?>
                        <tr multiple="<?php echo e($multiple); ?>">
                            <td>
                                <?php echo e($attr['name']); ?>

                                <input type="hidden" value="<?php echo e($attr['name']); ?>" name="attributes[<?php echo e($attribute_id); ?>][options][<?php echo e($key); ?>][name]">
                            </td>
                            <td>
                                <?php if(!empty($attr['values'])): ?>
                                <?php
                                    $form_name = $multiple==0 ? 'attributes['.$attribute_id.'][options]['.$key.'][value]' : 'attributes['.$attribute_id.'][options]['.$key.'][value][]';
                                ?>
                                <select name="<?php echo e($form_name); ?>" class="form-select select2" <?php echo e($multiple==1?'multiple':''); ?>>
                                    <?php $__currentLoopData = $attr['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $okey => $oval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                        $selected = "";

                                        if(isset($selected_attributes[$attribute_id]))
                                        {
                                            if(in_array($oval->id,$selected_attributes[$attribute_id]['options'][$attribute_id]['value']))
                                                $selected = 'selected';
                                        }
                                        ?>
                                        <option value="<?php echo e($okey); ?>" <?php echo e($selected); ?>>
                                            <?php echo e($oval->translation->name ?? ''); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php else: ?>
                                    <input type="text" name="<?php echo e($form_name); ?>" value="<?php echo e($selected_attributes[$attribute_id]['options'][$key]['value'] ?? ''); ?>" class="form-control">
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="btn btn-danger btn-xs del" title="<?php echo e(__('delete')); ?>"><i class="bi bi-trash"></i></span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <hr>
            <button type="submit" class="btn btn-primary"><?php echo e(__('admin.save')); ?></button>
        <?php else: ?>
            <?php echo e(__('admin.no_category_attributes')); ?>

        <?php endif; ?>
    </div>
</div>
</form>
<?php /**PATH /var/www/html/architus/resources/views/admin/products/components/attributes-form.blade.php ENDPATH**/ ?>