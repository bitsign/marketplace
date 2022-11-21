$(document).ready(function() {
	$('.datatable').DataTable( {
        "order": [[ 0, "asc" ]],
        "aLengthMenu": [
            [25, 50, 100, 200, -1],
            [25, 50, 100, 200, all]
        ],
        "iDisplayLength": 50,
        "language": {
            "url": base_url+"assets/admin/plugins/datatables/i18n/"+admin_locale+".json"
        },
        "responsive": true
	});

});