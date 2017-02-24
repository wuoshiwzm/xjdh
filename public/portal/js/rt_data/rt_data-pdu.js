$(document).ready(function(){
	var dataIdArrVpdu = new Array();
	$('.rt-data').each(function() {
		if ($(this).attr('data_type') == 'vpdu'){
			dataIdArrVpdu.push($(this).attr('data_id'));
		}
	});

	var params = {};
	params['dataIdArrVpdu'] =  dataIdArrVpdu.toString();
	params['model'] =  "pdu";
	params['access_token']  = typeof(accessToken) == "undefined" ? "":accessToken;
	function refreshData() {
		$.get('/portal/refreshData', params, function(ret) {
			var length = ret.pduList.length;
			for(var i = 0 ; i < length ; i++)
			{
				var obj = ret.pduList[i];
				if(obj.dynamic_config != false)
				{
					$('#tb-'+ obj.data_id +'-dc>tbody').empty();
					var dcList = JSON.parse(obj.dynamic_config);
					if(dcList == null){
						$('#tb-'+ obj.data_id +'-dc').hide();
					}else{
						if(dcList.length == 0){
							$('#tb-'+ obj.data_id +'-dc').hide();
						}else
							$('#tb-'+ obj.data_id +'-dc').show();
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
							$('#tb-'+ obj.data_id +'-dc>tbody').append(trObj);
						}
					}
				}else{
					$('#tb-'+ obj.data_id +'-dc').hide();
				}				
			}	
		});
	}
	refreshData();
	setInterval(refreshData, 20000);
})
