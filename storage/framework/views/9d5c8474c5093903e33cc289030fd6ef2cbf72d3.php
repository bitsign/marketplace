<section class="services">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($service->translation === NULL): ?>
                    <?php continue; ?>
                <?php endif; ?>
                <div class="col-md-4">
                    <div class="card mb-3 border-0">
                        <?php if($service->image): ?>
                            <img src="<?php echo e(url('files/editor/' . $service->image)); ?>" class="card-img-top m-auto" alt="<?php echo e($service->title); ?>">
                        <?php endif; ?>
                        <div class="card-body text-center">
                            <h5 class="card-title text-center">
                                <a class="<?php echo e(request()->segment(2) == $service->translation->url ? 'active' : ''); ?>"
                                    href="<?php echo e(app()->getLocale() . '/' . __('routes.service') . '/' . $service->translation->url); ?>">
                                    <?php echo e(!empty($service->translation->menu_title) ? $service->translation->menu_title : $service->translation->name); ?>

                                </a>
                            </h5>
                            <p class="card-text text-dark"><?php echo $service->translation->content; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section><?php /**PATH /var/www/html/architus/resources/views/services/services-block.blade.php ENDPATH**/ ?>