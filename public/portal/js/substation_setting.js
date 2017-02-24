$(document).ready(function() {
	var radioObj = null;

	$('.rChoose').change(function(){
		radioObj = $(this);
		$('#txtDcScript').insert({"text":radioObj.attr('networkname')});
	});
	$('.btn-op').click(function(){
		$('#txtDcScript').insert({"text":$(this).text()});
	});
	$('#btn-addConfig,.btn-edit').click(function(){
		$('#dynamicSettingDlg').modal('show');
	});
	$('.btn-edit').click(function(){
		$('#dynamicSettingDlg').modal('show');
		$('#txtDcScript').val($(this).parent().siblings().eq(1).text());
	})
	
	$(".btn-del").click(function(){
		if(confirm("请确认删除此动态配置?"))
		{
			var pTr = $(this).parents("tr:eq(0)");
			$.post("/portal/deleteNetworkConfig", { substation_id:substation_id}, function(ret){
				if(ret)
				{
					pTr.remove();
					var n = noty({
						text: '<span>删除成功。</span>',
						type: 'success',
						layout: 'topCenter',
						timeout : 1000,
						closeWith: ['hover','click','button']
					});
				}
			});
		}
	});
	$('#btn-save').click(function(){
		$.post('/portal/saveNetworkConfig',{substation_id:substation_id,nk_script:$('#txtDcScript').val()},
			function(ret){
			if(ret){
				$('#dynamicSettingDlg').modal('hide');
				setTimeout('window.location.reload()',500);
			}else{
				var n = noty({
					text: '<span>添加/修改失败，请重试.</span>',
					type: 'error',
					layout: 'topCenter',
					timeout : 1000,
					closeWith: ['hover','click','button']
				});
			}
		});
	});

	
});
