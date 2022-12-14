<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin/layout/page-header', ['page_title' => $page_title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header"><?php echo e($page_title); ?></div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <form method="post" action="<?php echo e(route('vendors.store')); ?>" class="form-horizontal" role="form"
                        id="add_vendor_form">
                        <?php echo csrf_field(); ?>
                        <fieldset>
                            <?php echo $__env->make('layout/messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <legend><?php echo e(__('admin.account_informations')); ?></legend>
                            <div class="mb-2 row">
                                <label class="col-lg-3 text-lg-end"><?php echo e(__('admin.language')); ?> <code>*</code></label>
                                <div class="col-lg-9">
                                    <select name="lang" class="form-select" required>
                                        <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($lang); ?>")>
                                            <?php echo e($key); ?>

                                        </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-lg-3 text-end"><?php echo e(__('admin.name')); ?> <code>*</code></label>
                                <div class="col-lg-9">
                                    <input name="name" type="text" value="<?php echo e(old('name')); ?>"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-lg-3 text-end"><?php echo e(__('email')); ?> <code>*</code></label>
                                <div class="col-lg-9">
                                    <input name="email" type="text" value="<?php echo e(old('email')); ?>"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-lg-3 text-end"><?php echo e(__('phone')); ?></label>
                                <div class="col-lg-9">
                                    <input name="phone" type="text" value="<?php echo e(old('phone')); ?>"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-lg-3 text-end"><?php echo e(__('password')); ?> <code>*</code></label>
                                <div class="col-lg-9">
                                    <input name="password" type="password" value="" class="form-control"
                                        autocomplete="off" id="password">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-lg-3 text-end"><?php echo e(__('password_confirm')); ?> <code>*</code></label>
                                <div class="col-lg-9">
                                    <input name="confirm_password" type="password" value="" class="form-control"
                                        id="confirm_password" autocomplete="off">
                                </div>
                            </div>
                            <!--div class="row mb-2">
                                <label class="col-lg-3 text-end"><?php echo e(__('admin.group')); ?></label>
                                <div class="col-lg-9">
                                    
                                </div>
                            </div-->
                            <div class="mb-3 row">
                                <label class="col-lg-3 text-lg-end"><?php echo e(__('admin.active')); ?>?</label>
                                <div class="col-lg-9">
                                    <input type="checkbox" data-onstyle="success" data-offstyle="danger"
                                        data-size="mini" data-on="Igen" data-off="Nem" data-toggle="toggle"
                                        name="active" value="1" checked />
                                </div>
                            </div>
                            <!--div class="row mb-2">
                                <label class="col-lg-3 text-end"><?php echo e(__('admin.discount')); ?></label>
                                <div class="col-lg-9">
                                    <input name="discount" type="text" value="<?php echo e(old('discount')); ?>" class="form-control">
                                </div>
                            </div-->
                        </fieldset>
                        <fieldset>
                            <legend><?php echo e(__('admin.billing_info')); ?></legend>
                            <div class="row mb-2">
                                <label class="col-lg-3 text-end"><?php echo e(__('admin.billing_name')); ?> <code>*</code></label>
                                <div class="col-lg-9">
                                    <input name="billing_name" value="<?php echo e(old('billing_name')); ?>" type="text"
                                        id="billing_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-lg-3 text-end"><?php echo e(__('country')); ?> <code>*</code></label>
                                <div class="col-lg-9">
                                    <input name="country" value="<?php echo e('Magyarorsz??g'); ?>" type="text" id="country"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-lg-3 text-end"><?php echo e(__('state')); ?> <code>*</code></label>
                                <div class="col-lg-9">
                                    <input name="state" value="<?php echo e(old('state')); ?>" type="text" id="state"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-lg-3 text-end"><?php echo e(__('zip')); ?><code>*</code></label>
                                <div class="col-lg-9">
                                    <input name="zip" value="<?php echo e(old('zip')); ?>" type="number" id="zip"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-lg-3 text-end"><?php echo e(__('city')); ?> <code>*</code></label>
                                <div class="col-lg-9">
                                    <input name="city" value="<?php echo e(old('city')); ?>" type="text" id="city"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-lg-3 text-end"><?php echo e(__('address')); ?> <code>*</code></label>
                                <div class="col-lg-9" id="city_container">
                                    <input name="address" value="<?php echo e(old('address')); ?>" type="text"
                                        id="address" class="form-control" required>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-lg-3 text-end"><?php echo e(__('vat_number')); ?></label>
                                <div class="col-lg-9">
                                    <input type="text" name="vat_number" class="form-control"
                                        value="<?php echo e(old('vat_number')); ?>">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Admin <?php echo e(__('note')); ?></legend>
                            <div class="row mb-2 ">
                                <label class="col-lg-3 text-end"><?php echo e(__('note')); ?></label>
                                <div class="col-lg-9">
                                    <input name="admin_note" value="<?php echo e(old('admin_note')); ?>" type="text"
                                        id="admin_note" class="form-control">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-lg-3 text-end"></label>
                                <div class="col-lg-9">
                                    <button type="submit" class="btn btn-primary"><?php echo e(__('admin.save')); ?></button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/admin/vendors/create.blade.php ENDPATH**/ ?>