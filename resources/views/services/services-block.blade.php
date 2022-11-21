<section class="services">
    <div class="container-fluid">
        <div class="row justify-content-center">
            @foreach ($services as $service)
                @if($service->translation === NULL)
                    @continue
                @endif
                <div class="col-md-4">
                    <div class="card mb-3 border-0">
                        @if ($service->image)
                            <img src="{{ url('files/editor/' . $service->image) }}" class="card-img-top m-auto" alt="{{ $service->title }}">
                        @endif
                        <div class="card-body text-center">
                            <h5 class="card-title text-center">
                                <a class="{{ request()->segment(2) == $service->translation->url ? 'active' : '' }}"
                                    href="{{ app()->getLocale() . '/' . __('routes.service') . '/' . $service->translation->url }}">
                                    {{ !empty($service->translation->menu_title) ? $service->translation->menu_title : $service->translation->name }}
                                </a>
                            </h5>
                            <p class="card-text text-dark">{!! $service->translation->content !!}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>