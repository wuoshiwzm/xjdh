<?php if($type == 'alarm'){?>
<script type="text/javascript">
var chartData = new Object();
chartData.title = '<?php echo $chartTitle;?>';
chartData.categories = new Array();
chartData.values = new Object();
chartData.values.level1 = new Array();
chartData.values.level2 = new Array();
chartData.values.level3 = new Array();
chartData.values.level4 = new Array();
var alarmList = eval('<?php echo json_encode($alarmList);?>');
for(var i = 0 ; i < alarmList.length ; i++)
{
	var alarmObj = alarmList[i];
	chartData.categories[i] = alarmObj.name;
	chartData.values.level1[i] = parseInt(alarmObj.level1);
	chartData.values.level2[i] = parseInt(alarmObj.level2);
	chartData.values.level3[i] = parseInt(alarmObj.level3);
	chartData.values.level4[i] = parseInt(alarmObj.level4);	
}
$(document).ready(function(){
	
	$('#chart-area').highcharts({
       chart: {
           type: 'column'
       },
       credits: false,
       title: {
           text: '新疆电信动环'+chartData.title+'统计图'
       },
       xAxis: {
           categories: chartData.categories,
           crosshair: true
       },
       yAxis: {
           min: 0,
           title: {
               text: '告警数量'
           },
           stackLabels: {
               enabled: true,
               style: {
                   fontWeight: 'bold',
                   color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
               }
           }
       },
       legend: {
    	   align: 'right',
           x: -70,
           verticalAlign: 'top',
           y: 20,
           floating: true,
           backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
           borderColor: '#CCC',
           borderWidth: 1,
           shadow: false
       },
       tooltip: {
           formatter: function() {
               return '<b>'+ this.x +'</b><br>'+
                   this.series.name +': '+ this.y +' 个<br>'+
                   '总共: '+ this.point.stackTotal + ' 个';
           }
       },
       plotOptions: {
           column: {
               stacking: 'normal',
               dataLabels: {
                   enabled: true,
                   color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
               }
           }
       },
       series: [{
    	    name: '一级告警',
    	    data: chartData.values.level1,
    	    color: 'red'
        }, {
            name: '二级告警',
            data: chartData.values.level2,
            color: 'orange'
        }, {
            name: '三级告警',
            data: chartData.values.level3,
            color: 'yellow'
        }, {
            name: '四级告警',
            data: chartData.values.level4,
            color: 'blue'
        }]
   });
});
</script>
<?php }else if($type == 'energy'){?>
<script type="text/javascript">
var chartData = new Object();
chartData.title = '<?php echo $chartTitle;?>';
chartData.categories = new Array();
chartData.values = new Array();

var energyList = eval('<?php echo json_encode($energyList);?>');
for(var i = 0 ; i < energyList.length ; i++)
{
	var energyObj = energyList[i];
	chartData.categories[i] = energyObj.name;
	chartData.values[i] = parseFloat(energyObj.energy);
}
$(document).ready(function(){
	
	$('#chart-area').highcharts({
       chart: {
           type: 'column'
       },
       credits: false,
       title: {
           text: '新疆电信动环'+chartData.title+'统计图'
       },
       xAxis: {
           categories: chartData.categories,
           crosshair: true
       },
       yAxis: {
           min: 0,
           title: {
               text: '能耗'
           }
       },
       legend: {
    	   align: 'right',
           x: -70,
           verticalAlign: 'top',
           y: 20,
           floating: true,
           backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
           borderColor: '#CCC',
           borderWidth: 1,
           shadow: false
       },
       tooltip: {
           formatter: function() {
               return '<b>'+ this.x +'</b><br>'+
                   this.series.name +': '+ this.y +' KW·h<br>';
           }
       },
       plotOptions: {
           column: {
               dataLabels: {
                   enabled: true,
                   color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
               }
           }
       },
       series: [{
    	    name: '能耗',
    	    data: chartData.values,
    	    color: 'green'
        }]
   });
});
</script>
<?php }?>
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
		<?php if(in_array($type, array('energy' ,'alarm'))){?>
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
		<?php }?>
		<div class="row-fluid">
			<div class="span12">
				<div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>综合查询</h3>
					</div>
					<div class="widget-container">
						<form class="form-horizontal">
							<div class="control-group">
								<label class="control-label" style="float: left;">分公司</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择分公司"
										name='selCity' id='selCity'>
										<?php if($userObj->user_role == "admin"){?>
    							        <option value=''>全网</option>
    							        <?php foreach (Defines::$gCity as $cityKey=>$cityVal){?>
							            <option value='<?php echo $cityKey;?>'
											<?php  if($cityCode == $cityKey){?> selected="selected"
											<?php }?>><?php echo $cityVal;?>本地网</option>
    							        <?php }?>
    							        <?php }else if($userObj->user_role == "city_admin"||$userObj->user_role == "noc"){ ?>
    							        <option value="<?php echo $userObj->city_code; ?>">
    							            <?php echo Defines::$gCity[$userObj->city_code]; ?></option>
    							        <?php }?>
    								</select>
								</div>

								<label class="control-label" style="float: left;">区域</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择区域"
										name='selCounty' id='selCounty'>
										<?php if($userObj->user_role == "city_admin"||$userObj->user_role == "noc"){ ?>
											<option value="0">所有区域</option>
											<?php foreach (Defines::$gCounty[$userObj->city_code] as $key=> $val){?>
										    <option value='<?php echo $key;?>'
												<?php if($countyCode == $key){?>selected="selected"<?php }?>>
												<?php echo $val;?></option>
									        <?php } ?>
								        <?php }else{ ?>
										    <option value="0">所有区域</option>
										    <?php if(count($cityCode)) foreach (Defines::$gCounty[$cityCode] as $key=> $val){?>
									            <option value='<?php echo $key;?>'
											    <?php if($countyCode == $key){?> selected="selected" <?php }?>>
											    <?php echo $val;?></option>
								            <?php }?>   
								        <?php }?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">所属局站</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择局站"
										name='selSubstation' id='selSubstation'>
										<option value=''>所有局站</option>
									<?php foreach ($substationList as $substationObj){?>
									   <option value='<?php echo htmlentities($substationObj->id,ENT_COMPAT,"UTF-8")?>'
											<?php if($substationObj->id == $selSubstation){?>
											selected="selected" <?php }?>> <?php echo htmlentities($substationObj->name,ENT_COMPAT,"UTF-8");?></option>
									<?php }?>
									</select>
								</div>
								<label class="control-label" style="float: left;">所属机房</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择机房"
										name='selRoom' id='selRoom'>
										<option value=''>所有机房</option>
									<?php if(isset($roomList)) foreach ($roomList as $roomObj){?>
									   <option value='<?php echo htmlentities($roomObj->id,ENT_COMPAT,"UTF-8")?>'
											<?php if($roomObj->id == $selRoom){?> selected="selected"
											<?php }?>> <?php echo htmlentities($roomObj->name,ENT_COMPAT,"UTF-8");?></option>
									<?php }?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">局站类型</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择局站类型 "
										name='selRoomType' id='selRoomType'>
										<option value=''>所有类型</option>
										<option value='A' <?php if($roomtype == 'A'){?>
											selected='selected' <?php }?>>A类基站</option>
										<option value='B' <?php if($roomtype == 'B'){?>
											selected='selected' <?php }?>>B类基站</option>
										<option value='C' <?php if($roomtype == 'C'){?>
											selected='selected' <?php }?>>C类基站</option>
										<option value='D' <?php if($roomtype == 'D'){?>
											selected='selected' <?php }?>>D类基站</option>
									</select>
								</div>
								<label class="control-label" style="float: left;">查询类型</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<label class="radio"> <input type="radio"
										<?php if($type != 'energy'){?> checked="" <?php }?>
										value="alarm" name="rdType">告警
									</label> <label class="radio"> <input type="radio"
										<?php if($type == 'energy'){?> checked="" <?php }?>
										value="energy" name="rdType">能耗
									</label>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">开始时间</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" class='datepicker' name='datestart'
										id='datestart'
										value="<?php if(isset($datestart)) echo $datestart;?>">
								</div>
								<label class="control-label" style="float: left;">终止时间</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" class='datepicker' name='dateend'
										id='dateend'
										value="<?php if(isset($dateend)) echo $dateend;?>">
								</div>
							</div>
							<div class="form-actions">
								<button class="btn btn-success" type="submit">查询</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>查询结果</h3>
					</div>
					<div class="widget-container">
					<?php if($type == 'alarm'){?>
					   <table class="table table-bordered responsive table-striped">
							<thead>
								<tr>
									<th><?php echo $columnName;?>\告警级别</th>
									<th>一级告警</th>
									<th>二级告警</th>
									<th>三级告警</th>
									<th>四级告警</th>
									<th>合计</th>
								</tr>
							</thead>
							<tbody>
							 <?php foreach ($alarmList as $alarmObj){?>
							     <tr>
									<td><?php echo htmlentities($alarmObj->name,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($alarmObj->level1,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($alarmObj->level2,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($alarmObj->level3,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($alarmObj->level4,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo (htmlentities($alarmObj->level1,ENT_COMPAT,"UTF-8")+htmlentities($alarmObj->level2,ENT_COMPAT,"UTF-8")+htmlentities($alarmObj->level3,ENT_COMPAT,"UTF-8")+htmlentities($alarmObj->level4,ENT_COMPAT,"UTF-8")) ;?></td>
								</tr>
							 <?php }?>
							</tbody>
						</table>
					<?php }elseif($type=='energy'){?>
					<?php }?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
