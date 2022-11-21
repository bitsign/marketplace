<?php $__env->startSection('content'); ?>
<section id="login" class="login">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex justify-content-center py-4">
                    <a href="<?php echo e(url(app()->getLocale())); ?>" class="logo d-flex align-items-center w-auto">
                        <img src="<?php echo e(asset('img/logo.png')); ?>" alt="<?php echo e(SHOP_NAME); ?>">
                    </a>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4"><?php echo e(__('new_password')); ?></h5>
                        </div>
                        <?php echo $__env->make('layout.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <form method="POST" action="<?php echo e(route('password.update')); ?>" class="row g-3">
                        <?php echo csrf_field(); ?>
                            <div class="col-12">
                                <label class="form-label"><?php echo e(__('email')); ?></label>
                                <div class="input-group has-validation">
                                    <input type="email" class="form-control" name="email" value="<?php echo e(old('email',request()->email)); ?>" required autofocus>
                                    <input type="hidden" name="token" value="<?php echo e(request()->route('token')); ?>">
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label"><?php echo e(__('password')); ?></label>
                                <input type="password" class="form-control" name="password" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label"><?php echo e(__('confirm_password')); ?></label>
                                <input id="password_confirmation" class="form-control"
                                    type="password"
                                    name="password_confirmation" required>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit"><?php echo e(__('Reset Password')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/myshop/resources/views/users/reset-password.blade.php ENDPATH**/ ?>