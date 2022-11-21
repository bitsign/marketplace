<?php $__env->startSection('content'); ?>
<section id="<?php echo e($manufacturer->url); ?>" class="<?php echo e($manufacturer->url); ?>">
    <div class="container">
        <div class="row">
          <div class="col-lg-12 py-3">
            <div class="card mb-3 border-0">
                <?php if($manufacturer->image): ?>
                <img src="<?php echo e(url('files/editor/manufacturers/'.$manufacturer->image)); ?>" class="card-img-top w-auto m-auto" alt="<?php echo e($manufacturer->title); ?>" >
                <?php endif; ?>
                <div class="card-body text-center">
                    <h5 class="card-title text-center">
                        <a class="<?php echo e(request()->segment(2) == $manufacturer->url ? 'active' : ''); ?>" href="<?php echo e(app()->getLocale().'/'.__('routes.manufacturer').'/'.$manufacturer->url); ?>">
                            
                        </a>
                    </h5>
                </div>
            </div>
         </div>
    </div>
    </div>
</section>
<section id="products" class="products py-4">
    <div class="container">
        <div class="row">
            <?php echo $__env->make('products.list',$products, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         </div>
         <?php echo e($products->links()); ?>

    </div>
</section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/myshop/resources/views/manufacturers/show.blade.php ENDPATH**/ ?>