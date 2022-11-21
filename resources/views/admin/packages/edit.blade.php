@extends('admin.layout.app')
@section('content')

@include ('admin/layout/page-header',['page_title'=>$page_title])
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header"><b>{{ $page_title }}</b></div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">

                    <div class="col-lg-12">@include('layout/messages')</div>
                    <form method="post" action="{{ route('packages.update',$package->id) }}" class="form-horizontal" role="form" id="page_form">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.name') }} <code>*</code></label>
                            <div class="col-lg-8">
                                <input name="name" type="text" value="{{ $package->name }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">Url <code>*</code></label>
                            <div class="col-lg-8">
                                <input name="url" type="text" value="{{ $package->url }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('products') }} <code>*</code></label>
                            <div class="col-lg-8">
                                <input name="product_nr" type="text" value="{{ $package->product_nr }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('price') }}</label>
                            <div class="col-lg-8">
                                <input name="price" type="text" value="{{ $package->price }}" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('action_price') }}</label>
                            <div class="col-lg-8">
                                <input name="action_price" type="text" value="{{ $package->action_price }}" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">Stripe ID</label>
                            <div class="col-lg-8">
                                <input name="stripe_plan" type="text" value="{{ $package->stripe_plan }}" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.description') }}</label>
                            <div class="col-lg-8">
                                <textarea name="description" class="editor">{{ $package->description }}</textarea>
                            </div>
                        </div>

                        <hr />
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"></label>
                            <div class="col-lg-9">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> {{ __('admin.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
