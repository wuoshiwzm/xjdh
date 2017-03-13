<script type="text/javascript">
var model = <?php echo json_encode($model); ?>;
var obj = <?php echo json_encode($dataObj); ?>;

function set_label_class(domObj, alert_value)
{
	if(alert_value == "正常")
	{
		domObj.removeClass("label-important").addClass("label-success");
	}else{
		domObj.removeClass("label-success").addClass("label-important");
	}
}
if(model == "power_302a")
{
	//有功功率
	$('#power302a-'+ obj.data_id + '-1 td:eq(2)>span').html(obj.pa.toFixed(3));
	$('#power302a-'+ obj.data_id + '-1 td:eq(3)>span').html(obj.pb.toFixed(3));
	$('#power302a-'+ obj.data_id + '-1 td:eq(4)>span').html(obj.pc.toFixed(3));
	$('#power302a-'+ obj.data_id + '-1 td:eq(5)>span').html(obj.pt.toFixed(3));
	//电压有效值
	$('#power302a-'+ obj.data_id + '-2 td:eq(2)>span').html(obj.uaRms.toFixed(3));
	$('#power302a-'+ obj.data_id + '-2 td:eq(3)>span').html(obj.ubRms.toFixed(3));
	$('#power302a-'+ obj.data_id + '-2 td:eq(4)>span').html(obj.ucRms.toFixed(3));
	//$('#power302a-'+ obj.data_id + '-2 td:eq(5)>span').html(obj.utRms.toFixed(3));
	//电流有效值
	$('#power302a-'+ obj.data_id + '-3 td:eq(2)>span').html(obj.iaRms.toFixed(3));
	$('#power302a-'+ obj.data_id + '-3 td:eq(3)>span').html(obj.ibRms.toFixed(3));
	$('#power302a-'+ obj.data_id + '-3 td:eq(4)>span').html(obj.icRms.toFixed(3));
	//$('#power302a-'+ obj.data_id + '-3 td:eq(5)>span').html(obj.itRms.toFixed(3));
	//功率因数
	$('#power302a-'+ obj.data_id + '-4 td:eq(2)>span').html(obj.pfa.toFixed(3));
	$('#power302a-'+ obj.data_id + '-4 td:eq(3)>span').html(obj.pfb.toFixed(3));
	$('#power302a-'+ obj.data_id + '-4 td:eq(4)>span').html(obj.pfc.toFixed(3));
	//$('#power302a-'+ obj.data_id + '-4 td:eq(5)>span').html(obj.pft.toFixed(3));
	//频率
	$('#power302a-'+ obj.data_id + '-5 td:eq(5)>span').html(obj.freq.toFixed(3));
	//有功电能
	$('#power302a-'+ obj.data_id + '-6 td:eq(2)>span').html(obj.epa.toFixed(3));
	$('#power302a-'+ obj.data_id + '-6 td:eq(3)>span').html(obj.epb.toFixed(3));
	$('#power302a-'+ obj.data_id + '-6 td:eq(4)>span').html(obj.epc.toFixed(3));
	$('#power302a-'+ obj.data_id + '-6 td:eq(5)>span').html(obj.ept.toFixed(3));
}
if(model == "battery_24"||model == "battery_32")
{
	for(var j = 0 ; j < obj.battery_voltage.length ; j+=4)
	{
		if(j == 0){
			$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+j +') td:eq(1)>span:eq(0)').html(obj.battery_voltage[j].toFixed(3) + 'V');
			$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+j +') td:eq(3)>span:eq(0)').html(obj.battery_voltage[j+1].toFixed(3) + 'V');
			$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+j +') td:eq(5)>span:eq(0)').html(obj.battery_voltage[j+2].toFixed(3) + 'V');
			$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+j +') td:eq(7)>span:eq(0)').html(obj.battery_voltage[j+3].toFixed(3) + 'V');
		}
		else{
			var k = j - ((j / 4) * 3);
			$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+k +') td:eq(1)>span:eq(0)').html(obj.battery_voltage[j].toFixed(3) + 'V');
			$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+k +') td:eq(3)>span:eq(0)').html(obj.battery_voltage[j+1].toFixed(3) + 'V');
			$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+k +') td:eq(5)>span:eq(0)').html(obj.battery_voltage[j+2].toFixed(3) + 'V');
			$('#bat_voltage_'+ obj.data_id).find(' tbody>tr:eq('+k +') td:eq(7)>span:eq(0)').html(obj.battery_voltage[j+3].toFixed(3) + 'V');
		}
	}
}

if(model == "aeg-ms10se")
{
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field0').html(obj.f.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field1').html(obj.v1.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field2').html(obj.v2.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field3').html(obj.v3.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field4').html(obj.vvavg.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field5').html(obj.v12.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field6').html(obj.v23.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field7').html(obj.v31.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field8').html(obj.vlavg.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field9').html(obj.i1.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field10').html(obj.i2.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field11').html(obj.i3.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field12').html(obj.iavg.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field13').html(obj.in.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field14').html(obj.p1.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field15').html(obj.p2.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field16').html(obj.p3.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field17').html(obj.psum.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field18').html(obj.q1.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field19').html(obj.q2.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field20').html(obj.q3.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field21').html(obj.qsum.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field22').html(obj.s1.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field23').html(obj.s2.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field24').html(obj.s3.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field25').html(obj.ssum.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field26').html(obj.pf1.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field27').html(obj.pf2.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field28').html(obj.pf3.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field29').html(obj.pf.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field30').html(obj.psum2.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field31').html(obj.qsum2.toFixed(3));
    $('#aeg-ms10se-reg1-'+ obj.data_id + '-field32').html(obj.ssum2.toFixed(3));

    $('#aeg-ms10se-reg2-'+ obj.data_id + '-field0').html(obj.ep_imp.toFixed(3));
    $('#aeg-ms10se-reg2-'+ obj.data_id + '-field1').html(obj.ep_exp.toFixed(3));
    $('#aeg-ms10se-reg2-'+ obj.data_id + '-field2').html(obj.eq_imp.toFixed(3));
    $('#aeg-ms10se-reg2-'+ obj.data_id + '-field3').html(obj.eq_exp.toFixed(3));
    $('#aeg-ms10se-reg2-'+ obj.data_id + '-field4').html(obj.ep_total.toFixed(3));
    $('#aeg-ms10se-reg2-'+ obj.data_id + '-field5').html(obj.ep_net.toFixed(3));
    $('#aeg-ms10se-reg2-'+ obj.data_id + '-field6').html(obj.eq_total.toFixed(3));
    $('#aeg-ms10se-reg2-'+ obj.data_id + '-field7').html(obj.eq_net.toFixed(3));

    $('aeg-ms10se-di-'+ obj.data_id + '-field0').html(obj.di[0].toFixed(3));
    $('aeg-ms10se-di-'+ obj.data_id + '-field1').html(obj.di[1].toFixed(3));
    $('aeg-ms10se-di-'+ obj.data_id + '-field2').html(obj.di[2].toFixed(3));
    $('aeg-ms10se-di-'+ obj.data_id + '-field3').html(obj.di[3].toFixed(3));
    $('aeg-ms10se-di-'+ obj.data_id + '-field4').html(obj.di[4].toFixed(3));
    $('aeg-ms10se-di-'+ obj.data_id + '-field5').html(obj.di[5].toFixed(3));

    $('aeg-ms10se-do-'+ obj.data_id + '-field0').html(obj.d_o[0].toFixed(3));
    $('aeg-ms10se-do-'+ obj.data_id + '-field1').html(obj.d_o[1].toFixed(3));
    $('aeg-ms10se-do-'+ obj.data_id + '-field2').html(obj.d_o[2].toFixed(3));
    $('aeg-ms10se-do-'+ obj.data_id + '-field3').html(obj.d_o[3].toFixed(3));
    $('aeg-ms10se-do-'+ obj.data_id + '-field4').html(obj.d_o[4].toFixed(3));
    $('aeg-ms10se-do-'+ obj.data_id + '-field5').html(obj.d_o[5].toFixed(3));
}


