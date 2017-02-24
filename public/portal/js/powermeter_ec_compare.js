$(document).ready(function(){
	var originObj = $("#departmentClone").clone();
	function city_change(){
		var nodeObj = $(this).parents(".department").find('.selCounty');
		$.get('/portal/getcounty',{citycode:$(this).val()},function(data){
			eval('var ret =' + data);
			nodeObj.empty();
			nodeObj.append('<option value="">所有分局</option>' );
			if(ret.ret == 0){
				for(i = 0 ; i < ret.countyList.length ; i++)
				{
					var countyObj = ret.countyList[i];
					nodeObj.append('<option value="'+countyObj.key +'">'+countyObj.val +'</option>' );
				}
			}
			nodeObj.trigger("liszt:updated");
			nodeObj.trigger("change");
		});
	}
	function county_change(){
		var nodeObj = $(this).parents(".department").find('.selSubstation');
		$.get('/portal/getSubstation',{countycode:$(this).val()},function(data){
			eval('var ret =' + data);
			nodeObj.empty();
			nodeObj.append('<option value="">所有局站</option>' );
			for(i = 0 ; i < ret.substationList.length ; i++)
			{
				var substationObj = ret.substationList[i];
				nodeObj.append('<option value="'+ substationObj.id +'">'+ substationObj.name +'</option>' );
			}
			nodeObj.trigger("liszt:updated");
			nodeObj.trigger("change");
		});
	}
	function substation_change(){
		var nodeObj = $(this).parents(".department").find('.selRoom');
		$.get('/portal/getroom',{substation_id:$(this).val()},function(data){
			eval('var ret =' + data);
			nodeObj.empty();


			nodeObj.append('<option value="">所有机房</option>' );

			for(i = 0 ; i < ret.roomList.length ; i++)
			{
				var roomObj = ret.roomList[i];
				nodeObj.append('<option value="'+ roomObj.id +'">'+ roomObj.name +'</option>' );
			}

			nodeObj.trigger("liszt:updated");

		});
	}
	$(".selCity").change(city_change);
	$('.selCounty').change(county_change);
	$('.selSubstation').change(substation_change);
		
		
	$("#btnNew").click(function(){
		var dObj = originObj.clone();
		dObj.find("*").removeAttr("id");
		dObj.insertAfter($("#departmentClone"));
		dObj.find("select").each(function(){
			$(this).next().remove();
			$(this).show();
		})
		dObj.find(".chzn-select").removeClass("chzn-done").chosen();
		dObj.find(".selCity").change(city_change);
		dObj.find('.selCounty').change(county_change);
		dObj.find('.selSubstation').change(substation_change);
		
	});
	
	$("#btnRemove").click(function(){
		if($("#departmentClone").next().hasClass("department"))
		{
			$("#departmentClone").next().remove();
		}		
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
	if(dataArray)
	{
	    var chartData = [
	         			
	                     ];
		var seriesData = [];
		for(var i=0;i < labelArray.length;i++)
		{
			seriesData[i] = [];
		}
		for(var obj in dataArray)
		{
			var i = 0;
			for(var city in  dataArray[obj])
			{
				var pointData = [];
				pointData.push(obj);
				pointData.push(dataArray[obj][city]);
				seriesData[i++].push(pointData);
			}			
		}
		for(var i=0;i < labelArray.length;i++)
		{
			chartData.push(
				{
				    data: seriesData[i],
				    label: labelArray[i],
				    points: {
				        show: true
				    },
				    lines: {
				        show: true
				    },
				    yaxis: 2
				});
		}
		
		var options = {
				series: {
		            lines: {
		                show: true,
		                fill: false
		            },
		            points: {
		                show: true,
		                lineWidth: 2,
		                fill: true,
		                fillColor: "#ffffff",
		                symbol: "circle",
		                radius: 2,
		            },
		            shadowSize: 0,
		        },
		        grid: {
		            hoverable: true,
		            clickable: true,
		            tickColor: "#f9f9f9",
		            borderWidth: 1
		        },
		        colors: ["#b086c3", "#ea701b"],
		        xaxis: {
					mode: "categories"
				},
		        tooltip: true,
		        tooltipOpts: {
		            defaultTheme: false
		        },
		        legend: {
		            position: 'nw',
		            labelBoxBorderColor: "#000000",
		            container: $("#area-chart #legendPlaceholderArea"),
		            noColumns: 0
		        }
		    };
	
	    $.plot($("#lineChart"), chartData, options);
	}
    
});