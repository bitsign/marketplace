@extends('layout.page')
@section('content')
<section id="{{ $manufacturer->url }}" class="{{ $manufacturer->url }}">
    <div class="container">
        <div class="row">
          <div class="col-lg-12 py-3">
            <div class="card mb-3 border-0">
                @if($manufacturer->image)
                <img src="{{ url('files/editor/manufacturers/'.$manufacturer->image) }}" class="card-img-top w-auto m-auto" alt="{{ $manufacturer->title }}" >
                @endif
                <div class="card-body text-center">
                    <h5 class="card-title text-center">
                        <a class="{{ request()->segment(2) == $manufacturer->url ? 'active' : '' }}" href="{{ app()->getLocale().'/'.__('routes.manufacturer').'/'.$manufacturer->url }}">
                            {{-- $manufacturer->name --}}
                        </a>
                    </h5>
                </div>
            </div>
         </div>
    </div>
    </div>
</section>
<section id="products" class="products py-4">
    <div class="container">
        <div class="row">
            @include('products.list',$products)
         </div>
         {{ $products->links() }}
    </div>
</section>
@endsection

