$(document).ready(function() {
	$("#coupons_form").validate(
	{
		errorClass: 'alert-danger',
		errorElement: "code",
		rules: {
			name: {required : true},
			code: {required : true},
			type: {required : true},
			discount: {required : true}
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

    $('.select2').select2();
});