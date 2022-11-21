<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    You will be charged $<?php echo e(number_format($package->price, 2)); ?> for <?php echo e($package->name); ?> Plan
                </div>
  
                <div class="card-body">
  
                    <form id="payment-form" action="<?php echo e(route('subscription.create')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="package" id="package" value="<?php echo e($package->id); ?>">
  
                        <div class="row">
                            <div class="col-xl-4 col-lg-4">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" id="card-holder-name" class="form-control" value="" placeholder="Name on the card">
                                </div>
                            </div>
                        </div>
  
                        <div class="row">
                            <div class="col-xl-4 col-lg-4">
                                <div class="form-group">
                                    <label for="">Card details</label>
                                    <div id="card-element"></div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12">
                            <hr>
                                <button type="submit" class="btn btn-primary" id="card-button" data-secret="<?php echo e($intent->client_secret); ?>">Purchase</button>
                            </div>
                        </div>
  
                    </form>
  
                </div>
            </div>
        </div>
    </div>
</div>
  
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('<?php echo e(env('STRIPE_KEY')); ?>')
  
    const elements = stripe.elements()
    const cardElement = elements.create('card')
  
    cardElement.mount('#card-element')
  
    const form = document.getElementById('payment-form')
    const cardBtn = document.getElementById('card-button')
    const cardHolderName = document.getElementById('card-holder-name')
  
    form.addEventListener('submit', async (e) => {
        e.preventDefault()
  
        cardBtn.disabled = true
        const { setupIntent, error } = await stripe.confirmCardSetup(
            cardBtn.dataset.secret, {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: cardHolderName.value
                    }   
                }
            }
        )
  
        if(error) {
            cardBtn.disable = false
        } else {
            let token = document.createElement('input')
            token.setAttribute('type', 'hidden')
            token.setAttribute('name', 'token')
            token.setAttribute('value', setupIntent.payment_method)
            form.appendChild(token)
            form.submit();
        }
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/architus/resources/views/packages/subscription.blade.php ENDPATH**/ ?>