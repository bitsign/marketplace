<?php $__env->startSection('content'); ?>
<section class="h-100">
    <div class="container py-5">
        <div class="row d-flex justify-content-center my-4">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0"><?php echo e(__('checkout')); ?></h5>
                    </div>
                    <div class="card-body">
                        <h4 class="mb-3"><?php echo e(__('billing_data')); ?></h4>
                        <form action="<?php echo e(url(app()->getLocale().'/save-order')); ?>" class="needs-validation" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="row g-3">
                                <div class="col-sm-4">
                                    <label for="firstName" class="form-label"><?php echo e(__('name')); ?></label>
                                    <input type="text" name="name" class="form-control" id="firstName" placeholder="" value="<?php echo e(Auth::check() ? Auth::user()->name : ''); ?>" required>
                                </div>

                                <div class="col-sm-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="" value="<?php echo e(Auth::check() ? Auth::user()->email : ''); ?>" required>
                                </div>

                                <div class="col-sm-4">
                                    <label for="phone" class="form-label"><?php echo e(__('phone')); ?></label>
                                    <input type="phone" name="phone" class="form-control" id="phone" placeholder="" value="<?php echo e(Auth::check() ? Auth::user()->phone : ''); ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="country" class="form-label"><?php echo e(__('country')); ?></label>
                                    
                                    <input type="text" name="country" class="form-control" id="country" value="<?php echo e(old('country') ?? (Auth::check() ? Auth::user()->country : '')); ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="state" class="form-label"><?php echo e(__('state')); ?></label>
                                    
                                    <input type="text" name="state" class="form-control" id="state" value="<?php echo e(old('state') ?? (Auth::check() ? Auth::user()->state : '')); ?>">
                                </div>

                                <div class="col-3">
                                    <label for="city" class="form-label"><?php echo e(__('city')); ?></label>
                                    
                                    <input type="text" name="city" class="form-control" id="city" value="<?php echo e(old('city') ?? (Auth::check() ? Auth::user()->city : '')); ?>">
                                </div>

                                <div class="col-md-3">
                                    <label for="zip" class="form-label"><?php echo e(__('zip')); ?></label>
                                    <input type="number" min="1" name="zip" class="form-control" id="zip" placeholder="" value="<?php echo e(old('zip') ?? (Auth::check() ? Auth::user()->zip : '')); ?>" required="">
                                </div>

                                <div class="col-6">
                                    <label for="address" class="form-label"><?php echo e(__('address')); ?></label>
                                    <input type="text" name="address"  class="form-control" id="address" placeholder="" value="<?php echo e(old('address') ?? (Auth::check() ? Auth::user()->address : '')); ?>" required>
                                </div>

                            </div>

                            <hr class="my-4">

                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" id="same-address" <?php echo e(isset(Auth::user()->state2) ? '' : 'checked'); ?>>
                                <label class="form-check-label" for="same-address"><?php echo e(__('same_as_billing_data')); ?></label>
                            </div>

                            <div class="same_as_billing mb-3" <?php echo isset(Auth::user()->state2) ? '' : 'style="display:none"'; ?>>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="state2" class="form-label"><?php echo e(__('state')); ?></label>
                                        <input type="text" name="state2" class="form-control" id="state2" value="<?php echo e(old('state2') ?? (Auth::check() ? Auth::user()->state2 : '')); ?>" >
                                    </div>

                                    <div class="col-md-6">
                                        <label for="zip2" class="form-label"><?php echo e(__('zip')); ?></label>
                                        <input type="number" min="1" name="zip2" class="form-control" id="zip2" placeholder="" value="<?php echo e(old('zip2') ?? (Auth::check() ? Auth::user()->zip2 : '')); ?>" >
                                    </div>

                                    <div class="col-6">
                                        <label for="city2" class="form-label"><?php echo e(__('city')); ?></label>
                                        <input type="text" name="city2"  class="form-control" id="address" placeholder="" value="<?php echo e(old('city2') ?? (Auth::check() ? Auth::user()->city2 : '')); ?>" >
                                    </div>

                                    <div class="col-6">
                                        <label for="address2" class="form-label"><?php echo e(__('address')); ?></label>
                                        <input type="text" name="address2"  class="form-control" id="address2" placeholder="" value="<?php echo e(old('address2') ?? (Auth::check() ? Auth::user()->address2 : '')); ?>" >
                                    </div>
                                </div>
                            </div>

                            <button class="w-100 btn btn-primary btn-lg" type="submit"><?php echo e(__('i_order')); ?></button>
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0"><?php echo e(__('order_summary')); ?></h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 pb-0">
                                <?php echo e(__('products')); ?> (<?php echo e(Cart::getTotalQuantity()); ?> <?php echo e(__('unit.unit_1')); ?>) :
                                <span><?php echo e(currency(Cart::getSubTotal())); ?></span>
                            </li>
                            <?php $__currentLoopData = Cart::getConditions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $condition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div><b><?php echo e(__($condition->getType())); ?>:</b> <?php echo e($condition->getName()); ?></div>
                                    <div><?php echo e($condition->getValue() != 0 ? currency($condition->getValue()) : ''); ?></div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                <div>
                                    <strong><?php echo e(__('total')); ?></strong>
                                    <strong>
                                        <p class="mb-0">(<?php echo e(__('including VAT')); ?>)</p>
                                    </strong>
                                </div>
                                <span><strong><?php echo e(currency(Cart::getTotal())); ?></strong></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/myshop/resources/views/cart/checkout.blade.php ENDPATH**/ ?>