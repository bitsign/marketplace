$(document).ready(function() {
    $("#banner_form").validate(
    {
        errorClass: 'alert-danger',
        errorElement: "code",
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
                url: base_url+'admin/banners/sort-banners',
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

    $("table .delete").on('click',function(e){
        e.preventDefault();
        if(confirm('Biztos hogy törlöd ezt a bannert?'))
            this.closest('form').submit();
    });

});
