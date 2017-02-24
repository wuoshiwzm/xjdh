$(document).ready(function() {
	$('.datepicker').datetimepicker({
		language: 'zh-CN',
		format: 'yyyy-mm-dd',
		todayBtn: true,
		autoclose: true,
		minView: 2		
	});
	$('.date-range-picker').daterangepicker({
		format: 'YYYY-MM-DD',
        separator: '至',
        timePicker: false,
    	locale: {
    		applyLabel: '选择',
    		cancelLabel: '重置',
            fromLabel: '从',
            toLabel: '到',
            weekLabel: '星期',
            customRangeLabel: '范围',
            daysOfWeek: ['日','一','二','三','四','五','六'],
            monthNames: ['一月', '二月', '三月', '四月', '五月', '六月','七月', '八月', '九月', '十月', '十一月', '十二月'],
            firstDay: 0
    	}
	});
	var alert_id = null;
	var trObj = null;
	$('.block-alert').click(function(){
		alert_id = $(this).attr('alert_id');
		trObj = $(this).parents('tr');
		bootbox.dialog({
			message: "<h4 class='text-error'>是否确认该告警？</h4>",
			buttons:{
				OK:{
					label : "确定",
					className : "btn-info",
					callback : function() {
						$.post('/portal/take_alert',{alert_id:alert_id},function(ret){
							if(ret)
							{								
								trObj.remove();
								var n = noty({
									text: '<span>确认成功.</span>',
									type: 'success',
									layout: 'topCenter',
									closeWith: ['hover','click','button']
								});
							}else{
								var n = noty({
									text: '<span>确认失败.</span>',
									type: 'fail',
									layout: 'topCenter',
									closeWith: ['hover','click','button']
								});
							}
						});
					}
				},
				Cancel:{
					label : "取消",
					className : "btn"
				}
			},
			onEscape: true
		});
	});
	//setInterval("window.location.reload();", 10000);
});