$(document).ready(function() {
	var dataIdArr = new Array();
	$('.rt-data').each(function() {
		if ($(this).attr('data_type') == 'motor_battery' && dataIdArr.indexOf($(this).attr('data_id')) == -1) {
			dataIdArr.push($(this).attr('data_id'));		
		}
	});
	function refreshData() {
		$.get('/portal/refreshData', {
			dataIdArr : dataIdArr.toString(),
			model : model,
			access_token : typeof(accessToken) == "undefined" ? "":accessToken
		}, function(ret) {
			var length = ret.motorBatList.length;
			for(var i = 0 ; i < length ; i++)
			{
				var obj = ret.motorBatList[i];
				$('#device-'+ obj.data_id).find('td:eq(2)').html(obj.value + ' V');	
				$('#device-'+ obj.data_id).find('td:eq(3)').html(obj.save_datetime);			
			}
		});
	}
	refreshData();
	setInterval(refreshData, 20000);
});
