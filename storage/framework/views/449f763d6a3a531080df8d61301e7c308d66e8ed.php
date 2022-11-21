<div class="card shadow mb-2">
    <div class="card-header">
        <a class="btn btn-primary" data-bs-toggle="collapse" href="#filters" role="button" aria-expanded="<?php echo e(!empty(session('filter_order')) ? 'true' : 'false'); ?>" aria-controls="filters"><?php echo e(__('admin.filter')); ?></a>
    </div>
    <div class="collapse <?php echo e(!empty(session('filter_order')) ? 'show' : ''); ?>" id="filters">
        <div class="card card-body">
        <form action="<?php echo e(route('orders.index')); ?>" method='POST'>
            <?php echo csrf_field(); ?>

            <div class="row mb-2">
                <label class="col-lg-2 col-form-label"><?php echo e(__('status')); ?></label>
                <div class="col-lg-8">
                    <?php echo custom_select('statuses','status','id','name',false,false,session('filter_order_status'),[''=>__('all')]); ?>

                </div>
            </div>

            <div class="row mb-2">
                <label class="col-lg-2 col-form-label"><?php echo e(__('admin.name')); ?></label>
                <div class="col-lg-8">
                    <input name="name" type="text" value="<?php echo e(session('filter_order_user')); ?>" class="form-control">
                </div>
            </div>

             <div class="row mb-2">
                <label class="col-lg-2 col-form-label"><?php echo e(__('admin.order_id')); ?></label>
                <div class="col-lg-8">
                    <input name="id" value="<?php echo e(session('filter_order_id')); ?>" type="text" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-lg-2 col-form-label"><?php echo e(__('admin.order_min_date')); ?></label>
                <div class="col-lg-8">
                    <input name="mindate" value="<?php echo e(session('filter_order_mindate')); ?>" class="form-control input-sm" type="text" id="datepicker_from"/>
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-lg-2 col-form-label"><?php echo e(__('admin.order_max_date')); ?></label>
                <div class="col-lg-8">
                    <input name="maxdate" value="<?php echo e(session('filter_order_maxdate')); ?>" class="form-control input-sm" type="text" id="datepicker_to"/>
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-lg-2 col-form-label"></label>
                <div class="col-lg-8">
                    <select name="limit" class="form-select float-start" style="width: auto; margin:0 10px 0 0;">
                        <option value="10" <?php if(session('order_limit') == 10): echo 'selected'; endif; ?>>10</option>
                        <option value="50" <?php if(session('order_limit') == 50): echo 'selected'; endif; ?>>50</option>
                        <option value="100" <?php if(session('order_limit') == 100): echo 'selected'; endif; ?>>100</option>
                        <option value="200" <?php if(session('order_limit') == 200): echo 'selected'; endif; ?>>200</option>
                        <option value="999999" <?php if(session('order_limit') == 999999): echo 'selected'; endif; ?>><?php echo e(__('all')); ?></option>
                    </select>
                     <?php echo e(__('admin.founds_per_page')); ?>

                </div>
            </div>

            <div class="row mb-2">
                <div class="offset-lg-2 col-lg-2">
                    <button type="submit" class="btn btn-primary" value="1" name="order_filter"><?php echo e(__('search')); ?></button>
                </div>
                <div class="col-lg-4">
                    <button type="submit" class="btn btn-warning" name="clear_filters" value="1"><?php echo e(__('admin.filter_reset')); ?></button>
                </div>
            </div>

        </form>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/myshop/resources/views/admin/orders/filter-form.blade.php ENDPATH**/ ?>