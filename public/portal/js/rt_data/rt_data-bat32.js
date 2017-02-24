$(document).ready(function(){
	var dataIdArr2 = new Array();
	var dataIdArr3 = new Array();
	var dataIdArr4 = new Array();
	$('.rt-data').each(function() {
		if ($(this).attr('data_type') == 'bat24' && dataIdArr3.indexOf($(this).attr('data_id')) == -1) {
			dataIdArr3.push($(this).attr('data_id'));
		}else if ($(this).attr('data_type') == 'bat32' && dataIdArr4.indexOf($(this).attr('data_id')) == -1) {
			dataIdArr4.push($(this).attr('data_id'));
		}else if ($(this).attr("data_type") == "battery24voltage" && dataIdArr2.indexOf($(this).attr("data_id")) == -1){
			dataIdArr2.push($(this).attr("data_id"));
		}
	});

	var params = {};
	params['dataIdArr2'] = dataIdArr2.toString();
	params['dataIdArr3'] = dataIdArr3.toString();
	params['dataIdArr4'] = dataIdArr4.toString();
	params['model'] =  model;
	params['access_token'] =  typeof(accessToken) == "undefined" ? "":accessToken;

	function refreshData() {
		$.get('/portal/refreshData', params, function(ret) {
			var length = ret.batList.length;
			for(var i = 0 ; i < length ; i++)
			{
				var obj = ret.batList[i];
				$(' .group_v').html(obj.group_v +'V');
				$(' .update_datetime').html(obj.update_datetime);
				if(obj.group_i != undefined)
				{
					$('#device-' + obj.data_id + ' .group_i').html(obj.group_i +'A');
					$('#device-' + obj.data_id + ' .bat_temp').html(obj.temperature +'°C');

					for(var j = 0 ; j < obj.voltage.length ; j++)
					{
						$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+j +') td:eq(1)>span:eq(0)').html(obj.voltage[j] + 'V');
					}	
					$('#bat_pi-' + obj.data_id +' tbody').empty();
					if(obj.pi == null || obj.pi.length == 0){
						$('#bat_pi-' + obj.data_id +' tbody').html('<tr><td colspan="3">无</td></tr>');
					}else{
						for(var j = 0 ; j < obj.pi.length ; j++){
							var piObj = obj.pi[j];
							$('#bat_pi-' + obj.data_id +' tbody').append('<tr><td>'+ (j+1) +'</td><td>'+ piObj.label +'</td><td>'+ piObj.value +'V</td></tr>');
						}
					}
				}

				if(obj.dynamic_config != false)
				{
					$('#tb-'+ obj.data_id +'-dc>tbody').empty();
					var dcList = JSON.parse(obj.dynamic_config);
					if(dcList == null){
						$('#tb-'+ obj.data_id +'-dc').hide();
					}else{
						if(dcList.length == 0){
							$('#tb-'+ obj.data_id +'-dc').hide();
						}else
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
			}	
		});
	}
	refreshData();
	setInterval(refreshData, 20000);
})
