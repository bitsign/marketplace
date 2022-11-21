$(document).ready(function() {
	$("#offer_form").validate(
	{
		errorClass: 'alert-danger',
		errorElement: "code",
		rules: {
			name: {required : true},
			price: {required : true},
			unit: {required : true},
			content: {required : true}
		},
		messages:{
			name: {required : 'A név megadása kötelező!'},
			price: {required : 'Az ár megadása kötelező!'},
			unit: {required : 'A mértékegység megadása kötelező'},
			content: {required : 'A tartalom megadása kötelező'}
		}
	});
	
	
	$('.iframe-btn').fancybox({
		width		: '900px',
		height		: '600px',
		type		: 'iframe',
		autoScale	: false,
		autoSize : false,
		iframe	:{
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
				url: base_url+'admin/offers/sort_offers/',
				success: function(data){
	 				//alert(data);
	 				location.reload();
				}
			});
		}
	});
	
});