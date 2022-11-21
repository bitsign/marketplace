<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin/layout/page-header', ['page_title' => $page_title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header"><?php echo e($page_title); ?></div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <form method="post" action="<?php echo e(route('users.update', $user)); ?>" class="form-horizontal" role="form"
                        id="user_form">
                        <?php echo method_field('PUT'); ?>
                        <?php echo csrf_field(); ?>
                        <fieldset>
                            <?php echo $__env->make('layout/messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <legend><?php echo e(__('admin.account_informations')); ?></legend>
                            <div class="mb-2 row">
                                <label class="col-lg-3 text-lg-end"><?php echo e(__('admin.language')); ?> <code>*</code></label>
                                <div class="col-lg-9">
                                    <select name="lang" class="form-select" required>
                                        <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($lang); ?>"  <?php if($user['lang'] == $lang): echo 'selected'; endif; ?>>
                                            <?php echo e($key); ?>

                                        </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
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
                            <!--div class="row mb-2">
                                <label class="col-lg-3 text-end"><?php echo e(__('admin.group')); ?></label>
                                <div class="col-lg-9">
                                    
                                </div>
                            </div-->
                            <div class="mb-3 row">
                                <label class="col-lg-3 text-lg-end"><?php echo e(__('admin.active')); ?>?</label>
                                <div class="col-lg-9">
                                    <input type="checkbox" data-onstyle="success" data-offstyle="danger"
                                        data-size="mini" data-on="<?php echo e(__('yes')); ?>" data-off="<?php echo e(__('no')); ?>"
                                        data-toggle="toggle" name="active" value="1"
                                        <?php echo e(!empty($user['active']) ? 'checked' : ''); ?> />
                                </div>
                            </div>
                            <!--div class="row mb-2">
                                <label class="col-lg-3 text-end"><?php echo e(__('admin.discount')); ?></label>
                                <div class="col-lg-9">
                                    <input name="discount" type="text" value="<?php echo e($user['discount']); ?>" class="form-control">
                                </div>
                            </div-->
                        </fieldset>
                        <fieldset>
                            <legend><?php echo e(__('admin.billing_info')); ?></legend>
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
                                <label class="col-lg-3 text-end"><?php echo e(__('company_vat_number')); ?></label>
                                <div class="col-lg-9">
                                    <input type="text" name="vat_number" class="form-control"
                                        value="<?php echo e($user['vat_number']); ?>">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend><?php echo e(__('admin.shipping_info')); ?></legend>
                            <div class="row mb-2">
                                <label class="col-lg-3 text-end"><?php echo e(__('country')); ?></label>
                                <div class="col-lg-9">
                                    <input name="country2"
                                        value="<?php echo e($user['country2'] != '' ? $user['country2'] : 'Magyarország'); ?>"
                                        type="text" id="country2" class="form-control">
                                </div>
                            </div>
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
                        </fieldset>
                        <fieldset>
                            <legend>Admin <?php echo e(__('note')); ?></legend>
                            <div class="row mb-2 ">
                                <label class="col-lg-3 text-end"><?php echo e(__('note')); ?></label>
                                <div class="col-lg-9">
                                    <input name="admin_note" value="<?php echo e($user['admin_note']); ?>" type="text"
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

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/admin/users/edit.blade.php ENDPATH**/ ?>