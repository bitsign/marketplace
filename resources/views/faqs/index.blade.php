@extends('layout.page')
@section('content')
<section id="{{ $page->url }}" class="{{ $page->url }}">
    <div class="container">
        <div class="row py-3">

            @if(!empty($faqs[0]))
            <div class="accordion" id="accordionExample">
                @foreach($faqs as $key => $faq)
                @php $translation = json_decode($faq['transitions'],true); @endphp
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $key }}">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $key }}" aria-expanded="false" aria-controls="collapseThree">
                    {{ $translation['name'][app()->getLocale()] ?? $faq['name'] }}
                  </button>
                </h2>
                <div id="collapse{{ $key }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $key }}" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    {!! $translation['content'][app()->getLocale()] ?? $faq['content'] !!}
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            @endif
        </div>
    </div>
</section>
@endsection