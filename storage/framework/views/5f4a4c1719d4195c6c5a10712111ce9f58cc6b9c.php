<nav class="navigation bg-primary">
    <div class="d-xl-flex align-items-center justify-content-between">

        <a class="btn btn-primary text-white d-xl-none catalog_btn float-start">
            <span class="bi bi-list"></span> <?php echo e(__('categories')); ?>

        </a>

        <a class="btn btn-primary text-white d-xl-none pages_btn float-end">
            <span class="bi bi-list"></span> <?php echo e(__('pages')); ?>

        </a>

        <div class="category_menu" id="category_menu">
            <ul>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(empty($category->translation->name)): ?>
                        <?php continue; ?>
                    <?php endif; ?>
                    <?php
                        $prefix = app()->getLocale();
                        //$category_url = count($category->children) ? __('routes.categories') : __('routes.products');
                        $category_url = __('routes.products');
                    ?>
                    <li class="<?php echo e(request()->segment(3) == $category->translation->url ? 'active' : ''); ?>">
                        <a class="" href="<?php echo e(url($prefix . '/' . $category_url . '/' . $category->translation->url)); ?>"
                            title="<?php echo e($category->translation->name); ?>">
                            <?php echo e($category->translation->name); ?>

                        </a>
                        <?php echo count($category->children) ? '<i class="bi bi-chevron-down"></i>' : ''; ?>

                        <?php if(count($category->children)): ?>
                            <?php echo $__env->make('layout.menu.subcategories', [
                                'childs' => $category->children,
                                'depth' => $category->depth,
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>

        <div class="pages_menu" id="pages_menu">
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
<?php /**PATH /var/www/html/myshop/resources/views/layout/menu/categories_menu.blade.php ENDPATH**/ ?>