$(document).ready(function()
{
    $(".select2").select2();
    
    /*$('.name').nameBadge({
        border: {width: 0},
        colors: ['#1abc9c', '#2ecc71', '#e74c3c', '#34495e', '#f1c40f'],
        text: '#fff',
        margin: 15,
        size: 70
    });*/

    $("#comment_form").validate(
    {
        errorClass: 'alert-danger',
        errorElement: "code",
        rules: {
            display_name: {required : true},
            comment: {required : true},
            captcha: {required : true}
        },
    });

    $(document).on("click",".send_reply",function()
    {
        var comment_id = $(this).data('id');

        $(".reply_form form").remove();
        $("#respond form").show();
        $(".comment .cmeta .btn").html('Válaszolok');

        $("#respond form").clone().attr("id","new_respond_"+comment_id).appendTo("#reply_form_"+comment_id)
        $("#respond form").hide();
        $("#new_respond_"+comment_id+" #parent_id").val(comment_id);

        $(this).html('Mégsem válaszolok');
        $(this).removeClass('send_reply');
        $(this).addClass('cancel_send_reply');
    });

    $(document).on("click",".cancel_send_reply",function(){
        var comment_id = $(this).data('id');
        $("#reply_form_"+comment_id+" form").remove();
        $("#respond form").show();
        $(this).html('Válaszolok');
        $(this).removeClass('cancel_send_reply');
        $(this).addClass('send_reply');
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

    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        startDate: '-1d',
        weekStart: 1,
        language: 'hu',
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
});