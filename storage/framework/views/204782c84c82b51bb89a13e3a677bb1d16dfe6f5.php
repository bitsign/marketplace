<?php $__env->startSection('content'); ?>
<section id="portfolio" class="portfolio">
    <div class="container">
        <div class="section-title my-2">
            <h2><?php echo e($portfolio->name); ?></h2>
            <?php echo $portfolio->description; ?>

        </div>

        <div class="row">
            <div class="col-lg-12 d-flex justify-content-center">
                <ul id="portfolio-flters">
                    <li data-filter="*"><?php echo e(__('all')); ?></li>
                    <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li data-filter=".<?php echo e($key); ?>"><?php echo e($tag); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>

        <div class="row portfolio-container" id="lightgallery">
            <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-md-6 portfolio-item <?php echo e(str_replace(',',' ',$img->tags)); ?>">
                <a href="<?php echo e(url('files/portfolio/original/'.$img->image)); ?>" title="<?php echo e($img->name); ?>" data-lightbox="gallery-item" class="portfolio-lightbox">
                    <img src="<?php echo e(url('files/portfolio/thumbs/'.$img->image)); ?>" class="card-img-top" alt="<?php echo e($img->name); ?>">
                </a>
                <div class="portfolio-info">
                    <h4><?php echo e($img->name); ?></h4>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/myshop/resources/views/portfolio/show.blade.php ENDPATH**/ ?>