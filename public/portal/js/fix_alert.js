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
		$.post("/portal/door_add_user", {data_id : $(this).attr("door_id"), userArr : userArr, expire_date: $("#txtExpire").val() }, function(ret){
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
		if(confirm("请确认移除用户授权"))
		{
			var idArr = new Array();
			idArr.push(pTr.attr("dooruser_id"));
			$.post('/portal/revoke_door_user', { data_id: door_id, user_id: idArr}, function(ret){
				if(ret.ret == 0)
				{
					pTr.find("td:eq(12)").text("待移除");
					pTr.find("td:eq(13)").empty();
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
		var idArrS = new Array();
		var idArrSS = new Array();
		var idArrSSS = new Array();
		$("#userList input[type='checkbox']:checked").each(function(){
			idArr.push($(this).parents("tr:eq(0)").attr("alertId"));
			idArrS.push($(this).parents("tr:eq(0)").attr("devId"));
			idArrSS.push($(this).parents("tr:eq(0)").attr("signalId"));
			idArrSSS.push($(this).parents("tr:eq(0)").attr("level"));
		});
		if(idArr.length == 0)
		{
			alert("请至少选中一个");
			return;
		}
		if(confirm("请确认修复"))
		{			
			$.post('/portal/Fix_Alert_By_Data_Signal_Id', {alertId: idArr, devId: idArrS, signalId:idArrSS, level: idArrSSS}, function(ret){
				if(ret)
				{
					var n = noty({
						text: '<span>修复成功</span>',
						type: 'success',
						layout: 'topCenter',
						timeout : 1000,
						closeWith: ['hover','click','button']
					});
				}else{
					var n = noty({
						text: '<span>修复失败</span>',
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
		$.post("/portal/down_doorlist", {data_id: door_id, mode : 9}, function(ret){
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
		$.post("/portal/down_doorlist", {data_id: door_id, mode : 10}, function(ret){
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