if(model == "datamate3000")
{
    $('#datamate3000-'+ obj.data_id + '-field0').html(obj.Data." ".obj.Time);
    $('#datamate3000-'+ obj.data_id + '-field1').html(obj.room_temp.toFixed(3) + '°C');
    $('#datamate3000-'+ obj.data_id + '-field2').html(obj.room_humid.toFixed(3)+ '%');
    $('#datamate3000-'+ obj.data_id + '-field3').html(obj.outdoor_temp.toFixed(3) + '°C');
    $('#datamate3000-'+ obj.data_id + '-field4').html(obj.air_state == "1" ? "开机" : "关机");
    $('#datamate3000-'+ obj.data_id + '-field5').html(obj.temperature.toFixed(3) + '°C');
    $('#datamate3000-'+ obj.data_id + '-field6').html(obj.humidity.toFixed(3) + '%');
    $('#datamate3000-'+ obj.data_id + '-field7').html(obj.set_temp.toFixed(3) + '°C');
    $('#datamate3000-'+ obj.data_id + '-field8').html(obj.temp_pric.toFixed(3));
    $('#datamate3000-'+ obj.data_id + '-field9').html(obj.set_humid.toFixed(3) + '%');
    $('#datamate3000-'+ obj.data_id + '-field10').html(obj.humid_pric.toFixed(3));
    $('#datamate3000-'+ obj.data_id + '-field11').html(obj.switch_status == "1" ? "开机":"关机");
    $('#datamate3000-'+ obj.data_id + '-field12').html(obj.fan_status == "1" ? "开机":"关机");
    $('#datamate3000-'+ obj.data_id + '-field13').html(obj.cool_status == "1" ? "开机":"关机");
    $('#datamate3000-'+ obj.data_id + '-field14').html(obj.heat_status == "1" ? "开机":"关机");
    $('#datamate3000-'+ obj.data_id + '-field15').html(obj.humid_status == "1" ? "开机":"关机");
    $('#datamate3000-'+ obj.data_id + '-field16').html(obj.dehumid_status == "1" ? "开机":"关机");
    switch(obj.unit_status)
	{
		case "0":
			$('#datamate3000-'+ obj.data_id + '-field17').html("关机");
			break;
		case "1":
			$('#datamate3000-'+ obj.data_id + '-field17').html("运行");
			break;
		case "2":
			$('#datamate3000-'+ obj.data_id + '-field17').html("待机");
			break;
		case "3":
			$('#datamate3000-'+ obj.data_id + '-field17').html("锁定");
			break;					
	}
	switch(obj.unit_prop)
	{
		case "0":
			$('#datamate3000-'+ obj.data_id + '-field18').html("主机");
			break;
		case "0":
			$('#datamate3000-'+ obj.data_id + '-field18').html("背机");
			break;
		case "0":
			$('#datamate3000-'+ obj.data_id + '-field18').html("从机");
			break;	
	}
	$('#datamate3000-'+ obj.data_id + '-field19').html(obj.high_press_lock == "1"?"已锁定":"未锁定");
	$('#datamate3000-'+ obj.data_id + '-field20').html(obj.low_press_lock == "1"?"已锁定":"未锁定");					
	$('#datamate3000-'+ obj.data_id + '-field21').html(obj.exhaust_lock == "1"?"已锁定":"未锁定");
	$('#datamate3000-'+ obj.data_id + '-field22').html(obj.setting_temperature.toFixed(3) + '°C');
	$('#datamate3000-'+ obj.data_id + '-field23').html(obj.setting_humidity.toFixed(3) + '%');	
	$('#datamate3000-'+ obj.data_id + '-field24').html(obj.high_temperature_alert.toFixed(3) + '°C');
	$('#datamate3000-'+ obj.data_id + '-field25').html(obj.low_temperature_alert.toFixed(3) + '°C');
	$('#datamate3000-'+ obj.data_id + '-field26').html(obj.high_humidity_alert.toFixed(3) + '%');
	$('#datamate3000-'+ obj.data_id + '-field27').html(obj.low_humidity_alert.toFixed(3) + '%');
	$('#datamate3000-'+ obj.data_id + '-field28').text(obj.high_press_alarm == "1" ? "告警" : "正常");
	$('#datamate3000-'+ obj.data_id + '-field29').text(obj.low_press_alarm == "1" ? "告警" : "正常");
	$('#datamate3000-'+ obj.data_id + '-field30').text(obj.high_temp_alarm == "1" ? "告警" : "正常");
	$('#datamate3000-'+ obj.data_id + '-field31').text(obj.low_temp_alarm == "1" ? "告警" : "正常");
	$('#datamate3000-'+ obj.data_id + '-field32').text(obj.high_humid_alarm == "1" ? "告警" : "正常");
	$('#datamate3000-'+ obj.data_id + '-field33').text(obj.low_humid_alarm == "1" ? "告警" : "正常");
	$('#datamate3000-'+ obj.data_id + '-field34').text(obj.power_failer_alarm == "1" ? "告警" : "正常");
	$('#datamate3000-'+ obj.data_id + '-field35').text(obj.short_cycle_alarm == "1" ? "告警" : "正常");
	$('#datamate3000-'+ obj.data_id + '-field36').text(obj.custom_alarm1 == "1" ? "告警" : "正常");
	$('#datamate3000-'+ obj.data_id + '-field37').text(obj.custom_alarm2 == "1" ? "告警" : "正常");
	$('#datamate3000-'+ obj.data_id + '-field38').text(obj.main_fan_mainten_alarm == "1" ? "告警" : "正常");
	$('#datamate3000-'+ obj.data_id + '-field39').text(obj.humid_mainten_alarm == "1" ? "告警" : "正常");
	$('#datamate3000-'+ obj.data_id + '-field40').text(obj.filter_mainten_alarm == "1" ? "告警" : "正常");
	$('#datamate3000-'+ obj.data_id + '-field41').text(obj.com_failer_alarm == "1" ? "告警" : "正常");
	$('#datamate3000-'+ obj.data_id + '-field42').text(obj.coil_freeze_alarm == "1" ? "告警" : "正常");
	$('#datamate3000-'+ obj.data_id + '-field43').text(obj.humid_fault_alarm == "1" ? "告警" : "正常");
	$('#datamate3000-'+ obj.data_id + '-field44').text(obj.sensor_miss_alarm == "1" ? "告警" : "正常");
	$('#datamate3000-'+ obj.data_id + '-field45').text(obj.gas_temp_fault_alarm == "1" ? "告警" : "正常");
	$('#datamate3000-'+ obj.data_id + '-field46').text(obj.power_miss_fault_alarm == "1" ? "告警" : "正常");
	$('#datamate3000-'+ obj.data_id + '-field47').text(obj.power_undervol_alarm == "1" ? "告警" : "正常");
	$('#datamate3000-'+ obj.data_id + '-field48').text(obj.power_phase_alarm == "1" ? "告警" : "正常");
	$('#datamate3000-'+ obj.data_id + '-field49').text(obj.power_freq_alarm == "1" ? "告警" : "正常");
	$('#datamate3000-'+ obj.data_id + '-field50').text(obj.floor_overflow_alarm == "1" ? "告警" : "正常");
}

if(model == "liebert-ups")
{

}

