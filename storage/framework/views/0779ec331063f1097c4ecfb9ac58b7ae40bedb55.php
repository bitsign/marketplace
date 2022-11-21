<?php $__env->startSection('content'); ?>
<section id="<?php echo e($service->url); ?>" class="<?php echo e($service->url); ?>">
<div class="container col-xxl-8 px-4 py-5">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
        <div class="col-10 col-sm-8 col-lg-6">
            <?php if($service->image): ?>
            <img src="<?php echo e(url('files/editor/'.$service->image)); ?>" class="d-block mx-lg-auto img-fluid" alt="<?php echo e($service->title); ?>" width="700" height="500" loading="lazy">
            <?php endif; ?>
        </div>
        <div class="col-lg-6">
            <h1 class="display-5 fw-bold lh-1 mb-3"><?php echo e(!empty($service->menu_title) ? $service->menu_title : $service->name); ?></h1>
            <p class="lead"><?php echo $service->content; ?></p>
            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <!--button type="button" class="btn btn-primary btn-lg px-4 me-md-2">Primary</button>
                <button type="button" class="btn btn-outline-secondary btn-lg px-4">Default</button -->
            </div>
        </div>
    </div>
</div>
</section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/myshop/resources/views/services/show.blade.php ENDPATH**/ ?>