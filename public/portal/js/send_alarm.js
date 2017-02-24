$(document).ready(function() {
	var model_sys_code = '00';
	$("#selDevModel").change(function() {
		model_sys_code = $(this).find("option:selected").attr('sys_code');
		_constructSignalId();
		$.get('/portal/getDeviceByModel', {
			cityCode : $('#selCity').val(),
			countyCode : $('#selCounty').val(),
			substationId : $('#selSubstation').val(),
			roomId : $('#selRoom').val(),
			model : $(this).val()
		}, function(ret) {
			$('#selDevice').empty();
			$('#selDevice').append('<option value="">选择设备</option>');
			for (var i = 0; i < ret.length; i++) {
				var devObj = ret[i];
				$('#selDevice').append('<option value="' + devObj.data_id + '">' + devObj.name + '</option>');
			}
			$('#selDevice').trigger("liszt:updated");
			$('#selDevice').trigger("change");
		});
	});
	$("#selStationType, #selSignalType, #txtSignalNum, #txtSignalSerial,#selDevice").change(_constructSignalId);
	function _constructSignalId() {
		var substationType = $("#selStationType").val();
		var signalType = $('#selSignalType').val();
		var signalNum = $('#txtSignalNum').val()
		var signalSerial = $('#txtSignalSerial').val();
		$('#txtSignalId').val(substationType + model_sys_code + signalType + signalNum + signalSerial);
		$('#txtSignalName').val($('#selDevModel').find("option:selected").text());
		$('#txtSubject').val(
				$('#selSubstation').find("option:selected").text() + $('#selRoom').find("option:selected").text()
						+ $('#selDevice').find("option:selected").text());
	}
	_constructSignalId();
	$('#btnSend').click(function() {
		if (typeof ($('#selDevice').val()) == 'undefined') {
			alert('请选择告警设备');
			return;
		}
		$('#span_dataId').html($('#selDevice').val());
		$('#span_level').html($('#selLevel').find("option:selected").text() + "告警");
		if ($('#txtSignalName').val() == '') {
			alert('请选择信号名称');
			return;
		}
		$('#span_signalName').html($('#txtSignalName').val());
		if ($('#txtSignalId').val() == '') {
			alert('请填写信号ID');
			return;
		}
		$('#span_signalId').html($('#txtSignalId').val());
		if ($('#txtSubject').val() == '') {
			alert('请填写告警信息');
			return;
		}
		$('#span_subject').html($('#txtSubject').val());
		$('#sendDlg').modal('show');
	});
	$('#btnConfirm').click(function() {
		$.post('/portal/addAlarmManualy', {
			data_id : $('#selDevice').val(),
			level : $('#selLevel').val(),
			signal_name : $('#txtSignalName').val(),
			signal_id : $('#txtSignalId').val(),
			subject : $('#txtSubject').val(),
		}, function(ret) {
			alert(ret ? "下发成功" : "下发失败");
		});
	});
});