<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin/layout/page-header', ['page_title' => $page_title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header"><b><?php echo e($page_title); ?></b></div>
                <div class="card-body">
                    <div class="row no-gutters align-items-center">

                        <div class="col-lg-12"><?php echo $__env->make('layout/messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></div>

                        <form method="post" action="<?php echo e(route('services.update', $service)); ?>" class="form-horizontal"
                            role="form" id="service_form">
                            <?php echo method_field('PUT'); ?>
                            <?php echo csrf_field(); ?>
                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.title')); ?> <code>*</code></label>
                                <div class="col-lg-10">
                                    <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="input-group mb-1">
                                            <span class="input-group-text"><img src="<?php echo e(url('assets/img/' . $lang . '.png')); ?>"
                                                    width="18px"></span>
                                            <input name="name[<?php echo e($lang); ?>]" type="text"
                                                value="<?php echo e(!empty($translations[$lang]['name']) ? $translations[$lang]['name'] : ''); ?>"
                                                class="form-control">
                                        </div>
                                        <input type="hidden" name="translation_id[<?php echo e($lang); ?>]"
                                            value="<?php echo e(!empty($translations[$lang]['id']) ? $translations[$lang]['id'] : ''); ?>">
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="mb-3 row">
                                    <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.content')); ?> <img
                                            src="<?php echo e(url('assets/img/' . $lang . '.png')); ?>" width="18px"></label>
                                    <div class="col-lg-10">
                                        <textarea id="editor1" class="editor form-control" name="content[<?php echo e($lang); ?>]" rows="10" cols="80"><?php echo e(@!empty($translations[$lang]['content']) ? $translations[$lang]['content'] : ''); ?></textarea>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.meta_description')); ?></label>
                                <div class="col-lg-10">
                                    <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="input-group mb-1">
                                            <span class="input-group-text"><img src="<?php echo e(url('assets/img/' . $lang . '.png')); ?>"
                                                    width="18px"></span>
                                            <input name="meta_description[<?php echo e($lang); ?>]" type="text"
                                                value="<?php echo e(!empty($translations[$lang]['meta_description']) ? $translations[$lang]['meta_description'] : ''); ?>"
                                                class="form-control">
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.meta_keywords')); ?></label>
                                <div class="col-lg-10">
                                    <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="input-group mb-1">
                                            <span class="input-group-text"><img src="<?php echo e(url('assets/img/' . $lang . '.png')); ?>"
                                                    width="18px"></span>
                                            <input name="meta_keywords[<?php echo e($lang); ?>]" type="text"
                                                value="<?php echo e(!empty($translations[$lang]['meta_keywords']) ? $translations[$lang]['meta_keywords'] : ''); ?>"
                                                class="form-control">
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.menu_title')); ?></label>
                                <div class="col-lg-10">
                                    <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="input-group mb-1">
                                            <span class="input-group-text"><img src="<?php echo e(url('assets/img/' . $lang . '.png')); ?>"
                                                    width="18px"></span>
                                            <input name="menu_title[<?php echo e($lang); ?>]" type="text"
                                                value="<?php echo e(!empty($translations[$lang]['menu_title']) ? $translations[$lang]['menu_title'] : ''); ?>"
                                                class="form-control">
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <hr>

                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.image')); ?></label>
                                <div class="col-lg-10">
                                    <div class="input-group col-lg-12">
                                        <input id="fieldID" type="text"
                                            value="<?php echo e(@!empty($service['image']) ? $service['image'] : ''); ?>"
                                            name="image" class="form-control">
                                        <span class="input-group-btn">
                                            <a class="btn btn-primary iframe-btn" type="button"
                                                href="<?php echo e(URL::to('/assets/admin/plugins/filemanager/dialog.php')); ?>?type=1&subfolder=&field_id=fieldID"><?php echo e(__('admin.select_image')); ?></a>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.active')); ?>?</label>
                                <div class="col-lg-10">
                                    <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini"
                                        data-on="<?php echo e(__('yes')); ?>" data-off="<?php echo e(__('no')); ?>" data-toggle="toggle"
                                        name="active" value="1"
                                        <?php echo e(!empty($service['active']) || empty($service['id']) ? 'checked' : ''); ?> />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.sort_order')); ?></label>
                                <div class="col-lg-10">
                                    <input name="sort" value="<?php echo e($service['sort'] ?? 0); ?>" type="text"
                                        class="form-control">
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

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/admin/services/edit.blade.php ENDPATH**/ ?>