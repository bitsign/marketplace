<?php $__env->startSection('content'); ?>
<section class="section profile">
    <div class="container">
    <div class="row my-3">
        <?php echo $__env->make('layout.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 
        <?php echo $__env->make('vendors.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="col-md-9">
            <div class="card border-0">
                <div class="card-body pt-3">
                   <?php if(count($sales) > 0): ?>
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
                        <?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                    <?php echo e(__('No Data')); ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/vendors/sales.blade.php ENDPATH**/ ?>