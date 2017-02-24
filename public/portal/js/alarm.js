$(document).ready(function() {	
	$("#all").click(function(){
		if($("#all").prop("checked") == true){
			 $("[name='checkbox']").attr("checked",'true');
		};
	   if($("#all").prop("checked") == false){
		 $("[name='checkbox']").removeAttr("checked");
	    };
})
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
	$('.restore-alert').click(function(){
		
		alert_id = $(this).attr('alert_id');
		trObj = $(this).parents('tr');
		
				bootbox.dialog({
					message: "<h4 class='text-error'>是否结束告警？</h4>",
					buttons:{
						OK:{
							label : "确定",
							className : "btn-info",
							callback : function() {
						$.post('/portal/restore_alert',{alert_id:alert_id},function(ret){
							if(ret)
							{
								trObj.remove();
								var n = noty({
									text: '<span>结束告警操作成功.</span>',
									type: 'success',
									layout: 'topCenter',
									closeWith: ['hover','click','button']
								            })
								
							}
						   });
					   }		
					 },
								Cancel:{
									label : "取消",
									className : "btn",
									callback : function() {					
									
								                       } 									
							           }							
						},
				  onEscape: true
			});

		});
	$("#Batch").click(function(){		
		var alarmListId = [];
		$("#tbAlarm input.nameCheckbox:checked").each(function(){			
			if($(this).prop("checked") == true){
				alarmListId.push($(this).val());
			}
		});
		if(alarmListId.length == 0)
		{
			alert("请先选中要恢复的告警");
			return false;
		}
		if(confirm("确认要结束所有选中的已恢复告警？")){			
	        $.post('/portal/batch_end_alarm', { alarmListId : alarmListId},function(ret){
				if(ret)
				{
					var n = noty({
						text: '<span>结束告警操作成功.</span>',
						type: 'success',
						layout: 'topCenter',
						closeWith: ['hover','click','button']
					});
					setTimeout(function(){ 
						window.location.reload();
					}, 1000);
				}else{
					var n = noty({
						text: '<span>结束告警操作失败.</span>',
						type: 'fail',
						layout: 'topCenter',
						closeWith: ['hover','click','button']
					});
				}
			});
		}
	});
	$('.block-alert').click(function(){
		alert_id = $(this).attr('alert_id');
		trObj = $(this).parents('tr');
		bootbox.dialog({
			message: "<h4 class='text-error'>是否屏蔽该告警？</h4>",
			buttons:{
				OK:{
					label : "确定",
					className : "btn-info",
					callback : function() {
						$.post('/portal/block_alert',{alert_id:alert_id},function(ret){
							if(ret)
							{
								trObj.remove();
								var n = noty({
									text: '<span>告警屏蔽成功.</span>',
									type: 'success',
									layout: 'topCenter',
									closeWith: ['hover','click','button']
								});
								setTimeout(function(){ 
									window.location.reload();
								}, 1000);
							}else{
								var n = noty({
									text: '<span>告警屏蔽失败.</span>',
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