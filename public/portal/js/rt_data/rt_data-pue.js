$(document).ready(function() {
	var dataIdArr = new Array();
	$('#devList tr').each(function() {
		dataIdArr.push($(this).attr("id"));
	});
	function refreshData() {
		$.get('/portal/refreshData', {
			dataIdArr : dataIdArr.toString(),
			model : "pue"
		}, function(ret) {			
			for(var i = 0 ; i < ret.value.length ; i++)
			{
				var obj = ret.value[i];
				$('#' + obj.data_id).data("all_power", obj.all_power);
				$("#" + obj.data_id).data('main_power', obj.main_power);
				$('#' + obj.data_id).data("all_power_consumption", obj.all_power_consumption);
				$('#' + obj.data_id).data("main_power_consumption", obj.main_power_consumption);
				
				$('#' + obj.data_id + '>td:eq(10)').text(obj.update_datetime);
				$('#' + obj.data_id + '>td:eq(4)').text(obj.all_power_compensate + " W");
				$('#' + obj.data_id + '>td:eq(5)').text(obj.main_power_compensate +  " W");
				$('#' + obj.data_id + '>td:eq(6)').text(obj.pue);
				$('#' + obj.data_id + '>td:eq(7)').text(obj.all_power_consumption_compensate + " W");
				$('#' + obj.data_id + '>td:eq(8)').text(obj.main_power_consumption_compensate + " W");
				$('#' + obj.data_id + '>td:eq(9)').text(obj.accumulated_pue);
			}
			
		});
	}
	refreshData();
	setInterval(refreshData, 10000);
	
	$(".setting").click(function(){
		$("#settingDialog").modal({keyboard:true,modal:true});		
		var pTr = $(this).parents("tr:eq(0)");
		$("#settingDialog").data("id", pTr.attr("id"));
		$("#allPower").text(pTr.data("all_power"));
		$("#mainPower").text(pTr.data("main_power"));
		var fAllPower = parseFloat(pTr.data("all_power"));
		var fMainPower = parseFloat(pTr.data("main_power"));
		if(fMainPower != 0)
		{
			$("#pue").text(fAllPower/fMainPower);
		}else{
			$("#pue").text("无");	
		}
		$("#settingDialog").data("id", pTr.attr("id"));
		$("#allPowerConsumption").text(pTr.data("all_power_consumption"));
		$("#mainPowerConsumption").text(pTr.data("main_power_consumption"));
		var fAllPowerConsumption = parseFloat(pTr.data("all_power_consumption"));
		var fMainPowerConsumption = parseFloat(pTr.data("main_power_consumption"));
		if(fMainPowerConsumption != 0)
		{
			$("#AccPue").text(fAllPowerConsumption/fMainPowerConsumption);
		}else{
			$("#AccPue").text("无");	
		}
		
		$.post("/portal/get_station_settings", {id:pTr.attr("id")},function(data){
			if(data == "")
			{
				$("#txtAllDevicePower,#txtMainDevicePower,#txtAllDevicePowerConsumption,#txtMainDevicePowerConsumption").val(0);
			}else{
				eval("var ret = " + data);
				$("#txtAllDevicePower").val(ret.all_power);
				$("#txtMainDevicePower").val(ret.main_power);
				$("#txtAllDevicePowerConsumption").val(ret.all_power_consumption);
				$("#txtMainDevicePowerConsumption").val(ret.main_power_consumption);
				$("#txtMainDevicePower,#txtMainDevicePowerConsumption").trigger('change');
			}
			
			
		});
		
	});
	$("#txtAllDevicePower,#txtMainDevicePower").change(function(){
		var fAllPower = parseFloat($("#allPower").text());
		var fMainPower = parseFloat($("#mainPower").text());
		var fAllPowerCom = parseFloat($("#txtAllDevicePower").val());
		if(isNaN(fAllPowerCom))
			fAllPowerCom = 0.0
		var fMainPowerCom = parseFloat($("#txtMainDevicePower").val());
		if(isNaN(fMainPowerCom))
			fMainPowerCom = 0.0;
		if( (fMainPower + fMainPowerCom) == 0)
			$("#ComPue").text("无");
		else
			$("#ComPue").text( ((fAllPower+fAllPowerCom)/(fMainPower+fMainPowerCom)).toFixed(2) );
	});
	
	$("#txtAllDevicePowerConsumption,#txtMainDevicePowerConsumption").change(function(){
		var fAllPower = parseFloat($("#allPowerConsumption").text());
		var fMainPower = parseFloat($("#mainPowerConsumption").text());
		var fAllPowerCom = parseFloat($("#txtAllDevicePowerConsumption").val());
		if(isNaN(fAllPowerCom))
			fAllPowerCom = 0.0;
		var fMainPowerCom = parseFloat($("#txtMainDevicePowerConsumption").val());
		if(isNaN(fMainPowerCom))
			fMainPowerCom = 0.0;
		if( (fMainPower+fMainPowerCom) == 0)
			$("#ComAccPue").text("无");
		else
			$("#ComAccPue").text( ((fAllPower+fAllPowerCom)/(fMainPower+fMainPowerCom)).toFixed(2) );
	});
	
	$("#btn-ok-check").click(function(){
		var allPower = $("#txtAllDevicePower").val();
		if(isNaN(allPower))
			allPower = 0.0;
		var mainPower = $("#txtMainDevicePower").val();
		if(isNaN(mainPower))
			mainPower = 0.0;
		var allPowerConsumption = $("#txtAllDevicePowerConsumption").val();
		if(isNaN(allPowerConsumption))
			allPowerConsumption = 0.0;
		var mainPowerConsumption = $("#txtMainDevicePowerConsumption").val();
		if(isNaN(mainPowerConsumption))
			mainPowerConsumption = 0.0;
		$.post("/portal/save_station_settings",{id : $("#settingDialog").data("id"), all_power:allPower, main_power:mainPower, 
			all_power_consumption:allPowerConsumption,main_power_consumption:mainPowerConsumption}, function(data){
			eval("var ret = " + data);
			if(ret.ret == 0)
			{
				var n = noty({
					text: '<span>设置成功。</span>',
					type: 'success',
					layout: 'topCenter',
					timeout : 1000,
					closeWith: ['hover','click','button']
				});
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
});
