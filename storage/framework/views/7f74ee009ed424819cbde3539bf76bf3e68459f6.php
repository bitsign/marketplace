<?php $__env->startSection('content'); ?>

<?php echo $__env->make('admin/layout/page-header',['page_title'=>$page_title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header"><b><?php echo e($page_title); ?></b></div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">

                    <div class="col-lg-12"><?php echo $__env->make('layout/messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></div>

                    <form method="post" action="<?php echo e(route('shipping-methods.update',$shippingMethod)); ?>" class="form-horizontal" role="form" id="shipping_form">
                        <?php echo method_field('PUT'); ?>
                        <?php echo csrf_field(); ?>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.title')); ?> <code>*</code></label>
                            <div class="col-lg-10">
                                <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"><img src="<?php echo e(url('assets/img/' . $lang . '.png')); ?>"
                                                width="18px"></span>
                                        <input name="translations[name][<?php echo e($lang); ?>]" type="text"
                                            value="<?php echo e($translations['name'][$lang] ?? ''); ?>" class="form-control" required>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.id')); ?> <code>*</code></label>
                            <div class="col-lg-10">
                                <input name="code" type="text" value="<?php echo e($shippingMethod['code']); ?>" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.shipping_cost')); ?></label>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    <div class="accordion mb-3" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <label 
                                                    class="accordion-button p-2 <?php echo e(empty($shippingMethod->value) ? 'collapsed' : ''); ?>" 
                                                    aria-expanded="<?php echo e(!empty($shippingMethod->value) ? 'true' : 'false'); ?>"
                                                    type="button" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#collapseOne"  
                                                    aria-controls="collapseOne">
                                                    <input type="radio" class="me-2" name="shipping_charge_method" value="fixed_fee" <?php echo e(!empty($shippingMethod->value) ? 'checked' : ''); ?>>
                                                    <?php echo e(__('admin.fixed_shipping_cost')); ?>

                                                </label>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse <?php echo e(!empty($shippingMethod->value) ? 'show' : ''); ?>" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="input-group">
                                                        <input name="value" type="text" value="<?php echo e($shippingMethod['value']); ?>" class="form-control">
                                                        <span class="input-group-text"><?php echo e(config('currency.default')); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwo">
                                                <label 
                                                    class="accordion-button p-2 <?php echo e(empty($shippingMethod->weight_interval) ? 'collapsed' : ''); ?>" 
                                                    type="button" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#collapseTwo" 
                                                    aria-expanded="<?php echo e(!empty($shippingMethod->weight_interval) ? 'true' : 'false'); ?>" 
                                                    aria-controls="collapseTwo">
                                                        <input type="radio" class="me-2" name="shipping_charge_method" value="weight_interval" <?php echo e(!empty($shippingMethod->weight_interval) ? 'checked' : ''); ?>>
                                                        <?php echo e(__('admin.weight_interval_cost')); ?>

                                                </label>
                                            </h2>
                                            <?php
                                                $weight_intervals = !empty($shippingMethod->weight_interval) ? json_decode($shippingMethod->weight_interval,true) : array();
                                            ?>
                                            <div id="collapseTwo" class="accordion-collapse collapse <?php echo e(!empty($shippingMethod->weight_interval) ? 'show' : ''); ?>" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-hover" id="weight_intervals_form">
                                                        <tr>
                                                            <th><?php echo e(__('admin.weight_limit')); ?></th>
                                                            <th><?php echo e(__('admin.shipping_cost')); ?></th>
                                                            <th><?php echo e(__('admin.operations')); ?></th>
                                                        </tr>
                                                        <?php if(!empty($weight_intervals)): ?>
                                                        <?php for($i=0; $i<count($weight_intervals['limit']); $i++): ?>
                                                        <tr>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text" name="weight_interval[limit][]" class="form-control" value="<?php echo e($weight_intervals['limit'][$i]); ?>">
                                                                    <span class="input-group-text">g</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text" name="weight_interval[cost][]" class="form-control" value="<?php echo e($weight_intervals['cost'][$i]); ?>">
                                                                    <span class="input-group-text"><?php echo e(config('currency.default')); ?></span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="btn btn-danger btn-xs del" title="Intervallum törlése"><i class="bi bi-trash"></i></span>
                                                            </td>
                                                        </tr>
                                                        <?php endfor; ?>
                                                        <?php else: ?>
                                                        <tr>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text" name="weight_interval[limit][]" class="form-control" value="">
                                                                    <span class="input-group-text">g</span>
                                                                </div>
                                                                
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text" name="weight_interval[cost][]" class="form-control" value="">
                                                                    <span class="input-group-text"><?php echo e(config('currency.default')); ?></span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="btn btn-danger btn-xs del" title="Intervallum törlése"><i class="bi bi-trash"></i></span>
                                                            </td>
                                                        </tr>
                                                        <?php endif; ?>
                                                    </table>
                                                    <button type="button" class="btn btn-info text-white" id="add_weight_interval"><i class="bi bi-plus"></i> <?php echo e(__('admin.new_interval')); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <label 
                                                    class="accordion-button p-2 <?php echo e(empty($shippingMethod->price_interval) ? 'collapsed' : ''); ?>" 
                                                    type="button" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#collapseThree" 
                                                    aria-expanded="<?php echo e(!empty($shippingMethod->price_interval) ? 'true' : 'false'); ?>" 
                                                    aria-controls="collapseThree">
                                                    <input type="radio" class="me-2" name="shipping_charge_method" value="price_interval" <?php echo e(!empty($shippingMethod->price_interval) ? 'checked' : ''); ?>>
                                                    <?php echo e(__('admin.price_interval_cost')); ?>

                                                </label>
                                            </h2>
                                            <?php
                                                $price_intervals = !empty($shippingMethod->price_interval) ? json_decode($shippingMethod->price_interval,true) : array();
                                            ?>
                                            <div id="collapseThree" class="accordion-collapse collapse <?php echo e(!empty($shippingMethod->price_interval) ? 'show' : ''); ?>" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-hover" id="payment_intervals_form">
                                                        <tr>
                                                            <th><?php echo e(__('admin.price_limit')); ?></th>
                                                            <th><?php echo e(__('admin.shipping_cost')); ?></th>
                                                            <th><?php echo e(__('admin.operations')); ?></th>
                                                        </tr>
                                                        <?php if(!empty($price_intervals)): ?>
                                                        <?php for($j=0; $j<count($price_intervals['limit']); $j++): ?>
                                                        <tr>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text" name="price_interval[limit][]" class="form-control" value="<?php echo e($price_intervals['limit'][$j]); ?>">
                                                                    <span class="input-group-text"><?php echo e(config('currency.default')); ?></span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text" name="price_interval[cost][]" class="form-control" value="<?php echo e($price_intervals['cost'][$j]); ?>">
                                                                    <span class="input-group-text"><?php echo e(config('currency.default')); ?></span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="btn btn-danger btn-xs del" title="Intervallum törlése"><i class="bi bi-trash"></i></span>
                                                            </td>
                                                        </tr>
                                                        <?php endfor; ?>
                                                        <?php else: ?>
                                                        <tr>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text" name="price_interval[limit][]" class="form-control" value="">
                                                                    <span class="input-group-text"><?php echo e(config('currency.default')); ?></span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text" name="price_interval[cost][]" class="form-control" value="">
                                                                    <span class="input-group-text"><?php echo e(config('currency.default')); ?></span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="btn btn-danger btn-xs del" title="Intervallum törlése"><i class="bi bi-trash"></i></span>
                                                            </td>
                                                        </tr>
                                                        <?php endif; ?>
                                                    </table>
                                                    <button type="button" class="btn btn-info text-white" id="add_payment_interval"><i class="bi bi-plus"></i> <?php echo e(__('admin.new_interval')); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingFour">
                                                <label
                                                    class="accordion-button p-2 <?php echo e(empty($shippingMethod->free) ? 'collapsed' : ''); ?>"
                                                    type="button" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#headingFour" 
                                                    aria-expanded="<?php echo e(!empty($shippingMethod->free) ? 'true' : 'false'); ?>" 
                                                    aria-controls="headingFour"> 
                                                    <input type="radio" class="me-2" name="shipping_charge_method" value="free_shipping" <?php echo e(!empty($shippingMethod->free) ? 'checked' : ''); ?>>
                                                    <?php echo e(__('admin.free_shipping_cost')); ?>

                                                </label>
                                            </h2>
                                            <div id="headingFour" class="accordion-collapse collapse <?php echo e(!empty($shippingMethod->free) ? 'show' : ''); ?>" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <?php echo e(__('admin.no_shipping_cost')); ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.description')); ?> <img
                                    src="<?php echo e(url('assets/img/' . $lang . '.png')); ?>" width="18px"></label>
                            <div class="col-lg-10">
                                <textarea class="editor form-control" name="translations[description][<?php echo e($lang); ?>]" rows="10" cols="80"><?php echo e($translations['description'][$lang] ?? ''); ?></textarea>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.active')); ?>?</label>
                            <div class="col-lg-10">
                                <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="Igen" data-off="Nem" data-toggle="toggle" name="active" value="1" <?php echo e(!empty($shippingMethod['active']) || empty($shippingMethod['id']) ? 'checked' : ''); ?>/>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.possible_payments')); ?></label>
                            <div class="col-lg-10">
                                <?php echo custom_select('payment_methods','possible_payments[]','code','name',false,true,json_decode($shippingMethod['possible_payments'],true)); ?>

                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.possible_countries')); ?></label>
                            <div class="col-lg-10">
                                <select name="possible_countries[]" class="form-select select2" multiple>
                                    <?php 
                                        $possible_countries = $shippingMethod['possible_countries'] != '' ? json_decode($shippingMethod['possible_countries'],true) : []
                                    ?>
                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($country->id); ?>" <?php if(in_array($country->id, $possible_countries)): echo 'selected'; endif; ?>>
                                        <?php echo e(app()->getLocale() == 'en' ? $country->name : $country->native); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.sort_order')); ?></label>
                            <div class="col-lg-10">
                                <input name="sort" value="<?php echo e($shippingMethod['sort'] ??  0); ?>" type="text" class="form-control">
                            </div>
                        </div>
                        <hr />
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"></label>
                            <div class="col-lg-9">
                                <button type="submit" class="btn btn-primary"><?php echo e(__('admin.save')); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/admin/shippings/edit.blade.php ENDPATH**/ ?>