$(document).ready(function() {



    $("#page_form").validate(
    {
        errorClass: 'alert-danger',
        errorElement: "code",
        rules: {
            name: {required : true},
            type : {required : true}
        }
    });

    $("#page_type_form").validate(
    {
        errorClass: 'alert-danger',
        errorElement: "code",
        rules: {
            page_type: {required : true},
            type_name: {required : true}
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
                url: base_url+'admin/pages/sort-pages',
                success: function(data){
                     //location.reload();
                     window.location.href = base_url+'admin/pages';
                }
            });
        }
    });

});
