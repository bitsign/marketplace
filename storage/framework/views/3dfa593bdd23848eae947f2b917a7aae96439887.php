<?php $__env->startSection('content'); ?>
<section id="<?php echo e($page->url); ?>" class="<?php echo e($page->url); ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 py-3">
                <?php echo $page->content; ?>

            </div>
            <div class="row">
                <?php $__currentLoopData = $portfolio; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $portf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 mb-3">
                    <div class="card">
                        <a href="<?php echo e(url(app()->getLocale().'/'.__('routes.portfolio').'/'.$portf->translation->url)); ?>" title="<?php echo e($portf->translation->name); ?>">
                            <img src="<?php echo e(url('files/editor/'.$portf->image)); ?>" class="card-img-top" alt="<?php echo e($portf->translation->name); ?>">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($portf->translation->name); ?></h5>
                            <?php echo Str::words($portf->translation->description, 10, '...'); ?>

                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/portfolio/index.blade.php ENDPATH**/ ?>