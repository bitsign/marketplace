@extends('layout.page')
@section('content')
<section id="{{ $service->url }}" class="{{ $service->url }}">
<div class="container col-xxl-8 px-4 py-5">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
        <div class="col-10 col-sm-8 col-lg-6">
            @if($service->image)
            <img src="{{ url('files/editor/'.$service->image) }}" class="d-block mx-lg-auto img-fluid" alt="{{ $service->title }}" width="700" height="500" loading="lazy">
            @endif
        </div>
        <div class="col-lg-6">
            <h1 class="display-5 fw-bold lh-1 mb-3">{{ !empty($service->menu_title) ? $service->menu_title : $service->name }}</h1>
            <p class="lead">{!! $service->content !!}</p>
            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <!--button type="button" class="btn btn-primary btn-lg px-4 me-md-2">Primary</button>
                <button type="button" class="btn btn-outline-secondary btn-lg px-4">Default</button -->
            </div>
        </div>
    </div>
</div>
</section>
@endsection

