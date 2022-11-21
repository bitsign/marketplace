<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title><?php echo SHOP_NAME ?> admin</title>
    <link href="/assets/admin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('admin/images/favicon.ico') }}">
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
        <h1 class="h3 mb-3 fw-normal">{{ __('login') }}</h1>
        @include('layout.messages')
        @if(empty(session('admin_wait_time')))
        <form action="{{ route('admin_login') }}" method="post">
           @csrf

            <div class="form-floating">
                <input type="email" class="form-control" name="email" placeholder="{{ __('email') }}" required="required">
                <label for="floatingInput">{{ __('email') }}</label>
                <span class="text-danger">@error('email'){{ $message }} @enderror</span>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" name="password" placeholder="{{ __('password') }}" required="required">
                <label for="floatingPassword">{{ __('password') }}</label>
                <span class="text-danger">@error('password'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <button type="submit" class="w-100 btn btn-lg btn-primary">{{ __('login') }}</button>
            </div>
            <p class="mt-5 mb-3 text-muted">&copy; 2017–<?php echo date("Y") ?></p>
        </form>
        @else
            @php
                header("Refresh:".session('admin_wait_time')."; url=".url()->current());
                if(time()+session('admin_wait_time') > time())
                    session()->forget('admin_wait_time');
            @endphp
        @endif
    </main>
    <script src="{{ asset('admin/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('admin/js/jquery-migrate-3.3.2.js') }}"></script>
    <script>
    function disableF5Btn(e) {
        if ((e.which || e.keyCode) == 116)
            e.preventDefault();
    };
    $(document).bind("keydown", disableF5Btn);
    </script> 
</body>
</html>
