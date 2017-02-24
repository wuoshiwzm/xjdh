$(document).ready(function(){
	var trObj = null;
	var device_id = null;
	$('.btn-white').click(function(){	
		if($(this).find('i').text() == "移除白名单"){
			$(this).find('i').text("添加白名单");
		}else{
			$(this).find('i').text("移除白名单");
		}		
		var data_id= $(this).attr("dataId");
		$.post('/portal/insert_white',{data_id:data_id},function(data){
			eval("var ret = "+data);
			if(ret.result == 2)
			{
				var n = noty({
					text: '<span>添加成功.</span>',
					type: 'success',
					layout: 'topCenter',
					closeWith: ['hover','click','button']
				});
			}else if(ret.result == 1){
				var n = noty({
					text: '<span>移除成功.</span>',
					type: 'fail',
					layout: 'topCenter',
					closeWith: ['hover','click','button']
				});
		    }else{
		    	var n = noty({
					text: '<span>操作失败.</span>',
					type: 'fail',
					layout: 'topCenter',
					closeWith: ['hover','click','button']
				});
		    }
    	})
	});
	$('.delete-dev').click(function(){
		trObj = $(this).parents('tr');
		device_id = trObj.attr('dataId');
		bootbox.dialog({
			message: "<h4 class='text-error'>是否删除该设备？</h4>",
			buttons:{
				OK:{
					label : "确定",
					className : "btn-info",
					callback : function() {
						$.post('/portal/deletedevice',{device_id:device_id},function(ret){
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
		device_id = $(this).parents('tr').attr('device_id');
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
			message: "<h4 >是否"+ text +"该设备？</h4>",
			buttons:{
				OK:{
					label : "确定",
					className : "btn-info",
					callback : function() {
						$.post('/portal/toggledevicestatus',{device_id:device_id,active:status},function(ret){
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

	 $("#selModel").change(function(){
			 var models = $(this).val();
			 if(models.indexOf("-ac") > 0||models.indexOf("-dc") > 0||models.indexOf("-rc") > 0)
			 {
				 $("#group, #devgroup").show();
				 $("#text1, #must").show();
			 }else{
				 $("#group, #devgroup").hide();
				 $("#text1, #must").hide();
			 }

	 });
	 


// $("#selModel").change(modelChange);
	 
});
