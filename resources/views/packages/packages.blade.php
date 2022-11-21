<div class="row row-cols-1 row-cols-md-4 mb-3 text-center">
    @foreach ($packages as $package)
    <div class="col">
        <div class="card mb-4 rounded-3 shadow-sm {{ $loop->index == 1 ? 'border-success' : '' }}">
            <div class="card-header py-3">
                <h4 class="my-0 fw-normal">{{ $package->name }}</h4>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title">
                    @if($package->price != 0)
                    $ {{ $package->price }}/{{ __('month') }}
                    @else
                    {{ __('free') }}
                    @endif
                </h1>
                <div class="list-unstyled mt-3 mb-4" style="min-height: 200px;">
                    
                    <p class="text-muted">{{ $package->product_nr == 0 ? __('unlimited') : $package->product_nr }} {{ __('plan') }}</p>
                    {!! $package->description !!}
                </div>
                
                @isset($subscription->stripe_price)
                    @if($subscription->stripe_price == $package->stripe_plan)
                    <button type="button" class="btn btn-success">Előfizetett csomag</button>
                    @endif
                @else
                <a href="{{ url(app()->getLocale().'/'.__('routes.offer').'/'.$package->url) }}" class="w-100 btn btn-lg btn-outline-primary">
                    {{ __('i_order') }}
                </a>
                @endisset
            </div>
        </div>
    </div>
    @endforeach
</div>