if(model == "ug40")
{
	 $('#ug40-'+ obj.data_id + '-field0').html(obj.Data." ".obj.Time);
	 $('#ug40-'+ obj.data_id + '-field1').text(obj.system_on);                          //系统运行
	 $('#ug40-'+ obj.data_id + '-field2').text(obj.compressor1);                        //压缩机1
	 $('#ug40-'+ obj.data_id + '-field3').text(obj.compressor2);                        //压缩机2
	 $('#ug40-'+ obj.data_id + '-field4').text(obj.compressor3);                        //压缩机3
	 $('#ug40-'+ obj.data_id + '-field5').text(obj.compressor4);                        //压缩机4
	 $('#ug40-'+ obj.data_id + '-field6').text(obj.heater1);                            //加热器1
	 $('#ug40-'+ obj.data_id + '-field7').text(obj.heater2);                            //加热器2
	 $('#ug40-'+ obj.data_id + '-field8').text(obj.hot_gas);                            //热风
	 $('#ug40-'+ obj.data_id + '-field9').text(obj.dehumidification);                   //除湿
	 $('#ug40-'+ obj.data_id + '-field10').text(obj.emergency);                          //应急工作
	 $('#ug40-'+ obj.data_id + '-field11').text(obj.wrong_psword);                       //错误密码报警
	 $('#ug40-'+ obj.data_id + '-field12').text(obj.high_room_temp);                     //高温报警
	 $('#ug40-'+ obj.data_id + '-field13').text(obj.low_room_temp);                      //低温报警
	 $('#ug40-'+ obj.data_id + '-field14').text(obj.high_room_humidy);                   //高湿度报警
	 $('#ug40-'+ obj.data_id + '-field15').text(obj.low_root_humidy);                    //低湿度报警
	 $('#ug40-'+ obj.data_id + '-field16').text(obj.sensors);                            //温湿度传感器
	 $('#ug40-'+ obj.data_id + '-field17').text(obj.clogged_filter);                     //过滤器
	 $('#ug40-'+ obj.data_id + '-field18').text(obj.flooding);                           //漏水报警
	 $('#ug40-'+ obj.data_id + '-field19').text(obj.loss_air_flow);                      //气流报警
	 $('#ug40-'+ obj.data_id + '-field20').text(obj.heater_over);                        //加热器过热
	 $('#ug40-'+ obj.data_id + '-field21').text(obj.circuit1_high_presure);              //高压电路1
	 $('#ug40-'+ obj.data_id + '-field22').text(obj.circuit2_high_presure);              //高压电路2
	 $('#ug40-'+ obj.data_id + '-field23').text(obj.circuit1_low_presure);               //低压电路1
	 $('#ug40-'+ obj.data_id + '-field24').text(obj.circuit2_low_presure);               //低压电路2
	 $('#ug40-'+ obj.data_id + '-field25').text(obj.circuit1_elec_valve);                //电路1电流值
	 $('#ug40-'+ obj.data_id + '-field26').text(obj.circuit2_elec_valve);                //电路2电流值
	 $('#ug40-'+ obj.data_id + '-field27').text(obj.power_loss);                         //气流丢失
	 $('#ug40-'+ obj.data_id + '-field28').text(obj.water_loss);                         //水流丢失
	 $('#ug40-'+ obj.data_id + '-field29').text(obj.cthd);                               //连续波温度过高对除湿
	 $('#ug40-'+ obj.data_id + '-field30').text(obj.cvf_wftl);                           //连续波阀故障或水流过低
	 $('#ug40-'+ obj.data_id + '-field31').text(obj.loss_water_flow);                    //水流报警
	 $('#ug40-'+ obj.data_id + '-field32').text(obj.room_air_sensor);                    //室内空气传感器/断开连接失败
	 $('#ug40-'+ obj.data_id + '-field33').text(obj.hot_water_temp_sensor);              //热水温度传感器/断开连接失败
	 $('#ug40-'+ obj.data_id + '-field34').text(obj.chilled_water_temp);                 //冷冻水温度传感器/断开连接失败
	 $('#ug40-'+ obj.data_id + '-field35').text(obj.outdoor_temp_sensor);                //室外温度传感器/断开连接失败
	 $('#ug40-'+ obj.data_id + '-field36').text(obj.deliv_air_temp_sensor);              //交付空气温度传感器/断开连接失败
	 $('#ug40-'+ obj.data_id + '-field37').text(obj.room_humid);                         //房间的湿度传感器/断开连接失败
	 $('#ug40-'+ obj.data_id + '-field38').text(obj.water_outlet_temp);                  //冷冻水出口Temp.Sensor失败/断开连接
	 $('#ug40-'+ obj.data_id + '-field39').text(obj.compress1_alarm);                    //压缩机1:小时计数器阈值报警
	 $('#ug40-'+ obj.data_id + '-field40').text(obj.compress2_alarm);                    //压缩机2:小时计数器阈值报警
	 $('#ug40-'+ obj.data_id + '-field41').text(obj.compress3_alarm);                    //压缩机3:小时计数器阈值报警
	 $('#ug40-'+ obj.data_id + '-field42').text(obj.compress4_alarm);                    //压缩机4:小时计数器阈值报警
	 $('#ug40-'+ obj.data_id + '-field43').text(obj.air_filter);                         //空气过滤器:小时计数器阈值报警
	 $('#ug40-'+ obj.data_id + '-field44').text(obj.heater1_alarm);                      //加热器1:小时计数器阈值报警
	 $('#ug40-'+ obj.data_id + '-field45').text(obj.heater2_alarm);                      //加热器2:小时计数器阈值报警
	 $('#ug40-'+ obj.data_id + '-field46').text(obj.humid_alarm);                        //加湿器:小时计数器阈值报警
	 $('#ug40-'+ obj.data_id + '-field47').text(obj.air_cond_unit);                      //空调机组:小时计数器阈值报警
	 $('#ug40-'+ obj.data_id + '-field48').text(obj.digital_input2);                     //警报通过数字输入2
	 $('#ug40-'+ obj.data_id + '-field49').text(obj.digital_input4);                     //警报通过数字输入4
	 $('#ug40-'+ obj.data_id + '-field50').text(obj.digital_input6);                     //警报通过数字输入6
	 $('#ug40-'+ obj.data_id + '-field51').text(obj.humid_general);                      //加湿器通用报警
	 $('#ug40-'+ obj.data_id + '-field52').text(obj.unit);                               //单位在报警
	 $('#ug40-'+ obj.data_id + '-field53').text(obj.unit_rotation);                      //单位在旋转报警
	 $('#ug40-'+ obj.data_id + '-field54').text(obj.unit_a);                             //单位在报警A型
	 $('#ug40-'+ obj.data_id + '-field55').text(obj.unit_b);                             //单位在报警B型
	 $('#ug40-'+ obj.data_id + '-field56').text(obj.unit_c);                             //单位在报警C型
	 $('#ug40-'+ obj.data_id + '-field57').text(obj.dc_switch);                          //DX /连续波开关TC单位
	 $('#ug40-'+ obj.data_id + '-field58').text(obj.sw_switch);                          //夏季/冬季开关
	 $('#ug40-'+ obj.data_id + '-field59').text(obj.unit_switch);                        //单位开/关开关
	 $('#ug40-'+ obj.data_id + '-field60').text(obj.unit_reset);                         //蜂鸣器报警单元复位
	 $('#ug40-'+ obj.data_id + '-field61').text(obj.filter_reset);                       //过滤器运行小时重置
	 $('#ug40-'+ obj.data_id + '-field62').text(obj.comp1_run_reset);                    //压缩机运行1小时重置
	 $('#ug40-'+ obj.data_id + '-field63').text(obj.comp2_run_reset);                    //压缩机运行2小时重置
	 $('#ug40-'+ obj.data_id + '-field64').text(obj.comp3_run_reset);                    //压缩机运行3小时重置
	 $('#ug40-'+ obj.data_id + '-field65').text(obj.comp4_run_reset);                    //压缩机运行4小时重置
	 $('#ug40-'+ obj.data_id + '-field66').text(obj.heater1_run_reset);                  //加热器运行1小时重置
	 $('#ug40-'+ obj.data_id + '-field67').text(obj.heater2_run_reset);                  //加热器运行2小时重置
	 $('#ug40-'+ obj.data_id + '-field68').text(obj.heater1_start_reset);                //加热器1开始重置
	 $('#ug40-'+ obj.data_id + '-field69').text(obj.heater2_start_reset);                //加热器2开始重置
	 $('#ug40-'+ obj.data_id + '-field70').text(obj.humid_run_reset);                    //增湿器运行小时重置
	 $('#ug40-'+ obj.data_id + '-field71').text(obj.humid_start_reset);                  //增湿器开始重置
	 $('#ug40-'+ obj.data_id + '-field72').text(obj.unit_run_reset);                     //单位运行时间重置
	 $('#ug40-'+ obj.data_id + '-field73').text(obj.setback_mode);                       //挫折模式(睡眠模式)
	 $('#ug40-'+ obj.data_id + '-field74').text(obj.sleep_mode_test);                    //睡眠模式测试
	 $('#ug40-'+ obj.data_id + '-field75').text(obj.lm_usage_values);                    //平均值
	 $('#ug40-'+ obj.data_id + '-field76').text(obj.sb_unit_no);                         //备用单元
	 $('#ug40-'+ obj.data_id + '-field77').text(obj.unit2_rotation);                     //第2单元旋转报警
	 $('#ug40-'+ obj.data_id + '-field78').text(obj.unit3_rotation);                     //第3单元旋转报警
	 $('#ug40-'+ obj.data_id + '-field79').text(obj.unit4_rotation);                     //第4单元旋转报警
	 $('#ug40-'+ obj.data_id + '-field80').text(obj.unit5_rotation);                     //第5单元旋转报警
	 $('#ug40-'+ obj.data_id + '-field81').text(obj.unit6_rotation);                     //第6单元旋转报警
	 $('#ug40-'+ obj.data_id + '-field82').text(obj.unit7_rotation);                     //第7单元旋转报警
	 $('#ug40-'+ obj.data_id + '-field83').text(obj.unit8_rotation);                     //第8单元旋转报警
	 $('#ug40-'+ obj.data_id + '-field84').text(obj.unit9_rotation);                     //第9单元旋转报警
	 $('#ug40-'+ obj.data_id + '-field85').text(obj.unit10_rotation);                    //第10单元旋转报警
	 $('#ug40-'+ obj.data_id + '-field86').text(obj.room_temp);                          //房间温度
	 $('#ug40-'+ obj.data_id + '-field87').text(obj.outdoor_temp);                       //室外温度
	 $('#ug40-'+ obj.data_id + '-field88').text(obj.deliv_air_temp);                     //交付空气温度
	 $('#ug40-'+ obj.data_id + '-field89').text(obj.chill_water_temp);                   //冷水温度
	 $('#ug40-'+ obj.data_id + '-field90').text(obj.hot_water_temp);                     //热水温度
	 $('#ug40-'+ obj.data_id + '-field91').text(obj.room_rela_humid);                    //房间相对湿度
	 $('#ug40-'+ obj.data_id + '-field92').text(obj.outlet_water_temp);                  //出口冷冻水温度
	 $('#ug40-'+ obj.data_id + '-field93').text(obj.circuit1_evap_press);                //电路1蒸发压力
	 $('#ug40-'+ obj.data_id + '-field94').text(obj.circuit2_evap_press);                //电路2蒸发压力
	 $('#ug40-'+ obj.data_id + '-field95').text(obj.circuit1_suct_temp);                 //电路1吸入温度
	 $('#ug40-'+ obj.data_id + '-field96').text(obj.circuit2_suct_temp);                 //电路2吸入温度
	 $('#ug40-'+ obj.data_id + '-field97').text(obj.circuit1_evap_temp);                 //电路1蒸发温度
	 $('#ug40-'+ obj.data_id + '-field98').text(obj.circuit2_evap_temp);                 //电路2蒸发温度
	 $('#ug40-'+ obj.data_id + '-field99').text(obj.circuit1_superheat);                 //电路1过热
	 $('#ug40-'+ obj.data_id + '-field100').text(obj.circuit2_superheat);                 //电路2过热
	 $('#ug40-'+ obj.data_id + '-field101').text(obj.cold_water_ramp);                    //冷水阀坡道
	 $('#ug40-'+ obj.data_id + '-field102').text(obj.hot_water_ramp);                     //热水出水阀坡道
	 $('#ug40-'+ obj.data_id + '-field103').text(obj.evap_fan_speed);                     //蒸发风扇转速
	 $('#ug40-'+ obj.data_id + '-field104').text(obj.cool_set);                           //冷却定位点
	 $('#ug40-'+ obj.data_id + '-field105').text(obj.cool_sensit);                        //冷却的敏感性
	 $('#ug40-'+ obj.data_id + '-field106').text(obj.cool_set2);                          //第二个冷却定位点
	 $('#ug40-'+ obj.data_id + '-field107').text(obj.heat_se);                            //加热定位点
	 $('#ug40-'+ obj.data_id + '-field108').text(obj.heat_set2);                          //第二次加热定位点
	 $('#ug40-'+ obj.data_id + '-field109').text(obj.heat_sensit);                        //听力敏感性
	 $('#ug40-'+ obj.data_id + '-field110').text(obj.high_room_temp_thres);               //房间温度高报警阈值
	 $('#ug40-'+ obj.data_id + '-field111').text(obj.low_room_temp_thres);                //室温低报警阈值
	 $('#ug40-'+ obj.data_id + '-field112').text(obj.cool_set_mode);                      //挫折模式:冷却定位点
	 $('#ug40-'+ obj.data_id + '-field113').text(obj.heat_set_mode);                      //挫折模式:加热定位点
	 $('#ug40-'+ obj.data_id + '-field114').text(obj.cws_to_sd);                          //连续波选点开始除湿
	 $('#ug40-'+ obj.data_id + '-field115').text(obj.cw_high_temp_thres);                 //连续波高温报警阈值
	 $('#ug40-'+ obj.data_id + '-field116').text(obj.cws_to_scwom);                       //连续波选点开始连续波操作模式(只有TC单位)
	 $('#ug40-'+ obj.data_id + '-field117').text(obj.radcool_set);                        //Radcooler定位点在节能模式
	 $('#ug40-'+ obj.data_id + '-field118').text(obj.radcooler_set_dx);                   //Radcooler定位点在DX模式
	 $('#ug40-'+ obj.data_id + '-field119').text(obj.del_temp_low_set);                   //排气温度下限设定值
	 $('#ug40-'+ obj.data_id + '-field120').text(obj.serial_trans);                       //自动均值/局部转换的三角洲温度
	 $('#ug40-'+ obj.data_id + '-field121').text(obj.delta_temp);                         //串行传输抵消
	 $('#ug40-'+ obj.data_id + '-field122').text(obj.unit2_room_temp);                    //局域网单元二室温
	 $('#ug40-'+ obj.data_id + '-field123').text(obj.unit3_room_temp);                    //局域网单元三室温
	 $('#ug40-'+ obj.data_id + '-field124').text(obj.unit4_room_temp);                    //局域网单元四室温
	 $('#ug40-'+ obj.data_id + '-field125').text(obj.unit5_room_temp);                    //局域网单元五室温
	 $('#ug40-'+ obj.data_id + '-field126').text(obj.unit6_room_temp);                    //局域网单元六室温
	 $('#ug40-'+ obj.data_id + '-field127').text(obj.unit7_room_temp);                    //局域网单元七室温
	 $('#ug40-'+ obj.data_id + '-field128').text(obj.unit8_room_temp);                    //局域网单元八室温
	 $('#ug40-'+ obj.data_id + '-field129').text(obj.unit9_room_temp);                    //局域网单元九室温
	 $('#ug40-'+ obj.data_id + '-field130').text(obj.unit10_room_temp);                   //局域网单元十室温
	 $('#ug40-'+ obj.data_id + '-field131').text(obj.unit2_room_humid);                   //二单元保温室
	 $('#ug40-'+ obj.data_id + '-field132').text(obj.unit3_room_humid);                   //三单元保温室
	 $('#ug40-'+ obj.data_id + '-field133').text(obj.unit4_room_humid);                   //四单元保温室
	 $('#ug40-'+ obj.data_id + '-field134').text(obj.unit5_room_humid);                   //五单元保温室
	 $('#ug40-'+ obj.data_id + '-field135').text(obj.unit6_room_humid);                   //六单元保温室
	 $('#ug40-'+ obj.data_id + '-field136').text(obj.unit7_room_humid);                   //七单元保温室
	 $('#ug40-'+ obj.data_id + '-field137').text(obj.unit8_room_humid);                   //八单元保温室
	 $('#ug40-'+ obj.data_id + '-field138').text(obj.unit9_room_humid);                   //九单元保温室
	 $('#ug40-'+ obj.data_id + '-field139').text(obj.unit10_room_humid);                  //十单元保温室
	 $('#ug40-'+ obj.data_id + '-field140').text(obj.air_filter_run);                     //空气过滤器
	 $('#ug40-'+ obj.data_id + '-field141').text(obj.unit_run);                           //运行单位
	 $('#ug40-'+ obj.data_id + '-field142').text(obj.comp1_run);                          //空压机1运行
	 $('#ug40-'+ obj.data_id + '-field143').text(obj.comp2_run);                          //空压机2运行
	 $('#ug40-'+ obj.data_id + '-field144').text(obj.comp3_run);                          //空压机3运行
	 $('#ug40-'+ obj.data_id + '-field145').text(obj.comp4_run);                          //空压机4运行
	 $('#ug40-'+ obj.data_id + '-field146').text(obj.heat1_run);                          //加热器1运行
	 $('#ug40-'+ obj.data_id + '-field147').text(obj.heat2_run);                          //加热器2运行
	 $('#ug40-'+ obj.data_id + '-field148').text(obj.humid_run);                          //加湿器运行
	 $('#ug40-'+ obj.data_id + '-field149').text(obj.dehumid_prop_band);                  //除湿器支撑带
	 $('#ug40-'+ obj.data_id + '-field150').text(obj.humid_prop_band);                    //加湿器支撑带
	 $('#ug40-'+ obj.data_id + '-field151').text(obj.high_humid_thres);                   //高湿度报警阈值
	 $('#ug40-'+ obj.data_id + '-field152').text(obj.low_humid_thres);                    //低湿度报警阈值
	 $('#ug40-'+ obj.data_id + '-field153').text(obj.dehumid_set);                        //除湿定位点
	 $('#ug40-'+ obj.data_id + '-field154').text(obj.dehumid_set_mode);                   //除湿定位点逆流模式
	 $('#ug40-'+ obj.data_id + '-field155').text(obj.humid_set);                          //加湿定位点
	 $('#ug40-'+ obj.data_id + '-field156').text(obj.humid_set_mode);                     //加湿定位点逆流模式
	 $('#ug40-'+ obj.data_id + '-field157').text(obj.res_delay);                          //重新启动延迟
	 $('#ug40-'+ obj.data_id + '-field158').text(obj.low_press_delay);                    //低压延迟
	 $('#ug40-'+ obj.data_id + '-field159').text(obj.th_limit_delay);                     //温度/湿度限制告警延迟
	 $('#ug40-'+ obj.data_id + '-field160').text(obj.anti_hunt);                          //防震荡常数
	 $('#ug40-'+ obj.data_id + '-field161').text(obj.cycle);                              //备用循环基准时间
	 $('#ug40-'+ obj.data_id + '-field162').text(obj.lan_units_num);                      //局域网的数量单位
	 $('#ug40-'+ obj.data_id + '-field163').text(obj.circuit1_elec);                      //电路1电子阀的位置
	 $('#ug40-'+ obj.data_id + '-field164').text(obj.circuit2_elec);                      //电路2电子阀的位置
     
}
if(model == "psm-6")
{
	$('#psm06-'+ obj.data_id + '-field0').html(obj.Data." ".obj.Time);
	$('#psm06-'+ obj.data_id + '-field1').html(obj.ac_type);
	$('#psm06-'+ obj.data_id + '-field2').html(obj.p_in_v_max_limiting + 'V');
	$('#psm06-'+ obj.data_id + '-field3').html(obj.p_in_v_min_limiting + 'V');
	$('#psm06-'+ obj.data_id + '-field4').html(obj.output_count);
	$('#psm06-'+ obj.data_id + '-field5').html(obj.rc_model_count);
	$('#psm06-'+ obj.data_id + '-field6').html(obj.battery_count + '组');
	$('#psm06-'+ obj.data_id + '-field7').html(obj.battery_capacity + 'Ah');
	$('#psm06-'+ obj.data_id + '-field8').html(obj.charge_float_v + 'V');
	$('#psm06-'+ obj.data_id + '-field9').html(obj.charge_average_v + 'V');
	$('#psm06-'+ obj.data_id + '-field10').html(obj.charge_average_timer + '天');
	$('#psm06-'+ obj.data_id + '-field11').html(obj.charge_average_time + '小时');
	$('#psm06-'+ obj.data_id + '-field12').html(obj.charge_modulus);
	$('#psm06-'+ obj.data_id + '-field13').html(obj.ac_type + 'mΩ');
	$('#psm06-'+ obj.data_id + '-field14').html(obj.ac_type + 'A');
	$('#psm06-'+ obj.data_id + '-field15').html(obj.ac_type + 'A');
	$('#psm06-'+ obj.data_id + '-field16').html(obj.feeder_resistance);
	$('#psm06-'+ obj.data_id + '-field17').html(obj.charge_limit_i);
	$('#psm06-'+ obj.data_id + '-field18').html(obj.charge_average_trans_i);
	$('#psm06-'+ obj.data_id + '-field19').html(obj.low_battery_alert_v);
	$('#psm06-'+ obj.data_id + '-field20').html(obj.low_battery_protect_v);
	$('#psm06-'+ obj.data_id + '-field21').html(obj.low_battery_autoprotect == "1" ? "是" : "否");
	$('#psm06-'+ obj.data_id + '-field22').html(obj.dev_addr);

	for(var i=23;i<obj.output_count+23;i++){
       $('#psm06-output-'+ obj.data_id + '-field'+i).html(obj.output_num[i]);
    }
	for(var i=obj.output_count+24;i<obj.rc_model_count+obj.output_count+24;i++){
	   $('#psm06-model-'+ obj.data_id + '-field'+i).html(obj.rc_model_addrs[i]);
	}
	
}
if(model == "fresh_air")
{
	$('#fresh-air-'+ obj.data_id + '-field0').html(obj.Data." ".obj.Time);
	$('#fresh-air-'+ obj.data_id + '-field1').html(obj.temperature1 + '°C');
	$('#fresh-air-'+ obj.data_id + '-field2').html(obj.temperature2 + '°C');
	$('#fresh-air-'+ obj.data_id + '-field3').html(obj.temperature3 + '°C');
	$('#fresh-air-'+ obj.data_id + '-field4').html(obj.temperature4 + '°C');
	$('#fresh-air-'+ obj.data_id + '-field5').html(obj.temperature5 + '°C');
	$('#fresh-air-'+ obj.data_id + '-field6').html(obj.humidity1 + '%');
	$('#fresh-air-'+ obj.data_id + '-field7').html(obj.humidity2 + '%');
	$('#fresh-air-'+ obj.data_id + '-field8').html(obj.humidity3 + '%');
	$('#fresh-air-'+ obj.data_id + '-field9').html(obj.humidity4 + '%');
	$('#fresh-air-'+ obj.data_id + '-field10').html(obj.humidity5 + '%');
	$('#fresh-air-'+ obj.data_id + '-field11').html(obj.wind_temperature + '°C');
	$('#fresh-air-'+ obj.data_id + '-field12').html(obj.wind_humidity + '%');
	$('#fresh-air-'+ obj.data_id + '-field13').html(obj.outside_temperature + '°C');
	$('#fresh-air-'+ obj.data_id + '-field14').html(obj.outside_humidity + '%');
	$('#fresh-air-'+ obj.data_id + '-field15').html(obj.humidifier_current);
	$('#fresh-air-'+ obj.data_id + '-field16').html(obj.average_temperature + '°C');
	$('#fresh-air-'+ obj.data_id + '-field17').html(obj.average_humidity + '%');
	$('#fresh-air-'+ obj.data_id + '-field18').html(obj.highest_temperature + '°C');
	$('#fresh-air-'+ obj.data_id + '-field19').html(obj.runstate_pump);
	$('#fresh-air-'+ obj.data_id + '-field20').html(obj.runstate_ac);
	$('#fresh-air-'+ obj.data_id + '-field21').html(obj.setting_temperature + '°C');
	$('#fresh-air-'+ obj.data_id + '-field22').html(obj.setting_humidity + '%');
	$('#fresh-air-'+ obj.data_id + '-field23').html(obj.high_temperature_alert + '°C');
	$('#fresh-air-'+ obj.data_id + '-field24').html(obj.low_temperature_alert + '°C');
	$('#fresh-air-'+ obj.data_id + '-field25').html(obj.high_humidity_alert + '%');
	$('#fresh-air-'+ obj.data_id + '-field26').html(obj.low_humidity_alert + '%');
	
}

