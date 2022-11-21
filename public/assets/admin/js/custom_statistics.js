$(document).ready(function() {
	
	$('#date-start').datepicker({
		format: "yyyy-mm-dd",
		startDate: '-1Y',
		weekStart: 1,
		language: 'hu',
		todayBtn: "linked",
		autoclose: true,
		todayHighlight: true
	});

	$('#date-end').datepicker({
		format: "yyyy-mm-dd",
		startDate: '-1Y',
		weekStart: 1,
		language: 'hu',
		todayBtn: "linked",
		autoclose: true,
		todayHighlight: true
	});
});