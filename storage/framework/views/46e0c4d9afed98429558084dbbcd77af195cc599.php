<footer id="footer" class="footer bg-dark text-white">

    <div class="footer-content">
        <div class="container py-5">
            <div class="row">

                <div class="col-lg-4 col-md-6 footer-links">
                    <h4 class="mb-3"><?php echo e(__('useful_links')); ?></h4>
                    <ul>
                        <?php $__currentLoopData = $info_menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info_page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php  
                        if($info_page->translation === NULL)
                            continue;
                        $url = $info_page->type == 'page' 
                                ? app()->getLocale() . '/' . __('routes.page') . '/' . $info_page->translation->url 
                                : app()->getLocale() . '/' . __('routes.' . $info_page->type); 
                        ?>
                        <li><i class="bi bi-chevron-right"></i> <a href="<?php echo e(url($url)); ?>"><?php echo e($info_page->translation->name); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6 footer-links">
                    <h4 class="mb-3"><?php echo e(__('pages')); ?></h4>
                    <ul>
                        <?php $__currentLoopData = $foot_pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php  
                         if($page->translation === NULL)
                            continue;
                        $url = $page->type == 'page' 
                                ? app()->getLocale() . '/' . __('routes.page') . '/' . $page->translation->url 
                                : app()->getLocale() . '/' . __('routes.' . $page->type); 
                        ?>
                        <li><i class="bi bi-chevron-right"></i> <a href="<?php echo e(url($url)); ?>"><?php echo e($page->translation->name); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="footer-info">
                        <h3><?php echo e(SHOP_NAME); ?></h3>
                        <p>
                            <?php echo e(SHOP_ADDRESS); ?> <br>
                            <strong><?php echo e(__('phone')); ?>:</strong> <?php echo e(SHOP_PHONE); ?><br>
                            <strong><?php echo e(__('email')); ?>:</strong> <?php echo e(SHOP_MAIL); ?><br>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        &copy; <?php echo e(date('Y') > 2022 ? "2022 - {date('Y')}" : '2022'); ?>. <?php echo e(__('all_rights')); ?> <a class="text-white" href="<?php echo e(url('/')); ?>"><?php echo e(SHOP_NAME); ?></a>
        <?php if(config('app.env') == 'local'): ?>
        <br>
        <small class="text-muted">Test mode - Laravel v<?php echo e(Illuminate\Foundation\Application::VERSION); ?> (PHP v<?php echo e(PHP_VERSION); ?>)</small>
        <?php endif; ?>
    </div>
</footer>
<?php /**PATH D:\laragon\www\architus\resources\views/layout/footer.blade.php ENDPATH**/ ?>