if(model.indexOf("-ac") > 0){		
    $('#' + obj.data_id +'-update_datetime').html(obj.Date+" "+obj.Time);
	if(model.search(/-ac$/) != -1){
		$('#' + obj.data_id +'-ia').html(obj.ia.toFixed(3));
		$('#' + obj.data_id +'-ib').html(obj.ib.toFixed(3));
		$('#' + obj.data_id +'-ic').html(obj.ic.toFixed(3));
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
			$("#" + obj.data_id + '-p40_43-field' + i).text(obj.p40_43[i]);//p40_43数据有问题
		}
		if($('#' + obj.data_id + '-sps-ac-2 tbody').children().length == 0){
			//这个地方生成本设备协议的显示界面
			var columnsCount = $('#' + obj.data_id + '-sps-ac-2 thead>tr>th').length;
			var trObj = $('<tr></tr>');
			for(var j = 0; j < columnsCount; j++)
			{
				trObj.append('<td><span class="label label-success"></span></td>');
			}
			for(var j = 0 ; j < obj.ac_channel.length ; j++)
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
			for(var j = 0 ; j < obj.ac_channel.length ; j++){
				var tTrObj = trObj.clone();
				tTrObj.find("td:eq(0)").text('交流通道'+ (j+1));
				$('#' + obj.data_id + '-sps-ac-3 tbody').append(tTrObj);
			}
		}
		var trObj = $('#' + obj.data_id + '-sps-ac-2 tbody>tr:eq(0)');
		var alertTrObj = $('#' + obj.data_id + '-sps-ac-3 tbody>tr:eq(0)');
		for(var j = 0 ; j < obj.ac_channel.length ; j++)
		{
			var channelObj = obj.ac_channel[j];
			trObj.find("td:eq(1)").text(channelObj.a.toFixed(3));
			trObj.find("td:eq(2)").text(channelObj.b.toFixed(3));
			trObj.find("td:eq(3)").text(channelObj.c.toFixed(3));
			trObj.find("td:eq(4)").text(channelObj.f.toFixed(3));
			for(var i=0; i < channelObj.p40_41_count.length; i++)
			{
				trObj.find("td:eq(" + (i+5) + ")").text(channelObj.p40_41[i]); //p40_41数据有问题
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
	}
}
if(model.indexOf("-dc") > 0){
	 $('#' + obj.data_id +'-update_datetime').html(obj.Date+" "+obj.Time);
	 if(model.search(/-dc$/) != -1)
	 {
			$('#'+ obj.data_id +'-v').html(obj.v.toFixed(3));
			$('#'+ obj.data_id +'-i').html(obj.i.toFixed(3));
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

if(model.indexOf("-rc") > 0){
	 $('#' + obj.data_id +'-update_datetime').html(obj.Date+" "+obj.Time);
	  if(model.search(/-rc$/) != -1)
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
		}
}

if(model == "battery24_voltage"||model == 'motor_battery'||model == 'humid'||model == 'temperature'||model == 'water'){
	$('#updata').html(obj.Date+" "+obj.Time);
	$('#value').html(obj.value.toFixed(3));
}
</script>
<?php if(in_array($model,array('power_302a'))){ ?>
	<div class="tab-pane active" id="device-<?echo $dataObj->data_id; ?>">
		<table
			class="table table-bordered table-striped responsive table-sortable">
			<thead>
				<tr>
					<th>序号</th>
					<th>信号量</th>
					<th>A相值</th>
					<th>B相值</th>
					<th>C相值</th>
					<th>合相值</th>
				</tr>
			</thead>
			<tbody class='rt-data 302a_power' data_id='<?php echo $dataObj->data_id;?>'>
			     <?php $i=1; foreach(Defines::$g302APower as $key){ ?>
					<?php if($key == "无功功率" || $key == "视在功率"){ continue; } ?>
	             <tr id="power302a-<?php echo $dataObj->data_id."-".$i; ?>"> 
					<td><?php echo $i++;?></td>
					<td><?php echo $key; ?></td>
					<td><span></span></td>
					<td><span></span></td>
					<td><span></span></td>
					<td><span></span></td>
				</tr>
				<?php } ?>
	        </tbody>
		</table>
	</div>
<?php } ?>
<?php if(in_array($model,array('battery_24','battery_32'))){ ?> 
    <table
		class="table table-bordered table-striped responsive table-sortable"
		id="bat_voltage_<?php echo $dataObj->data_id;?>">
		<thead>
			<tr>
				<th>节号</th>
				<th>电压</th>
				<th>节号</th>
				<th>电压</th>
				<th>节号</th>
				<th>电压</th>
				<th>节号</th>
				<th>电压</th>
			</tr>
		</thead>
		<tbody>				
    <?php $row = count($dataObj->battery_voltage);
    for ($j = 0; $j < $row; $j += 4) {?>
	    <tr>
				<td><?php echo $j+1;?></td>
				<td bat_num='<?php echo $j;?>'><span></span>&nbsp;</td>
				<td><?php echo $j+2;?></td>
				<td bat_num='<?php echo $j+1;?>'><span></span>&nbsp;</td>		
				<td><?php echo $j+3;?></td>
				<td bat_num='<?php echo $j+2;?>'><span></span>&nbsp;</td>
				<td><?php echo $j+4;?></td>
				<td bat_num='<?php echo $j+3;?>'><span></span>&nbsp;</td>				
		</tr>
	 <?php }?>                              
        </tbody>
    </table>
<?php } ?>

<?php if(in_array($model,array('humid','temperature','water','battery24_voltage','motor_battery'))){ ?> 
	<table
		class="table table-bordered responsive table-striped table-sortable">
		<thead>
			<tr class="trth">
			    <th>更新时间</th>
				<th>数据值</th>
			</tr>
		</thead>
		<tbody>
        <tr>
			<td id='updata'><span></span></td>
			<td id='value'><span></span></td>
		</tr>
       </tbody>
	</table>
<?php } ?>

<?php if(strpos($model,"-ac")!== false){?>
	<p>数据采集时间时间:<span id="<?php echo $dataObj->data_id;?>-update_datetime"></span>
	<table
		class="table table-bordered responsive table-striped table-sortable"
		id='<?php echo $dataObj->data_id;?>-sps-ac-1'>
		<thead>
			<tr>
				<th>序号</th>
				<th>信号名称</th>
				<th>采集值</th>
			</tr>
		</thead>
		<tbody>
		 <?php if(isset($ia_support) && $ia_support){ ?>
		 <tr>
		   <td>1</td>
		   <td>交流屏输出电流A</td>
		   <td><span class="label label-success"  id="<?php echo $dataObj->data_id.'-ia'; ?>"></span></td>
		 </tr>
		 <?php } ?>
		  <?php if(isset($ib_support) && $ib_support){ ?>
		 <tr>
		   <td>2</td>
		   <td>交流屏输出电流B</td>
		   <td><span class="label label-success"  id="<?php echo $dataObj->data_id.'-ib'; ?>"></span></td>
		 </tr>
		 <?php } ?>
		  <?php if(isset($ic_support) && $ic_support){ ?>
		 <tr>
		   <td>3</td>
		   <td>交流屏输出电流C</td>
		   <td><span class="label label-success" id="<?php echo $dataObj->data_id.'-ic'; ?>"></span></td>
		 </tr>
		 <?php } ?>
		 <tr>
		   <td>4</td>
		   <td>交流输入路数</td>
		   <td><span class="label label-success" id="<?php echo $dataObj->data_id.'-channel_count'; ?>"></span></td>
		 </tr>
		 <?php $p40_43_index = -1; 
		   foreach ($p40_43_label as $key => $val){
	            if(!$val)continue;  $p40_43_index++;?>
		   <tr id="<?php echo $dataObj->data_id.'-p40_43'.$p40_43_index; ?>">
				<td></td>
				<td><?php echo $key;?></td>
				<td><span class="label label-success" id='<?php echo $dataObj->data_id.'-p40_43-field'.$p40_43_index;?>'></span></td>	       
	       </tr>
	    <?php }?>   
		 <?php if(isset($ia_alert_support) && $ia_alert_support){ ?>
		 <tr>
		   <td></td>
		   <td>A相输入电流告警状态</td>
		   <td><span class="label label-success" id="<?php echo $dataObj->data_id.'-ia_alert'; ?>"></span></td>
		 </tr>
		 <?php } ?>
		  <?php if(isset($ib_alert_support) && $ib_alert_support){ ?>
		 <tr>
		   <td></td>
		   <td>B相输入电流告警状态</td>
		   <td><span class="label label-success"  id="<?php echo $dataObj->data_id.'-ib_alert'; ?>"></span></td>
		 </tr>
		 <?php } ?>
		  <?php if(isset($ic_alert_support) && $ic_alert_support){ ?>
		 <tr>
		   <td></td>
		   <td>C相输入电流告警状态</td>
		   <td><span class="label label-success"  id="<?php echo $dataObj->data_id.'-ic_alert'; ?>"></span></td>
		 </tr>
		 <?php } ?>
		 <tr  id="<?php echo $dataObj->data_id."-lastTr"; ?>">
		   <td></td>
		   <td>输出空开数量</td>
		   <td id="<?php echo $dataObj->data_id.'-airlock_count'; ?>"></td>
		 </tr>
		</tbody>
	</table>
	<h4>交流输入各路采集状态</h4>
	<table  id='<?php echo $dataObj->data_id;?>-sps-ac-2'
		class="table table-bordered responsive table-striped table-sortable">
		<thead>
			<tr>
				<th>序号</th>
				<th>输入线/相电压AB/A</th>
				<th>输入线/相电压BC/B</th>
				<th>输入线/相电压CA/C</th>
				<th>输入频率</th>
				<?php foreach($p40_41_label as $key=>$support){
				    if(!$support)continue; ?>
				<th><?php echo $key; ?></th>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
	<h4>交流输入各路告警状态</h4>
	<table id='<?php echo $dataObj->data_id;?>-sps-ac-3'
		class="table table-bordered responsive table-striped table-sortable">
		<thead>
			<tr>
				<th>序号</th>
				<th>输入线/相电压AB/A告警</th>
				<th>输入线/相电压BC/B告警</th>
				<th>输入线/相电压CA/C告警</th>
				<th>频率告警</th>
				<?php foreach($p40_44_label as $key=>$show){
				     if(!$show)continue; ?>
				<th><?php echo $key; ?></th>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
<?php } ?>	

<?php if(strpos($model,"-dc")!== false){?>
	<p>最后更新时间:<span id="<?php echo $dataObj->data_id;?>-update_datetime"></span>
	<table
		class="table table-bordered responsive table-striped table-sortable"
		id='<?php echo $dataObj->data_id;?>-sps-dc-1'>
		<thead>
			<tr>
				<th>序号</th>
				<th>信号名称</th>
				<th>当前值</th>
			<tr>	
		</thead>
		<tbody>
		<tr>
		<td>1</td>
		<td>直流输出电压</td>
		<td id="<?php echo $dataObj->data_id.'-v'; ?>"></td>
		</tr>
		<tr>
		<td>2</td>
		<td>总负载电流</td>
		<td id="<?php echo $dataObj->data_id.'-i'; ?>"></td>
		</tr>
		<tr>
		<td>3</td>
		<td>监测电池分路电流数量</td>
		<td id="<?php echo $dataObj->data_id.'-m'; ?>"></td>
		</tr>
		<?php for($i=0; $i < $m; $i++){ ?>
		<tr class="dc_m">
	    	<td></td>
	    	<td>电池电流<?php echo $i+1; ?></td>
	    	<td id="<?php echo $dataObj->data_id.'-m'.$i; ?>"></td>
		</tr>
		<?php } ?>
		<tr>
		<td></td>
		<td>监测直流分路电流数</td>
		<td id="<?php echo $dataObj->data_id.'-n'; ?>"></td>
		</tr>
		<?php for($i=0; $i < $n; $i++){ ?>
		<tr class="dc_n">
	    	<td></td>
	    	<td>直流分路电流<?php echo $i+1; ?></td>
	    	<td id="<?php echo $dataObj->data_id.'-n'.$i; ?>"></td>
		</tr>
		<?php } ?>
		<?php if($dataObj->model == "zxdu58-b121v21-dc"){ ?>
		<tr>
		<td></td>
		<td>有无测试报告</td>
		<td id="<?php echo $dataObj->data_id.'-has_report'; ?>"></td>
		</tr>
		<tr>
		<td></td>
		<td>电池测试结束时间</td>
		<td id="<?php echo $dataObj->data_id.'-test_end'; ?>"></td>
		</tr>
		<tr>
		<td></td>
		<td>电池测试持续时间（分钟）</td>
		<td id="<?php echo $dataObj->data_id.'-duration_minutes'; ?>"></td>
		</tr>
		<tr>
		<td></td>
		<td>电池放电容量（Ah）</td>
		<td id="<?php echo $dataObj->data_id.'-discharge_capacity'; ?>"></td>
		</tr>
		<?php } ?>
		<?php $pi=-1;foreach($p_label as $pl=>$show){
		          $pi++; 
		          if(!$show)continue;?>
		<tr>
		<td></td>
		<td><?php echo $pl.'(用户自定义)'; ?></td>
		<td class="dc_p" id="<?php echo $dataObj->data_id."-dc_p".$pi; ?>"></td>
		</tr>
		<?php } ?>
		<tr id="<?php echo $dataObj->data_id.'-lastTr'; ?>">
		<td></td>
		<td>直流电压告警</td>
		<td id="<?php echo $dataObj->data_id.'-alert_v'; ?>"></td>
		</tr>
		
	    </tbody>
	</table>
	<h4>直流熔断丝告警</h4>
	<table
		class="table table-bordered responsive table-striped table-sortable"
		id='<?php echo $dataObj->data_id;?>-sps-dc-2'>
		<thead>
			<tr>
				<th>熔丝序号</th>
				<th>当前状态</th>
				<th>熔丝序号</th>
				<th>当前状态</th>
				<th>熔丝序号</th>
				<th>当前状态</th>
				<th>熔丝序号</th>
				<th>当前状态</th>
				<th>熔丝序号</th>
				<th>当前状态</th>
				<th>熔丝序号</th>
				<th>当前状态</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
	<h4>告警</h4>
	<table
		class="table table-bordered responsive table-striped table-sortable"
		id='<?php echo $dataObj->data_id;?>-sps-dc-5'>
		<thead>
			<tr>
				<th>序号</th>
				<th>信号名称</th>
				<th>当前状态</th>
				<th>序号</th>
				<th>信号名称</th>
				<th>当前状态</th>
				<th>序号</th>
				<th>信号名称</th>
				<th>当前状态</th>
				<th>序号</th>
				<th>信号名称</th>
				<th>当前状态</th>
			</tr>
		</thead>
		<tbody>
	        <?php $api = -1; $pi = -1; foreach ($alert_p_label as $key => $val){
	                $pi++;
	                if(is_array($val))
	                {
	                    foreach($val as $ak=>$av)
	                    {
	                        if(!$av)
	                        {
	                            continue;
	                        }
	                        $api++;
	                        if($api%4 == 0)
	                        {
	                            echo "<tr>";
	                        }
	                        ?>
	            			<td><?php echo $api+1; ?></td>
	            			<td><?php echo $ak; ?></td>
	            			<td><span class="label label-success"  id='<?php echo $dataObj->data_id.'-alert_p'.$api; ?>'></span></td>
	                    <?php }
	                }else{
	                    if(!$val){ 
	                        continue;
	                    }
	                    $api++;
	                    if($api%4 == 0)
	                    {
	                        echo "<tr>";
	                    }
	                    ?>
	        			<td><?php echo $api+1;?></td>
	        			<td><?php echo $key;?></td>
	        			<td><span class="label label-success"  id='<?php echo $dataObj->data_id.'-alert_p'.$api?>'></span></td>
	    		   <?php }  
	         if($api%4 == 3)
	               {
	                   echo "</tr>";
	               }          
	        }
	        if($api%4 != 3)
	        {
	            for($i=0; $i < (3-$api%4); $i++)
	            {
	                echo "<td></td><td></td><td></td>";
	            }
	            echo "</tr>";
	        }
	        ?>
	    </tbody>
	</table>
<?php } ?>		
	
<?php if(strpos($model,"-rc")!== false){?>
	<p>最后更新时间:<span id="<?php echo $dataObj->data_id;?>-update_datetime"></span>
	<table
		class="table table-bordered responsive table-striped table-sortable"
		id='<?php echo $dataObj->data_id;?>-rc'>
		<thead>
			<tr>
				<th>序号</th>
				<th>信号名称</th>
				<th>当前值</th>
			</tr>
		</thead>
		<tbody>
	        <tr>
				<td>1</td>
				<td>整流模块输出电压</td>
				<td id='<?php echo $dataObj->data_id.'-out_v';?>'></td>
		</tr>
		<tr>
			<td>2</td>
			<td>整流模块数量</td>
			<td id='<?php echo $dataObj->data_id.'-channel_count';?>'></td>
			</tr>
		</tbody>
	</table>
	<h4>整流输入各路状态</h4>
	<table
		class="table table-bordered responsive table-striped table-sortable"
		id='<?php echo $dataObj->data_id;?>-sps-rc-2'>
	<thead>
		<tr>
			<th>序号</th>
			<th>整流模块输出电流</th>
			<?php foreach($p41_41_label as $key=>$show){
			    if(!$show)continue; ?>
			<th class="p41_41"><?php echo $key; ?></th>
			<?php } ?>
			<th>开机/关机状态</th>
			<th>限流/不限流状态</th>
			<th>浮充/均充/测试状态</th>
			<?php foreach($p41_43_label as $key=>$show){
			    if(!$show)continue; ?>
			<th class="p41_43"><?php echo $key; ?></th>
			<?php } ?>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
	<h4>整流输入各路告警状态</h4>
	<table
		class="table table-bordered responsive table-striped table-sortable"
		id='<?php echo $dataObj->data_id;?>-sps-rc-3'>
	<thead>
		<tr>
			<th>序号</th>
			<th>整流模块故障</th>
			<?php foreach($p41_44_label as $key=>$show){
			    if(!$show)continue; ?>
			<th><?php echo $key; ?></th>
			<?php } ?>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
<?php } ?>		

<?php if(in_array($model,array('aeg-ms10se'))){ ?>
<?php
    $reg1 = array('频率F','相电压V1','相电压V2','相电压V3','相电压均值Vvavg','线电压V12','线电压V23','线电压V31','线电压均值Vlavg','相（线）电流I1','相（线）电流I2','相（线）电流I3','三相电流均值Iavg','中线电流In',
            '分相有功功率P1','分相有功功率P2','分相有功功率P3','系统有功功率Psum','分相无功功率Q1','分相无功功率Q2','分相无功功率Q3','系统无功功率Qsum','分相视在功率S1','分相视在功率S2','分相视在功率S3','系统视在功率Ssum',
            '分相功率因数PF1','分相功率因数PF2','分相功率因数PF3','系统功率因数PF','系统有功功率Psum','系统无功功率Qsum','系统视在功率Ssum');
    $reg2 = array('有功电度 Ep_imp','有功电度 Ep_exp','感性无功电度 Eq_imp','容性无功电度 Eq_exp','总有功电度 Ep_total','净有功电度 Ep_net','总电度 Eq_total','净无功电度 Eq_net');
    $di = array('DI1','DI2','DI3','DI4','DI5','DI6');
    $d_o = array('DO1','DO2','DO3','DO4','DO5','DO6');
    ?>
<h4>基本测量参数</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $dataObj->data_id;?>-aeg-ms10se-reg1'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前值</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($reg1 as $key => $val){?>
	   <tr>
			<td><?php echo $key + 1;?></td>
			<td><?php echo $val;?></td>
			<td id='aeg-ms10se-reg1-<?php echo $dataObj->data_id.'-field'.$key;?>'></td>
		</tr>
   <?php }?>
	</tbody>
</table>
<h4>电度测量参数</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $dataObj->data_id;?>-aeg-ms10se-reg2'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前值</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($reg2 as $key => $val){?>
	   <tr>
			<td><?php echo $key + 1;?></td>
			<td><?php echo $val;?></td>
			<td id='aeg-ms10se-reg2-<?php echo $dataObj->data_id.'-field'.$key;?>'></td>
		</tr>
   <?php }?>
	</tbody>
</table>
<h4>DI数据参数</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $dataObj->data_id;?>-aeg-ms10se-di'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前值</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($di as $key => $val){?>
	   <tr>
			<td><?php echo $key + 1;?></td>
			<td><?php echo $val;?></td>
			<td id='aeg-ms10se-di-<?php echo $dataObj->data_id.'-field'.$key;?>'></td>
		</tr>
   <?php }?>
	</tbody>
</table>
<h4>DO数据参数</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $dataObj->data_id;?>-aeg-ms10se-do'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前值</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($d_o as $key => $val){?>
	   <tr>
			<td><?php echo $key + 1;?></td>
			<td><?php echo $val;?></td>
			<td id='aeg-ms10se-do-<?php echo $dataObj->data_id.'-field'.$key;?>'></td>
		</tr>
   <?php }?>
	</tbody>
</table>
<?php } ?>

