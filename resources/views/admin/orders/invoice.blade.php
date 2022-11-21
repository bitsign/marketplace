<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Invoice Print</title>
  <link href="http://myshop.test/assets/admin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <style type="text/css">
        @page {
            margin: 5mm;
            size: A4 portrait;
        }
        .container.invoice{width: 200mm;  height: 287mm; margin: 25px auto;}
        #save_invoice{position: fixed; top: 5%; right: 5%;}
        #print_invoice{position: fixed; top: 10%; right: 5%;}
        
        @media print
        {
            .no-print{display: none !important;}
        }

    </style>
</head>
<body>
<div class="card border-0">
    <div class="card-body">
        <div class="container invoice" id="print">
            <div class="row d-flex align-items-baseline">
                <div class="col-xl-9">
                    <p style="color: #7e8d9f;font-size: 20px;"><strong>{{ SHOP_NAME }} {{ __('admin.order') }} - ID: #{{ $order['id'] }}</strong></p>
                </div>
                <hr>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-8">
                        <ul class="list-unstyled">
                            <li class="text-primary">
                                {{ $order->user->billing_name ?? $order->user->name }}
                            </li>
                            <li class="text-muted">{{ $order->user->zip }}, {{ $order->user->city }}, {{ $order->user->address }}
                            </li>
                            <li class="text-muted">{{ $order->user->state }}, {{ $order->user->country }}</li>
                            <li class="text-muted"><i class="bi bi-phone text-muted"></i> {{ $order->user->phone }}</li>
                        </ul>
                    </div>
                    <div class="col-xl-4">
                        <ul class="list-unstyled">
                            <li class="text-muted">
                                <span class="fw-bold">{{ __('date') }}: </span>{{ $order->created_at }}
                            </li>
                            <li class="text-muted">
                                <span class="me-1 fw-bold">{{ __('admin.status') }}:</span>
                                @php $st_name = json_decode($status['translations'],true) @endphp
                                <span class="badge" style="background-color: {{ $status['color']; }}">
                                    {{ $st_name[$order->lang] }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="row my-2 mx-1 justify-content-center">
                    <table class="table table-bordered">
                        <thead style="background-color:#84B0CA;" class="text-white">
                            <tr>
                                <th scope="col">{{ __('product') }}</th>
                                <th scope="col">{{ __('quantity') }}</th>
                                <th scope="col">{{ __('price') }}</th>
                                <th scope="col">{{ __('subtotal') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->products as $product)
                            <tr>
                                <td>
                                    {{ $product['version_name'] }} <br>
                                    @if(!empty($product['options']))
                                        <small>
                                        @php $options = json_decode($product['options'],true) @endphp
                                        @foreach($options as $key => $value)
                                            {{ $key }}: {{ $value }}<br>
                                        @endforeach
                                        </small>
                                    @endif
                                </td>
                                <td>{{ $product['qty'] }}</td>
                                <td>{{ currency($product['price']) }}</td>
                                <td>{{ currency($product['price']*$product['qty']) }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{ __('shipping_cost') }}:</td>
                                <td>{{ $order->shipping_cost != 0 ? currency($order->shipping_cost) : __('free') }}</td>
                            </tr>
                        </tbody>

                    </table>
                </div>
                <div class="row">
                    <div class="col">
                        <ul class="list-unstyled">
                            <li class="text-muted ms-3">
                                <span class="text-black me-4">{{ __('net_price') }}</span>
                                {{ currency(round($order->total/(1+VAT/100))) }}
                            </li>
                            <li class="text-muted ms-3 mt-2">
                                <span class="text-black me-4">{{ __('vat') }} ({{ VAT }}%)</span>
                                {{ currency(round($order->total-$order->total/(1+VAT/100))) }}
                            </li>
                            <li class="text-muted ms-3 mt-2">
                                <span class="text-black me-4">{{ __('total') }}</span>
                                <span style="font-size: 25px;">{{ currency($order->total) }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" 
            id="save_invoice" 
            class="btn btn-success no-print" 
            data-id="{{ $order->id }}"
            data-name="{{ $order->user->name }}"
            data-lang="{{ $order->user->lang }}"
            > 
            <i class="bi bi-download"></i> {{ __('download') }}
        </button>

        <button type="button" 
            id="print_invoice" 
            class="btn btn-primary no-print"
            onclick="window.print()" 
            > 
            <i class="bi bi-download"></i> {{ __('print') }}
        </button>
    </div>
</div>


<script src="{{ url('assets/admin/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ url('assets/admin/js/jquery-migrate-3.3.2.js') }}"></script>
<script src="{{ url('assets/admin/js/html2canvas.min.js')  }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<script>
    $("#save_invoice").on('click',function()
    {
        var order_id       = $(this).data('id');
        let date = new Date();
        let filename = 'order_'+order_id+'_'+date.getFullYear()+'-'+date.getMonth()+'-'+date.getDate();
        const captureElement = document.querySelector('#print');
        html2canvas(captureElement,{scale:2})
        .then(canvas => {
            canvas.style.display = 'none';
            document.body.appendChild(canvas);
            return canvas;
        })
        .then(canvas => {
            const image = canvas.toDataURL('image/jpeg')
            var doc = new jsPDF('p', 'mm','a4');
            doc.addImage(image, 'JPG', 5, 5, 200, 287);

            //var blob = doc.output('blob');

            //var formData = new FormData();
            //formData.append('pdf', blob);

            doc.save(filename);

            /*var name         = $(this).data('name');
            var lang           = $(this).data('lang');
            var id             = $(this).data('id');
            var order_id       = $(this).data('order_id');

            $.ajax(base_url+'admin/booking/save_invoice/'+order_id,
            {
                method      : 'POST',
                data        : formData,
                processData : false,
                contentType : false,
                success     : function(msg){

                    $.post( base_url+'admin/booking/save_voucher_db', { 'name':name,'lang':lang,'id':id,'order_id':order_id } );
                    alert(msg);
                    location.reload();
                },
                error       : function(msg){alert(msg)}
            });*/
              canvas.remove()
        });
    });

    function capture(order_id)
    {
        let date = new Date();
        let filename = 'order_'+order_id+'_'+date.getFullYear()+'-'+date.getMonth()+'-'+date.getDate();
        const captureElement = document.querySelector('#print')
        html2canvas(captureElement)
        .then(canvas => {
          canvas.style.display = 'none';
          document.body.appendChild(canvas);
          return canvas;
        })
        .then(canvas => {
            const image = canvas.toDataURL('image/jpeg')
            var doc = new jsPDF('p', 'mm','a4');
            doc.addImage(image, 'JPG', 20, 20);
            doc.save(filename);
            canvas.remove()
        });
    }
</script>
</body>
</html>