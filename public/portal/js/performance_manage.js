$(document).ready(function(){
	var trObj = null;
	var id = null;
	$('.deleteperfor').click(function(){
		trObj = $(this).parents('tr');
		id = trObj.attr('id'); 
		bootbox.dialog({
			message: "<h4 class='text-error'><i class='icon-exclamation-sign'></i> 是否删除该性能列表？</h4><br><b>该动作将删除该行性能列表。</b>",
			buttons:{
				OK:{
					label : "确定",
					className : "btn-info",
					callback : function() {
						$.post('/portal/delete_perfor',{id:id},function(ret){
							if(ret)
							{
								trObj.remove();
								var n = noty({
									text: '<span>删除成功.</span>',
									type: 'success',
									layout: 'topCenter',
									timeout : 1000,
									closeWith: ['hover','click','button']
								});
							}else{
								var n = noty({
									text: '<span>'+ text +'失败.</span>',
									type: 'fail',
									layout: 'topCenter',
									timeout : 1000,
									closeWith: ['hover','click','button']
								});
							}
						});
					}
				},
				Cancel:{
					label : "取消",
					className : "btn",
					callback : function() {
						
					}
				}
			},
			onEscape: true
		});
	});
	$('.date-range-picker').daterangepicker({
		format: 'YYYY-MM-DD',
        separator: '至',
        timePicker: false,
    	locale: {
    		applyLabel: '选择',
    		cancelLabel: '重置',
            fromLabel: '从',
            toLabel: '到',
            weekLabel: '星期',
            customRangeLabel: '范围',
            daysOfWeek: ['日','一','二','三','四','五','六'],
            monthNames: ['一月', '二月', '三月', '四月', '五月', '六月','七月', '八月', '九月', '十月', '十一月', '十二月'],
            firstDay: 0
    	}
	});
	
	var to = false;
	$('#userQuery').keyup(function () {
		if(to) { clearTimeout(to); }
		to = setTimeout(function () {
			var v = $('#userQuery').val();
			$('#area-tree').jstree(true).search(v);
		}, 250);
	});
	$('#area-tree').jstree({
		  "plugins" : [ "wholerow" ],
		  'core' : {
				'data' : {
				    'url' : function (node) {
				      return '/portal/get_substation_tree';
				    },
				    'data' : function (node) {
				      return { 'id' : node.id };
				    }
				}
			}
	});
	$('#area-tree').bind("activate_node.jstree", function (event,data) {
		  var dataIdArr = $('#area-tree').jstree().get_bottom_selected();
		  var bText = "";
		  for(var i= (data.node.parents.length-2); i>=0;i--)
		  {
			  bText += $.trim($('#area-tree').jstree().get_node(data.node.parents[i]).text) + ">";
		  }
		  bText += data.node.text;
          $("#substation_id").val(dataIdArr);
          $("#selSubstation").text(bText);
	});
	
	$("#btnSearch,#btnExport").click(function(){
		if($("#data_id").val().length == 0)
		{
			alert("请选择一个电表");
			return false;
		}
		if($("#dateRange").val().length == 0)
		{
			alert("请选择要查看数据的开始时间和终止时间");
			return false;
		}
		return true;
	});
	
	
	
	
})