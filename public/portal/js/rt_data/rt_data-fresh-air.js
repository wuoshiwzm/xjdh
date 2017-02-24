$(document).ready(function() {
	$(".remote_open").click(function(){
		setTimeout(function(){
		var n = noty({
			text: '<span>远程开机成功</span>',
		type: 'success',
		layout: 'center',
		closeWith: ['hover','click','button'],
		timeout : 3000
		});
		},500);
	});
	$(".remote_close").click(function(){
		setTimeout(function(){
		var n = noty({
			text: '<span>远程关机成功</span>',
		type: 'success',
		layout: 'center',
		closeWith: ['hover','click','button'],
		timeout : 3000
		});
		},500);
	});
	var dataIdArr5 = new Array();//fresh-air
	$('.rt-data').each(function() {
		if ($(this).attr('data_type') == 'fresh-air' && dataIdArr5.indexOf($(this).attr('data_id')) == -1) {
			dataIdArr5.push($(this).attr('data_id'));
		}
	});
	function refreshData() {
		$.get('/portal/refreshData', {
			dataIdArr5 : dataIdArr5.toString(),
			model: model,
			access_token : typeof(accessToken) == "undefined" ? "":accessToken,
		}, function(ret) {
			for(var i = 0 ; i < ret.freshAirList.length ; i++)
			{
				var obj = ret.freshAirList[i];
				if(!obj.is_empty){
					$('#fresh-air-'+ obj.data_id + '-1').html(obj.temperature1 + '°C');
					$('#fresh-air-'+ obj.data_id + '-2').html(obj.temperature2 + '°C');
					$('#fresh-air-'+ obj.data_id + '-3').html(obj.temperature3 + '°C');
					$('#fresh-air-'+ obj.data_id + '-4').html(obj.temperature4 + '°C');
					$('#fresh-air-'+ obj.data_id + '-5').html(obj.temperature5 + '°C');
					$('#fresh-air-'+ obj.data_id + '-6').html(obj.humidity1 + '%');
					$('#fresh-air-'+ obj.data_id + '-7').html(obj.humidity2 + '%');
					$('#fresh-air-'+ obj.data_id + '-8').html(obj.humidity3 + '%');
					$('#fresh-air-'+ obj.data_id + '-9').html(obj.humidity4 + '%');
					$('#fresh-air-'+ obj.data_id + '-10').html(obj.humidity5 + '%');
					$('#fresh-air-'+ obj.data_id + '-11').html(obj.wind_temperature + '°C');
					$('#fresh-air-'+ obj.data_id + '-12').html(obj.wind_humidity + '%');
					$('#fresh-air-'+ obj.data_id + '-13').html(obj.outside_temperature + '°C');
					$('#fresh-air-'+ obj.data_id + '-14').html(obj.outside_humidity + '%');
					$('#fresh-air-'+ obj.data_id + '-15').html(obj.humidifier_current + 'A');
					$('#fresh-air-'+ obj.data_id + '-16').html(obj.average_temperature + '°C');
					$('#fresh-air-'+ obj.data_id + '-17').html(obj.average_humidity + '%');
					$('#fresh-air-'+ obj.data_id + '-18').html();//reserve_60_42_1
					$('#fresh-air-'+ obj.data_id + '-19').html();//reserve_60_42_1
					$('#fresh-air-'+ obj.data_id + '-20').html(obj.highest_temperature + '°C');
					
					$('#fresh-air-'+ obj.data_id + '-21').html(obj.runstate_pump);
					$('#fresh-air-'+ obj.data_id + '-22').html(obj.runstate_ac);
					$('#fresh-air-'+ obj.data_id + '-23').html();//alert
					$('#fresh-air-'+ obj.data_id + '-24').html(obj.setting_temperature);
					$('#fresh-air-'+ obj.data_id + '-25').html(obj.setting_humidity + '%');
					
					$('#fresh-air-'+ obj.data_id + '-26').html(obj.high_temperature_alert + '°C');
					$('#fresh-air-'+ obj.data_id + '-27').html(obj.low_temperature_alert + '°C');
					$('#fresh-air-'+ obj.data_id + '-28').html(obj.high_humidity_alert + '%');
					$('#fresh-air-'+ obj.data_id + '-29').html(obj.low_humidity_alert + '%');
					$('#fresh-air-'+ obj.data_id + '-30').html(obj.update_datetime);
					
				}else{
					$('#fresh-air-'+ obj.data_id + ' tr').each(function(){
						$(this).find('td:eq(2)').html('暂无数据');
					});
				}
				if(obj.dynamic_config != false)
				{
					$('#tb-'+ obj.data_id +'-dc>tbody').empty();
					var dcList = JSON.parse(obj.dynamic_config);
					if(dcList == null){
						$('#tb-'+ obj.data_id +'-dc').hide();
					}else{f
						if(dcList.length == 0)
							$('#tb-'+ obj.data_id +'-dc').hide();
						else
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
});