<?php if(in_array($model,array('fresh_air'))){ ?>
<?php
    $semaphore = array('更新时间','室内温度1','室内温度2','室内温度3','室内温度4','室内温度5','室内湿度1','室内湿度2','室内湿度3','室内湿度4','室内湿度5',
	            '出风温度','出风湿度','室外温度','室外湿度','加湿器电流','平均温度','平均湿度','最高室内温度','湿帘加湿水泵','外部空调','温度设定点',
	            '湿度设定点','高温告警点','低温告警点','高湿报警点','低湿报警点');
    ?>
    <div class="row-fluid ">
	<table
		class="table table-bordered table-striped responsive table-sortable">
		<thead>
			<tr>
				<th>序号</th>
				<th>信号量</th>
				<th>数据值</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($semaphore as $key => $val){?>
			<tr>
				<td><?php echo $key + 1;?></td>
				<td><?php echo $val;?></td>
				<td id='fresh-air-<?php echo $dataObj->data_id.'-field'.$key;?>'></td>
			</tr>
		<?php }?>	
		</tbody>
	</table>
</div>
<?php } ?>	

<?php if(in_array($model,array('datamate3000'))){ ?>
<?php
    $semaphore = array('更新时间','室内温度','室内湿度','室外温度','空调开关机状态','开机温度','关机湿度','温度设定点','温度偏差','湿度设定点','湿度偏差',
          '开/关机状态','风机状态','制冷状态','加热状态','加湿状态','除湿状态','机组状态','机组属性','高压锁定状态','低压锁定状态','排气锁定状态',
          '温度设定点','湿度设定点','高温告警点','低温告警点','高湿报警点','低湿报警点','高压报警','低压报警','高压温度告警','低压温度告警','高压湿度告警',
          '低压湿度告警','电源故障报警','短周期报警','用户自定义1报警','用户自定义2报警','主风机维护报警','加湿器维护报警','过滤网维护报警','通讯故障报警',
          '盘管冻结报警','加湿器故障报警','传感器板丢失报警','排气温度故障报警','电源丢失故障报警','电源过欠压报警','电源缺相报警','电源频率偏移报警','地板溢水报警');
    ?>
    <div class="row-fluid ">
	<table
		class="table table-bordered table-striped responsive table-sortable">
		<thead>
			<tr>
				<th>序号</th>
				<th>信号量</th>
				<th>数据值</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($semaphore as $key => $val){?>
			<tr>
				<td><?php echo $key + 1;?></td>
				<td><?php echo $val;?></td>
				<td id='datamate3000-<?php echo $dataObj->data_id.'-field'.$key;?>'></td>
			</tr>
		<?php }?>	
		</tbody>
	</table>
</div>
<?php } ?>


