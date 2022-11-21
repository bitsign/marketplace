<?php $__env->startSection('content'); ?>
<section id="<?php echo e($page->url); ?>" class="<?php echo e($page->url); ?>">
    <div class="container py-4">
        <?php echo $__env->make('packages.packages',$packages, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/packages/index.blade.php ENDPATH**/ ?>