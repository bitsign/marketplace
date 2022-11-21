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
                        <form method="post" action="<?php echo e(route('faqs.update',$faq)); ?>" class="form-horizontal" role="form" id="faq_form">
                            <?php echo method_field('PUT'); ?>
                        <?php else: ?>
                        <form method="post" action="<?php echo e(route('faqs.store')); ?>" class="form-horizontal" role="form" id="faq_form">
                        <?php endif; ?>
                        <?php echo csrf_field(); ?>
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-end"><?php echo e(__('admin.question')); ?> <code>*</code></label>
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
                        <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.content')); ?> <img
                                        src="<?php echo e(url('assets/img/' . $lang . '.png')); ?>" width="18px"></label>
                                <div class="col-lg-10">
                                    <textarea id="editor1" class="editor form-control" name="translations[content][<?php echo e($lang); ?>]" rows="10" cols="80" required><?php echo e($translations['content'][$lang] ?? ''); ?></textarea>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <hr />
                        <div class="mb-3 row">
                            <label class="col-lg-2 col-form-label"></label>
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

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/admin/faqs/form.blade.php ENDPATH**/ ?>