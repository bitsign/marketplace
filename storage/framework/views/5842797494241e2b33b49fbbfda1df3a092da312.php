<?php if(!empty($attached_products)): ?>
    <h2 class="page-header"><?php echo e(__('admin.attached_products')); ?>:</h2>
    <form method="POST" action="<?php echo e(url('admin/products/update-attached-products')); ?>">
    <?php echo csrf_field(); ?>
    <?php $__currentLoopData = $attached_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="row mb-3">
            <label class="col-lg-3"><?php echo e($p->translation->name); ?></label>
            <div class="col-lg-9">
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <div class="col-lg-offset-2 col-lg-8">
        <input type="hidden" name="product_id" value="<?php echo e($product['id']); ?>">
        <input type="hidden" name="deleteall" value="1">
        <button type="submit" class="delete_att_products btn btn-xs btn-danger" id="deleteall_<?php echo e($product['id']); ?>"><?php echo e(__('delete')); ?></button>
    </div>
    </form>
<?php endif; ?>

<h2 class="page-header"><?php echo e(__('admin.attach_products')); ?></h2>
<form action="<?php echo e(url('admin/products/update-attached-products')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="row mb-3">
        <label class="col-lg-2"><?php echo e(__('admin.search_by_category')); ?></label>
        <input type="hidden" name="product_id" value="<?php echo e($product['id']); ?>">
        <div class="col-lg-10">
            <?php echo category_select($categories,[],'','','search_by_category_id'); ?>

        </div>
    </div>
    
    <div class="row mb-3 hidden" id="search_results">
        <label class="col-lg-2"><?php echo e(__('admin.products')); ?></label>
        <div class="col-lg-8" id="products">

        </div>
        <div class="clearfix"></div>
        <div class="col-lg-offset-2 col-lg-8">
            <button type="submit" class="btn btn-primary"><?php echo e(__('admin.save')); ?></button>
        </div>
    </div>
</form>
<?php /**PATH /var/www/html/architus/resources/views/admin/products/components/attached-prods-form.blade.php ENDPATH**/ ?>