<?php if(in_array($model,array('liebert-ups'))){ ?>
 <?php
      $semaphore1 = array('更新时间',"AB相输出电压","BC相输出电压","CA相输出电压","A相输出电压","B相输出电压","C相输出电压","A相输出电流","B相输出电流","C相输出电流","N相输出电流","A相实际输出功率","B相实际输出功率","C相实际输出功率","旁路频率","逆变器频率",
                    "旁路AB相电压","旁路BC相电压","旁路CA相电压","电池电压","电池电流","A相视在输出功率","B相视在输出功率","C相视在输出功率","A相负载百分比","B相负载百分比","C相负载百分比","电池充电比例","电池剩余时间","电池温度","8000H");
      $semaphore2 = array("保留位","保留位","旁路开关状态","输出开关状态","整流器开关状态","电池开关状态","手动旁路开关状态","保留位","风扇故障","保留位","旁路无电压告警","旁路过压告警","旁路欠压告警","旁路频率异常","旁路相位异常","旁路晶闸管故障","旁路关闭","面板关闭旁路",
                    "旁路供电","旁路过温","整流器关闭","面板关闭整流器","整流器封锁","整流器限流","整流器过温","整流器熔丝故障","保留位","保留位","保留位","逆变供电","逆变器关闭","面板关闭逆变器","逆变器封锁","逆变器限流","逆变器过温","逆变器不同步","逆变器过压","逆变器欠压",
                    "逆变器熔丝故障","输出过压","输出欠压","输出无电压","输出波形异常","输出频率异常","逆变并机错误","接触器故障","逆变台数不够","并机线未连接","一台或多台UPS不工作","电池充电故障","电池自检中","电池自检失败","电池供电","电池放电结束","均充时间超限",
                    "母线慢速过压","电池电压低","电池熔丝故障","母线快速过压","电池接地故障","旁路逆变切换次数到","UPS过载关机","UPS过温关机","UPS紧急关机","回灌故障","保留位","UPS过载","UPS过载关机","保留位","保留位","容量未设置","参数1校验错误","参数2校验错误",
                    "参数3校验错误","告警历史校验错误","事件历史校验错误","内部电池电压低","保留位","保留位","保留位","CAN 通讯未响应");
  ?>
<div class='row-fluid'>
	<div class="span6">
      <h4>UPS遥测量</h4>
		<table
			class="table table-bordered responsive table-striped table-sortable">
			<thead>
				<tr>
					<th>序号</th>
					<th>信号量</th>
					<th>数据值</th>
					<th>告警状态</th>
                </tr>
			</thead>
			<tbody>
      <?php foreach ($semaphore1 as $key => $val){?>
                <tr>
					<td><?php echo $key + 1;?></td>
					<td><?php echo $val;?></td>
					<td id='liebert-ups1-<?php echo $dataObj->data_id.'-field'.$key;?>'><span></span></td>
					<td id='liebert-ups1-<?php echo $dataObj->data_id.'-alert'.$key;?>'><span></span></td>
                </tr>
      <?php }?>
            </tbody>
		</table>
		
		<h4>UPS遥信量</h4>
		<table
			class="table table-bordered responsive table-striped table-sortable">
			<thead>
				<tr>
					<th>序号</th>
					<th>信号量</th>
					<th>数据值</th>
					<th>告警状态</th>         
               </tr>
			</thead>
			<tbody>
        <?php foreach ($semaphore2 as $key => $val){?>
                <tr>
					<td><?php echo $key + 1;?></td>
					<td><?php echo $val;?></td>
					<td id='liebert-ups2-<?php echo $dataObj->data_id.'-field'.$key;?>'><span></span></td>
					<td id='liebert-ups2-<?php echo $dataObj->data_id.'-alert'.$key;?>'><span></span></td>
                </tr>
        <?php }?>
            </tbody>
		</table>
    </div>
</div>	
<?php } ?>

