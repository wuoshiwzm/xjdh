$(document).ready(function() {
	var dataIdArr1 = new Array();//aidi
	$('.rt-data').each(function() {
		if ($(this).attr('data_type') == 'aidi' && dataIdArr1.indexOf($(this).attr('data_id')) == -1) {
			dataIdArr1.push($(this).attr('data_id'));
		} 
	});
	
	$('.datepicker').datetimepicker({
		language: 'zh-CN',
		format: 'yyyy-mm-dd',
		todayBtn: true,
		autoclose: true,
		minView: 2		
	});
	$('.date-range-picker').daterangepicker({
		format: 'YYYY-MM-DD',
        separator: '至',
        timePicker: false,
    	locale: {
    		applyLabel: '选择',
    		cancelLabel: '重置',
            fromLabel: '从',
            toLabel: '到',
            weekLabel: '星期',
            customRangeLabel: '范围',
            daysOfWeek: ['日','一','二','三','四','五','六'],
            monthNames: ['一月', '二月', '三月', '四月', '五月', '六月','七月', '八月', '九月', '十月', '十一月', '十二月'],
            firstDay: 0
    	}
	});
	
	function refreshData(hre,hrename,batmodel) {
		$.get('/portal/refreshData', {
			dataIdArr1 : dataIdArr1.toString(),
			model: model,
			access_token : typeof(accessToken) == "undefined" ? "":accessToken
		}, function(ret) {	
			for(var i = 0 ; i < ret.aidiValue.length ; i++)
			{
				var obj = ret.aidiValue[i];
				if(hre !=null){
					$(".rt-data").remove();
						if(obj.data_id==hre){
							$('#s').show();
							$('#s td:eq(0)').html(i);
							$('#s td:eq(1) a').html(hrename);
							if(obj.model == 'water' || obj.model == 'smoke'){
								$('#s td:eq(2)').html(obj.alert_value > 0 ? '<span class="label label-important">告警</span>' : '<span class="label label-success">正常</span>');
							}else if(obj.model == 'temperature'){
								$('#s td:eq(2)').html(obj.alert_value > 0 ? '<span class="label label-important">'+ obj.value + '°C</span>' : '<span class="label label-success">'+ obj.value + '°C</span>' );
							}else if(obj.model == 'humid'){
								$('#s td:eq(2)').html(obj.alert_value > 0 ? '<span class="label label-important">'+ obj.value + '°%</span>' : '<span class="label label-success">'+ obj.value + '%</span>');
							}
							$('#s td:eq(3)').html(obj.save_datetime);
							$('#butt').attr("data_id",hre);
							$('#s td:eq(1) a').attr("data_id",hre);
							$('#s td:eq(1) a').attr("model",batmodel);
						}	
				}
				if(obj.model == 'water' || obj.model == 'smoke'){
					$('#device-'+ obj.data_id +'>td:eq(2)').html(obj.alert_value > 0 ? '<span class="label label-important"><a href="/portal/alarm?word=' + obj.data_id + '">告警</a></span>' : '<span class="label label-success">正常</span>');
				}else if(obj.model == 'temperature'){
					$('#device-'+ obj.data_id +'>td:eq(2)').html(obj.alert_value > 0  ? '<span class="label label-important"><a href="/portal/alarm?word=' + obj.data_id + '">' + obj.value + '°C</a></span>' : '<span class="label label-success">'+ obj.value + '°C</span>' );
				}else if(obj.model == 'humid'){
					$('#device-'+ obj.data_id +'>td:eq(2)').html(obj.alert_value > 0  ? '<span class="label label-important"><a href="/portal/alarm?word=' + obj.data_id + '">' + obj.value + '°%</a></span>' : '<span class="label label-success">'+ obj.value + '%</span>');
				}
				$('#device-'+ obj.data_id +'>td:eq(3)' ).html(obj.save_datetime);
			}
			
		});
	}
	refreshData();
	setInterval(refreshData, 10000);
	$(".ad").click(function(){
		var hre=$(this).attr("hre");
		var hrename=$(this).attr("hrename");
		var batmodel=$(this).attr("batmodel");
		refreshData(hre,hrename,batmodel)
	})
});
