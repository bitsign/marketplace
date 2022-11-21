<nav id="sidebar" class="bg-dark">
    <div class="sidebar-header">
        <h3 class="text-center">Admin</h3>
    </div>

    <ul class="menu list-unstyled">

        <li class="<?php echo e((request()->segment(2) == 'dashboard') ? 'active' : ''); ?>">
            <a href="<?php echo e(url('admin/dashboard')); ?>">
                <i class="bi bi-speedometer2"></i> <span><?php echo e(__('admin.dashboard')); ?></span>
            </a>
        </li>

        <?php
            $content_urls = array('pages','banners','blocks','team','portfolios','services','faqs','feedbacks');
            $act = in_array(request()->segment(2), $content_urls);
        ?>
        <li class="<?php echo e($act===true ? 'active' : ''); ?>">
            <a href="#contents" data-bs-toggle="collapse" aria-expanded="<?php echo e($act===true ? 'true' : 'false'); ?>" class="dropdown-toggle">
                <i class="bi bi-file-text"></i> <span><?php echo e(__('admin.contents')); ?></span>
            </a>
            <ul class="collapse list-unstyled <?php echo e($act===true ? 'show' : ''); ?>" id="contents">
                <li class="<?php echo e((request()->segment(2) == 'pages') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('admin/pages')); ?>">
                        <i class="bi bi-circle"></i> <?php echo e(__('admin.pages')); ?>

                    </a>
                </li>

                <li class="<?php echo e((request()->segment(2) == 'banners') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('admin/banners')); ?>">
                        <i class="bi bi-circle"></i> <span><?php echo e(__('admin.banners')); ?></span>
                    </a>
                </li>
                <li class="<?php echo e((request()->segment(2) == 'blocks') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('admin/blocks')); ?>">
                        <i class="bi bi-circle"></i> <span><?php echo e(__('admin.blocks')); ?></span>
                    </a>
                </li>
                
            </ul>
        </li>

        <?php
            $content_urls_ = array('orders','statuses','deleted-orders','payment-methods','shipping-methods','deleted-orders');
            $act_ = in_array(request()->segment(2), $content_urls_);
        ?>
        <li class="<?php echo e($act_===true ? 'active' : ''); ?>">
            <a href="#orders" data-bs-toggle="collapse" aria-expanded="<?php echo e($act_===true ? 'true' : 'false'); ?>" class="dropdown-toggle">
                <i class="bi bi-cart-check-fill"></i> <?php echo e(__('admin.shop')); ?></i>
            </a>
            <ul class="collapse list-unstyled <?php echo e($act_===true ? 'show' : ''); ?>" id="orders">
                <li class="<?php echo e((request()->segment(2) == 'orders') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('admin/orders')); ?>">
                        <i class="bi bi-circle"></i>  <span><?php echo e(__('admin.orders')); ?></span>
                    </a>
                </li>

                <li class="<?php echo e((request()->segment(2) == 'deleted-orders') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('admin/orders/deleted-orders')); ?>">
                        <i class="bi bi-circle"></i>  <span><?php echo e(__('admin.deleted_orders')); ?></span>
                    </a>
                </li>

                <li class="<?php echo e((request()->segment(2) == 'statuses') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('admin/statuses')); ?>">
                        <i class="bi bi-circle"></i>  <span><?php echo e(__('admin.statuses')); ?></span>
                    </a>
                </li>
               
                <li class="<?php echo e((request()->segment(2) == 'payment-methods') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('admin/payment-methods')); ?>">
                        <i class="bi bi-circle"></i>  <span><?php echo e(__('admin.payment_methods')); ?></span>
                    </a>
                </li>

                <li class="<?php echo e((request()->segment(2) == 'shipping-methods') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('admin/shipping-methods')); ?>">
                        <i class="bi bi-circle"></i>  <span><?php echo e(__('admin.shipping_methods')); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        
        <?php
            $content_urls_ = array('products','attributes','manufacturers');
            $act_ = in_array(request()->segment(2), $content_urls_);
        ?>
        <li class="<?php echo e($act_===true ? 'active' : ''); ?>">
            <a href="#products" data-bs-toggle="collapse" aria-expanded="<?php echo e($act_===true ? 'true' : 'false'); ?>" class="dropdown-toggle">
                <i class="bi bi-dropbox"></i> <?php echo e(__('admin.products')); ?></i>
            </a>
            <ul class="collapse list-unstyled <?php echo e($act_===true ? 'show' : ''); ?>" id="products">
                <li class="<?php echo e((request()->segment(2) == 'products') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('admin/products')); ?>">
                        <i class="bi bi-circle"></i> <span><?php echo e(__('admin.edit_products')); ?></span>
                    </a>
                </li>
                <li class="<?php echo e((request()->segment(2) == 'attributes') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('admin/attributes')); ?>">
                        <i class="bi bi-circle"></i> <span><?php echo e(__('admin.attributes')); ?></span>
                    </a>
                </li>
                
            </ul>
        </li>

        <li class="<?php echo e((request()->segment(2) == 'packages') ? 'active' : ''); ?>">
            <a href="<?php echo e(url('admin/packages')); ?>">
                <i class="bi bi-boxes"></i> <span><?php echo e(__('admin.packages')); ?></span>
            </a>
        </li>

        <li class="<?php echo e((request()->segment(2) == 'vendors-list') ? 'active' : ''); ?>">
            <a href="<?php echo e(url('admin/vendors')); ?>">
                <i class="bi bi-house-heart"></i> <span><?php echo e(__('admin.designers')); ?></span>
            </a>
        </li>

        

        <?php
            $content_urls_ = array('statistic_products','statistic_orders');
            $act_ = in_array(request()->segment(3), $content_urls_);
        ?>
        <!--li class="<?php echo e($act_===true ? 'active' : ''); ?>">
            <a href="#statistics" data-bs-toggle="collapse" aria-expanded="<?php echo e($act_===true ? 'true' : 'false'); ?>" class="dropdown-toggle">
                <i class="bi bi-bar-chart"></i> <?php echo e(__('admin.statistics')); ?>

            </a>
            <ul class="collapse list-unstyled <?php echo e($act_===true ? 'show' : ''); ?>" id="statistics">
                <li class="<?php echo e((request()->segment(2) == 'statistic_products') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('admin/statistics/statistic_products')); ?>">
                        <i class="bi bi-circle"></i> <span><?php echo e(__('admin.product_statistics')); ?></span>
                    </a>
                </li>
                <li class="<?php echo e((request()->segment(2) == 'statistic_orders') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('admin/statistics/statistic_orders')); ?>">
                        <i class="bi bi-circle"></i> <?php echo e(__('admin.order_statistics')); ?>

                    </a>
                </li>
            </ul>
        </li-->

        <li class="<?php echo e((request()->segment(2) == 'users-list') ? 'active' : ''); ?>">
            <a href="<?php echo e(url('admin/users')); ?>">
                <i class="bi bi-people-fill"></i> <span><?php echo e(__('admin.users')); ?></span>
            </a>
        </li>
        

        <?php if(isset(session('AdminUser')['group_id']) && session('AdminUser')['group_id'] == 0): ?>
        <li class="<?php echo e((request()->segment(2) == 'administrators') ? 'active' : ''); ?>">
            <a href="<?php echo e(url('admin/administrators')); ?>">
                <i class="bi bi-person-lines-fill"></i> <span><?php echo e(__('admin.administrators')); ?></span>
            </a>
        </li>
        <li class="<?php echo e((request()->segment(2) == 'settings') ? 'active' : ''); ?>">
            <a href="<?php echo e(url('admin/settings')); ?>">
                <i class="bi bi-gear"></i> <span><?php echo e(__('admin.settings')); ?></span>
            </a>
        </li>
        <li class="<?php echo e((request()->segment(2) == 'currencies') ? 'active' : ''); ?>">
            <a href="<?php echo e(url('admin/currencies')); ?>">
                <i class="bi bi-currency-exchange"></i>  <span><?php echo e(__('admin.currencies')); ?></span>
            </a>
        </li>
        <li class="<?php echo e((request()->segment(2) == 'email-texts') ? 'active' : ''); ?>">
            <a href="<?php echo e(url('admin/email-texts')); ?>">
                <i class="bi bi-envelope"></i> <span><?php echo e(__('admin.system_emails')); ?></span>
            </a>
        </li>
        <?php endif; ?>
    </ul>
</nav>
<?php /**PATH /var/www/html/architus/resources/views/admin/layout/menu.blade.php ENDPATH**/ ?>