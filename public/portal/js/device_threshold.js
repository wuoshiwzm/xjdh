$(document).ready(function() {
	var signalNameId;
	$("table").tablesorter({headers: {0: { sorter: false}}});
	var selectObj = $('<select></select>');
	for ( var modelKey in modelList) {
		selectObj.append($("<option value='"+ modelKey +"'>"+ modelList[modelKey] +"</option>"));
	}
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
	$(".dv_btn_edit").click(function() {
		var pTr = $(this).parents("tr:eq(0)");
		var pTd = pTr.find("td:eq(2)");
		var selObj = selectObj.clone();
		selObj.val(pTd.attr('dev_type'));
		pTd.data("old_data", pTd.text());
		pTd.empty();
		pTd.append(selObj);

		var tVal = pTr.find("td:eq(3)").text() 
		var vInput= $('<div class="input-append span"><input type="text" value="'+ tVal +'"/><div class="btn-group">\
		<button class="btn btn-info btn-choose" type="button">选择数据变量<i class="icon-arrow-right"></i></button></div></div>');
		var tdObj = pTr.find("td:eq(3)");
		tdObj.data("old_data", tVal);
		tdObj.empty();
		tdObj.append(vInput);
		
		$(".btn-choose", pTr).click(function(){
			open_selectDataParamDlg(pTr)
		});
		
		enable_edit(pTr.find("td:eq(4)"), "span");
		$(this).siblings().show();
		$(this).hide();
	});

	function open_selectDataParamDlg($trObj)
	{
		$('#tbDataParam').empty();
		if(gDeviceThresholdParam[$("select", $trObj).val()] != undefined){
			var i = 1;
			var paramList = gDeviceThresholdParam[$("select", $trObj).val()]
			for ( var key in paramList) {
				var dpTr = $('<tr><td class="center">'+ (i++) +'</td><td class="center">'+ paramList[key] +'</td><td class="center">'+key+'</td><td class="center"><input type="radio"></td><tr>');
				$('#tbDataParam').append(dpTr);
			}
			$('input',$('#tbDataParam')).change(function(){
				$("input:eq(0)", $trObj).val($(this).parents('tr').find('td:eq(1)').html());
				$("input:eq(1)", $trObj).val($(this).parents('tr').find('td:eq(2)').html());
				$('#dataParamDialog').modal('hide');
			});
		}else{
			$('#tbDataParam').append('<tr><td colspan="4">没有选择选择项，请手动填写</td></tr>');
		}
		$('#dataParamDialog').modal('show');
	
	}
	
	$(".dv_btn-inverse").click(function() {
		var pTr = $(this).parents("tr:eq(0)");
		revert_edit(pTr.find("td:eq(1)"));
		revert_edit(pTr.find("td:eq(2)"));
		revert_edit(pTr.find("td:eq(3)"));
		revert_edit(pTr.find("td:eq(4)"));
		$(this).parent().find("button:eq(2)").hide();
		$(this).prev().show();
		$(this).hide();
	});
	
	$(".dv_btn_del").click(function(){
		var pTr = $(this).parents("tr:eq(0)");
		if(confirm("请确认删除该设备数据变量"))
		{
			$.post('/portal/del_device_var', {oid: pTr.attr("oid")}, function(data){
				eval('var ret = ' + data);
				if (ret.ret == 0) {
					var n = noty({
						text: '<span>删除成功。</span>',
						type: 'success',
						layout: 'topCenter',
						closeWith: ['hover','click','button']
					});
					pTr.remove();
				}else{
					var n = noty({
						text: '<span>删除失败。</span>',
						type: 'fail',
						layout: 'topCenter',
						closeWith: ['hover','click','button']
					});
				}
			});
		}
	});		
	function dv_save(){
		var pTr = $(this).parents("tr:eq(0)");
		var dev_type = $.trim(pTr.find("select").val());
		var var_label = $.trim(pTr.find("input:eq(0)").val());
		var var_name = $.trim(pTr.find("input:eq(1)").val());
		if(dev_type.length == 0)
		{
			alert("请选择设备类型");
			return;
		}
		if(var_label.length == 0)
		{
			alert("请输入数据变量标签");
			return;
		}
		if(var_name.length == 0)
		{
			alert("请输入数据变量");
			return;
		}
		var prid=0;
		if(aa==null){
			prid=0;
		}
		if(aa!=null){
       if(parkey!=null){
			prid=parkey;
		}else{
			alert("请设置分局");
			return;
		}
		}
		$.post("/portal/save_device_var", {
			oid : pTr.attr("oid"),
			dev_type : dev_type,
			var_label : var_label,
			var_name : var_name,
			prid:prid,
			selSubstation:selSubstation,
			selCity:selCity
		}, function(data) {
			//eval('var ret = ' + data);
			if (data == 0){
				var n = noty({
					text: '<span>保存成功。</span>',
					type: 'success',
					layout: 'topCenter',
					closeWith: ['hover','click','button']		
				});
				setTimeout("window.location.reload()",1000);
			}else{
				var n = noty({
					text: '<span>保存失败。</span>',
					type: 'fail',
					layout: 'topCenter',
					closeWith: ['hover','click','button']
				});
				
			}
		});
	}
	$(".dv_btn_save").click(dv_save);
	
	$("#btnAddDeviceVar").click(function(){
		var maxIndex = $("#tbDeviceVar tr").length + 1;
		var tTr = $('<tr oid="0"><td class="center">' + maxIndex + '</td><td></td><td>'+selectObj.prop("outerHTML")+'</td>\
				<td class="center"><div class="input-append span"><input type="text"/><div class="btn-group">\
				<button class="btn btn-info btn-choose" type="button">选择数据变量<i class="icon-arrow-right"></i></button></div></div></td>\
				<td class="center"><input type="text" class="span" /></td>\
						 <td class="center"></td><td class="center"><div class="btn-toolbar row-action">\
								  <div class="btn-group">\
										<button class="btn btn-danger dv_btn_del" title="删除"><i class="icon-remove"></i></button>\
			                            <button class="btn btn-success dv_btn_save" title="保存"><i class=" icon-ok"></i></button>\
				                        </div>\
                        </div></td></tr>');
		tr.data('city_code', $("#selCity").val());
		tr.data('county_code', $("#selCounty").val());
		tr.data('substation_id', $("#selSubstation").val());
		$(".dv_btn_del", tTr).click(function(){
			$(this).parents("tr:eq(0)").remove();
			var index = 1;
			$("#tbRule tr").each(function(){
				$(this).find("td:eq(0)").text(index++);
			});
		});
		
		$(".btn-choose", tTr).click(function(){
			open_selectDataParamDlg(tTr);			
		});
		$(".dv_btn_save", tTr).click(dv_save);
		
		$("#tbDeviceVar").append(tTr);
	});
	
	
	//导出
	
//	$(".dv_btn_export").click(function(){
//		var pTr = $(this).parents("tr:eq(0)");
//		var dev_type = $.trim(pTr.find("td:eq(1)").val());
//		var var_label = $.trim(pTr.find("td:eq(2)").val());
//		var var_name = $.trim(pTr.find("td:eq(3)").val());
//		var aexport = 1;
//		$.post("/portal/export_alarm", {aexport : aexport,dev_type : dev_type,var_label : var_label,var_name : var_name
//		},function(){
//			
//			var n = noty({
//				text: '<span>正在导出。</span>',
//				type: 'success',
//				layout: 'topCenter',
//				closeWith: ['hover','click','button']
//			});
//			
//		});
//	});
	
	
	//threshold related functions
	
	function enable_edit($elem, $cssClass) {
		var tVal = $elem.text();
		var vInput = $('<input type="text" class="' + $cssClass + '" />');
		vInput.val(tVal);
		$elem.data("old_data", tVal);
		$elem.empty();
		$elem.append(vInput);
	}
	
	function edit_click() {
		var pTr = $(this).parents("tr:eq(0)");
		var typeSel = $('<select style="width:auto;"><option value="">请选择</option><option value="lower">下限</option><option value="upper">上限</option><option value="value">阈值</option></select>');
		pTr.find("td:eq(1)").empty().append(typeSel);
		typeSel.val(pTr.data("t_type"));		
		enable_edit(pTr.find("td:eq(2)"), "span1");
		enable_edit(pTr.find("td:eq(8)"), "span1");
		
		var levelSel = $('<select style="width:auto;"><option value="">请选择</option><option value="1">一级告警</option><option value="2">二级告警</option><option value="3">三级告警</option><option value="4">四级告警</option></select>');
		pTr.find("td:eq(3)").empty().append(levelSel);
		levelSel.val(pTr.data("t_level"));
		var t_signal_name = $('<select style="width:auto;" class="ss"></select>');
		pTr.find("td:eq(4)").empty().append(t_signal_name);
		for(i=0;i<signalNameId.length;i++){	
			pTr.find(".ss").append("<option value="+signalNameId[i].key+">"+signalNameId[i].name+"</option>");
		}
		pTr.find(".ss").val(pTr.data("t_signal_id"));
		var t_signal_ids=$('<input type="text" id="ids" disabled="true" class="span1"/>');
		pTr.find("td:eq(5)").empty().append(t_signal_ids);
		$("#ids").val(pTr.data("t_signal_id"));
		pTr.find(".ss").change(function(){
			$("#ids").val($(this).val());
		})		
		enable_edit(pTr.find("td:eq(6)"), "span3");	

		
		var blockCB = $('<input type="checkbox" />');
		pTr.find("td:eq(7)").empty().append(blockCB);
		blockCB.prop("checked", pTr.data("t_block"));
		
		$(this).hide();
		$(this).parent().find("button:eq(2),button:eq(3)").show();
	}
	
	function reverse_click() {
		var pTr = $(this).parents("tr:eq(0)");
		
		var t_type = pTr.data("t_type");
		var t_value = pTr.data("t_value");
		var t_level = pTr.data("t_level");
		var t_msg = pTr.data("t_msg");
		var t_signal_name = pTr.data('t_signal_name');
		var t_signal_id = pTr.data("t_signal_id");
		var t_block = pTr.data("t_block");
		var t_time = pTr.data("t_time");
		
		if(t_type == "lower")
		{
			pTr.find("td:eq(1)").empty().text("下限");
		}else if(t_type == "upper")
		{
			pTr.find("td:eq(1)").empty().text("上限");
		}else if(t_type == "value")
		{
			pTr.find("td:eq(1)").empty().text("阈值");
		}
		
		pTr.find("td:eq(2)").empty().text(t_value);
		var levelStr;
		switch(t_level)
		{
		case "1":
			levelStr = "一级告警";
			break;
		case "2":
			levelStr = "二级告警";
			break;
		case "3":
			levelStr = "三级告警";
			break;
		case "4":
			levelStr = "四级告警";
			break;
		}
		pTr.find("td:eq(3)").empty().text(levelStr);
		
		pTr.find("td:eq(4)").empty().text(t_signal_name);
		pTr.find("td:eq(5)").empty().text(t_signal_id);
		
		pTr.find("td:eq(6)").empty().text(t_msg);		
		pTr.find("td:eq(7)").empty().text(t_block ? "屏蔽" : "未屏蔽");
		pTr.find("td:eq(8)").empty().text(t_time);
		
		
		$(this).parent().find("button:eq(2),button:eq(3)").hide();
		$(this).parent().find("button:eq(1)").show();
	}
	
	function save_click(){
		var pTr = $(this).parents("tr:eq(0)");
		//阈值类型
		if(pTr.find("td:eq(1) select").val() == "")
		{
			alert("请选择阈值类型");
			return;
		}
		if(pTr.find('td:eq(2) input').val() == "")
		{
			alert("请填写阈值");
			return;
		}
		if(pTr.find("td:eq(3) select").val() == "")
		{
			alert("请选择告警级别");
			return;
		}
		if(pTr.find("td:eq(4) select").val() == "")
		{
			alert("请填写信号名称");
			return;
		}
		if(pTr.find("td:eq(5) input").val() == "")
		{
			alert("请选择信号ID");
			return;
		}
		if(pTr.find("td:eq(6) input").val() == "")
		{
			alert("请填写告警文本");
			return;
		}
		var t_type = pTr.find("td:eq(1) select").val();
		var t_value = pTr.find('td:eq(2) input').val();
		var t_level = pTr.find("td:eq(3) select").val();
		var t_signal_name = pTr.find("td:eq(4) select>option:selected").text();
		var t_signal_id = pTr.find("td:eq(5) input").val();
		var t_msg = pTr.find("td:eq(6) input").val();
		var t_block = pTr.find("td:eq(7) input").prop("checked");
		var t_time = pTr.find('td:eq(8) input').val();
		//确定，每个阈值类型+告警级别，只能有一个规则
		var bDup = false;
		$("#tbRule tr").each(function(){
			if($(this).find("td:eq(1)").text() == pTr.find("td:eq(1) select>option:selected").text() 
					&& $(this).find("td:eq(3)").text() == pTr.find("td:eq(3) select>option:selected").text())
			{
				bDup = true;
				return false;
			}
		});
		if(bDup){
			alert("同一阈值类型和告警级别(比如\"上限\"+\"一级告警\")只能设置一条规则,请修改后重试");
			return false;
		}
		pTr.data('t_type', t_type);
		pTr.data('t_value', t_value);
		pTr.data('t_level', t_level);
		pTr.data('t_signal_name', t_signal_name);
		pTr.data('t_signal_id', t_signal_id);
		pTr.data('t_msg', t_msg);
		pTr.data('t_block', t_block);
		pTr.data('t_time', t_time);
		
		if(t_type == "lower")
		{
			pTr.find("td:eq(1)").empty().text("下限");
		}else if(t_type == "upper")
		{
			pTr.find("td:eq(1)").empty().text("上限");
		}else if(t_type == "value")
		{
			pTr.find("td:eq(1)").empty().text("阈值");
		}
		pTr.find("td:eq(2)").empty().text(t_value);
		var levelStr;
		switch(t_level)
		{
		case "1":
			levelStr = "一级告警";
			break;
		case "2":
			levelStr = "二级告警";
			break;
		case "3":
			levelStr = "三级告警";
			break;
		case "4":
			levelStr = "四级告警";
			break;
		}
		pTr.find("td:eq(3)").empty().text(levelStr);
		pTr.find("td:eq(4)").empty().text(t_signal_name);
		
		pTr.find("td:eq(5)").empty().text(t_signal_id);
		pTr.find("td:eq(6)").empty().text(t_msg);
		pTr.find("td:eq(7)").empty().text(t_block ? "屏蔽" : "未屏蔽");
		pTr.find("td:eq(8)").empty().text(t_time);
		
		$(this).parent().find("button:eq(2),button:eq(3)").hide();		
		$(this).parent().find("button:eq(1)").show();
		
	}
	

	$(".setThreshold").click(function(){
		gldev_type=$(this).parent().parent().find("td:eq(1)").text();
		$("#thresholdDialog").modal({
			 keyboard: true,
			 show	: true,			 
		});
		
		var model = $(this).parent().prev().prev().prev().attr("dev_type");
		model += " " + $(this).parent().prev().text();
		$.get('/portal/Get_SignalNameId', {model: model}, function(data){
			
                         signalNameId = data;
		});
		$("#thresholdDialog").data("oid", $(this).attr("oid"));
		$("#tbRule").empty();
		$.get("/portal/get_dv_threshold", {oid: $(this).attr("oid")}, function(data){
			eval('var ret = '  + data);
			if(ret.ret == 0)
			{
				if(ret.setting == undefined)
					return;
				for(var i =0; i < ret.setting.length; i++)
				{
					var pTr = $('<tr><td>' + (i+1) + '</td><td></td>\
							 <td></td>\
							 <td></td>\
							 <td></td>\
							 <td></td>\
							 <td></td>\
							 <td></td><td></td><td><div class="btn-toolbar row-action">\
									  <div class="btn-group">\
											<button class="btn btn-danger btn_del" title="删除"><i class="icon-remove"></i></button>\
				                            <button class="btn btn-info btn_edit" title="修改"><i class="icon-edit"></i></button>\
	                         				 <button style="display:none" class="btn btn-inverse" title="取消修改"><i class=" icon-remove-sign"></i></button>\
	                       					<button  style="display:none" class="btn btn-success btn_save" title="保存"><i class=" icon-ok"></i></button>\
					                        </div>\
	                        </div></td></tr>');
					$("#tbRule").append(pTr);
					$(".btn_del", pTr).click(function(){
						$(this).parents("tr:eq(0)").remove();
						var index = 1;
						$("#tbRule tr").each(function(){
							$(this).find("td:eq(0)").text(index++);
						});
					});
					$(".btn_edit", pTr).click(edit_click);
					$(".btn-inverse",pTr).click(reverse_click);
					$(".btn_save", pTr).click(save_click);
					
					var t_type = ret.setting[i].type;
					var t_value = ret.setting[i].value;
					var t_level = ret.setting[i].level;
					var t_signal_name = ret.setting[i].signal_name;
					var t_signal_id = ret.setting[i].signal_id;
					var t_msg = ret.setting[i].msg;
					var t_block = ret.setting[i].block;
					var t_time = ret.setting[i].timeout;
					
					pTr.data('t_type', t_type);
					pTr.data('t_value', t_value);
					pTr.data('t_level', t_level);
					pTr.data("t_signal_name", t_signal_name);
					pTr.data("t_signal_id", t_signal_id);
					pTr.data('t_msg', t_msg);
					pTr.data('t_block', t_block);
					pTr.data('t_time', t_time);
					
					if(t_type == "lower")
					{
						pTr.find("td:eq(1)").empty().text("下限");
					}else if(t_type == "upper")
					{
						pTr.find("td:eq(1)").empty().text("上限");
					}else if(t_type == "value")
					{
						pTr.find("td:eq(1)").empty().text("阈值");
					}
					pTr.find("td:eq(2)").empty().text(t_value);
					var levelStr;
					switch(t_level)
					{
					case "1":
						levelStr = "一级告警";
						break;
					case "2":
						levelStr = "二级告警";
						break;
					case "3":
						levelStr = "三级告警";
						break;
					case "4":
						levelStr = "四级告警";
						break;
					}
					pTr.find("td:eq(3)").empty().text(levelStr);
					pTr.find("td:eq(4)").empty().text(t_signal_name);
					pTr.find("td:eq(5)").empty().text(t_signal_id);
					pTr.find("td:eq(6)").empty().text(t_msg);
					pTr.find("td:eq(7)").empty().text(t_block ? "屏蔽" : "未屏蔽");					
					pTr.find("td:eq(8)").empty().text(t_time);

				}
			}else{
				alert(ret.msg);
			}
		});
	});
	
	
	
	$("#btnAddRule").click(function(){
			var maxIndex = $("#tbRule tr").length + 1;
			//<td><label style="display:inline-block;"><input type="checkbox" />A类</label style="display:inline-block;">&nbsp;<label style="display:inline-block;"><input type="checkbox" />B类</label><br/><label style="display:inline-block;"><input type="checkbox" />C类</label>&nbsp;<label style="display:inline-block;"><input type="checkbox" />D类</label></td>\
			 
			var tTr = $('<tr><td>' + maxIndex + '</td><td><select style="width:auto;"><option value="">请选择</option><option value="lower">下限</option><option value="upper">上限</option><option value="value">阈值</option></select></td>\
						 <td><input type="text" class="span1" /></td>\
						 <td><select style="width:auto;"><option value="">请选择</option><option value="1">一级告警</option><option value="2">二级告警</option><option value="3">三级告警</option><option value="4">四级告警</option></select></td>\
						 <td><select style="width:auto;" class="selSignal"></select></td>\
						 <td><input type="text" readonly="true" class="span1"/></td>\
						 <td><input type="text" class="span3"/></td>\
						 <td><input type="checkbox"/></td>\
					         <td><input type="text" class="span1"/></td>\
						 <td><div class="btn-toolbar row-action">\
							  <div class="btn-group">\
					<button class="btn btn-danger btn_del" title="删除"><i class="icon-remove"></i></button>\
                    <button style="display:none" class="btn btn-info btn_edit" title="修改"><i class="icon-edit"></i></button>\
     				 <button style="display:none" class="btn btn-inverse" title="取消修改"><i class=" icon-remove-sign"></i></button>\
   					<button  class="btn btn-success btn_save" title="保存"><i class=" icon-ok"></i></button>\
                    </div>\
            	</div>\
			 </td></tr>');
			for(i=0;i<signalNameId.length;i++){
				 tTr.find(".selSignal").append("<option value='" + signalNameId[i].key + "'>"+signalNameId[i].name+"</option");  
			}
			tTr.find(".selSignal").change(function(){
				$(this).parent().next().find("input").val($(this).val());
			}).trigger("change");
			$(".btn_del", tTr).click(function(){
				$(this).parents("tr:eq(0)").remove();
				var index = 1;
				$("#tbRule tr").each(function(){
					$(this).find("td:eq(0)").text(index++);
				});
			});
			$(".btn_edit", tTr).click(edit_click);
			$(".btn-inverse",tTr).click(reverse_click);
			$(".btn_save", tTr).click(save_click);		
			$("#tbRule").append(tTr);
	});
	
	$("#btn-ok-checks").click(function(){
			$("#thresholdDialog3").modal({
				 keyboard: true,
				 show	: true,
				 
			});		
	})
	$("#btn-ok-check").click(function(){
		var settingArr = new Array();
		$("#tbRule tr").each(function(){
			if($(this).data("t_type") != undefined)
			{
				var settingObj = {};
				settingObj.type = $(this).data("t_type");
				settingObj.value = $(this).data("t_value");
				settingObj.level = $(this).data("t_level");
				settingObj.signal_name = $(this).data('t_signal_name');
				settingObj.signal_id = $(this).data('t_signal_id');
				settingObj.msg = $(this).data('t_msg');
				settingObj.save = $(this).data('t_save');
				//settingObj.block = $(this).data('t_block');
				settingObj.timeout = $(this).data("t_time");
				settingArr.push(settingObj);
			}
		});
		if(settingArr.length == 0)
		{
			if(!confirm("你没有设置任何规则，请确认保存吗?"))
				return;
		}
		$.post("/portal/set_dv_threshold", {
			oid : $("#thresholdDialog").data("oid"),
			setting : JSON.stringify(settingArr)}, function(data){
				eval('var ret = ' + data);
				if (ret.ret == 0) {
					var n = noty({
						text: '<span>保存成功。</span>',
						type: 'success',
						layout: 'topCenter',
						closeWith: ['hover','click','button']
					});
				}else{
					var n = noty({
						text: '<span>保存失败。</span>',
						type: 'fail',
						layout: 'topCenter',
						closeWith: ['hover','click','button']
					});
				}
			});
		$('#thresholdDialog').modal('hide');
	});
});
