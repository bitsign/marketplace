@extends('layout.page')
@section('content')
<section id="portfolio" class="portfolio">
    <div class="container">
        <div class="section-title my-2">
            <h2>{{ $portfolio->name }}</h2>
            {!! $portfolio->description !!}
        </div>

        <div class="row">
            <div class="col-lg-12 d-flex justify-content-center">
                <ul id="portfolio-flters">
                    <li data-filter="*">{{ __('all') }}</li>
                    @foreach($tags as $key => $tag)
                    <li data-filter=".{{ $key }}">{{ $tag }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="row portfolio-container" id="lightgallery">
            @foreach($images as $img)
            <div class="col-lg-4 col-md-6 portfolio-item {{ str_replace(',',' ',$img->tags) }}">
                <a href="{{ url('files/portfolio/original/'.$img->image) }}" title="{{ $img->name }}" data-lightbox="gallery-item" class="portfolio-lightbox">
                    <img src="{{ url('files/portfolio/thumbs/'.$img->image) }}" class="card-img-top" alt="{{ $img->name }}">
                </a>
                <div class="portfolio-info">
                    <h4>{{ $img->name }}</h4>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
@endsection