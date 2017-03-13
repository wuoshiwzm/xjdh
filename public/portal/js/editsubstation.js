$(document).ready(function(){
	$('#deleteimgs').click(function(){
		 $.get('/portal/DeleteImgFile',{stationimg:stationimg},function(data){
			 if(data == 1){
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
	   					text: '<span>没有多余图片!</span>',
	   					type: 'success',
	   					layout: 'topCenter',
	   					closeWith: ['hover','click','button']
	   				});

	           }
		 })
	})
	$('#selCity').change(function(){
		var city = $("#selCity option:selected").text(); 
		city = city.replace("本地网","");
		$('#txtName').val(city); 
		$('#selCounty').change(function(){
			var county = $("#selCounty option:selected").text();
			county = county.replace("分局","");
			if($("#selCounty option:selected").text()!="所有分局"){
				var city_county = city+"_"+county;
				$('#txtName').val(city_county);	 
				$('#selType').click(function(){
				       var type = $("#selType option:selected").text(); 
				       type = type.replace("级局站","");
				       var city_typecounty = city+"_"+type+"_"+county+"局站名";
				       $('#txtName').val(city_typecounty); 
			     });
			}	
		});
		
		$('#selType').click(function(){
		       var type = $("#selType option:selected").text(); 
		       type = type.replace("级局站","");
		       var city_typecounty = city+"_"+type+"_";
		       $('#txtName').val(city_typecounty); 
		       $('#selCounty').change(function(){
					var county = $("#selCounty option:selected").text();
					county = county.replace("分局","");
					if($("#selCounty option:selected").text()!="所有分局"){
						var city_county = city+"_"+type+"_"+county+"局站名";
						$('#txtName').val(city_county);	 
					}	
				});
	     });

	});

	$("form:eq(0)").validate({
        rules: {
        	txtName: {
                required: true,
                remote: {
                	url: '/portal/checksubname',    
                	type: 'post',
                	data: {                     
        		        subname: function() {
        		            return $('#txtName').val();
        		        },
        		    }
                }
            },
	        Stationcode:{
		         required: true,  
		         maxlength:5  
		    }
     },
     messages: {
    	txtName: {
            required: '请填写局站地址',
            remote: '请填写局站名',
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