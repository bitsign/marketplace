<?php $__env->startSection('content'); ?>
<section id="products" class="products">
    <div class="container" data-aos="fade-up">
        <div class="row mb-3">
            <div class="col-lg-12"><?php echo $__env->make('layout/messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></div>

            <div class="col-md-6" id="lightgallery">
                <div class="main_image mb-3">
                    <a
                      href="<?php echo e(url('files/products/large')); ?>/<?php echo e(!empty($main_image->filename) ? $main_image->filename : 'no-image.png'); ?>"
                      title="<?php echo e($main_image->title ?? ''); ?>"
                    >
                        <img src="<?php echo e(url('files/products/medium')); ?>/<?php echo e(!empty($main_image->filename) ? $main_image->filename : 'no-image.png'); ?>" class="card-img-top" title="<?php echo e($main_image->title ?? ''); ?>" alt="<?php echo e($main_image->name ?? ''); ?>">
                    </a>
                </div>
                <?php if(!empty($gallery)): ?>
                    <div class="row">
                    <?php $__currentLoopData = $gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-2 m-1">
                            <a
                              href="<?php echo e(url('files/products/large')); ?>/<?php echo e(!empty($g->filename) ? $g->filename : 'no-image.png'); ?>"
                              title="<?php echo e($g->title ?? ''); ?>"
                            >
                                <img src="<?php echo e(url('files/products/small')); ?>/<?php echo e(!empty($g->filename) ? $g->filename : 'no-image.png'); ?>" class="card-img-top" title="<?php echo e($g->title); ?>" alt="<?php echo e($main_image->name); ?>">
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6">

                <h1 class="mb-3"><?php echo e($product->name); ?></h1>

                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item w-50"><b><?php echo e(__('product_number')); ?></b></li>
                  <li class="list-group-item w-50"><?php echo e($product->product_number); ?></li>
                </ul>
                
                <?php if(!empty($product->manufacturer->name)): ?>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item w-50"><b><?php echo e(__('manufacturer')); ?></b></li>
                  <li class="list-group-item w-50"><?php echo e($product->manufacturer->name); ?></li>
                </ul>
                <?php endif; ?>

                <?php if($product->weight != 0): ?>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item w-50"><b><?php echo e(__('weight')); ?></b></li>
                  <li class="list-group-item w-50"><?php echo e($product->weight); ?> g</li>
                </ul>
                <?php endif; ?>

                <?php if($product->shipping_cost != 0): ?>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item w-50"><b><?php echo e(__('shipping_cost')); ?></b></li>
                  <li class="list-group-item w-50"><?php echo e(currency($product->shipping_cost)); ?></li>
                </ul>
                <?php endif; ?>

                <?php if($product->warranty != 0): ?>
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item w-50"><b><?php echo e(__('warranty')); ?></b></li>
                  <li class="list-group-item w-50"><?php echo e($product->warranty); ?> <?php echo e(__('month')); ?></li>
                </ul>
                <?php endif; ?>

                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item w-50"><b><?php echo e(__('stock')); ?></b></li>
                  <li class="list-group-item w-50"><?php echo e($product->stock); ?> <?php echo e(__('unit.unit_'.$product->unit_id)); ?></li>
                </ul>

                <?php if($product->action_price != 0): ?>
                    <h6 class="my-3 text-decoration-line-through"><?php echo e(__('price')); ?>: <?php echo e(currency($product->price)); ?></h6>
                    <h4 class="my-3 text-success"><?php echo e(__('action_price')); ?>: <?php echo e(currency($product->action_price)); ?></h4>
                <?php else: ?>
                    <h4 class="my-3 text-success"><?php echo e(__('price')); ?>: <?php echo e(currency($product->price)); ?></h4>
                <?php endif; ?>

                <form action="<?php echo e(route('cart.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <?php if(!empty($attributes)): ?>
                        <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attr_id => $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $att['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!empty($opt['value']) && is_array($opt['value']) && !empty($opt['type'])): ?>

                                    <?php if($opt['type'] == 'radio'): ?>
                                        <?php $__currentLoopData = $opt['value']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <input name="options-<?php echo e($attr_id); ?>" type="radio" class="btn-check" id="btn-check-<?php echo e($val); ?>" autocomplete="off">
                                            <label class="btn btn-outline-secondary mb-1" for="btn-check-<?php echo e($val); ?>"><?php echo e($val); ?></label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>

                                <?php elseif(is_array(@$opt['value'])): ?>
                                    <?php echo e($opt['name']); ?>: 
                                    <select name="option[<?php echo e($opt['name']); ?>]" required class="form-select mb-2">
                                        <?php $__currentLoopData = $opt['value']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $okey => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value); ?>"><?php echo e($value); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                <?php else: ?>
                                    <?php echo e($opt['name']); ?>: <?php echo e($opt['value'] ?? ''); ?><br>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                    <input type="hidden" value="<?php echo e($product->id); ?>" name="id">
                    <input type="hidden" value="<?php echo e($product->name); ?>" name="name">
                    <input type="hidden" value="<?php echo e($product->product_number); ?>" name="product_number">
                    <input type="hidden" value="<?php echo e($product->action_price != 0 ? $product->action_price : $product->price); ?>" name="price">
                    <input type="hidden" value="<?php echo e(!empty($main_image->filename) ? $main_image->filename : 'no-image.png'); ?>"  name="image">
                    <input type="hidden" value="<?php echo e($product->shipping_cost != 0 ? $product->shipping_cost : ""); ?>" name="shipping_cost">
                    <input type="hidden" value="<?php echo e($product->unit_id != 0 ? __('unit.unit_'.$product->unit_id) : __('unit.unit_1')); ?>" name="unit">
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" value="1" min="1" name="quantity">
                        <button class="btn btn-success btn-block text-center"><?php echo e(__('add_to_cart_button')); ?></button>
                    </div>
                </form>

            </div>
            <div class="col-md-12">
                <h2><?php echo e(__('description')); ?></h2>
                <?php echo $product->details; ?>

            </div>

         </div>

         <?php if(!empty($attached_products)): ?>
             <h3><?php echo e(__('related_products')); ?></h3>
             <div class="row py-3">
                <?php echo $__env->make('products.list',['products'=>$attached_products], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
             </div>
         <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/myshop/resources/views/products/product.blade.php ENDPATH**/ ?>