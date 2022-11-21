@extends('layout.page')
@section('content')
    <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-12">
                    {!! $page->content !!}
                </div>
            </div>
            <div class="row">
                @if (!empty($posts))
                    <div class="col-lg-8">
                        <div class="row">
                            @foreach ($posts as $post)
                                @if ($post->active_from != null || $post->active_to != null)
                                    @if ($post->active_from >= date('Y-m-d') || $post->active_to < date('Y-m-d'))
                                        @continue
                                    @endif
                                @endif
                                <div class="col-md-6 my-3">
                                    <div class="card">
                                        <img src="{{ url('files/editor/' . $post->image) }}" class="card-img-top"
                                            alt="{{ $post->name }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $post->name }}</h5>
                                            <small><i class="bi bi-clock"></i> {{ $post->created_at }}</small>
                                            <div class="card-text">{!! $post->intro !!}</div>
                                            <a href="{{ url(app()->getLocale() . '/' . __('routes.post') . '/' . $post->url) }}"
                                                class="btn btn-primary">{{ __('details') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="sidebar pt-3">
                            <div class="sidebar-item search-form mb-3">
                                <h3 class="sidebar-title">{{ __('search') }}</h3>
                                <form action="{{ url()->current() }}" class="mt-3" method="get">
                                    <div class="input-group">
                                      <input type="text" class="form-control rounded-0" name="search" value="{{ request('search') ?? '' }}">
                                      <button type="submit" class="btn btn-outline-secondary rounded-0"> <i class="bi bi-search"></i></button>
                                    </div>
                                </form>
                            </div>

                            <div class="sidebar-item archives">
                                <h3 class="sidebar-title mb-3">{{ __('archive') }}</h3>
                                <ul class="mt-3">
                                    @foreach($archives as $stats)
                                    <li>
                                        <a href="{{ url(app()->getLocale().'/'.__('routes.blog').'?year='.$stats['year'].'&month='.$stats['month']) }}">
                                            {{ $stats['year'] }} {{ $stats['monthname'] }} ({{ $stats['published'] }})
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="sidebar-item tags">
                                <h3 class="sidebar-title">{{ __('tags') }}</h3>
                                <ul class="mt-3">
                                    @foreach($terms as $term)
                                    <li>
                                        <a href="{{ url(app()->getLocale().'/'.__('routes.blog').'?term='.$term['term_key']) }}">
                                            {{ $term['name'] }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col text-center">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
