$(document).ready(function() {

    $("#datepicker_from").datepicker({
        timePicker: true, 
        timePickerIncrement: 30,
        changeMonth: true, 
        changeYear: true,
        format: "yyyy-mm-dd",
        weekStart: 1,
        language: '{{ app()->getLocale() }}',
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: true
    });
    $("#datepicker_to").datepicker({
        timePicker: true, 
        timePickerIncrement: 30,
        changeMonth: true, 
        changeYear: true,
        format: "yyyy-mm-dd",
        weekStart: 1,
        language: '{{ app()->getLocale() }}',
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: true
    });

    if(jQuery().colorpicker)
    {
        $('.color').colorpicker();

        $('.color').on('colorpickerChange', function(event) {
            $('.colorpicker input').css('backround-color', event.color.toString()+'!important');
        });
    }

    $(".change_item_qty").click(function(e){
        e.preventDefault();
        var url = $(this).data('href');
        var order_product_id = $(this).data('order_product_id');
        var value = $('#qty_'+order_product_id).val();
        $.ajax({
            data: {},
            type: 'POST',
            url: url+'/'+value,
            beforeSend : function() {
                $.blockUI({
                    message        : 'Mentés folyamatban...',
                    baseZ         : 99999,
                    theme         : true,
                    fadeOut     : 10,
                    fadeIn         : 100,
                    showOverlay : true
                });
            },
            complete : function() {
                //$.unblockUI();
            },
            success: function(data){
                 if(data > 0)
                     var message = 'Sikeres mentés';
                 else
                     var message = 'Nincs változás';
                 $.blockUI({ 
                    message: message, 
                    baseZ: 99999,
                    theme : true,
                    fadeIn: 700, 
                    fadeOut: 700, 
                    timeout: 1000, 
                    showOverlay: true, 
                    centerY: true, 
                    css: { 
                        width: '350px', 
                        top: '10px', 
                        left: '', 
                        right: '10px', 
                        border: 'none', 
                        padding: '5px', 
                        backgroundColor: '#000', 
                        '-webkit-border-radius': '10px', 
                        '-moz-border-radius': '10px', 
                        opacity: .6, 
                        color: '#fff' 
                    },
                    onUnblock: function(){location.reload();} 
                }); 
            }
        });
    });

    $(".change_item_price").click(function(e){
        e.preventDefault();
        var url = $(this).data('href');
        var order_product_id = $(this).data('order_product_id');
        var value = $('#price_'+order_product_id).val();
        $.ajax({
            data: {},
            type: 'POST',
            url: url+'/'+value,
            beforeSend : function() {
                $.blockUI({
                    message        : 'Mentés folyamatban...',
                    baseZ         : 99999,
                    theme         : true,
                    fadeOut     : 10,
                    fadeIn         : 100,
                    showOverlay : true
                });
            },
            complete : function() {
                //$.unblockUI();
            },
            success: function(data){
                 if(data > 0)
                     var message = 'Sikeres mentés';
                 else
                     var message = 'Nincs változás';
                 $.blockUI({ 
                    message: message, 
                    baseZ: 99999,
                    theme : true,
                    fadeIn: 700, 
                    fadeOut: 700, 
                    timeout: 1000, 
                    showOverlay: true, 
                    centerY: true, 
                    css: { 
                        width: '350px', 
                        top: '10px', 
                        left: '', 
                        right: '10px', 
                        border: 'none', 
                        padding: '5px', 
                        backgroundColor: '#000', 
                        '-webkit-border-radius': '10px', 
                        '-moz-border-radius': '10px', 
                        opacity: .6, 
                        color: '#fff' 
                    },
                    onUnblock: function(){location.reload();} 
                }); 
            }
        });
    });

    $("#change_shipping_cost").click(function(e){
        e.preventDefault();
        var url = $(this).data('href');
        var value = $('#shipping_cost').val();
        $.ajax({
            data: {},
            type: 'POST',
            url: url+'/'+value,
            beforeSend : function() {
                $.blockUI({
                    message        : 'Mentés folyamatban...',
                    baseZ         : 99999,
                    theme         : true,
                    fadeOut     : 10,
                    fadeIn         : 100,
                    showOverlay : true
                });
            },
            complete : function() {
                //$.unblockUI();
            },
            success: function(data){
                 if(data > 0)
                     var message = 'Sikeres mentés';
                 else
                     var message = 'Nincs változás';
                 $.blockUI({ 
                    message: message, 
                    baseZ: 99999,
                    theme : true,
                    fadeIn: 700, 
                    fadeOut: 700, 
                    timeout: 1000, 
                    showOverlay: true, 
                    centerY: true, 
                    css: { 
                        width: '350px', 
                        top: '10px', 
                        left: '', 
                        right: '10px', 
                        border: 'none', 
                        padding: '5px', 
                        backgroundColor: '#000', 
                        '-webkit-border-radius': '10px', 
                        '-moz-border-radius': '10px', 
                        opacity: .6, 
                        color: '#fff' 
                    },
                    onUnblock: function(){location.reload();} 
                }); 
            }
        });
    });

    $("#payment_id_id").change(function(){
        
        var url = $('#change_payment_mode').val();
        var value = $(this).val();
        $.ajax({
            data: {},
            type: 'POST',
            url: url+'/'+value,
            beforeSend : function() {
                $.blockUI({
                    message        : 'Mentés folyamatban...',
                    baseZ         : 99999,
                    theme         : true,
                    fadeOut     : 10,
                    fadeIn         : 100,
                    showOverlay : true
                });
            },
            complete : function() {
                //$.unblockUI();
            },
            success: function(data){
                 if(data > 0)
                     var message = 'Fizetési mód módosítva';
                 else
                     var message = 'Nincs változás';
                 $.blockUI({ 
                    message: message, 
                    baseZ: 99999,
                    theme : true,
                    fadeIn: 700, 
                    fadeOut: 700, 
                    timeout: 1000, 
                    showOverlay: true, 
                    centerY: true, 
                    css: { 
                        width: '350px', 
                        top: '10px', 
                        left: '', 
                        right: '10px', 
                        border: 'none', 
                        padding: '5px', 
                        backgroundColor: '#000', 
                        '-webkit-border-radius': '10px', 
                        '-moz-border-radius': '10px', 
                        opacity: .6, 
                        color: '#fff' 
                    },
                    onUnblock: function(){location.reload();} 
                }); 
            }
        });
    });

    $("#shipping_id_id").change(function(){
        
        var url = $('#change_transport_option').val();
        var value = $(this).val();
        $.ajax({
            data: {},
            type: 'POST',
            url: url+'/'+value,
            beforeSend : function() {
                $.blockUI({
                    message        : 'Mentés folyamatban...',
                    baseZ         : 99999,
                    theme         : true,
                    fadeOut     : 10,
                    fadeIn         : 100,
                    showOverlay : true
                });
            },
            complete : function() {
                //$.unblockUI();
            },
            success: function(data){
                 if(data > 0)
                     var message = 'Kiszállítási mód módosítva';
                 else
                     var message = 'Nincs változás';
                 $.blockUI({ 
                    message: message, 
                    baseZ: 99999,
                    theme : true,
                    fadeIn: 700, 
                    fadeOut: 700, 
                    timeout: 1000, 
                    showOverlay: true, 
                    centerY: true, 
                    css: { 
                        width: '350px', 
                        top: '10px', 
                        left: '', 
                        right: '10px', 
                        border: 'none', 
                        padding: '5px', 
                        backgroundColor: '#000', 
                        '-webkit-border-radius': '10px', 
                        '-moz-border-radius': '10px', 
                        opacity: .6, 
                        color: '#fff' 
                    },
                    onUnblock: function(){location.reload();} 
                }); 
            }
        });
    });

    // AJAX search.
    $("input#product_search").on('input',function(){
        if($(this).val().length > 2)
        {
            $.ajax({
                url: base_url + 'admin/orders/ajax_search/',
                dataType: 'html',
                method: 'POST',
                data: {'term':$(this).val()},
            }).done(function( msg ) {
                if(msg != 'false'){
                    $("#search-result").html(msg);
                    $("#search-result ul").show();
                }
            });
        }
        else
        {
            $("#search-result").html('');
            $("#search-result ul").hide();
        }
    });

    $(document).on("click",".add_product",function(e){
        e.preventDefault();
        var product_name = $(this).text();
        var version_id = $(this).attr('id');
        $("#product_search").val(product_name);
        $("#product_search").attr('data-version_id',version_id);
        $("#search-result").html('');
        $("#search-result ul").hide();
    });

    $(document).on("click","#add_product_to_order",function(e){
        e.preventDefault();
        var version_id = $("#product_search").data('version_id');
        var order_id = $("#product_search").data('order_id');
        var user_id = $("#product_search").data('user_id');
        if(version_id)
        {
            $.ajax({
                data: {},
                type: 'POST',
                url: base_url+'admin/orders/add_product_to_order/'+version_id+'/'+order_id+'/'+user_id,
                beforeSend : function() {
                    $.blockUI({
                        message        : 'Mentés folyamatban...',
                        baseZ         : 99999,
                        theme         : true,
                        fadeOut     : 10,
                        fadeIn         : 100,
                        showOverlay : true
                    });
                },
                complete : function() {
                    //$.unblockUI();
                },
                success: function(data){
                     if(data > 0)
                         var message = 'Tétel hozzáadva';
                     else
                         var message = 'Nincs változás';
                     $.blockUI({ 
                        message: message, 
                        baseZ: 99999,
                        theme : true,
                        fadeIn: 700, 
                        fadeOut: 700, 
                        timeout: 1000, 
                        showOverlay: true, 
                        centerY: true, 
                        css: { 
                            width: '350px', 
                            top: '10px', 
                            left: '', 
                            right: '10px', 
                            border: 'none', 
                            padding: '5px', 
                            backgroundColor: '#000', 
                            '-webkit-border-radius': '10px', 
                            '-moz-border-radius': '10px', 
                            opacity: .6, 
                            color: '#fff' 
                        },
                        onUnblock: function(){
                            location.reload();
                        } 
                    }); 
                }
            });
        }
    });
    

    $(document).on('click','#coupon_btn',function () {
        var coupon_code = $("#coupon_code").val();
        var order_id = $(this).data('order_id');
        var user_id = $(this).data('user_id');
        $.ajax({
            url: base_url + 'admin/orders/add_coupon/'+coupon_code+'/'+order_id+'/'+user_id,
            dataType: 'json',
            html: 'html',
            beforeSend : function() {
                $.blockUI({
                    message        : 'Mentés folyamatban...',
                    baseZ         : 99999,
                    theme         : true,
                    fadeOut     : 10,
                    fadeIn         : 100,
                    showOverlay : true
                });
            },
            complete : function() {
                $.unblockUI();
            },
            success: function(data) {
                if(data.error != "")
                {
                    $('.coupon_error').html(data.error);
                    $('.coupon_error').show();
                }
                else
                {
                    $('.coupon_valid').html(data.msg);
                    $('.coupon_valid').show();
                    setTimeout(function ()
                    {
                        location.reload();
                    }, 500);
                }
            }
        });
    });

});

function printDiv() 
{
  var divToPrint=document.getElementById('invoice');
  var newWin=window.open('','Print-Window');
  newWin.document.open();
  newWin.document.write(divToPrint.innerHTML);
  newWin.document.close();
  setTimeout(function(){newWin.close();},10);
}