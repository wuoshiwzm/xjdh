$(document).ready(function() {
	var dataIdArr = new Array();//fresh-air
	$('.rt-data').each(function() {
		dataIdArr.push($(this).attr('data_id'));
	});
	function refreshData() {
		$.get('/portal/refreshData', {
			dataIdArr : dataIdArr.toString(),
			model: 'datamate3000',
			access_token : typeof(accessToken) == "undefined" ? "":accessToken,
		}, function(ret) {
			for(var i = 0 ; i < ret.dataList.length ; i++)
			{
				var obj = ret.dataList[i];
				if(!obj.is_empty){
					$('#datamate3000-'+ obj.data_id + '-1').html(obj.room_temp + '°C');
					$('#datamate3000-'+ obj.data_id + '-2').html(obj.room_humid + '%');
					$('#datamate3000-'+ obj.data_id + '-3').html(obj.outdoor_temp + '°C');
					$('#datamate3000-'+ obj.data_id + '-4').html(obj.air_state == "1" ? "开机" : "关机");
					$('#datamate3000-'+ obj.data_id + '-5').html(obj.temperature + '°C');
					$('#datamate3000-'+ obj.data_id + '-6').html(obj.humidity + '%');
					$('#datamate3000-'+ obj.data_id + '-7').html(obj.set_temp + '°C');
					$('#datamate3000-'+ obj.data_id + '-8').html(obj.temp_pric);
					$('#datamate3000-'+ obj.data_id + '-9').html(obj.set_humid + '%');
					$('#datamate3000-'+ obj.data_id + '-10').html(obj.humid_pric);
					
					$('#datamate3000-'+ obj.data_id + '-11').html(obj.switch_status == "1" ? "开机":"关机");
					$('#datamate3000-'+ obj.data_id + '-12').html(obj.fan_status == "1" ? "开机":"关机");
					$('#datamate3000-'+ obj.data_id + '-13').html(obj.cool_status == "1" ? "开机":"关机");
					$('#datamate3000-'+ obj.data_id + '-14').html(obj.heat_status == "1" ? "开机":"关机");
					$('#datamate3000-'+ obj.data_id + '-15').html(obj.humid_status == "1" ? "开机":"关机");
					$('#datamate3000-'+ obj.data_id + '-16').html(obj.dehumid_status == "1" ? "开机":"关机");
					
					switch(obj.unit_status)
					{
						case "0":
							$('#datamate3000-'+ obj.data_id + '-17').html("关机");
							break;
						case "1":
							$('#datamate3000-'+ obj.data_id + '-17').html("运行");
							break;
						case "2":
							$('#datamate3000-'+ obj.data_id + '-17').html("待机");
							break;
						case "3":
							$('#datamate3000-'+ obj.data_id + '-17').html("锁定");
							break;					
					}
					switch(obj.unit_prop)
					{
						case "0":
							$('#datamate3000-'+ obj.data_id + '-18').html("主机");
							break;
						case "0":
							$('#datamate3000-'+ obj.data_id + '-18').html("背机");
							break;
						case "0":
							$('#datamate3000-'+ obj.data_id + '-18').html("从机");
							break;
					}
					$('#datamate3000-'+ obj.data_id + '-19').html(obj.high_press_lock == "1"?"已锁定":"未锁定");
					$('#datamate3000-'+ obj.data_id + '-20').html(obj.low_press_lock == "1"?"已锁定":"未锁定");					
					$('#datamate3000-'+ obj.data_id + '-21').html(obj.exhaust_lock == "1"?"已锁定":"未锁定");
					$('#datamate3000-'+ obj.data_id + '-22').html(obj.update_datetime);
					
					$('#datamate3000-'+ obj.data_id + '-23').html();//alert
					$('#datamate3000-'+ obj.data_id + '-24').html(obj.setting_temperature);
					$('#datamate3000-'+ obj.data_id + '-25').html(obj.setting_humidity + '%');
					
					$('#datamate3000-'+ obj.data_id + '-26').html(obj.high_temperature_alert + '°C');
					$('#datamate3000-'+ obj.data_id + '-27').html(obj.low_temperature_alert + '°C');
					$('#datamate3000-'+ obj.data_id + '-28').html(obj.high_humidity_alert + '%');
					$('#datamate3000-'+ obj.data_id + '-29').html(obj.low_humidity_alert + '%');
					$('#datamate3000-'+ obj.data_id + '-30').html(obj.update_datetime);
					
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(0)>td:eq(1)').text(obj.high_press_alarm == "1" ? "告警" : "正常");
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(0)>td:eq(3)').text(obj.low_press_alarm == "1" ? "告警" : "正常");
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(0)>td:eq(5)').text(obj.high_temp_alarm == "1" ? "告警" : "正常");
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(0)>td:eq(7)').text(obj.low_temp_alarm == "1" ? "告警" : "正常");
					
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(1)>td:eq(1)').text(obj.high_humid_alarm == "1" ? "告警" : "正常");
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(1)>td:eq(3)').text(obj.low_humid_alarm == "1" ? "告警" : "正常");
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(1)>td:eq(5)').text(obj.power_failer_alarm == "1" ? "告警" : "正常");
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(1)>td:eq(7)').text(obj.short_cycle_alarm == "1" ? "告警" : "正常");
					
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(2)>td:eq(1)').text(obj.custom_alarm1 == "1" ? "告警" : "正常");
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(2)>td:eq(3)').text(obj.custom_alarm2 == "1" ? "告警" : "正常");
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(2)>td:eq(5)').text(obj.main_fan_mainten_alarm == "1" ? "告警" : "正常");
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(2)>td:eq(7)').text(obj.humid_mainten_alarm == "1" ? "告警" : "正常");
					
					
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(3)>td:eq(1)').text(obj.filter_mainten_alarm == "1" ? "告警" : "正常");
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(3)>td:eq(3)').text(obj.com_failer_alarm == "1" ? "告警" : "正常");
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(3)>td:eq(5)').text(obj.coil_freeze_alarm == "1" ? "告警" : "正常");
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(3)>td:eq(7)').text(obj.humid_fault_alarm == "1" ? "告警" : "正常");
					
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(4)>td:eq(1)').text(obj.sensor_miss_alarm == "1" ? "告警" : "正常");
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(4)>td:eq(3)').text(obj.gas_temp_fault_alarm == "1" ? "告警" : "正常");
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(4)>td:eq(5)').text(obj.power_miss_fault_alarm == "1" ? "告警" : "正常");
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(4)>td:eq(7)').text(obj.power_undervol_alarm == "1" ? "告警" : "正常");
					
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(5)>td:eq(1)').text(obj.power_phase_alarm == "1" ? "告警" : "正常");
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(5)>td:eq(3)').text(obj.power_freq_alarm == "1" ? "告警" : "正常");
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(5)>td:eq(5)').text(obj.floor_overflow_alarm == "1" ? "告警" : "正常");
					$('#table-' + obj.data_id + '-alarm tbody tr:eq(5)>td:eq(7)').text(obj.save_card_failure == "1" ? "告警" : "正常");
				}else{
				}
			}
		});
	}
	refreshData();
	setInterval(refreshData, 20000);
});
