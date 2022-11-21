<nav id="top" class="">
    <div class="container-fluid">
        <div class="nav float-start">
            <ul class="list-inline m-0">
                <li class="list-inline-item">
                    <a href="tel:{{ SHOP_PHONE }}">
                        <i class="bi bi-telephone"></i> 
                        <span class="d-none d-md-inline">{{ SHOP_PHONE }}</span>
                    </a>
                </li>
            </ul>
            {{-- <ul class="list-inline m-0">
                <li class="list-inline-item">
                    <div class="dropdown">
                        <a href="#" data-bs-toggle="dropdown" class="dropdown-toggle" aria-expanded="false">
                            <span class="d-none d-md-inline">{{ __('Currency') }}: </span>
                            @php $selectedCurrency = currency()->find(currency()->getUserCurrency());  @endphp
                            <strong>{{ $selectedCurrency->symbol }}</strong> 
                        </a>
                        <ul class="dropdown-menu" style="">
                            @foreach($currencies as $currency)
                            <li>
                                <a href="{{ url()->current() }}?currency={{ $currency['code'] }}" class="dropdown-item">
                                    {{ $currency['symbol'] }} - {{ $currency['name'] }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                <li class="list-inline-item">
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src='{{ asset('img/'.app()->getLocale().'.png') }}'>
                                {{ array_search(app()->getLocale(), config('app.available_locales')) }} <span class="caret">
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        @foreach (config('app.available_locales') as $language => $al)
                        <li>
                            <a class="dropdown-item" href="{{ getTranslation(app()->getLocale(),$al,request()->segment(3)) }}">
                                <img src='{{ asset('img/'. $al.'.png') }}'>
                                {{ $language }}
                            </a>
                        </li>
                        @endforeach
                        </ul>
                    </div>
                </li>
            </ul> --}}
        </div>
        <div class="nav float-end">
            <ul class="list-inline m-0">

                <li class="list-inline-item">
                    @if(Auth::guard('vendor')->check())
                        <a href="{{ route('vendor.profile') }}" title="{{ __('my_profile') }}" class="text-danger me-3">
                            <i class="bi bi-house-gear"></i>
                            <span class="d-none d-md-inline">{{ __('my_profile') }}</span>
                        </a>
                    @else
                        <a href="{{ route('vendor.login-register') }}" title="{{ __('sell_your_plans') }}" class="text-danger me-3">
                            <i class="bi bi-house-gear"></i>
                            {{ __('sell_your_plans') }}
                        </a>
                    @endif
                </li>

                {{-- <li class="list-inline-item">
                    <a href="" id="wishlist-total" title="Wish List (0)"><i class="bi bi-heart"></i> <span class="d-none d-md-inline">Wish List (0)</span></a>
                </li>

                <li class="list-inline-item">
                    <a href="" title="Shopping Cart" class="position-relative">
                        <i class="bi bi-cart"></i>
                        <span class="d-none d-md-inline">{{ __('cart') }}</span>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ Cart::getTotalQuantity() }}
                        </span>
                    </a>
                </li> --}}
            </ul>

            @php 
                $selectedCurrency = currency()->find(currency()->getUserCurrency()); 
                $key = array_search (app()->getLocale(), config('app.available_locales'));
                $lang_name = config('app.available_locales')[$key];
            @endphp
            <div class="topbar-text dropdown disable-autohide">
                <a class="topbar-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="me-1" src="{{ asset('img/'.app()->getLocale().'.png') }}" max-width="20" alt="{{ $lang_name }}">
                    {{ $key }} / {{ $selectedCurrency->symbol }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" style="">
                    <li class="dropdown-item">
                        <select class="form-select form-select-sm" onchange='window.location="{{ url()->current() }}?currency="+this.value;'>
                            @foreach($currencies as $currency)
                            <option value="{{ $currency['code'] }}" {{ $selectedCurrency->name == $currency['name'] ? 'selected' : '' }}>{{ $currency['symbol'] }} - {{ $currency['name'] }}</option>
                            @endforeach
                        </select>
                    </li>
                    @foreach (config('app.available_locales') as $language => $al)
                    <li>
                        <a class="dropdown-item pb-1" href="{{ getTranslation(app()->getLocale(),$al,request()->segment(3)) }}">
                            <img class="me-2" src='{{ asset('img/'. $al.'.png') }}' width="20" alt="{{ app()->getLocale() }}">
                            {{ $language }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        
    </div>
</nav>