$(document).ready(function(){
	$('.deletespedv').click(function(){
		if(confirm("请确认删除!")){
	        var manageId=$(this).attr('hrefvalue');
            $.post("/portal/delete_manage/",{manageId:manageId},function(data){
    	    eval('var ret = ' + data);
    	       if(ret == "true"){
    		      var n = noty({
					    text: '<span>操作成功!</span>',
					    type: 'success',
					    layout: 'topCenter',
					    closeWith: ['hover','click','button']
				  });
    		      setTimeout(function(){
    			       window.location.reload();
    		           },1000);
        	    }else {
        		    var n = noty({
   					  text: '<span>操作失败!</span>',
   					  type: 'success',
   					  layout: 'topCenter',
   					  closeWith: ['hover','click','button']
   				   });
    	        }
    	  
            });
	    }
	 });  
});