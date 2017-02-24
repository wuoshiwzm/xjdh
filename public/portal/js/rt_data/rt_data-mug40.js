$(document).ready(function() {
	var dataIdArr9 = new Array();
	$('.rt-data').each(function() {
		if ($(this).attr('data_type') == 'ug40' && dataIdArr9.indexOf($(this).attr('data_id')) == -1) {
			dataIdArr9.push($(this).attr('data_id'));
		}
	});
	function refreshData() {
		$.get('/portal/refreshData', {
			dataIdArr9 : dataIdArr9.toString(),
			model : "ug40"
		}, function(ret) {
			for(var i = 0 ; i < ret.ug40List.length ; i++)
			{
				var obj = ret.ug40List[i];
				for(var j = 0 ; j < obj.value.length ; j++)
				{
//					obj.value[j] = String.fromCharCode(obj.value[j])
					$('#ug40-' + obj.data_id + '-field' + j ).html(obj.value[j]);
				}
			}
		});
	}
	refreshData();
	setInterval(refreshData, 20000);
});
