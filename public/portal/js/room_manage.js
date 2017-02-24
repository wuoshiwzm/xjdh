$(document).ready(function() {
	var button = null;
	var room_id = null;
	var maxIndex = 0;
	$('.btn-addPi').click(function() {
	
		button = $(this);
		maxIndex = 0;
		try{
			var piSettings = JSON.parse($(this).attr('pi_setting'));
			for ( var i = 0 ;i< piSettings.length;i++) {
				var tempArr = new Array();
				for ( var property in piSettings[i]) {
					tempArr.push(property);
					tempArr.push(piSettings[i][property]);
				}
				add_pi(tempArr[0],tempArr[1]);
			}
		}catch(e)
		{
			
		}
		
		$('#roomPiDlg').modal('show');
	});
	
	function add_pi($name,$value){
		var tTr = $('<tr><td>'+ (++maxIndex) + '</td><td><input type="text" class="span2 pi-name" value="'+ $name +'"/></td>\
				<td><input type="text" class="span2 pi-value" value="'+$value+'"/></td>\
				<td><div class="btn-toolbar row-action">\
				  <div class="btn-group">\
					<button class="btn btn-danger btn_del" title="删除"><i class="icon-remove"></i></button></div></div></td></tr>');
		$('.btn_del',tTr).click(function(){
			tTr.remove();
			var index = 1;
			$("#tbRoomPi tr").each(function(){
				$(this).find("td:eq(0)").text(index++);
			});
		});
		$('#tbRoomPi').append(tTr);
	}
	$("#btnAddPi").click(function(){
		add_pi('','');
	});
	$('#btn-ok').click(function() {
		var settingArr = new Array();
		$("#tbRoomPi tr").each(function(){
			var settingObj = {};
			settingObj[$(this).find('input:eq(0)').val()] = $(this).find('input:eq(1)').val();
			settingArr.push(settingObj);
		});
		if(settingArr.length == 0)
		{
			if(!confirm("你没有设置任何规则，请确认保存吗?"))
				return;
		}
		var pi_setting = JSON.stringify(settingArr);
		$.post('/portal/saveRoomPi', {
			'room_id' : button.parent().attr('room_id'),
			'pi_setting' : pi_setting
		}, function(ret) {
			if (ret) {
				button.attr('pi_setting', pi_setting);
				button.parent().siblings().eq(8).html(pi_setting);
				$('#roomPiDlg').modal('hide');
				var n = noty({
					text : '<span>添加成功.</span>',
					type : 'success',
					layout : 'topCenter',
					closeWith : [ 'hover', 'click', 'button' ]
				});
			} else {
				var n = noty({
					text : '<span>添加失败，请重试。</span>',
					type : 'error',
					layout : 'topCenter',
					closeWith : [ 'hover', 'click', 'button' ]
				});
			}
		});

	});
	$(".btn-delete").click(function(){
		if(confirm("请确认删除!")){
		var roomid=$(this).attr("roomid");
		$.get('/portal/deleteroom',{roomid:roomid},function(data){
			  eval('var ret = ' + data);
	    	   if(ret == "true"){
	    		   var n = noty({
						text: '<span>操作成功!</span>',
						type: 'success',
						layout: 'topCenter',
						closeWith: ['hover','click','button']
					});
	        	   }else {
	        		   var n = noty({
	   					text: '<span>操作失败!</span>',
	   					type: 'success',
	   					layout: 'topCenter',
	   					closeWith: ['hover','click','button']
	   				});

	            	   }
		})
		}
	})
});