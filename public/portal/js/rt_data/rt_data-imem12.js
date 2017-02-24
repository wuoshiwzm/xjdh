$(document).ready(function() {
	var dataIdArr2 = new Array();//imem12
	$('.rt-data').each(function() {
		if ($(this).attr('data_type') == 'imem12' && dataIdArr2.indexOf($(this).attr('data_id')) == -1) {
			dataIdArr2.push($(this).attr('data_id'));
		}
	});
	function refreshData() {
		$.get('/portal/refreshData', {
			dataIdArr2 : dataIdArr2.toString(),
			model : model,
			access_token : typeof(accessToken) == "undefined" ? "":accessToken
		}, function(ret) {
			for(var i = 0 ; i < ret.imem12Value.length ; i++)
			{
				var obj = ret.imem12Value[i];
				$('#imem12_p1_'+ obj.data_id + ' td:eq(4)').html(obj.update_datetime);
				$('#imem12_p2_'+ obj.data_id + ' td:eq(4)').html(obj.update_datetime);
				$('#imem12_p3_'+ obj.data_id + ' td:eq(4)').html(obj.update_datetime);
				$('#imem12_p4_'+ obj.data_id + ' td:eq(4)').html(obj.update_datetime);
				
				$('#imem12_p1_'+ obj.data_id+' td:eq(2)>span:eq(0)').html(obj.p1);
				$('#imem12_p1_'+ obj.data_id + ' td:eq(3)').html(obj.w1);
				$('#imem12_p2_'+ obj.data_id+' td:eq(2)>span:eq(0)').html(obj.p2);
				$('#imem12_p2_'+ obj.data_id + ' td:eq(3)').html(obj.w2);
				$('#imem12_p3_'+ obj.data_id+' td:eq(2)>span:eq(0)').html(obj.p3);
				$('#imem12_p3_'+ obj.data_id + ' td:eq(3)').html(obj.w3);
				$('#imem12_p4_'+ obj.data_id+' td:eq(2)>span:eq(0)').html(obj.p4);
				$('#imem12_p4_'+ obj.data_id + ' td:eq(3)').html(obj.w4);
			}
		});
	}
	refreshData();
	setInterval(refreshData, 10000);
});
