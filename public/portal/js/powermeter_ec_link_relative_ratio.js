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
    	var seriesData = []; var categories = [];
        for(var i in ecType) 
        {
            seriesData[i] = [];
            seriesData[i+"_ratio"] = [];
            for(var data in dataArray)
            {
                categories.push(data);
                for(var type in dataArray[data])
                {
                    if(i == type){
                        seriesData[i].push(dataArray[data][type]);
                    }else if(type == i+"_ratio"){
                        seriesData[i+"_ratio"].push(dataArray[data][type]);
                    }
                }
            }
        }
        var series = [];  var seriesEc = [];
        for(var i in ecType)
        {
            var arr = {name : labelArray[i],data : seriesData[i]};
            var arrEc = {name : labelArray[i],data : seriesData[i+"_ratio"]};
            series.push(arr);
            seriesEc.push(arrEc);
        }
    	
        $(function () {
            $('#lineChart').highcharts({
                title: {
                    text: '设备能耗折线图',
                    x: -20
                },
                subtitle: {
                    text: '',
                    x: -20
                },
                xAxis: {
                    categories: categories
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
                    text: '能耗环比折线图',
                    x: -20
                },
                subtitle: {
                    text: '',
                    x: -20
                },
                xAxis: {
                    categories: categories
                },
                yAxis: {
                    title: {
                        text: '环比增长率 (%)'
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
                series: seriesEc
            });
        });
     }

 
});