$(document).ready(function() {
	var dataIdArr = new Array();
	$('#devList tr').each(function() {
		dataIdArr.push($(this).attr("id"));
	});
	function refreshData() {
		$.get('/portal/refreshData', {
			dataIdArr : dataIdArr.toString(),
			model : "flunctuation"
		}, function(ret) {			
			for(var i = 0 ; i < ret.value.length ; i++)
			{
				var obj = ret.value[i];
				$('#' + obj.data_id + '>td:eq(11)').text(obj.update_datetime);
				if(!obj.isEmpty)
				{
					$('#' + obj.data_id + '>td:eq(5)').text(obj.stable_load + "w");
					$('#' + obj.data_id + '>td:eq(6)').text(obj.stable_i + "A");
					$('#' + obj.data_id + '>td:eq(7)').text(obj.load + "w");
					$('#' + obj.data_id + '>td:eq(8)').text(obj.i + "A");
					$('#' + obj.data_id + '>td:eq(9)').text(obj.sudden_flunctuation + "%");
					$('#' + obj.data_id + '>td:eq(10)').html("I0:" + obj.i0 + "<br/>I1:" + obj.i1 + "<br/>周期波动率:" + obj.period_flunctuation + "%");
				}else{
					$('#' + obj.data_id + '>td:eq(5)').text('无数据');
					$('#' + obj.data_id + '>td:eq(6)').text('无数据');
					$('#' + obj.data_id + '>td:eq(7)').text('无数据');
					$('#' + obj.data_id + '>td:eq(8)').text('无数据');
					$('#' + obj.data_id + '>td:eq(9)').text('无数据');
					$('#' + obj.data_id + '>td:eq(10)').text('无数据');
				}
			}
			
		});
	}
	refreshData();
	setInterval(refreshData, 10000);
});
