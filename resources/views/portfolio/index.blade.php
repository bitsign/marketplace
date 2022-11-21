@extends('layout.page')
@section('content')
<section id="{{ $page->url }}" class="{{ $page->url }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 py-3">
                {!! $page->content !!}
            </div>
            <div class="row">
                @foreach($portfolio as $portf)
                <div class="col-lg-4 mb-3">
                    <div class="card">
                        <a href="{{ url(app()->getLocale().'/'.__('routes.portfolio').'/'.$portf->translation->url) }}" title="{{ $portf->translation->name }}">
                            <img src="{{ url('files/editor/'.$portf->image) }}" class="card-img-top" alt="{{ $portf->translation->name }}">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $portf->translation->name }}</h5>
                            {!! Str::words($portf->translation->description, 10, '...') !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
