$(document).ready(function(){
	var seriesData = [];
	for(var i=startYear;i<=endYear;i++)
	{
	    seriesData[i] = [];
	}
	for(var year in ecBasicArray)
	{
	    for(var yearData in ecBasicArray[year])
	    {
	        seriesData[year].push(ecBasicArray[year][yearData]);
	    }
	}
	var series = [];
	for(var i=startYear;i<=endYear;i++)
	{
	    var arr = {name : i,data : seriesData[i]};
	    series.push(arr);
	}
	
	var seriesEcData = [];
	for(var ec in ecArray)
	{
		seriesEcData.push(ecArray[ec]);
	}
	
	if(ecBasicArray)
	{
		$(function () {
		    $('#lineChart').highcharts({
		        title: {
		            text: '不同年份能耗折线图',
		            x: -20
		        },
		        subtitle: {
		            text: '',
		            x: -20
		        },
		        xAxis: {
		            categories: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月']
		        },
		        yAxis: {
		            title: {
		                text: '能耗 (度)'
		            },
		            plotLines: [{
		                value: 0,
		                width: 1,
		                color: '#808080'
		            }]
		        },
		        tooltip: {
		            valueSuffix: '度'
		        },
		        legend: {
		            layout: 'vertical',
		            align: 'right',
		            verticalAlign: 'middle',
		            borderWidth: 0
		        },
		        series: series
		    });
	    });
		
		$(function () {
            $('#eclineChart').highcharts({
                title: {
                    text: '能耗同比折线图',
                    x: -20
                },
                subtitle: {
                    text: '',
                    x: -20
                },
                xAxis: {
                    categories: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月']
                },
                yAxis: {
                    title: {
                        text: '同比增长率 (%)'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    valueSuffix: '%'
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{
                    name: '同比增长率',
                    data: seriesEcData
                }]
            });
        });
	}
  
})



