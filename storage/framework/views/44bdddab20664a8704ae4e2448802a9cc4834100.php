<?php $__env->startSection('content'); ?>
<section id="products" class="products">
    <div class="container">
        <div class="row">
            
        </div>

        <div class="row">
            <div class="col-md-3">
                <?php echo $__env->make('categories.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="product_count">
                        <h1 class="my-3"><?php echo e($category['name']); ?></h1>
                        <?php //if($total_rows > 0) __('there_are_x_products_in_the_category',false,$total_rows);?>
                    </div>
                </div>
                <div class="row">
                    <?php echo $__env->make('products.list',$products, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <?php echo e($products->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/categories/product-list.blade.php ENDPATH**/ ?>