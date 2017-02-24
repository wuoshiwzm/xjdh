$(document).ready(function() {
	$('.settings').click(function(){
		var data_id = $(this).attr('data_id');
		window.open('/portal/dynamicSetting/'+ data_id);
	});
	var dataIdArr6 = new Array();
	var dataIdArr7 = new Array();
	var dataIdArr8 = new Array();
	var dataIdArr9 = new Array();
	var dataIdArr10 = new Array();
	$('.rt-data').each(function() {
		if (($(this).attr('data_type') == 'psma-ac' || $(this).attr('data_type') == 'zxdu-ac' ||$(this).attr('data_type') == 'm810g-ac' ||$(this).attr('data_type') == 'smu06c-ac') && dataIdArr6.indexOf($(this).attr('data_id')) == -1) {
			dataIdArr6.push($(this).attr('data_id'));
		}else if (($(this).attr('data_type') == 'psma-rc' || $(this).attr('data_type') == 'zxdu-rc' || $(this).attr('data_type') == 'm810g-rc' ||$(this).attr('data_type') == 'smu06c-rc') && dataIdArr7.indexOf($(this).attr('data_id')) == -1) {
			dataIdArr7.push($(this).attr('data_id'));
		}else if (($(this).attr('data_type') == 'psma-dc' || $(this).attr('data_type') == 'zxdu-dc' || $(this).attr('data_type') == 'm810g-dc' ||$(this).attr('data_type') == 'smu06c-dc') && dataIdArr8.indexOf($(this).attr('data_id')) == -1) {
			dataIdArr8.push($(this).attr('data_id'));
		}else if ($(this).attr('data_type') == 'dk04')
		{
			dataIdArr9.push($(this).attr("data_id"));
		}else if ($(this).attr('data_type') == 'psm-6')
		{
			dataIdArr10.push($(this).attr("data_id"));
		}
	});
	$('#tab-sps .nav-tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
	function refreshData() {
		$.get('/portal/refreshData', {
			dataIdArr6 : dataIdArr6.toString(),
			dataIdArr7 : dataIdArr7.toString(),
			dataIdArr8 : dataIdArr8.toString(),
			dataIdArr9 : dataIdArr9.toString(),
			dataIdArr10 : dataIdArr10.toString(),
			model : model,
			access_token : typeof(accessToken) == "undefined" ? "":accessToken
		}, function(ret) {	
			for(var i = 0 ; i < ret.spsAcList.length ; i++)
			{
				var obj = ret.spsAcList[i];
				$('#sps-ac-'+ obj.data_id +'-field0').html(obj.update_datetime);
				if(!obj.isEmpty)
				{
					if(obj.model == 'smu06c-ac')
					{
						$('#sps-ac-'+ obj.data_id +'-field1').html(obj.channelCount + '路');
						$('#sps-ac-'+ obj.data_id +'-field2').html(obj.ac_switch == 0x81 ? '自动' : '手动');
						$('#sps-ac-'+ obj.data_id +'-field3').html(obj.airlock_count + '个');
						$('#sps-ac-'+ obj.data_id +'-field4').html(obj.p + '个');
						$('#sps-ac-'+ obj.data_id +'-field5').html(obj.airlock_count + '个');
						$('#table-'+ obj.data_id + '-sps-ac-2>tbody').empty();
						$('#table-'+ obj.data_id + '-sps-ac-3>tbody').empty();					

						for(var j = 0 ; j < obj.channelList.length ; j++)
						{
							var channelObj = obj.channelList[j];
	
							var trObj = $('<tr></tr>');
							trObj.append('<td>交流通道'+ (j+1) +'</td>');
							trObj.append('<td>'+ channelObj.a +' V</td>');
							trObj.append('<td>'+ channelObj.b +' V</td>');
							trObj.append('<td>'+ channelObj.c +' V</td>');
							trObj.append('<td>'+ channelObj.f +' Hz</td>');
							$('#table-'+ obj.data_id + '-sps-ac-2>tbody').append(trObj);
							var trObj1 = $('<tr><td></td><td></td><td></td></tr>');
							trObj1.prepend('<td>'+ (j+1) +'</td>');
							trObj1.find('td:eq(1)').append(channelObj.alert_a ? '<span class="label label-important">告警</span> ' : '<span class="label label-success">正常</span>');
							trObj1.find('td:eq(2)').append(channelObj.alert_b ? '<span class="label label-important">告警</span> ' : '<span class="label label-success">正常</span>');
							trObj1.find('td:eq(3)').append(channelObj.alert_c ? '<span class="label label-important">告警</span> ' : '<span class="label label-success">正常</span>');
							for(var k = 0; k < channelObj.alert_mp.length ; k++ )
							{
								var tdObj = $('<td></td>');
								tdObj.append(parseInt(channelObj.alert_mp[k]) ? '<span class="label label-important">告警</span> ' : '<span class="label label-success">正常</span>');
								trObj1.append(tdObj);							
							}
							$('#table-'+ obj.data_id + '-sps-ac-3>tbody').append(trObj1);
						}						
					}else if(obj.model == 'zxdu-ac'){
						$('#sps-ac-'+ obj.data_id +'-field1').html(obj.ia + 'A');
						$('#sps-ac-'+ obj.data_id +'-field2').html(obj.ib + 'A');
						$('#sps-ac-'+ obj.data_id +'-field3').html(obj.ic + 'A');
						$('#sps-ac-'+ obj.data_id +'-field4').html(obj.channelCount + '路');
						$('#sps-ac-'+ obj.data_id +'-field5').html(obj.airlock_count + '个');
						
						$('#sps-ac-'+ obj.data_id +'-field6').html(obj.status_p);
						$('#sps-ac-'+ obj.data_id +'-field7').html(obj.airlock_status[0] ? '断开' : '闭合');
						$('#sps-ac-'+ obj.data_id +'-field8').html(obj.airlock_status[1] ? '断开' : '闭合');
						$('#sps-ac-'+ obj.data_id +'-field9').html(obj.airlock_status[2] ? '断开' : '闭合');
						$('#sps-ac-'+ obj.data_id +'-field10').html(obj.airlock_status[3] == 0 ? '市电1' : (obj.airlock_status[3] == 1 ? '市电2' : '电池'));
						
						$('#sps-ac-'+ obj.data_id +'-field11').html(obj.ia_alert + '个');
//						$('#sps-ac-'+ obj.data_id +'-field12').html('无检测');
//						$('#sps-ac-'+ obj.data_id +'-field13').html('无检测');
						$('#table-'+ obj.data_id + '-sps-ac-2>tbody').empty();
						$('#table-'+ obj.data_id + '-sps-ac-3>tbody').empty();					

						for(var j = 0 ; j < obj.channelList.length ; j++)
						{
							var channelObj = obj.channelList[j];

							var trObj = $('<tr></tr>');
							trObj.append('<td>交流通道'+ (j+1) +'</td>');
							trObj.append('<td>'+ channelObj.va +' V</td>');
							trObj.append('<td>'+ channelObj.vb +' V</td>');
							trObj.append('<td>'+ channelObj.vc +' V</td>');
							trObj.append('<td>'+ channelObj.f +' Hz</td>');
//							trObj.append('<td>'+ channelObj.m + ' 个</td>');
							trObj.append('<td>'+ channelObj.alert_m + ' 个</td>');
							$('#table-'+ obj.data_id + '-sps-ac-2>tbody').append(trObj);
							var trObj1 = $('<tr><td></td><td></td><td></td></tr>');
							trObj1.prepend('<td>'+ (j+1) +'</td>');
							trObj1.find('td:eq(1)').append(channelObj.alert_a ? '<span class="label label-important">告警</span> ' : '<span class="label label-success">正常</span>');
							trObj1.find('td:eq(2)').append(channelObj.alert_b ? '<span class="label label-important">告警</span> ' : '<span class="label label-success">正常</span>');
							trObj1.find('td:eq(3)').append(channelObj.alert_c ? '<span class="label label-important">告警</span> ' : '<span class="label label-success">正常</span>');
//							trObj1.find('td:eq(4)').append(channelObj.alert_f ? '<span class="label label-important">告警</span> ' : '<span class="label label-success">正常</span>');
							for(var k = 0; k < channelObj.am.length ; k++ )
							{
								var tdObj = $('<td></td>');
								tdObj.append(parseInt(channelObj.am[k]) ? '<span class="label label-important">告警</span> ' : '<span class="label label-success">正常</span>');
								trObj1.append(tdObj);							
							}
							$('#table-'+ obj.data_id + '-sps-ac-3>tbody').append(trObj1);
						}
					}else{
					$('#sps-ac-'+ obj.data_id +'-field1').html(obj.ia + 'A');
					$('#sps-ac-'+ obj.data_id +'-field2').html(obj.ib + 'A');
					$('#sps-ac-'+ obj.data_id +'-field3').html(obj.ic + 'A');
					$('#sps-ac-'+ obj.data_id +'-field4').html(obj.channelCount + '路');
					$('#sps-ac-'+ obj.data_id +'-field5').html(obj.ac_switch ? '自动' : '手动');
					$('#sps-ac-'+ obj.data_id +'-field6').html(obj.light_switch ? '开' :'关');
					$('#sps-ac-'+ obj.data_id +'-field7').html('第'+ obj.working_line + '路');
					$('#sps-ac-'+ obj.data_id +'-field8').html(obj.ia_alert + '个');
					$('#sps-ac-'+ obj.data_id +'-field9').html(obj.ib_alert + '个');
					$('#sps-ac-'+ obj.data_id +'-field10').html(obj.ic_alert + '个');
					$('#table-'+ obj.data_id + '-sps-ac-2>tbody').empty();
					$('#table-'+ obj.data_id + '-sps-ac-3>tbody').empty();					

					for(var j = 0 ; j < obj.channelList.length ; j++)
					{
						var channelObj = obj.channelList[j];
						
						var trObj = $('<tr></tr>');
						trObj.append('<td>交流通道'+ (j+1) +'</td>');
						trObj.append('<td>'+ channelObj.a +' V</td>');
						trObj.append('<td>'+ channelObj.b +' V</td>');
						trObj.append('<td>'+ channelObj.c +' V</td>');
						trObj.append('<td>'+ channelObj.f +' Hz</td>');
						$('#table-'+ obj.data_id + '-sps-ac-2>tbody').append(trObj);
						var trObj1 = $('<tr><td></td><td></td><td></td><td></td></tr>');
						trObj1.prepend('<td>'+ (j+1) +'</td>');
						trObj1.find('td:eq(1)').append(channelObj.alert_a ? '<span class="label label-important">告警</span> ' : '<span class="label label-success">正常</span>');
						trObj1.find('td:eq(2)').append(channelObj.alert_b ? '<span class="label label-important">告警</span> ' : '<span class="label label-success">正常</span>');
						trObj1.find('td:eq(3)').append(channelObj.alert_c ? '<span class="label label-important">告警</span> ' : '<span class="label label-success">正常</span>');
						trObj1.find('td:eq(4)').append(channelObj.alert_f ? '<span class="label label-important">告警</span> ' : '<span class="label label-success">正常</span>');
						for(var k = 0; k < channelObj.p.length ; k++ )
						{
							var tdObj = $('<td></td>');
							tdObj.append(parseInt(channelObj.p[k]) ? '<span class="label label-important">告警</span> ' : '<span class="label label-success">正常</span>');
							trObj1.append(tdObj);							
						}
						$('#table-'+ obj.data_id + '-sps-ac-3>tbody').append(trObj1);
						}
					}
				}
				setDcTable($('#table-'+ obj.data_id +'-dc'), obj.dynamic_config);
			}
			
			for(var i = 0 ; i < ret.spsRcList.length ; i++)
			{
				var obj = ret.spsRcList[i];
				$('#sps-rc-'+ obj.data_id +'-field0').html(obj.update_datetime);
				if(!obj.isEmpty)
				{
					$('#sps-rc-'+ obj.data_id +'-field1').html(obj.out_v + 'V');
					$('#sps-rc-'+ obj.data_id +'-field2').html(obj.channelCount + '路');
					$('#table-'+ obj.data_id + '-sps-rc-2>tbody').empty();
					$('#table-'+ obj.data_id + '-sps-rc-3>tbody').empty();
					for(var j = 0 ; j < obj.channelList.length ; j++)
					{
						var channelObj = obj.channelList[j];
						if(obj.model == 'psma-rc'){
							var trObj = $('<tr></tr>');
							trObj.append('<td>'+ (j+1) +'</td>');
							trObj.append('<td>'+ channelObj.out_i +' A</td>');
							trObj.append('<td>'+ channelObj.p_temperature +'°C</td>');
							trObj.append('<td>'+ channelObj.p_limiting +'%</td>');
							trObj.append('<td>'+ channelObj.p_out_v +'V</td>');
							trObj.append('<td>'+ channelObj.p_out_v_limiting +'%</td>');
							trObj.append('<td>'+ (channelObj.shutdown ? '关闭' : '开启') +'</td>');
							trObj.append('<td>'+ (channelObj.i_limit ? '不限流' : '限流') +'</td>');
							trObj.append('<td>'+ (channelObj.charge == 0 ? '浮充' : (channelObj.charge == 1 ? '均充' :'测试')) +'</td>');
							trObj.append('<td>'+ (channelObj.auto_manual == 0 ? '自动' : '手动') +'</td>');
							$('#table-'+ obj.data_id + '-sps-rc-2>tbody').append(trObj);
							var trObj1 = $('<tr></tr>');
							trObj1.append('<td>'+ (j+1) +'</td>');
							trObj1.append('<td>'+ channelObj.fault +'个</td>');
							trObj1.append(channelObj.p[0] ? '<td><span class="label label-important">告警</span></td>' : '<td><span class="label label-success">正常</span></tb>');
							trObj1.append(channelObj.p[1] ? '<td><span class="label label-important">告警</span></td>' : '<td><span class="label label-success">正常</span></td>');
							trObj1.append(channelObj.p[2] ? '<td><span class="label label-important">告警</span></td>' : '<td><span class="label label-success">正常</span></td>');
							trObj1.append(channelObj.p[3] == 226 ? '<td><span class="label label-important">模块通讯中断</span></td>' : '<td><span class="label label-success">正常</span></td>');
							$('#table-'+ obj.data_id + '-sps-rc-3>tbody').append(trObj1);
						}else if(obj.model == 'm810g-rc'){
							var trObj = $('<tr></tr>');
							trObj.append('<td>'+ (j+1) +'</td>');
							trObj.append('<td>'+ channelObj.out_i +' A</td>');
							trObj.append('<td>'+ channelObj.p_temperature +'°C</td>');
							trObj.append('<td>'+ channelObj.p_limiting +'%</td>');
							trObj.append('<td>'+ channelObj.p_out_v +'V</td>');
							trObj.append('<td>'+ channelObj.p_ab_v +'V</td>');
							trObj.append('<td>'+ channelObj.p_bc_v +'V</td>');
							trObj.append('<td>'+ channelObj.p_ca_v +'V</td>');
							trObj.append('<td>'+ channelObj.p_no +'%</td>');
							trObj.append('<td>'+ (channelObj.shutdown ? '关闭' : '开启') +'</td>');
							trObj.append('<td>'+ (channelObj.i_limit ? '不限流' : '限流') +'</td>');
							if(channelObj.charge == 3){
								trObj.append('<td>交流停电</td>');
							}else{
								trObj.append('<td>'+ (channelObj.charge == 0 ? '浮充' : (channelObj.charge == 1 ? '均充' :'测试'))+'</td>');
							}
							$('#table-'+ obj.data_id + '-sps-rc-2>tbody').append(trObj);
							var trObj1 = $('<tr></tr>');
							trObj1.append('<td>'+ (j+1) +'</td>');
							for(var k = 0 ; k < channelObj.status_p.length ;k++){
								trObj1.append(channelObj.status_p[k] ? '<td><span class="label label-important">异常</span></td>' : '<td><span class="label label-success">正常</span></tb>');	
							}
							trObj1.append('<td>'+ channelObj.fault +'个</td>');
							trObj1.append(channelObj.p[0] ? '<td><span class="label label-important">告警</span></td>' : '<td><span class="label label-success">正常</span></tb>');
							trObj1.append(channelObj.p[1] ? '<td><span class="label label-important">告警</span></td>' : '<td><span class="label label-success">正常</span></td>');
							trObj1.append(channelObj.p[2] ? '<td><span class="label label-important">告警</span></td>' : '<td><span class="label label-success">正常</span></td>');
							trObj1.append(channelObj.p[3] == 226 ? '<td><span class="label label-important">模块通讯中断</span></td>' : '<td><span class="label label-success">正常</span></td>');
							$('#table-'+ obj.data_id + '-sps-rc-3>tbody').append(trObj1);
						}else if(obj.model == 'smu06c-rc'){
							var trObj = $('<tr></tr>');
							trObj.append('<td>'+ (j+1) +'</td>');
							trObj.append('<td>'+ channelObj.out_i +' A</td>');
							trObj.append('<td>'+ channelObj.p_limiting +'%</td>');
							trObj.append('<td>'+ channelObj.p_out_v +'V</td>');
							trObj.append('<td>'+ channelObj.p_ab_v +'V</td>');
							trObj.append('<td>'+ channelObj.p_bc_v +'V</td>');
							trObj.append('<td>'+ channelObj.p_ca_v +'V</td>');
							trObj.append('<td>'+ (channelObj.shutdown ? '关闭' : '开启') +'</td>');
							trObj.append('<td>'+ (channelObj.i_limit ? '不限流' : '限流') +'</td>');
							trObj.append('<td>'+ (channelObj.charge == 0 ? '浮充' : (channelObj.charge == 1 ? '均充' :'测试')) +'</td>');
							$('#table-'+ obj.data_id + '-sps-rc-2>tbody').append(trObj);
							var trObj1 = $('<tr></tr>');
							trObj1.append('<td>'+ (j+1) +'</td>');
							trObj1.append('<td>'+ (channelObj.status_p[0] == 0 ? '运行' : '禁止') +'</td>');
							trObj1.append('<td>'+ (channelObj.status_p[1] == 0 ? '无顺序起机' : '顺序起机') +'</td>');
							trObj1.append('<td>'+ channelObj.fault +'个</td>');
							trObj1.append(channelObj.p[0] == 226 ? '<td><span class="label label-important">模块通讯中断</span></td>' : '<td><span class="label label-success">正常</span></td>');
							trObj1.append(channelObj.p[1] ? '<td><span class="label label-important">告警</span></td>' : '<td><span class="label label-success">正常</span></td>');
							$('#table-'+ obj.data_id + '-sps-rc-3>tbody').append(trObj1);
						}if(obj.model == 'zxdu-rc'){
							var trObj = $('<tr></tr>');
							trObj.append('<td>'+ (j+1) +'</td>');
							trObj.append('<td>'+ channelObj.out_i +' A</td>');
							trObj.append('<td>'+ (channelObj.status_p ? '在位' : '非在位') + '</td>');
//							trObj.append('<td>'+ channelObj.out_wrong +' </td>');
							trObj.append('<td>'+ (channelObj.fault ? '故障' : '正常') +'</td>');
							trObj.append('<td>'+ (channelObj.shutdown ? '开启' : '关闭') +'</td>');
							trObj.append('<td>'+ (channelObj.i_limit ? '不限流' : '限流') +'</td>');
							trObj.append('<td>'+ (channelObj.charge == 0 ? '浮充' : (channelObj.charge == 1 ? '均充' :'测试'))+'</td>');
							
							$('#table-'+ obj.data_id + '-sps-rc-2>tbody').append(trObj);
						}
					}
				}
				setDcTable($('#table-'+ obj.data_id +'-dc'), obj.dynamic_config);
			}
			for(var i = 0 ; i < ret.spsDcList.length ; i++)
			{
				var obj = ret.spsDcList[i];
				$('#sps-dc-'+ obj.data_id +'-field0').html(obj.update_datetime);
				if(!obj.isEmpty)
				{
					if(obj.model == 'smu06c-dc')
					{
						$('#sps-dc-'+ obj.data_id +'-field1').html(obj.out_v_high + 'V');
						$('#sps-dc-'+ obj.data_id +'-field2').html(obj.out_v_low + 'V');
						$('#sps-dc-'+ obj.data_id +'-field3').html(obj.screen_battery_packs[0] + '组');
						$('#sps-dc-'+ obj.data_id +'-field4').html(obj.param_num + '个');
						$('#sps-dc-'+ obj.data_id +'-field5').html(obj.timed_test_interval + '天');
						$('#sps-dc-'+ obj.data_id +'-field6').html(obj.battery_testend_time + '分钟');
						$('#sps-dc-'+ obj.data_id +'-field7').html(obj.timed_average_interval + '天');
						
						for(var i = 0 ; i < 9 ; i++)
						{
							$('#sps-dc-alert'+ obj.data_id +'-field' + i).html(obj.param[i]);
						}
						
						for(var j = 9 ; j < obj.param.length ; j++)
						{
							$('#sps-dc-battery'+ obj.data_id +'-field' + (j-9)).html(obj.param[j]);
						}
					}if(obj.model == 'zxdu-dc'){
						$('#sps-dc-'+ obj.data_id +'-field1').html(obj.dc_m + '个');
						$('#sps-dc-'+ obj.data_id +'-field2').html(obj.v + 'V');
						$('#sps-dc-'+ obj.data_id +'-field3').html(obj.i + 'A');
						$('#sps-dc-'+ obj.data_id +'-field4').html(obj.m );
						$('#sps-dc-'+ obj.data_id +'-field5').html(1<= obj.m ? obj.dc_i[0]+ 'A':'设备未提供');
						$('#sps-dc-'+ obj.data_id +'-field6').html(2<= obj.m ? obj.dc_i[1]+ 'A':'设备未提供');
						$('#sps-dc-'+ obj.data_id +'-field7').html(3<= obj.m ? obj.dc_i[2]+ 'A':'设备未提供');
						$('#sps-dc-'+ obj.data_id +'-field8').html(4<= obj.m ? obj.dc_i[3]+ 'A':'设备未提供');
						$('#sps-dc-'+ obj.data_id +'-field9').html(obj.p_count + '个');
						$('#table-'+ obj.data_id + '-sps-dc-2>tbody').empty();	
						$('#table-'+ obj.data_id + '-sps-dc-3>tbody').empty();	
						$('#table-'+ obj.data_id + '-sps-dc-5>tbody').empty();	
						for(var i = 0 ; i < obj.p_count / 3 ; i++)
						{
							var trObj = $('<tr></tr>');
							trObj.append('<td>'+ (i+1) +'</td>');
							trObj.append('<td>'+ obj.p[3*i] +' °C</td>');
							trObj.append('<td>'+ obj.p[3*i+1] +' V</td>');
							trObj.append('<td>'+ obj.p[3*i+2] +' %</td>');
							$('#table-'+ obj.data_id + '-sps-dc-2>tbody').append(trObj);
						}
						
						$('#sps-dc-'+ obj.data_id +'-field10').html(obj.alert_v + 'V');
						$('#sps-dc-'+ obj.data_id +'-field11').html(obj.alert_m_number + '个');
						$('#sps-dc-'+ obj.data_id +'-field12').html((obj.alert_m[0] ? '是' : '否'));
						$('#sps-dc-'+ obj.data_id +'-field13').html((obj.alert_m[1] ? '是' : '否'));
						$('#sps-dc-'+ obj.data_id +'-field14').html((obj.alert_m[22] ? '异常' : '正常'));
						$('#sps-dc-'+ obj.data_id +'-field15').html((obj.alert_m[23] ? '异常' : '正常'));
						$('#sps-dc-'+ obj.data_id +'-field16').html((obj.alert_m[24] ? '异常' : '正常'));
						$('#sps-dc-'+ obj.data_id +'-field17').html((obj.alert_m[25] ? '故障' : '正常'));
						$('#sps-dc-'+ obj.data_id +'-field18').html((obj.alert_m[26] ? '告警' : '正常'));
						
						var trObj1 = $('<tr></tr>');
						for(var i = 0 ; i < obj.alert_m_number ; i++)
						{
							//trObj1.append('<td>'+ (obj.alert_m[i] ? '异常' : '正常') + '</td>');
							trObj1.append('<td>'+ (obj.alert_m[i] ?  '<span class="label label-important">异常</span> ' : '<span class="label label-success">正常</span>') + '</td>');
						}
						$('#table-'+ obj.data_id + '-sps-dc-3>tbody').append(trObj1);
						
						for(var i = 0 ; i < 4 ; i++)
						{
							var trObj = $('<tr></tr>');
							trObj.append('<td>'+ (i+1) +'</td>');
							trObj.append('<td>'+ (obj.alert_p[2+4*i] ? '<span class="label label-important">异常</span> ' : '<span class="label label-success">正常</span>')+' </td>'); 
							trObj.append('<td>'+ (obj.alert_p[2+4*i] ? '<span class="label label-important">异常</span> ' : '<span class="label label-success">正常</span>')+' </td>'); 
							trObj.append('<td>'+ (obj.alert_p[2+4*i] ? '<span class="label label-important">异常</span> ' : '<span class="label label-success">正常</span>')+' </td>'); 
							trObj.append('<td>'+ (obj.alert_p[2+4*i] ? '<span class="label label-important">异常</span> ' : '<span class="label label-success">正常</span>')+' </td>'); 
							trObj.append('<td>'+ (obj.alert_p[2+4*i] ? '<span class="label label-important">异常</span> ' : '<span class="label label-success">正常</span>')+' </td>'); 
							$('#table-'+ obj.data_id + '-sps-dc-5>tbody').append(trObj);
						}
					}else{
					$('#sps-dc-'+ obj.data_id +'-field1').html(obj.v + 'V');
					$('#sps-dc-'+ obj.data_id +'-field2').html(obj.i + 'A');
					$('#sps-dc-'+ obj.data_id +'-field3').html(obj.m + '组');
					$('#sps-dc-'+ obj.data_id +'-field4').html(obj.n + '路');
					$('#sps-dc-'+ obj.data_id +'-field5').html(obj.alert_v + 'V');
					$('#sps-dc-'+ obj.data_id +'-field6').html(obj.alert_m_number + '根');
					for(var j = 0 ; j < obj.p.length ; j++)
					{
						$('#sps-dc-'+ obj.data_id +'-field' + (j + 7)).html(obj.p[j]);
					}
					
					$('#table-'+ obj.data_id + '-sps-dc-2 tr:eq(0) td:eq(1)').html(obj.dc_i[0] + 'A');
					$('#table-'+ obj.data_id + '-sps-dc-2 tr:eq(1) td:eq(1)').html(obj.dc_i[1] + 'A');
					
					$('#table-'+ obj.data_id + '-sps-dc-3 tr:eq(0) td:eq(1)').html(obj.channelList[0] + 'A');
					$('#table-'+ obj.data_id + '-sps-dc-3 tr:eq(0) td:eq(3)').html(obj.channelList[1] + 'A');
					$('#table-'+ obj.data_id + '-sps-dc-3 tr:eq(0) td:eq(5)').html(obj.channelList[2] + 'A');
					$('#table-'+ obj.data_id + '-sps-dc-3 tr:eq(1) td:eq(1)').html(obj.channelList[3] + 'A');					
					$('#table-'+ obj.data_id + '-sps-dc-3 tr:eq(1) td:eq(3)').html(obj.channelList[4] + 'A');
					$('#table-'+ obj.data_id + '-sps-dc-3 tr:eq(1) td:eq(5)').html(obj.channelList[5] + 'A');
					
					if(obj.model == 'm810g-dc'){

						$('#table-'+ obj.data_id + '-sps-dc-2 tr:eq(2) td:eq(1)').html(obj.dc_i[2] + 'A');
						$('#table-'+ obj.data_id + '-sps-dc-2 tr:eq(3) td:eq(1)').html(obj.dc_i[3] + 'A');
						
						$('#table-'+ obj.data_id + ' -sps-dc-3 tr:eq(2) td:eq(1)').html(obj.channelList[6] + 'A');					
						$('#table-'+ obj.data_id + ' -sps-dc-3 tr:eq(2) td:eq(3)').html(obj.channelList[7] + 'A');
						$('#table-'+ obj.data_id + ' -sps-dc-3 tr:eq(2) td:eq(5)').html(obj.channelList[8] + 'A');
						}
					}

					$('#table-'+ obj.data_id + '-sps-dc-4>tbody').empty();
					for(var row = 0 ; row < obj.alert_m_number; )
					{
						var trObj = $('<tr></tr>');
						var msg = null;
						switch (obj.alert_m[row])
						{
						case 0:
							msg = '正常';
							break;
						case 1:
							msg = '低于下限';
							break;
						case 2:
							msg = '高于上限';
							break;
						case 3:
							msg = '熔丝断';
							break;
						case 4:
							msg = '开关打开';
							break;
						case 225:
							msg = '过温';
							break;
						case 226:
							msg = '通讯中断';
							break;
						case 227:
							msg = '二次下电';
							break;
						case 228:
							msg = '电池保护';
							break;
						}
						var tdObj = $('<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>');
						var name="直流熔断丝";
						tdObj.eq(0).html(name+(row += 1));
						tdObj.eq(1).html(obj.alert_m[row] ? '<span class="label label-important">'+ msg +'</span> ' : '<span class="label label-success">正常</span>');
						trObj.append(tdObj);
							if(row<obj.alert_m_number)
							{
								tdObj.eq(2).html(name+(row += 1) );
								tdObj.eq(3).html(obj.alert_m[row] ? '<span class="label label-important">'+ msg +'</span> ' : '<span class="label label-success">正常</span>');
								trObj.append(tdObj);
								if(row<obj.alert_m_number)
								{
									tdObj.eq(4).html(name+(row += 1) );
									tdObj.eq(5).html(obj.alert_m[row] ? '<span class="label label-important">'+ msg +'</span> ' : '<span class="label label-success">正常</span>');
									trObj.append(tdObj);
								}
									if(row<obj.alert_m_number)
									{
										tdObj.eq(6).html(name+(row += 1) );
										tdObj.eq(7).html(obj.alert_m[row] ? '<span class="label label-important">'+ msg +'</span> ' : '<span class="label label-success">正常</span>');
										trObj.append(tdObj);
									}
										if(row<obj.alert_m_number)
										{
											tdObj.eq(8).html(name+(row += 1) );
											tdObj.eq(9).html(obj.alert_m[row] ? '<span class="label label-important">'+ msg +'</span> ' : '<span class="label label-success">正常</span>');
											trObj.append(tdObj);
										}
											if(row<obj.alert_m_number)
											{
												tdObj.eq(10).html(name+(row += 1) );
												tdObj.eq(11).html(obj.alert_m[row] ? '<span class="label label-important">'+ msg +'</span> ' : '<span class="label label-success">正常</span>');
												trObj.append(tdObj);
											}
							}
						
						$('#table-'+ obj.data_id + '-sps-dc-4>tbody').append(trObj);
					}
					for(var row = 0 ; row < obj.alert_p.length ; row++)
					{
						if(obj.model == 'psma-dc'){
							if(row == 11 || row == 12){
								$('#sps-dc-alarm-'+ obj.data_id + '-field' + row).html(obj.alert_p[row] ? ('<span class="label label-important">'+ alert_p[row] == 1 ? '欠压' :'过压' +'</span> ') : '<span class="label label-success">正常</span>');
							}else{
								$('#sps-dc-alarm-'+ obj.data_id + '-field' + row).html(obj.alert_p[row] ? '<span class="label label-important">异常</span> ' : '<span class="label label-success">正常</span>');
							}
						}else if(obj.model == 'm810g-dc'){
							$('#sps-dc-alarm-'+ obj.data_id + '-field' + row).html(obj.alert_p[row] ? '<span class="label label-important">异常</span> ' : '<span class="label label-success">正常</span>');
						}else if(obj.model == 'smu06c-dc'){
							$('#sps-dc-alarm-'+ obj.data_id + '-field' + row).html(obj.alert_p[row] ? '<span class="label label-important">异常</span> ' : '<span class="label label-success">正常</span>');
						}
					}
				}
				setDcTable($('#table-'+ obj.data_id +'-dc'), obj.dynamic_config);
			}

			for(var i=0;i < ret.dk04List.length; i++)
			{
				var obj = ret.dk04List[i];
				$('#dk04-'+ obj.data_id +'-field0').html(obj.update_datetime);
				if(!obj.isEmpty)
				{
					$('#dk04-'+ obj.data_id +'-field1').html(obj.SysV);
					$('#dk04-'+ obj.data_id +'-field2').html(obj.ILoad);
					$('#dk04-'+ obj.data_id +'-field3').html(obj.IBat1);
					$('#dk04-'+ obj.data_id +'-field4').html(obj.IBat2);
					$('#dk04-'+ obj.data_id +'-field5').html(obj.IBat3);
					$('#dk04-'+ obj.data_id +'-field6').html(obj.IBat4);
					$('#dk04-'+ obj.data_id +'-field7').html(obj.VAcSys);
					$('#dk04-'+ obj.data_id +'-field8').html(obj.I1AcSys);
					$('#dk04-'+ obj.data_id +'-field9').html(obj.I2AcSys);
					$('#dk04-'+ obj.data_id +'-field10').html(obj.Btemp1);
					$('#dk04-'+ obj.data_id +'-field11').html(obj.Btemp2);
					$('#dk04-'+ obj.data_id +'-field12').html(obj.Btemp3);
					$('#dk04-'+ obj.data_id +'-field13').html(obj.Btemp4);
					$('#dk04-'+ obj.data_id +'-field14').html(obj.Atemp);
				}
			}
			for(var i=0;i < ret.psm06List.length; i++)
			{
				var obj = ret.psm06List[i];
				$('#psm06-'+ obj.data_id +'-field0').html(obj.update_datetime);
				if(!obj.isEmpty)
				{
					$('#psm06-'+ obj.data_id +'-field1').html(obj.ac_type ? '三相' : '单相');
					$('#psm06-'+ obj.data_id +'-field2').html(obj.p_in_v_max_limiting);
					$('#psm06-'+ obj.data_id +'-field3').html(obj.p_in_v_min_limiting);
					$('#psm06-'+ obj.data_id +'-field4').html(obj.output_count);
					$('#psm06-'+ obj.data_id +'-field5').html(obj.rc_model_count);
					$('#psm06-'+ obj.data_id +'-field6').html(obj.auto_manual ? '自动' : '手动');
//					$('#table-'+ obj.data_id + '-sps-rc-2>tbody').empty();
//					$('#table-'+ obj.data_id + '-sps-rc-3>tbody').empty();
//					var trObj = $('<tr></tr>');
//					trObj.append('<td>'+ (j+1) +'</td>');
//					trObj.append('<td>'+ (obj.ac_type ? '三相' : '单相') +'</td>');
//					trObj.append('<td>'+ (obj.auto_manual ? '自动' : '手动') +'</td>');
//					trObj.append('<td>'+ (obj.low_battery_autoprotect ? '是' : '否') +'</td>');
//					$('#table-'+ obj.data_id + '-sps-rc-2>tbody').append(trObj);
					$('#psm06-'+ obj.data_id +'-field7').html(obj.battery_count - 48);
					$('#psm06-'+ obj.data_id +'-field8').html(obj.battery_capacity);
					$('#psm06-'+ obj.data_id +'-field9').html(obj.charge_float_v);
					$('#psm06-'+ obj.data_id +'-field10').html(obj.charge_average_v);
					$('#psm06-'+ obj.data_id +'-field11').html(obj.charge_average_timer);
					$('#psm06-'+ obj.data_id +'-field12').html(obj.charge_average_time);
					$('#psm06-'+ obj.data_id +'-field13').html(obj.charge_modulus);
					$('#psm06-'+ obj.data_id +'-field14').html(obj.feeder_resistance);
					$('#psm06-'+ obj.data_id +'-field15').html(obj.charge_limit_i);
					$('#psm06-'+ obj.data_id +'-field16').html(obj.charge_average_trans_i);
					$('#psm06-'+ obj.data_id +'-field17').html(obj.low_battery_alert_v);
					$('#psm06-'+ obj.data_id +'-field18').html(obj.low_battery_protect_v);
					$('#psm06-'+ obj.data_id +'-field19').html(obj.low_battery_autoprotect ? '是' : '否');
					$('#psm06-'+ obj.data_id +'-field20').html(obj.dev_addr);
					for(var j = 0 ; j < obj.output_count ; j++)
					{
						$('#psm06-output-'+ obj.data_id +'-field'+ j).html(obj.output_num[j]);
					}
					for(var j = 0 ; j < obj.rc_model_count ; j++)
					{
						$('#psm06-model-'+ obj.data_id +'-field' + j).html(obj.rc_model_addrs[j]);
					}
				}
			}
		});
	}
	function setDcTable($table,$dynamic_config){
		if($dynamic_config != false)
		{
			$table.find('tbody').empty();
			var dcList = JSON.parse($dynamic_config);
			if(dcList != null){
				if(dcList.length > 0)
					$table.show();
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
					$table.find('tbody').append(trObj);
				}
			}else{
				$table.hide();
			}
		}
	}
	refreshData();
	setInterval(refreshData, 20000);
});
