<?php $__env->startSection('content'); ?>

<?php echo $__env->make('admin/layout/page-header',['page_title'=>$page_title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header"><b><?php echo e($page_title); ?></b></div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">

                    <div class="col-lg-12"><?php echo $__env->make('layout/messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></div>
                    <form method="post" action="<?php echo e(route('email-texts.update',$emailText->id)); ?>" class="form-horizontal" role="form" id="page_form">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.language')); ?> <code>*</code></label>
                            <div class="col-lg-8">
                                <select name="lang" class="form-select" required>
                                    <?php $__currentLoopData = config('app.available_locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($lang); ?>" <?php if($emailText['lang'] == $lang): echo 'selected'; endif; ?>>
                                        <?php echo e($key); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.id')); ?></label>
                            <div class="col-lg-8">
                                <input name="email_id" type="text" value="<?php echo e($emailText['email_id']); ?>" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.title')); ?> <code>*</code></label>
                            <div class="col-lg-8">
                                <input name="name" type="text" value="<?php echo e($emailText['name']); ?>" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.subject')); ?></label>
                            <div class="col-lg-8">
                                <input name="subject" type="text" value="<?php echo e($emailText['subject']); ?>" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.email_body')); ?></label>
                            <div class="col-lg-8">
                                <textarea id="editor1" class="editor" name="body" rows="10" cols="80"><?php echo e($emailText['body']); ?></textarea>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.bank_transfer')); ?></label>
                            <div class="col-lg-8">
                                <textarea id="editor2" class="editor" name="bank_transfer" rows="10" cols="80"><?php echo e($emailText['bank_transfer']); ?></textarea>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"><?php echo e(__('admin.courier')); ?></label>
                            <div class="col-lg-8">
                                <textarea id="editor3" class="editor" name="courier" rows="10" cols="80"><?php echo e($emailText['courier']); ?></textarea>
                            </div>
                        </div>

                        <hr />
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"></label>
                            <div class="col-lg-9">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> <?php echo e(__('admin.save')); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/admin/email_texts/edit.blade.php ENDPATH**/ ?>