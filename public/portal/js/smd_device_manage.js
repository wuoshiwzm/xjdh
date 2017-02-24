$(document).ready(function(){
	var trObj = null;
	var smd_device_no = null;
	$('.delete-dev').click(function(){
		trObj = $(this).parents('tr');
		smd_device_no = trObj.attr('smd_device_no'); 
		bootbox.dialog({
			message: "<h4 class='text-error'><i class='icon-exclamation-sign'></i> 是否删除该采集单元？</h4><br><b>该动作将删除该采集单元以及挂载的所有设备。</b>",
			buttons:{
				OK:{
					label : "确定",
					className : "btn-info",
					callback : function() {
						$.post('/portal/deleteSmdDevice',{smd_device_no:smd_device_no},function(ret){
							if(ret)
							{
								trObj.remove();
								var n = noty({
									text: '<span>删除成功.</span>',
									type: 'success',
									layout: 'topCenter',
									closeWith: ['hover','click','button']
								});
							}else{
								var n = noty({
									text: '<span>'+ text +'失败.</span>',
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
					className : "btn",
					callback : function() {
						
					}
				}
			},
			onEscape: true
		});
	});
	$('.dev-unlock,.dev-lock').click(function(){
		smd_device_no = $(this).parents('tr').attr('smd_device_no');
		var spanObj = $(this);
		var isLock = $(this).hasClass('dev-lock');
		var text = isLock ? '锁定' : '激活';
		if(text == '锁定')
		{
				var status = 0;
		}else if(text == '激活'){
			var status = 1;
		}
		bootbox.dialog({
			message: "<h4 class='text-info'>是否"+ text +"该设备？</h4>",
			buttons:{
				OK:{
					label : "确定",
					className : "btn-info",
					callback : function() {
						$.post('/portal/toggleSmdDeviceStatus',{smd_device_no:smd_device_no,active:status},function(ret){
							if(ret)
							{
								var n = noty({
									text: '<span>'+ text +'成功.</span>',
									type: 'success',
									layout: 'topCenter',
									closeWith: ['hover','click','button']
								});
								spanObj.html(isLock ? '未激活':'已激活');
								spanObj.removeClass(isLock ? 'label-success' : 'label-warning');
								spanObj.removeClass(isLock ? 'dev-lock' : 'dev-unlock');
								spanObj.addClass(isLock ? 'label-warning' : 'label-success' );
								spanObj.addClass(isLock ? 'dev-unlock' : 'dev-lock');
							}else{
								var n = noty({
									text: '<span>'+ text +'失败.</span>',
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
					className : "btn",
					callback : function() {
						
					}
				}
			},
			onEscape: true
		});
	});
});