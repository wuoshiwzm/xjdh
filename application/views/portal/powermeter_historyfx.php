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
							<label class="control-label" style="float: left;">分析维度</label>
							<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select chzn-container-multi" multiple=''
										data-placeholder="选择设备类型" name='' id=''>
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

