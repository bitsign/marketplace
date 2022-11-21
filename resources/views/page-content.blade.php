@extends('layout.page')
@section('content')
<section id="{{ $page->url }}" class="{{ $page->url }}">
    <div class="container">
        <div class="row">
          <div class="col-lg-12 py-3">
            {!! $page->content !!}
         </div>
    </div>
    </div>
</section>
@endsection
