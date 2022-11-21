@extends('layout.page')
@section('content')
<section id="{{ $page->url ?? '' }}" class="{{ $page->url ?? '' }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 py-3">
                {!! $page->content ?? '' !!}
            </div>
            <div class="row align-items-center">
                @foreach($manufacturers as $manufacturer)
                <div class="col-lg-2 mb-3">
                    <div class="item">
                        <a href="{{ url(app()->getLocale().'/'.__('routes.manufacturer').'/'.$manufacturer->url) }}" title="{{ $manufacturer->name }}">
                            <img src="{{ url('files/editor/manufacturers/'.$manufacturer->image) }}" class="card-img-top" alt="{{ $manufacturer->name }}">
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
