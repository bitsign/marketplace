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
                    <form action="<?php echo e(route('products.import')); ?>" method="POST" enctype="multipart/form-data" id="fileUploadForm">
                        <?php echo csrf_field(); ?>
                        <input type="file" name="file" class="form-control">
                        <br>
                        <button class="btn btn-success"><?php echo e(__('admin.product_import')); ?></button>
                    
                        
                    </form>
                </div>
            </div>
        </div>

        <div class="card shadow mt-3">
            <div class="card-header">
                <?php echo e(__('admin.import_translations')); ?>

                <form action="<?php echo e(route('products.export-tr')); ?>" method="post" class="float-end">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-info text-white btn-xs"><?php echo e(__('admin.export_translations')); ?></button>
                </form>
            </div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <form action="<?php echo e(route('products.import-tr')); ?>" method="POST" enctype="multipart/form-data" id="fileUploadForm" class="float-start">
                        <?php echo csrf_field(); ?>
                        <input type="file" name="file" class="form-control">
                        <br>
                        <button class="btn btn-primary"><?php echo e(__('admin.import_translations')); ?></button>
                    </form>
                    
                </div>
            </div>
            <div class="card-footer">
                
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/admin/products/import.blade.php ENDPATH**/ ?>