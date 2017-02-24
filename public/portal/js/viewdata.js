$(document).ready(function() {
	var dataIdArr2 = new Array();
	$('.setThreshold').click(function() {
//		$('#rt-data').empty();		
	  $('#roomPiDlg').modal('show');	  
	  refreshData($(this).attr("data_id"));
  });
	
	  function refreshData(dataId)
	  {	
		$.get('/portal/refreshData', {
			dataIdArr2 : dataId,
			model : "powermeter"
		}, function(ret) {
		
				var length = ret.power302aValue.length;
				for(var i = 0 ; i < length ; i++)
				{
					var obj = ret.power302aValue[i];
					//有功功率
					$('#302a_power>tr:eq(0) td:eq(2)>span').html(obj.pa);
					$('#302a_power>tr:eq(0) td:eq(3)>span').html(obj.pb);
					$('#302a_power>tr:eq(0) td:eq(4)>span').html(obj.pc);
					$('#302a_power>tr:eq(0) td:eq(5)>span').html(obj.pt);

					//电压有效值
					$('#302a_power>tr:eq(1) td:eq(2)>span').html(obj.uaRms);
					$('#302a_power>tr:eq(1) td:eq(3)>span').html(obj.ubRms);
					$('#302a_power>tr:eq(1) td:eq(4)>span').html(obj.ucRms);
	                $('#302a_power>tr:eq(1) td:eq(5)>span').html(obj.utRms);

					//电流有效值
					$('#302a_power>tr:eq(2) td:eq(2)>span').html(obj.iaRms);
					$('#302a_power>tr:eq(2) td:eq(3)>span').html(obj.ibRms);
					$('#302a_power>tr:eq(2) td:eq(4)>span').html(obj.icRms);
					$('#302a_power>tr:eq(2) td:eq(5)>span').html(obj.itRms);
					//功率因数
					$('#302a_power>tr:eq(3) td:eq(2)>span').html(obj.pfa);
					$('#302a_power>tr:eq(3) td:eq(3)>span').html(obj.pfb);
					$('#302a_power>tr:eq(3) td:eq(4)>span').html(obj.pfc);
					$('#302a_power>tr:eq(3) td:eq(5)>span').html(obj.pft);
					//频率
	                $('#302a_power>tr:eq(4) td:eq(5)>span').html(obj.freq);
					//有功电能
					$('#302a_power>tr:eq(5) td:eq(2)>span').html(obj.epa);
					$('#302a_power>tr:eq(5) td:eq(3)>span').html(obj.epb);
					$('#302a_power>tr:eq(5) td:eq(4)>span').html(obj.epc);
					$('#302a_power>tr:eq(5) td:eq(5)>span').html(obj.ept);
			}
		});
	}


});