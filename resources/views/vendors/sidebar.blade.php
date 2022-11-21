<div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <i class="bi bi-person-circle"></i>
        <span class="fs-4">{{ __('my_profile') }}</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('vendor.profile') }}" class="nav-link {{ request()->segment(3) == 'profile' ? 'active' : '' }}" aria-current="page">
                <i class="bi bi-house"></i>
                {{ __('settings') }}
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('vendor.sales') }}" class="nav-link {{ request()->segment(3) == 'sales' ? 'active' : '' }}" aria-current="page">
                <i class="bi bi-currency-dollar"></i>
                {{ __('sales') }}
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link" aria-current="page">
                <i class="bi bi-box-seam"></i>
                {{ __('products') }}
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('vendor.add-product') }}" class="nav-link {{ request()->segment(3) == 'add-product' ? 'active' : '' }}" aria-current="page">
                <i class="bi bi-cloud-arrow-up"></i>
                {{ __('add_product') }}
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('vendor.logout') }}" class="nav-link" aria-current="page">
                <i class="bi bi-box-arrow-in-left"></i>
                {{ __('logout') }}
            </a>
        </li>
        
    </ul>
</div>