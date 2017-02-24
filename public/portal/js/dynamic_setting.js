$(document).ready(function() {
	var dc_id = 0;
	var data_id = 0;
	var radioObj = null;
	$('.rChoose').change(function(){
		radioObj = $(this);
		$.get('/portal/getDeviceSignal',{model:$(this).attr('dev_model')},function(signalList){
			$('#tbSignal tbody').empty();
			for(var i = 0 ; i < signalList.length ; i++){
				var signalObj = signalList[i];
				var trObj = $('<tr><td>'+ (i + 1)+'</td><td>'+ signalObj.name +'--'+ signalObj.key +'</td><td><input name="radio_signal" type="radio" signal_key="'+ signalObj.key +'" ></td></tr>');
				$('#tbSignal tbody').append(trObj);
			}

			$('#tbSignal input').change(function(){
				//$('#txtDcScript').val($('#txtDcScript').val() + '['+ radioObj.attr('data_id')+','+$(this).attr('signal_key') +']');
				$('#txtDcScript').insert({"text":'['+ radioObj.attr('data_id')+','+$(this).attr('signal_key') +']'});
			});
		});
	});
	$('.btn-op').click(function(){
		//$('#txtDcScript').val($('#txtDcScript').val() + $(this).text());
		$('#txtDcScript').insert({"text":$(this).text()});
	});
	$('#btn-addConfig,.btn-edit').click(function(){
		$('#dynamicSettingDlg').modal('show');
		dc_id = 0;
	});
	$('.btn-edit').click(function(){
		$('#dynamicSettingDlg').modal('show');
		dc_id = $(this).parent().attr('dc_id');
		$('#txtDcName').val($(this).parent().siblings().eq(1).text());
		$('#txtDcScript').val($(this).parent().siblings().eq(2).text());
	})
	
	$(".btn-del").click(function(){
		if(confirm("请确认删除此动态配置?"))
		{
			var pTr = $(this).parents("tr:eq(0)");
			$.post("/portal/deleteDynamicConfig", { dc_id:$(this).parent().attr('dc_id')}, function(ret){
				if(ret)
				{
					pTr.remove();
					var n = noty({
						text: '<span>删除成功。</span>',
						type: 'success',
						layout: 'topCenter',
						timeout : 1000,
						closeWith: ['hover','click','button']
					});
				}
			});
		}
	});
	$('#btn-save').click(function(){
		$.post('/portal/saveDynamicConfig',{dc_id:dc_id,data_id:$('#btn-addConfig').attr('data_id'),
			dc_name:$('#txtDcName').val(),dc_script:$('#txtDcScript').val()},
			function(ret){
			if(ret){
				$('#dynamicSettingDlg').modal('hide');
				setTimeout('window.location.reload()',500);
			}else{
				var n = noty({
					text: '<span>添加/修改失败，请重试.</span>',
					type: 'error',
					layout: 'topCenter',
					timeout : 1000,
					closeWith: ['hover','click','button']
				});
			}
		});
	});
	$('.btn-setalarm').click(function(){
		dc_id = $(this).parent().attr('dc_id');
		data_id = $(this).parent().attr("data_id");
		$('#dcSignalArea table').each(function(){
			$(this).hide();
		});
		$('#tbSignal-'+ dc_id).slideDown(1000);
		$('#btn-addAlarmRule,#btn-saveAlarmRule').show();
		$('#alarmSettingTitle').text('————' + $(this).parent().siblings().eq(1).text());
	});
	$('#btn-addAlarmRule').click(function(){
		var maxIndex = $('#tbSignal-'+ dc_id +">tbody>tr").length + 1;
		var tTr = $('<tr oid="0"><td class="center">' + maxIndex + '</td>\
				<td class="center"><select style="width:auto;"><option value="">请选择</option><option value="0">正常</option><option value="1">一级告警</option>\
				<option value="2">二级告警</option><option value="3">三级告警</option><option value="4">四级告警</option></select></td>\
				<td class="center"><input type="text" class="span"/></td>\
				<td class="center"><input type="text" class="span"/></td>\
				<td class="center"><select style="width:auto"><option value="">请选择</option><option value=">">&gt;</option><option value="<">&lt;</option><option value="=">=</option><option value=">=">&gt;=</option><option value="<=">&lt;=</option></select></td>\
				<td class="center"><input type="text" class="span"/></td>\
				<td class="center"><input type="text" class="span"/></td>\
				<td class="center"><input type="text" class="span"/></td>\
				<td class="center"><div class="btn-toolbar row-action">\
				  <div class="btn-group">\
						<button class="btn btn-info hide dv_btn_edit" data-original-title="修改"><i class="icon-edit"></i></button>\
		                <button class="btn btn-inverse hide dv_btn-inverse" data-original-title="取消"><i class=" icon-remove-sign"></i></button>\
		                <button class="btn btn-success dv_btn_save" data-original-title="保存"><i class=" icon-ok"></i></button>\
		                <button class="btn btn-danger dv_btn_del" title="删除"><i class="icon-remove"></i></button>\
                    </div>\
                </div></td></tr>');
		$(".dv_btn_del", tTr).click(function(){
			$(this).parents("tr:eq(0)").remove();
			var index = 1;
			$('#tbSignal-'+ dc_id +">tbody>tr").each(function(){
				$(this).find("td:eq(0)").text(index++);
			});
		});		
		$(".dv_btn_save", tTr).click(dv_save);
		$(".dv_btn_edit", tTr).click(edit_click);
		$(".dv_btn-inverse", tTr).click(reverse_click);
		
		$('#tbSignal-'+ dc_id +">tbody").append(tTr);
	
	});
	
	$(".dv_btn_edit").click(edit_click);
	$(".dv_btn-inverse").click(reverse_click);
	$(".dv_btn_save").click(dv_save);
	$(".dv_btn_del").click(function(){
		$(this).parents("tr:eq(0)").remove();
		var index = 1;
		$('#tbSignal-'+ dc_id +">tbody>tr").each(function(){
			$(this).find("td:eq(0)").text(index++);
		});
	});	
	
	function edit_click()
	{
		var pTr = $(this).parents("tr:eq(0)");
		var pTd = pTr.find("td:eq(1)");
		var levelSelect = $('<select style="width:auto;"><option value="">请选择</option><option value="0">正常</option><option value="1">一级告警</option>\
				<option value="2">二级告警</option><option value="3">三级告警</option><option value="4">四级告警</option></select>');
		levelSelect.val(pTd.attr('level'));
		pTd.data("old_data", pTd.attr('level'));
		pTd.empty().append(levelSelect);

		var pOpTd = pTr.find("td:eq(4)");
		var opSelect = $('<select style="width:auto"><option value="">请选择</option><option value=">">&gt;</option><option value="<">&lt;</option><option value="=">=</option><option value=">=">&gt;=</option><option value="<=">&lt;=</option></select>');
		opSelect.val(pOpTd.attr('op'));
		pOpTd.data("old_data", pOpTd.attr('op'));
		pOpTd.empty().append(opSelect);
		
		enable_edit(pTr.find("td:eq(2)"), "span");
		enable_edit(pTr.find("td:eq(3)"), "span");
		//enable_edit(pTr.find("td:eq(4)"), "span");
		enable_edit(pTr.find("td:eq(5)"), "span");
		enable_edit(pTr.find("td:eq(6)"), "span");
		enable_edit(pTr.find("td:eq(7)"), "span");
		
		pTr.data("t_level",pTd.attr('level'));
		pTr.data('t_signal_name',pTr.find('input:eq(0)').val());
		pTr.data("t_signal_id",pTr.find('input:eq(1)').val());
		pTr.data("t_msg",pTr.find('input:eq(3)').val());
		pTr.data("t_time",pTr.find('input:eq(4)').val());
		pTr.data("t_value",pTr.find('input:eq(2)').val());
		pTr.data("t_op",pOpTd.attr('op'));
		
		$(this).siblings().show();
		$(this).hide();
	
	}
	
	function reverse_click() {
		var pTr = $(this).parents("tr:eq(0)");		
		var t_level = pTr.data("t_level");
		var t_signal_name = pTr.data('t_signal_name');
		var t_signal_id = pTr.data("t_signal_id");
		var t_msg = pTr.data("t_msg");
		var t_time = pTr.data("t_time");
		var t_value = pTr.data("t_value");
		var t_op = pTr.data("t_op");
		
		var levelStr;
		switch(t_level)
		{
		case "0":
			levelStr = "正常";
			break;
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
		pTr.find("td:eq(1)").empty().text(levelStr);		
		pTr.find("td:eq(2)").empty().text(t_signal_name);
		pTr.find("td:eq(3)").empty().text(t_signal_id);
		pTr.find("td:eq(4)").empty().text(t_op);
		pTr.find("td:eq(5)").empty().text(t_value);
		pTr.find("td:eq(6)").empty().text(t_msg);
		pTr.find("td:eq(7)").empty().text(t_time);

		$(this).parent().find("button:eq(2),button:eq(1)").hide();
		$(this).parent().find("button:eq(0),button:eq(3)").show();
	}
	
	function enable_edit($elem, $cssClass) {
		var tVal = $elem.text();
		var vInput = $('<input type="text" class="' + $cssClass + '" />');
		vInput.val(tVal);
		$elem.data("old_data", tVal);
		$elem.empty();
		$elem.append(vInput);
	}
	function dv_save(){
		var pTr = $(this).parents("tr:eq(0)");
		var t_level = $.trim(pTr.find("select:eq(0)").val());
		var t_signal_name = $.trim(pTr.find("input:eq(0)").val());
		var t_signal_id = $.trim(pTr.find("input:eq(1)").val());
		var t_op = $.trim(pTr.find("select:eq(1)").val());
		var t_value = $.trim(pTr.find("input:eq(2)").val());
		var t_msg = $.trim(pTr.find("input:eq(3)").val());
		var t_time = $.trim(pTr.find("input:eq(4)").val());

		pTr.data("t_level",t_level);
		pTr.data('t_signal_name',t_signal_name);
		pTr.data("t_signal_id",t_signal_id);
		pTr.data("t_msg",t_msg);
		pTr.data("t_value",t_value);
		pTr.data("t_time",t_time);
		pTr.data("t_op",t_op);
		
		if(t_level.length == 0)
		{
			alert("请选择告警级别");
			return;
		}
		if(t_level > 0 && t_signal_name.length == 0)
		{
			alert("请输入信号名称");
			return;
		}
		if(t_level > 0 && t_signal_id.length == 0)
		{
			alert("请输入信号ID");
			return;
		}
		if(t_op.length == 0)
		{
			alert("请输入运算符号");
			return;
		}
		if(t_value.length == 0)
		{
			alert("请输入比较值");
			return;
		}
		if(t_msg.length == 0)
		{
			alert("请输入告警信息");
			return;
		}
		if(t_time.length == 0)
		{
			alert("请输入延时时间");
			return;
		}
		
		var levelStr;
		switch(t_level)
		{
		case "0":
			levelStr = "正常";
			break;
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
		pTr.find("td:eq(1)").attr('level',t_level);	
		pTr.find("td:eq(1)").empty().text(levelStr);		
		pTr.find("td:eq(2)").empty().text(t_signal_name);
		pTr.find("td:eq(3)").empty().text(t_signal_id);
		pTr.find("td:eq(4)").empty().text(t_op);
		pTr.find("td:eq(5)").empty().text(t_value);
		pTr.find("td:eq(6)").empty().text(t_msg);
		pTr.find("td:eq(7)").empty().text(t_time);
		$(this).parent().find("button:eq(2),button:eq(1)").hide();
		$(this).parent().find("button:eq(0),button:eq(3)").show();		
	}
	$('#btn-saveAlarmRule').click(function(){
		var configArr = new Array();
		$('#tbSignal-'+ dc_id +">tbody>tr").each(function(){
			var configObj = {};
			configObj.level = $.trim($(this).find("td:eq(1)").attr("level"));
			configObj.signal_name = $.trim($(this).find("td:eq(2)").text());
			configObj.signal_id = $.trim($(this).find("td:eq(3)").text());
			configObj.op = $.trim($(this).find("td:eq(4)").text());
			configObj.value = $.trim($(this).find("td:eq(5)").text());
			configObj.msg = $.trim($(this).find("td:eq(6)").text());
			configObj.time = $.trim($(this).find("td:eq(7)").text());
			configArr.push(configObj);
		});	
		if(configArr.length == 0)
		{
			if(!confirm("你没有设置任何规则，请确认保存吗?"))
				return;
		}
		$.post("/portal/saveDynamicConfigRule", {
			dc_id : dc_id,
			data_id : data_id,
			dc_config : JSON.stringify(configArr)}, 
			function(ret){
				if (ret) {
					var n = noty({
						text: '<span>保存成功。</span>',
						type: 'success',
						layout: 'topCenter',
						timeout : 1000,
						closeWith: ['hover','click','button']
					});
				}else{
					var n = noty({
						text: '<span>保存失败。</span>',
						type: 'fail',
						layout: 'topCenter',
						timeout : 1000,
						closeWith: ['hover','click','button']
					});
				}
		});
	});
	
});
