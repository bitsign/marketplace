@extends('layout.page')
@section('content')

    @if (!empty($banners))
        <div id="hero" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach ($banners as $b)
                @php $translations = json_decode($b['translations'],true) @endphp
                    <button type="button" data-bs-target="#hero" data-bs-slide-to="{{ $loop->index }}"
                        class="{{ $loop->index == 0 ? 'active' : '' }}" aria-current="true"
                        aria-label="{{ $translations['title'][app()->getLocale()] ?? '' }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach ($banners as $b)
                @php $translations = json_decode($b['translations'],true) @endphp
                    <div class="carousel-item {{ $loop->index == 0 ? 'active' : '' }}" data-bs-interval="5000">
                        <img src="{{ url('files/editor/' . $b->image) }}"
                            class="img-fluid d-block animate__animated animate__zoomIn" alt="{{ $translations['title'][app()->getLocale()] ?? '' }}" alt="{{ $translations['alt'][app()->getLocale()] ?? $translations['title'][app()->getLocale()] ?? '' }}">
                        <div class="carousel-caption d-none d-md-block">
                            <h2 class="animate__animated animate__fadeInDown">{{ $translations['title'][app()->getLocale()] ?? '' }}</h5>
                                <div class="animate__animated animate__fadeInUp desc">{!! $translations['description'][app()->getLocale()] ?? '' !!}</div>
                                @if (!empty($translations['url'][app()->getLocale()]))
                                    <a href="{{ url(app()->getLocale() . '/' . $translations['url'][app()->getLocale()]) }}"
                                        class="btn btn-primary animate__animated animate__fadeInUp">{{ __('details') }}</a>
                                @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#hero" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#hero" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden"></span>
            </button>
        </div>
    @endif

    @if(!empty($main_categories))
    <section class="featured_categories py-5">
        <div class="container-fluid">
            <h2 class="text-center my-4">{{ __('categories') }}</h2>
            <div class="row">
                @foreach ($main_categories as $category)
                    @if ($category->translation == null)
                        @continue
                    @endif
                    @php
                        $name = !empty($category->translation->name) ? $category->translation->name : $category->name;
                        $url = $category->translation->url ?? '';
                        //$prefix = count($category->children) ? app()->getLocale().'/'.__('routes.categories') : app()->getLocale().'/'.__('routes.products');
                        $prefix = app()->getLocale() . '/' . __('routes.products');
                    @endphp
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <a href="{{ url($prefix . '/' . $url) }}" title="{{ $name }}">
                                <img src="{{ url('files/editor/' . $category->image) }}" class="card-img-top"
                                    alt="{{ $name }}">
                            </a>
                            <div class="card-body text-center">
                                <h5 class="card-title text-center"><a href="{{ url($prefix . '/' . $url) }}"
                                        class="btn btn-primary">{{ $name }}</a></h5>
                                <p class="card-text">{{ $category->short_description ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if(count($packages) > 0)
    <section class="packages py-5">
    <div class="container">
        <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
            <h1 class="display-4 fw-normal">{{ __('membership_packages') }}</h1>
            <p class="fs-5 text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        @include('packages.packages',$packages)
    </div>
    </section>
    @endif

    @if (!empty($featured_products))
        <section class="featured_products bg-primary py-5 text-dark bg-opacity-10">
            <div class="container-fluid">
                <h2 class="text-center my-4">{{ __('Featured house plans') }}</h2>
                <div class="row">
                    @include('products.list',['products'=>$featured_products,'col'=>3])
                </div>
            </div>
        </section>
    @endif

    @if (!empty($blocks))
    <section class="blocks">
        <div class="container-fluid">
            <div class="row justify-content-center">
                @foreach ($blocks as $block)
                    @php $b_trans = json_decode($block['translations'],true) @endphp
                    <div class="col-md-4">
                        <div class="card mb-3 border-0">
                            @if ($block->image)
                                <img src="{{ url('files/editor/' . $block->image) }}" class="card-img-top w-auto m-auto"
                                    alt="{{ $b_trans['title'][app()->getLocale()] ?? '' }}">
                            @endif
                            <div class="card-body text-center">
                                <h5 class="card-title text-center"> {{ $b_trans['title'][app()->getLocale()] ?? '' }}</h5>
                                <p class="card-text">{{ $b_trans['content'][app()->getLocale()] ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if (!empty($services))
        @include('services.services-block',$services)
    @endif

    @if (!empty($team))
        <section class="blocks py-5 bg-primary bg-opacity-10">
            <div class="container-fluid">
                <div class="row">
                    @foreach ($team as $member)
                    @php $translation = json_decode($member['translations'],true) @endphp
                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <img src="{{ url('files/editor/' . $member->image) }}" class="rounded-circle"
                                        width="200" height="200">
                                    <h5 class="card-title mt-2 mb-1">{{ $member->name }}</h5>
                                    <span class="fs-2 mb-3 font-weight-bold">{{ $translation['occupation'][app()->getLocale()] ?? $member->occupation  }}</span>
                                    <p class="mb-3 mt-3">{!! $translation['intro'][app()->getLocale()] ?? $member->intro !!}</p>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a href="{{ $member->contact }}" target="_blank"><i
                                                    class="bi bi-facebook"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if (!empty($manufacturers))
        <section class="manufacturers py-5">
            <div class="container-fluid">
                <div class="row justify-content-center align-items-center">
                    @foreach ($manufacturers as $manufacturer)
                        <div class="col-lg-2">
                            <a href="{{ app()->getLocale() . '/' . __('routes.manufacturer') . '/' . $manufacturer->url }}"
                                target="_blank">
                                <img src="{{ url('files/editor/manufacturers/' . $manufacturer->image) }}" class="rounded"
                                    width="100">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
