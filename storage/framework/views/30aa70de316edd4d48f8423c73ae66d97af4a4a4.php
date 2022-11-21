<?php $__env->startSection('content'); ?>
<section id="<?php echo e($page->url ?? ''); ?>" class="<?php echo e($page->url ?? ''); ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 py-3">
                <?php echo $page->content ?? ''; ?>

            </div>
            <div class="row align-items-center">
                <?php $__currentLoopData = $manufacturers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manufacturer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-2 mb-3">
                    <div class="item">
                        <a href="<?php echo e(url(app()->getLocale().'/'.__('routes.manufacturer').'/'.$manufacturer->url)); ?>" title="<?php echo e($manufacturer->name); ?>">
                            <img src="<?php echo e(url('files/editor/manufacturers/'.$manufacturer->image)); ?>" class="card-img-top" alt="<?php echo e($manufacturer->name); ?>">
                        </a>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/manufacturers/index.blade.php ENDPATH**/ ?>