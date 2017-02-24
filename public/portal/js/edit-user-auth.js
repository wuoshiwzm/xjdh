$(document).ready(function () {
	$(".gFAuth").click(function(){
    	if($(this).prop("checked"))
		{
    		$(this).parents('td').next().find("input:checkbox").prop("checked",true);
		}else{
			$(this).parents('td').next().find("input:checkbox").prop("checked",false);
		}
    	
    	//$.uniform.update($(this).parents('td').next().find("input:checkbox"));
    });
    
    $(".gSAuth").click(function(){
    	if($(this).parents("td").find("input:checkbox:checked").length == 0)
		{
    		$(this).parents("td").prev().find("input:checkbox").prop("checked",false);    		
		}else{
			$(this).parents("td").prev().find("input:checkbox").prop("checked",true);
		}
    	//$.uniform.update($(this).parents("td").prev().find("input:checkbox"));
    });
   
	$(".gFAuth,.gSAuth").change(function(){
		var pTr = $(this).parents("tr");		
		if(!pTr.find(".gFAuth").prop("checked"))
		{
			return false;
		}
		var sMajor = "";
		pTr.find(".gFAuth:checked").each(function(){
			sMajor += $(this).val() + " ";
		});
//		$.post("/admin/get_courseware", { pMajor: pTr.find(".gFAuth").val(),
//						'gSAuth' : sMajor }, function(data){
//			eval('var ret = ' + data);
//			if(ret.ret == 0)
//			{
//				
//			}else{
//				alert(ret.msg);
//			}
//		});
		
	});

	$("#sMajor").trigger("change");
});