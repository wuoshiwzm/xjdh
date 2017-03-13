$(document).ready(function() {
	$('.settings').click(function(){
		var data_id = $(this).attr('data_id');
		window.open('/portal/dynamicSetting/'+ data_id);
	});
	
	var dataIdArr = new Array();
	var dataIdModel = {};
	$('.rt-data').each(function() {
		dataIdModel[$(this).attr("data_id")] = $(this).attr("data_type");
		dataIdArr.push($(this).attr("data_id"));
	});
	
	$('#tab-sps .nav-tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
	
	function set_label_class(domObj, alert_value)
	{
		if(alert_value == "正常")
		{
			domObj.removeClass("label-important").addClass("label-success");
		}else{
			domObj.removeClass("label-success").addClass("label-important");
		}
	}
	function refreshData() {
		$.get('/portal/refreshData', {
			'dataIdArr[]' : dataIdArr,
			model : model,
			access_token : typeof(accessToken) == "undefined" ? "":accessToken
		}, function(ret){
			for(var spIndex = 0 ; spIndex < ret.spsList.length ; spIndex++){
				var obj = ret.spsList[spIndex];				
				$('#' + obj.data_id +'-update_datetime').html(obj.update_datetime);
				if(!obj.isEmpty){
					var model = dataIdModel[obj.data_id];
					if(!obj.isMatch)
					{
						$("#" + obj.data_id + "-alert").show();
					}
					if(model == "dk04"){
						$("#dk04-" + obj.data_id + "-field0").text(obj.SysV);
						$("#dk04-" + obj.data_id + "-field1").text(obj.ILoad);
						$("#dk04-" + obj.data_id + "-field2").text(obj.IBat1);
						$("#dk04-" + obj.data_id + "-field3").text(obj.IBat2);
						$("#dk04-" + obj.data_id + "-field4").text(obj.IBat3);
						$("#dk04-" + obj.data_id + "-field5").text(obj.IBat4);
						$("#dk04-" + obj.data_id + "-field6").text(obj.VAcSys);
						$("#dk04-" + obj.data_id + "-field7").text(obj.I1AcSys);
						$("#dk04-" + obj.data_id + "-field8").text(obj.I2AcSys);
						$("#dk04-" + obj.data_id + "-field9").text(obj.Btemp1);
						$("#dk04-" + obj.data_id + "-field10").text(obj.Btemp2);
						$("#dk04-" + obj.data_id + "-field11").text(obj.Btemp3);
						$("#dk04-" + obj.data_id + "-field12").text(obj.Btemp4);
						$("#dk04-" + obj.data_id + "-field13").text(obj.Atemp);
						if($('#' + obj.data_id + '-sps-rc-2 tbody').children().length == 0){
							var columnsCount = $('#' + obj.data_id + '-sps-rc-2 thead>tr>th').length;
							var trObj = $('<tr></tr>');
							for(var j = 0; j < columnsCount; j++)
							{
								trObj.append('<td><span class="label label-success"></span></td>');
							}
							var columnsCount3 = $('#' + obj.data_id + '-sps-rc-3 thead>tr>th').length;
							var trObj3 = $('<tr></tr>');
							for(var j = 0; j < columnsCount3; j++)
							{
								trObj3.append('<td><span class="label label-success"></span></td>');
							}
							for(var j = 0 ; j < obj.number; j++)
							{
								var tTrObj = trObj.clone();
								tTrObj.find("td:eq(0)").text('整流模块'+ (j+1));
								$('#' + obj.data_id + '-sps-rc-2 tbody').append(tTrObj);
								var tTrObj3 = trObj3.clone();
								tTrObj3.find("td:eq(0)").text('整流模块'+ (j+1));
								$('#' + obj.data_id + '-sps-rc-3 tbody').append(tTrObj3);
							}
						}
						for(var j = 0 ; j < obj.number; j++)
						{
							var pTr = $('#' + obj.data_id + '-sps-rc-2 tbody>tr').eq(j);
							pTr.find("td:eq(1)").text(obj.Iout[j]);
							pTr.find("td:eq(2)").text(obj.channelParam[j].FloatV);
							pTr.find("td:eq(3)").text(obj.channelParam[j].EQV);
							pTr.find("td:eq(4)").text(obj.channelParam[j].Vhi);
							pTr.find("td:eq(5)").text(obj.channelParam[j].V1o);
							pTr.find("td:eq(6)").text(obj.channelParam[j].HVSD);
							pTr.find("td:eq(7)").text(obj.channelParam[j].I1im);
							pTr.find("td:eq(8)").text(obj.channelParam[j].AdjV);
							pTr.find("td:eq(9)").text(obj.channelParam[j].SecEnable);
							
							pTr = $('#' + obj.data_id + '-sps-rc-3 tbody>tr').eq(j);
							for(var z = 0; z < obj.channel[j].length; z++)
							{
								pTr.find("td:eq(" + (z+1) + ")>span").text(obj.channel[j][z]);
								set_label_class(pTr.find("td:eq(" + (z+1) + ")>span"), obj.channel[j][z]);
							}
						}
					}else if(model == "dk04c"){
						$("#dk04-" + obj.data_id + "-field0").text(obj.SysV);
						$("#dk04-" + obj.data_id + "-field1").text(obj.ILoad);
						$("#dk04-" + obj.data_id + "-field2").text(obj.IBat1);
						$("#dk04-" + obj.data_id + "-field3").text(obj.IBat2);
						for(var i = 0; i < obj.alarm.length; i++)
						{
							$("#tbAlarm .alarm" + i).text(obj.alarm[i]);
							set_label_class($("#tbAlarm .alarm" + i), obj.alarm[i]);
						}
						$("#dk04-" + obj.data_id + "-field4").text(obj.battery_temp);
						$("#dk04-" + obj.data_id + "-field5").text(obj.amb_temp);
						$("#dk04-" + obj.data_id + "-field6").text(obj.q_est_bat1);
						$("#dk04-" + obj.data_id + "-field7").text(obj.q_est_bat2);
						$("#dk04-" + obj.data_id + "-field8").text(obj.ac_volts);
						$("#dk04-" + obj.data_id + "-field9").text(obj.ac_current);
						$("#dk04-" + obj.data_id + "-field10").text(obj.ac_freq);
						$("#dk04-" + obj.data_id + "-field11").text(obj.acv_phase1);
						$("#dk04-" + obj.data_id + "-field12").text(obj.acv_phase2);
						$("#dk04-" + obj.data_id + "-field13").text(obj.acv_phase3);
						$("#dk04-" + obj.data_id + "-field14").text(obj.aci_phase1);
						$("#dk04-" + obj.data_id + "-field15").text(obj.aci_phase2);
						$("#dk04-" + obj.data_id + "-field16").text(obj.aci_phase3);
						$("#dk04-" + obj.data_id + "-field17").text(obj.ac_freq_3ph);
						if($('#' + obj.data_id + '-sps-rc-3 tbody').children().length == 0){
							var columnsCount = $('#' + obj.data_id + '-sps-rc-3 thead>tr>th').length;
							var trObj = $('<tr></tr>');
							for(var j = 0; j < columnsCount; j++)
							{
								trObj.append('<td><span class="label label-success"></span></td>');
							}
							var columnsCount3 = $('#' + obj.data_id + '-sps-rc-4 thead>tr>th').length;
							var trObj3 = $('<tr></tr>');
							for(var j = 0; j < columnsCount3; j++)
							{
								trObj3.append('<td><span class="label label-success"></span></td>');
							}
							for(var j = 0 ; j < obj.NumSMRs; j++)
							{
								var tTrObj = trObj.clone();
								tTrObj.find("td:eq(0)").text('整流模块'+ (j+1));
								$('#' + obj.data_id + '-sps-rc-3 tbody').append(tTrObj);
								var tTrObj3 = trObj3.clone();
								tTrObj3.find("td:eq(0)").text('整流模块'+ (j+1));
								$('#' + obj.data_id + '-sps-rc-4 tbody').append(tTrObj3);
							}
						}
						for(var j = 0 ; j < obj.NumSMRs; j++)
						{
							var pTr = $('#' + obj.data_id + '-sps-rc-3 tbody>tr').eq(j);
							pTr.find("td:eq(1)").text(obj.smr_volts[j]);
							pTr.find("td:eq(2)").text(obj.Iout[j]);
							pTr.find("td:eq(3)").text(obj.temp[j]);
							
							pTr = $('#' + obj.data_id + '-sps-rc-4 tbody>tr').eq(j);
							for(var z = 0; z < obj.channel[j].length; z++)
							{
								pTr.find("td:eq(" + (z+1) + ")>span").text(obj.channel[j][z]);
								set_label_class(pTr.find("td:eq(" + (z+1) + ")>span"), obj.channel[j][z]);
							}
						}
					}else if(model.search(/-ac$/) != -1){
						$('#' + obj.data_id +'-ia').html(obj.ia);
						$('#' + obj.data_id +'-ib').html(obj.ib);
						$('#' + obj.data_id +'-ic').html(obj.ic);
						$('#' + obj.data_id +'-channel_count').html(obj.channel_count);
						$('#' + obj.data_id +'-airlock_count').html(obj.airlock_count);
						$('#' + obj.data_id +'-ia_alert').html(obj.ia_alert);
						set_label_class($('#' + obj.data_id +'-ia_alert'), obj.ia_alert);
						$('#' + obj.data_id +'-ib_alert').html(obj.ib_alert);
						set_label_class($('#' + obj.data_id +'-ib_alert'), obj.ib_alert);
						$('#' + obj.data_id +'-ic_alert').html(obj.ic_alert);
						set_label_class($('#' + obj.data_id +'-ic_alert'), obj.ic_alert);
						if(obj.airlock_count)
						{						
							if($('#' + obj.data_id + '-lastTr').next().length == 0){
								var index = parseInt($('#' + obj.data_id + '-lastTr>td:eq(0)').text());
								for(var i=0;i <obj.airlock_count;i++){
									var trObj = $('<tr><td></td><td></td><td></td><td></td></tr>');
									trObj.after($('#' + obj.data_id + '-lastTr'));
									trObj.find("td:eq(0)").text(index++);
									trObj.find("td:eq(1)").text("空开" + index + "状态");
								}
							}
							var alTr = $('#' + obj.data_id + '-lastTr').next();
							for(var i=0;i <obj.airlock_count;i++){
								alTr.find("td:eq(2)").text(obj.airlock_status[i]);
								alTr = alTr.next();
							}
						}
						for(var i=0;i < obj.p40_43_count;i++){
							$("#" + obj.data_id + '-p40_43-field' + i).text(obj.p40_43[i]);
						}
						if($('#' + obj.data_id + '-sps-ac-2 tbody').children().length == 0){
							//这个地方生成本设备协议的显示界面
							var columnsCount = $('#' + obj.data_id + '-sps-ac-2 thead>tr>th').length;
							var trObj = $('<tr></tr>');
							for(var j = 0; j < columnsCount; j++)
							{
								trObj.append('<td><span class="label label-success"></span></td>');
							}
							for(var j = 0 ; j < obj.channelList.length ; j++)
							{
								var tTrObj = trObj.clone();
								tTrObj.find("td:eq(0)").text('交流通道'+ (j+1));
								$('#' + obj.data_id + '-sps-ac-2 tbody').append(tTrObj);
							}
							
							columnsCount = $('#' + obj.data_id + '-sps-ac-3 thead>tr>th').length;
							var trObj = $('<tr></tr>');
							for(var j = 0; j < columnsCount; j++){
								trObj.append('<td><span class="label label-success"></span></td>');
							}
							for(var j = 0 ; j < obj.channelList.length ; j++){
								var tTrObj = trObj.clone();
								tTrObj.find("td:eq(0)").text('交流通道'+ (j+1));
								$('#' + obj.data_id + '-sps-ac-3 tbody').append(tTrObj);
							}
						}
						var trObj = $('#' + obj.data_id + '-sps-ac-2 tbody>tr:eq(0)');
						var alertTrObj = $('#' + obj.data_id + '-sps-ac-3 tbody>tr:eq(0)');
						for(var j = 0 ; j < obj.channelList.length ; j++)
						{
							var channelObj = obj.channelList[j];
							trObj.find("td:eq(1)").text(channelObj.a);
							trObj.find("td:eq(2)").text(channelObj.b);
							trObj.find("td:eq(3)").text(channelObj.c);
							trObj.find("td:eq(4)").text(channelObj.f);
							for(var i=0; i < channelObj.p40_41.length; i++)
							{
								trObj.find("td:eq(" + (i+5) + ")").text(channelObj.p40_41[i]);
							}
							trObj = trObj.next();
							
							alertTrObj.find("td:eq(1)>span").text(channelObj.alert_a);
							set_label_class(alertTrObj.find("td:eq(1)>span"), channelObj.alert_a);
							alertTrObj.find("td:eq(2)>span").text(channelObj.alert_b);
							set_label_class(alertTrObj.find("td:eq(2)>span"), channelObj.alert_b);
							alertTrObj.find("td:eq(3)>span").text(channelObj.alert_c);
							set_label_class(alertTrObj.find("td:eq(3)>span"), channelObj.alert_c);
							alertTrObj.find("td:eq(4)>span").text(channelObj.alert_f);
							set_label_class(alertTrObj.find("td:eq(4)>span"), channelObj.alert_f);
							
							for(var i=0; i < channelObj.p40_44.length; i++)
							{
								alertTrObj.find("td:eq(" + (i+5) + ")>span").text(channelObj.p40_44[i]);
								set_label_class(alertTrObj.find("td:eq(" + (i+5) + ")>span"), channelObj.p40_44[i]);
							}
							alertTrObj = alertTrObj.next();
						}
						var j = 0;
						$('#' + obj.data_id + '-sps-ac-1>tbody>tr').each(function(){
							$(this).find("td:eq(0)").text(j+1);
							j++;
						});
					}else if(model.search(/-rc$/) != -1)
					{
						$('#'+ obj.data_id +'-out_v').html(obj.out_v);
						$('#'+ obj.data_id +'-channel_count').html(obj.channel_count);
						//$('#'+ obj.data_id + '-sps-rc-2>tbody').empty();
						//$('#'+ obj.data_id + '-sps-rc-3>tbody').empty();
						
						if($('#'+ obj.data_id + '-sps-rc-2>tbody').children().length == 0)
						{
							var columnsCount = $('#' + obj.data_id + '-sps-rc-2>thead>tr>th').length;
							var trObj = $('<tr></tr>');
							for(var j = 0; j < columnsCount; j++)
							{
								trObj.append('<td></td>');
							}
							for(var j = 0 ; j < obj.channelList.length ; j++)
							{
								var tTrObj = trObj.clone();
								tTrObj.find("td:eq(0)").text('整流模块'+ (j+1));
								$('#' + obj.data_id + '-sps-rc-2 tbody').append(tTrObj);
							}
							
							columnsCount = $('#' + obj.data_id + '-sps-rc-3>thead>tr>th').length;
							var trObj = $('<tr></tr>');
							for(var j = 0; j < columnsCount; j++)
							{
								trObj.append('<td><span class="label label-success"></span></td>');
							}
							for(var j = 0 ; j < obj.channelList.length ; j++)
							{
								var tTrObj = trObj.clone();
								tTrObj.find("td:eq(0)").text('整流模块'+ (j+1));
								$('#' + obj.data_id + '-sps-rc-3 tbody').append(tTrObj);
							}
						}
						
						var trObj = $('#' + obj.data_id + '-sps-rc-2 tbody>tr:eq(0)');
						var alertTrObj = $('#' + obj.data_id + '-sps-rc-3 tbody>tr:eq(0)');
						for(var j = 0 ; j < obj.channelList.length ; j++)
						{
							var channelObj = obj.channelList[j];
							
							trObj.find("td:eq(1)").text(channelObj.out_i);
							var tdOffset = 2;
							for(var i=0; i < $('#' + obj.data_id + '-sps-rc-2>thead>tr>th.p41_41').length; i++)
							{
								trObj.find("td:eq(" + tdOffset++ + ")").text(channelObj.p41_41[i]);
							}
							trObj.find("td:eq(" + tdOffset++ + ")").text(channelObj.shutdown);
							trObj.find("td:eq(" + tdOffset++ + ")").text(channelObj.i_limit);
							trObj.find("td:eq(" + tdOffset++ + ")").text(channelObj.charge);
							for(var i=0; i < channelObj.p41_43.length; i++)
							{
								trObj.find("td:eq(" + tdOffset++ + ")").text(channelObj.p41_43[i]);
							}
							trObj = trObj.next();
							
							alertTrObj.find("td:eq(1)>span").text(channelObj.fault);
							set_label_class(alertTrObj.find("td:eq(1)>span"), channelObj.fault);
							tdOffset = 2;
							for(var i=0; i < channelObj.p41_44_count; i++)
							{
								alertTrObj.find("td:eq(" + tdOffset + ")>span").text(channelObj.p41_44[i]);
								set_label_class(alertTrObj.find("td:eq(" + tdOffset++ + ")>span"), channelObj.p41_44[i]);
							}							
							alertTrObj = alertTrObj.next();
						}
					}else if(model.search(/-dc$/) != -1)
					{
						$('#'+ obj.data_id +'-v').html(obj.v);
						$('#'+ obj.data_id +'-i').html(obj.i);
						$('#'+ obj.data_id +'-m').html(obj.m);
						$('#'+ obj.data_id +'-sps-dc-1>tbody>tr.dc_m:gt(' + (obj.m-1) + ')').remove();
						for(var j=0; j< obj.m; j++)
						{
							$('#'+ obj.data_id +'-m' + j).text(obj.dc_i[j]);
						}
						$('#'+ obj.data_id +'-n').html(obj.n);
						if(obj.n == 0)
						{
							$('#'+ obj.data_id +'-sps-dc-1>tbody>tr.dc_n').remove();
						}else
						{
							$('#'+ obj.data_id +'-sps-dc-1>tbody>tr.dc_n:gt(' + (obj.n-1) + ')').remove();
							for(var j = 0 ; j < obj.n ; j++)
							{
								$('#'+ obj.data_id +'-n' + j).text(obj.channel[j]);
							}
						}
						
						for(var i=0; i < obj.p.length; i++)
						{
							if(i < obj.p_count)
							{
								$('#' + obj.data_id + '-dc_p' + i).text(obj.p[i]);
							}else{
								$('#' + obj.data_id + '-dc_p' + i).parent().remove();
							}
							
						}
						
						$('#'+ obj.data_id +'-alert_v').html(obj.alert_v);
						if(model == "zxdu58-b121v21-dc")
						{							
							//extra
							$('#' + obj.data_id + '-has_report').text(obj.has_report);
							$('#' + obj.data_id + '-test_end').text(obj.test_end);
							$('#' + obj.data_id + '-duration_minutes').text(obj.duration_minutes);
							$('#' + obj.data_id + '-discharge_capacity').text(obj.discharge_capacity);
							
						}
						if($("#" + obj.data_id + "-sps-dc-2 tbody").children().length == 0)
						{
							for(var i = 0 ; i < Math.ceil(obj.alert_m_count / 6) ; i++)
							{
								var trObj = $("<tr></tr>");
								trObj.append('<td>'+ (i*6+1) +'</td>');
								trObj.append('<td><span class="label label-success"></span></td>');
								if((i*6+2) <= obj.alert_m_count)
								{
									trObj.append('<td>'+ (i*6+2) +'</td>');
								}else{
									trObj.append('<td></td>');
								}								
								trObj.append('<td><span class="label label-success"></span></td>');
								if((i*6+3) <= obj.alert_m_count)
								{
									trObj.append('<td>'+ (i*6+3) +'</td>');
								}else{
									trObj.append('<td></td>');
								}	
								trObj.append('<td><span class="label label-success"></span></td>');
								if((i*6+4) <= obj.alert_m_count)
								{
									trObj.append('<td>'+ (i*6+4) +'</td>');
								}else{
									trObj.append('<td></td>');
								}
								trObj.append('<td><span class="label label-success"></span></td>');
								if((i*6+5) <= obj.alert_m_count)
								{
									trObj.append('<td>'+ (i*6+5) +'</td>');
								}else{
									trObj.append('<td></td>');
								}
								trObj.append('<td><span class="label label-success"></span></td>');
								if((i*6+5) <= obj.alert_m_count)
								{
									trObj.append('<td>'+ (i*6+6) +'</td>');
								}else{
									trObj.append('<td></td>');
								}
								trObj.append('<td><span class="label label-success"></span></td>');
								$("#" + obj.data_id + "-sps-dc-2 tbody").append(trObj);
							}
						}
						var trObj = $("#" + obj.data_id + "-sps-dc-2 tbody>tr:eq(0)");
						for(var i = 0 ; i < Math.ceil(obj.alert_m_count / 6) ; i++)
						{
							trObj.find("td:eq(1)>span").text(obj.alert_m[i*6]);
							set_label_class(trObj.find("td:eq(1)>span"),obj.alert_m[i*6]);
							if((i*6+1) < obj.alert_m_count)
							{
								set_label_class(trObj.find("td:eq(3)>span"),obj.alert_m[i*6+1]);
								trObj.find("td:eq(3)>span").text(obj.alert_m[i*6+1]);
							}
							if((i*6+2) < obj.alert_m_count)
							{
								trObj.find("td:eq(5)>span").text(obj.alert_m[i*6+2]);
								set_label_class(trObj.find("td:eq(5)>span"),obj.alert_m[i*6+2]);
							}
							if((i*6+3) < obj.alert_m_count)
							{
								trObj.find("td:eq(7)>span").text(obj.alert_m[i*6+3]);
								set_label_class(trObj.find("td:eq(7)>span"),obj.alert_m[i*6+3]);
							}
							if((i*6+4) < obj.alert_m_count)
							{
								trObj.find("td:eq(9)>span").text(obj.alert_m[i*6+4]);
								set_label_class(trObj.find("td:eq(9)>span"),obj.alert_m[i*6+4]);
							}
							if((i*6+5) < obj.alert_m_count)
							{
								trObj.find("td:eq(11)>span").text(obj.alert_m[i*6+5]);
								set_label_class(trObj.find("td:eq(11)>span"),obj.alert_m[i*6+5]);
							}
							trObj = trObj.next();
						}
						for(var i=0; i< obj.alert_p.length; i++)
						{
							$("#" + obj.data_id + "-alert_p" + i).text(obj.alert_p[i]);
							set_label_class($("#" + obj.data_id + "-alert_p" + i),obj.alert_p[i]);
						}
						
						var j = 0;
						$('#' + obj.data_id + '-sps-dc-1>tbody>tr').each(function(){
							$(this).find("td:eq(0)").text(j+1);
							j++;
						});
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
	setInterval(refreshData, 10000);
});
