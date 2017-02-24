$(document).ready(function() {
	var dataIdArr10 = new Array();//liebert pex
	$('.rt-data').each(function() {
		if ($(this).attr('data_type') == 'liebert-pex' && dataIdArr10.indexOf($(this).attr('data_id')) == -1) {
			dataIdArr10.push($(this).attr('data_id'));
		}
	});
	function refreshData() {
		$.get('/portal/refreshData', {
			dataIdArr10 : dataIdArr10.toString(),
			model : model,
			access_token : typeof(accessToken) == "undefined" ? "" : accessToken
		}, function(ret) {	
			for(var i = 0 ; i < ret.libertPexList.length ; i++)
			{
				var obj = ret.libertPexList[i];
				if(obj.dynamic_config != false)
				{
					$('#tb-'+ obj.data_id +'-dc>tbody').empty();
					var dcList = JSON.parse(obj.dynamic_config);
					if(dcList == null){
						$('#tb-'+ obj.data_id +'-dc').hide();
					}else if(dcList.length == 0){
						$('#tb-'+ obj.data_id +'-dc').hide();
					}
					else{
						$('#tb-'+ obj.data_id +'-dc').show();
						for (var index = 0 ; index < dcList.length ; index++) {
							var dcObj = dcList[index];
							var levelStr = '正常';
							var cls = '';
							if(typeof(dcObj.level) != 'undefined'){
								cls = 'text-error lead';
	
								switch (dcObj.level) {
								case 1:
									levelStr = '一级告警';
									break;
								case 2:
									levelStr = '二级告警';
									break;
								case 3:
									levelStr = '三级告警';
								break;
								case 4:
									levelStr = '四级告警';
									break;
								default:
									cls = '';
									break;
								}
							}
							var trObj = $('<tr><td>'+ (index + 1) +'</td><td>'+ dcObj.name +'</td><td>'+ (typeof(dcObj.value) == 'undefined' ? '':dcObj.value)
									+'</td><td><span class="'+ cls +'">' + levelStr + '</span></td></tr>');
							$('#tb-'+ obj.data_id +'-dc>tbody').append(trObj);
						}					
					}
				}else{
					$('#tb-'+ obj.data_id +'-dc').hide();
				}
				
				$('#liebert-pex-' + obj.data_id + ' .status').html(obj.isEmpty ? '离线': '在线');
				$('#liebert-pex-' + obj.data_id + ' .update_time').html(obj.update_datetime);
				if(obj.isEmpty){
					$('#liebert-pex-' + obj.data_id + ' table:eq(1) tr').each(function(){
						$('span:eq(0)',this).addClass('text-error lead');
						$('span:eq(0)',this).html("暂无数据");
						$('span:eq(1)',this).html("无状态");
					});
					$('#liebert-pex-' + obj.data_id + ' table:eq(2) tr').each(function(){
						$('span:eq(0)',this).addClass('text-error lead');
						$('span:eq(0)',this).html("暂无数据");
						$('span:eq(1)',this).html("无状态");
					});
					continue;
				}else{
					$('#liebert-pex-' + obj.data_id + ' table:eq(1) tr td>span').attr('class','');
					$('#liebert-pex-' + obj.data_id + ' table:eq(2) tr td>span').attr('class','');
				}					
				
				for(var k = 0 ; k < obj.aList.length ; k++)
				{
					var aObj = obj.aList[k];
					$('#liebert-pex-' + obj.data_id + ' table:eq(1)>tbody>tr:eq('+ k +') td>span:eq(0)').html(aObj.val);
					var levelStr = '正常';
					var cls = '';
					if(typeof(aObj.alert) != 'undefined'){
						cls = 'text-error lead';
						switch (aObj.alert) {
						case 1:
							levelStr = '一级告警';
							break;
						case 2:
							levelStr = '二级告警';
							break;
						case 3:
							levelStr = '三级告警';
						break;
						case 4:
							levelStr = '四级告警';
							break;
						default:
							cls = '';
							break;
						}
					}
					$('#liebert-pex-' + obj.data_id + ' table:eq(1)>tbody>tr:eq('+ k +') td>span:eq(1)').html(levelStr);
					$('#liebert-pex-' + obj.data_id + ' table:eq(1)>tbody>tr:eq('+ k +') td>span:eq(1)').attr('class',cls);
				}
				
				for(var j = 0 ; j < obj.d1List.length ; j++)
				{
					var d1Obj = obj.d1List[j];
					var msg = null;
					var cls = '';
					switch(j)
					{
					case 2:
					case 3:
					case 4:
					case 5:
						msg = parseInt(d1Obj.val) ? '断开' : '关闭';
						break;
					case 6:
						msg = parseInt(d1Obj.val) ? '关闭' : '断开';
						break;
					case 71:
					case 72:
					case 73:
					case 74:
					case 75:
						msg = parseInt(d1Obj.val) ? '错误' : '正常';
						break;
					case 0:
					case 1:
					case 7:
					case 9:
					case 26:
					case 27:
					case 28:
					case 65:
					case 68:
					case 69:
					case 77:
					case 78:
					case 79:
						msg = '无效';
						break;
					default:
						msg = parseInt(d1Obj.val) ? '是' : '否';
						break;
					}
					cls = parseInt(d1Obj.val) ? 'text-error lead':'';
					msg += "&nbsp;&nbsp;&nbsp;&nbsp;（原始值:" + d1Obj.val +"）";
					$('#liebert-pex-' + obj.data_id + '-field' + j +' span:eq(0)').html(msg);
					$('#liebert-pex-' + obj.data_id + '-field' + j +' span:eq(0)').attr('class',cls);
					
					var levelStr = '正常';
					cls = '';
					if(typeof(d1Obj.alert) != 'undefined'){
						cls = 'text-error lead';
						switch (d1Obj.alert) {
						case 1:
							levelStr = '一级告警';
							break;
						case 2:
							levelStr = '二级告警';
							break;
						case 3:
							levelStr = '三级告警';
						break;
						case 4:
							levelStr = '四级告警';
							break;
						default:
							cls = '';
							break;
						}
					}
					
					$('#liebert-pex-' + obj.data_id + '-field' + j +' span:eq(1)').html(levelStr);
					$('#liebert-pex-' + obj.data_id + '-field' + j +' span:eq(1)').attr('class',cls);
				}
			}
		});
	}
	refreshData();
	setInterval(refreshData, 20000);
});
