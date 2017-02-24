$(document).ready(function(){
	$('.datepicker').datetimepicker({
		language: 'zh-CN',
		format: 'yyyy-mm-dd',
		todayBtn: true,
		autoclose: true,
		minView: 2		
	});
	$("#btn-clear").click(function(){
    	window.location.href="/portal/loginloguser";
    	return false;
    });
});