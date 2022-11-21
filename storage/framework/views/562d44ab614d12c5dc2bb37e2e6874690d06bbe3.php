<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title><?php echo SHOP_NAME ?> admin</title>
    <link href="/assets/admin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="<?php echo e(asset('admin/images/favicon.ico')); ?>">
    <style type="text/css">
        html,
        body {
          height: 100%;
        }

        body {
          display: flex;
          align-items: center;
          padding-top: 40px;
          padding-bottom: 40px;
          background-color: #f5f5f5;
          flex-direction: column;
        }

        .form-signin {
          width: 100%;
          max-width: 330px;
          padding: 15px;
          margin: auto;
        }

        .form-signin .checkbox {
          font-weight: 400;
        }

        .form-signin .form-floating:focus-within {
          z-index: 2;
        }

        .form-signin input[type="email"] {
          margin-bottom: -1px;
          border-bottom-right-radius: 0;
          border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
          margin-bottom: 10px;
          border-top-left-radius: 0;
          border-top-right-radius: 0;
        }
    </style>
</head>
<body class="text-center">
    <main class="form-signin">
        <h1 class="h3 mb-3 fw-normal"><?php echo e(__('login')); ?></h1>
        <?php echo $__env->make('layout.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php if(empty(session('admin_wait_time'))): ?>
        <form action="<?php echo e(route('admin_login')); ?>" method="post">
           <?php echo csrf_field(); ?>

            <div class="form-floating">
                <input type="email" class="form-control" name="email" placeholder="<?php echo e(__('email')); ?>" required="required">
                <label for="floatingInput"><?php echo e(__('email')); ?></label>
                <span class="text-danger"><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></span>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" name="password" placeholder="<?php echo e(__('password')); ?>" required="required">
                <label for="floatingPassword"><?php echo e(__('password')); ?></label>
                <span class="text-danger"><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></span>
            </div>
            <div class="form-group">
                <button type="submit" class="w-100 btn btn-lg btn-primary"><?php echo e(__('login')); ?></button>
            </div>
            <p class="mt-5 mb-3 text-muted">&copy; 2017–<?php echo date("Y") ?></p>
        </form>
        <?php else: ?>
            <?php
                header("Refresh:".session('admin_wait_time')."; url=".url()->current());
                if(time()+session('admin_wait_time') > time())
                    session()->forget('admin_wait_time');
            ?>
        <?php endif; ?>
    </main>
    <script src="<?php echo e(asset('admin/js/jquery-3.6.0.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/jquery-migrate-3.3.2.js')); ?>"></script>
    <script>
    function disableF5Btn(e) {
        if ((e.which || e.keyCode) == 116)
            e.preventDefault();
    };
    $(document).bind("keydown", disableF5Btn);
    </script> 
</body>
</html>
<?php /**PATH /var/www/html/architus/resources/views/admin/login/login.blade.php ENDPATH**/ ?>