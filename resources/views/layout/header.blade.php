<header>
    @include('layout.header-top')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 d-flex align-items-center">
                <a href="{{ url('/'.app()->getLocale()) }}" class="navbar-brand logo py-2"><img src="{{ asset('img/logo.png') }}" alt="" class="img-fluid"></a>

                <div id="search-block" class="search_block m-auto">
                    <form id="search_form" action="{{ url(app()->getLocale().'/'.__('routes.products')) }}">
                        <div class="input-group">
                          <input type="text" class="form-control rounded-0" placeholder="" name="search_products" id="search-input" required>
                          <button class="btn btn-outline-secondary rounded-0" type="submit" id="button-addon2">{{ __('search') }}</button>
                        </div>
                    </form>
                    <div id="search-result"></div>
                </div>

                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <a class="position-relative" data-bs-toggle="dropdown" class="dropdown-toggle" aria-expanded="false">
                            <i class="bi bi-cart"></i> {{ __('cart') }}
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ Cart::getTotalQuantity() }}
                            </span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li>
                              <div class="shopping-cart">
                                <div class="shopping-cart-header">
                                  <i class="bi bi-cart"></i>
                                  <div class="shopping-cart-total">
                                    <span class="text-primary">{{ __('sum') }}:</span>
                                    <span class="text-primary">{{ number_format(Cart::getTotal()) }} Ft</span>
                                  </div>
                                </div> <!--end shopping-cart-header -->

                                <ul class="shopping-cart-items">
                                    @if(Cart::isEmpty())
                                        <div class="alert alert-info">{{ __('empty_cart') }}</div>
                                        @else
                                        @foreach (Cart::getContent() as $item)
                                            <li class="clearfix">
                                                <img src="{{ url('files/products/small/'.$item->attributes->image) }}" alt="item1" width="70"/>
                                                <span class="item-name">{{ $item->name }}</span>
                                                <span class="item-price">{{ number_format($item->price) }} Ft</span>
                                                <span class="item-quantity">x {{ $item->quantity }}</span>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                                @if(Cart::isEmpty() === false)
                                <a href="{{ url(app()->getLocale().'/'.'cart') }}" class="btn btn-primary btn-sm">{{ __('go_to_checkout') }}</a>
                                @endif
                              </div>
                            </li>
                        </ul>
                    </div>
                    <div class="dropdown ms-3">
                        @guest
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person" aria-hidden="true"></i>
                            {{ __('my_profile') }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item" href="{{ url(app()->getLocale().'/'.__('routes.login')) }}">{{ __('login') }}</a></li>
                                <li><a class="dropdown-item" href="{{ url(app()->getLocale().'/'.__('routes.register')) }}">{{ __('register') }}</a></li>
                            </ul>
                        @else
                            <a class="dropdown-toggle" href="#" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person" aria-hidden="true"></i>
                                {{ Auth::user()->name ?? "" }} <span class="caret">
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item" href="{{ url(app()->getLocale().'/'.__('routes.profile')) }}">{{ __('my_profile') }}</a></li>
                                <li><a class="dropdown-item" href="{{ url(app()->getLocale().'/'.__('routes.logout')) }}">{{ __('logout') }}</a></li>

                            </ul>
                        @endguest
                    </div>


                    <div class="navbar-right">
                        
                    </div>

                     <!--end shopping-cart -->

                </div>
            </div>
        </div>
    </div>
</header>

@include('layout.menu.categories_menu',['categories' => $categories])
