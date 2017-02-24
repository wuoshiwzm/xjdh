$(document).ready(function(){
	var trObj = null;
	var id = null;
	$('.deletenetwork').click(function(){
		trObj = $(this).parents('tr');
		id = trObj.attr('id'); 
		bootbox.dialog({
			message: "<h4 class='text-error'><i class='icon-exclamation-sign'></i> 是否删除该电源网络安全评估？</h4><br><b>该动作将删除该电源网络安全评估。</b>",
			buttons:{
				OK:{
					label : "确定",
					className : "btn-info",
					callback : function() {
						$.post('/portal/delete_network',{id:id},function(ret){
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
	
	
	
	
	
})