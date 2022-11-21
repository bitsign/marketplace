<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin/layout/page-header',['page_title'=>$page_title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <?php echo e($page_title); ?>

            </div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-lg-12">
                        <?php echo $__env->make('layout/messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="orders_table">
                            <thead>
                                <tr>
                                <th>#ID</th>
                                <th><?php echo e(__('admin.name')); ?></th>
                                <th><?php echo e(__('address')); ?></th>
                                <th><?php echo e(__('date')); ?></th>
                                <th><?php echo e(__('total')); ?></th>
                                <th><?php echo e(__('admin.shipping')); ?></th>
                                <th class="text-end"><?php echo e(__('admin.operations')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($orders)): ?>
                                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                    <td><?php echo e($o['id']); ?></td>
                                    <td><?php echo e(!empty($o->user->name) ?$o->user->name : "Törölt felhasználó"); ?>

                                        <?php echo e($o->user->phone); ?><br />
                                        <?php echo e($o->user->email); ?><br />
                                    </td>
                                    <td>
                                        <span class="text-success">
                                            <?php echo e($o->user->zip); ?>, <?php echo e($o->user->city); ?>,
                                            <?php echo e($o->user->location); ?>

                                            <?php echo e($o->user->state); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($o['created_at']); ?></td>
                                    <td><?php echo e(number_format($o['total'])); ?></td>
                                    <td><?php echo e(number_format($o['shipping_cost'])); ?></td>
                                    <td>
                                        <div class="btn-group" style="float:right">
                                            <a class="btn btn-xs btn-info" href="<?php echo e(route('orders.edit',$o['id'])); ?>">
                                                <i class="bi bi-tools"></i>
                                            </a>
                                            <form action="<?php echo e(route('orders.destroy', $o->id)); ?>" method="post">
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
                            <?php endif; ?>
                            </tbody>
                        </table>

                        <div class="card-footer">
                            <form>
                                <input type="hidden" name="export" value="1" />
                                <button class="btn btn-primary" type="submit"><?php echo e(__('admin.export_orders')); ?></button>
                            </form>
                        </div>
                        <div class="pagination my-4">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/myshop/resources/views/admin/orders/deleted.blade.php ENDPATH**/ ?>