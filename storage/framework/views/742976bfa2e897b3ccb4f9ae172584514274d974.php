<?php $__env->startSection('content'); ?>
<section id="login" class="login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card my-3">
                    <div class="card-body">
                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4"><?php echo e(__('login')); ?></h5>
                        </div>
                        <?php echo $__env->make('layout.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <form action="<?php echo e(route('vendor.login')); ?>" method="post" class="row g-3">
                            <?php echo csrf_field(); ?>
                            <div class="col-12">
                                <label class="form-label"><?php echo e(__('email')); ?></label>
                                <div class="input-group has-validation">
                                    <input type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label"><?php echo e(__('password')); ?></label>
                                <input type="password" class="form-control" name="password" required>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe"><?php echo e(__('remember_me')); ?></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit"><?php echo e(__('login')); ?></button>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 control">
                                    <div class="small"></div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 control">
                                    <div class="float-end small">
                                        <a href="<?php echo e(route(__('routes.forgot-password'))); ?>" title="<?php echo e(__('forgot-password')); ?>">
                                            <?php echo e(__('forgot_password')); ?>?
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card my-3">
                    <div class="card-body">
                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4"><?php echo e(__('register')); ?></h5>
                        </div>
                        <?php echo $__env->make('layout.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <form action="<?php echo e(route('vendor.register')); ?>" method="post" class="row g-3">
                        <?php echo csrf_field(); ?>
                        <div class="col-12">
                            <label for="yourName" class="form-label"><?php echo e(__('name')); ?></label>
                            <input type="text" name="name" class="form-control" id="yourName" value="<?php echo e(old('name')); ?>" required>
                        </div>

                        <div class="col-12">
                            <label for="yourEmail" class="form-label"><?php echo e(__('email')); ?></label>
                            <input type="email" name="email" class="form-control" id="yourEmail" value="<?php echo e(old('email')); ?>" required>
                        </div>

                        <div class="col-12">
                            <label for="yourPassword" class="form-label"><?php echo e(__('password')); ?></label>
                            <input type="password" name="password" class="form-control" id="yourPassword" required="">
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required="">
                                <label class="form-check-label" for="acceptTerms">
                                <?php echo __('I agree to the :terms_of_service and :privacy_policy',
                                        [
                                            'terms_of_service' => '<a href="'.url(app()->getLocale().'/'.__('routes.page').'/'.__('routes.terms')).'">'.__('terms_of_service').'</a>',
                                            'privacy_policy'   => '<a href="'.url(app()->getLocale().'/'.__('routes.page').'/'.__('routes.privacy_policy')).'">'.__('privacy_policy').'</a>'
                                        ]
                                    ); ?>

                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit"><?php echo e(__('i_register')); ?></button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/myshop/resources/views/vendors/login.blade.php ENDPATH**/ ?>