<?php $__env->startSection('content'); ?>

<?php echo $__env->make('admin/layout/page-header',['page_title'=>$page_title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header"><b><?php echo e($product['name'] ??  $page_title); ?></b></div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-lg-12"><?php echo $__env->make('layout/messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></div>
                    <form method="post" action="<?php echo e(route('products.store')); ?>" class="form-horizontal" role="form" id="product_form">
                        <?php echo csrf_field(); ?>
                        <div class="row py-3">
                            <div class="col-md-12">
                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.categories')); ?> *</label>
                                    <div class="col-lg-10">
                                        <?php echo category_select($categories,[],'multiple','required'); ?>

                                        <i class="help-block"><?php echo e(__('admin.select_category_info')); ?></i>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end" for="product_number"><?php echo e(__('admin.product_number')); ?> *</label>
                                    <div class="col-lg-4">
                                        <input name="product_number" value="<?php echo e(old('product_number')); ?>" type="text" class="form-control input-sm" required/>
                                    </div>
                                    <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.manufacturer')); ?></label>
                                    <div class="col-lg-4">
                                        <?php echo custom_select('manufacturers','manufacturer_id','id','name',false,false,'',[''=>__('none')]); ?>

                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end" for="price"><?php echo e(__('admin.price')); ?> *</label>
                                    <div class="col-lg-2">
                                        <input name="price" value="<?php echo e(old('price')); ?>" type="number" class="form-control input-sm" required placeholder="<?php echo e(__('admin.price')); ?>" />
                                    </div>
                                    <div class="col-lg-2">
                                        <input name="action_price" value="<?php echo e(old('action_price')); ?>" type="number" class="form-control input-sm" placeholder="<?php echo e(__('admin.action_price')); ?>" />
                                    </div>
                                
                                    <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.action_price_temp')); ?></label>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <input name="action_start_date" value="<?php echo e(old('action_start_date')); ?>" type="text" class="form-control input-sm datepicker" placeholder="<?php echo e(__('admin.action_start_date')); ?>" autocomplete="off" />
                                            <input name="action_end_date" value="<?php echo e(old('action_end_date')); ?>" type="text" class="form-control input-sm datepicker" placeholder="<?php echo e(__('admin.action_end_date')); ?>" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end" for="stock"><?php echo e(__('admin.stock')); ?></label>
                                    <div class="col-lg-4">
                                        <input name="stock" value="<?php echo e(old('stock') ?? 0); ?>" type="text" class="form-control input-sm"/>
                                    </div>
                                    <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.weight')); ?> (g)</label>
                                    <div class="col-lg-4">
                                        <input name="weight" value="<?php echo e(old('weight') ?? 0); ?>" type="text" class="form-control input-sm"/>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.shipping_cost')); ?></label>
                                    <div class="col-lg-4">
                                        <input name="shipping_cost" value="<?php echo e(old('shipping_cost') ?? 0); ?>" type="number" class="form-control input-sm" placeholder="">
                                    </div>
                                    <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.warranty')); ?> (<?php echo e(__('admin.month')); ?>)</label>
                                    <div class="col-lg-4">
                                        <input name="warranty" value="<?php echo e(old('warranty') ?? 0); ?>" type="number" class="form-control input-sm" />
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.unit')); ?></label>
                                    <div class="col-lg-4">
                                        <select name="unit_id" class="form-select">
                                            <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($unit->id); ?>" <?php if(old('unit_id')): echo 'selected'; endif; ?>>
                                                    <?php echo e(__('unit.'.$unit->key_name)); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.reward_points')); ?></label>
                                    <div class="col-lg-4">
                                        <input name="reward" value="0" type="number" class="form-control input-sm" />
                                    </div>
                                </div>

                                <div class="mb-3 row ">
                                    <label class="col-lg-2 text-lg-end"></label>
                                    <div class="col-lg-10">
                                        <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="<?php echo e(__('admin.published')); ?>" data-off="<?php echo e(__('admin.not')); ?> <?php echo e(__('admin.published')); ?>" data-toggle="toggle" name="published" value="1" checked/>

                                        <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="<?php echo e(__('admin.buyable')); ?>" data-off="<?php echo e(__('admin.not')); ?> <?php echo e(__('admin.buyable')); ?>" data-toggle="toggle" name="available" value="1" checked />

                                        <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="<?php echo e(__('admin.featured')); ?>" data-off="<?php echo e(__('admin.not')); ?> <?php echo e(__('admin.featured')); ?>" data-toggle="toggle" name="featured" value="1" />

                                        <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="<?php echo e(__('admin.free_shipping')); ?>" data-off="<?php echo e(__('admin.not')); ?> <?php echo e(__('admin.free_shipping')); ?>" data-toggle="toggle" name="free_shipping" value="1" />
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end" for="name"><?php echo e(__('admin.product_name')); ?> *</label>
                                    <div class="col-lg-10">
                                        <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="input-group mb-1">
                                            <span class="input-group-text"><img src="<?php echo e(url('assets/img/'.$lang.'.png')); ?>" width="18px"></span>
                                            <input name="name[<?php echo e($lang); ?>]" type="text" value="<?php echo e(old('name['.$lang.']')); ?>" class="form-control" required>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.short_description')); ?></label>
                                    <div class="col-lg-10">
                                        <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="input-group mb-1">
                                            <span class="input-group-text"><img src="<?php echo e(url('assets/img/'.$lang.'.png')); ?>" width="18px"></span>
                                            <textarea name="short_details[<?php echo e($lang); ?>]" rows="3" class="form-control"><?php echo e(old('short_details['.$lang.']')); ?></textarea>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>

                                <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.content')); ?> <img src="<?php echo e(url('assets/img/'.$lang.'.png')); ?>" width="18px"></label>
                                    <div class="col-lg-10">
                                        <textarea id="editor1" class="editor" name="details[<?php echo e($lang); ?>]"><?php echo e(old('details['.$lang.']')); ?></textarea>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.meta_description')); ?></label>
                                    <div class="col-lg-10">
                                        <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="input-group mb-1">
                                            <span class="input-group-text"><img src="<?php echo e(url('assets/img/'.$lang.'.png')); ?>" width="18px"></span>
                                            <input name="meta_description[<?php echo e($lang); ?>]" type="text" value="<?php echo e(old('meta_description['.$lang.']')); ?>" class="form-control">
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
                                            <input name="meta_keywords[<?php echo e($lang); ?>]" type="text" value="<?php echo e(old('meta_keywords['.$lang.']')); ?>" class="form-control">
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
                                            <input name="meta_title[<?php echo e($lang); ?>]" type="text" value="<?php echo e(old('meta_title['.$lang.']')); ?>" class="form-control">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/admin/products/create.blade.php ENDPATH**/ ?>