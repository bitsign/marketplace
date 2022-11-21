@extends('layout.page')
@section('content')
<section class="h-100">
    <div class="container py-4">
        <div class="row d-flex justify-content-center my-4">
            <div class="col-md-12 text-center">
                <img src="{{ asset('img/siker.png') }}" width="80px" class="m-auto">
                <h1>{{ __('thanks_for_order') }}</h1>
                @include('layout.messages')
                {{ __('order_success') }}
            </div>
        </div>
    </div>
</section>
@endsection
