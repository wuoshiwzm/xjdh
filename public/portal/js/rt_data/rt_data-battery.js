$(document).ready(function(){
	var dataIdArr2 = new Array();
	var dataIdArr3 = new Array();
	var dataIdArr4 = new Array();
	$('.rt-data').each(function() {
		if ($(this).attr('data_type') == 'bat24' && dataIdArr3.indexOf($(this).attr('data_id')) == -1) {
			dataIdArr3.push($(this).attr('data_id'));
		}else if ($(this).attr('data_type') == 'bat32' && dataIdArr4.indexOf($(this).attr('data_id')) == -1) {
			dataIdArr4.push($(this).attr('data_id'));
		}else if ($(this).attr("data_type") == "battery24_voltage" && dataIdArr2.indexOf($(this).attr("data_id")) == -1){
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
				$('#device-'+ obj.data_id +' .group_v').html(obj.group_v +'V');
				$('#device-'+ obj.data_id +' .update_datetime').html(obj.update_datetime);
				if(obj.group_i != undefined)
				{	
					$('#device-'+ obj.data_id +' .group_i').html(obj.group_i +'A');
					$('#device-'+ obj.data_id +' .bat_temp').html(obj.temperature +'°C');
					if(No1){
					     var arr = No1.split(',');
									for(var q=0;q<arr.length;q++){
									  $('#bat_voltageNo1_'+ obj.data_id).find(' tbody>tr:eq('+q +') td:eq(1)>span:eq(0)').html(obj.voltage[arr[q]] + 'V');
									  $('#bat_voltageNo1_'+ obj.data_id).find(' tbody>tr:eq('+q +') td:eq(4)>span:eq(0)').html(obj.voltage[arr[q+1]] + 'V');
									  $('#bat_voltageNo1_'+ obj.data_id).find(' tbody>tr:eq('+q +') td:eq(7)>span:eq(0)').html(obj.voltage[arr[q]+2] + 'V');
									  $('#bat_voltageNo1_'+ obj.data_id).find(' tbody>tr:eq('+q +') td:eq(10)>span:eq(0)').html(obj.voltage[arr[q]+3] + 'V');								
									}
							}
					if(No2){
					     var arr = No2.split(',');
							for(var q=0;q<arr.length;q++){
							  $('#bat_voltageNo2_'+ obj.data_id).find(' tbody>tr:eq('+q +') td:eq(1)>span:eq(0)').html(obj.voltage[arr[q]] + 'V');
							  $('#bat_voltageNo2_'+ obj.data_id).find(' tbody>tr:eq('+q +') td:eq(4)>span:eq(0)').html(obj.voltage[arr[q+1]] + 'V');
							  $('#bat_voltageNo2_'+ obj.data_id).find(' tbody>tr:eq('+q +') td:eq(7)>span:eq(0)').html(obj.voltage[arr[q]+2] + 'V');
							  $('#bat_voltageNo2_'+ obj.data_id).find(' tbody>tr:eq('+q +') td:eq(10)>span:eq(0)').html(obj.voltage[arr[q]+3] + 'V');								
							}
						}
					if(!No1){
					for(var j = 0 ; j < obj.voltage.length ; j+=4)
					{
						if(j == 0){
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+j +') td:eq(1)>span:eq(0)').html(obj.voltage[j] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+j +') td:eq(4)>span:eq(0)').html(obj.voltage[j+1] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+j +') td:eq(7)>span:eq(0)').html(obj.voltage[j+2] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+j +') td:eq(10)>span:eq(0)').html(obj.voltage[j+3] + 'V');
						}
						else{
							var k = j - ((j / 4) * 3);
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+k +') td:eq(1)>span:eq(0)').html(obj.voltage[j] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+k +') td:eq(4)>span:eq(0)').html(obj.voltage[j+1] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+k +') td:eq(7)>span:eq(0)').html(obj.voltage[j+2] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+k +') td:eq(10)>span:eq(0)').html(obj.voltage[j+3] + 'V');
						}
					}
					}
					if( type == "44"){
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(1)>span:eq(0)').html(obj.voltage[0] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(4)>span:eq(0)').html(obj.voltage[1] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(7)>span:eq(0)').html(obj.voltage[2] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(10)>span:eq(0)').html(obj.voltage[3] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(1)>span:eq(0)').html(obj.voltage[6] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(4)>span:eq(0)').html(obj.voltage[7] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(7)>span:eq(0)').html(obj.voltage[8] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(10)>span:eq(0)').html(obj.voltage[9] + 'V');
							
							$('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(1)>span:eq(0)').html(obj.voltage[13] + 'V');
							$('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(4)>span:eq(0)').html(obj.voltage[14] + 'V');
							$('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(7)>span:eq(0)').html(obj.voltage[14] + 'V');
							$('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(10)>span:eq(0)').html(obj.voltage[16] + 'V');
							$('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(1)>span:eq(0)').html(obj.voltage[19] + 'V');
							$('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(4)>span:eq(0)').html(obj.voltage[20] + 'V');
							$('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(7)>span:eq(0)').html(obj.voltage[21] + 'V');
							$('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(10)>span:eq(0)').html(obj.voltage[22] + 'V');
					}
                                        if( type == "44i"){
						        $('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(1)>span:eq(0)').html(obj.voltage[0] + 'V');
						        $('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(4)>span:eq(0)').html(obj.voltage[1] + 'V');
						        $('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(7)>span:eq(0)').html(obj.voltage[2] + 'V');
						        $('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(10)>span:eq(0)').html(obj.voltage[3] + 'V');
						        $('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(1)>span:eq(0)').html(obj.voltage[6] + 'V');
						        $('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(4)>span:eq(0)').html(obj.voltage[7] + 'V');
						        $('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(7)>span:eq(0)').html(obj.voltage[8] + 'V');
						        $('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(10)>span:eq(0)').html(obj.voltage[9] + 'V');
						
						        $('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(1)>span:eq(0)').html(obj.voltage[12] + 'V');
						        $('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(4)>span:eq(0)').html(obj.voltage[13] + 'V');
						        $('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(7)>span:eq(0)').html(obj.voltage[14] + 'V');
						        $('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(10)>span:eq(0)').html(obj.voltage[15] + 'V');
						        $('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(1)>span:eq(0)').html(obj.voltage[18] + 'V');
						        $('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(4)>span:eq(0)').html(obj.voltage[19] + 'V');
						        $('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(7)>span:eq(0)').html(obj.voltage[20] + 'V');
						        $('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(10)>span:eq(0)').html(obj.voltage[21] + 'V');
				        }
					if( type == "11"){
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(1)>span:eq(0)').html(obj.voltage[0] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(4)>span:eq(0)').html(obj.voltage[1] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(7)>span:eq(0)').html(obj.voltage[2] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(10)>span:eq(0)').html(obj.voltage[3] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(1)>span:eq(0)').html(obj.voltage[4] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(4)>span:eq(0)').html(obj.voltage[5] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(7)>span:eq(0)').html(obj.voltage[6] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(10)>span:eq(0)').html(obj.voltage[7] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+2 +') td:eq(1)>span:eq(0)').html(obj.voltage[8] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+2 +') td:eq(4)>span:eq(0)').html(obj.voltage[9] + 'V');
							$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+2 +') td:eq(7)>span:eq(0)').html(obj.voltage[10] + 'V');
							
							$('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(1)>span:eq(0)').html(obj.voltage[13] + 'V');
							$('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(4)>span:eq(0)').html(obj.voltage[14] + 'V');
							$('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(7)>span:eq(0)').html(obj.voltage[15] + 'V');
							$('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+0 +') td:eq(10)>span:eq(0)').html(obj.voltage[16] + 'V');
							$('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(1)>span:eq(0)').html(obj.voltage[17] + 'V');
							$('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(4)>span:eq(0)').html(obj.voltage[18] + 'V');
							$('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(7)>span:eq(0)').html(obj.voltage[19] + 'V');
							$('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+1 +') td:eq(10)>span:eq(0)').html(obj.voltage[20] + 'V');
							$('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+2 +') td:eq(1)>span:eq(0)').html(obj.voltage[21] + 'V');
							$('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+2 +') td:eq(4)>span:eq(0)').html(obj.voltage[22] + 'V');
							$('#bat_voltage2_'+ obj.data_id).find(' tbody>tr:eq('+2 +') td:eq(7)>span:eq(0)').html(obj.voltage[23] + 'V');	
						
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
