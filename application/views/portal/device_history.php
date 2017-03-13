<script type="text/javascript">
var model = <?php echo json_encode($model); ?>;
var devModelName = <?php echo json_encode($devModelName); ?>;
var modelName = <?php echo json_encode(Defines::$gDevModel[$model]); ?>;
var chartData = new Object();
chartData.title = '<?php echo $chartTitle;?>';
chartData.categories = new Array();

chartData.value = new Array();
chartData.voltage = new Array();
chartData.current = new Array();

chartData.voltage1 = new Array();
chartData.voltage2 = new Array();
chartData.voltage3 = new Array();
chartData.voltage4 = new Array();

chartData.current1 = new Array();
chartData.current2 = new Array();
chartData.current3 = new Array();
chartData.current4 = new Array();

chartData.power1 = new Array();
chartData.power2 = new Array();
chartData.power3 = new Array();
chartData.power4 = new Array();

chartData.energy1 = new Array();
chartData.energy2 = new Array();
chartData.energy3 = new Array();
chartData.energy4 = new Array();

var powerDataList = eval('<?php echo json_encode($powerDataList);?>');
for(var i = 0 ; i < powerDataList.length ; i++)
{
        var powerDataObj = powerDataList[i];
        chartData.categories[i] = powerDataObj.Date+"\ "+powerDataObj.Time;
        if(model == 'power_302a'){
        	   chartData.voltage1[i] = parseFloat(powerDataObj.uaRms);	
			   chartData.voltage2[i] = parseFloat(powerDataObj.ubRms);
			   chartData.voltage3[i] = parseFloat(powerDataObj.ucRms);
			   chartData.voltage4[i] = parseFloat(powerDataObj.utRms);
			   
			   chartData.current1[i] = parseFloat(powerDataObj.iaRms);	
			   chartData.current2[i] = parseFloat(powerDataObj.ibRms);
			   chartData.current3[i] = parseFloat(powerDataObj.icRms);
			   chartData.current4[i] = parseFloat(powerDataObj.itRms);
			   
			   chartData.power1[i] = parseFloat(powerDataObj.linePa);	
			   chartData.power2[i] = parseFloat(powerDataObj.linePb);
			   chartData.power3[i] = parseFloat(powerDataObj.linePc);
			   chartData.power4[i] = parseFloat(powerDataObj.linePt);
			   
			   chartData.energy1[i] = parseFloat(powerDataObj.lineEpa);	
			   chartData.energy2[i] = parseFloat(powerDataObj.lineEpb);
			   chartData.energy3[i] = parseFloat(powerDataObj.lineEpc);
			   chartData.energy4[i] = parseFloat(powerDataObj.lineEpt);
        }
        if(model == 'battery_24'||model == 'battery_32'){
     	       chartData.voltage[i] = parseFloat(powerDataObj.voltage);	
     	       chartData.current[i] = parseFloat(powerDataObj.current);
        }
        if(model.indexOf("-ac") > 0){
     	       chartData.current1[i] = parseFloat(powerDataObj.ia);	
			   chartData.current2[i] = parseFloat(powerDataObj.ib);
			   chartData.current3[i] = parseFloat(powerDataObj.ic);
        }
        if(model.indexOf("-dc") > 0){
               chartData.voltage[i] = parseFloat(powerDataObj.v);	
  	           chartData.current[i] = parseFloat(powerDataObj.i);
        }
        if(model.indexOf("-rc") > 0){
               chartData.voltage[i] = parseFloat(powerDataObj.out_v);	
        }
        if(model == 'humid'||model == 'temperature'||model == 'water'){
        	   chartData.value[i] = parseFloat(powerDataObj.value);
        }
        if(model == 'aeg-ms10se'){
        	   chartData.voltage1[i] = parseFloat(powerDataObj.v1);	
			   chartData.voltage2[i] = parseFloat(powerDataObj.v2);
			   chartData.voltage3[i] = parseFloat(powerDataObj.v3);
			   chartData.voltage4[i] = parseFloat(powerDataObj.vvavg);
			   
			   chartData.current1[i] = parseFloat(powerDataObj.i1);	
			   chartData.current2[i] = parseFloat(powerDataObj.i2);
			   chartData.current3[i] = parseFloat(powerDataObj.i3);
			   chartData.current4[i] = parseFloat(powerDataObj.iavg);
			   
			   chartData.power1[i] = parseFloat(powerDataObj.p1);	
			   chartData.power2[i] = parseFloat(powerDataObj.p2);
			   chartData.power3[i] = parseFloat(powerDataObj.p3);
			   chartData.power4[i] = parseFloat(powerDataObj.psum);
        }
        if(model == "psm-6"){
        	   chartData.power1[i] = parseFloat(powerDataObj.charge_average_v);	
			   chartData.power2[i] = parseFloat(powerDataObj.charge_float_v);
        } 
        if(model == "datamate3000"){
        	   chartData.power1[i] = parseFloat(powerDataObj.room_temp);	
			   chartData.power2[i] = parseFloat(powerDataObj.outdoor_temp);            
        }
}
if(model == 'power_302a'){
	$(function () {
	    $('#chart-voltage').highcharts({
	        title: {
	            text: '新疆电信动环'+modelName+'统计图',
	            x: -20 //center
	        },
	        subtitle: {
	            text: '电压有效值历史数据统计图',
	            x: -20
	        },
	        xAxis: {
	            categories: chartData.categories,
	            crosshair: true
	        },
	        yAxis: {
	            title: {
	                text: '电压有效值 (V)'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: 'V'
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	        series: [{
		        name: 'A相电压有效值',
		        data: chartData.voltage1
		    }, {
		        name: 'B相电压有效值',
		        data: chartData.voltage2
		    }, {
		        name: 'C相电压有效值',
		        data: chartData.voltage3
		    }, {
		        name: '合相电压有效值',
		        data: chartData.voltage4
		    }]
	    });

	    $('#chart-current').highcharts({
	    	title: {
	    		text: '新疆电信动环'+modelName+'统计图',
	            x: -20 //center
	        },
	        subtitle: {
	            text: '电流历史数据统计图',
	            x: -20
	        },
	        xAxis: {
	            categories: chartData.categories,
	            crosshair: true
	        },
	        yAxis: {
	            title: {
	                text: '电流 有效值(A)'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: 'A'
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	    	series: [{
	            name: 'A相电流有效值',
	            data: chartData.current1
	        }, {
	            name: 'B相电流有效值',
	            data: chartData.current2
	        }, {
	            name: 'C相电流有效值',
	            data: chartData.current3
	        }, {
	            name: '合相电流有效值',
	            data: chartData.current4
	        }] 
	    });

	    $('#chart-power').highcharts({
	    	title: {
	    		text: '新疆电信动环'+modelName+'统计图',
	            x: -20 //center
	        },
	        subtitle: {
	            text: '功率历史数据统计图',
	            x: -20
	        },
	        xAxis: {
	            categories: chartData.categories,
	            crosshair: true
	        },
	        yAxis: {
	            title: {
	                text: '有功功率 (W)'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: 'W'
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	    	series: [{
	            name: 'A相有功功率',
	            data: chartData.power1
	        }, {
	            name: 'B相有功功率',
	            data: chartData.power2
	        }, {
	            name: 'C相有功功率',
	            data: chartData.power3
	        }, {
	            name: '合相有功功率',
	            data: chartData.power4
	        }] 
	    });

	    $('#chart-energy').highcharts({
	    	title: {
	    		text: '新疆电信动环'+modelName+'统计图',
	            x: -20 //center
	        },
	        subtitle: {
	            text: '电能历史数据统计图',
	            x: -20
	        },
	        xAxis: {
	            categories: chartData.categories,
	            crosshair: true
	        },
	        yAxis: {
	            title: {
	                text: '有功电能 (kW·h)'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: 'kW·h'
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	    	series: [{
	            name: 'A相有功电能',
	            data: chartData.energy1
	        }, {
	            name: 'B相有功电能',
	            data: chartData.energy2
	        }, {
	            name: 'C相有功电能',
	            data: chartData.energy3
	        }, {
	            name: '合相有功电能',
	            data: chartData.energy4
	        }] 
	    });
	});
	
}

if(model == 'battery_24'||model == 'battery_32'){
	$(function () {
	    $('#chart-voltage').highcharts({
	        title: {
	        	text: '新疆电信动环'+modelName+'统计图',
	            x: -20 //center
	        },
	        subtitle: {
	            text: '蓄电池总电压历史数据统计图',
	            x: -20
	        },
	        xAxis: {
	            categories: chartData.categories,
	            crosshair: true
	        },
	        yAxis: {
	            title: {
	                text: '蓄电池总电压 (V)'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: 'V'
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	        series: [{
		        name: '蓄电池总电压',
		        data: chartData.voltage
		    }]
	    });

	    $('#chart-current').highcharts({
	        title: {
	        	text: '新疆电信动环'+modelName+'统计图',
	            x: -20 //center
	        },
	        subtitle: {
	            text: '电流历史数据统计图',
	            x: -20
	        },
	        xAxis: {
	            categories: chartData.categories,
	            crosshair: true
	        },
	        yAxis: {
	            title: {
	                text: '电流 (A)'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: 'A'
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	        series: [{
		        name: '电流',
		        data: chartData.current
		    }]
	    });  
	});
}


if(model.indexOf("-ac") > 0){
	$(function () {
		 $('#chart-current').highcharts({
		        title: {
		        	text: '新疆电信动环'+modelName+'统计图',
		            x: -20 //center
		        },
		        subtitle: {
		            text: '电流历史数据统计图',
		            x: -20
		        },
		        xAxis: {
		            categories: chartData.categories,
		            crosshair: true
		        },
		        yAxis: {
		            title: {
		                text: '电流 (A)'
		            },
		            plotLines: [{
		                value: 0,
		                width: 1,
		                color: '#808080'
		            }]
		        },
		        tooltip: {
		            valueSuffix: 'A'
		        },
		        legend: {
		            layout: 'vertical',
		            align: 'right',
		            verticalAlign: 'middle',
		            borderWidth: 0
		        },
		        series: [{
		            name: 'A相电流',
		            data: chartData.current1
		        }, {
		            name: 'B相电流',
		            data: chartData.current2
		        }, {
		            name: 'C相电流',
		            data: chartData.current3
		        }] 
		    });
	});
}

if(model.indexOf("-dc") > 0){
	$(function () {
	    $('#chart-voltage').highcharts({
	        title: {
	        	text: '新疆电信动环'+modelName+'统计图',
	            x: -20 //center
	        },
	        subtitle: {
	            text: '电压历史数据统计图',
	            x: -20
	        },
	        xAxis: {
	            categories: chartData.categories,
	            crosshair: true
	        },
	        yAxis: {
	            title: {
	                text: '电压 (V)'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: 'V'
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	        series: [{
		        name: '电压',
		        data: chartData.voltage
		    }]
	    });

	    $('#chart-current').highcharts({
	        title: {
	        	text: '新疆电信动环'+modelName+'统计图',
	            x: -20 //center
	        },
	        subtitle: {
	            text: '电流历史数据统计图',
	            x: -20
	        },
	        xAxis: {
	            categories: chartData.categories,
	            crosshair: true
	        },
	        yAxis: {
	            title: {
	                text: '电流 (A)'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: 'A'
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	        series: [{
		        name: '电流',
		        data: chartData.current
		    }]
	    });  
	});
}


if(model.indexOf("-rc") > 0){
	$(function () {
	    $('#chart-voltage').highcharts({
	        title: {
	        	text: '新疆电信动环'+modelName+'统计图',
	            x: -20 //center
	        },
	        subtitle: {
	            text: '输出电压历史数据统计图',
	            x: -20
	        },
	        xAxis: {
	            categories: chartData.categories,
	            crosshair: true
	        },
	        yAxis: {
	            title: {
	                text: '电压 (V)'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: 'V'
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	        series: [{
		        name: '电压',
		        data: chartData.voltage
		    }]
	    });
	});
}

if(model == 'humid'||model == 'temperature'||model == 'water'){
	$(function () {
		 $('#chart-voltage').highcharts({
		        title: {
		        	text: '新疆电信动环'+modelName+'统计图',
		            x: -20 //center
		        },
		        subtitle: {
		            text: '数值历史数据统计图',
		            x: -20
		        },
		        xAxis: {
		            categories: chartData.categories,
		            crosshair: true
		        },
		        yAxis: {
		            title: {
		                text: '数值'
		            },
		            plotLines: [{
		                value: 0,
		                width: 1,
		                color: '#808080'
		            }]
		        },
		        tooltip: {
		            valueSuffix: ''
		        },
		        legend: {
		            layout: 'vertical',
		            align: 'right',
		            verticalAlign: 'middle',
		            borderWidth: 0
		        },
		        series: [{
		            name: '数值',
		            data: chartData.value
		        }] 
		    });
	});
}

if(model == 'aeg-ms10se'){
	$(function () {
	    $('#chart-voltage').highcharts({
	        title: {
	            text: '新疆电信动环'+modelName+'统计图',
	            x: -20 //center
	        },
	        subtitle: {
	            text: '相电压历史数据统计图',
	            x: -20
	        },
	        xAxis: {
	            categories: chartData.categories,
	            crosshair: true
	        },
	        yAxis: {
	            title: {
	                text: '相电压 (V)'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: 'V'
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	        series: [{
		        name: '相电压V1',
		        data: chartData.voltage1
		    }, {
		        name: '相电压V2',
		        data: chartData.voltage2
		    }, {
		        name: '相电压V3',
		        data: chartData.voltage3
		    }, {
		        name: '相电压均值Vvavg',
		        data: chartData.voltage4
		    }]
	    });

	    $('#chart-current').highcharts({
	    	title: {
	    		text: '新疆电信动环'+modelName+'统计图',
	            x: -20 //center
	        },
	        subtitle: {
	            text: '相（线）电流历史数据统计图',
	            x: -20
	        },
	        xAxis: {
	            categories: chartData.categories,
	            crosshair: true
	        },
	        yAxis: {
	            title: {
	                text: '相（线）电流(A)'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: 'A'
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	    	series: [{
	            name: '相（线）电流I1',
	            data: chartData.current1
	        }, {
	            name: '相（线）电流I2',
	            data: chartData.current2
	        }, {
	            name: '相（线）电流I3',
	            data: chartData.current3
	        }, {
	            name: '三相电流均值Iavg',
	            data: chartData.current4
	        }] 
	    });

	    $('#chart-power').highcharts({
	    	title: {
	    		text: '新疆电信动环'+modelName+'统计图',
	            x: -20 //center
	        },
	        subtitle: {
	            text: '分相有功功率历史数据统计图',
	            x: -20
	        },
	        xAxis: {
	            categories: chartData.categories,
	            crosshair: true
	        },
	        yAxis: {
	            title: {
	                text: '分相有功功率 (W)'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: 'W'
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	    	series: [{
	            name: '分相有功功率P1',
	            data: chartData.power1
	        }, {
	            name: '分相有功功率P2',
	            data: chartData.power2
	        }, {
	            name: '分相有功功率P3',
	            data: chartData.power3
	        }, {
	            name: '系统有功功率Psum',
	            data: chartData.power4
	        }] 
	    });
	});
	
}

if(model == 'psm-6'){
	$(function () {
	    $('#chart-voltage').highcharts({
	        title: {
	        	text: '新疆电信动环'+modelName+'统计图',
	            x: -20 //center
	        },
	        subtitle: {
	            text: '均/浮充电压历史数据统计图',
	            x: -20
	        },
	        xAxis: {
	            categories: chartData.categories,
	            crosshair: true
	        },
	        yAxis: {
	            title: {
	                text: '电压 (V)'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: 'V'
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	        series: [{
	            name: '均充电压',
	            data: chartData.power1
	        }, {
	            name: '浮充电压',
	            data: chartData.power2
	        }] 
	    });
	});
}

if(model == 'datamate3000'){
	$(function () {
	    $('#chart-voltage').highcharts({
	        title: {
	        	text: '新疆电信动环'+modelName+'统计图',
	            x: -20 //center
	        },
	        subtitle: {
	            text: '室内/外温度历史数据统计图',
	            x: -20
	        },
	        xAxis: {
	            categories: chartData.categories,
	            crosshair: true
	        },
	        yAxis: {
	            title: {
	                text: '温度 (°C)'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: '°C'
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	        series: [{
	            name: '室内温度',
	            data: chartData.power1
	        }, {
	            name: '室外温度',
	            data: chartData.power2
	        }] 
	    });
	});
}


</script>
<div class="main-wrapper">
	<div class="container-fluid">
		<div class="row-fluid ">
			<div class="span12">
				<div class="primary-head">
					<h3 class="page-header">管理面板</h3>
					<ul class="breadcrumb">
						<li><a class="icon-home" href="/"></a> <span class="divider"><i
								class="icon-angle-right"></i></span></li>
						<?php foreach ($bcList as $bcObj){?>
						<?php if($bcObj->isLast){?>	
						<li class="active"><?php echo htmlentities($bcObj->title,ENT_COMPAT,"UTF-8");?></li>
						<?php }else {?>
						<li><a href='<?php echo htmlentities($bcObj->url,ENT_COMPAT,"UTF-8");?>'><?php echo htmlentities($bcObj->title,ENT_COMPAT,"UTF-8");?></a>
							<span class="divider"><i class="icon-angle-right"></i></span></li>
						<?php }?>
						<?php }?>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
		      <div class='span3'>
				<div class="content-widgets">
					<div class="widget-header-block">
						<h3>设备列表</h3>
						<div class="content-box">
						<input type="text" value=""
							style="box-shadow: inset 0 0 4px #eee; margin: 0; padding: 6px 12px; border-radius: 4px; border: 1px solid silver; font-size: 1.1em;"
							id="userQuery" placeholder="搜索" />
						<div id='pwTree'></div>
					   </div>
						<div id='area-tree' style="max-height: 500px; overflow-y: auto;">									
						</div>
					</div>					
				</div>
			</div>
			<div class="span9">
			<?php if($powerDataList){ ?>
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets">
						<div class="widget-head bondi-blue">
							<h3>统计图</h3>
						</div>
						<div class="widget-container">
							<div id="chart-voltage"></div>
							<div id="chart-current"></div>
							<div id="chart-power"></div>
							<div id="chart-energy"></div>
						</div>
					</div>
				</div>
			</div>
	    	<?php }?>
				<div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>综合查询</h3>
					</div>
					<div class="widget-container">
						<form class="form-horizontal">
						  <div class="control-group">
								<label class="control-label">当前选中设备<input type="hidden" id="data_id" name="data_id" 
								value="<?php echo $data_id;?>" /></label>
								<div class="controls" id="selPowerMeter"  >
									<?php if(isset($dataObj)){ 
									   echo Defines::$gCity[$dataObj->city_code].">".Defines::$gCounty[$dataObj->city_code][$dataObj->county_code].">".$dataObj->substation_name.">".$dataObj->room_name.">".$dataObj->name;
									}?>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">开始时间 - 终止时间</label>
								<div class="controls" style="margin-left: 20px; float: left;">
								<input type="text" class='form-control date-range-picker'
										name="dateRange" id="dateRange"
										value="<?php if(isset($dateRange)) echo htmlentities($dateRange, ENT_COMPAT, "UTF-8");?>">
										</div>
							</div>
							<div class="form-actions">
								<button id="btnSearch" class="btn btn-success" type="submit">查询</button>
								<button id="btnExport" name="export" class="btn btn-success" value="exporttoexcel" type="submit">导出报表</button>
							</div>
						</form>
					</div>
					<div class="widget-head bondi-blue">
						<h3>查询结果</h3>
					</div>

					<div class="widget-container">
				  <?php if($powerDataList){ ?>
					<div class="row-fluid">
							<div class="span6">
                                          总计 <?php echo $count;?> 条历史数据
                            </div>
							<div class="span6">
                            <?php echo $pagination;?>
                            </div>
						</div>
				   <?php } ?>
						<table class="table table-bordered responsive table-striped">
						
						
						<!-- D类板载电表历史数据				 -->
			            <?php if($model=="power_302a"){ ?>
							<thead>
								<tr>
								    <th>序号</th>
									<th>日期</th>
									<th>A相电压</th>
									<th>B相电压</th>
									<th>C相电压</th>
									<th>合相电压</th>
									<th>A相电流</th>
									<th>B相电流</th>
									<th>C相电流</th>
									<th>合相电流</th>
									<th>A相电能</th>
									<th>B相电能</th>
									<th>C相电能</th>
									<th>合相电能</th>
									<th>详细信息</th>
								</tr>
							</thead>
							<tbody>
					           <?php $i = $offset + 1; foreach($powerDataList as $powerDataObj){ ?>		 
							     <tr>
							        <td><?php echo $i++;?></td>
							        <td><?php echo htmlentities($powerDataObj->Date." ".$powerDataObj->Time,ENT_COMPAT,"UTF-8");?></td>					
									<td><?php echo number_format($powerDataObj->uaRms,3);?></td>
									<td><?php echo number_format($powerDataObj->ubRms,3);?></td>
									<td><?php echo number_format($powerDataObj->ucRms,3);?></td>
									<td><?php echo number_format($powerDataObj->utRms,3);?></td>
									<td><?php echo number_format($powerDataObj->iaRms,3);?></td>
									<td><?php echo number_format($powerDataObj->ibRms,3);?></td>
									<td><?php echo number_format($powerDataObj->icRms,3);?></td>
									<td><?php echo number_format($powerDataObj->itRms,3);?></td>
									<td><?php echo number_format($powerDataObj->epa,3);?></td>
									<td><?php echo number_format($powerDataObj->epb,3);?></td>
									<td><?php echo number_format($powerDataObj->epc,3);?></td>
									<td><?php echo number_format($powerDataObj->ept,3);?></td>
									<td><button class='btn btn-info dev-info'
											data_id='<?php echo $powerDataObj->data_id;?>' model='<?php echo $model;?>' 
											id='<?php echo $i-1;?>' endTime='<?php echo $endTime;?>' 
											startTime='<?php echo $startTime;?>' >详细信息</button></td>
								</tr>
							 <?php }?>
							</tbody>
							<?php } ?> 
						<!--  交直流屏电源蓄电池组、UPS电源蓄电池历史数据             -->
                        <?php if(in_array($model,array('battery_24','battery_32'))){ ?>
                             <?php $battery_voltage = $powerDataObj->battery_voltage;
//                                    $len = count($battery_voltage);
//                                    for ($i = 0; $i < $len; $i++)
//                                    {
//                                        $battery_voltage[$i] = number_format($battery_voltage[$i],3);
//                                    }?>
							<thead>
								<tr>
								    <th>序号</th>
									<th>更新日期</th>
									<th>数据ID</th>
									<th>蓄电池总电压</th>
									<th>电流</th>
									<th>温度</th>
									<th>详细信息</th>
								</tr>
							</thead>
							<tbody>
					           <?php $i = $offset + 1; foreach($powerDataList as $powerDataObj){ ?>		 
							     <tr>
							        <td><?php echo $i++;?></td>
									<td><?php echo htmlentities($powerDataObj->Date." ".$powerDataObj->Time,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->data_id,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo number_format($powerDataObj->voltage,3);?></td>									
									<td><?php echo number_format($powerDataObj->current,3);?></td>
									<td><?php echo number_format($powerDataObj->temperature,3);?></td>
									<td><button class='btn btn-info dev-info'
											data_id='<?php echo $powerDataObj->data_id;?>' model='<?php echo $model;?>' 
											id='<?php echo $i-1;?>' endTime='<?php echo $endTime;?>' 
											startTime='<?php echo $startTime;?>' >详细信息</button></td>
								</tr>
							 <?php }?>
							</tbody>
						<?php } ?> 
						
						<!-- 湿度、温度、水浸历史数据                    -->
                        <?php if($model=="humid"||$model=="temperature"||$model=="water"||$model=='battery24_voltage'||$model=='motor_battery'){ ?>
                        <thead>
								<tr>
								    <th>序号</th>
									<th>更新日期</th>
									<th>数据ID</th>
									<th>数值</th>
									<th>详细信息</th>
								</tr>
							</thead>
							<tbody>
					           <?php $i = $offset + 1; foreach($powerDataList as $powerDataObj){ ?>		 
							     <tr>
							        <td><?php echo $i++;?></td>
									<td><?php echo htmlentities($powerDataObj->Date." ".$powerDataObj->Time,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->data_id,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo number_format($powerDataObj->value,3);?></td>
									<td><button class='btn btn-info dev-info'
											data_id='<?php echo $powerDataObj->data_id;?>' model='<?php echo $model;?>' 
											id='<?php echo $i-1;?>' endTime='<?php echo $endTime;?>'
											startTime='<?php echo $startTime;?>' >详细信息</button></td>
								</tr>
							 <?php }?>
							</tbody>
						<?php } ?>
						
						<!-- 交流屏电源历史数据                    -->
                        <?php if(strpos($model,"-ac")!== false){ ?>
                        <thead>
								<tr>
								    <th>序号</th>
									<th>更新日期</th>
									<th>数据ID</th>
									<th>A相电流</th>
									<th>B相电流</th>
									<th>C相电流</th>
									<th>交流输入路数</th>
									<th>详细信息</th>
								</tr>
							</thead>
							<tbody>
					           <?php $i = $offset + 1; foreach($powerDataList as $powerDataObj){ ?>		 
							     <tr>
							        <td><?php echo $i++;?></td>
									<td><?php echo htmlentities($powerDataObj->Date." ".$powerDataObj->Time,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->data_id,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo number_format($powerDataObj->ia,3);?></td>
									<td><?php echo number_format($powerDataObj->ib,3);?></td>
									<td><?php echo number_format($powerDataObj->ic,3);?></td>
									<td><?php echo htmlentities($powerDataObj->channel_count,ENT_COMPAT,"UTF-8");?></td>
									<td><button class='btn btn-info dev-info'
											data_id='<?php echo $powerDataObj->data_id;?>' model='<?php echo $model;?>' 
											id='<?php echo $i-1;?>' endTime='<?php echo $endTime;?>'
											startTime='<?php echo $startTime;?>' >详细信息</button></td>
								</tr>
							 <?php }?>
							</tbody>
						<?php } ?>
						
						<!-- 直流屏电源历史数据                    -->
                        <?php if(strpos($model,"-dc")!== false){ ?>
                        <thead>
								<tr>
								    <th>序号</th>
									<th>更新日期</th>
									<th>数据ID</th>
									<th>直流输出电压</th>
									<th>负载总电流</th>
									<th>告警电压</th>
									<th>详细信息</th>
								</tr>
							</thead>
							<tbody>
					           <?php $i = $offset + 1; foreach($powerDataList as $powerDataObj){ ?>		 
							     <tr>
							        <td><?php echo $i++;?></td>
									<td><?php echo htmlentities($powerDataObj->Date." ".$powerDataObj->Time,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->data_id,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo number_format($powerDataObj->v,3);?></td>
									<td><?php echo number_format($powerDataObj->i,3);?></td>
									<td><?php echo '('.$powerDataObj->alert_v['$binary'].','.$powerDataObj->alert_v['$type'].')';?></td>
									<td><button class='btn btn-info dev-info'
											data_id='<?php echo $powerDataObj->data_id;?>' model='<?php echo $model;?>' 
											id='<?php echo $i-1;?>' endTime='<?php echo $endTime;?>'
											startTime='<?php echo $startTime;?>' >详细信息</button></td>
								</tr>
							 <?php }?>
							</tbody>
						<?php } ?>
						
						<!-- 直流屏电源历史数据                    -->
                        <?php if(strpos($model,"-rc")!== false){ ?>
                        <thead>
								<tr>
								    <th>序号</th>
									<th>更新日期</th>
									<th>数据ID</th>
									<th>vu</th>
									<th>vl</th>
									<th>iu</th>
									<th>fu</th>
									<th>fl</th>
									<th>详细信息</th>
								</tr>
							</thead>
							<tbody>
					           <?php $i = $offset + 1; foreach($powerDataList as $powerDataObj){ ?>		 
							     <tr>
							        <td><?php echo $i++;?></td>
									<td><?php echo htmlentities($powerDataObj->Date." ".$powerDataObj->Time,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->data_id,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo number_format($powerDataObj->vu,3);?></td>
									<td><?php echo number_format($powerDataObj->vl,3);?></td>
									<td><?php echo number_format($powerDataObj->iu,3);?></td>
									<td><?php echo number_format($powerDataObj->fu,3);?></td>
									<td><?php echo number_format($powerDataObj->fl,3);?></td>
									<td><button class='btn btn-info dev-info'
											data_id='<?php echo $powerDataObj->data_id;?>' model='<?php echo $model;?>' 
											id='<?php echo $i-1;?>' endTime='<?php echo $endTime;?>'
											startTime='<?php echo $startTime;?>' >详细信息</button></td>
								</tr>
							 <?php }?>
							</tbody>
						<?php } ?>
						
						
						
						
						<!-- 华为开关电源PSM-6                   -->
                        <?php if(in_array($model,array('psm-6'))){ ?>
                        <thead>
								<tr>
								    <th>序号</th>
									<th>更新日期</th>
									<th>数据ID</th>
									<th>交流输入类型</th>
									<th>输入交流高压保护值(V)</th>
									<th>输入交流低压保护值(V)</th>
									<th>电池总数(组)</th>
									<th>电池容量(Ah)</th>
									<th>详细信息</th>
								</tr>
							</thead>
							<tbody>
					           <?php $i = $offset + 1; foreach($powerDataList as $powerDataObj){ ?>		 
							     <tr>
							        <td><?php echo $i++;?></td>
									<td><?php echo htmlentities($powerDataObj->Date." ".$powerDataObj->Time,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->data_id,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->ac_type,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->p_in_v_max_limiting,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->p_in_v_min_limiting,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->battery_count,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->battery_capacity,ENT_COMPAT,"UTF-8");?></td>
									<td><button class='btn btn-info dev-info'
											data_id='<?php echo $powerDataObj->data_id;?>' model='<?php echo $model;?>' 
											id='<?php echo $i-1;?>' endTime='<?php echo $endTime;?>'
											startTime='<?php echo $startTime;?>' >详细信息</button></td>
								</tr>
							 <?php }?>
							</tbody>
						<?php } ?>

						<!-- 新风系统历史数据                    -->
                        <?php if($model=="fresh_air"){ ?>
                        <thead>
								<tr>
								    <th>序号</th>
									<th>更新日期</th>
									<th>数据ID</th>
									<th>告警状态</th>
									<th>温度设定点</th>
									<th>湿度设定点</th>
									<th>高温告警点</th>
									<th>低温告警点</th>
									<th>详细信息</th>
								</tr>
							</thead>
							<tbody>
					           <?php $i = $offset + 1; foreach($powerDataList as $powerDataObj){ ?>		 
							     <tr>
							        <td><?php echo $i++;?></td>
									<td><?php echo htmlentities($powerDataObj->Date." ".$powerDataObj->Time,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->data_id,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->alert,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->setting_temperature,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->setting_humidity,ENT_COMPAT,"UTF-8");?></td>									
									<td><?php echo htmlentities($powerDataObj->high_temperature_alert,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->low_temperature_alert,ENT_COMPAT,"UTF-8");?></td>
									<td><button class='btn btn-info dev-info'
											data_id='<?php echo $powerDataObj->data_id;?>' model='<?php echo $model;?>' 
											id='<?php echo $i-1;?>' endTime='<?php echo $endTime;?>'
											startTime='<?php echo $startTime;?>' >详细信息</button></td>
								</tr>
							 <?php }?>
							</tbody>
						<?php } ?>
						
						<!-- AEG低压配电柜                     -->
                        <?php if(in_array($model,array('aeg-ms10se'))){ ?>
                        <thead>
								<tr>
								    <th>序号</th>
									<th>更新日期</th>
									<th>数据ID</th>
									<th>相电压均值Vvavg</th>
									<th>线电压均值Vlavg</th>
									<th>三相电流均值Iavg</th>
									<th>系统有功功率Psum</th>
									<th>总电度 Eq_total</th>
									<th>详细信息</th>
								</tr>
							</thead>
							<tbody>
					           <?php $i = $offset + 1; foreach($powerDataList as $powerDataObj){ ?>		 
							     <tr>
							        <td><?php echo $i++;?></td>
									<td><?php echo htmlentities($powerDataObj->Date." ".$powerDataObj->Time,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->data_id,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->vvavg,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->blavg,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->iavg,ENT_COMPAT,"UTF-8");?></td>									
									<td><?php echo htmlentities($powerDataObj->psum,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->eq_total,ENT_COMPAT,"UTF-8");?></td>
									<td><button class='btn btn-info dev-info'
											data_id='<?php echo $powerDataObj->data_id;?>' model='<?php echo $model;?>' 
											id='<?php echo $i-1;?>' endTime='<?php echo $endTime;?>'
											startTime='<?php echo $startTime;?>' >详细信息</button></td>
								</tr>
							 <?php }?>
							</tbody>
						<?php } ?>
						
						<!-- 爱默生Datamate300                    -->
                        <?php if(in_array($model,array('datamate3000'))){ ?>
                        <thead>
								<tr>
								    <th>序号</th>
									<th>更新日期</th>
									<th>数据ID</th>
									<th>室内温度</th>
									<th>室内湿度</th>
									<th>室外温度</th>
									<th>开机温度</th>
									<th>关机湿度</th>
									<th>告警状态</th>
									<th>装置状态</th>
									<th>详细信息</th>
								</tr>
							</thead>
							<tbody>
					           <?php $i = $offset + 1; foreach($powerDataList as $powerDataObj){ ?>		 
							     <tr>
							        <td><?php echo $i++;?></td>
									<td><?php echo htmlentities($powerDataObj->Date." ".$powerDataObj->Time,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->data_id,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->room_temp,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->room_humid,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->outdoor_temp,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->temperature,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->humidity,ENT_COMPAT,"UTF-8");?></td>							
									<td><?php echo htmlentities($powerDataObj->alert_status,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($powerDataObj->unit_status,ENT_COMPAT,"UTF-8");?></td>
									<td><button class='btn btn-info dev-info'
											data_id='<?php echo $powerDataObj->data_id;?>' model='<?php echo $model;?>' 
											id='<?php echo $i-1;?>' endTime='<?php echo $endTime;?>'
											startTime='<?php echo $startTime;?>' >详细信息</button></td>
								</tr>
							 <?php }?>
							</tbody>
						<?php } ?>
						
						</table>
					<?php if($powerDataList){ ?>
						<div class="row-fluid">
							<div class="span6">
                                 总计 <?php echo $count;?> 条历史数据
                            </div>
							<div class="span6">
                            <?php echo $pagination;?>
                            </div>
					   </div>
					 <?php } ?>   
				</div>
			</div>
		</div>
	</div>
</div>
