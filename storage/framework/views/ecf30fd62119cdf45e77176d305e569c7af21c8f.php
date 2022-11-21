<ul class="">
<?php $__currentLoopData = $childs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
     <?php
        if($menu->translation === NULL)
            continue;
        $active = '';
        $name = !empty($menu->translation->menu_title) ? $menu->translation->menu_title : $menu->translation->name;
        $url = $menu->type == 'page' ? app()->getLocale() . '/' . __('routes.page') . '/' . $menu->translation->url : app()->getLocale() . '/' . __('routes.' . $menu->type);
        $active = request()->segment(2) == $menu->translation->url ? 'active' : '';
    ?>
   <li>
        <a class="" title="<?php echo e($name); ?>" href="<?php echo e($url); ?>">
            <?php echo e($name); ?>

        </a>
        <?php echo count($menu->children) ? '<i class="bi bi-chevron-right"></i>' :''; ?>

        <?php if(count($menu->children)): ?>
            <?php echo $__env->make('layout.menu.subpages',['childs' => $menu->children,'depth'=>$menu->depth], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
   </li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH /var/www/html/architus/resources/views/layout/menu/subpages.blade.php ENDPATH**/ ?>