<header>
    <?php echo $__env->make('layout.header-top', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 d-flex align-items-center">
                <a href="<?php echo e(url('/'.app()->getLocale())); ?>" class="navbar-brand logo py-2"><img src="<?php echo e(asset('img/logo.png')); ?>" alt="" class="img-fluid"></a>

                <div id="search-block" class="search_block m-auto">
                    <form id="search_form" action="<?php echo e(url(app()->getLocale().'/'.__('routes.products'))); ?>">
                        <div class="input-group">
                          <input type="text" class="form-control rounded-0" placeholder="" name="search_products" id="search-input" required>
                          <button class="btn btn-outline-secondary rounded-0" type="submit" id="button-addon2"><?php echo e(__('search')); ?></button>
                        </div>
                    </form>
                    <div id="search-result"></div>
                </div>

                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <a class="position-relative" data-bs-toggle="dropdown" class="dropdown-toggle" aria-expanded="false">
                            <i class="bi bi-cart"></i> <?php echo e(__('cart')); ?>

                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?php echo e(Cart::getTotalQuantity()); ?>

                            </span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li>
                              <div class="shopping-cart">
                                <div class="shopping-cart-header">
                                  <i class="bi bi-cart"></i>
                                  <div class="shopping-cart-total">
                                    <span class="text-primary"><?php echo e(__('sum')); ?>:</span>
                                    <span class="text-primary"><?php echo e(number_format(Cart::getTotal())); ?> Ft</span>
                                  </div>
                                </div> <!--end shopping-cart-header -->

                                <ul class="shopping-cart-items">
                                    <?php if(Cart::isEmpty()): ?>
                                        <div class="alert alert-info"><?php echo e(__('empty_cart')); ?></div>
                                        <?php else: ?>
                                        <?php $__currentLoopData = Cart::getContent(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="clearfix">
                                                <img src="<?php echo e(url('files/products/small/'.$item->attributes->image)); ?>" alt="item1" width="70"/>
                                                <span class="item-name"><?php echo e($item->name); ?></span>
                                                <span class="item-price"><?php echo e(number_format($item->price)); ?> Ft</span>
                                                <span class="item-quantity">x <?php echo e($item->quantity); ?></span>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </ul>
                                <?php if(Cart::isEmpty() === false): ?>
                                <a href="<?php echo e(url(app()->getLocale().'/'.'cart')); ?>" class="btn btn-primary btn-sm"><?php echo e(__('go_to_checkout')); ?></a>
                                <?php endif; ?>
                              </div>
                            </li>
                        </ul>
                    </div>
                    <div class="dropdown ms-3">
                        <?php if(auth()->guard()->guest()): ?>
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person" aria-hidden="true"></i>
                            <?php echo e(__('my_profile')); ?>

                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item" href="<?php echo e(url(app()->getLocale().'/'.__('routes.login'))); ?>"><?php echo e(__('login')); ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo e(url(app()->getLocale().'/'.__('routes.register'))); ?>"><?php echo e(__('register')); ?></a></li>
                            </ul>
                        <?php else: ?>
                            <a class="dropdown-toggle" href="#" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person" aria-hidden="true"></i>
                                <?php echo e(Auth::user()->name ?? ""); ?> <span class="caret">
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item" href="<?php echo e(url(app()->getLocale().'/'.__('routes.profile'))); ?>"><?php echo e(__('my_profile')); ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo e(url(app()->getLocale().'/'.__('routes.logout'))); ?>"><?php echo e(__('logout')); ?></a></li>

                            </ul>
                        <?php endif; ?>
                    </div>


                    <div class="navbar-right">
                        
                    </div>

                     <!--end shopping-cart -->

                </div>
            </div>
        </div>
    </div>
</header>

<?php echo $__env->make('layout.menu.categories_menu',['categories' => $categories], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /var/www/html/architus/resources/views/layout/header.blade.php ENDPATH**/ ?>