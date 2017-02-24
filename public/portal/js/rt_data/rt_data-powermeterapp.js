$(document).ready(function(){
	var dataIdArr1 = new Array();
	var dataIdArr2 = new Array();
	
	$(".imem_12").each(function(){
		dataIdArr1.push($(this).attr('data_id'));
	});
	
	$(".302a_power").each(function(){
		dataIdArr2.push($(this).attr('data_id'));
	});
	
	
	function refreshData()
	{	
		$.get('/portal/refreshData', {
			dataIdArr1 : dataIdArr1.toString(),
			dataIdArr2 : dataIdArr2.toString(),
			model : "powermeter",
			access_token : typeof(accessToken) == "undefined" ? "":accessToken
		}, function(ret) {
			
			if(dataIdArr1.toString())
			{
				var length = ret.imem12Value.length;
				for(var i = 0 ; i < length ; i++)
				{
					var obj = ret.imem12Value[i];
					$('#imem12_p_'+ obj.data_id + ' td:eq(3)').html(obj.update_datetime);
					
					$('#imem12_p_'+ obj.data_id+' td:eq(1)>span:eq(0)').html(obj.p1);
					$('#imem12_p_'+ obj.data_id + ' td:eq(2)').html(obj.w1);
				}				
				
//				for(var i = 0 ; i < dataIdArr1.length ; i++)
//				{
//					var obj = dataIdArr1[i];
//					$('#imem12_p_'+ obj + ' td:eq(3)').html(obj);
//					
//					$('#imem12_p_'+ obj+' td:eq(1)>span:eq(0)').html(obj);
//					$('#imem12_p_'+ obj + ' td:eq(2)').html(obj);
//				}
			}
			if(dataIdArr2.toString())
			{
				var length = ret.power302aValue.length;
				for(var i = 0 ; i < length ; i++)
				{
					var obj = ret.power302aValue[i];
					//有功功率
					$('#power302a-'+ obj.data_id + '-1 td:eq(2)>span').html(obj.pa);
					$('#power302a-'+ obj.data_id + '-1 td:eq(3)>span').html(obj.pb);
					$('#power302a-'+ obj.data_id + '-1 td:eq(4)>span').html(obj.pc);
					$('#power302a-'+ obj.data_id + '-1 td:eq(5)>span').html(obj.pt);
					//无功功率
					/*$('#power302a-'+ obj.data_id + '-2 td:eq(2)>span').html(obj.qa);
					$('#power302a-'+ obj.data_id + '-2 td:eq(3)>span').html(obj.qb);
					$('#power302a-'+ obj.data_id + '-2 td:eq(4)>span').html(obj.qc);
					$('#power302a-'+ obj.data_id + '-2 td:eq(5)>span').html(obj.qt);
					//视在功率
					$('#power302a-'+ obj.data_id + '-3 td:eq(2)>span').html(obj.sa);
					$('#power302a-'+ obj.data_id + '-3 td:eq(3)>span').html(obj.sb);
					$('#power302a-'+ obj.data_id + '-3 td:eq(4)>span').html(obj.sc);
					$('#power302a-'+ obj.data_id + '-3 td:eq(5)>span').html(obj.st);*/
					//电压有效值
					$('#power302a-'+ obj.data_id + '-2 td:eq(2)>span').html(obj.uaRms);
					$('#power302a-'+ obj.data_id + '-2 td:eq(3)>span').html(obj.ubRms);
					$('#power302a-'+ obj.data_id + '-2 td:eq(4)>span').html(obj.ucRms);
					//$('#power302a-'+ obj.data_id + '-4 td:eq(5)>span').html(obj.utRms);
					//电流有效值
					$('#power302a-'+ obj.data_id + '-3 td:eq(2)>span').html(obj.iaRms);
					$('#power302a-'+ obj.data_id + '-3 td:eq(3)>span').html(obj.ibRms);
					$('#power302a-'+ obj.data_id + '-3 td:eq(4)>span').html(obj.icRms);
					$('#power302a-'+ obj.data_id + '-3 td:eq(5)>span').html(obj.itRms);
					//功率因数
					$('#power302a-'+ obj.data_id + '-4 td:eq(2)>span').html(obj.pfa);
					$('#power302a-'+ obj.data_id + '-4 td:eq(3)>span').html(obj.pfb);
					$('#power302a-'+ obj.data_id + '-4 td:eq(4)>span').html(obj.pfc);
					$('#power302a-'+ obj.data_id + '-4 td:eq(5)>span').html(obj.pft);
					//频率
					$('#power302a-'+ obj.data_id + '-5 td:eq(5)>span').html(obj.freq);
					//有功电能
					$('#power302a-'+ obj.data_id + '-6 td:eq(2)>span').html(obj.epa);
					$('#power302a-'+ obj.data_id + '-6 td:eq(3)>span').html(obj.epb);
					$('#power302a-'+ obj.data_id + '-6 td:eq(4)>span').html(obj.epc);
					$('#power302a-'+ obj.data_id + '-6 td:eq(5)>span').html(obj.ept);
				}	
				
//				for(var i = 0 ; i < dataIdArr2.length ; i++)
//				{						
//					var obj = dataIdArr2[i];					
//					$('#power302a-'+ obj + '-1 td:eq(2)>span').html(obj);
//					$('#power302a-'+ obj + '-1 td:eq(3)>span').html(obj);
//					$('#power302a-'+ obj + '-1 td:eq(4)>span').html(obj);
//					$('#power302a-'+ obj + '-1 td:eq(5)>span').html(obj);
//					//无功功率
//					/*$('#power302a-'+ obj.data_id + '-2 td:eq(2)>span').html(obj.qa);
//					$('#power302a-'+ obj.data_id + '-2 td:eq(3)>span').html(obj.qb);
//					$('#power302a-'+ obj.data_id + '-2 td:eq(4)>span').html(obj.qc);
//					$('#power302a-'+ obj.data_id + '-2 td:eq(5)>span').html(obj.qt);
//					//视在功率
//					$('#power302a-'+ obj.data_id + '-3 td:eq(2)>span').html(obj.sa);
//					$('#power302a-'+ obj.data_id + '-3 td:eq(3)>span').html(obj.sb);
//					$('#power302a-'+ obj.data_id + '-3 td:eq(4)>span').html(obj.sc);
//					$('#power302a-'+ obj.data_id + '-3 td:eq(5)>span').html(obj.st);*/
//					//电压有效值
//					$('#power302a-'+ obj + '-2 td:eq(2)>span').html(obj);
//					$('#power302a-'+ obj + '-2 td:eq(3)>span').html(obj);
//					$('#power302a-'+ obj + '-2 td:eq(4)>span').html(obj);
//					//$('#power302a-'+ obj.data_id + '-4 td:eq(5)>span').html(obj.utRms);
//					//电流有效值
//					$('#power302a-'+ obj + '-3 td:eq(2)>span').html(obj);
//					$('#power302a-'+ obj + '-3 td:eq(3)>span').html(obj);
//					$('#power302a-'+ obj + '-3 td:eq(4)>span').html(obj);
//					$('#power302a-'+ obj + '-3 td:eq(5)>span').html(obj);
//					//功率因数
//					$('#power302a-'+ obj + '-4 td:eq(2)>span').html(obj);
//					$('#power302a-'+ obj + '-4 td:eq(3)>span').html(obj);
//					$('#power302a-'+ obj + '-4 td:eq(4)>span').html(obj);
//					$('#power302a-'+ obj + '-4 td:eq(5)>span').html(obj);
//					//频率
//					$('#power302a-'+ obj + '-5 td:eq(5)>span').html(obj);
//					//有功电能
//					$('#power302a-'+ obj + '-6 td:eq(2)>span').html(obj);
//					$('#power302a-'+ obj + '-6 td:eq(3)>span').html(obj);
//					$('#power302a-'+ obj + '-6 td:eq(4)>span').html(obj);
//					$('#power302a-'+ obj + '-6 td:eq(5)>span').html(obj);
//				}
			}
		});
	}
	refreshData();
	setInterval(refreshData, 20000);
});
