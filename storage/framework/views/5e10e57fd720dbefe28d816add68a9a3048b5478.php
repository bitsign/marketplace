<?php $__env->startSection('content'); ?>

<?php echo $__env->make('admin/layout/page-header',['page_title'=>$page_title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header"><b><?php echo e($page_title); ?></b></div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">

                    <div class="col-lg-12"><?php echo $__env->make('layout/messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></div>
                    <form method="post" action="<?php echo e(route('administrators.update',$administrator->id)); ?>" class="form-horizontal" role="form" id="page_form">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.group')); ?> <code>*</code></label>
                            <div class="col-lg-8">
                                <select name="group_id" class="form-select">
                                    <option value="0" <?php if($administrator['group_id'] == 0): echo 'selected'; endif; ?>>Admin</option>
                                    <option value="1" <?php if($administrator['group_id'] == 1): echo 'selected'; endif; ?>>Editor</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.name')); ?> <code>*</code></label>
                            <div class="col-lg-8">
                                <input name="name" type="text" value="<?php echo e($administrator['name']); ?>" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"><?php echo e(__('email')); ?></label>
                            <div class="col-lg-8">
                                <input name="email" type="text" value="<?php echo e($administrator['email']); ?>" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"><?php echo e(__('password')); ?></label>
                            <div class="col-lg-8">
                                <input name="password" type="password" value="" class="form-control">
                            </div>
                        </div>

                        <hr />
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"></label>
                            <div class="col-lg-9">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> <?php echo e(__('admin.save')); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/admin/administrators/edit.blade.php ENDPATH**/ ?>