<form method="post" action="<?php echo e(route('products.update',$product)); ?>" class="form-horizontal" role="form" id="product_form">
    <?php echo method_field('PUT'); ?>
    <?php echo csrf_field(); ?>
    <div class="row py-3">
        <div class="col-md-12">
            <div class="mb-3 row">
                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.categories')); ?> *</label>
                <div class="col-lg-10">
                    <?php echo category_select($categories,!empty($product['categories']) ? explode(',',$product['categories']) : array(),'multiple','required'); ?>

                    <i class="help-block"><?php echo e(__('admin.select_category_info')); ?></i>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-lg-2 text-lg-end" for="product_number"><?php echo e(__('admin.product_number')); ?> *</label>
                <div class="col-lg-4">
                    <input name="product_number" value="<?php echo e($product['product_number'] ?? old('product_number')); ?>" type="text" class="form-control input-sm" required/>
                </div>
                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.manufacturer')); ?></label>
                <div class="col-lg-4">
                    <?php echo custom_select('manufacturers','manufacturer_id','id','name',false,false,@$product['manufacturer_id'],[''=>__('none')]); ?>

                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-lg-2 text-lg-end" for="price"><?php echo e(__('admin.price')); ?> *</label>
                <div class="col-lg-2">
                    <input name="price" value="<?php echo e($product['price']); ?>" type="number" class="form-control input-sm" required placeholder="<?php echo e(__('admin.price')); ?>" />
                </div>
                <div class="col-lg-2">
                    <input name="action_price" value="<?php echo e($product['action_price'] ?? ''); ?>" type="number" class="form-control input-sm" placeholder="<?php echo e(__('admin.action_price')); ?>" />
                </div>

                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.action_price_temp')); ?></label>
                <div class="col-lg-4">
                    <div class="input-group">
                        <input name="action_start_date" value="<?php echo e($product['action_start_date'] ?? ''); ?>" type="text" class="form-control input-sm datepicker" placeholder="<?php echo e(__('admin.action_start_date')); ?>" autocomplete="off" />
                        <input name="action_end_date" value="<?php echo e($product['action_end_date'] ?? ''); ?>" type="text" class="form-control input-sm datepicker" placeholder="<?php echo e(__('admin.action_end_date')); ?>" autocomplete="off" />
                    </div>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-lg-2 text-lg-end" for="stock"><?php echo e(__('admin.stock')); ?></label>
                <div class="col-lg-4">
                    <input name="stock" value="<?php echo e($product['stock'] ?? old('stock')); ?>" type="text" class="form-control input-sm"/>
                </div>
                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.weight')); ?> (g)</label>
                <div class="col-lg-4">
                    <input name="weight" value="<?php echo e($product['weight'] ?? old('weight')); ?>" type="text" class="form-control input-sm" required/>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.shipping_cost')); ?></label>
                <div class="col-lg-4">
                    <input name="shipping_cost" value="<?php echo e($product['shipping_cost'] ?? old('shipping_cost')); ?>" type="number" class="form-control input-sm" placeholder="">
                </div>
                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.warranty')); ?> (<?php echo e(__('admin.month')); ?>)</label>
                <div class="col-lg-4">
                    <input name="warranty" value="<?php echo e($product['warranty'] ?? old('warranty')); ?>" type="number" class="form-control input-sm" />
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.unit')); ?></label>
                <div class="col-lg-4">
                    <select name="unit_id" class="form-select">
                        <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($unit->id); ?>" <?php if($unit->id==$product->unit_id): echo 'selected'; endif; ?>>
                            <?php echo e(__('unit.'.$unit->key_name)); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.reward_points')); ?></label>
                <div class="col-lg-4">
                    <input name="reward" value="<?php echo e($product['reward'] ?? 0); ?>" type="number" class="form-control input-sm" />
                </div>
            </div>

            <div class="mb-3 row ">
                <label class="col-lg-2 text-lg-end"></label>
                <div class="col-lg-10">
                    <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="<?php echo e(__('admin.published')); ?>" data-off="<?php echo e(__('admin.not')); ?> <?php echo e(__('admin.published')); ?>" data-toggle="toggle" name="published" value="1" <?php echo e(@$product['published'] == 1 || @$product['id'] == "" ? 'checked' : ''); ?>/>

                    <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="<?php echo e(__('admin.buyable')); ?>" data-off="<?php echo e(__('admin.not')); ?> <?php echo e(__('admin.buyable')); ?>" data-toggle="toggle" name="available" value="1" <?php echo e(@$product['available'] == 1 || @$product['id'] == "" ? 'checked' : ''); ?> />

                    <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="<?php echo e(__('admin.featured')); ?>" data-off="<?php echo e(__('admin.not')); ?> <?php echo e(__('admin.featured')); ?>" data-toggle="toggle" name="featured" value="1" <?php echo e(@$product['featured'] == 1 ? 'checked' : ''); ?> />

                    <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="<?php echo e(__('admin.free_shipping')); ?>" data-off="<?php echo e(__('admin.not')); ?> <?php echo e(__('admin.free_shipping')); ?>" data-toggle="toggle" name="free_shipping" value="1" <?php echo e(@$product['free_shipping'] == 1 || @$product['id'] == "" ? 'checked' : ''); ?>/>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-lg-2 text-lg-end" for="name"><?php echo e(__('admin.product_name')); ?> *</label>
                <div class="col-lg-10">
                    <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="input-group mb-1">
                        <span class="input-group-text"><img src="<?php echo e(url('assets/img/'.$lang.'.png')); ?>" width="18px"></span>
                        <input name="name[<?php echo e($lang); ?>]" type="text" value="<?php echo e($translations[$lang]['name'] ?? ''); ?>" class="form-control" required>
                    </div>
                    <input type="hidden" name="translation_id[<?php echo e($lang); ?>]" value="<?php echo e($translations[$lang]['id'] ?? ''); ?>">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.short_description')); ?></label>
                <div class="col-lg-10">
                    <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="input-group mb-1">
                        <span class="input-group-text"><img src="<?php echo e(url('assets/img/'.$lang.'.png')); ?>" width="18px"></span>
                        <textarea name="short_details[<?php echo e($lang); ?>]" rows="3" class="form-control"><?php echo e($translations[$lang]['short_details'] ?? ""); ?></textarea>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="mb-3 row">
                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.content')); ?> <img src="<?php echo e(url('assets/img/'.$lang.'.png')); ?>" width="18px"></label>
                <div class="col-lg-10">
                    <textarea id="editor1" class="editor" name="details[<?php echo e($lang); ?>]"><?php echo e($translations[$lang]['details'] ?? ""); ?></textarea>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="mb-3 row">
                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.meta_description')); ?></label>
                <div class="col-lg-10">
                    <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="input-group mb-1">
                        <span class="input-group-text"><img src="<?php echo e(url('assets/img/'.$lang.'.png')); ?>" width="18px"></span>
                        <input name="meta_description[<?php echo e($lang); ?>]" type="text" value="<?php echo e($translations[$lang]['meta_description'] ?? ''); ?>" class="form-control">
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.meta_keywords')); ?></label>
                <div class="col-lg-10">
                    <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="input-group mb-1">
                        <span class="input-group-text"><img src="<?php echo e(url('assets/img/'.$lang.'.png')); ?>" width="18px"></span>
                        <input name="meta_keywords[<?php echo e($lang); ?>]" type="text" value="<?php echo e($translations[$lang]['meta_keywords'] ?? ''); ?>" class="form-control">
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.meta_title')); ?></label>
                <div class="col-lg-10">
                    <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="input-group mb-1">
                        <span class="input-group-text"><img src="<?php echo e(url('assets/img/'.$lang.'.png')); ?>" width="18px"></span>
                        <input name="meta_title[<?php echo e($lang); ?>]" type="text" value="<?php echo e($translations[$lang]['meta_title'] ?? ''); ?>" class="form-control">
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <hr />
        <div class="mb-3 row">
            <div class="col-lg-offset-1 col-lg-8">
                <button type="submit" class="btn btn-primary"><?php echo e(__('admin.save')); ?></button>
            </div>
        </div>
    </div>
</form>
<?php /**PATH /var/www/html/architus/resources/views/admin/products/components/default-form.blade.php ENDPATH**/ ?>