$(document).ready(function(){
	$(".real").click(function(){
		var data_id = $(this).attr('data_id');
		$.post('/portal/get_video_url', {data_id:data_id}, function(data){
			eval('var ret = ' + data);
			if(ret.ret == 0)
			{
				$('#realtime-' + data_id).show();
				setTimeout(function(){
					$("#realtime-" + data_id).html('<iframe class="realtime-video" width="730" height="600"  frameborder="no" border="0"  src="' + ret.url + '" />');
				}, 5000);
			}else{
				alert(ret.msg);
			}
		});
	});
	
	$(".rst").click(function(){
		var data_id = $(this).attr('data_id');
		$.post('/portal/reload_camera_para', {data_id:data_id}, function(data){
			eval('var ret = ' + data);
			if(ret.ret == 0)
			{
				 var n = noty({
						text: '<span>加载成功</span>',
						type: 'success',
						layout: 'topCenter',
						timeout:1000,
						closeWith: ['hover','click','button']
					});
			}else{
				alert(ret.msg);
			}
		});
	});
});
