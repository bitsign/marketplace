<!-- Content Header (Page header) -->
<section class="content-header">
    <h2>
        <small><?php echo e($page_title ?? ''); ?></small>
    </h2>
</section>
<section class="content-header mb-2">
    <?php if(!empty($tabs)): ?>
        <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $__currentLoopData = $tab; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(strpos($key,'http:') === false && strpos($key,'https:') === false ? URL::to($key) : $key); ?>" class="btn btn-primary mb-2">
                <?php echo $value; ?>

            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</section>
<?php /**PATH /var/www/html/architus/resources/views/admin/layout/page-header.blade.php ENDPATH**/ ?>