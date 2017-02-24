$(document).ready(function(){
	$('.hrefvalue').click(function(){
		if(confirm("请确认删除!")){
	var	substationid=$(this).attr('hrefvalue');
       $.get("/portal/Delete_substation/",{substationid:substationid},function(data){   	   
           eval('var ret = ' + data);
    	   if(ret == "true"){
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
})
