<form action="{{ route('product-images.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row mb-3">
        <div class="col-lg-12">
            <input id="file-1" type="file" multiple name="filename[]">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-offset-2 col-lg-8">
            <input type="hidden" name="product_id" value="{{ $product->id ?? '' }}">
            <button type="submit" class="btn btn-primary btn-lg">{{ __('admin.upload') }}</button>
        </div>
    </div>
</form>

@if(!empty($product->images))
<div class="row mb-3">
    <h4>{{ __('admin.uploaded_images') }}:</h4>
    @foreach ($product->images as $img)
    <div class="col-lg-2">
        <div class="thumbnail">
        <div class="alert alert-success hidden" id="alerts_{{ $img['id'] }}" role="alert"></div>
        <div class="alert alert-danger hidden" id="alertd_{{ $img['id'] }}" role="alert"></div>
        <img class="m-auto" style="max-height:150px" src="{{ url('files/products/small/'.$img['filename']) }}">
        <div class="caption py-2">
            <label for="default_{{ $img['id'] }}" class="">
                <input type="radio" name="default" class="set_default" id="default_{{ $img['id'] }}" {{ $img['default'] == 1 ? " checked " : "";  }} value="1">
                {{ __('default') }}
            </label>
            <a class="btn btn-danger btn-xs float-end delete_image" id="delete_{{ $img['id'] }}" href="#">
                <i class="icon-trash icon-white"></i> {{ __('delete') }}
            </a>
            <hr>
            <div class="row">
                <div class="col-lg-3">{{ __('admin.title') }}</div>
                <div class="col-lg-9"><input type="text" id="title_{{ $img['id'] }}" value="{{ $img['title'] }}" class="form-control form-control-sm"></div>

                <div class="col-lg-3">{{ __('admin.alt') }}</div>
                <div class="col-lg-9"><input type="text" id="alt_{{ $img['id'] }}" value="{{ $img['alt'] }}" class="form-control form-control-sm"></div>
            </div>
            <hr>
            <input type="button" value="{{ __('admin.save') }}" id="save_{{ $img['product_id'] }}_{{ $img['id'] }}" class="save_image col-md-12 btn btn-primary">
            <div class="clearfix"></div>
        </div>
        </div>
    </div>
    @endforeach
</div>
@endif

<div class="clearfix"></div>
<div class="callout callout-info">
    @if(config('app.admin_locale') == 'hu')
    <p>
    Az eredeti term??kk??pek k??nyvt??ra: /public/files/products/original/ (maxim??lis fot??m??ret magass??g 1200px, sz??less??g 1200px). A k??nyvt??r tartalma nem ??rhet?? el internetr??l.<br/>
    Innen a rendszer automatikusan 3 m??ret?? fot??t k??sz??t felt??lt??skor 3 k??l??n k??nyvt??rba a <a class="link-primary" href="{{ url('admin/products/settings') }}">be??ll??t??sok</a> alatt megadott m??retekben: </br>
    1 - listak??p (/files/products/small/)<br />
    2 - term??k oldali k??p (/files/products/medium/)<br />
    3 - nagy term??k k??p (/files/products/original/large/)<br />
    CSV-b??l val?? term??kfelt??lt??s eset??n a term??kk??peket FTP-n kereszt??l a <i>/files/products/original/</i> k??nyvt??rba kell felm??solni, innen a rendszer automatikusan ??tm??retezi.
    </p>
    @else
    <p>
    The library of original product images is /public/files/products/original/ (max. height 1200px, max. width 1200px). The contents of the library are not accessible from the Internet.<br/>
    From here, the system automatically creates 3 photo sizes when uploading to 3 separate directories in the sizes specified in the <a class="link-primary" href="{{ url('admin/products/settings') }}">settings</a>: </br>
    1 - list image (/files/products/small/)<br>
    2 - product page image (/files/products/medium/)<br>
    3 - large product image (/files/products/original/large/)<br>
    When uploading products from CSV, the product images must be copied to the directory via FTP, from where the system will automatically resize them.
    </p>
    @endif
</div>
