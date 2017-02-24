//function edit_clicks(imgName) {
//		if(confirm("请确认删除!")){
//			 $.get('/portal/DeleteImg',{imgName:imgName},function(data){
//				 if(data == 1){
//		    		   var n = noty({
//							text: '<span>操作成功!</span>',
//							type: 'success',
//							layout: 'topCenter',
//							closeWith: ['hover','click','button']
//						});
//		        	   }else {
//		        		   var n = noty({
//		   					text: '<span>操作失败!</span>',
//		   					type: 'success',
//		   					layout: 'topCenter',
//		   					closeWith: ['hover','click','button']
//		   				});
//
//		            	   }
//			 })
//		  }
//	};
$(document).ready(function(){
	var subid = '';
	 $(".deleteImg").click(function(){
		 var imgName = $(this).attr("val");
		 if(confirm("请确认删除!")){
			 $.get('/portal/DeleteImg',{imgName:imgName},function(data){
				 if(data == 1){
		    		   var n = noty({
							text: '<span>操作成功!</span>',
							type: 'success',
							layout: 'topCenter',
							closeWith: ['hover','click','button']
						});
		        	   }else {
		        		   var n = noty({
		   					text: '<span>操作失败!</span>',
		   					type: 'success',
		   					layout: 'topCenter',
		   					closeWith: ['hover','click','button']
		   				});

		           }
			 })
		  }
	 })
//	$('.batterylist').click(function(){
//	    subid = $(this).attr('subid');
//	   $("#deletestation").attr('hrefvalue',subid);
//	   $("#editstation").attr('href',"/portal/editsubstationGather?substationid="+subid);
//	   $("#editstations").attr('href',"/portal/editsubstation?substationid="+subid);
//	   $("#img").find("a").remove();
//	   for(var i=0;i<substationGather.length;i++){
//		  if(substationGather[i].id == subid){
//			  $('#lists').html(substationGather[i].name+'--坐标:'+substationGather[i].lat+'/'+substationGather[i].lng);
//		  }		  
//	   }
//
//	   for(var j=0;j<substationGatherimg.length;j++){
//		   if(subid == substationGatherimg[j].substation_id){			  
//                 var app=$('<a rel="group"  class="deleteImg" onclick="edit_clicks('+substationGatherimg[j].id+')" ><img style="width: 200px;height: 200px" class="example1"  src="../public/portal/Station_image/'+substationGatherimg[j].stationImage+'" />&nbsp;&nbsp;&nbsp;</a>');
//                  $("#img").append(app);
//                  
//		   }
//	   }
//	   app.find(".deleteImg").click(edit_clicks);
//	});
//   $('.groupingImg').click(function(){
//	   $("#img").find("a").remove();
//	   for(var j=0;j<substationGatherimg.length;j++){
//		   if($(this).attr('val') == substationGatherimg[j].newGrouping){
//                 var app=$('<a rel="group"  class="deleteImg" onclick="edit_clicks('+substationGatherimg[j].id+')" ><img style="width: 200px;height: 200px" class="example1"  src="../public/portal/Station_image/'+substationGatherimg[j].stationImage+'" />&nbsp;&nbsp;&nbsp;</a>');
//                  $("#img").append(app);
//		   }
//	   }
//	   //app.find(".deleteImg").click(edit_clicks);
//   });
  $('.ListImg').jqthumb({
        classname      : 'jqthumb',
        width          : 70,
        height         : 50,
        position       : { top: '50%', left: '50%' },
        showoncomplete : false,
        before         : function(oriImage){},
        after          : function(imgObj){
            $(imgObj)
                .css('opacity', 0)
                .show()
                .animate({
                    opacity: 1
                }, 2000);
        }
    });

		$("a[rel=group]").fancybox({ 
			'zoomSpeedIn': 300, 
			'zoomSpeedOut': 300, 
			'overlayShow': true ,
			'hideOnOverlayClick': true,
			'showNavArrows':true,
			'overlayColor':'#666',
			'overlayOpacity':0.5
		});
		
		$(".demo1").fancybox({
		    'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic',
			'titlePosition' : 'inside'
		});
		 
//	 $(".customGal").click(		
//			 function(){
//				 $("#pp").text($(this).attr("val"));
//			 	easyDialog.open({
//			 		  container : 'imgBox',
//			 		  fixed : false,
//			 		});
//			 });
//	 $('#imgBox').click(function(){
//		 easyDialog.close();
//	 })
    $('.example1').jqthumb({
        classname      : 'jqthumb',
        width          : 200,
        height         : 200,
        position       : { top: '50%', left: '50%' },
        showoncomplete : false,
        before         : function(oriImage){},
        after          : function(imgObj){
            $(imgObj)
                .css('opacity', 0)
                .show()
                .animate({
                    opacity: 1
                }, 2000);
        }
    });
	
}); 