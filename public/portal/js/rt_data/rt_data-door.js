$(document).ready(function() {	 
	$(".btnOpenDoor").click(function(){
		$("#thresholdDialog3"+ $(this).attr("data_id")).modal({
			 keyboard: true,
			 show	: true,
		});	
		$("#btn-ok-checks").unbind("click").click(function(){
			 if($("#openMessage").val() == ""){
				 alert("请填写情况说明");
				 return;
			 }
			 if(confirm("请确认远程开门操作")){
				 $.post('/portal/open_door', {data_id:$(this).attr("data_id"),openMessage:$("#openMessage").val(),action:'远程开门 '},function(data){
	                                  eval('var ret = ' + data);
					 if(ret.ret == 0)
					 {
						 var n = noty({
		  						text: '<span>开门成功</span>',
		  						type: 'success',
		  						layout: 'topCenter',
		  						timeout:1000,
		  						closeWith: ['hover','click','button']
		  					});
						 $('#thresholdDialog3').modal('hide');
						 refreshData();
					 }else{
						 var n = noty({
		  						text: '<span>' + ret.msg + '</span>',
		  						type: 'error',
		  						layout: 'topCenter',
		  						timeout:1000,
		  						closeWith: ['hover','click','button']
		  					});
					 }
				 });
			 }
		 });	
     })
     
     
     $(".btnForceOpenDoor").click(function(){
		$("#thresholdDialog3"+ $(this).attr("data_id")).modal({
			 keyboard: true,
			 show	: true,
			 
		});	
		$("#btn-ok-checks").unbind("click").click(function(){
			 if($("#openMessage").val() == ""){
				 alert("请填写情况说明");
				 return;
			 }
			 if(confirm("请确认强制远程开门操作")){
				 $.post('/portal/force_open_door', {data_id:$(this).attr("data_id"),openMessage:$("#openMessage").val(),action:'强制远程开门 '},function(data){
	                                  eval('var ret = ' + data);
					 if(ret.ret == 0)
					 {
						 var n = noty({
		  						text: '<span>开门成功</span>',
		  						type: 'success',
		  						layout: 'topCenter',
		  						timeout:1000,
		  						closeWith: ['hover','click','button']
		  					});
						 $('#thresholdDialog3').modal('hide');
						 refreshData();
					 }else{
						 var n = noty({
		  						text: '<span>' + ret.msg + '</span>',
		  						type: 'error',
		  						layout: 'topCenter',
		  						timeout:1000,
		  						closeWith: ['hover','click','button']
		  					});
					  }
				 });
			 }
		 });	
     })

	 var dataIdArr = new Array();
	 $(".door").each(function(){
		 dataIdArr.push($(this).attr('data_id'));
	 });
	 
	 function refreshData() {
		$.get('/portal/refreshData', { model : "door", dataIdArr : dataIdArr.toString() } , function(ret) {
			for(var i=0;i<ret.doorList.length;i++)
			{
				var door = ret.doorList[i];
				$("#door-" + door.data_id).text(door.door1 == 0 ? "关闭" : "开门");
			}
		});
	 }
	refreshData();
	setInterval(refreshData, 10000);
});
