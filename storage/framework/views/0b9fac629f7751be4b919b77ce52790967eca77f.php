<?php $__env->startSection('content'); ?>
<section class="section profile">
    <div class="container">
    <div class="row my-3">
        <?php echo $__env->make('layout.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 
        <?php echo $__env->make('vendors.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="col-md-9">
            <div class="card border-0">
                <div class="card-body pt-3">
                   <!-- Profile Edit Form -->
                    <form action="<?php echo e(route('vendor.profile')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                        <div class="row mb-2">
                            <label class="col-lg-3 text-end"><?php echo e(__('admin.name')); ?> <code>*</code></label>
                            <div class="col-lg-9">
                                <input name="name" type="text" value="<?php echo e($vendor['name']); ?>"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-lg-3 text-end"><?php echo e(__('email')); ?> <code>*</code></label>
                            <div class="col-lg-9">
                                <input name="email" type="text" value="<?php echo e($vendor['email']); ?>"
                                    class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-lg-3 text-end"><?php echo e(__('phone')); ?></label>
                            <div class="col-lg-9">
                                <input name="phone" type="text" value="<?php echo e($vendor['phone']); ?>"
                                    class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-lg-3 text-end"><?php echo e(__('password_new')); ?></label>
                            <div class="col-lg-9">
                                <input name="password" type="password" value="" class="form-control"
                                    autocomplete="off" id="password">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-lg-3 text-end"><?php echo e(__('password_confirm')); ?></label>
                            <div class="col-lg-9">
                                <input name="confirm_password" type="password" value="" class="form-control"
                                    id="confirm_password" autocomplete="off">
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="offset-md-2"><?php echo e(__('admin.billing_info')); ?></legend>
                        <div class="row mb-2">
                            <label class="col-lg-3 text-end"><?php echo e(__('country')); ?> <code>*</code></label>
                            <div class="col-lg-9">
                                <input name="country"
                                    value="<?php echo e($vendor['country'] != '' ? $vendor['country'] : 'Magyarország'); ?>"
                                    type="text" id="country" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-lg-3 text-end"><?php echo e(__('state')); ?> <code>*</code></label>
                            <div class="col-lg-9">
                                <input name="state" value="<?php echo e($vendor['state']); ?>" type="text" id="state"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-lg-3 text-end"><?php echo e(__('zip')); ?><code>*</code></label>
                            <div class="col-lg-9">
                                <input name="zip" value="<?php echo e($vendor['zip']); ?>" type="number" id="zip"
                                    class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-lg-3 text-end"><?php echo e(__('city')); ?> <code>*</code></label>
                            <div class="col-lg-9">
                                <input name="city" value="<?php echo e($vendor['city']); ?>" type="text" id="city"
                                    class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-lg-3 text-end"><?php echo e(__('address')); ?> <code>*</code></label>
                            <div class="col-lg-9" id="city_container">
                                <input name="address" value="<?php echo e($vendor['address']); ?>" type="text"
                                    id="address" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-lg-3 text-end"><?php echo e(__('vat_number')); ?></label>
                            <div class="col-lg-9">
                                <input type="text" name="vat_number" class="form-control"
                                    value="<?php echo e($vendor['vat_number']); ?>">
                            </div>
                        </div>
                    </fieldset>

                        <div class="offset-md-3">
                            <button type="submit" class="btn btn-primary"><?php echo e(__('admin.save')); ?></button>
                        </div>
                    </form><!-- End Profile Edit Form -->
                    <fieldset>
                        <legend><?php echo e(__('admin.subscription')); ?></legend>
                        <?php if(!empty($package) && !empty($subscription)): ?>
                        <ul class="list-group">
                            <li class="list-group-item d-flex align-items-center">
                                <?php echo e(__('admin.package')); ?>:
                                <span class="badge bg-primary rounded-pill ms-2"><?php echo e($package['name']); ?></span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                Stripe ID:
                                <span class="badge bg-primary rounded-pill ms-2"><?php echo e($subscription['stripe_id']); ?></span>
                                </li>
                            <li class="list-group-item d-flex align-items-center">
                                Stripe price:
                                <span class="badge bg-primary rounded-pill ms-2"><?php echo e($subscription['stripe_price']); ?></span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                Stripe Status:
                                <span class="badge bg-primary rounded-pill ms-2"><?php echo e($subscription['stripe_status']); ?></span>
                            </li>
                        </ul>
                        <?php else: ?>

                        <?php endif; ?>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/vendors/profile.blade.php ENDPATH**/ ?>