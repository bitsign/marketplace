<?php $__env->startSection('content'); ?>
<section class="section profile">
    <div class="container">
    <div class="row my-3">
        <?php echo $__env->make('layout.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 
        <?php echo $__env->make('vendors.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="col-md-9">
            <div class="card border-0">
                <div class="card-body pt-3">
                   <!-- Profile Edit Form -->
                    <form action="<?php echo e(route('vendor.profile')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                        <div class="row mb-2">
                            <label class="col-lg-3 text-end"><?php echo e(__('name')); ?> <code>*</code></label>
                            <div class="col-lg-9">
                                <input name="name" type="text" value="<?php echo e(old('name')); ?>" class="form-control">
                            </div>
                        </div>
                        
                    

                        <div class="offset-md-3">
                            <button type="submit" class="btn btn-primary"><?php echo e(__('admin.save')); ?></button>
                        </div>
                    </form><!-- End Profile Edit Form -->
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/vendors/add-product.blade.php ENDPATH**/ ?>