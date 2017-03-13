$(document).ready(function(){
	$("#selCitys").change(function(){
		  $('#txtName1').val($(this).val());
	})
	$('#deleteimgs').click(function(){
		 $.get('/portal/DeleteImgFile',{stationimg:stationimg},function(data){
			 if(data == 1){
	    		   var n = noty({
						text: '<span>操作成功!</span>',
						type: 'success',
						layout: 'topCenter',
						closeWith: ['hover','click','button']
					});
	        	   }else {
	        		   var n = noty({
	   					text: '<span>没有多余图片!</span>',
	   					type: 'success',
	   					layout: 'topCenter',
	   					closeWith: ['hover','click','button']
	   				});

	           }
		 })
	})
	$("form:eq(0)").validate({
        rules: {
        	txtName: {
                required: true,             
            },
	Stationcode:{
		 required: true,  
		 maxlength:5  
		}
        },
        messages: {
        	txtName: {
                required: '请填写局站地址',
            },
        Stationcode:{
        	 required: '请填写局站编码',
        	 maxlength:'最多不能超过5位'
            }     
        }
    });
	$('#btn-submits').click(function(){
    	var bRet = true;
    	if($('#txtUsername').is(':enabled'))
		{
    		bRet = $("#txtUsername").valid() && bRet;
    		bRet = $("#txtPasswd").valid() && bRet;
    		bRet = $("#txtPasswdConfirm").valid() && bRet;
		}
		bRet = $("#txtFullName").valid() && bRet;		
		bRet = $("#txtMobile").valid() && bRet;
		bRet = $("#txtEmail").valid() && bRet;
		var btnObj = $(this);
		if (bRet) {
			return true;
		}
		return false;
    });
});