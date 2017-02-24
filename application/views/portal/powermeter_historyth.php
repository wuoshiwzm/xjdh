<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        title: {
            text: 'Monthly Average Temperature',
            x: -20 //center
        },
        subtitle: {
            text: 'Source: WorldClimate.com',
            x: -20
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
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
						<h3>电表列表</h3>
						<div class="content-box">
						<input type="text" value=""
							style="box-shadow: inset 0 0 4px #eee; margin: 0; padding: 6px 12px; border-radius: 4px; border: 1px solid silver; font-size: 1.1em;"
							id="userQuery" placeholder="搜索" />
						<div id='pwTree'></div>
					   </div>
						<div id='area-tree'
											style="max-height: 500px; overflow-y: auto;">
										<ul id="cityKey">
										<?php foreach (Defines::$gCity as $cityKey => $cityVal) {?>
										  <li >
										     <?php echo $cityVal?>
										      <ul id="countyKey">
										       <?php foreach (Defines::$gCounty[$cityKey] as $countyKey => $countyVal) {?>
										       <li style="display:none;">
										          <?php echo $countyVal?>
										          <ul id="substationList">
										             <?php foreach ($substationList as $substationListObj){?>
										             <?php if($substationListObj->county_code == $countyKey){?>
										             <li>
										                <?php echo htmlentities($substationListObj->name,ENT_COMPAT,"UTF-8")?>
										                <ul id="roomList">
										                 <?php foreach ($deviceList as $roomListObj){?>
										                  <?php if($roomListObj->substation_id == $substationListObj->id){?>
										                  <li id="<?php echo htmlentities($roomListObj->dataId,ENT_COMPAT,"UTF-8")?>">
										                      <?php echo $roomListObj->name?>/ <?php echo htmlentities($roomListObj->devName,ENT_COMPAT,"UTF-8")?>

										                  </li>
										                  <?php }?>
										                  <?php }?>
										                </ul>
										             </li>
										             <?php }?>
										             <?php }?>
										          </ul>
										       </li>
										       <?php }?>
										      </ul>										    
										  </li>
										 <?php }?>
										</ul>
									</div>
					</div>					
				</div>
			</div>
			<div class="span9">
				<div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>综合查询</h3>
					</div>
					<div class="widget-container">
						<form class="form-horizontal">
						   <div class="control-group">
								<label class="control-label">当前选中电表<input type="hidden" id="hdPwDataId" name="hdPwDataId" /></label>
								<div class="controls" id="selPowerMeter">
									
								</div>
							</div>
							<div class="control-group">
							<label class="control-label" style="float: left;">结构维度</label>
							<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择维度"
										name='Flat' id='Flat'>

									</select>
								</div>
								<label class="control-label" style="float: left;">成员</label>
							<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select chzn-container-multi" multiple=''
										data-placeholder="选择成员" name='member' id='member'>
										<option>1</option>
										<option>2</option>
										<option>3</option>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">开始时间</label>
								<div class="controls" style="margin-left: 20px; float: left;">
								<input type="text" id="txtProductionDate"
										name="txtProductionDate" class="datepickers"
										value="<?php if(isset($datestart)) echo $datestart;?>">
								</div>
								<label class="control-label" style="float: left;">终止时间</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" class='datepickers' name='dateend'
										id='txtProductionDates'
										value="<?php if(isset($dateend)) echo $dateend;?>">
								</div>
							</div>
							<div class="form-actions">
								<button class="btn btn-success" type="submit">查询</button>
								<button class="btn btn-success" name="export" value="exporttoexcel" type="submit">导出报表</button>
							</div>
						</form>
					</div>
					<div class="widget-head bondi-blue">
						<h3>查询结果</h3>
					</div>
					<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
				</div>
			</div>
		</div>
	</div>
</div>

