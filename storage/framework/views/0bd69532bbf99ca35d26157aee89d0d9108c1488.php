<?php $__env->startSection('content'); ?>
    <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-12">
                    <?php echo $page->content; ?>

                </div>
            </div>
            <div class="row">
                <?php if(!empty($posts)): ?>
                    <div class="col-lg-8">
                        <div class="row">
                            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($post->active_from != null || $post->active_to != null): ?>
                                    <?php if($post->active_from >= date('Y-m-d') || $post->active_to < date('Y-m-d')): ?>
                                        <?php continue; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <img src="<?php echo e(url('files/editor/' . $post->image)); ?>" class="card-img-top"
                                            alt="<?php echo e($post->name); ?>">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo e($post->name); ?></h5>
                                            <small><i class="bi bi-clock"></i> <?php echo e($post->created_at); ?></small>
                                            <div class="card-text"><?php echo $post->intro; ?></div>
                                            <a href="<?php echo e(url(app()->getLocale() . '/' . __('routes.post') . '/' . $post->url)); ?>"
                                                class="btn btn-primary"><?php echo e(__('details')); ?></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="sidebar pt-3">
                            <div class="sidebar-item search-form mb-3">
                                <h3 class="sidebar-title"><?php echo e(__('search')); ?></h3>
                                <form action="<?php echo e(url()->current()); ?>" class="mt-3" method="get">
                                    <div class="input-group">
                                      <input type="text" class="form-control rounded-0" name="search" value="<?php echo e(request('search') ?? ''); ?>">
                                      <button type="submit" class="btn btn-outline-secondary rounded-0"> <i class="bi bi-search"></i></button>
                                    </div>
                                </form>
                            </div>

                            <div class="sidebar-item archives">
                                <h3 class="sidebar-title mb-3"><?php echo e(__('archive')); ?></h3>
                                <ul class="mt-3">
                                    <?php $__currentLoopData = $archives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stats): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a href="<?php echo e(url(app()->getLocale().'/'.__('routes.blog').'?year='.$stats['year'].'&month='.$stats['month'])); ?>">
                                            <?php echo e($stats['year']); ?> <?php echo e($stats['monthname']); ?> (<?php echo e($stats['published']); ?>)
                                        </a>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>

                            <div class="sidebar-item tags">
                                <h3 class="sidebar-title"><?php echo e(__('tags')); ?></h3>
                                <ul class="mt-3">
                                    <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a href="<?php echo e(url(app()->getLocale().'/'.__('routes.blog').'?term='.$term['term_key'])); ?>">
                                            <?php echo e($term['name']); ?>

                                        </a>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="row">
                <div class="col text-center">
                    <?php echo e($posts->links()); ?>

                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/blog/index.blade.php ENDPATH**/ ?>