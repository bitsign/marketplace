<?php
    $template =  'layout.page';
    $params   =  ['page_title'=>'429 '.__('Too Many Requests')];
?>

<?php $__env->startSection('content'); ?>
<div class="col-xl-12 col-md-6 my-4">
    <div class="card shadow mx-auto border-danger" style="width:33%">
        <div class="card-header">
            429
        </div>
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col-lg-12">
                    <?php echo e(__('auth.throttle',['seconds'=>60])); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($template,$params, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/myshop/resources/views/errors/429.blade.php ENDPATH**/ ?>