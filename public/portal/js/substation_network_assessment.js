$(document).ready(function() {
	var to = false;
	$('#areaQuery').keyup(function () {
		if(to) { clearTimeout(to); }
		to = setTimeout(function () {
			var v = $('#areaQuery').val();
			$('#area-tree').jstree(true).search(v);
		}, 250);
	});
	$('#area-tree').jstree({
		  "plugins" : ["wholerow","search"],
		  'core' : {
				'data' : {
				    'url' : function (node) {
				      return '/portal/get_substation_tree';
				    },
				    'data' : function (node) {
				      return { 'id' : node.id };
				    }
				}
			}
	});
	
	$(".setting").click(function(){
		$("#settingDialog").modal({keyboard:true,modal:true});		
		var pTr = $(this).parents("tr:eq(0)");
		$("#settingDialog").data("id", pTr.attr("id"));
		$("#settingDialog").data("substation_id", pTr.attr("substation_id"));
		$('#network').empty();
		$.post("/portal/get_network_settings", {id:pTr.attr("id"),substation_id:pTr.attr("substation_id")},function(data){
			eval("var ret = " + data);
				for (var key in ret.txt) {				
					var tTr = $('<div class="control-group"><label class="control-label"></label><div class="controls"><input type="text" /></div></div>');
					$('#network').append(tTr); 
					for(var k in ret.array) {
					    if( k == key ){ 
						    tTr.find("input").val(ret.array[k]);
					    }
					}
					tTr.find("label").text(ret.txt[key]);
				}
				if(ret.config){
			       var pTr = $('<div class="control-group"><label class="control-label">计算公式</label>\
			       <div class="controls"><div>'+ret.formulaconfig+'</div></div>');
			       $('#network').append(pTr);
				}
				if(ret.haveconfig){
					if(!ret.config){
						 var pTr = $('<label">指标配置错误，请检查电源网络安全评估页面</label>');
						 $('#network').append(pTr);
					}
				}	
				if(!ret.config){
					 var pTr = $('<div class="text" style=" text-align:center;"><h4>未设置指标配置</h4></div>');
					 $('#network').append(pTr);
				}
		});
	});
	
	$("#btn-ok-check").click(function(){
		var varArray = [];
		$("#network").find("input").each(function(){
			varArray.push($(this).val());
		});
		$.post("/portal/saveNetWorkPi",{
			id:$("#settingDialog").data("id"),
			substation_id:$("#settingDialog").data("substation_id"),
			varArray:varArray
		}, function(data){
			eval('var ret = ' + data);
			if(ret)
			{
				var n = noty({
					text: '<span>设置成功。</span>',
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
					text: '<span>设置失败。</span>',
					type: 'fail',
					layout: 'topCenter',
					timeout : 1000,
					closeWith: ['hover','click','button']
				});
			}
			$("#settingDialog").modal('hide');	
		});
		
	});

	$('#area-tree').bind("activate_node.jstree", function (event,data) {
	  var substation_id = $('#area-tree').jstree().get_bottom_selected();
      substation_id = JSON.stringify(substation_id); 
 	  substation_id = substation_id.replace("[\"##",""); 
 	  substation_id = substation_id.replace("\"]",""); 
 	  substation_id = substation_id.replace("[\"",""); 
 	  window.location.href="/portal/substation_network_assessment/"+substation_id; 
	});

	
	
});