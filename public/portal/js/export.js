$(document).ready(function() {
	$('.open-form').click(function() {
		$('.type-choose').slideUp();
		$('#area-form').slideDown();
		$('#area-form .widget-head>h3').text($(this).parents(".board-widgets").find('.n-counter').text());
		$('#type').val($(this).attr('data-type'));
		$('#time').val($(this).attr('data-time'));
		$('#txtDate').datetimepicker('remove');
		if ($(this).attr('data-time') == 'day') {
			$('#txtDate').val(new Date().Format("yyyy-MM-dd"));
			$('#txtDate').datetimepicker({
				language : 'zh-CN',
				format : 'yyyy-mm-dd',
				startDate : new Date().Format("yyyy-01-01"),
				endDate : new Date().Format("yyyy-MM-dd"),
				todayBtn : true,
				autoclose : true,
				minView : 2
			});
		} else {
			$('#txtDate').val(new Date().Format("yyyy-MM"));
			$('#txtDate').datetimepicker({
				language : 'zh-CN',
				format : 'yyyy-mm',
				autoclose : true,
				startDate : new Date().Format("yyyy-01-00"),
				endDate : new Date().Format("yyyy-MM-dd"),
				minView : 3,
				startView : 3
			});
		}
	});
	$('#btn-close').click(function() {
		$('.type-choose').slideDown();
		$('#area-form').slideUp();
		$('#type').val("");
		$('#time').val("");
		$('#selCity').val("");
		$('#selCity').trigger("liszt:updated");
		$('#selCity').trigger("change");
	});
});