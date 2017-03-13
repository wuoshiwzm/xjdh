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

	 $('#selSubstation').change(function(){
		 if($("#selSubstation option:selected").text() != "所有局站"){
			 var substation = $("#selSubstation option:selected").text();
			 var type = substation.substring(substation.indexOf("_") + 1,substation.indexOf("_")+ 2); 
		 }
		 $('#selRoom').change(function(){
				var room = $("#selRoom option:selected").text();
				var devname = "请选择所属设备类型";
				$('#txtName').val(devname); 
//				$('#selSmdDev').change(function(){
//					var device = $('#selSmdDev option:selected').text();
					$('#selModel').change(function(){
						var t_model = $('#selModel option:selected').text();
						if(t_model == "温度" || t_model == "湿度" || t_model == "烟感" || t_model == "水浸"){
							if(type == "D"){
								var devname = "环境信号"+"（"+t_model+"_"+room+"）";
							}else{
								var devname = "环境信号"+"（"+"编号"+"#"+t_model+"_"+room+"）";
							}
						}else if(t_model == "小精灵门禁"){
							if(room.indexOf("F_") < 0){
								room = room.replace(/F/, "F_");
							}
							if(room.indexOf("F") > -1){
								var devname = "门禁系统"+"（"+room+"_"+"编号#"+"小精灵168"+"）";
							}else{
								var devname = "门禁系统"+"（"+"楼层F"+room+"_"+"编号#"+"小精灵168"+"）";
							}
						}else if(t_model == "监控设备"){
//							device = device.substring(device.indexOf("（") + 1,device.indexOf("_"));
//							var devname = "监控设备"+"（"+device+"_"+room+"）";
							var devname = "监控设备"+"（"+"所属采集板"+"_"+room+"）";
						}else if(t_model == "智能电表"){
							if(type == "D"){
								var devname = "智能电表"+"（"+"编号#"+"电表厂商"+"（吉姆）"+"电表型号"+"（IMEM12）"+"）";
							}else{
								var devname = "智能电表"+"（"+room+"_编号#"+"电表厂商"+"（吉姆）"+"电表型号"+"（IMEM12）"+"）";
							}
						}else if(t_model.indexOf("流屏电源") > 0 && (t_model != "交直流屏电源蓄电池组")){
							t_model=t_model.replace("电源","");
							if(type == "D"){
								var devname = "开关电源"+"（"+"设备厂商"+t_model+"）";
							}else{
								var devname = "开关电源"+"（"+room+"_"+"设备厂商"+"_"+t_model+"）";
							}
						}else if(t_model.indexOf("空调") > 0){
							var devname = "专用空调"+"（"+room+"_编号#"+"设备厂商设备型号"+"）";
						}else if(t_model == "新风系统"){   //新风设备标准化命名中没有具体的命名规范,可以按空调
							var devname = "新风设备"+"（"+room+"_编号#"+"设备型号"+"）";
						}else if(t_model == "摄像头"){
							var devname = "视频监控"+"（"+"编号#摄像头_"+room+"）";
						}else if(t_model == "交直流屏电源蓄电池组"){
							if(type == "D"){
								var devname = "蓄电池组"+"（"+"蓄电池组编号#"+"蓄电池厂商"+"容量AH"+"）";
							}else{
								var devname = "蓄电池组"+"（"+room+"_"+"开关电源厂商"+"_"+"开关电源型号_"+"编号#"+"蓄电池厂商"+"容量AH"+"）";
							}
						}else if(t_model == "UPS电源蓄电池组"){
							if(type == "D"){
								var devname = "蓄电池组"+"（"+"蓄电池组编号#"+"蓄电池厂商"+"容量AH"+"）";
							}else{
								var devname = "蓄电池组"+"（"+room+"_编号#UPS系统编号#主机_"+"开关电源厂商 "+"开关电源型号"+"编号#"+"蓄电池厂商"+"容量AH"+"）";+"容量AH"+"）";
							}
						}else if(t_model == "力博特UPS"){
							var devname = "UPS"+"（"+room+"_编号#UPS系统编号#主机_"+"设备厂商 "+"设备型号"+"）";
						}else if(t_model == "虚拟低压配电"){
							var devname = "低压配电";
						}else if(t_model == "机房环境量"){
							var devname = room +"机房环境";
						}else if(t_model == "蓄电池总电压"){
							if(type == "D"){
								var devname = "蓄电池组"+"（"+"蓄电池组编号#"+"蓄电池厂商"+"容量AH"+"）";
							}else{
								var devname = "蓄电池组"+"（"+room+"_"+"开关电源厂商"+"_"+"开关电源型号_"+"蓄电池厂商"+"容量AH"+"）";
							}
						}else if(t_model == "洲际开关电源DK04"){
							if(type == "D"){
								var devname = "开关电源"+"（"+"设备厂商"+t_model+"）";
							}else{
								var devname = "开关电源"+"（"+room+"_"+"设备厂商"+"_"+t_model+"）";
							}	
						}else if(t_model == "洲际开关电源DK04C(支持DK04D,DK04E)"){
							if(type == "D"){
								var devname = "开关电源"+"（"+"设备厂商"+t_model+"）";
							}else{
								var devname = "开关电源"+"（"+room+"_"+"设备厂商"+"_"+t_model+"）";
							}
						}else if(t_model == "华为开关电源PSM-6"){
							if(type == "D"){
								var devname = "开关电源"+"（"+"华为PSM-6"+"）";
							}else{
								var devname = "开关电源"+"（"+room+"_华为_PSM-6"+"）";
							}
						}else if(t_model == "油机"){		
							var devname = "油机"+"（"+room+"_编号#"+"设备厂商设备型号"+"）";
						}else if(t_model == "D类板载电表"){		
							var devname = "能耗"+"（"+"空调、开关电源、市电"+"_"+room+"）";
						}else if(t_model == "爱默生Datamate300"){		
							var devname = "专用空调"+"（"+room+"_编号#_"+"设备厂商设备型号"+"）";
						}else if(t_model == "油机启动电池"){		
							var devname = "油机启动电池"+"（"+room+"_"+"设备厂商设备型号"+"）";
						}else if(t_model == "威尔逊Access4000油机"){		
							var devname = "油机"+"（"+room+"_威尔逊Access4000"+"）";
						}else{
							var devname = "标准化命名中暂时没有具体的命名规范";
						}
						$('#txtName').val(devname);	
//					});
				});
			});
	 });
	 
	$('#txtName').change(function(){
		var device = $('#txtName').val();
		device = device.replace("交流屏","");
		device = device.replace("整流屏","");
		device = device.replace("直流屏","");
		$('#devgroup').val(device);
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
			 if(models == "PSM-A交流屏电源" || models == "PSM-A整流屏电源" || models == "PSM-A直流屏电源" || models == "M810G交流屏电源" || models == "M810G直流屏电源" || models == "M810G整流屏电源" || models=="zxdu交流屏电源" || models=="zxdu整流屏电源" || models=="zxdu直流屏电源"|| models == "SMU06C交流屏电源" || models == "SMU06C整流屏电源" || models == "SMU06C直流屏电源")
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
			 if((t_model.indexOf("直流屏电源") > 0||t_model.indexOf("交流屏电源") > 0||t_model.indexOf("整流屏电源") > 0) && t_model !="交直流屏电源蓄电池组")
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
        		required: '请输入设备名',
        		remote: '请重新检查设备名'
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
