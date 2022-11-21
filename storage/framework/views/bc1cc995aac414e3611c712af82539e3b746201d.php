<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin/layout/page-header',['page_title'=>$page_title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">

        <?php echo $__env->make('admin.products.components.filter-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
                        <form action="<?php echo e(route('products.export')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <table class="table table-striped table-hover" id="product_list">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" name="select_all" id="product_list_select_all" class="" onclick="$(this).closest('table').find('input[type=checkbox]').prop('checked',$(this).prop('checked'));">
                                    </th>
                                    <th>Id</th>
                                    <th><?php echo e(__('admin.product_name')); ?></th>
                                    <th><?php echo e(__('admin.product_number')); ?></th>
                                    <th><?php echo e(__('admin.category')); ?></th>
                                    <th><?php echo e(__('admin.published')); ?>?</th>
                                    <th><?php echo e(__('admin.featured')); ?>?</th>
                                    <th><?php echo e(__('admin.created')); ?></th>
                                    <th><?php echo e(__('admin.updated')); ?></th>
                                    <th class="text-end"><?php echo e(__('admin.operations')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($products)): ?>
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr id="item-<?php echo e($product['id']); ?>">
                                    <td><input type="checkbox" name="product_ids[]" value="<?php echo e($product['id']); ?>"></td>
                                    <td><?php echo e($product['id']); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('products.edit',$product['id'])); ?>">
                                            <?php echo e(Str::words($product['name'], 3, '...')); ?>

                                        </a>
                                    </td>
                                    <td><?php echo e($product['product_number']); ?></td>
                                    <td>
                                        <?php echo $product['category_name'] ?? ''; ?>

                                    </td>
                                    <td>
                                        <?php echo $product['published'] == 1 ? "<span class='badge bg-success'>".__('yes')."</span>" : "<span class='badge bg-success'>".__('no')."</span>"; ?>

                                    </td>
                                    <td>
                                        <?php echo $product['featured'] == 1 ? "<span class='badge bg-success'>".__('yes')."</span>" : ""; ?>

                                    </td>
                                    <td><?php echo e($product['created_at']); ?></td>
                                    <td><?php echo e($product['updated_at']); ?></td>
                                    <td>
                                        <div class="btn-group" style="float:right">
                                            <a class="btn btn-primary btn-xs" href="<?php echo e(route('products.edit',$product['id'])); ?>">
                                                <i class="bi bi-tools"></i>
                                            </a>
                                            <a class="btn btn-danger btn-xs" href="<?php echo e(route('products.delete', $product['id'])); ?>" onclick="return confirm('<?php echo e(__('admin.msg_are_you_sure')); ?>')">
                                                <i class="bi bi-trash"></i>
                                            </a>
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
                        
                        <div class="pagination my-4">
                            <?php echo e($products->links()); ?>

                        </div>
                        <button type="submit" class="btn btn-primary btn-xs"><?php echo e(__('admin.export')); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/myshop/resources/views/admin/products/index.blade.php ENDPATH**/ ?>