<?php $system_messages = get_system_messages(); ?>
<?php if(!empty($system_messages)): ?>
    <?php $__currentLoopData = $system_messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $messages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(!empty($messages)): ?>
            <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="alert alert-<?php echo e($key); ?>"><?php echo e($message); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php clear_system_messages(); ?>

<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul class="m-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?><?php /**PATH /var/www/html/architus/resources/views/layout/messages.blade.php ENDPATH**/ ?>