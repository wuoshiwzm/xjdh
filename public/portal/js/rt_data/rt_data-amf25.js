$(document).ready(function() {
	var dataIdArr9 = new Array();//amf25
	$('.rt-data').each(function() {
		if ($(this).attr('data_type') == 'amf25' && dataIdArr9.indexOf($(this).attr('data_id')) == -1) {
			dataIdArr9.push($(this).attr('data_id'));
		}
	});
	function refreshData() {
		$.get('/portal/refreshData', {
			dataIdArr9 : dataIdArr9.toString(),
			model : "amf25",
			access_token : typeof(accessToken) == "undefined" ? "" : accessToken
		}, function(ret) {	
			for(var i = 0 ; i < ret.amf25List.length ; i++)
			{
				var obj = ret.amf25List[i];
				for(var j in obj)
				{					
					$('#amf25-' + obj.data_id + '-field-' + j +' span:eq(0)').html(obj[j]);
				}
			}
		});
	}
	refreshData();
	setInterval(refreshData, 20000);
});
