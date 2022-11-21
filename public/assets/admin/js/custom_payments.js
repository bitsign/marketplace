$(document).ready(function() {
    
    $("#shipping_form, #payment_form").validate(
    {
        errorClass: 'alert-danger',
        errorElement: "code",
    });
    
    // Add new price interval
    $("button#add_payment_interval").on("click", function() {
        var last_row     = $("#payment_intervals_form tr:last");
        var clone         = last_row.clone();
        clone.find("input").each(function() {
            $(this).val("");
         });
        clone.insertAfter(last_row);
    });
    
    // Delete interval
    $("#payment_intervals_form").on("click", "span.del", function() {
        var nr = $("#payment_intervals_form tr").length;
        if(nr > 2)
            $(this).parents("tr").remove();
    });

    // Add new weight interval
    $("button#add_weight_interval").on("click", function() {
        var last_row     = $("#weight_intervals_form tr:last");
        var clone         = last_row.clone();
        clone.find("input").each(function() {
            $(this).val("");
         });
        clone.insertAfter(last_row);
    });
    
    // Delete interval
    $("#weight_intervals_form").on("click", "span.del", function() {
        var nr = $("#weight_intervals_form tr").length;
        if(nr > 2)
            $(this).parents("tr").remove();
    });

    $('.sortable').sortable({
        nested: true,
        axis: "y",
        items:'tr',
        handle:'.handle1',
        forceHelperSize: true,
        forcePlaceholderSize: true,
        update: function (event, ui)
        {
            var data = $(this).sortable('serialize');
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: data,
                type: 'POST',
                url: base_url+'admin/payment-methods/sort-payments',
                success: function(data){
                     //alert(data);
                     location.reload();
                }
            });
        }
    });

    $('.sortable_tr').sortable({
        nested: true,
        axis: "y",
        items:'tr',
        handle:'.handle1',
        forceHelperSize: true,
        forcePlaceholderSize: true,
        update: function (event, ui)
        {
            var data = $(this).sortable('serialize');
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: data,
                type: 'POST',
                url: base_url+'admin/shipping-methods/sort-shippings',
                success: function(data){
                     //alert(data);
                     location.reload();
                }
            });
        }
    });

});