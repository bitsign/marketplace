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
                        <table class="table table-striped table-hover datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('admin.name')); ?></th>
                                    <th><?php echo e(__('admin.code')); ?></th>
                                    <th><?php echo e(__('admin.symbol')); ?></th>
                                    <th><?php echo e(__('admin.format')); ?></th>
                                    <th><?php echo e(__('admin.exchange_rate')); ?></th>
                                    <th><?php echo e(__('admin.active')); ?></th>
                                    <th><?php echo e(__('admin.default')); ?></th>
                                    <th class="text-end"><?php echo e(__('admin.operations')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(count($currencies) > 0): ?>
                                <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($currency->updated_at != $currency->created_at): ?> 
                                        <?php $last_update = $currency->updated_at; ?>
                                    <?php endif; ?>
                                <tr <?php echo $currency->exchange_rate == 1 ? 'class="table-success"' : ''; ?>>
                                    <td><?php echo e($currency->name); ?></td>
                                    <td><?php echo e($currency->code); ?></td>
                                    <td><?php echo e($currency->symbol); ?></td>
                                    <td><?php echo e($currency->format); ?></td>
                                    <td><?php echo e($currency->exchange_rate); ?></td>
                                    <td><?php echo $currency->active == 1
                                            ? '<span class="badge bg-success">' . __('yes') . '</span>'
                                            : '<span class="badge bg-danger">' . __('no') . '</span>'; ?>

                                    </td>
                                    <td><?php echo $currency->exchange_rate == 1
                                            ? '<span class="badge bg-success">' . __('admin.default') . '</span>'
                                            : ''; ?>

                                    </td>
                                    <td>
                                        <div class="btn-group" style="float:right">
                                            <a class="btn btn-primary btn-xs" href="<?php echo e(route('currencies.edit',$currency->id)); ?>"><i class="bi bi-tools"></i></a>
                                            <form action="<?php echo e(route('currencies.destroy', $currency->id)); ?>" method="post">
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
                        <?php 
                            $date = new Carbon\Carbon();
                        ?>
                        <?php if($date->diffInMinutes($last_update) > 5): ?>
                            <a href="<?php echo e(route('update-exchage-rates')); ?>" class="btn btn-warning mb-4">
                                <?php echo e(__('admin.update_exchange_rates')); ?>

                            </a>
                        <?php endif; ?>

                        <div class="alert alert-primary d-flex align-items-center" role="alert">
                           <i class="bi bi-info-circle text-primary"></i> 
                           <div class="ms-3"><?php echo __('admin.currency_text'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/admin/currencies/index.blade.php ENDPATH**/ ?>