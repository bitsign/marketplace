@if (Request::segment(2) != '')
<section id="breadcrumbs" class="breadcrumbs">
    <div class="container">
        <ol>
            <li><a href="{{ URL::to('/'.app()->getLocale())}}">{{ __('front_page') }}</a></li>
            @if (!empty($breadcrumbs))
                @foreach ($breadcrumbs as $breadcrumb)
                    @if (!empty($breadcrumb['url']) && !$loop->last)
                        <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ Str::words($breadcrumb['title'], 3, '...') }}</a></li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">{{ Str::words($breadcrumb['title'], 3, '...') }}</li>
                    @endif

                @endforeach
            @else
                <li class="breadcrumb-item active" aria-current="page">{{ $page->name ?? "" }}</li>
            @endif
        </ol>
    </div>
</section>
@endif
