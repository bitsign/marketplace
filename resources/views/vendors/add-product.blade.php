@extends('layout.page')
@section('content')
<section class="section profile">
    <div class="container">
    <div class="row my-3">
        @include('layout.messages')
 
        @include('vendors.sidebar')

        <div class="col-md-9">
            <div class="card border-0">
                <div class="card-body pt-3">
                   <!-- Profile Edit Form -->
                    <form action="{{ route('vendor.profile') }}" method="POST">
                    @csrf
                        <div class="row mb-2">
                            <label class="col-lg-3 text-end">{{ __('name') }} <code>*</code></label>
                            <div class="col-lg-9">
                                <input name="name" type="text" value="{{ old('name') }}" class="form-control">
                            </div>
                        </div>
                        
                    

                        <div class="offset-md-3">
                            <button type="submit" class="btn btn-primary">{{ __('admin.save') }}</button>
                        </div>
                    </form><!-- End Profile Edit Form -->
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection
