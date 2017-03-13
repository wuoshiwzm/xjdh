$(document).ready(function(){
	$("form:eq(0)").validate({
        rules: {
        	selCity:{
        		required: true
        	},
        	selCounty:{
        		required: true
        	},
        	selSubstation:{
        		required: true
        	},
        	selRoom:{
        		required: true
        	},
        	txtDevNo:{
        		required: true,
        		isIntGtZero: true,
        		remote:{
        			url:'/portal/checkSmdDevce',
        			type: "post"
        		}
        	},
        	txtName:{
        		required: true,
        		remote: {
                	url: '/portal/checkdevname',    
                	type: 'post',
                	data: {                     
        		        devname: function() {
        		            return $('#txtName').val();
        		        },
        		    }
                }
        	},
        	txtIP:{
        		required: true,
        		ip: true,
        		remote: {
                	url: "/portal/checkip",     //后台处理程序
                	type: "post",
                	data: {                     //要传递的数据
                		txtDevNo: function() {
        		            return $("#txtDevNo").val();
        		        },
        		        txtEmail:function() {
        		            return $("#txtIP").val();
        		        },
        		    }
                }
            }
        },
        messages: {
        	selCity:{
        		required: '请选择分公司'
        	},
        	selCounty:{
        		required: '请选择分局'
        	},
        	selSubstation:{
        		required: '请选择局站'
        	},
        	selRoom:{
        		required: '请选择机房'
        	},
        	txtDevNo:{
        		required: '请填写设备编号',
        		isIntGtZero: '设备编号必须大于0',
        		remote:'该设备ID已经被使用，请重新输入'
        	},
        	txtName:{
        		required: '请填写设备名',
        		remote: '请重新检查设备名'
        	},
        	txtIP:{
        		required: '请填写设备IP地址',
        		ip: '请输入合法的IP地址',
        		remote:'该IP地址被占用'
        	}
        },
        ignore: ".ignore"
    });
	
	
	
	$('#selRoom').change(function(){
		var room = $("#selRoom option:selected").text(); 
		var devname = '监控设备（编号#302A（301E）智能采集板_'+room+"）";
		$('#txtName').val(devname); 
	});
	
	
	
	$('#btn-submit').click(function(){
    	var bRet = true;
    	if(!$('#txtDevNo').prop('readonly'))
		{
    		bRet = $("#txtDevNo").valid() && bRet;
		}
		bRet = $("#selCity").valid() && bRet;
		bRet = $("#selCounty").valid() && bRet;
		bRet = $("#selSubstation").valid() && bRet;		
		bRet = $("#selRoom").valid() && bRet;
		bRet = $("#txtName").valid() && bRet;
		bRet = $("#txtIP").valid() && bRet;		
		var btnObj = $(this);
		if (bRet) {
			return true;
		}
		return false;
    });
});