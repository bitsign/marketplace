<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin/layout/page-header', ['page_title' => $page_title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header"><b><?php echo e($page_title); ?></b></div>
                <div class="card-body">
                    <div class="row no-gutters align-items-center">

                        <div class="col-lg-12"><?php echo $__env->make('layout/messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></div>

                        <form method="post" action="<?php echo e(route('payment-methods.update', $paymentMethod)); ?>"
                            class="form-horizontal" role="form" id="payment_form">
                            <?php echo method_field('PUT'); ?>
                            <?php echo csrf_field(); ?>

                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.title')); ?> <code>*</code></label>
                                <div class="col-lg-10">
                                    <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"><img src="<?php echo e(url('assets/img/' . $lang . '.png')); ?>"
                                                width="18px"></span>
                                        <input name="translations[name][<?php echo e($lang); ?>]" type="text"
                                            value="<?php echo e($translations['name'][$lang] ?? ''); ?>" class="form-control" required>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.id')); ?> <code>*</code></label>
                                <div class="col-lg-10">
                                    <input name="code" type="text" value="<?php echo e($paymentMethod['code']); ?>"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.price')); ?></label>
                                <div class="col-lg-10">
                                    <input name="value" type="text" value="<?php echo e($paymentMethod['value']); ?>"
                                        class="form-control">
                                </div>
                            </div>

                            <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.description')); ?> <img
                                        src="<?php echo e(url('assets/img/' . $lang . '.png')); ?>" width="18px"></label>
                                <div class="col-lg-10">
                                    <textarea class="editor form-control" name="translations[description][<?php echo e($lang); ?>]" rows="10" cols="80"><?php echo e($translations['description'][$lang] ?? ''); ?></textarea>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.active')); ?>?</label>
                                <div class="col-lg-10">
                                    <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini"
                                        data-on="Igen" data-off="Nem" data-toggle="toggle" name="active" value="1"
                                        <?php echo e(!empty($paymentMethod['active']) || empty($paymentMethod['id']) ? 'checked' : ''); ?> />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.sort_order')); ?></label>
                                <div class="col-lg-10">
                                    <input name="sort" value="<?php echo e($paymentMethod['sort'] ?? 0); ?>" type="text"
                                        class="form-control">
                                </div>
                            </div>
                            <hr />
                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end"></label>
                                <div class="col-lg-9">
                                    <button type="submit" class="btn btn-primary"><?php echo e(__('admin.save')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/admin/payments/edit.blade.php ENDPATH**/ ?>