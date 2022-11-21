<?php $__env->startSection('content'); ?>
<section class="h-100">
    <div class="container py-5">
        <?php if($message = Session::get('success')): ?>
            <div class="p-4 mb-3 alert alert-success">
                <?php echo e($message); ?>

            </div>
        <?php endif; ?>
        <div class="row d-flex justify-content-center my-4">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0"><?php echo e(__('cart')); ?></h5>
                    </div>
                    <div class="card-body">
                        <?php
                            $cart_shipping_id = "";
                            $cart_payment_id = "";
                            $style = "";
                        ?>
                        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <!-- Single item -->
                            <div class="row">
                                <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                    <!-- Image -->
                                    <div class="bg-image hover-overlay hover-zoom rounded">
                                        <img src="<?php echo e(url('files/products/small/')); ?>/<?php echo e($item->attributes->image ?? 'no-image.png'); ?>"
                                            class="w-100" />
                                    </div>
                                    <!-- Image -->
                                </div>

                                <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                    <!-- Data -->
                                    <p><strong><?php echo e($item->name); ?></strong></p>
                                    
                                    <?php if($item->attributes->options): ?>
                                        <?php $__currentLoopData = $item->attributes->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo e($key); ?>: <?php echo e($value); ?><br>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>

                                    <form action="<?php echo e(route('cart.remove')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" value="<?php echo e($item->id); ?>" name="id">
                                        <button type="submit" class="btn btn-danger btn-sm me-1 mb-2"
                                            data-mdb-toggle="tooltip" title="Remove item">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                    <!-- Data -->
                                </div>

                                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                    <!-- Quantity -->
                                    <form action="<?php echo e(route('cart.update')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="id" value="<?php echo e($item->id); ?>">
                                        <div class="d-flex mb-4" style="max-width: 300px">
                                            <div class="input-group">
                                                <button class="btn btn-primary"
                                                    onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                    <i class="bi bi-dash-lg"></i>
                                                </button>
                                                <input name="quantity" value="<?php echo e($item->quantity); ?>" type="number" class="form-control" min="1" />
                                                <button class="btn btn-primary"
                                                    onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                    <i class="bi bi-plus-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- Quantity -->

                                    <!-- Price -->
                                    <p class="text-start text-md-center">
                                        <strong><?php echo e(currency($item->price)); ?></strong>
                                    </p>
                                    <!-- Price -->
                                </div>
                            </div>
                            <!-- Single item -->

                            <hr class="my-4" />
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php if(Cart::isEmpty() === false): ?>
                        <form action="<?php echo e(url(app()->getLocale() . '/checkout')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <h4 class="mb-3"><?php echo e(__('shipping_methods')); ?></h4>

                            <div class="my-3">
                                <?php $__currentLoopData = $transportOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $to): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $tr_translation = json_decode($to['translations'],true) ?>
                                    <div class="form-check">
                                        <input id="transport_<?php echo e($to['id']); ?>" name="shipping" type="radio"
                                            class="form-check-input shopping_method"
                                            <?php echo e($to['name'] == $selected_shipping ? 'checked' : ''); ?> required
                                            value="<?php echo e($to['code']); ?>"
                                            data-possible_payments = "<?php echo e(implode("|",json_decode($to['possible_payments'],true))); ?>"
                                            data-id = "<?php echo e($to['id']); ?>"
                                            data-name = "<?php echo e($to['name']); ?>"
                                            >
                                        <label class="form-check-label"
                                            for="transport_<?php echo e($to['id']); ?>"><?php echo e($tr_translation['name'][app()->getLocale()]); ?> 
                                            <?php echo e($to['value'] != 0 ? '(+'.currency($to['value']).')' : ''); ?>

                                            <span class="badge rounded-pill bg-info" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-html="true" title="<?php echo e($tr_translation['description'][app()->getLocale()]); ?>">
                                                i
                                            </span>
                                        </label>
                                    </div>
                                    <?php
                                        if($selected_shipping==$to['name'])
                                            $visible_payments = json_decode($to['possible_payments'],true);
                                    ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <hr class="my-4">

                            <h4 class="mb-3"><?php echo e(__('payment_methods')); ?></h4>

                            <div class="payment_methods my-3">
                                <div class="payments_loading"></div>
                                <?php $__currentLoopData = $paymentModes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $style = 'display:none;';
                                        if(!empty($visible_payments))
                                        {
                                            if(in_array($pm['code'], $visible_payments))
                                                $style = "";
                                            else
                                                $style = 'display:none;';

                                        }
                                        $pm_translation = json_decode($pm['translations'],true)
                                    ?>
                                    <div class="form-check payment_method" id="payment_<?php echo e($pm['code']); ?>" style="<?php echo e($style); ?>">
                                        <input name="payment" type="radio" id="payment-<?php echo e($pm['code']); ?>"
                                            class="form-check-input"
                                            <?php echo e($pm['name'] == $selected_payment ? 'checked' : ''); ?> required
                                            value="<?php echo e($pm['code']); ?>">
                                        <label class="form-check-label" for="payment-<?php echo e($pm['code']); ?>"><?php echo e($pm_translation['name'][app()->getLocale()]); ?>

                                            <span class="badge rounded-pill bg-info" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-html="true" title="<?php echo e($pm_translation['description'][app()->getLocale()]); ?>">
                                                i
                                            </span>
                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <hr class="my-4">
                            <button type="submit" class="btn btn-success float-end">
                                <?php echo e(__('go_to_checkout')); ?>

                            </button>
                        </form>
                        <?php endif; ?>

                        <?php if(Cart::isEmpty()): ?>
                            <div class="alert alert-info"><?php echo e(__('empty_cart')); ?></div>

                            <a href="<?php echo e(url(app()->getLocale())); ?>"
                                class="btn btn-primary"><?php echo e(__('continue_shopping')); ?></a>
                        <?php else: ?>
                            <form action="<?php echo e(route('cart.clear')); ?>" method="POST" class="float-start">
                                <?php echo csrf_field(); ?>
                                <button class="btn btn-warning"><i class="bi bi-trash"></i>
                                    <?php echo e(__('delete_cart')); ?></button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0"><?php echo e(__('order_summary')); ?></h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                <?php echo e(__('products')); ?> (<?php echo e(Cart::getTotalQuantity()); ?> <?php echo e(__('unit.unit_1')); ?>)
                                <span><?php echo e(currency(Cart::getSubTotal())); ?></span>
                            </li>

                            <?php $__currentLoopData = Cart::getConditions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $condition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <?php echo e($condition->getName()); ?>

                                    <span><?php echo e(currency($condition->getValue())); ?></span>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                <div>
                                    <strong><?php echo e(__('total')); ?></strong>
                                    <strong>
                                        <p class="mb-0">(<?php echo e(__('including VAT')); ?>)</p>
                                    </strong>
                                </div>
                                <span><strong><?php echo e(currency(Cart::getTotal())); ?></strong></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/cart/cart.blade.php ENDPATH**/ ?>