@extends('layout.page')
@section('content')
<section class="h-100">
    <div class="container py-5">
        <div class="row d-flex justify-content-center my-4">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0">{{ __('checkout') }}</h5>
                    </div>
                    <div class="card-body">
                        <h4 class="mb-3">{{ __('billing_data') }}</h4>
                        <form action="{{ url(app()->getLocale().'/save-order') }}" class="needs-validation" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-sm-4">
                                    <label for="firstName" class="form-label">{{ __('name') }}</label>
                                    <input type="text" name="name" class="form-control" id="firstName" placeholder="" value="{{ Auth::check() ? Auth::user()->name : '' }}" required>
                                </div>

                                <div class="col-sm-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="" value="{{ Auth::check() ? Auth::user()->email : '' }}" required>
                                </div>

                                <div class="col-sm-4">
                                    <label for="phone" class="form-label">{{ __('phone') }}</label>
                                    <input type="phone" name="phone" class="form-control" id="phone" placeholder="" value="{{ Auth::check() ? Auth::user()->phone : '' }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="country" class="form-label">{{ __('country') }}</label>
                                    {{-- <select  id="country-dd" class="form-select select2" required>
                                        <option value="">{{ __('please_select') }}</option>
                                        @foreach ($countries as $data)
                                        <option value="{{ $data->id }}">
                                            {{ $data->native }}
                                        </option>
                                        @endforeach
                                    </select> --}}
                                    <input type="text" name="country" class="form-control" id="country" value="{{ old('country') ?? (Auth::check() ? Auth::user()->country : '') }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="state" class="form-label">{{ __('state') }}</label>
                                    {{-- <select id="state-dd" class="form-select select2" required></select> --}}
                                    <input type="text" name="state" class="form-control" id="state" value="{{ old('state') ?? (Auth::check() ? Auth::user()->state : '') }}">
                                </div>

                                <div class="col-3">
                                    <label for="city" class="form-label">{{ __('city') }}</label>
                                    {{-- <select id="city-dd" class="form-select select2" required></select> --}}
                                    <input type="text" name="city" class="form-control" id="city" value="{{ old('city') ?? (Auth::check() ? Auth::user()->city : '') }}">
                                </div>

                                <div class="col-md-3">
                                    <label for="zip" class="form-label">{{ __('zip') }}</label>
                                    <input type="number" min="1" name="zip" class="form-control" id="zip" placeholder="" value="{{ old('zip') ?? (Auth::check() ? Auth::user()->zip : '') }}" required="">
                                </div>

                                <div class="col-6">
                                    <label for="address" class="form-label">{{ __('address') }}</label>
                                    <input type="text" name="address"  class="form-control" id="address" placeholder="" value="{{ old('address') ?? (Auth::check() ? Auth::user()->address : '') }}" required>
                                </div>

                            </div>

                            <hr class="my-4">

                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" id="same-address" {{ isset(Auth::user()->state2) ? '' : 'checked' }}>
                                <label class="form-check-label" for="same-address">{{ __('same_as_billing_data') }}</label>
                            </div>

                            <div class="same_as_billing mb-3" {!! isset(Auth::user()->state2) ? '' : 'style="display:none"' !!}>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="state2" class="form-label">{{ __('state') }}</label>
                                        <input type="text" name="state2" class="form-control" id="state2" value="{{ old('state2') ?? (Auth::check() ? Auth::user()->state2 : '') }}" >
                                    </div>

                                    <div class="col-md-6">
                                        <label for="zip2" class="form-label">{{ __('zip') }}</label>
                                        <input type="number" min="1" name="zip2" class="form-control" id="zip2" placeholder="" value="{{ old('zip2') ?? (Auth::check() ? Auth::user()->zip2 : '') }}" >
                                    </div>

                                    <div class="col-6">
                                        <label for="city2" class="form-label">{{ __('city') }}</label>
                                        <input type="text" name="city2"  class="form-control" id="address" placeholder="" value="{{ old('city2') ?? (Auth::check() ? Auth::user()->city2 : '') }}" >
                                    </div>

                                    <div class="col-6">
                                        <label for="address2" class="form-label">{{ __('address') }}</label>
                                        <input type="text" name="address2"  class="form-control" id="address2" placeholder="" value="{{ old('address2') ?? (Auth::check() ? Auth::user()->address2 : '') }}" >
                                    </div>
                                </div>
                            </div>

                            <button class="w-100 btn btn-primary btn-lg" type="submit">{{ __('i_order') }}</button>
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0">{{ __('order_summary') }}</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 pb-0">
                                {{ __('products') }} ({{ Cart::getTotalQuantity() }} {{ __('unit.unit_1') }}) :
                                <span>{{ currency(Cart::getSubTotal()) }}</span>
                            </li>
                            @foreach (Cart::getConditions() as $condition)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div><b>{{ __($condition->getType()) }}:</b> {{ $condition->getName() }}</div>
                                    <div>{{ $condition->getValue() != 0 ? currency($condition->getValue()) : '' }}</div>
                                </li>
                            @endforeach
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                <div>
                                    <strong>{{ __('total') }}</strong>
                                    <strong>
                                        <p class="mb-0">({{ __('including VAT') }})</p>
                                    </strong>
                                </div>
                                <span><strong>{{ currency(Cart::getTotal()) }}</strong></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
