$(document).ready(function() {
    $("#attribute_form").validate(
    {
        errorClass: 'alert alert-danger',
        errorElement: "code",
        rules: {
            name: {required : true},
            group_id: {required : true}
        }
    });

    $("#attribute_values_form").validate(
    {
        errorClass: 'alert alert-danger',
        errorElement: "div",
        rules: {
            'name[]': {required : true},
            'value[]': {required : true}
        }
    });

    var img_form_nr = parseInt($('.opt_img').length);
    var autocomplete_options = {
        minLength: 2,
        source: function(request, response) {
            var term = request.term;
            $.getJSON(base_url + 'admin/get-attributes-values', request, function(data, status, xhr) {
                if(data.response == 'true'){
                    response(data.message);
                }
            });
        },
        select: function(event, ui) {
            //console.log("Selected value: " + ui.item.value);
            return;
        }
    };
    $("input.new_value").autocomplete(autocomplete_options);

    $(document).on("click","#attribute_values_form button#add_value",function()
    {
        img_form_nr++;
        var last_row     = $("#attribute_values_form table tr:last");
        var clone         = last_row.clone();

        clone.find("input").each(function() {
            $(this).val("");
            var field_id = $(this).attr('id');
            $(this).attr("id",field_id+''+img_form_nr);
         })
         .end()
         .find("input.name_field").each(function() {
            $(this).autocomplete(autocomplete_options);
         })
         .end()
         .find("span.del").each(function() {
            $(this).removeClass("disabled");
            $(this).attr("data-id","");
         })
         .end()
         .find("a.opt_img_link").each(function() {
             var ids = $(this).attr('href');
            $(this).attr("href",ids+img_form_nr);
         })
         .end();

        clone.insertAfter(last_row);
    });

    // Delete
    $("#attribute_values_form").on("click", "span.del", function() {

        var option_id = $(this).data('id');
        if(option_id != '')
        {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                url: base_url+'admin/attributes/delete-value/'+option_id,
                beforeSend : function() {
                    // Block the UI
                    $.blockUI({
                        message     : 'Törlés folyamatban...',
                        baseZ       : 99999,
                        theme       : true, // use jQuery UI theme
                        fadeOut     : 10,
                        fadeIn      : 100,
                        showOverlay : true
                    });
                },
                complete : function() {
                    // Unblock the UI on success / error
                    $.unblockUI();
                },
                success: function(data){
                     alert(data);
                     //location.reload();
                }
            });
        }

        if($(this).hasClass('disabled') === false)
            $(this).parents("tr").remove();
    });

    $('.popover_').popover();

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
                url: base_url+'admin/attributes/sort-attributes',
                beforeSend : function() {
                    // Block the UI
                    $.blockUI({
                        message    : 'Sorbarendezés folyamatban...',
                        baseZ      : 99999,
                        theme      : true, // use jQuery UI theme
                        fadeOut    : 10,
                        fadeIn     : 100,
                        showOverlay: true
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

    $('.sortable_values').sortable({
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
                url: base_url+'admin/attributes/sort-values',
                beforeSend : function() {
                    $.blockUI({
                        message: 'Sorbarendezés folyamatban...',
                        baseZ: 99999,
                        theme: true,
                        fadeOut: 10,
                        fadeIn: 100,
                        showOverlay: true
                    });
                },
                complete : function() {
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

    /*$(".delete").on('click',function(e){
        e.preventDefault();
        if(confirm('Biztos hogy törlöd ezt az attributumot?'))
            this.closest('form').submit();
    });*/

    $('#datatable').DataTable( {
        "order": [[ 0, "asc" ]],
        "aLengthMenu": [
            [25, 50, 100, 200, -1],
            [25, 50, 100, 200, all]
        ],
        "iDisplayLength": 50,
        "language": {
            "url": base_url+"assets/admin/plugins/datatables/i18n/"+admin_locale+".json"
        },
        "responsive": true
    });

});
