<?php if(Request::segment(2) != ''): ?>
<section id="breadcrumbs" class="breadcrumbs">
    <div class="container">
        <ol>
            <li><a href="<?php echo e(URL::to('/'.app()->getLocale())); ?>"><?php echo e(__('front_page')); ?></a></li>
            <?php if(!empty($breadcrumbs)): ?>
                <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(!empty($breadcrumb['url']) && !$loop->last): ?>
                        <li class="breadcrumb-item"><a href="<?php echo e($breadcrumb['url']); ?>"><?php echo e(Str::words($breadcrumb['title'], 3, '...')); ?></a></li>
                    <?php else: ?>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo e(Str::words($breadcrumb['title'], 3, '...')); ?></li>
                    <?php endif; ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <li class="breadcrumb-item active" aria-current="page"><?php echo e($page->name ?? ""); ?></li>
            <?php endif; ?>
        </ol>
    </div>
</section>
<?php endif; ?>
<?php /**PATH /var/www/html/myshop/resources/views/layout/breadcrumbs.blade.php ENDPATH**/ ?>