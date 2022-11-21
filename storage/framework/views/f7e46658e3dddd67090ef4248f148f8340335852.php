<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin/layout/page-header',['page_title'=>$page_title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <b><?php echo e($page_title); ?></b>
            </div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-lg-12">
                        <?php echo $__env->make('layout/messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('admin.name')); ?></th>
                                    <th><?php echo e(__('email')); ?></th>
                                    <th><?php echo e(__('admin.created')); ?></th>
                                    <th class="text-end"><?php echo e(__('admin.operations')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(count($administrators) > 0): ?>
                                <?php $__currentLoopData = $administrators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $administrator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><a href="<?php echo e(route('administrators.edit',$administrator)); ?>"><?php echo e($administrator->name); ?></a></td>
                                    <td><?php echo e($administrator->email); ?></td>
                                    <td><?php echo e($administrator->created_at); ?></td>
                                    <td>
                                        <div class="btn-group" style="float:right">
                                            <a class="btn btn-primary btn-xs" href="<?php echo e(route('administrators.edit',$administrator->id)); ?>"><i class="bi bi-tools"></i></a>
                                            <form action="<?php echo e(route('administrators.destroy', $administrator->id)); ?>" method="post">
                                                <?php echo method_field('DELETE'); ?>
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-danger btn-xs" id="delete" onclick="return confirm('<?php echo e(__('admin.msg_are_you_sure')); ?>')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="4"><?php echo e(__('admin.no_data')); ?></td>
                            </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/admin/administrators/index.blade.php ENDPATH**/ ?>