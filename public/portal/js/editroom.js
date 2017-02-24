$(document).ready(function(){
	$("form:eq(0)").validate({
        rules: {
        	txtName: {
                required: true,
                minlength: 1
            }
          
        },
        messages: {
        	txtName: {
                required: '请填写机房名',
                minlength: '机房名应多于1个字'
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
		var btnObj = $(this);
		if (bRet) {
			return true;
		}
		return false;
    });
	$("#selSubstation").change(function(){
	    var SubstationId =$(this).val();
		$.get('/portal/SubstationformatCode',{SubstationId:SubstationId},function(data){
			eval("var ret = "+data);
			$("#SubstationformatCode").val(data);
		})
	})
});