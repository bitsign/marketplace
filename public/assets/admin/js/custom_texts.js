$(document).ready(function() {
	
	$('#datatable').DataTable( {
		"order": [[ 0, "asc" ]],
		"iDisplayLength": 25,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Hungarian.json"
		},
		"responsive": true
	});
	
	$("#texts_form").validate(
	{
		errorClass: 'alert-danger',
		errorElement: "code",
		rules: {
			key: {required : true},
			value: {required : true},
		}
	});

	
});