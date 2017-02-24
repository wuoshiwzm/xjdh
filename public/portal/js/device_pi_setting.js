$(document).ready(function() {
	$("table").tablesorter({headers: {0: { sorter: false}}});
	
	function edit_pi()
	{
		var pTr = $(this).parents("tr:eq(0)");
		enable_edit(pTr.find("td:eq(1)"),'input');
		enable_edit(pTr.find("td:eq(2)"),'input');
		$(this).siblings().show();
		$(this).hide();
	}
	
	function revert_pi() {
		var pTr = $(this).parents("tr:eq(0)");		
		revert_edit(pTr.find("td:eq(1)"),'input');
		revert_edit(pTr.find("td:eq(2)"),'input');
		
		if(pTr.find("td:eq(1)>input").val().length == 0)
		{
			pTr.remove();
			return;
		}
		$(this).parent().find("button:eq(2)").show();
		$(this).parent().find("button:eq(1)").hide();
		$(this).hide();
	}
	
	function delete_pi(){
		var pTr = $(this).parents("tr:eq(0)");
		pTr.remove();
	}
	
	function save_pi()
	{
		var pTr = $(this).parents("tr:eq(0)");
		var piName = pTr.find("input:eq(0)").val();
		var piLabel = pTr.find("input:eq(1)").val();
		if(piName.length == 0)
		{
			alert("请填写性能指标变量名");
			return;
		}
		if(piLabel.length == 0)
		{
			alert("请填写性能指标显示标签");
			return;
		}
		piName = $.trim(piName);
		piLabel = $.trim(piLabel);
		var bDup = false;
		$("#piTable tr").each(function(){
			if($(this)[0] != pTr[0])
			{
				var oName = $(this).find("input:eq(0)").val();
				var oLabel = $(this).find("input:eq(1)").val();
				if(oName == piName)
				{
					bDup = true;
					alert("性能指标变量名不唯一，请修改");
					pTr.find("input:eq(0)").focus();
					return false;
				}else if(piLabel == oLabel)
				{
					bDup = true;
					alert("性能指标标签不唯一，请修改");
					pTr.find("input:eq(1)").focus();
					return false;
				}
			}
		});
		if(bDup)
			return;
		remove_edit(pTr.find("td:eq(1)"),'input');
		remove_edit(pTr.find("td:eq(2)"),'input');
		$(this).parent().find("button:eq(2)").show();
		$(this).parent().find("button:eq(0)").hide();
		$(this).hide();

	}
	
	function edit_alert()
	{
		var pTr = $(this).parents("tr:eq(0)");
		enable_edit(pTr.find("td:eq(1)"), 'input');
		enable_edit(pTr.find("td:eq(2)"),'input');
		enable_edit(pTr.find("td:eq(3)"), 'input');
		enable_edit(pTr.find("td:eq(4)"),'input');
		enable_edit(pTr.find("td:eq(5)"),'select');
		enable_edit(pTr.find("td:eq(6)"),'input');
		$(this).siblings().show();
		$(this).hide();
	}
	
	function revert_alert() {
		var pTr = $(this).parents("tr:eq(0)");
		revert_edit(pTr.find("td:eq(1)"), 'input');
		revert_edit(pTr.find("td:eq(2)"),'input');
		revert_edit(pTr.find("td:eq(3)"), 'input');
		revert_edit(pTr.find("td:eq(4)"),'input');
		revert_edit(pTr.find("td:eq(5)"),'select');
		revert_edit(pTr.find("td:eq(6)"),'input');
		if(pTr.find("td:eq(1)>input").val().length == 0)
		{
			pTr.remove();
			return;
		}
		$(this).parent().find("button:eq(2)").show();
		$(this).parent().find("button:eq(1)").hide();
		$(this).hide();
	}
	
	function delete_alert(){
		var pTr = $(this).parents("tr:eq(0)");
		pTr.remove();
	}
	
	function save_alert()
	{
		var pTr = $(this).parents("tr:eq(0)");
		var alertName = pTr.find("input:eq(0)").val();
		var alertLabel = pTr.find("input:eq(1)").val();
		var signalName = pTr.find("input:eq(2)").val();
		var signalId = pTr.find("input:eq(3)").val();
		var alertMsg = pTr.find("input:eq(4)").val();
		alertName = $.trim(alertName);
		alertLabel = $.trim(alertLabel);
		alertMsg = $.trim(alertMsg);
		signalName = $.trim(signalName);
		signalId = $.trim(signalId);
		if(alertName.length == 0)
		{
			alert("请填写告警变量名");
			return;
		}
		if(alertLabel.length == 0)
		{
			alert("请填写告警变量标签");
			return;
		}

		if(signalName.length == 0)
		{
			alert("请填写信号名称");
			return;
		}
		if(signalId.length == 0)
		{
			alert("请填写信号ID");
			return;
		}
		if(alertMsg.length == 0)
		{
			alert("请填写告警文本");
			return;
		}		
		var bDup = false;
		$("#alertTable tr").each(function(){
			if($(this)[0] != pTr[0])
			{
				var oName = $.trim($(this).find("input:eq(0)").val());
				var oLabel = $.trim($(this).find("input:eq(1)").val());
				if(oName == piName)
				{
					bDup = true;
					alert("告警变量名不唯一，请修改");
					pTr.find("input:eq(0)").focus();
					return false;
				}else if(piLabel == oLabel)
				{
					bDup = true;
					alert("告警变量标签不唯一，请修改");
					pTr.find("input:eq(1)").focus();
					return false;
				}
			}
		});
		if(bDup)
			return;
		remove_edit(pTr.find("td:eq(1)"),'input');
		remove_edit(pTr.find("td:eq(2)"),'input');
		remove_edit(pTr.find("td:eq(3)"),'input');
		remove_edit(pTr.find("td:eq(4)"),'input');
		remove_edit(pTr.find("td:eq(5)"),'select');
		remove_edit(pTr.find("td:eq(6)"),'input');
		
		$(this).parent().find("button:eq(2)").show();
		$(this).parent().find("button:eq(0)").hide();
		$(this).hide();

	}
	
	
	$("#addPi").click(function(){
		var pTr = $('<tr pid="0"><td></td><td><input type="text" name="piName[]" /></td><td><input type="text" name="piLabel[]" /></td>\
				<td>\
				<div class="btn-toolbar row-action">\
				  <div class="btn-group">\
				<button type="button" class="btn btn-inverse" data-original-title="取消"><i class=" icon-remove-sign"></i></button>\
 				  <button type="button" class="btn btn-success" data-original-title="保存"><i class=" icon-ok"></i></button>\
                <button type="button"  style="display:none"  class="btn btn-info btn_edit" title="修改"><i class="icon-edit"></i></button>\
                <button type="button" class="btn btn-danger" title="删除"><i class="icon-remove"></i></button>\
                </div>\
				</div></td></tr>');
		$("#piTable").append(pTr);
		pTr.find("td:eq(0)").text($("#piTable tr").length);
		
		pTr.find("select").change(function(){
			$(this).prev().val($(this).val());
		});		
		pTr.find(".btn_edit").click(edit_pi);
		pTr.find(".btn-inverse").click(revert_pi);
		pTr.find(".btn-danger").click(delete_pi);
		pTr.find(".btn-success").click(save_pi);		
		
	});
	
	$("#addAlert").click(function(){
		var pTr = $('<tr><td></td><td><input type="text" name="alertName[]" class="span" /></td><td><input type="text" name="alertLabel[]" class="span" /></td>\
				<td><input type="text" name="signalName[]" class="span" /></td><td><input type="text" name="signalId[]" class="span" /></td>\
				<td><input type="hidden" name="alertLevel[]" value="4" />\
				<select class="span"><option value="1">一级告警</option><option value="2">二级告警</option>\
				<option value="3">三级告警</option><option value="4" selected>四级告警</option></select></td>\
				<td><input type="text" name="alertMsg[]" class="span" /></td><td><div class="btn-toolbar row-action">\
				  <div class="btn-group">\
				<button type="button" class="btn btn-inverse" title="取消"><i class=" icon-remove-sign"></i></button>\
 				  <button type="button" class="btn btn-success" title="保存"><i class=" icon-ok"></i></button>\
                <button type="button"  style="display:none"  class="btn btn-info btn_edit" title="修改"><i class="icon-edit"></i></button>\
                <button type="button" class="btn btn-danger" title="删除"><i class="icon-remove"></i></button>\
                </div>\
				</div></td></tr>');
		$("#alertTable").append(pTr);
		pTr.find("td:eq(0)").text($("#alertTable tr").length);
		
		pTr.find("select").change(function(){
			$(this).prev().val($(this).val());
		});
		
		pTr.find(".btn_edit").click(edit_alert);
		pTr.find(".btn-inverse").click(revert_alert);
		pTr.find(".btn-danger").click(delete_alert);
		pTr.find(".btn-success").click(save_alert);
		
		
	});
	
	
	function enable_edit($elem, $ctrl) {
		var tVal = $elem.find($ctrl).val();
		if($ctrl == "select")
		{
			$elem.find($ctrl).removeAttr("disabled");
		}else{
			$elem.find($ctrl).removeAttr("readonly");
		}
		
		$elem.data("old_data", tVal);
	}
	function revert_edit($elem, $ctrl) {
		$elem.find($ctrl).val($elem.data('old_data'));
		if($ctrl == "select")
		{
			$elem.find($ctrl).attr("disabled","disabled");
		}else{
			$elem.find($ctrl).attr("readonly","readonly");
		}
		
	}
	function remove_edit($elem, $ctrl) {
		if($ctrl == "select")
		{
			$elem.find($ctrl).attr("disabled","disabled");
		}else{
			$elem.find($ctrl).attr("readonly","readonly");
		}
	}
	$(".btn_edit").click(edit_pi);

	$(".btn-inverse").click(revert_pi);

	$(".btn-danger").click(delete_pi);
	
	$(".btn-success").click(save_pi);

	$(".alert-btn_edit").click(edit_alert);
	$(".alert-btn-inverse").click(revert_alert);
	$(".alert-btn-danger").click(delete_alert);	
	$(".alert-btn-success").click(save_alert);

	
	$(".table-sortable tr select").change(function(){
		$(this).prev().val($(this).val());
	});
});