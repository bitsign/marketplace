<nav id="sidebar" class="bg-dark">
    <div class="sidebar-header">
        <h3 class="text-center">Admin</h3>
    </div>

    <ul class="menu list-unstyled">

        <li class="{{ (request()->segment(2) == 'dashboard') ? 'active' : '' }}">
            <a href="{{ url('admin/dashboard') }}">
                <i class="bi bi-speedometer2"></i> <span>{{ __('admin.dashboard') }}</span>
            </a>
        </li>

        @php
            $content_urls = array('pages','banners','blocks','team','portfolios','services','faqs','feedbacks');
            $act = in_array(request()->segment(2), $content_urls);
        @endphp
        <li class="{{ $act===true ? 'active' : '' }}">
            <a href="#contents" data-bs-toggle="collapse" aria-expanded="{{ $act===true ? 'true' : 'false' }}" class="dropdown-toggle">
                <i class="bi bi-file-text"></i> <span>{{ __('admin.contents') }}</span>
            </a>
            <ul class="collapse list-unstyled {{ $act===true ? 'show' : '' }}" id="contents">
                <li class="{{ (request()->segment(2) == 'pages') ? 'active' : '' }}">
                    <a href="{{ url('admin/pages') }}">
                        <i class="bi bi-circle"></i> {{ __('admin.pages') }}
                    </a>
                </li>

                <li class="{{ (request()->segment(2) == 'banners') ? 'active' : '' }}">
                    <a href="{{ url('admin/banners') }}">
                        <i class="bi bi-circle"></i> <span>{{ __('admin.banners') }}</span>
                    </a>
                </li>
                <li class="{{ (request()->segment(2) == 'blocks') ? 'active' : '' }}">
                    <a href="{{ url('admin/blocks') }}">
                        <i class="bi bi-circle"></i> <span>{{ __('admin.blocks') }}</span>
                    </a>
                </li>
                {{-- <li class="{{ (request()->segment(2) == 'team') ? 'active' : '' }}">
                    <a href="{{ url('admin/team') }}">
                        <i class="bi bi-circle"></i> <span>{{ __('admin.staff') }}</span>
                    </a>
                </li>
                <li class="{{ (request()->segment(2) == 'portfolios') ? 'active' : '' }}">
                    <a href="{{ url('admin/portfolios') }}">
                        <i class="bi bi-circle"></i> <span>{{ __('admin.gallery') }}</span>
                    </a>
                </li>
                <li class="{{ (request()->segment(2) == 'faqs') ? 'active' : '' }}">
                    <a href="{{ url('admin/faqs') }}">
                        <i class="bi bi-circle"></i> <span>{{ __('admin.faq') }}</span>
                    </a>
                </li>
                <li class="{!-- (request()->segment(2) == 'feedbacks') ? 'active' : '' --}">
                    <a href="{!-- url('admin/feedbacks') --}">
                        <i class="bi bi-circle"></i> <span>{!-- __('admin.feedbacks') --}</span>
                    </a>
                </li>
                <li class="{{ (request()->segment(2) == 'services') ? 'active' : '' }}">
                    <a href="{{ url('admin/services') }}">
                        <i class="bi bi-circle"></i> <span>{{ __('admin.services') }}</span>
                    </a>
                </li> --}}
            </ul>
        </li>

        @php
            $content_urls_ = array('orders','statuses','deleted-orders','payment-methods','shipping-methods','deleted-orders');
            $act_ = in_array(request()->segment(2), $content_urls_);
        @endphp
        <li class="{{ $act_===true ? 'active' : '' }}">
            <a href="#orders" data-bs-toggle="collapse" aria-expanded="{{ $act_===true ? 'true' : 'false' }}" class="dropdown-toggle">
                <i class="bi bi-cart-check-fill"></i> {{ __('admin.shop') }}</i>
            </a>
            <ul class="collapse list-unstyled {{ $act_===true ? 'show' : '' }}" id="orders">
                <li class="{{ (request()->segment(2) == 'orders') ? 'active' : '' }}">
                    <a href="{{ url('admin/orders') }}">
                        <i class="bi bi-circle"></i>  <span>{{ __('admin.orders') }}</span>
                    </a>
                </li>

                <li class="{{ (request()->segment(2) == 'deleted-orders') ? 'active' : '' }}">
                    <a href="{{ url('admin/orders/deleted-orders') }}">
                        <i class="bi bi-circle"></i>  <span>{{ __('admin.deleted_orders') }}</span>
                    </a>
                </li>

                <li class="{{ (request()->segment(2) == 'statuses') ? 'active' : '' }}">
                    <a href="{{ url('admin/statuses') }}">
                        <i class="bi bi-circle"></i>  <span>{{ __('admin.statuses') }}</span>
                    </a>
                </li>
               
                <li class="{{ (request()->segment(2) == 'payment-methods') ? 'active' : '' }}">
                    <a href="{{ url('admin/payment-methods') }}">
                        <i class="bi bi-circle"></i>  <span>{{ __('admin.payment_methods') }}</span>
                    </a>
                </li>

                <li class="{{ (request()->segment(2) == 'shipping-methods') ? 'active' : '' }}">
                    <a href="{{ url('admin/shipping-methods') }}">
                        <i class="bi bi-circle"></i>  <span>{{ __('admin.shipping_methods') }}</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- <li class="{{ (request()->segment(2) == 'categories') ? 'active' : '' }}">
            <a href="{{ url('admin/categories') }}">
                <i class="bi bi-bar-chart-steps"></i> <span>{{ __('admin.categories') }}</span>
            </a>
        </li> --}}
        @php
            $content_urls_ = array('products','attributes','manufacturers');
            $act_ = in_array(request()->segment(2), $content_urls_);
        @endphp
        <li class="{{ $act_===true ? 'active' : '' }}">
            <a href="#products" data-bs-toggle="collapse" aria-expanded="{{ $act_===true ? 'true' : 'false' }}" class="dropdown-toggle">
                <i class="bi bi-dropbox"></i> {{ __('admin.products') }}</i>
            </a>
            <ul class="collapse list-unstyled {{ $act_===true ? 'show' : '' }}" id="products">
                <li class="{{ (request()->segment(2) == 'products') ? 'active' : '' }}">
                    <a href="{{ url('admin/products') }}">
                        <i class="bi bi-circle"></i> <span>{{ __('admin.edit_products') }}</span>
                    </a>
                </li>
                <li class="{{ (request()->segment(2) == 'attributes') ? 'active' : '' }}">
                    <a href="{{ url('admin/attributes') }}">
                        <i class="bi bi-circle"></i> <span>{{ __('admin.attributes') }}</span>
                    </a>
                </li>
                {{-- <li class="{{ (request()->segment(2) == 'manufacturers') ? 'active' : '' }}">
                    <a href="{{ url('admin/manufacturers') }}">
                        <i class="bi bi-circle"></i> <span>{{ __('admin.manufacturers') }}</span>
                    </a>
                </li> --}}
            </ul>
        </li>

        <li class="{{ (request()->segment(2) == 'packages') ? 'active' : '' }}">
            <a href="{{ url('admin/packages') }}">
                <i class="bi bi-boxes"></i> <span>{{ __('admin.packages') }}</span>
            </a>
        </li>

        <li class="{{ (request()->segment(2) == 'vendors-list') ? 'active' : '' }}">
            <a href="{{ url('admin/vendors') }}">
                <i class="bi bi-house-heart"></i> <span>{{ __('admin.designers') }}</span>
            </a>
        </li>

        {{-- <li class="{{ (request()->segment(2) == 'rewards') ? 'active' : '' }}">
            <a href="{{ url('admin/rewards') }}">
                <i class="bi bi-star"></i> <span>{{ __('admin.rewards') }}</span>
            </a>
        </li>

        <li class="{{ (request()->segment(2) == 'terms') ? 'active' : '' }}">
            <a href="{{ url('admin/terms') }}">
                <i class="bi bi-tags"></i> <span>{{ __('admin.tags_terms') }}</span>
            </a>
        </li> --}}

        @php
            $content_urls_ = array('statistic_products','statistic_orders');
            $act_ = in_array(request()->segment(3), $content_urls_);
        @endphp
        <!--li class="{{ $act_===true ? 'active' : '' }}">
            <a href="#statistics" data-bs-toggle="collapse" aria-expanded="{{ $act_===true ? 'true' : 'false' }}" class="dropdown-toggle">
                <i class="bi bi-bar-chart"></i> {{ __('admin.statistics') }}
            </a>
            <ul class="collapse list-unstyled {{ $act_===true ? 'show' : '' }}" id="statistics">
                <li class="{{ (request()->segment(2) == 'statistic_products') ? 'active' : '' }}">
                    <a href="{{ url('admin/statistics/statistic_products') }}">
                        <i class="bi bi-circle"></i> <span>{{ __('admin.product_statistics') }}</span>
                    </a>
                </li>
                <li class="{{ (request()->segment(2) == 'statistic_orders') ? 'active' : '' }}">
                    <a href="{{ url('admin/statistics/statistic_orders') }}">
                        <i class="bi bi-circle"></i> {{ __('admin.order_statistics') }}
                    </a>
                </li>
            </ul>
        </li-->

        <li class="{{ (request()->segment(2) == 'users-list') ? 'active' : '' }}">
            <a href="{{ url('admin/users') }}">
                <i class="bi bi-people-fill"></i> <span>{{ __('admin.users') }}</span>
            </a>
        </li>
        {{-- <li class="{{ (request()->segment(2) == 'posts') ? 'active' : '' }}">
            <a href="{{ url('admin/posts') }}">
                <i class="bi bi-newspaper"></i> <span>{{ __('admin.blog') }}</span>
            </a>
        </li>
        <li class="{{ (request()->segment(2) == 'warranty') ? 'active' : '' }}">
            <a href="{{ url('admin/warranty') }}">
                <i class="bi bi-arrow-repeat"></i> <span>{{ __('admin.warranty') }}</span>
            </a>
        </li>

        <li class="{{ (request()->segment(2) == 'texts') ? 'active' : '' }}">
            <a href="{{ url('admin/texts') }}">
                <i class="bi bi-file-text"></i> <span>{{ __('admin.edit_words') }}</span>
            </a>
        </li>
        <li class="{{ (request()->segment(2) == 'coupons') ? 'active' : '' }}">
            <a href="{{ url('admin/coupons') }}">
                <i class="bi bi-gift"></i> <span>{{ __('admin.coupons') }}</span>
            </a>
        </li> --}}

        @if(isset(session('AdminUser')['group_id']) && session('AdminUser')['group_id'] == 0)
        <li class="{{ (request()->segment(2) == 'administrators') ? 'active' : '' }}">
            <a href="{{ url('admin/administrators') }}">
                <i class="bi bi-person-lines-fill"></i> <span>{{ __('admin.administrators') }}</span>
            </a>
        </li>
        <li class="{{ (request()->segment(2) == 'settings') ? 'active' : '' }}">
            <a href="{{ url('admin/settings') }}">
                <i class="bi bi-gear"></i> <span>{{ __('admin.settings') }}</span>
            </a>
        </li>
        <li class="{{ (request()->segment(2) == 'currencies') ? 'active' : '' }}">
            <a href="{{ url('admin/currencies') }}">
                <i class="bi bi-currency-exchange"></i>  <span>{{ __('admin.currencies') }}</span>
            </a>
        </li>
        <li class="{{ (request()->segment(2) == 'email-texts') ? 'active' : '' }}">
            <a href="{{ url('admin/email-texts') }}">
                <i class="bi bi-envelope"></i> <span>{{ __('admin.system_emails') }}</span>
            </a>
        </li>
        @endif
    </ul>
</nav>
