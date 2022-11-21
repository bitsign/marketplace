<ul class="parent">
<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(empty($category->translation->name)): ?>
        <?php continue; ?>
    <?php endif; ?>
    <?php
        $prefix = app()->getLocale();
        //$category_url = count($category->children) ? __('routes.categories') : __('routes.products');
        $category_url = __('routes.products');
    ?>
    <li class="<?php echo e((request()->segment(3) == $category->translation->url) ? 'active' : ''); ?>">
        <a class="" href="<?php echo e(url($prefix.'/'.$category_url.'/'.$category->translation->url)); ?>" title="<?php echo e($category->translation->name); ?>" data-url="<?php echo e($category->translation->url); ?>">
            <?php echo e($category->translation->name); ?>

        </a>
        <?php echo count($category->children) ? '<i class="bi bi-plus-square"></i>' :''; ?>

        <?php if(count($category->children)): ?>
            <?php echo $__env->make('categories.sidebar-subcategories',['childs' => $category->children,'depth'=>$category->depth], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    </li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul><?php /**PATH /var/www/html/architus/resources/views/categories/sidebar-categories.blade.php ENDPATH**/ ?>