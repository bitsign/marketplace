@extends('layout.page')
@section('content')
<section id="{{ $page->url }}" class="{{ $page->url }}">
    <div class="container py-4">
        @include('packages.packages',$packages)
    </div>
    </div>
</section>
@endsection