<?php $__env->startSection('content'); ?>
<section id="<?php echo e($page->url); ?>" class="<?php echo e($page->url); ?>">
    <div class="container">
        <div class="row py-3">

            <?php if(!empty($faqs[0])): ?>
            <div class="accordion" id="accordionExample">
                <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $translation = json_decode($faq['transitions'],true); ?>
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading<?php echo e($key); ?>">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo e($key); ?>" aria-expanded="false" aria-controls="collapseThree">
                    <?php echo e($translation['name'][app()->getLocale()] ?? $faq['name']); ?>

                  </button>
                </h2>
                <div id="collapse<?php echo e($key); ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo e($key); ?>" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <?php echo $translation['content'][app()->getLocale()] ?? $faq['content']; ?>

                  </div>
                </div>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/myshop/resources/views/faqs/index.blade.php ENDPATH**/ ?>