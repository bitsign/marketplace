@extends('layout.page')
@section('content')
<section id="products" class="products">
    <div class="container">
        <div class="row">
            
        </div>

        <div class="row">
            <div class="col-md-3">
                @include('categories.sidebar')
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="product_count">
                        <h1 class="my-3">{{ $category['name'] }}</h1>
                        <?php //if($total_rows > 0) __('there_are_x_products_in_the_category',false,$total_rows);?>
                    </div>
                </div>
                <div class="row">
                    @include('products.list',$products)
                </div>
                <div class="row">
                    <div class="col text-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
