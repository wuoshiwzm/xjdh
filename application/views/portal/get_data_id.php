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
						<li><a href='<?php echo $bcObj->url;?>'><?php echo htmlentities($bcObj->title,ENT_COMPAT,"UTF-8");?></a>
							<span class="divider"><i class="icon-angle-right"></i></span></li>
						<?php }?>
						<?php }?>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>
							<i class="icon-search"></i> 综合查询
						</h3>
						<a class="widget-settings" href="#search-area" id='serarch-toggle'><i
							class="icon-hand-up"></i></a>
					</div>
					<div class="widget-container" style='display: none;'
						id='search-area'>
						<form class="form-horizontal">
							<div class="control-group">
								<label class="control-label" style="float: left;">所属部门/分公司</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择分公司"
										name='selCity' id='selCity'>
										<option value=''>全网</option>
    							        <?php foreach (Defines::$gCity as $cityKey=>$cityVal){?>
							            <option value='<?php echo $cityKey;?>'
											<?php  if($cityCode == $cityKey){?> selected="selected"
											<?php }?>><?php echo $cityVal;?>本地网</option>
    							        <?php }?>
    								</select>
								</div>
								<label class="control-label" style="float: left;">区域</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择区域"
										name='selCounty' id='selCounty'>
										<option value=''>全本地网</option>
									<?php if(count($devObj)) foreach (Defines::$gCounty[$cityCode] as $key=> $val){?>
									   <option value='<?php echo $key;?>'
											<?php if($cityCode == $key){?> selected="selected" <?php }?>><?php echo $val;?></option>
								   <?php }?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">所属局站</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择局站"
										name='selSubstation' id='selSubstation'>
									<?php if(isset($substationList)) foreach ($substationList as $substationObj){?>
									   <option value='<?php echo htmlentities($substationObj->id,ENT_COMPAT,"UTF-8")?>'
											<?php if($substationObj->id == $substationId){?>
											selected="selected" <?php }?>> <?php echo htmlentities($substationObj->name,ENT_COMPAT,"UTF-8");?></option>
									<?php }?>
									</select>
								</div>
								<label class="control-label" style="float: left;">所属机房</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择机房"
										name='selRoom' id='selRoom'>
									<?php if(isset($roomList)) foreach ($roomList as $roomObj){?>
									   <option value='<?php echo htmlentities($roomObj->id,ENT_COMPAT,"UTF-8")?>'
											<?php if($roomObj->id == $roomId){?> selected="selected"
											<?php }?>> <?php echo htmlentities($roomObj->name,ENT_COMPAT,"UTF-8");?></option>
									<?php }?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">所属采集板</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择采集板"
										name='selSmdDev' id='selSmdDev'>
									   <?php if(isset($smdDevList)) foreach ($smdDevList as $smdDevObj){?>
									   <option value='<?php echo htmlentities($smdDevObj->device_no,ENT_COMPAT,"UTF-8")?>'
											<?php if($devObj->smd_device_no == $deviceNo){?>
											selected="selected" <?php }?>><?php echo htmlentities($smdDevObj->name,ENT_COMPAT,"UTF-8");?></option>
									   <?php }?>
									</select>
								</div>
							<div class="form-actions">
								<button class="btn btn-success" type="submit" id='btn-submit'>提交</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<div class="content-widgets light-gray">
					<div class="widget-container">
						<br>
						<table id="dataTable"
							class="table table-bordered responsive table-striped">
							<thead>
								<tr>
									<th>序号</th>
									<th>分公司</th>
									<th>区域</th>
									<th>机房</th>
									<th>采集单元</th>
									<th>设备名</th>
									<th>原数据ID</th>
									<th>自动生成数据ID</th>
									<th>设备类型</th>
									<th>是否激活</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
							<?php $i = 1; foreach ($deviceidList as $devObj){?>
							<tr device_id='<?php echo htmlentities($devObj->id,ENT_COMPAT,"UTF-8"); ?>'>
									<td><?php echo $i++;?></td>
									<td><?php echo htmlentities(Defines::$gCity[$devObj->city_code],ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities(Defines::$gCounty[$devObj->city_code][$devObj->county_code],ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($devObj->room_name,ENT_COMPAT,"UTF-8");?></td>
									<td><a data-rel="popover"
										data-content="<?php echo "IP：".htmlentities($devObj->ip,ENT_COMPAT,"UTF-8");?>"
										data-placement="top" href="###" data-original-title="采集设备信息"><?php echo '('.htmlentities($devObj->smd_device_no,ENT_COMPAT,"UTF-8").')'.htmlentities($devObj->smd_device_name,ENT_COMPAT,"UTF-8");?></a></td>
									<td><a href="###" data_id='<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?>'><?php echo htmlentities($devObj->name,ENT_COMPAT,"UTF-8");?></a></td>
									<td><?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($devObj->new_data_id,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo Defines::$gDevModel[$devObj->model]; ?></td>
									<td><a href='#'><?php if($devObj->active){?><span
											class="label label-success dev-lock">已激活</span><?php }else{?><span
											class="label label-warning dev-unlock">未激活</span><?php }?></a>
									</td>
									<td>
										<div class="btn-toolbar row-action">
											<div class="btn-group">
												<button class="btn btn-info" data-original-title="编辑"
													onclick='location.href="/portal/edit_device?data_id=<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?>"'>
													<i class="icon-edit"></i>
												</button>
											</div>
										</div>
									</td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>