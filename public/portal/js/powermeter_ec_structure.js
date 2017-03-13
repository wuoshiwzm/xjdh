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
	
	var data = [{
        label: "主设备",
        data: main/total
    }, {
        label: "空调",
        data: air/total
    }, {
        label: "其他",
        data: other/total
    }];
    var options = {
        series: {
            pie: {
                show: true
            }
        },
        legend: {
            show: true
        },
        grid: {
            hoverable: true,
            clickable: true
        },
        tooltip: true,
        tooltipOpts: {
            defaultTheme: false,
            content: "%p",
        }
    };
    $.plot($("#pieChart"), data, options);
    
    var data1 =  [ ["主设备", main], ["空调", air], ["其他", other]];
   
	$.plot("#barChart", [data1 ], {
		series: {
			bars: {
				show: true,
				barWidth: 0.6,
				align: "center"
			}
		},
        grid: {
            hoverable: true
        },
		xaxis: {
			mode: "categories"
		},
		tooltip: true,
        tooltipOpts: {
            defaultTheme: false,
            content: "%y",
        }
	});
});