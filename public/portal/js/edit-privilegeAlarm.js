$(document).ready(function(){
	   var gdevice=""
	function edit_click() {
		var pTr = $(this).parents("tr:eq(0)");
		var typeSel = $('<select style="width:auto;"><option value="">请选择</option><option value="lower">下限</option><option value="upper">上限</option><option value="value">阀值</option></select>');
		pTr.find("td:eq(1)").empty().append(typeSel);
		typeSel.val(pTr.data("t_type"));		
		enable_edit(pTr.find("td:eq(2)"), "span1");
		
		var levelSel = $('<select style="width:auto;"><option value="">请选择</option><option value="1">一级告警</option><option value="2">二级告警</option><option value="3">三级告警</option><option value="4">四级告警</option></select>');
		pTr.find("td:eq(3)").empty().append(levelSel);
		levelSel.val(pTr.data("t_level"));
			var t_signal_name = $('<select style="width:auto;" class="ss"><option selected="selected" >'+pTr.data("t_signal_name")+'</option></select>');
			pTr.find("td:eq(4)").empty().append(t_signal_name);
			for(i=0;i<gret.length;i++){	
				pTr.find(".ss").append("<option value="+gret[i].key+">"+gret[i].name+"</option>");
			}		
		 var t_signal_ids=$('<input type="text" id="ids" disabled="true" class="span1"/>');
		pTr.find("td:eq(5)").empty().append(t_signal_ids);
		$("#ids").val(pTr.data("t_signal_id"));
		$(".ss").change(function(){
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
		if(t_type == "lower")
		{
			pTr.find("td:eq(1)").empty().text("下限");
		}else if(t_type == "upper")
		{
			pTr.find("td:eq(1)").empty().text("上限");
		}else if(t_type == "value")
		{
			pTr.find("td:eq(1)").empty().text("阀值");
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
		
		
		$(this).parent().find("button:eq(2),button:eq(3)").hide();
		$(this).parent().find("button:eq(1)").show();
	}
	function save_click(){
		var pTr = $(this).parents("tr:eq(0)");
		//阀值类型
		if(pTr.find("td:eq(1) select").val() == "")
		{
			alert("请选择阀值类型");
			return;
		}
		if(pTr.find('td:eq(2) input').val() == "")
		{
			alert("请填写阀值");
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
		var t_signal_name = pTr.find("td:eq(4) select").val();
		var t_signal_id = pTr.find("td:eq(5) input").val();
		var t_msg = pTr.find("td:eq(6) input").val();
		var t_block = pTr.find("td:eq(7) input").prop("checked");
		pTr.data('t_type', t_type);
		pTr.data('t_value', t_value);
		pTr.data('t_level', t_level);
		for(i=0;i<gret.length;i++){
			
			if(gret[i].key == t_signal_name){
				pTr.data('t_signal_name', gret[i].name);
			}			
		}		
		pTr.data('t_signal_id', t_signal_id);
		pTr.data('t_msg', t_msg);
		pTr.data('t_block', t_block);
		
		if(t_type == "lower")
		{
			pTr.find("td:eq(1)").empty().text("下限");
		}else if(t_type == "upper")
		{
			pTr.find("td:eq(1)").empty().text("上限");
		}else if(t_type == "value")
		{
			pTr.find("td:eq(1)").empty().text("阀值");
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
		for(i=0;i<gret.length;i++){
			
			if(gret[i].key == t_signal_name){
				pTr.find("td:eq(4)").empty().text(gret[i].name);
			}			
		}	
		
		pTr.find("td:eq(5)").empty().text(t_signal_id);
		pTr.find("td:eq(6)").empty().text(t_msg);
		pTr.find("td:eq(7)").empty().text(t_block ? "屏蔽" : "未屏蔽");
		
		$(this).parent().find("button:eq(2),button:eq(3)").hide();		
		$(this).parent().find("button:eq(1)").show();
		
	}
//  $("#cityKey li").hover(function(){
//	 $(this).find("li").show();	  
//  },
//  function(){
//	  $(this).find("li").hide();
//  }
//  )
//  $("#countyKey li").hover(function(){
//	 $(this).find("li").show();	  
//  },
//  function(){
//	  $(this).find("li").hide();
//  }
//  )
//  $("#substationList li").hover(function(){
//	 $(this).find("li").show();	  
//  },
//  function(){
//	  $(this).find("li").hide();
//  }
//  )
//  $("#deviceList li").hover(function(){
//	 $(this).find("li").show();	  
//  },
//  function(){
//	  $(this).find("li").hide();
//  }
//  )
	$('#area-tree').jstree({'plugins':["checkbox"]});
  $("#btnSubmit").click(function(){
	  var areaTempArr = $('#area-tree').jstree().get_checked();
	  var areaArr = new Array();
		for(var i = 0 ; i < areaTempArr.length ; i++)
		{
			var substationId = Number(areaTempArr[i]);
			if(!isNaN(substationId))
				areaArr.push(substationId);
		}
		gdevice = areaArr;
//	  var obj=document.getElementsByName('deviceId'); 
//	  var s=''; 
//	  for(var i=0; i<obj.length; i++){
//		  if(obj[i].checked) s+=obj[i].value+',';
//		  } 
//	  gdevice = s;
//	  alert(gdevice);
	  $("#thresholdDialog").modal({
			 keyboard: true,
			 show	: true,
			 
		});
  })
	$("#btnAddRule").click(function(){
		$.get("/portal/Get_SignalNameId",{model: 'temperature'},function(ret){
		    gret=ret;
			var maxIndex = $("#tbRule tr").length + 1;
			//<td><label style="display:inline-block;"><input type="checkbox" />A类</label style="display:inline-block;">&nbsp;<label style="display:inline-block;"><input type="checkbox" />B类</label><br/><label style="display:inline-block;"><input type="checkbox" />C类</label>&nbsp;<label style="display:inline-block;"><input type="checkbox" />D类</label></td>\
			 
			var tTr = $('<tr><td>' + maxIndex + '</td><td><select style="width:auto;"><option value="">请选择</option><option value="lower">下限</option><option value="upper">上限</option><option value="value">阀值</option></select></td>\
						 <td><input type="text" class="span1" /></td>\
						 <td><select style="width:auto;"><option value="">请选择</option><option value="1">一级告警</option><option value="2">二级告警</option><option value="3">三级告警</option><option value="4">四级告警</option></select></td>\
						 <td><select style="width:auto;" class="selSignal"></select></td>\
						 <td><input type="text" readonly="true" class="span1"/></td>\
						 <td><input type="text" class="span1"/></td>\
						 <td><input type="checkbox"/></td>\
						 <td><div class="btn-toolbar row-action">\
							  <div class="btn-group">\
								<button class="btn btn-danger btn_del" title="删除"><i class="icon-remove"></i></button>\
	                            <button style="display:none" class="btn btn-info btn_edit" title="修改"><i class="icon-edit"></i></button>\
                 				 <button style="display:none" class="btn btn-inverse" title="取消修改"><i class=" icon-remove-sign"></i></button>\
               					<button  class="btn btn-success btn_save" title="保存"><i class=" icon-ok"></i></button>\
		                        </div>\
                        	</div>\
						</td></tr>');
			for(i=0;i<ret.length;i++){
				 tTr.find(".selSignal").append("<option value='" + ret[i].key + "'>"+ret[i].name+"</option");  
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
			$("#tbRule").append(tTr);
		});
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
			settingObj.block = $(this).data('t_block');
			settingArr.push(settingObj);
		}
	});
	if(settingArr.length == 0)
	{
		if(!confirm("你没有设置任何规则，请确认保存吗?"))
			return;
	}
	$.post("/portal/editPrTempAlarmJS", {
		gdevice:gdevice,
		setting : JSON.stringify(settingArr)}, function(data){
                         alert(data);
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
