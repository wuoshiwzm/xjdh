$(document).ready(function(){
	var to = false;
	$('#areaQuery').keyup(function () {
		if(to) { clearTimeout(to); }
		to = setTimeout(function () {
			var v = $('#areaQuery').val();
			$('#area-tree').jstree(true).search(v);
		}, 250);
	});
	$('#area-tree').jstree({'plugins':["checkbox","search"], 'core' : {
		'data' : areaTreeData
	}});
	$('#dev-tree').jstree({'plugins':["checkbox"], 'core' : {
		'data' : devTreeData
	}});
	$('#btnSubmit').click(function(){
		var devArr = $('#dev-tree').jstree('get_selected');
		var areaTempArr = $('#area-tree').jstree('get_selected');
		var areaArr = new Array();
		for(var i = 0 ; i < areaTempArr.length ; i++)
		{
			var substationId = Number(areaTempArr[i]);
			if(!isNaN(substationId))
				areaArr.push(substationId);
		}
		$.post('/portal/changeUserPrivilege',{user_id:$('#btnSubmit').attr('user_id'), area_privilege:areaArr.join(','),dev_privilege:devArr.join(',')},function(ret){
			if(ret){
				var n = noty({
					text: '<span>修改成功.</span>',
					type: 'success',
					layout: 'topCenter',
					closeWith: ['hover','click','button']
				});
			}else{
				var n = noty({
					text: '<span>修改失败，请重试.</span>',
					type: 'error',
					layout: 'topCenter',
					closeWith: ['hover','click','button']
				});
			}
		});
	});
});
