@extends('layout.page')
@section('content')
<section id="post" class="post">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 my-3">
                @if (!empty($post))
                    <h1>{{ $post->name }}</h1>
                    <small><i class="bi bi-clock"></i> {{ $post->created_at }}</small>
                    <img src="{{ url('files/editor/'.$post->image) }}" class="card-img-top" alt="{{ $post->title }}">
                    {!! $post->content !!}
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                @if(count($terms) > 0)
                <h3>{{ __('tags') }}</h3>
                @foreach($terms as $term)
                    <li>
                        <a href="{{ url(app()->getLocale().'/'.__('routes.blog').'?term='.$term['term_key']) }}">
                            {{ $term['name'] }}
                        </a>
                    </li>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
@endsection