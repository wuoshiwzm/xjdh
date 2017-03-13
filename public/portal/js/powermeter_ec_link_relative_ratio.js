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
			for(var i=0;i < dataArray[obj].length;i++)
			{
				var pointData = [];
				pointData.push(obj);
				pointData.push(dataArray[obj][i]);
				seriesData[i].push(pointData);
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