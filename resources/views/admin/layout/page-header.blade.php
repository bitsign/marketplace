<!-- Content Header (Page header) -->
<section class="content-header">
    <h2>
        <small>{{ $page_title ?? '' }}</small>
    </h2>
</section>
<section class="content-header mb-2">
    @if(!empty($tabs))
        @foreach ($tabs as $tab)
            @foreach ($tab as $key => $value)
            <a href="{{ strpos($key,'http:') === false && strpos($key,'https:') === false ? URL::to($key) : $key }}" class="btn btn-primary mb-2">
                {!! $value !!}
            </a>
            @endforeach
        @endforeach
    @endif
</section>
