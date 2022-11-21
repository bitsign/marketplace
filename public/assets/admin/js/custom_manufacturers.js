$(document).ready(function() {
    $("#brands_form").validate(
    {
        errorClass: 'alert-danger',
        errorElement: "code",
    });
    
    $('.iframe-btn').fancybox({
        width       : '900px',
        height      : '600px',
        type        : 'iframe',
        autoScale   : false,
        autoSize    : false,
        iframe      : {
            'scrolling' : 'auto',
            'preload'   : true
        }
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
                data: data,
                type: 'POST',
                url: base_url+'admin/manufacturers/sort_manufacturers/',
                beforeSend : function() {
                    $.blockUI({
                        message     : 'Sorbarendezés folyamatban...',
                        baseZ       : 99999,
                        theme       : true,
                        fadeOut     : 10,
                        fadeIn      : 100,
                        showOverlay : true
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