<div class="sidebar_menu" id="sidebar_menu">
    <h2 class="p-3"><?php echo e(__('categories')); ?></h2>
    <?php echo $__env->make('categories.sidebar-categories', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div><?php /**PATH /var/www/html/architus/resources/views/categories/sidebar.blade.php ENDPATH**/ ?>