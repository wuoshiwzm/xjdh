$(document).ready(function() {
	$("table").tablesorter({headers: {0: { sorter: false}}});

	$("thead tr input[type='checkbox']").change(function(){
		var tBody = $(this).parents("thead").next();
		var set = $("tbody input[type='checkbox']");
		if($(this).prop('checked') == true){
			$("input[type='checkbox']",tBody).prop('checked',true);
			//$("input[type='checkbox']",tBody).parent().addClass('checked');
		}else{
			$("input[type='checkbox']",tBody).prop('checked',false);
			//$("input[type='checkbox']",tBody).parent().removeClass('checked');
		}
	});
	
	function tbodyChange()
	{
		var tBody = $(this).parents("tbody");
		var tHead = tBody.prev();
		if($("input[type='checkbox']:not(:checked)",tBody).length > 0)
		{
			$("tr input[type='checkbox']",tHead).prop('checked',false);
		}else{
			$("tr input[type='checkbox']",tHead).prop("checked",true);
		}
		//$.uniform.update($("tr input[type='checkbox']",tHead));
	}
	$("tbody input[type='checkbox']").change(tbodyChange);
	
	function enable_edit($elem, $cssClass) {
		var tVal = $elem.text();
		var vInput = $('<input type="text" class="' + $cssClass + '" />');
		vInput.val(tVal);
		$elem.data("old_data", tVal);
		$elem.empty();
		$elem.append(vInput);
	}
	function revert_edit($elem) {
		$elem.text($elem.data('old_data'));
	}
	function remove_edit($elem) {
		var tVal = $elem.find("input").val();
		$elem.text(tVal);
	}
	$(".btn_edit").click(function() {
		var pTr = $(this).parents("tr:eq(0)");
		enable_edit(pTr.find("td:eq(2)"), "span6");
		enable_edit(pTr.find("td:eq(3)"), "span12");
		enable_edit(pTr.find("td:eq(4)"), "span6");
		enable_edit(pTr.find("td:eq(5)"), "span12");
		enable_edit(pTr.find("td:eq(6)"), "span6");
		enable_edit(pTr.find("td:eq(7)"), "span12");
		enable_edit(pTr.find("td:eq(8)"), "span6");
		enable_edit(pTr.find("td:eq(9)"), "span12");
		$(this).siblings().show();
		$(this).hide();
	});

	$(".btn-inverse").click(function() {
		var pTr = $(this).parents("tr:eq(0)");
		revert_edit(pTr.find("td:eq(2)"));
		revert_edit(pTr.find("td:eq(3)"));
		revert_edit(pTr.find("td:eq(4)"));
		revert_edit(pTr.find("td:eq(5)"));
		revert_edit(pTr.find("td:eq(6)"));
		revert_edit(pTr.find("td:eq(7)"));
		revert_edit(pTr.find("td:eq(8)"));
		revert_edit(pTr.find("td:eq(9)"));
		$(this).parent().find("button:eq(2)").hide();
		$(this).prev().show();
		$(this).hide();
	});

	$(".btn-success").click(function() {
		var pTr = $(this).parents("tr:eq(0)");
		var btnObj = $(this);
		$.post("/portal/set_threshold_battery", {
			oid : pTr.attr("oid"),
			lower_value : pTr.find("td:eq(2)>input").val(),
			lower_msg : pTr.find("td:eq(3)>input").val(),
			upper_value : pTr.find("td:eq(4)>input").val(),
			upper_msg : pTr.find("td:eq(5)>input").val(),
			lower1_value : pTr.find("td:eq(6)>input").val(),
			lower1_msg : pTr.find("td:eq(7)>input").val(),
			upper1_value : pTr.find("td:eq(8)>input").val(),
			upper1_msg : pTr.find("td:eq(9)>input").val()
		}, function(data) {
			eval('var ret = ' + data);
			if (ret.ret == 0) {
				var n = noty({
					text: '<span>保存成功.</span>',
					type: 'success',
					layout: 'topCenter',
					closeWith: ['hover','click','button']
				});
				remove_edit(pTr.find("td:eq(2)"));
				remove_edit(pTr.find("td:eq(3)"));
				remove_edit(pTr.find("td:eq(4)"));
				remove_edit(pTr.find("td:eq(5)"));
				remove_edit(pTr.find("td:eq(6)"));
				remove_edit(pTr.find("td:eq(7)"));
				remove_edit(pTr.find("td:eq(8)"));
				remove_edit(pTr.find("td:eq(9)"));
				btnObj.parent().find("button:eq(0)").show();
				btnObj.parent().find("button:eq(1)").hide();
				btnObj.hide();
			}else{
				var n = noty({
					text: '<span>保存失败.</span>',
					type: 'fail',
					layout: 'topCenter',
					closeWith: ['hover','click','button']
				});
			}
		});
	});
	
	$("#tempEdit").click(function(){
		$("#settingForm").toggle();
	});
	
	$("#btnSave").click(function(){
		if($("#tempTable tbody input[type='checkbox']:checked").length == 0)
		{
			alert("请至少选择一个要设置的设备");
			return;
		}
		var oidArr = new Array();//aidi
		$("#tempTable tbody input[type='checkbox']:checked").each(function(){
			oidArr.push($(this).val());
		});
		$.post("/portal/batch_set_threshold_battery", {
			oidArr : oidArr.toString(),
			lower_value : $("#txtLower").val(),
			lower_msg : $("#txtLowerMsg").val(),
			upper_value : $("#txtUpper").val(),
			upper_msg : $("#txtUpperMsg").val(),
			lower1_value : $("#txtLower1").val(),
			lower1_msg : $("#txtLower1Msg").val(),
			upper1_value : $("#txtUpper1").val(),
			upper1_msg : $("#txtUpper1Msg").val()
		}, function(data) {
			eval('var ret = ' + data);
			if (ret.ret == 0) {
				var n = noty({
					text: '<span>保存成功。</span>',
					type: 'success',
					layout: 'topCenter',
					closeWith: ['hover','click','button']
				});
				setTimeout(function(){
					window.location.reload();
				},2000);
			}else{
				var n = noty({
					text: '<span>保存失败。</span>',
					type: 'fail',
					layout: 'topCenter',
					closeWith: ['hover','click','button']
				});
			}
		});
	});
});