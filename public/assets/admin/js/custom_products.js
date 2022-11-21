$(document).ready(function() {

    $(".grouped").select2({
        language: 'hu',
        minimumInputLength: 2,
        multiple:true,
        ajax: {
        url: base_url+'admin/products/search_by_product_number/',
        dataType: 'json',
        delay: 250,
         processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
      }
    });
    var vals=[];
    $(".grouped option").each(function(){
        if($(this).val())
            vals.push($(this).val());
    });
    if(vals.length !== 0)
    {
        $("#grouped").val(vals).trigger("change");
    }

    $("#product_form").validate(
    {
        errorClass: 'alert-danger',
        errorElement: "code",
        rules: {
            name: {required : true},
            lang: {required : true},
            'categories[]': {required : true},
            product_number: {required : true},
            price: {required : true}
        },
    });

    $("#action_price_form").validate(
    {
        errorClass: 'alert-danger',
        errorElement: "code",
        rules: {
            'value': {required : true, number: true},
        },
    });


    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        //startDate: '-1d',
        weekStart: 1,
        language: admin_locale,
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: true
    });
    $("#reset-date-1").click(function(){
        $('#datepicker-1').val("0").datepicker("update");
    })
    $("#reset-date-0").click(function(){
        $('#datepicker-0').val("0").datepicker("update");
    })

    $('body').on('click', '.optionTitle', function(){
        $($(this).attr('href')).slideToggle();
        return false;
    }).on('click', '.deleteOptionValue', function(){
        if(confirm('Biztos, hogy törlöd ezt az értéket?'))
        {
            var product_option_id = $(this).data('product_option_id');
            var product_id = $(this).data('product_id');
            if(product_option_id !== "")
            {
                $.ajax({
                    url: base_url + 'admin/products/delete_product_option_value_by_id/'+product_option_id+'/'+product_id,
                    success: function(data) {
                        if(data > 0)
                            alert('Opció érték sikeresen törölve');
                        else
                            alert('Nincs változás');
                    }
                });
            }
            $(this).closest('.optionValuesForm').remove();
        }
    });

    $(".sortable").sortable();
    $(".sortable > col-medium-").disableSelection();

    //product attributes
    $(document).on("click","button.add_option",function()
    {
        var row_nr =  parseInt($('.options_table tr').length);
        $('.options_table select').select2("destroy");
        var nr = $(".options_table tr").length;
        var row     = $(".options_table tr:last");
        var clone         = row.clone();
        clone.attr("data-row", row_nr+1);
        clone.insertAfter(row);
        $('.options_table select').select2({theme:'bootstrap-5'});
    });
    /*$(document).on("click","button.add_option",function()
    {
        var version_id = $(this).attr('data-versionid');
        var row_nr =  parseInt($('.options_table tr').length);
        $('.options_table#version_'+version_id+' select').select2("destroy");
        var row      = $(".options_table#version_"+version_id+' tr:last');
        var clone     = row.clone();
        clone.attr("data-row", row_nr+1);
        clone.insertAfter(row);

        $('.options_table#version_'+version_id+' select').select2();
    });*/


    //új attributum
    $(document).on("change",".options_table tr select",function()
    {
        var attr_id        = $(this).val();
        var row_nr         = $(this).closest('tr').attr('data-row');
        if(attr_id != "undefined")
        {
            $(this).attr('name','attribute_['+attr_id+']');
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: base_url+"admin/get-attributes-values/"+attr_id,
            }).done(function( data ) {
                if(data != 'false')
                {
                    $('.options_table tr[data-row="'+row_nr+'"] td.attr_options').html(data);
                    $('.options_table tr[data-row="'+row_nr+'"] td.attr_options select').select2();
                }
            });
        }
    });

    // Delete attribute option
    $(document).on("click", "span.del", function() {
        var nr = $(".options_table tbody tr").length;
        if(nr > 1)
            $(this).parents("tr").remove();
        else
            $(".options_table tbody tr select").val('');
    });


    //fotok szerkesztes
    if($().fileinput)
    {
        $("#file-1").fileinput({
            theme: 'bs5',
            language: admin_locale,
            browseOnZoneClick: true,
            browseIcon:"<i class='bi bi-plus'></i> ",
            uploadIcon:"<i class='bi bi-save'></i> ",
            removeIcon:"<i class='bi bi-trash'></i> ",
            showUpload: false,
            showCaption: false,
            fileType: "any"
        });
    }

    $(document).on('click','.file-preview-frame',function()
    {
        var img_nr = $('.file-preview-thumbnails .file-preview-frame').length;
        if(img_nr == 1)
        {
            $(this).remove();
            $(".file-preview").parent().addClass('file-input-new');
        }
        else
            $(this).remove();
    });

    $('.delete_image').click(function(e)
    {
        e.preventDefault();
        var dialog = confirm('Biztos hogy törlöd ezt a fotót?');
        if(dialog)
        {
            var id= $(this).attr('id').split("_");
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "DELETE",
                dataType: 'json',
                data:{'image_id':id[1]},
                url: base_url+"admin/product-images/destroy",
            }).done(function( data ) {

                if(data.code == 1)
                    $("#delete_"+id[1]).parent().parent().parent().remove();

                alert(data.msg);
            });
        }
    });

    $('.save_image').click(function(e)
    {
        e.preventDefault();
        var id= $(this).attr('id').split("_");
        var product_id = id[1];
        var img_default = $("#default_"+id[2]+":checked").val();
        var img_title = $("#title_"+id[2]).val();
        var img_alt = $("#alt_"+id[2]).val();
        $.ajax({
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              type: "PUT",
              dataType: 'json',
              url: base_url+"admin/product-images/"+id[2],
              data: {'id':id[2], 'default': img_default, 'title': img_title, 'alt': img_alt,'product_id':product_id }
        }).done(function( data ) {
            if(data.code == 1)
            {
                $("#alerts_"+id[2]).html(data.msg);
                $("#alerts_"+id[2]).removeClass('hidden');
                setTimeout(function()
                {
                    $("#alerts_"+id[2]).hide('slow');
                    //location.reload();
                }, 1000);
            }
            else
            {
                $("#alertd_"+id[2]).html(data.msg);
                $("#alertd_"+id[2]).removeClass('hidden');
                setTimeout(function()
                {
                    $("#alertd_"+id[2]).hide('slow');
                    //location.reload();
                }, 1000);
            }
        });
    });
    //foto szerkesztes vege

    //aktuális fül kinyitása
    var url = window.location.href;
    if (url.match('#')) {
        var activeTab = url.substring(url.indexOf("#") + 1);
        $('.nav-pills button[aria-controls='+activeTab+']').tab('show');
    }

    //kapcsolodo termekek
    $('#search_by_category_id').on('select2:select', function (e) { 
        console.log('select event');
    });
    
    $('#search_by_category_id').on('change',function(){
        var id = $(this).val();
        alert(id);
        /*var product_number = $("#search_by_product_number").val();
        if(id != "" && id != 1)
        {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                data: {'product_number':product_number},
                url: base_url+"admin/get-products-by-category/"+id,
            }).done(function( msg ) {
                if(msg == 0)
                {
                    $("#search_results #products").html('Nem található termék ebben a kategóriában');
                    $("#search_results").removeClass('hidden');
                }
                else
                {
                    $("#search_results #products").html(msg);
                    $("#search_results").removeClass('hidden');
                }
            });
        }*/
    });
    $('#search_by_product_number').on('input',function(){
        var id = $("#search_products").val();
        var product_number = $(this).val();

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: {'product_number':product_number},
            url: base_url+"admin/get-products-by-category/"+id,
        }).done(function( msg ) {
            if(msg == 0)
            {
                $("#search_results #products").html('Nem található termék ebben a kategóriában');
                $("#search_results").removeClass('hidden');
            }
            else
            {
                $("#search_results #products").html(msg);
                $("#search_results").removeClass('hidden');
            }
        });
    });

    $('.delete_att_product').on('click',function(){
        var dialog = confirm('Biztos hogy törlöd ezt a kapcsolódó terméket?');
        if(dialog)
        {
            var id = $(this).attr('id').split('_');
            $.ajax({
                url: base_url+"admin/products/delete_attached_product/"+id[1]+"/"+id[2],
            }).done(function( msg ) {
                if(msg == 0)
                    alert('Nem található ilyen termék');
                else
                    alert('Kapcsoldó termék sikeresen törölve');
                location.reload();
            });
        }
    });

    $('.delete_att_products').on('click',function(){
        var dialog = confirm('Biztos hogy törlöd a kapcsolódó termékeket?');
        if(dialog)
        {
            var id = $(this).attr('id').split('_');
            $.ajax({
                url: base_url+"admin/products/delete_attached_products/"+id[1],
            }).done(function( msg ) {
                if(msg == 0)
                    alert('Nem található ilyen termék');
                else
                    alert('Kapcsoldó termékek sikeresen törölve');
                location.reload();
            });
        }
    });
    //kapcsolodo termekek vége

    $('.product_sortable').sortable({
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
                data: data,
                type: 'POST',
                url: base_url+'admin/products/sort_products/',
                beforeSend : function() {
                    // Block the UI
                    $.blockUI({
                        message        : 'Sorbarendezés folyamatban...',
                        baseZ         : 99999,
                        theme         : true, // use jQuery UI theme
                        fadeOut     : 10,
                        fadeIn         : 100,
                        showOverlay : true
                    });
                },
                complete : function() {
                    // Unblock the UI on success / error
                    $.unblockUI();
                },
                success: function(data){
                     //alert(data);
                     location.reload();
                }
            });
        }
    });

    $('.iframe-btn').fancybox({
        width        : '900px',
        height        : '600px',
        type        : 'iframe',
        autoScale    : false,
        autoSize : false,
        iframe    :{
            'scrolling' : 'auto',
            'preload'   : true
            }
    });

    $(".select-all-options").on("click", function() {
         $('input[type=checkbox]').attr('checked', 'checked');
    });

    $(".delete-all-options").on("click", function() {
         $('input[type=checkbox]').attr('checked', false);
    });

});

function insertToFilename( id, text )
{
    var $txt = jQuery(id);
    var caretPos = $txt[0].selectionStart;
    var textAreaTxt = $txt.val();
    $(id).val( textAreaTxt.substring(0, caretPos) + text + textAreaTxt.substring(caretPos) );
}
