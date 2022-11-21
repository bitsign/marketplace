<nav class="navigation bg-primary">
    <div class="d-xl-flex align-items-center justify-content-between">

        <a class="btn btn-primary text-white d-xl-none catalog_btn float-start">
            <span class="bi bi-list"></span> <?php echo e(__('categories')); ?>

        </a>

        <a class="btn btn-primary text-white d-xl-none pages_btn float-end">
            <span class="bi bi-list"></span> <?php echo e(__('pages')); ?>

        </a>

        

        <div class="pages_menu m-auto" id="pages_menu">
            <ul>
                <?php $__currentLoopData = $pages_menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        if($menu->translation === NULL)
                            continue;
                        $active = ''; $disabled = '';
                        $name = !empty($menu->translation->menu_title) ? $menu->translation->menu_title : $menu->translation->name;
                        $url = $menu->type == 'page' 
                            ? app()->getLocale() . '/' . __('routes.page') . '/' . $menu->translation->url 
                            : app()->getLocale() . '/' . __('routes.' . $menu->type);
                        $active = request()->segment(2) == $menu->translation->url ? 'active' : '';
                        if (count($menu->children) > 0)
                            $active = "pe-none";
                    ?>
                    <li class="">
                        <a class="<?php echo e($active); ?> text-white" href="<?php echo e($url); ?>" tabindex="-1" aria-disabled="true">
                            <?php echo e($name); ?>

                        </a>
                        <?php echo count($menu->children) > 0 ? '<span class="bi bi-chevron-down"></span>' : ''; ?>

                        <?php if(count($menu->children) > 0): ?>
                            <?php echo $__env->make('layout.menu.subpages', ['childs' => $menu->children], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>

    </div>
</nav>
<?php /**PATH D:\laragon\www\architus\resources\views/layout/menu/categories_menu.blade.php ENDPATH**/ ?>