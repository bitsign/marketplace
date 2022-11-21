$(document).ready(function() {
    $("#portfolio_form").validate(
    {
        errorClass: 'alert-danger',
        errorElement: "code",
    });

    $('.iframe-btn').fancybox({
        'width' : 900,
        'height' : 600,
        'type' : 'iframe',
        'fitToView' : false,
        'autoSize' : false
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
                url: base_url+'admin/portfolio/sort-portfolio',
                success: function(data){
                     //alert(data);
                     location.reload();
                }
            });
        }
    });
    //fotok szerkesztes
    if($().fileinput)
    {
        $("#file-1").fileinput({
            showUpload: false,
            showCaption: true,
            language: 'hu',
            theme: 'fa',
            fileType: "any"
        });

        $("#file-2").fileinput({
            showUpload: false,
            showCaption: true,
            language: 'hu',
            theme: 'fa',
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

        var msg_confirm = $(this).data('msg_confirm');

        if(confirm(msg_confirm))
        {
            var id= $(this).attr('id').split("_");
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                url: base_url+"admin/portfolio/delete-image",
                data: { id: id[1] }
            }).done(function( msg ) {
                if(msg == 0)
                {
                    setTimeout(function()
                    {
                        $("#alertd_"+id[1]).hide('slow');
                    }, 3000);
                }
                else
                {
                    $("#delete_"+id[1]).parent().parent().remove();
                    setTimeout(function()
                    {
                        $("#alerts_"+id[1]).hide('slow');
                    }, 3000);
                }
            });
        }
    });
    
    $('.save_image').click(function(e)
    {
        e.preventDefault();
        var id          = $(this).attr('id').split("_");
        var img_default = $("#default_"+id[2]+":checked").val();
        var img_title   = $("#title_"+id[2]).val();
        //var img_alt   = $("#alt_"+id[2]).val();
        var tags        = $("#tags_"+id[2]).val();
        var msg_success = $(this).data('msg_success');
        var msg_danger  = $(this).data('msg_danger');
        $.ajax({
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              method: "POST",
              type: "html",
              url: base_url+"admin/portfolio/set-image",
              data: { id: id[1], img_id: id[2],img_default: img_default, title: img_title, tags:tags}
        }).done(function( msg ) {
            if(msg == 0)
            {
                $("#alertd_"+id[2]).html(msg_danger);
                $("#alertd_"+id[2]).removeClass('hidden');
                setTimeout(function()
                {
                    $("#alertd_"+id[2]).hide('slow');
                    //location.reload();
                }, 1000);
            }
            else
            {
                $("#alerts_"+id[2]).html(msg_success);
                $("#alerts_"+id[2]).removeClass('hidden');
                setTimeout(function()
                {
                    $("#alerts_"+id[2]).hide('slow');
                    //location.reload();
                }, 1000);
            }
        });
    });
    //foto szerkesztes vege
});
