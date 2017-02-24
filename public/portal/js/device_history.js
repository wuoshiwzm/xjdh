$(document).ready(function(){
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
				      return '/portal/get_device_history_tree';
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
          $("#data_id").val(dataIdArr);
          $("#selPowerMeter").text(bText);
	});
	
	$("#btnSearch,#btnExport").click(function(){
		if($("#data_id").val().length == 0)
		{
			alert("请选择一个设备");
			return false;
		}
		if($("#dateRange").val().length == 0)
		{
			alert("请选择要查看数据的开始时间和终止时间");
			return false;
		}
		return true;
	});
//	$('#area-tree').bind("select_node.jstree",function(event,data){    
//        if("true" == data.rslt.obj.attr("isLast")){   
//                 //get the attrs data you set in the attrs field;  
//                alert(data.rslt.obj.attr("id")+data.rslt.obj.attr("isLast"));  
//                //you can do something here...  
//            }else{  
//               //toggle node refer to the id setted in the metadata  
//                //get the metadata id field value : jQuery.data(data.rslt.obj[0], "id")；  
//                //The metadata id value should be different to each other !!!  
//                //otherwise, the toggle_node will work incorrect !!!  
//          $("#jsonDemo").jstree("toggle_node","#"+jQuery.data(data.rslt.obj[0], "id"));  
//            }      
//    })
});
