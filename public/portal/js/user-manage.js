$(function(){
	var trObj = null;
	var user_id = null;
	$('.delete-user').click(function(){
		trObj = $(this).parents('tr');
		user_id = trObj.attr('user_id'); 
	
		bootbox.dialog({
			message: "<h4 class='text-error'>是否删除？</h4>",
			buttons:{
				OK:{
					label : "确定",
					className : "btn-info",
					callback : function() {
						$.post('/portal/deluser',{user_id:user_id},function(ret){
							trObj.remove();
							var n = noty({
							text: '<span>删除成功.</span>',
							type: 'success',
							layout: 'topCenter',
							timeout : 1000,
							closeWith: ['hover','click','button']	
						})
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
	$('.user-active').click(function(){
		user_id = $(this).parents('tr').attr('user_id');
		var spanObj = $(this);
		bootbox.dialog({
			message: "<h4 class='text-info'>是否激活该用户？</h4>",
			buttons:{
				OK:{
					label : "确定",
					className : "btn-info",
					callback : function() {
						$.post('/portal/activeuser',{user_id:user_id},function(){
							
								var n = noty({
									text: '<span>激活成功.</span>',
									type: 'success',
									layout: 'topCenter',
									closeWith: ['hover','click','button']
								});
								spanObj.html('已激活');
								spanObj.removeClass('label-warning');
								spanObj.addClass('label-success');
							
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