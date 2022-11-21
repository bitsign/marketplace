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
                            <h5 class="card-title text-center pb-0 fs-4"><?php echo e(__('forgot_password')); ?></h5>
                        </div>
                        <?php echo $__env->make('layout.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <form action="<?php echo e(route('forgot-password')); ?>" method="post" class="row g-3">
                            <?php echo csrf_field(); ?>
                            <div class="col-12">
                                <label class="form-label"><?php echo e(__('email')); ?></label>
                                <div class="input-group has-validation">
                                    <input type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit"><?php echo e(__('new_password_button')); ?></button>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 control"></div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 control">
                                    <div class="float-end small">
                                        <a href="<?php echo e(route(__('routes.login'))); ?>" title="<?php echo e(__('login')); ?>">
                                            <i class="bi bi-box-arrow-in-right"></i> <?php echo e(__('login')); ?>

                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/myshop/resources/views/users/forgot-password.blade.php ENDPATH**/ ?>