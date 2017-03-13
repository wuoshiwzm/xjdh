$(document).ready(function(){
	var index = 0;
	function load_video(i,data_id){
			$.post('/portal/get_video_url', {data_id : data_id}, function(data){
				eval('var ret = ' + data);
				if(ret.ret == 0)
				{					
					$('.video').eq(i).html('<iframe class="realtime-video" width="730" height="600"  frameborder="no" border="0"  src="' + ret.url + '" />');
				}else{
					//alert(ret.msg);
				}
			});
	}
	function rotate_camera()
	{
		$("#videoList").empty();
		var lastIndex = index +1;
		for(var i =0; i< number; i++)
		{
			if(index == devList.length)
			{
				index = 0;
			}
			var devObj = devList[index++];
			load_video(i, devObj.data_id);
			$(".title").eq(i).text(devObj.substation_name + "-" + devObj.dev_name);
		}
		$("#showRange").text(lastIndex + "至" + index);
		//get next video group
		var nextIndex = index;
		for(var i =0; i< number; i++)
		{
			if(nextIndex == devList.length)
			{
				nextIndex = 0;
			}
			var devObj = devList[nextIndex++];
			var newDiv = $('<div  style="color:red;"></div>');
			$("#videoList").append(newDiv);
			newDiv.text(devObj.substation_name + "-" + devObj.dev_name);
		}
	}
	rotate_camera();
	setInterval(rotate_camera, second * 1000);
	
	$("#btnPrev").click(function(){
		index -= 2*number;
		if(index < 0)
		{
			index += devList.length; 
		}
		rotate_camera();
	});
	$("#btnNext").click(function(){
		rotate_camera();
	});
});
