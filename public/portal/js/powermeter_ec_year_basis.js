$(document).ready(function(){
	if(yearData)
	{
		var seriesData = []
		for(var obj in yearData)
		{
			var pointData = [];
			pointData.push(obj);
			pointData.push(yearData[obj]);
			seriesData.push(pointData);
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
	    var chartData = [
			{
			    data: seriesData,
			    label: "年度能耗",
			    points: {
			        show: true
			    },
			    lines: {
			        show: true
			    },
			    yaxis: 2
			}
	                     ];
	    $.plot($("#lineChart"), chartData, options);
	}
    
});