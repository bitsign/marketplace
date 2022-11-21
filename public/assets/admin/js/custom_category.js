$(document).ready(function() {
    $("#category_form").validate(
    {
        errorClass: 'alert-danger',
        errorElement: "code",
    });

    $('.iframe-btn').fancybox({
        width     : '900px',
        height    : '600px',
        type      : 'iframe',
        autoScale : false,
        autoSize  : false,
        iframe    :{
            'scrolling' : 'auto',
            'preload'   : true
            }
    });

    $(".select_all").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

});