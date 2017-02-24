<script type="text/javascript">

var chartData = new Object();
chartData.title = '<?php echo $chartTitle;?>';
chartData.categories = new Array();
chartData.values = new Object();
chartData.values.level1 = new Array();
chartData.values.level2 = new Array();
chartData.values.level3 = new Array();
chartData.values.level4 = new Array();
var powerDataList = eval('<?php echo json_encode($powerDataList);?>');
for(var i = 0 ; i < alarmList.length ; i++)
{
	var powerDataObj = powerDataList[i];
	chartData.categories[i] = powerDataObj.Data;
	chartData.values.level1[i] = parseInt(powerDataObj.level1);
	chartData.values.level2[i] = parseInt(powerDataObj.level2);
	chartData.values.level3[i] = parseInt(powerDataObj.level3);
	chartData.values.level4[i] = parseInt(alarmObj.level4);	
}

$(function () {
    $('#chart-area').highcharts({
        title: {
            text: 'XXXX'+'历史数据查询',
            x: -20 //center
        },
       
        xAxis: {
        	categories: chartData.categories
        },
        yAxis: {
            title: {
                text: 'Temperature (°C)'
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
            name: 'Tokyo',
            data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
        }, {
            name: 'New York',
            data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
        }, {
            name: 'Berlin',
            data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
        }, {
            name: 'London',
            data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
        }]
    });
});
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
			
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets">
						<div class="widget-head bondi-blue">
							<h3>统计图</h3>
						</div>
						<div class="widget-container">
							<div id="chart-area"></div>
						</div>
					</div>
				</div>
			</div>
		
				<div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>综合查询</h3>
					</div>
					<div class="widget-container">
						<form class="form-horizontal">
						  <div class="control-group">
								<label class="control-label">当前选中设备<input type="hidden" id="data_id" name="data_id" /></label>
								<div class="controls" id="selPowerMeter">
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
					<div class="row-fluid">
							<div class="span6">
                                   总计 <?php echo $count;?> 条历史数据
                            </div>
							<div class="span6">
                            <?php echo $pagination;?>
                            </div>
						</div>
						<table class="table table-bordered responsive table-striped">
						
						
						<!-- D类板载电表历史数据				 -->
			            <?php if($model=="power_302a"){ ?>
							<thead>
								<tr>
								    <th>序号</th>
									<th>日期</th>
									<th>A相功率</th>
									<th>B相功率</th>
									<th>C相功率</th>
									<th>合相功率</th>
									<th>A相电压</th>
									<th>B相电压</th>
									<th>C相电压</th>
									<th>A相电流</th>
									<th>B相电流</th>
									<th>C相电流</th>
									<th>合相电流</th>
									<th>A相电能</th>
									<th>B相电能</th>
									<th>C相电能</th>
									<th>合相电能</th>
								</tr>
							</thead>
							<tbody>
					           <?php $i = $offset + 1; foreach($powerDataList as $powerDataObj){ ?>		 
							     <tr>
							        <td><?php echo $i++;?></td>
							        <td><?php echo htmlentities($powerDataObj->Date." ".$powerDataObj->Time,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo number_format($powerDataObj->pa,3);?></td>
									<td><?php echo number_format($powerDataObj->pb,3);?></td>
									<td><?php echo number_format($powerDataObj->pc,3);?></td>
									<td><?php echo number_format($powerDataObj->pt,3);?></td>									
									<td><?php echo number_format($powerDataObj->uaRms,3);?></td>
									<td><?php echo number_format($powerDataObj->ubRms,3);?></td>
									<td><?php echo number_format($powerDataObj->ucRms,3);?></td>
									<td><?php echo number_format($powerDataObj->iaRms,3);?></td>
									<td><?php echo number_format($powerDataObj->ibRms,3);?></td>
									<td><?php echo number_format($powerDataObj->icRms,3);?></td>
									<td><?php echo number_format($powerDataObj->itRms,3);?></td>
									<td><?php echo number_format($powerDataObj->epa,3);?></td>
									<td><?php echo number_format($powerDataObj->epb,3);?></td>
									<td><?php echo number_format($powerDataObj->epc,3);?></td>
									<td><?php echo number_format($powerDataObj->ept,3);?></td>
								</tr>
							 <?php }?>
							</tbody>
							<?php } ?> 
						<!--  交直流屏电源蓄电池组、UPS电源蓄电池历史数据             -->
                        <?php if($model=="battery_24"||$model=="battery_32"){ ?>	
							<thead>
								<tr>
								    <th>序号</th>
									<th>更新日期</th>
									<th>数据ID</th>
									<th>蓄电池总电压</th>
									<th>电压</th>
									<th>电流</th>
									<th>温度</th>
								</tr>
							</thead>
							<tbody>
					           <?php $i = $offset + 1; foreach($powerDataList as $powerDataObj){ ?>		 
							     <tr>
							        <td><?php echo $i++;?></td>
									<td><?php echo htmlentities($powerDataObj->Date." ".$powerDataObj->Time,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo number_format($powerDataObj->data_id,3);?></td>
									<td><?php echo number_format($powerDataObj->battery_voltage,3);?></td>
									<td><?php echo number_format($powerDataObj->voltage,3);?></td>									
									<td><?php echo number_format($powerDataObj->current,3);?></td>
									<td><?php echo number_format($powerDataObj->temperature,3);?></td>
								</tr>
							 <?php }?>
							</tbody>
						<?php } ?> 
						
						<!-- 湿度、温度、水浸历史数据                    -->
                        <?php if($model=="humid"||$model=="temperature"||$model=="water"){ ?>
                        <thead>
								<tr>
								    <th>序号</th>
									<th>更新日期</th>
									<th>数据ID</th>
									<th>数值</th>
								</tr>
							</thead>
							<tbody>
					           <?php $i = $offset + 1; foreach($powerDataList as $powerDataObj){ ?>		 
							     <tr>
							        <td><?php echo $i++;?></td>
									<td><?php echo htmlentities($powerDataObj->Date." ".$powerDataObj->Time,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo number_format($powerDataObj->data_id,3);?></td>
									<td><?php echo number_format($powerDataObj->value,3);?></td>
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
									<th>temperature1</th>
									<th>temperature2"</th>
									<th>temperature3</th>
									<th>temperature4"</th>
									<th>temperature5</th>
									<th>humidity1</th>
									<th>humidity2</th>
									<th>humidity3</th>
									<th>humidity4</th>
									<th>humidity5</th>
									<th>wind_temperature</th>
									<th>wind_humidity</th>
									<th>outside_temperature</th>
									<th>outside_humidity</th>
									<th>humidifier_current</th>
									<th>average_temperature</th>
									<th>average_humidity</th>
									<th>reserve_60_42_1</th>
									<th>reserve_60_42_2</th>
									<th>highest_temperature</th>
									<th>runstate_alert</th>
									<th>runstate_fan</th>
									<th>runstate_r1</th>
									<th>runstate_r2</th>
									<th>runstate_r3</th>
									<th>runstate_r4</th>
									<th>runstate_drain</th>	
									<th>runstate_fill</th>
									<th>runstate_pump</th>
									<th>runstate_ac</th>
									<th>alert</th>
									<th>setting_temperature</th>
									<th>setting_humidity</th>
									<th>high_temperature_alert</th>
									<th>low_temperature_alert</th>
									<th>high_humidity_alert</th>
									<th>low_humidity_alert</th>
								</tr>
							</thead>
							<tbody>
					           <?php $i = $offset + 1; foreach($powerDataList as $powerDataObj){ ?>		 
							     <tr>
							        <td><?php echo $i++;?></td>
									<td><?php echo htmlentities($powerDataObj->Date." ".$powerDataObj->Time,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo number_format($powerDataObj->data_id,3);?></td>
									<td><?php echo number_format($powerDataObj->temperature1,3);?></td>
									<td><?php echo number_format($powerDataObj->temperature2,3);?></td>
									<td><?php echo number_format($powerDataObj->temperature3,3);?></td>
									<td><?php echo number_format($powerDataObj->temperature4,3);?></td>
									<td><?php echo number_format($powerDataObj->temperature5,3);?></td>
									<td><?php echo number_format($powerDataObj->humidity1,3);?></td>
									<td><?php echo number_format($powerDataObj->humidity2,3);?></td>
									<td><?php echo number_format($powerDataObj->humidity3,3);?></td>
									<td><?php echo number_format($powerDataObj->humidity4,3);?></td>
									<td><?php echo number_format($powerDataObj->humidity5,3);?></td>
									<td><?php echo number_format($powerDataObj->wind_temperature,3);?></td>
									<td><?php echo number_format($powerDataObj->wind_humidity,3);?></td>
									<td><?php echo number_format($powerDataObj->outside_temperature,3);?></td>
									<td><?php echo number_format($powerDataObj->outside_humidity,3);?></td>
									<td><?php echo number_format($powerDataObj->humidifier_current,3);?></td>
									<td><?php echo number_format($powerDataObj->average_temperature,3);?></td>
									<td><?php echo number_format($powerDataObj->average_humidity,3);?></td>
									<td><?php echo number_format($powerDataObj->reserve_60_42_1,3);?></td>
									<td><?php echo number_format($powerDataObj->reserve_60_42_2,3);?></td>
									<td><?php echo number_format($powerDataObj->highest_temperature,3);?></td>
									<td><?php echo number_format($powerDataObj->runstate_alert,3);?></td>
									<td><?php echo number_format($powerDataObj->runstate_fan,3);?></td>
									<td><?php echo number_format($powerDataObj->runstate_r1,3);?></td>
									<td><?php echo number_format($powerDataObj->runstate_r2,3);?></td>
									<td><?php echo number_format($powerDataObj->runstate_r3,3);?></td>
									<td><?php echo number_format($powerDataObj->runstate_r4,3);?></td>
									<td><?php echo number_format($powerDataObj->runstate_drain,3);?></td>
									<td><?php echo number_format($powerDataObj->runstate_fill,3);?></td>
									<td><?php echo number_format($powerDataObj->runstate_pump,3);?></td>
									<td><?php echo number_format($powerDataObj->runstate_ac,3);?></td>
									<td><?php echo number_format($powerDataObj->alert,3);?></td>
									<td><?php echo number_format($powerDataObj->setting_temperature,3);?></td>
									<td><?php echo number_format($powerDataObj->setting_humidity,3);?></td>
									<td><?php echo number_format($powerDataObj->high_temperature_alert,3);?></td>
									<td><?php echo number_format($powerDataObj->low_temperature_alert,3);?></td>
									<td><?php echo number_format($powerDataObj->high_humidity_alert,3);?></td>
									<td><?php echo number_format($powerDataObj->low_humidity_alert,3);?></td>
								</tr>
							 <?php }?>
							</tbody>
						<?php } ?>
						
						
						
						</table>
						<div class="row-fluid">
							<div class="span6">
                                 总计 <?php echo $count;?> 条历史数据
                            </div>
							<div class="span6">
                            <?php echo $pagination;?>
                            </div>
                           
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
