<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin/layout/page-header', ['page_title' => $page_title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header"><?php echo e($page_title); ?></div>
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-lg-12"><?php echo $__env->make('layout/messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></div>
                        <div class="table-responsive">
                            <table class="table table-striped sortable table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('admin.sort_order')); ?></th>
                                        <th width="250px"><?php echo e(__('admin.title')); ?></th>
                                        <th><?php echo e(__('admin.active')); ?>?</th>
                                        <th><?php echo e(__('admin.image')); ?></th>
                                        <th class="text-end"><?php echo e(__('admin.operations')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($banners)): ?>
                                        <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr id="item-<?php echo e($banner['id']); ?>">
                                                <td><a class="handle1 btn btn-primary btn-xs"><i
                                                            class="bi bi-arrow-down-up"></i></a></td>
                                                <td><a href="<?php echo e(url('admin/banners/'.$banner['id'])); ?>"><?php echo e($banner['title']); ?></a></td>
                                                <td>
                                                    <?php echo $banner['active'] == 1
                                                        ? '<span class="badge bg-success">' . __('yes') . '</span>'
                                                        : '<span class="badge bg-danger">' . __('no') . '</span>'; ?>

                                                </td>
                                                <td><img src="<?php echo e(url('files/editor/' . $banner['image'])); ?>"
                                                        width="70px"></td>
                                                <td>
                                                    <div class="btn-group" style="float:right">
                                                        <a class="btn btn-primary btn-xs"
                                                            href="banners/<?php echo e($banner['id']); ?>"><i
                                                                class="bi bi-tools"></i></a>
                                                        <form action="<?php echo e(route('banners.destroy', $banner)); ?>"
                                                            method="post">
                                                            <?php echo method_field('DELETE'); ?>
                                                            <?php echo csrf_field(); ?>
                                                            <button type="submit" class="btn btn-danger btn-xs"
                                                                id="delete"
                                                                onclick="return confirm('<?php echo e(__('admin.msg_are_you_sure')); ?>')">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7"><?php echo e(__('admin.no_data')); ?></td>
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

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/admin/banners/index.blade.php ENDPATH**/ ?>