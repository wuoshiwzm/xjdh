$(document).ready(function(){
	 $('.datepicker').datetimepicker({
         language: 'zh-CN',
         format: 'yyyy-mm-dd',
         todayBtn: true,
         autoclose: true,
         minView: 2
	 });

	var treeInit = false;
	$("#btnAddPermission").click(function(){
		if(!treeInit)
		{
			treeInit = true;
			$.get('/portal/get_user_tree', function(areaTreeData){
				$('#userTree').jstree({'plugins':["checkbox","search"], 'core' : {
					'data' : areaTreeData
				}});
			});
		}
		$("#userDialog").modal({
			 keyboard: true,
			 show	: true, 
		});
	});
	
	var to = false;
	$('#userQuery').keyup(function () {
		if(to) { clearTimeout(to); }
		to = setTimeout(function () {
			var v = $('#userQuery').val();
			$('#userTree').jstree(true).search(v);
		}, 250);
	});
	
	$("#btnDoorAddUser").click(function(){
		var userArr = $('#userTree').jstree('get_bottom_selected');
		if(!$("#cbRemote").prop("checked") && !$("#cbCard").prop("checked"))
		{
			alert("请至少选择一种开门权限");
			return;
		}
		$.post("/portal/door_add_user", {data_id : $(this).attr("door_id"), userArr : userArr, expire_date: $("#txtExpire").val()
					, card_control : $("#cbCard").prop("checked"), remote_control: $("#cbRemote").prop("checked") }, function(ret){
			if(ret.ret == 0)
			{								
				var n = noty({
					text: '<span>添加成功.</span>',
					type: 'success',
					layout: 'topCenter',
					timeout : 1000,
					closeWith: ['hover','click','button']
				});
				setTimeout(function(){ 
					window.location.reload();
				}, 1000);
			}else{
				var n = noty({
					text: '<span>添加失败' + ret.msg + '</span>',
					type: 'fail',
					layout: 'topCenter',
					timeout : 1000,
					closeWith: ['hover','click','button']
				});
			}
		});
	});
	
	$("#cbAll").change(function(){
		var tBody = $(this).parents("thead").next();
		if($(this).prop("checked")){
			$("input[type='checkbox']",tBody).prop('checked',true);
		}else{
			$("input[type='checkbox']",tBody).prop('checked',false);
		}
	});
	
	function tbodyChange()
	{
		var tBody = $(this).parents("tbody");
		var tHead = tBody.prev();
		if($("input[type='checkbox']:not(:checked)",tBody).length > 0)
		{
			$("tr input[type='checkbox']",tHead).prop("checked",false);
		}else{
			$("tr input[type='checkbox']",tHead).prop("checked",true);
		}
	}
	$("#userList input[type='checkbox']").change(tbodyChange);
	
	$(".btn-primary").click(function(){
		var pTr = $(this).parents("tr:eq(0)");
		user_id = pTr.attr("dooruser_id");
		$("#txtTimes").val($(this).parent().prev().text());
		$("#propertyDialog").modal({
			 keyboard: true,
			 show	: true, 
		});
	});
	
	$("#btnDoorSet").click(function(){
		var t = parseInt($("#txtTimes").val());
		if(isNaN(t))
		{
			t = 0;
		}
		
		$.post("/portal/door_set_check_time", {data_id : $(this).attr("data_id"), user_id : user_id,  times:t},function(ret){
			if(ret.ret == 0)
			{
				var n = noty({
					text: '<span>设置成功.</span>',
					type: 'success',
					layout: 'topCenter',
					timeout : 1000,
					closeWith: ['hover','click','button']
				});
				setTimeout(function(){ window.location.reload(); }, 1000);
			}else{
				var n = noty({
					text: '<span>设置失败</span>',
					type: 'fail',
					layout: 'topCenter',
					timeout : 1000,
					closeWith: ['hover','click','button']
				});
			}
		});
	});
	
	$(".delete-user").click(function(){
		var pTr = $(this).parents("tr:eq(0)");
		if(confirm("请确认移除用户授权"))
		{
			var idArr = new Array();
			idArr.push(pTr.attr("dooruser_id"));
			$.post('/portal/revoke_door_user', { data_id: door_id, user_id: idArr}, function(ret){
				if(ret.ret == 0)
				{
					var n = noty({
						text: '<span>移除用户授权成功.</span>',
						type: 'success',
						layout: 'topCenter',
						timeout : 1000,
						closeWith: ['hover','click','button']
					});
					setTimeout(function(){ window.location.reload(); }, 1000);
				}else{
					var n = noty({
						text: '<span>移除用户授权失败' + ret.msg + '</span>',
						type: 'fail',
						layout: 'topCenter',
						timeout : 1000,
						closeWith: ['hover','click','button']
					});
				}
			});
		}
	});
	
	$("#btnRevoke").click(function(){
		var idArr = new Array();
		$("#userList input[type='checkbox']:checked").each(function(){
			idArr.push($(this).parents("tr:eq(0)").attr("dooruser_id"));
		});
		if(idArr.length == 0)
		{
			alert("请至少选中一个用户");
			return;
		}
		if(confirm("请确认移除用户授权"))
		{			
			$.post('/portal/revoke_door_user', {data_id: door_id,  user_id: idArr}, function(ret){
				if(ret.ret == 0)
				{
					var n = noty({
						text: '<span>移除用户授权成功.</span>',
						type: 'success',
						layout: 'topCenter',
						timeout : 1000,
						closeWith: ['hover','click','button']
					});
					setTimeout(function(){ window.location.reload(); }, 1000);
				}else{
					var n = noty({
						text: '<span>移除用户授权失败' + ret.msg + '</span>',
						type: 'fail',
						layout: 'topCenter',
						timeout : 1000,
						closeWith: ['hover','click','button']
					});
				}
			});
		}
	});
	
	$("#btnDown").click(function(){
		$.post("/portal/down_doorlist", {data_id: door_id, mode : "down"}, function(ret){
			if(ret.ret == 0)
				{
					var n = noty({
						text: '<span>下发成功.请稍后查看执行结果.</span>',
						type: 'success',
						layout: 'topCenter',
						timeout : 1000,
						closeWith: ['hover','click','button']
					});
				}else{
					var n = noty({
						text: '<span>下发失败:' + ret.msg + '</span>',
						type: 'fail',
						layout: 'topCenter',
						timeout : 1000,
						closeWith: ['hover','click','button']
					});
				}
		})
	});
	
	$("#btnDownAll").click(function(){
		$.post("/portal/down_doorlist", {data_id: door_id, mode : "clr_down"}, function(ret){
			if(ret.ret == 0)
				{
					var n = noty({
						text: '<span>下发成功.请稍后查看执行结果.</span>',
						type: 'success',
						layout: 'topCenter',
						timeout : 1000,
						closeWith: ['hover','click','button']
					});
				}else{
					var n = noty({
						text: '<span>下发失败:' + ret.msg + '</span>',
						type: 'fail',
						layout: 'topCenter',
						timeout : 1000,
						closeWith: ['hover','click','button']
					});
				}
		})
	});
	
		
	$(".dev-unlock,.dev-lock").click(function(){
		device_id = $(this).parents('tr').attr('device_id');
		var spanObj = $(this);
		var isLock = $(this).hasClass('dev-lock');
		var status = isLock ? '待下发' : '已下发';
		bootbox.dialog({
			message: "<h4 class='text-info'>是否修改下发状态？</h4>",
			buttons:{
				OK:{
					label : "确定",
					className : "btn-info",
					callback : function() {
						$.post('/portal/change_status',{device_id:device_id,status:status},function(ret){
							if(ret)
							{
								var n = noty({
									text: '<span>'+ status +'成功.</span>',
									type: 'success',
									layout: 'topCenter',
									closeWith: ['hover','click','button']
								});
								spanObj.html(isLock ? '待下发':'已下发');
								spanObj.removeClass(isLock ? 'label-success' : 'label-warning');
								spanObj.removeClass(isLock ? 'dev-lock' : 'dev-unlock');
								spanObj.addClass(isLock ? 'label-warning' : 'label-success' );
								spanObj.addClass(isLock ? 'dev-unlock' : 'dev-lock');
							}else{
								var n = noty({
									text: '<span>'+ status +'失败.</span>',
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
