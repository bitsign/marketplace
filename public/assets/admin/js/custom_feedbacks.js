$(document).ready(function() {
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
				url: base_url+'admin/feedbacks/sort_feedbacks/',
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
});