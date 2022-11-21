<div class="card shadow mb-2">
    <div class="card-header">
        <a class="btn btn-primary" data-bs-toggle="collapse" href="#filters" role="button" aria-expanded="<?php echo e(!empty(session('filter_product')) ? 'true' : 'false'); ?>" aria-controls="filters"><?php echo e(__('admin.filter')); ?></a>
    </div>
    <div class="collapse <?php echo e(!empty(session('filter_user')) ? 'show' : ''); ?>" id="filters">
        <div class="card card-body">
        <form action="<?php echo e(route('users.list')); ?>" method='POST'>
            <?php echo csrf_field(); ?>

            <div class="row mb-2">
                <label class="col-lg-2 text-end"><?php echo e(__('admin.name')); ?></label>
                <div class="col-lg-8">
                    <input name="name" type="text" value="<?php echo e(session('filter_user_name')); ?>" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-lg-2 text-end"><?php echo e(__('email')); ?></label>
                <div class="col-lg-8">
                    <input name="email" type="text" value="<?php echo e(session('filter_user_email')); ?>" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-lg-2 text-end"><?php echo e(__('phone')); ?></label>
                <div class="col-lg-8">
                    <input name="phone" type="text" value="<?php echo e(session('filter_user_phone')); ?>" class="form-control">
                </div>
            </div>

             <div class="row mb-2">
                <label class="col-lg-2 text-end">
                    <?php echo e(__('admin.order_by')); ?>

                </label>
                <div class="col-lg-4">
                <select name="order_by" id="order_by" class="form-select float-end">
                    <option value="">
                        <?php echo e(__('default')); ?> (<?php echo e(__('admin.order_by_desc',['name'=>__('ID')])); ?>)
                    </option>
                    <option value="name_asc" <?php echo e(session('filter_user_order_by') == 'name_asc' ? 'selected' : ''); ?>>
                        <?php echo e(__('admin.order_by_asc',['name'=>__('admin.name')])); ?>

                    </option>
                    <option value="name_desc" <?php echo e(session('filter_user_order_by') == 'name_desc' ? 'selected' : ''); ?>>
                        <?php echo e(__('admin.order_by_desc',['name'=>__('admin.name')])); ?>

                    </option>
                    <option value="date_asc" <?php echo e(session('filter_user_order_by') == 'date_asc' ? 'selected' : ''); ?>>
                        <?php echo e(__('admin.order_by_asc',['name'=>__('Date')])); ?>

                    </option>
                    <option value="date_desc" <?php echo e(session('filter_user_order_by') == 'date_desc' ? 'selected' : ''); ?>>
                        <?php echo e(__('admin.order_by_desc',['name'=>__('Date')])); ?>

                    </option>
                </select>
                </div>
                <div class="col-lg-2">
                    <select name="limit" class="form-select float-end">
                        <option value="50" <?php echo e(session('filter_user_limit') == 50 ? 'selected' : ''); ?>>50</option>
                        <option value="100" <?php echo e(session('filter_user_limit') == 100 ? 'selected' : ''); ?>>100</option>
                        <option value="200" <?php echo e(session('filter_user_limit') == 200 ? 'selected' : ''); ?>>200</option>
                        <option value="999999" <?php echo e(session('filter_user_limit') == 999999 ? 'selected' : ''); ?>><?php echo e(__('all')); ?></option>
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
<?php /**PATH /var/www/html/myshop/resources/views/admin/users/filter-form.blade.php ENDPATH**/ ?>