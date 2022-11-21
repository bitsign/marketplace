<?php $__env->startSection('content'); ?>

<?php echo $__env->make('admin/layout/page-header',['page_title'=>$page_title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header"><b><?php echo e($product['name'] ??  $page_title); ?></b></div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-lg-12"><?php echo $__env->make('layout/messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></div>

                    <ul class="nav nav-pills" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true">
                                <?php echo e(__('admin.general_datas')); ?>

                            </button>
                        </li>
                        <?php if(!empty($product['id'])): ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false">
                                <?php echo e(__('admin.images')); ?>

                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab0-tab" data-bs-toggle="tab" data-bs-target="#tab0" type="button" role="tab" aria-controls="tab0" aria-selected="false">
                                <?php echo e(__('admin.attributes')); ?>

                            </button>
                        </li>
                        <!--li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab10-tab" data-bs-toggle="tab" data-bs-target="#tab10" type="button" role="tab" aria-controls="tab10" aria-selected="false">
                                
                            </button>
                        </li-->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3" type="button" role="tab" aria-controls="tab3" aria-selected="false">
                                <?php echo e(__('admin.attached_products')); ?>

                            </button>
                        </li>
                        
                        <?php endif; ?>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active  py-3" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                            <?php echo $__env->make('admin.products.components.default-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="tab-pane fade py-3" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                            <?php echo $__env->make('admin.products.components.images-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="tab-pane fade py-3" id="tab0" role="tabpanel" aria-labelledby="tab0-tab">
                            <?php echo $__env->make('admin.products.components.attributes-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <!--div class="tab-pane fade py-3" id="tab10" role="tabpanel" aria-labelledby="tab10-tab">
                            
                        </div-->
                        <div class="tab-pane fade py-3" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                            <?php echo $__env->make('admin.products.components.attached-prods-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="tab-pane fade py-3" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
                            
                        </div>
                        <div class="tab-pane fade py-3" id="tab5" role="tabpanel" aria-labelledby="tab5-tab">
                             
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/myshop/resources/views/admin/products/form.blade.php ENDPATH**/ ?>