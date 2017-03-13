$(document).ready(function(){
	var pre_data_id = $('#txtDataId').attr('data_id');
	var devName = '';
	 $("#selRoom").bind("change",function(){
		 $.get('/portal/Get_Sev_Name',{roomid:$(this).val()},function(data){
			 eval('var ret = ' + data);
			 devName = ret;
		 })
	 })
	  $("#selModel").bind("change",function(){
		for(var i=0;i<devName.denName.length;i++){
			if($('#txtName').val() == devName.denName[i].name){
				alert("同一个机房下不能有重复设备名字");
				$('#txtName').val('');
				return;
			}
		}
	  });
	var models =$("#selModel").find("option:selected").text();
		 $("#selModel").bind("change",function(){
			 if(pre_data_id)
			 {
				 $("#txtDataId").val(pre_data_id);
			 }
			 else
			 {
				 var city = $("#selCity").find("option:selected").val();
				 var smdid = $("#selSmdDev").find("option:selected").val();
	             var city = $("#selCity").find("option:selected").val();
				 $.post('/portal/Get_Max_data_id',{smdid:smdid,city:city},function(data){
					 eval('var ret = ' + data);					
//					 var new_data_id = ret.dataId.max_data_id * 1;
//	                                 if(new_data_id == 0)
//	                                 {
//	                                     var head = city << 22;
//	                                     head = head >>> 0;
//					     var mid = smdid << 10;
//	                                     new_data_id = head + mid + 1;   
//					 }
//					 else{									 
//					     new_data_id = new_data_id + 1;
//						 for(var i=0;i<ret.dataId.retAll.length;i++){
//							 if(ret.dataId.retAll[i].data_id == new_data_id){
//								 new_data_id = new_data_id + 1;
//							 }
//						 }
//				         }
					 $("#txtDataId").val(ret.dataId.max_data_id); 
				 });
			 }
		 });	
		 
		 function model()
		 {
			 if(models.indexOf("直流屏电源") > 0||models.indexOf("交流屏电源") > 0||models.indexOf("整流屏电源") > 0)
			 {
				 $("#group").show();
				 $("#devgroup").show();
				 $("#text1").show();
				 $("#must").show();
			 }
		 }
		 
		 $("#selModel").bind("change",function(){
			 var t_model=$("#selModel").find("option:selected").text();
			 if(t_model == "烟感" || t_model == "水浸")
			 {
				 $("#labelport").html("DI端口号     <font size=4 color=red>&nbsp;*</font>");
			 }
			 else if(t_model == "温度" || t_model == "湿度" || t_model == "蓄电池总电压")
			 {
				 $("#labelport").html("AI端口号     <font size=4 color=red>&nbsp;*</font>");
			 }
			 else if(t_model == "智能电表")
			 {
				 $("#labelport").html("智能电表端口号     <font size=4 color=red>&nbsp;*</font>");
			 }
			 else if(t_model == "智能设备")
			 {
				 $("#labelport").html("串口号     <font size=4 color=red>&nbsp;*</font>");
			 }
			 else if(t_model == "摄像头")
			 {
				 $("#labelport").html("网口端口号     <font size=4 color=red>&nbsp;*</font>");
			 }else{
				 $("#labelport").html("端口号     <font size=4 color=red>&nbsp;*</font>");
			 }
			 if(t_model.indexOf("直流屏电源") > 0||t_model.indexOf("交流屏电源") > 0||t_model.indexOf("整流屏电源") > 0)
			 {
				 $("#group").show();
				 $("#devgroup").show();
				 $("#text1").show();
				 $("#must").show();
			 }
			 else
			 {
				 $("#group").hide();
				 $("#devgroup").hide();
				 $("#text1").hide();
				 $("#must").hide();
			 }
			 if(t_model == "虚拟低压配电")
			 {
				 $("#labelport").hide();
				 $("#port").hide();
			 }
			 else
			 {
				 $("#labelport").show();
				 $("#port").show();
			 }
		 });

		 
		 $("#selModel").bind("change",function(){
			 
			 var t_model=$("#selModel").find("option:selected").text();
			 if(t_model == "门禁")
			 {
				 $("#di").show();
				 $("#diinput").show();
				 $("#do").show();
				 $("#doinput").show();
			 }
			 else
			 {
				 $("#di").hide();
				 $("#diinput").hide();
				 $("#do").hide();
				 $("#doinput").hide();

			 }
		 });

	$('.datepicker').datetimepicker({
		language: 'zh-CN',
		format: 'yyyy-mm-dd HH:ii:ss',
		todayBtn: true,
		autoclose: true	
	});
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
        	selSmdDev:{
        		required: true
        	},
        	txtName:{
        		required: true
        	},
        	selModel:{
        		required: true
        	},
        	selPort:{
        		required: true
        	},
        	txtDataId:{
        		required: true,
        		rangelength:[10,10],
        		remote:{
        			url: '/portal/checkdevice',
        			type: "post",
        			data:{pre_data_id:function(){
        				return pre_data_id;
        			}}
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
        	selSmdDev:{
        		required: '请选择采集板'
        	},
        	txtName:{
        		required: '请输入设备名'
        	},
        	selModel:{
        		required: '选择设备类型'
        	},
        	selPort:{
        		required: '选择端口号'
        	},
        	txtDataId:{
        		required: '请填写数据ID',
        		rangelength:'请输入10位长度的数据',
        		remote:'该数据ID已被使用，请检查该数据ID是否正确'
        	}
        },
        ignore: ".ignore"
    });
	$('#btn-submit').click(function(){
    	var bRet = true;
    	if(!$('#txtDataId').prop('readonly'))
		{
    		bRet = $("#txtDataId").valid() && bRet;
		}
		bRet = $("#selCity").valid() && bRet;
		bRet = $("#selCounty").valid() && bRet;
		bRet = $("#selSubstation").valid() && bRet;		
		bRet = $("#selRoom").valid() && bRet;
		bRet = $("#selSmdDev").valid() && bRet;

		bRet = $("#txtName").valid() && bRet;
		bRet = $("#selModel").valid() && bRet;		
		bRet = $("#selPort").valid() && bRet;
		var btnObj = $(this);
		if (bRet) {
			return true;
		}
		return false;
    });
	
	tinymce.init({
	    selector: '#txtMemo',
		language : 'zh_CN',
		plugins: [
		          "advlist autolink lists link image charmap print preview anchor",
		          "searchreplace visualblocks code fullscreen",
		          "insertdatetime media table contextmenu paste"],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
	});
	model();
});
