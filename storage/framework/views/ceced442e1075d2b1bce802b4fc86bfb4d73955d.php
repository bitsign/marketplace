<ul class="">
<?php $__currentLoopData = $childs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(empty($child->translation->name)): ?>
        <?php continue; ?>
    <?php endif; ?>
    <?php
        //$category_url = count($child->children) ? __('routes.categories') : __('routes.products');
        $category_url = __('routes.products');
        $url = $child->translation->url ?? '';
    ?>
   <li>
        <a class="" title="<?php echo e($child->translation->name); ?>" href="<?php echo e(url(app()->getLocale().'/'.$category_url.'/'.$url)); ?>" data-url="<?php echo e($child->translation->url); ?>">
            <?php echo e($child->translation->name); ?>

        </a>
        <?php echo count($child->children) ? '<i class="bi bi-plus-square"></i>' :''; ?>

        <?php if(count($child->children)): ?>
            <?php echo $__env->make('categories.sidebar-subcategories',['childs' => $child->children,'depth'=>$child->depth], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
   </li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH /var/www/html/myshop/resources/views/categories/sidebar-subcategories.blade.php ENDPATH**/ ?>