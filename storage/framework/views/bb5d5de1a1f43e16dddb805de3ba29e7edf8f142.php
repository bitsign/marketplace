<?php $__env->startSection('content'); ?>
<section id="post" class="post">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 my-3">
                <?php if(!empty($post)): ?>
                    <h1><?php echo e($post->name); ?></h1>
                    <small><i class="bi bi-clock"></i> <?php echo e($post->created_at); ?></small>
                    <img src="<?php echo e(url('files/editor/'.$post->image)); ?>" class="card-img-top" alt="<?php echo e($post->title); ?>">
                    <?php echo $post->content; ?>

                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?php if(count($terms) > 0): ?>
                <h3><?php echo e(__('tags')); ?></h3>
                <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <a href="<?php echo e(url(app()->getLocale().'/'.__('routes.blog').'?term='.$term['term_key'])); ?>">
                            <?php echo e($term['name']); ?>

                        </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/myshop/resources/views/blog/post.blade.php ENDPATH**/ ?>