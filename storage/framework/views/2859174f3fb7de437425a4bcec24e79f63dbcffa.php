<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($page_title ?? ''); ?> | Admin</title>
    <link rel="icon" href="<?php echo e(asset('admin/images/favicon.ico')); ?>">
    <link href="<?php echo e(asset('admin/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('admin/css/bootstrap-toggle.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('admin/fonts/bootstrap-icons.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('admin/plugins/jquery-ui/jquery-ui.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('admin/plugins/bootstrap-fileinput/css/fileinput.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('admin/plugins/select2/select2.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('admin/plugins/select2/select2-bootstrap-5-theme.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('admin/plugins/fancybox/source/jquery.fancybox.css')); ?>" rel="stylesheet">
    <?php if(isset($css) && (!empty($css))): ?>
        <?php $__currentLoopData = $css; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <link rel="stylesheet" href="<?php echo e(strpos($cs,'http:') === false && strpos($cs,'https:') === false ? asset('admin/css/'.$cs):$cs); ?>">
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    <link href="<?php echo e(asset('admin/css/common.css')); ?>" rel="stylesheet">
    <script>
        var base_url = "<?php echo e(url('/')); ?>/";
        var admin_locale = "<?php echo e(config('app.admin_locale')); ?>";
        var all = "<?php echo e(__('all')); ?>";
    </script>
    </head>
    <body class="">
       <div class="wrapper">

        <?php echo $__env->make('admin.layout.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div id="content" class="d-flex flex-column h-100">
            <nav class="navbar navbar-expand-lg bg-primary">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="bi bi-text-left"></i>
                    <span></span>
                </button>

                <div class="btn-group ms-auto me-4">
                  <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                    <span class="mx-1">
                        <i class="bi bi-person"></i>
                        <span class="d-none d-sm-inline"><?php echo e(Auth::guard('admin')->user()->name ?? ""); ?></span>
                    </span>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a href="<?php echo e(Auth::guard('admin')->user() !== NULL ? route('administrators.edit',Auth::guard('admin')->user()->id) : ''); ?>" class="dropdown-item btn btn-default btn-flat">
                            <i class="bi bi-person-fill"></i> <?php echo e(__('admin.account')); ?>

                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?php echo e(route('admin.logout')); ?>" class="btn btn-default btn-flat">
                            <i class="bi bi-key"></i> <?php echo e(__('logout')); ?>

                        </a>
                    </li>
                  </ul>
                </div>
            </nav>

            <div class="content flex-shrink-0">
                <div class="container-fluid">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>

            <?php echo $__env->make('admin.layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        </div>
    </div>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="bi bi-chevron-up"></i>
    </a>

    <script src="<?php echo e(asset('admin/js/jquery-3.6.0.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/jquery-migrate-3.3.2.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/bootstrap-toggle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/plugins/jquery-ui/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/plugins/bootstrap-fileinput/js/fileinput.min.js')); ?>"></script>
    <?php if(config('app.admin_locale') != 'en'): ?>
        <script src="<?php echo e(asset('admin/plugins/bootstrap-fileinput/js/locales/'.config('app.admin_locale').'.js')); ?>"></script>
    <?php endif; ?>
    <script src="<?php echo e(asset('admin/plugins/select2/select2.full.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/plugins/fancybox/source/jquery.fancybox.pack.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/jquery.validate.min.js')); ?>"></script>
    <?php if(config('app.admin_locale') != 'en'): ?>
        <script src="<?php echo e(asset('admin/js/localization/messages_'.config('app.admin_locale').'.js')); ?>"></script>
    <?php endif; ?>
    <script src="<?php echo e(asset('admin/plugins/tinymce/tinymce.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/tinymce_settings.js')); ?>"></script>
    <?php if(config('app.admin_locale') != 'en'): ?>
        <script src="<?php echo e(asset('admin/plugins/tinymce/langs/'.config('app.admin_locale').'.js')); ?>"></script>
    <?php endif; ?>
    <?php if(isset($scripts) && (!empty($scripts))): ?>
        <?php $__currentLoopData = $scripts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $script): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <script src="<?php echo e(strpos($script,'http:') === false && strpos($script,'https:') === false ? asset('admin/js/'.$script):$script); ?>"></script>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    <script src="<?php echo e(asset('admin/js/common.js')); ?>"></script>
  </body>
</html>
<?php /**PATH /var/www/html/architus/resources/views/admin/layout/app.blade.php ENDPATH**/ ?>