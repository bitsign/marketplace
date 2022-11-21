<div class="row row-cols-1 row-cols-md-4 mb-3 text-center">
    <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col">
        <div class="card mb-4 rounded-3 shadow-sm <?php echo e($loop->index == 1 ? 'border-success' : ''); ?>">
            <div class="card-header py-3">
                <h4 class="my-0 fw-normal"><?php echo e($package->name); ?></h4>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title">
                    <?php if($package->price != 0): ?>
                    $ <?php echo e($package->price); ?>/<?php echo e(__('month')); ?>

                    <?php else: ?>
                    <?php echo e(__('free')); ?>

                    <?php endif; ?>
                </h1>
                <div class="list-unstyled mt-3 mb-4" style="min-height: 200px;">
                    
                    <p class="text-muted"><?php echo e($package->product_nr == 0 ? __('unlimited') : $package->product_nr); ?> <?php echo e(__('plan')); ?></p>
                    <?php echo $package->description; ?>

                </div>
                
                <?php if(isset($subscription->stripe_price)): ?>
                    <?php if($subscription->stripe_price == $package->stripe_plan): ?>
                    <button type="button" class="btn btn-success">Előfizetett csomag</button>
                    <?php endif; ?>
                <?php else: ?>
                <a href="<?php echo e(url(app()->getLocale().'/'.__('routes.offer').'/'.$package->url)); ?>" class="w-100 btn btn-lg btn-outline-primary">
                    <?php echo e(__('i_order')); ?>

                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div><?php /**PATH /var/www/html/architus/resources/views/packages/packages.blade.php ENDPATH**/ ?>