<div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <i class="bi bi-person-circle"></i>
        <span class="fs-4"><?php echo e(__('my_profile')); ?></span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="<?php echo e(route('vendor.profile')); ?>" class="nav-link <?php echo e(request()->segment(3) == 'profile' ? 'active' : ''); ?>" aria-current="page">
                <i class="bi bi-house"></i>
                <?php echo e(__('settings')); ?>

            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo e(route('vendor.sales')); ?>" class="nav-link <?php echo e(request()->segment(3) == 'sales' ? 'active' : ''); ?>" aria-current="page">
                <i class="bi bi-currency-dollar"></i>
                <?php echo e(__('sales')); ?>

            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link" aria-current="page">
                <i class="bi bi-box-seam"></i>
                <?php echo e(__('products')); ?>

            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo e(route('vendor.add-product')); ?>" class="nav-link <?php echo e(request()->segment(3) == 'add-product' ? 'active' : ''); ?>" aria-current="page">
                <i class="bi bi-cloud-arrow-up"></i>
                <?php echo e(__('add_product')); ?>

            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo e(route('vendor.logout')); ?>" class="nav-link" aria-current="page">
                <i class="bi bi-box-arrow-in-left"></i>
                <?php echo e(__('logout')); ?>

            </a>
        </li>
        
    </ul>
</div><?php /**PATH /var/www/html/architus/resources/views/vendors/sidebar.blade.php ENDPATH**/ ?>