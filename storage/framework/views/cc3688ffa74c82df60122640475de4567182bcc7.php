<?php $__env->startSection('content'); ?>

<?php echo $__env->make('admin/layout/page-header',['page_title'=>$page_title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header"><b><?php echo e($page_title); ?></b></div>
                <div class="card-body">
                    <div class="row no-gutters align-items-center">

                        <div class="col-lg-12"><?php echo $__env->make('layout/messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></div>

                        <?php if($edit === true): ?>
                        <form method="post" action="<?php echo e(route('team.update',$team)); ?>" class="form-horizontal" role="form" id="team_form">
                            <?php echo method_field('PUT'); ?>
                        <?php else: ?>
                        <form method="post" action="<?php echo e(route('team.store')); ?>" class="form-horizontal" role="form" id="team_form">
                        <?php endif; ?>
                        <?php echo csrf_field(); ?>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-end"><?php echo e(__('admin.name')); ?> <code>*</code></label>
                            <div class="col-lg-10">
                                <input name="name" type="text" value="<?php echo e(!empty($team['name']) ? $team['name'] : old('name')); ?>" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-end"><?php echo e(__('admin.occupation')); ?></label>
                            <div class="col-lg-10">
                                <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"><img src="<?php echo e(url('assets/img/' . $lang . '.png')); ?>"
                                                width="18px"></span>
                                        <input name="translations[occupation][<?php echo e($lang); ?>]" type="text"
                                            value="<?php echo e($translations['occupation'][$lang] ?? ''); ?>" class="form-control" required>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.description')); ?> <img
                                        src="<?php echo e(url('assets/img/' . $lang . '.png')); ?>" width="18px"></label>
                                <div class="col-lg-10">
                                    <textarea class="editor form-control" name="translations[intro][<?php echo e($lang); ?>]" rows="10" cols="80"><?php echo e($translations['intro'][$lang] ?? ''); ?></textarea>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-end">Facebook link</label>
                            <div class="col-lg-10">
                                <input name="contact" type="text" value="<?php echo e(!empty($team['contact']) ? $team['contact'] : old('contact')); ?>" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 col-form-label"><?php echo e(__('admin.image')); ?></label>
                            <div class="col-lg-10">
                                <div class="input-group col-lg-12">
                                    <input id="fieldID" type="text" value="<?php echo e(!empty($team['image']) ? $team['image'] : old('image')); ?>" name="image" class="form-control">
                                    <span class="input-group-btn">
                                    <a class="btn btn-primary iframe-btn" type="button" href="<?php echo e(URL::to('/assets/admin/plugins/filemanager/dialog.php')); ?>?type=1&subfolder=&field_id=fieldID"><?php echo e(__('admin.select_image')); ?></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-lg-2  text-end"><?php echo e(__('admin.active')); ?>?</label>
                            <div class="col-lg-10">
                                <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="<?php echo e(__('yes')); ?>" data-off="<?php echo e(__('no')); ?>" data-toggle="toggle" name="active" value="1" <?php echo e(!empty($team['active']) || empty($team['id']) ? 'checked' : ''); ?>/>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-end"><?php echo e(__('admin.sort_order')); ?></label>
                            <div class="col-lg-10">
                                <input name="sort" type="number" value="<?php echo e(!empty($team['sort']) ? $team['sort'] : old('sort')); ?>" class="form-control">
                            </div>
                        </div>
                        <hr />
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-end"></label>
                            <div class="col-lg-10">
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

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/admin/team/team_form.blade.php ENDPATH**/ ?>