$(document).ready(function() {
    $("#faq_form").validate(
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
                url: base_url+'admin/faqs/sort-faqs',
                success: function(data){
                     //alert(data);
                     location.reload();
                }
            });
        }
    });
})
