@extends('admin.layout.app')
@section('content')
    @include ('admin/layout/page-header', ['page_title' => $page_title])
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header"><b>{{ $page_title }}</b></div>
                <div class="card-body">
                    <div class="row no-gutters align-items-center">

                        <div class="col-lg-12">@include('layout/messages')</div>

                        <form method="post" action="{{ route('payment-methods.update', $paymentMethod) }}"
                            class="form-horizontal" role="form" id="payment_form">
                            @method('PUT')
                            @csrf

                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end">{{ __('admin.title') }} <code>*</code></label>
                                <div class="col-lg-10">
                                    @foreach (config('app.available_locales') as $lang)
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"><img src="{{ url('assets/img/' . $lang . '.png') }}"
                                                width="18px"></span>
                                        <input name="translations[name][{{ $lang }}]" type="text"
                                            value="{{ $translations['name'][$lang] ?? '' }}" class="form-control" required>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end">{{ __('admin.id') }} <code>*</code></label>
                                <div class="col-lg-10">
                                    <input name="code" type="text" value="{{ $paymentMethod['code'] }}"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end">{{ __('admin.price') }}</label>
                                <div class="col-lg-10">
                                    <input name="value" type="text" value="{{ $paymentMethod['value'] }}"
                                        class="form-control">
                                </div>
                            </div>

                            @foreach (config('app.available_locales') as $lang)
                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end">{{ __('admin.description') }} <img
                                        src="{{ url('assets/img/' . $lang . '.png') }}" width="18px"></label>
                                <div class="col-lg-10">
                                    <textarea class="editor form-control" name="translations[description][{{ $lang }}]" rows="10" cols="80">{{ $translations['description'][$lang] ?? '' }}</textarea>
                                </div>
                            </div>
                            @endforeach

                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end">{{ __('admin.active') }}?</label>
                                <div class="col-lg-10">
                                    <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-size="mini"
                                        data-on="Igen" data-off="Nem" data-toggle="toggle" name="active" value="1"
                                        {{ !empty($paymentMethod['active']) || empty($paymentMethod['id']) ? 'checked' : '' }} />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end">{{ __('admin.sort_order') }}</label>
                                <div class="col-lg-10">
                                    <input name="sort" value="{{ $paymentMethod['sort'] ?? 0 }}" type="text"
                                        class="form-control">
                                </div>
                            </div>
                            <hr />
                            <div class="mb-3 row">
                                <label class="col-lg-2 text-lg-end"></label>
                                <div class="col-lg-9">
                                    <button type="submit" class="btn btn-primary">{{ __('admin.save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
