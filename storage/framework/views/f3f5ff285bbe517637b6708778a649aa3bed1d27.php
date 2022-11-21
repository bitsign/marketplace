<?php $__env->startSection('content'); ?>

<?php echo $__env->make('admin/layout/page-header',['page_title'=>$page_title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
<div class="col-md-6">
<div class="card shadow mb-3">
<div class="card-header"><?php echo e($page_title); ?> lista</div>
<div class="card-body">
<div class="row no-gutters align-items-center">
    <div class="col-lg-12"><?php echo $__env->make('layout/messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Típus azonostó</th>
                    <th>Név</th>
                    <th class="text-right">Műveletek</th>
                </tr>
            </thead>
            <tbody>
            <?php if(!empty($page_types)): ?>
                <?php $__currentLoopData = $page_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($pt->id); ?></td>
                        <td><?php echo e($pt->type); ?></td>
                        <td><?php echo e($pt->name); ?></td>
                        <td>
                            <div class="btn-group" style="float:right">
                                <a class="btn btn-success btn-xs" href="<?php echo e(url('admin/pages/page-types/false/'.$pt->id)); ?>"><i class="bi bi-tools"></i></a>
                                <form action="<?php echo e(url('admin/pages/page-types/delete/'.$pt->id)); ?>" method="post">
                                    <?php echo method_field('DELETE'); ?>
                                    <?php echo csrf_field(); ?>
                                    <a href="" class="btn btn-danger btn-xs" id="delete" onclick="event.preventDefault(); if(confirm('Biztos hogy törlöd ezt a tartalom típust?')){this.closest('form').submit();}"><i class="bi bi-trash"></i></a>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
            <tr>
                <td colspan="5">Nincs adat</td>
            </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
</div>

<div class="col-md-6">
<div class="card shadow mb-3 <?php echo e($edit === false ? '' : 'border-success'); ?>">
<div class="card-header">
    Oldal típus <?php echo e(!empty($page_type->name) ? $page_type->name : ""); ?> <?php echo e($edit === false ? 'létrehozása' : 'szerkesztése'); ?>

</div>
<div class="card-body">
<div class="row no-gutters align-items-center">
    <?php if($edit === true): ?>
        <form method="post" action="<?php echo e(url('/admin/pages/page-types/update/'.$page_type->id)); ?>" class="form-horizontal" role="form" id="page_type_form">
        <?php echo method_field('PUT'); ?>
    <?php else: ?>
         <form method="post" action="<?php echo e(url('/admin/pages/page-types/add/0')); ?>" class="form-horizontal" role="form" id="page_type_form">
    <?php endif; ?>
    <?php echo csrf_field(); ?>
    <div class="mb-3 row">
        <label class="col-lg-3 col-form-label">Oldal típus azonosító*</label>
        <div class="col-lg-9">
            <input name="type" type="text" value="<?php echo e(@$page_type->type); ?>" class="form-control" placeholder="Oldal típus azonosító" required>
            <small class="form-text">A resources/lang/routes.php fájlban beállított url-re mutatnak a beállított oldal típusok</small>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-lg-3 col-form-label">Oldal típus neve*</label>
        <div class="col-lg-9">
            <input name="name" type="text" value="<?php echo e(@$page_type->name); ?>" class="form-control" placeholder="Oldal típus neve" required>
        </div>
    </div>

    <hr />
    <div class="mb-3 row">
        <label class="col-lg-3 col-form-label"></label>
        <div class="col-lg-9">
            <button type="submit" class="btn btn-primary"><?php echo e($edit === false ? 'Feltölt' : 'Módosít'); ?></button>
            <?php if($edit === true): ?>
                <a href="<?php echo e(url('/admin/pages/page-types/view/0')); ?>" class="btn btn-danger">Mégsem</a>
            <?php endif; ?>
        </div>
    </div>
    </form>
</div>
</div>
</div>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/admin/pages/page-types.blade.php ENDPATH**/ ?>