<?php if(in_array($model,array('psm-6'))){ ?>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $dataObj->data_id;?>'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>数据值</th>
		</tr>
	</thead>
	<tbody>
 	<?php
		$signalArray = array ('更新时间',"交流输入类型","输入交流过压保护值(V)","输入交流低压保护值(V)","配电输出总数","电源系统整流模块总数",
				"电池总数(组)","电池容量(Ah)","浮充电压(V)","均充电压(V)","均充时间间隔(天)","均充定时时间(小时)","充电系数",
				"馈线电阻(mΩ)","电流充电限流值(A)","均浮充转换电流(A)","电池欠压报警值","电池欠压保护值","电池欠压是否自动保护","配电监控单元地址(00-99)");
		foreach ( $signalArray as $key => $val ) {?>
   	<tr>
			<td><?php echo $key + 1;?></td>
			<td><?php echo $val;?></td>
			<td id='psm06-<?php echo $dataObj->data_id.'-field'.$key;$dataObj->output_count = id;?>'></td>
			</tr>
   <?php }?>
        </tbody>
</table>
<h4>各路配电输出序号</h4>
<?php
		$params = array ();
		for($i = 1; $i <= $dataObj->output_count; $i++) {
			$params [$i] = $i.'路';
		}
 ?>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $dataObj->data_id;?>-1'>
	<thead>
		<tr>
			<th>配电输出路</th>
			<th>配电输出序号</th>
		</tr>
	</thead>
	<tbody>
        <?php foreach ($params as $key => $val){?>
        <tr>
			<td><?php echo $val;?></td>
			<td id='psm06-output-<?php echo $dataObj->data_id.'-field'.($key-1)?>'></td>
		</tr>
        <?php }?>
    </tbody>
</table>
<h4>各整流模块地址</h4>
<?php
	$params = array ();
	for($i = 1; $i <= $dataObj->rc_model_count; $i++) {
		$params [$i] = '模块' . $i;
	}
            ?>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $dataObj->data_id;?>-2'>
	<thead>
		<tr>
			<th>模块序号</th>
			<th>模块地址</th>
		</tr>
	</thead>
	<tbody>
        <?php foreach ($params as $key=> $val){?>
        <tr>
			<td><?php echo $val;?></td>
			<td id='psm06-model-<?php echo $dataObj->data_id.'-field'.($key-1)?>'></td>
		</tr>
        <?php }?>
    </tbody>
</table>
<?php } ?>

