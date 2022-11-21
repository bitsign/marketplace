$(document).ready(function() {
    $("#block_form").validate(
    {
        errorClass: 'alert-danger',
        errorElement: "code",
    });
    
    $('.iframe-btn').fancybox({
        width         : '900px',
        height        : '600px',
        type          : 'iframe',
        autoScale     : false,
        autoSize      : false,
        iframe    :{
            'scrolling' : 'auto',
            'preload'   : true
            }
    });
    
});