$(document).ready(function() {
	var dataIdArr1 = new Array();//aidi
	$('.rt-data').each(function() {
		if ($(this).attr('data_type') == 'aidi' && dataIdArr1.indexOf($(this).attr('data_id')) == -1) {
			dataIdArr1.push($(this).attr('data_id'));
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
								$('#s td:eq(2)').html(obj.value == 0 ? '<span class="label label-important">告警</span>' : '<span class="label label-success">正常</span>');
							}else if(obj.model == 'temperature'){
								$('#s td:eq(2)').html('<span class="label label-success">'+ obj.value + '°C</span>');
							}else if(obj.model == 'humid'){
								$('#s td:eq(2)').html('<span class="label label-success">'+ obj.value + '%</span>');
							}
							$('#s td:eq(3)').html(obj.save_datetime);
							$('#butt').attr("data_id",hre);
							$('#s td:eq(1) a').attr("data_id",hre);
							$('#s td:eq(1) a').attr("model",batmodel);
						}	
				}
				if(obj.model == 'water' || obj.model == 'smoke'){
					$('#device-'+ obj.data_id +'>td:eq(2)').html(obj.value == 0 ? '<span class="label label-important">告警</span>' : '<span class="label label-success">正常</span>');
				}else if(obj.model == 'temperature'){
					$('#device-'+ obj.data_id +'>td:eq(2)').html('<span class="label label-success">'+ obj.value + '°C</span>');
				}else if(obj.model == 'humid'){
					$('#device-'+ obj.data_id +'>td:eq(2)').html('<span class="label label-success">'+ obj.value + '%</span>');
				}
				$('#device-'+ obj.data_id +'>td:eq(3)' ).html(obj.save_datetime);
			}
			
		});
	}
	alert("aa");
	refreshData();
	setInterval(refreshData, 10000);
	$(".ad").click(function(){
		var hre=$(this).attr("hre");
		var hrename=$(this).attr("hrename");
		var batmodel=$(this).attr("batmodel");
		refreshData(hre,hrename,batmodel)
	})
});