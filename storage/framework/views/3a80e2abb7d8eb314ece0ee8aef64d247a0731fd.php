<div class="card shadow mb-2">
    <div class="card-header">
        <a class="btn btn-primary" data-bs-toggle="collapse" href="#filters" role="button" aria-expanded="<?php echo e(!empty(session('filter_product')) ? 'true' : 'false'); ?>" aria-controls="filters"><?php echo e(__('admin.filter')); ?></a>
    </div>
    <div class="collapse <?php echo e(!empty(session('filter_product')) ? 'show' : ''); ?>" id="filters">
        <div class="card card-body">
        <form action="<?php echo e(route('products.index')); ?>" method='POST'>
            <?php echo csrf_field(); ?>
            <div class="row mb-2">
                <label class="col-lg-2 text-end"><?php echo e(__('admin.product_number')); ?></label>
                <div class="col-lg-8">
                    <input name="product_number" value="<?php echo e(session('filter_product_number')); ?>" type="text" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-lg-2 text-end"><?php echo e(__('admin.manufacturer')); ?></label>
                <div class="col-lg-8">
                    <?php echo custom_select('manufacturers','manufacturer_id','id','name',false,false,session('filter_manufacturer'),[''=>__('all')]); ?>

                </div>
            </div>

            <div class="row mb-2">
                <label class="col-lg-2 text-end"><?php echo e(__('admin.categories')); ?></label>
                <div class="col-lg-8">
                    <?php echo category_select($categories,session('filter_categories') ?? array(),'multiple'); ?>

                </div>
            </div>

            <div class="row mb-2">
                <label class="col-lg-2 text-end"><?php echo e(__('admin.name')); ?></label>
                <div class="col-lg-8">
                    <input name="name" type="text" value="<?php echo e(session('filter_name')); ?>" class="form-control">
                </div>
            </div>

            <div class="row mb-2 ">
                <div class="col-lg-2 text-end"><?php echo e(__('admin.published')); ?>?</div>
                <div class="col-lg-8">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="published" value="0" id="published0" <?php echo e(session('filter_published') === 0 ? 'checked' : ''); ?>>
                      <label class="form-check-label" for="published0"><?php echo e(__('no')); ?></label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="published" value="1" id="published1">
                      <label class="form-check-label" for="published1" <?php echo e(session('filter_published') == 1 ? 'checked' : ''); ?>><?php echo e(__('yes')); ?></label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="published" value="2" id="published2" <?php echo e((session('filter_published') == 2 || empty(session('filter_published'))) ? 'checked' : ''); ?>>
                      <label class="form-check-label" for="published2"><?php echo e(__('all')); ?></label>
                    </div>
                </div>
            </div>

            <div class="row mb-2 ">
                <div class="col-lg-2 text-end"><?php echo e(__('admin.buyable')); ?>?</div>
                <div class="col-lg-8">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="available" value="0" id="available0" <?php echo e(session('filter_available') == 0 ? 'checked' : ''); ?>>
                      <label class="form-check-label" for="available0"><?php echo e(__('no')); ?></label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="available" value="1" id="available1" <?php echo e(session('filter_available') == 1 ? 'checked' : ''); ?>>
                      <label class="form-check-label" for="available1"><?php echo e(__('yes')); ?></label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="available" value="2" id="available2" <?php echo e(session('filter_available') == 2 || empty(session('filter_available')) ? 'checked' : ''); ?>>
                      <label class="form-check-label" for="available2"><?php echo e(__('all')); ?></label>
                    </div>
                </div>
            </div>

            <div class="row mb-2 ">
                <div class="col-lg-2 text-end"><?php echo e(__('admin.on_stock')); ?>?</div>
                <div class="col-lg-8">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="stock" value="0" id="stock0" <?php echo e(session('filter_stock') == 0 ? 'checked' : ''); ?>>
                      <label class="form-check-label" for="stock0"><?php echo e(__('no')); ?></label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="stock" value="1" id="stock1" <?php echo e(session('filter_stock') == 1 ? 'checked' : ''); ?>>
                      <label class="form-check-label" for="stock1"><?php echo e(__('yes')); ?></label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="stock" value="2" id="stock2" <?php echo e(session('filter_stock') == 2 || empty(session('filter_stock')) ? 'checked' : ''); ?>>
                      <label class="form-check-label" for="stock2"><?php echo e(__('all')); ?></label>
                    </div>
                </div>
            </div>

            <div class="row mb-2 ">
                <div class="col-lg-2 text-end"><?php echo e(__('admin.featured')); ?>?</div>
                <div class="col-lg-8">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="featured" value="0" id="featured0" <?php echo e(session('filter_featured') == 0 ? 'checked' : ''); ?>>
                      <label class="form-check-label" for="featured0"><?php echo e(__('no')); ?></label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="featured" value="1" id="featured1" <?php echo e(session('filter_featured') == 1 ? 'checked' : ''); ?>>
                      <label class="form-check-label" for="featured1"><?php echo e(__('yes')); ?></label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="featured" value="2" id="featured2" <?php echo e(session('filter_featured') == 2 || empty(session('filter_featured')) ? 'checked' : ''); ?>>
                      <label class="form-check-label" for="featured2"><?php echo e(__('all')); ?></label>
                    </div>
                </div>
            </div>

            <div class="row mb-2 ">
                <div class="col-lg-2 text-end"><?php echo e(__('free_shipping')); ?>?</div>
                <div class="col-lg-8">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="free_shipping" value="0" id="free_shipping0" <?php echo e(session('filter_free_shipping') == 0 ? 'checked' : ''); ?>>
                      <label class="form-check-label" for="free_shipping0"><?php echo e(__('no')); ?></label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="free_shipping" value="1" id="free_shipping1" <?php echo e(session('filter_free_shipping') == 1 ? 'checked' : ''); ?>>
                      <label class="form-check-label" for="free_shipping1"><?php echo e(__('yes')); ?></label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="free_shipping" value="2" id="free_shipping2" <?php echo e(session('filter_free_shipping') == 2 || empty(session('filter_free_shipping')) ? 'checked' : ''); ?>>
                      <label class="form-check-label" for="free_shipping2"><?php echo e(__('all')); ?></label>
                    </div>
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-lg-2 text-end">
                    <?php echo e(__('admin.order_by')); ?>

                </label>
                <div class="col-lg-4">
                <select name="order_by" id="order_by" class="form-select float-end">
                    <option value="">
                        <?php echo e(__('default')); ?>

                    </option>
                    <option value="name_asc" <?php echo e(session('filter_order_by') == 'name_asc' ? 'selected' : ''); ?>>
                        <?php echo e(__('admin.order_by_asc',['name'=>__('admin.name')])); ?>

                    </option>
                    <option value="name_desc" <?php echo e(session('filter_order_by') == 'name_desc' ? 'selected' : ''); ?>>
                        <?php echo e(__('admin.order_by_desc',['name'=>__('admin.name')])); ?>

                    </option>
                    <option value="price_asc" <?php echo e(session('filter_order_by') == 'price_asc' ? 'selected' : ''); ?>>
                        <?php echo e(__('admin.order_by_asc',['name'=>__('Price')])); ?>

                    </option>
                    <option value="price_desc" <?php echo e(session('filter_order_by') == 'price_desc' ? 'selected' : ''); ?>>
                        <?php echo e(__('admin.order_by_desc',['name'=>__('Price')])); ?>

                    </option>
                    <option value="date_asc" <?php echo e(session('filter_order_by') == 'date_asc' ? 'selected' : ''); ?>>
                        <?php echo e(__('admin.order_by_asc',['name'=>__('Date')])); ?>

                    </option>
                    <option value="date_desc" <?php echo e(session('filter_order_by') == 'date_desc' ? 'selected' : ''); ?>>
                        <?php echo e(__('admin.order_by_desc',['name'=>__('Date')])); ?>

                    </option>
                    <option value="shipping_desc" <?php echo e(session('filter_order_by') == 'shipping_desc' ? 'selected' : ''); ?>>
                        <?php echo e(__('admin.order_by_desc',['name'=>__('admin.unique_transport')])); ?>

                    </option>
                </select>
                </div>
                <div class="col-lg-2">
                    <select name="limit" class="form-select float-end">
                        <option value="50" <?php echo e(session('limit') == 50 ? 'selected' : ''); ?>>50</option>
                        <option value="100" <?php echo e(session('limit') == 100 ? 'selected' : ''); ?>>100</option>
                        <option value="200" <?php echo e(session('limit') == 200 ? 'selected' : ''); ?>>200</option>
                        <option value="999999" <?php echo e(session('limit') == 999999 ? 'selected' : ''); ?>><?php echo e(__('all')); ?></option>
                    </select>
                </div>
                <label class="col-lg-2">
                    <?php echo e(__('admin.founds_per_page')); ?>

                </label>
            </div>
            <div class="row mb-2">
                <div class="offset-lg-2 col-lg-2">
                    <button type="submit" name="filter" value="1" class="btn btn-primary"><?php echo e(__('search')); ?></button>
                </div>
                <div class="col-lg-4">
                    <button type="submit" class="btn btn-warning" name="clear_filters" value="1"><?php echo e(__('admin.filter_reset')); ?></button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/myshop/resources/views/admin/products/components/filter-form.blade.php ENDPATH**/ ?>