<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin/layout/page-header', ['page_title' => $page_title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">

            <?php echo $__env->make('admin.vendors.filter-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
                            <form action="" method="post">
                                <?php echo csrf_field(); ?>
                                <table class="table table-striped table-hover" id="vendor_list">
                                    <thead>
                                        <tr>
                                            <!--th>
                                            <input type="checkbox" name="select_all" id="vendor_list_select_all" class="" onclick="$(this).closest('table').find('input[type=checkbox]').prop('checked',$(this).prop('checked'));">
                                        </th -->
                                            <th>Id</th>
                                            <th><?php echo e(__('admin.name')); ?></th>
                                            <th><?php echo e(__('email')); ?></th>
                                            <th><?php echo e(__('phone')); ?></th>
                                            <th><?php echo e(__('admin.active')); ?>?</th>
                                            <th><?php echo e(__('admin.language')); ?>?</th>
                                            <th><?php echo e(__('admin.created')); ?></th>
                                            <th><?php echo e(__('admin.updated')); ?></th>
                                            <th class="text-end"><?php echo e(__('admin.operations')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($vendors[0])): ?>
                                            <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr id="item-<?php echo e($vendor['id']); ?>">
                                                    <!--td><input type="checkbox" name="vendor_ids[]" value="<?php echo e($vendor['id']); ?>"></td-->
                                                    <td><?php echo e($vendor['id']); ?></td>
                                                    <td>
                                                        <a href="<?php echo e(route('vendors.edit', $vendor['id'])); ?>">
                                                            <?php echo e(Str::words($vendor['name'], 3, '...')); ?>

                                                        </a>
                                                    </td>
                                                    <td><?php echo e($vendor['email']); ?></td>
                                                    <td><?php echo e($vendor['phone']); ?></td>
                                                    <td>
                                                        <?php echo $vendor['active'] == 1
                                                            ? "<span class='badge bg-success'>" . __('yes') . '</span>'
                                                            : "<span class='badge bg-success'>" . __('no') . '</span>'; ?>

                                                    </td>
                                                    <td><img src="<?php echo e(url('assets/img/'.$vendor['lang'].'.png')); ?>"></td>
                                                    <td><?php echo e($vendor['created_at']); ?></td>
                                                    <td><?php echo e($vendor['updated_at']); ?></td>
                                                    <td>
                                                        <div class="btn-group" style="float:right">
                                                            <a class="btn btn-primary btn-xs"
                                                                href="<?php echo e(route('vendors.edit', $vendor['id'])); ?>">
                                                                <i class="bi bi-tools"></i>
                                                            </a>
                                                            <a class="btn btn-danger btn-xs"
                                                                href="<?php echo e(route('vendors.delete', $vendor['id'])); ?>"
                                                                onclick="return confirm('<?php echo e(__('admin.msg_are_you_sure')); ?>')">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="9"><?php echo e(__('admin.no_data')); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>

                                </table>
                                <div class="pagination my-4">
                                    <?php echo e($vendors->links()); ?>

                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/admin/vendors/index.blade.php ENDPATH**/ ?>