$(document).ready(function(){
	$.get('/portal/getMapStatistics',{},function(ret){
		//eval('var ret =' + data);
		var mapData = null;
		// Initiate the chart
	    $('#container').highcharts('Map', {
	        title : {
	            text : ret.title
	        },
	        credits: false,
	        legend:{
	        	enable: false
	        },
	        tooltip: {
	            headerFormat: '',
	            pointFormat: '<b>{point.name}</b><br>本月告警量: {point.alarm} 个<br>本月能耗: {point.energy} KW*h'
	        },
	        plotOptions: {
                series: {
                    point: {
                        events: {
                            click: function () {
                            	var row = this.options.row,
            		            $div = $('<div></div>')
            		                .dialog({
            		                    title: this.name,
            		                    width: 400,
            		                    height: 300
            		                });
                            	var cityCode = 0;
                            	var countyCode = 0;
                            	if(parentcode != 0 ){
                            		cityCode = parentcode;
                            		countyCode = this.code;
                            	}else{
                            		cityCode = this.code;
                            	}
                            	$.get('/portal/getAlarmChartsData',{citycode:cityCode,countycode:countyCode},function(ret){
                    			        window.chart = new Highcharts.Chart({
                    				        chart: {
                    				        	renderTo: $div[0],
                    			                type: 'column',
                    			                width: 370,
                    			                height: 240
                    				        },
                    				        credits: false,
                    				        title: {
                    				            text: '本月告警统计图'
                    				        },
                    				        xAxis: {
                    				            categories: ret.categories,
                    				            crosshair: true
                    				        },
                    				        yAxis: [{
                    				        	labels: {
                    				                format: '{value}',
                    				                style: {
                    				                    color: '#89A54E'
                    				                }
                    				            },
                    				            title: {
                    				                text: '告警数量( 个 )',
                    				                style: {
                    				                    color: '#4572A7'
                    				                }
                    				            }
                    				        }],
                    				        legend: {
                    				            layout: 'vertical',
                    				            align: 'left',
                    				            margin: 30,
                    				            itemMarginTop:5,
                    				            x: 100,
                    				            verticalAlign: 'top',
                    				            y: 20,
                    				            floating: true,
                    				            backgroundColor: '#FFFFFF'
                    				        },
                    				        tooltip: {
                    				            shared: true
                    				        },
                    				        plotOptions: {
                    				        	series: {
                    				        		cursor: 'pointer',
                    				                events: {
                    				                    click: function(e) {
                    				                    	location.href = '/portal/alarm?selCity='+ cityCode +'&selCounty='+ countyCode +'&level=' + (e.point.x + 1);
	                    				                }
                    				                },
                    				            }
                    				        },
                    				        series: [{
                    				            name: '告警数量',
                    				            data: ret.alarmList,
                    							showInLegend: false,
                    				        	dataLabels: {
                    				                enabled: true,
                    				                color: 'red',
                    				                align: 'right',
                    				                style: {
                    				                    fontSize: '10px',
                    				                    fontFamily: 'Verdana, sans-serif'
                    				                }
                    				            },
                    				            tooltip: {
                    				                valueSuffix: ' 个'
                    				            }
                    				        }]
                    				    });
                			        });

                            }
                        }
                    }
                }
            },
	        series : [{
				type: "map",
				data: ret.mapData,
				name: '告警量',
				showInLegend: false,
				dataLabels: {
                    enabled: true,
                    color: 'black',
                    format: '{point.name}'
                }
			}]
	    });
	});

});