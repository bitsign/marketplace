<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
<base href="<?php echo e(url('/')); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?php echo e($meta_description ?? META_DESCRIPTION); ?>">
<meta name="keywords" content="<?php echo e($meta_keywords ?? META_KEYWORDS); ?>">
<meta property="og:url" content="<?php echo e(url()->current()); ?>" />
<meta property="og:title" content="<?php echo e(isset($meta_title) ? $meta_title.' | ' : ''); ?> <?php echo e(SHOP_NAME); ?>" />
<meta property="og:description" content="<?php echo e($meta_description ?? META_DESCRIPTION); ?>" />
<meta property="og:image" content="<?php echo e(!empty($og_image) ? url($og_image) : url('assets/img/logo_fb.png')); ?>" />
<meta property="og:image:type" content="image/jpeg" />
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title><?php echo e(isset($meta_title) ? $meta_title.' | ' : ''); ?> <?php echo e(SHOP_NAME); ?></title>
<!-- Favicons -->
<link href="<?php echo e(asset('img/favicon.ico')); ?>" rel="icon">

<!-- Vendor CSS Files -->
<link href="<?php echo e(asset('vendor/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('vendor/bootstrap-icons/bootstrap-icons.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('vendor/bootstrap-select/css/bootstrap-select.min.css')); ?>" rel="stylesheet">

<!-- Dynamic CSS Files -->
<?php if(isset($css) && (!empty($css))): ?>
<?php $__currentLoopData = $css; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $style): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<link rel="stylesheet" href="<?php echo e(strpos($style,'http:') === false && strpos($style,'https:') === false ? url('assets/css/'.$style):$style); ?>">
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<!-- Theme CSS File -->
<link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet">

<script>
var base_url = "<?php echo e(url('/').'/'); ?>";
var current_locale = "<?php echo e(app()->getLocale()); ?>";
</script>
</head>
<body class="<?php echo e(!empty($body_class) ? $body_class : ''); ?>">

    <?php echo $__env->make('layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main id="main">
        <?php echo $__env->make('layout.breadcrumbs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="to_top" id="gotoTop">
        <div class="d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></div>
    </div>

    <script type="text/javascript" src="<?php echo e(asset('vendor/jquery/jquery-3.6.0.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('vendor/jquery/jquery-migrate-3.4.0.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('vendor/bootstrap-select/js/bootstrap-select.min.js')); ?>"></script>
    <?php if(app()->getLocale() != 'en'): ?>
        <script type="text/javascript" src="<?php echo e(asset('vendor/bootstrap-select/js/i18n/defaults-'.app()->getLocale().'_'.strtoupper(app()->getLocale()).'.js')); ?>"></script>
    <?php endif; ?>

    <?php if(isset($js) && (!empty($js))): ?>
        <?php $__currentLoopData = $js; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $script): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <script src="<?php echo e(strpos($script,'http') === false ? url('assets/js/'.$script):$script); ?>"></script>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <script type="text/javascript" src="<?php echo e(asset('js/main.js')); ?>"></script>

    <?php if(!isset($_COOKIE['policy_cookie'])): ?>
    <div id="cookiePol">
        <div class="container">
            <div class="cookie_text">
                <?php echo e(__('cookie_text',['Shop_name'=>SHOP_NAME])); ?>

                <a href="<?php echo e(url(app()->getLocale().'/'.__('routes.privacy_policy'))); ?>" target="_blank"><?php echo e(__('details')); ?></a>
                <a id="accept" href="#"> OK </a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</body>
</html>
<?php /**PATH /var/www/html/myshop/resources/views/layout/page.blade.php ENDPATH**/ ?>