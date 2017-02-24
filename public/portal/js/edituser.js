$(document).ready(function(){
	jQuery.validator.addMethod("alphanumeric",function( value, element,param ) {
		if(/[a-zA-Z0-9_]/.test(value))
		{
			return true;
		}else{
			return false;
		}
	},"用户名只能为数字或字母");
	
	jQuery.validator.addMethod("maximumvalue",function( value, element,param ) {
		if(parseInt($('#accessid').val())>16777216)
		{
			return false;
		}else{
			return true;
		}
	},"门禁卡号不能大于16777216");
	
	$("form:eq(0)").validate({
        rules: {
        	txtUsername:{ 
        		alphanumeric:true,
        		//必填
        		required: $('#txtUsername').is(':enabled'),
        		//最短长度
        		minlength: 5,
        		remote:{
        			url: '/portal/checkaccount',
        			type: "post"
        		}
        	},
        	txtFullName: {
                required: true,
                minlength: 2
            },
            txtPasswd: {
                required: $('#txtUsername').is(':enabled'),
                minlength: 6
            },
            txtPasswdConfirm: {
            	//等于txtpasswd
            	equalTo: $('#txtPasswd') 
            },
            txtMobile: {
                required: true,
                isMobile: true,
                remote:{
        			url: '/portal/checkphone',
        			type: "post",
        			data: {                     //要传递的数据
        		        username: function() {
        		            return $("#txtUsername").val();
        		        },
        		        txtMobile:function() {
        		            return $("#txtMobile").val();
        		        },	        
        		    }
        		}
            },
            txtEmail: {
//                required: true,
                email: true,
                remote: {
                	url: "/portal/checkemail",     //后台处理程序
                	type: "post",
                	data: {                     //要传递的数据
        		        username: function() {
        		            return $("#txtUsername").val();
        		        },
        		        txtEmail:function() {
        		            return $("#txtEmail").val();
        		        },
        		    }
                }
            },
            accessid: {
            	maximumvalue:true,
             	digits:true,
                minlength: 10,
                maxlength: 20,
                remote: {
                	url: "/portal/checkaccessid",     //后台处理程序
                	type: "post",
                	data: {                     //要传递的数据
        		        username: function() {
        		            return $("#txtUsername").val();
        		        },
        		        txtEmail:function() {
        		            return $("#accessid").val();
        		        },
        		    }
                }
            }
        },
        messages: {
        	txtUsername:{
	    		required: '请填写用户名',
	    		minlength: '用户名最短长度5个字符',
	    		remote:'该用户名已被注册，请重新输入'
	    	},
        	txtFullName: {
                required: '请填写姓名',
                minlength: '姓名不得少于2个字符'
            },
            txtPasswd: {
                required: '请填写密码',
                minlength: '密码最短长度6位'
            },
            txtPasswdConfirm: {
            	equalTo: '两次输入的密码不一致' 
            },
            txtMobile: {
                required: '请填写联系方式',
                isMobile: '请输入正确的手机或者电话号码',
                remote:'该手机号码已被注册'
            },
            txtEmail: {
//                required: '请填写邮箱地址',
                email: '请输入正确的邮箱地址',
                remote:'该电子邮箱已被注册'
            },
            accessid: {
            	
            	digits: '只能为数字',
                minlength: '门禁卡号不能少于10位',
                maxlength: '门禁卡号不能超过20位',
                remote:'该门禁卡号被占用'
            }
        }
    });
	
	$('#btn-submit').click(function(){
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
		bRet = $("#accessid").valid() && bRet;
		var btnObj = $(this);
		if (bRet) {
			return true;
		}
		return false;
    });
	
});
