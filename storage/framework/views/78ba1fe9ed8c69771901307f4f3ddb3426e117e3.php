<nav id="top" class="">
    <div class="container-fluid">
        <div class="nav float-start">
            <ul class="list-inline m-0">
                <li class="list-inline-item">
                    <a href="tel:<?php echo e(SHOP_PHONE); ?>">
                        <i class="bi bi-telephone"></i> 
                        <span class="d-none d-md-inline"><?php echo e(SHOP_PHONE); ?></span>
                    </a>
                </li>
            </ul>
            
        </div>
        <div class="nav float-end">
            <ul class="list-inline m-0">

                <li class="list-inline-item">
                    <?php if(Auth::guard('vendor')->check()): ?>
                        <a href="<?php echo e(route('vendor.profile')); ?>" title="<?php echo e(__('my_profile')); ?>" class="text-danger me-3">
                            <i class="bi bi-house-gear"></i>
                            <span class="d-none d-md-inline"><?php echo e(__('my_profile')); ?></span>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('vendor.login-register')); ?>" title="<?php echo e(__('sell_your_plans')); ?>" class="text-danger me-3">
                            <i class="bi bi-house-gear"></i>
                            <?php echo e(__('sell_your_plans')); ?>

                        </a>
                    <?php endif; ?>
                </li>

                
            </ul>

            <?php 
                $selectedCurrency = currency()->find(currency()->getUserCurrency()); 
                $key = array_search (app()->getLocale(), config('app.available_locales'));
                $lang_name = config('app.available_locales')[$key];
            ?>
            <div class="topbar-text dropdown disable-autohide">
                <a class="topbar-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="me-1" src="<?php echo e(asset('img/'.app()->getLocale().'.png')); ?>" max-width="20" alt="<?php echo e($lang_name); ?>">
                    <?php echo e($key); ?> / <?php echo e($selectedCurrency->symbol); ?>

                </a>
                <ul class="dropdown-menu dropdown-menu-end" style="">
                    <li class="dropdown-item">
                        <select class="form-select form-select-sm" onchange='window.location="<?php echo e(url()->current()); ?>?currency="+this.value;'>
                            <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($currency['code']); ?>" <?php echo e($selectedCurrency->name == $currency['name'] ? 'selected' : ''); ?>><?php echo e($currency['symbol']); ?> - <?php echo e($currency['name']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </li>
                    <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language => $al): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <a class="dropdown-item pb-1" href="<?php echo e(getTranslation(app()->getLocale(),$al,request()->segment(3))); ?>">
                            <img class="me-2" src='<?php echo e(asset('img/'. $al.'.png')); ?>' width="20" alt="<?php echo e(app()->getLocale()); ?>">
                            <?php echo e($language); ?>

                        </a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>

        
    </div>
</nav><?php /**PATH /var/www/html/myshop/resources/views/layout/header-top.blade.php ENDPATH**/ ?>