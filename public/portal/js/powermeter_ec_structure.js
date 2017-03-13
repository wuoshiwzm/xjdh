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
    $(function () {
	    $('#pieChart').highcharts({
	        chart: {
	            plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false
	        },
	        title: {
	            text: '能耗结构饼状图'
	        },
	        tooltip: {
	            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	        },
	        plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                dataLabels: {
	                    enabled: false
	                },
	                showInLegend: true
	            }
	        },
	        series: [{
	            type: 'pie',
	            name: '所占比率',
	            data: [
	                {   name: '市电进入',
	                    y: total,
	                    sliced: true,
	                    selected: true
	                },
	                ['主设备',   main],
	                ['空调',     air],
	                ['其他',   other]
	            ]
	        }]
	     });
	  });
      $(function () {
          $('#barChart').highcharts({
              chart: {
                  type: 'column'
              },
              title: {
                  text: '能耗结构柱状图'
              },
              xAxis: {
                  categories: ['市电进入', '主设备', '空调', '其他']
              },
              yAxis: {
                  title: {
                      text: '能耗 (度)'
                  }
              },
              credits: {
                  enabled: false
              },
              series: [{
                  name: '能耗 (度)',
                  data: [total, main, air, other]
              }]
          });
      });
	
	
	
	
	
	
});