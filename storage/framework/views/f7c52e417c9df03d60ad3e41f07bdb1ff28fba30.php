<?php if(strpos($_SERVER['REQUEST_URI'],'admin') !== false): ?>
    <?php
        $template =  'admin.layout.app';
        $params   =  ['page_title'=>'404'];
        app()->setLocale(config('app.admin_locale'));
    ?>
<?php else: ?>
    <?php
        $template =  'layout.page';
        $params   = ['meta_title'=>'404'];
    ?>
<?php endif; ?>



<?php $__env->startSection('content'); ?>

<div class="col-xl-12 col-md-6 my-4">
    <div class="card shadow mx-auto border-danger" style="width:33%">
        <div class="card-header">
            404
        </div>
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col-lg-12">
                    <?php echo e(__('Not Found')); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>





<?php echo $__env->make($template,$params, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/myshop/resources/views/errors/404.blade.php ENDPATH**/ ?>