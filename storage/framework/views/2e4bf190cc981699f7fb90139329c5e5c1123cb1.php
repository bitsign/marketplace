<?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<?php 
$discount = $product->action_price != 0 ? round((($product->price - $product->action_price)*100)/$product->price)  : '';
?>
<?php if($product->translation === NULL): ?>
    <?php continue; ?>
<?php endif; ?>
<div class="col-md-<?php echo e(isset($col) ? $col : 4); ?>">
    <div class="card mb-3">
        <div class="bg-image">
            <a href="<?php echo e(url(app()->getLocale().'/'.__('routes.product').'/'.$product->translation->url)); ?>" title="<?php echo e($product->translation->name); ?>">
                <img src="<?php echo e(!empty($product->defaultImage->filename) ? url('files/products/small/'.$product->defaultImage->filename) : url('files/editor/no-image.jpg')); ?>" class="card-img-top" alt="<?php echo e($product->translation->name); ?>">
            </a>
            <?php if(!empty($discount)): ?>
            <span class="badge bg-danger ms-2">-<?php echo e($discount); ?>%</span>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <h5 class="card-title mb-3">
                 <a href="<?php echo e(url(app()->getLocale().'/'.__('routes.product').'/'.$product->translation->url)); ?>"><?php echo e($product->translation->name); ?></a>
            </h5>
            <h6 class="mb-3">
                <?php if($product->action_price != 0): ?>
                    <s><?php echo e(currency($product->price)); ?></s>
                    <strong class="ms-2 text-danger"><?php echo e(currency($product->action_price)); ?></strong>
                <?php else: ?>
                    <b><?php echo e(currency($product->price)); ?></b>
                <?php endif; ?>
            </h6>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<div class="alert alert-info">
    <?php echo e(__('no_product')); ?>

</div>
<?php endif; ?><?php /**PATH /var/www/html/architus/resources/views/products/list.blade.php ENDPATH**/ ?>