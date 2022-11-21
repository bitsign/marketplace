<?php $__env->startSection('content'); ?>
<section class="section profile">
    <div class="container">
    <div class="row my-3">
        <?php echo $__env->make('layout.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="col-xl-12">
            <div class="card border-0">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit" aria-selected="true" role="tab"><?php echo e(__('my_profile')); ?></button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-orders" aria-selected="false" tabindex="-1" role="tab"><?php echo e(__('my_orders')); ?></button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-wishlist" aria-selected="false" tabindex="-1" role="tab"><?php echo e(__('wishlist')); ?></button>
                        </li>
                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade profile-edit pt-3 active show" id="profile-edit" role="tabpanel">
                            <!-- Profile Edit Form -->
                            <form action="<?php echo e(route(__('routes.profile'))); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end"><?php echo e(__('admin.name')); ?> <code>*</code></label>
                                    <div class="col-lg-9">
                                        <input name="name" type="text" value="<?php echo e($user['name']); ?>"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end"><?php echo e(__('email')); ?> <code>*</code></label>
                                    <div class="col-lg-9">
                                        <input name="email" type="text" value="<?php echo e($user['email']); ?>"
                                            class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end"><?php echo e(__('phone')); ?></label>
                                    <div class="col-lg-9">
                                        <input name="phone" type="text" value="<?php echo e($user['phone']); ?>"
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
                                    <label class="col-lg-3 text-end"><?php echo e(__('admin.billing_name')); ?> <code>*</code></label>
                                    <div class="col-lg-9">
                                        <input name="billing_name" value="<?php echo e($user['billing_name']); ?>" type="text"
                                            id="billing_name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end"><?php echo e(__('country')); ?> <code>*</code></label>
                                    <div class="col-lg-9">
                                        <input name="country"
                                            value="<?php echo e($user['country'] != '' ? $user['country'] : 'Magyarország'); ?>"
                                            type="text" id="country" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end"><?php echo e(__('state')); ?> <code>*</code></label>
                                    <div class="col-lg-9">
                                        <input name="state" value="<?php echo e($user['state']); ?>" type="text" id="state"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end"><?php echo e(__('zip')); ?><code>*</code></label>
                                    <div class="col-lg-9">
                                        <input name="zip" value="<?php echo e($user['zip']); ?>" type="number" id="zip"
                                            class="form-control" required>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end"><?php echo e(__('city')); ?> <code>*</code></label>
                                    <div class="col-lg-9">
                                        <input name="city" value="<?php echo e($user['city']); ?>" type="text" id="city"
                                            class="form-control" required>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end"><?php echo e(__('address')); ?> <code>*</code></label>
                                    <div class="col-lg-9" id="city_container">
                                        <input name="address" value="<?php echo e($user['address']); ?>" type="text"
                                            id="address" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end"><?php echo e(__('vat_number')); ?></label>
                                    <div class="col-lg-9">
                                        <input type="text" name="vat_number" class="form-control"
                                            value="<?php echo e($user['vat_number']); ?>">
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend class="offset-md-2"><?php echo e(__('admin.shipping_info')); ?></legend>

                                <div class="row mb-2">
                                    <div class="form-check mb-2 offset-md-2">
                                        <input type="checkbox" class="form-check-input" id="same-address" <?php echo e(isset(Auth::user()->state2) ? '' : 'checked'); ?>>
                                        <label class="form-check-label" for="same-address"><?php echo e(__('same_as_billing_data')); ?></label>
                                    </div>
                                </div>
                                <div class="same_as_billing mb-3" <?php echo isset(Auth::user()->state2) ? '' : 'style="display:none"'; ?>>
                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end"><?php echo e(__('state')); ?></label>
                                    <div class="col-lg-9">
                                        <input name="state2" value="<?php echo e($user['state2']); ?>" type="text"
                                            id="state2" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end"><?php echo e(__('zip')); ?></label>
                                    <div class="col-lg-9">
                                        <input name="zip2" value="<?php echo e($user['zip2']); ?>" type="number" id="zip2"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end"><?php echo e(__('city')); ?></label>
                                    <div class="col-lg-9">
                                        <input name="city2" value="<?php echo e($user['city2']); ?>" type="text"
                                            id="city2" class="form-control">
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <label class="col-lg-3 text-end"><?php echo e(__('address')); ?></label>
                                    <div class="col-lg-9" id="city_container">
                                        <input name="address2" value="<?php echo e($user['address2']); ?>" type="text"
                                            id="address2" class="form-control">
                                    </div>
                                </div>
                                </div>
                            </fieldset>

                                <div class="offset-md-3">
                                    <button type="submit" class="btn btn-primary"><?php echo e(__('admin.save')); ?></button>
                                </div>
                            </form><!-- End Profile Edit Form -->

                        </div>

                        <div class="tab-pane fade pt-3" id="profile-orders" role="tabpanel">
                            <?php if(count($orders) > 0): ?>
                            <table class="table table-striped table-bordered table-hover" id="orders_table">
                                <thead>
                                    <tr>
                                    <th>#ID</th>
                                    <th><?php echo e(__('date')); ?></th>
                                    <th><?php echo e(__('total')); ?></th>
                                    <th><?php echo e(__('admin.shipping')); ?></th>
                                    <th><?php echo e(__('status')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $status = json_decode($o->statuses->translations,true) ?>
                                    <tr>
                                    <td><?php echo e($o['id']); ?></td>
                                    <td><?php echo e($o['created_at']); ?></td>
                                    <td><?php echo e(currency_format($o['total'],$o['currency'])); ?></td>
                                    <td><?php echo e(currency_format($o['shipping_cost'],$o['currency'])); ?></td>
                                    <td>
                                        <span class="badge" style="background-color:<?php echo $o->statuses->color; ?>;"><?php echo e($status[$o['lang']]); ?></span>
                                    </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <?php else: ?>
                            <?php echo e(__('no_orders')); ?>

                            <?php endif; ?>
                        </div>

                        <div class="tab-pane fade pt-3" id="profile-wishlist" role="tabpanel">

                        </div>
                    </div><!-- End Bordered Tabs -->
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/myshop/resources/views/users/profile.blade.php ENDPATH**/ ?>