<?php if(in_array($model,array('ug40'))){ ?>
<?php
    $semaphore = array("更新时间","系统运行","压缩机1","压缩机2","压缩机3","压缩机4","加热器1","加热器2","热风","除湿","应急工作","错误密码报警","高温报警","低温报警","高湿度报警","低湿度报警","温湿度传感器","过滤器","漏水报警","气流报警","加热器过热","高压电路1","高压电路2","低压电路1","低压电路2",'电路1电流值','电路2电流值',"气流丢失","水流丢失","连续波温度过高对除湿","连续波阀故障或水流过低",
               "水流报警","室内空气传感器/断开连接失败","热水温度传感器/断开连接失败","冷冻水温度传感器/断开连接失败","室外温度传感器/断开连接失败","交付空气温度传感器/断开连接失败","房间的湿度传感器/断开连接失败","冷冻水出口Temp.Sensor失败/断开连接","压缩机1:小时计数器阈值报警","压缩机2:小时计数器阈值报警","压缩机3:小时计数器阈值报警","压缩机4:小时计数器阈值报警","空气过滤器:小时计数器阈值报警","加热器1:小时计数器阈值报警",
               "加热器2:小时计数器阈值报警","加湿器:小时计数器阈值报警","空调机组:小时计数器阈值报警","警报通过数字输入2","警报通过数字输入4","警报通过数字输入6","加湿器通用报警","单位在报警","单位在旋转报警","单位在报警A型","单位在报警B型","单位在报警C型","DX /连续波开关TC单位","夏季/冬季开关","单位开/关开关","蜂鸣器报警单元复位","过滤器运行小时重置","压缩机运行1小时重置","压缩机运行2小时重置","压缩机运行3小时重置",
               "压缩机运行4小时重置","压缩机1开始重置","压缩机2开始重置","压缩机3开始重置","压缩机4开始重置","加热器运行1小时重置","加热器运行2小时重置","加热器1开始重置","加热器2开始重置","增湿器运行小时重置","增湿器开始重置","单位运行时间重置","挫折模式(睡眠模式)","睡眠模式测试 ","平均值","备用单元","第2单元旋转报警","第3单元旋转报警","第4单元旋转报警","第5单元旋转报警","第6单元旋转报警","第7单元旋转报警","第8单元旋转报警",
               "第9单元旋转报警","第10单元旋转报警","房间温度","室外温度","交付空气温度","冷水温度","热水温度","房间相对湿度","出口冷冻水温度","电路1蒸发压力","电路2蒸发压力","电路1吸入温度","电路2吸入温度","电路1蒸发温度","电路2蒸发温度","电路1过热","电路2过热","冷水阀坡道","热水出水阀坡道","蒸发风扇转速","冷却定位点","冷却的敏感性","第二个冷却定位点","加热定位点","第二次加热定位点","听力敏感性","房间温度高报警阈值",
               "室温低报警阈值","挫折模式:冷却定位点","挫折模式:加热定位点","连续波选点开始除湿","连续波高温报警阈值","连续波选点开始连续波操作模式(只有TC单位)","Radcooler定位点在节能模式","Radcooler定位点在DX模式","排气温度下限设定值","自动均值/局部转换的三角洲温度","串行传输抵消","局域网单元二室温","局域网单元三室温","局域网单元四室温","局域网单元五室温","局域网单元六室温","局域网单元七室温","局域网单元八室温",
               "局域网单元九室温","局域网单元十室温","二单元保温室","三单元保温室","四单元保温室","五单元保温室","六单元保温室","七单元保温室","八单元保温室","九单元保温室","十单元保温室","空气过滤器","运行单位","空压机1运行","空压机2运行","空压机3运行","空压机4运行","加热器1运行","加热器2运行","加湿器运行","除湿器支撑带","加湿器支撑带",
		       "高湿度报警阈值","低湿度报警阈值","除湿定位点","除湿定位点逆流模式","加湿定位点","加湿定位点逆流模式","重新启动延迟","低压延迟","温度/湿度限制告警延迟","防震荡常数","备用循环基准时间","局域网的数量单位","电路1电子阀的位置","电路2电子阀的位置");	 
?>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $ug40Obj->data_id;?>'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>数据值</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($semaphore as $key => $val){?>
	   <tr>
			<td><?php echo $key + 1;?></td>
			<td><?php echo $val;?></td>
			<td id='ug40-<?php echo $ug40Obj->data_id.'-field'.$key;?>'></td>
		</tr>
   <?php }?>
	</tbody>
</table>
<?php } ?>






