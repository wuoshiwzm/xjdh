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
		var userId = $(this).attr('userId');
		if(!treeInit)
		{
			treeInit = true;
			$.get('/portal/get_door_tree',{userId:userId}, function(areaTreeData){
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
		var dataIdArr = $('#userTree').jstree('get_bottom_selected');
		if(!$("#cbRemote").prop("checked") && !$("#cbCard").prop("checked"))
		{
			alert("请至少选择一种开门权限");
			return;
		}
		$.post("/portal/user_add_door", { user_id : user_id, dataIdArr : dataIdArr, expire_date: $("#txtExpire").val()
								, card_control : $("#cbCard").prop("checked"), remote_control: $("#cbRemote").prop("checked")}, function(ret){
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
	
	$(".delete-user").click(function(){
		var pTr = $(this).parents("tr:eq(0)");
		if(confirm("请确认移除门禁授权"))
		{
			var idArr = new Array();
			idArr.push(pTr.attr("dataId"));
			$.post('/portal/revoke_user_door', { dataIdArr: idArr, user_id: user_id}, function(ret){
				if(ret.ret == 0)
				{
					setTimeout(function(){ window.location.reload(); }, 1000);
					var n = noty({
						text: '<span>移除用户授权成功.</span>',
						type: 'success',
						layout: 'topCenter',
						timeout : 1000,
						closeWith: ['hover','click','button']
					});
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
			idArr.push($(this).parents("tr:eq(0)").attr("dataId"));
		});
		if(idArr.length == 0)
		{
			alert("请至少选中一个门禁");
			return;
		}
		if(confirm("请确认移除门禁授权"))
		{			
			$.post('/portal/revoke_user_door', {dataIdArr: idArr,  user_id: user_id}, function(ret){
				if(ret.ret == 0)
				{
					setTimeout(function(){ window.location.reload(); }, 1000);
					var n = noty({
						text: '<span>移除门禁授权成功.</span>',
						type: 'success',
						layout: 'topCenter',
						timeout : 1000,
						closeWith: ['hover','click','button']
					});
				}else{
					var n = noty({
						text: '<span>移除门禁授权失败' + ret.msg + '</span>',
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
		$.post("/portal/down_user_door", {user_id: user_id, mode : "down"}, function(ret){
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
		$.post("/portal/down_user_door", {user_id: user_id, mode : "clr_down"}, function(ret){
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
	
	
});