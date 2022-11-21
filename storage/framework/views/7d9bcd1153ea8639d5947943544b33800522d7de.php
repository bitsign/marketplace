<?php $__env->startSection('content'); ?>

    <?php if(!empty($banners)): ?>
        <div id="hero" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $translations = json_decode($b['translations'],true) ?>
                    <button type="button" data-bs-target="#hero" data-bs-slide-to="<?php echo e($loop->index); ?>"
                        class="<?php echo e($loop->index == 0 ? 'active' : ''); ?>" aria-current="true"
                        aria-label="<?php echo e($translations['title'][app()->getLocale()] ?? ''); ?>"></button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="carousel-inner">
                <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $translations = json_decode($b['translations'],true) ?>
                    <div class="carousel-item <?php echo e($loop->index == 0 ? 'active' : ''); ?>" data-bs-interval="5000">
                        <img src="<?php echo e(url('files/editor/' . $b->image)); ?>"
                            class="img-fluid d-block animate__animated animate__zoomIn" alt="<?php echo e($translations['title'][app()->getLocale()] ?? ''); ?>" alt="<?php echo e($translations['alt'][app()->getLocale()] ?? $translations['title'][app()->getLocale()] ?? ''); ?>">
                        <div class="carousel-caption d-none d-md-block">
                            <h2 class="animate__animated animate__fadeInDown"><?php echo e($translations['title'][app()->getLocale()] ?? ''); ?></h5>
                                <div class="animate__animated animate__fadeInUp desc"><?php echo $translations['description'][app()->getLocale()] ?? ''; ?></div>
                                <?php if(!empty($translations['url'][app()->getLocale()])): ?>
                                    <a href="<?php echo e(url(app()->getLocale() . '/' . $translations['url'][app()->getLocale()])); ?>"
                                        class="btn btn-primary animate__animated animate__fadeInUp"><?php echo e(__('details')); ?></a>
                                <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#hero" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#hero" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden"></span>
            </button>
        </div>
    <?php endif; ?>

    <section class="featured_categories py-5">
        <div class="container-fluid">
            <h2 class="text-center my-4"><?php echo e(__('categories')); ?></h2>
            <div class="row">
                <?php $__currentLoopData = $main_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($category->translation == null): ?>
                        <?php continue; ?>
                    <?php endif; ?>
                    <?php
                        $name = !empty($category->translation->name) ? $category->translation->name : $category->name;
                        $url = $category->translation->url ?? '';
                        //$prefix = count($category->children) ? app()->getLocale().'/'.__('routes.categories') : app()->getLocale().'/'.__('routes.products');
                        $prefix = app()->getLocale() . '/' . __('routes.products');
                    ?>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <a href="<?php echo e(url($prefix . '/' . $url)); ?>" title="<?php echo e($name); ?>">
                                <img src="<?php echo e(url('files/editor/' . $category->image)); ?>" class="card-img-top"
                                    alt="<?php echo e($name); ?>">
                            </a>
                            <div class="card-body text-center">
                                <h5 class="card-title text-center"><a href="<?php echo e(url($prefix . '/' . $url)); ?>"
                                        class="btn btn-primary"><?php echo e($name); ?></a></h5>
                                <p class="card-text"><?php echo e($category->short_description ?? ''); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    <?php if(!empty($featured_products)): ?>
        <section class="featured_products bg-primary py-5 text-dark bg-opacity-10">
            <div class="container-fluid">
                <h2 class="text-center my-4"><?php echo e(__('featured_products')); ?></h2>
                <div class="row">
                    <?php echo $__env->make('products.list',['products'=>$featured_products,'col'=>3], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if(!empty($blocks)): ?>
    <section class="blocks">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <?php $__currentLoopData = $blocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $block): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $b_trans = json_decode($block['translations'],true) ?>
                    <div class="col-md-4">
                        <div class="card mb-3 border-0">
                            <?php if($block->image): ?>
                                <img src="<?php echo e(url('files/editor/' . $block->image)); ?>" class="card-img-top w-auto m-auto"
                                    alt="<?php echo e($b_trans['title'][app()->getLocale()] ?? ''); ?>">
                            <?php endif; ?>
                            <div class="card-body text-center">
                                <h5 class="card-title text-center"> <?php echo e($b_trans['title'][app()->getLocale()] ?? ''); ?></h5>
                                <p class="card-text"><?php echo e($b_trans['content'][app()->getLocale()] ?? ''); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if(count($packages) > 0): ?>
    <section class="packages bg-primary bg-opacity-10 py-5">
    <div class="container">
        <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
            <h1 class="display-4 fw-normal"><?php echo e(__('packages')); ?></h1>
            <p class="fs-5 text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
            <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal"><?php echo e($package->name); ?></h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title"><?php echo e(currency($package->price)); ?></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li><?php echo e($package->product_nr); ?> <?php echo e(__('product')); ?></li>
                            <li><?php echo e($package->months); ?> <?php echo e(__('month')); ?></li>
                            
                        </ul>
                        <a href="<?php echo e(route('vendor.login-register')); ?>" class="w-100 btn btn-lg btn-outline-primary"><?php echo e(__('i_order')); ?></a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    </section>
    <?php endif; ?>

    <?php if(!empty($services)): ?>
        <section class="services">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($service->translation === NULL): ?>
                            <?php continue; ?>
                        <?php endif; ?>
                        <div class="col-md-4">
                            <div class="card mb-3 border-0">
                                <?php if($service->image): ?>
                                    <img src="<?php echo e(url('files/editor/' . $service->image)); ?>" class="card-img-top m-auto" alt="<?php echo e($service->title); ?>">
                                <?php endif; ?>
                                <div class="card-body text-center">
                                    <h5 class="card-title text-center">
                                        <a class="<?php echo e(request()->segment(2) == $service->translation->url ? 'active' : ''); ?>"
                                            href="<?php echo e(app()->getLocale() . '/' . __('routes.service') . '/' . $service->translation->url); ?>">
                                            <?php echo e(!empty($service->translation->menu_title) ? $service->translation->menu_title : $service->translation->name); ?>

                                        </a>
                                    </h5>
                                    <p class="card-text text-dark"><?php echo $service->translation->content; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if(!empty($team)): ?>
        <section class="blocks py-5 bg-primary bg-opacity-10">
            <div class="container-fluid">
                <div class="row">
                    <?php $__currentLoopData = $team; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $translation = json_decode($member['translations'],true) ?>
                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <img src="<?php echo e(url('files/editor/' . $member->image)); ?>" class="rounded-circle"
                                        width="200" height="200">
                                    <h5 class="card-title mt-2 mb-1"><?php echo e($member->name); ?></h5>
                                    <span class="fs-2 mb-3 font-weight-bold"><?php echo e($translation['occupation'][app()->getLocale()] ?? $member->occupation); ?></span>
                                    <p class="mb-3 mt-3"><?php echo $translation['intro'][app()->getLocale()] ?? $member->intro; ?></p>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a href="<?php echo e($member->contact); ?>" target="_blank"><i
                                                    class="bi bi-facebook"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if(!empty($manufacturers)): ?>
        <section class="manufacturers py-5">
            <div class="container-fluid">
                <div class="row justify-content-center align-items-center">
                    <?php $__currentLoopData = $manufacturers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manufacturer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-2">
                            <a href="<?php echo e(app()->getLocale() . '/' . __('routes.manufacturer') . '/' . $manufacturer->url); ?>"
                                target="_blank">
                                <img src="<?php echo e(url('files/editor/manufacturers/' . $manufacturer->image)); ?>" class="rounded"
                                    width="100">
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/myshop/resources/views/front-page.blade.php ENDPATH**/ ?>