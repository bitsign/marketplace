<?php $__env->startSection('content'); ?>
<section id="<?php echo e($page->url); ?>" class="<?php echo e($page->url); ?>">
    <div class="container">
        <div class="row">
          <div class="col-lg-12 py-3">
            <?php echo $page->content; ?>

         </div>
    </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/page-content.blade.php ENDPATH**/ ?>