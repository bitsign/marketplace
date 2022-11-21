<form action="<?php echo e(route('product-images.store')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="row mb-3">
        <div class="col-lg-12">
            <input id="file-1" type="file" multiple name="filename[]">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-offset-2 col-lg-8">
            <input type="hidden" name="product_id" value="<?php echo e($product->id ?? ''); ?>">
            <button type="submit" class="btn btn-primary btn-lg"><?php echo e(__('admin.upload')); ?></button>
        </div>
    </div>
</form>

<?php if(!empty($product->images)): ?>
<div class="row mb-3">
    <h4><?php echo e(__('admin.uploaded_images')); ?>:</h4>
    <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-lg-2">
        <div class="thumbnail">
        <div class="alert alert-success hidden" id="alerts_<?php echo e($img['id']); ?>" role="alert"></div>
        <div class="alert alert-danger hidden" id="alertd_<?php echo e($img['id']); ?>" role="alert"></div>
        <img class="m-auto" style="max-height:150px" src="<?php echo e(url('files/products/'.PROD_IMG_SIZE_THUMB_DIR.'/'.$img['filename'])); ?>">
        <div class="caption py-2">
            <label for="default_<?php echo e($img['id']); ?>" class="">
                <input type="radio" name="default" class="set_default" id="default_<?php echo e($img['id']); ?>" <?php echo e($img['default'] == 1 ? " checked " : ""); ?> value="1">
                <?php echo e(__('default')); ?>

            </label>
            <a class="btn btn-danger btn-xs float-end delete_image" id="delete_<?php echo e($img['id']); ?>" href="#">
                <i class="icon-trash icon-white"></i> <?php echo e(__('delete')); ?>

            </a>
            <hr>
            <div class="row">
                <div class="col-lg-3"><?php echo e(__('admin.title')); ?></div>
                <div class="col-lg-9"><input type="text" id="title_<?php echo e($img['id']); ?>" value="<?php echo e($img['title']); ?>" class="form-control form-control-sm"></div>

                <div class="col-lg-3"><?php echo e(__('admin.alt')); ?></div>
                <div class="col-lg-9"><input type="text" id="alt_<?php echo e($img['id']); ?>" value="<?php echo e($img['alt']); ?>" class="form-control form-control-sm"></div>
            </div>
            <hr>
            <input type="button" value="<?php echo e(__('admin.save')); ?>" id="save_<?php echo e($img['product_id']); ?>_<?php echo e($img['id']); ?>" class="save_image col-md-12 btn btn-primary">
            <div class="clearfix"></div>
        </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>

<div class="clearfix"></div>
<div class="callout callout-info">
    <?php if(config('app.admin_locale') == 'hu'): ?>
    <p>
    Az eredeti termékképek könyvtára: /public/files/products/original/ (maximális fotóméret magasság 1200px, szélesség 1200px). A könyvtár tartalma nem érhető el internetről.<br/>
    Innen a rendszer automatikusan 3 méretű fotót készít feltöltéskor 3 külön könyvtárba a <a class="link-primary" href="<?php echo e(url('admin/products/settings')); ?>">beállítások</a> alatt megadott méretekben: </br>
    1 - listakép (/files/products/small/)<br />
    2 - termék oldali kép (/files/products/medium/)<br />
    3 - nagy termék kép (/files/products/original/large/)<br />
    CSV-ből való termékfeltöltés esetén a termékképeket FTP-n keresztűl a <i>/files/products/original/</i> könyvtárba kell felmásolni, innen a rendszer automatikusan átméretezi.
    </p>
    <?php else: ?>
    <p>
    The library of original product images is /public/files/products/original/ (max. height 1200px, max. width 1200px). The contents of the library are not accessible from the Internet.<br/>
    From here, the system automatically creates 3 photo sizes when uploading to 3 separate directories in the sizes specified in the <a class="link-primary" href="<?php echo e(url('admin/products/settings')); ?>">settings</a>: </br>
    1 - list image (/files/products/small/)<br>
    2 - product page image (/files/products/medium/)<br>
    3 - large product image (/files/products/original/large/)<br>
    When uploading products from CSV, the product images must be copied to the directory via FTP, from where the system will automatically resize them.
    </p>
    <?php endif; ?>
</div>
<?php /**PATH /var/www/html/myshop/resources/views/admin/products/components/images-form.blade.php ENDPATH**/ ?>