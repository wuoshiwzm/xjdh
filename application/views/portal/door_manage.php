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
			<div class="span12">
				<div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>
							<i class="icon-search"></i> 综合查询
						</h3>
						<a class="widget-settings" href="#search-area" id='serarch-toggle'><i
							class="icon-hand-up"></i></a>
					</div>
					<div class="widget-container" 
						id='search-area'>
						<form class="form-horizontal">
							<div class="control-group">
								<label class="control-label" style="float: left;">所属部门/分公司</label>
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
    							        <?php }else if($userObj->user_role == "city_admin"||$userObj->user_role == "operator"){ ?>
    							        <option value="<?php echo $userObj->city_code; ?>">
    							            <?php echo Defines::$gCity[$userObj->city_code]; ?></option>
    							        <?php }?>
    								</select>
								</div>
								
								<label class="control-label" style="float: left;">区域  </label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择区域"
										name='selCounty' id='selCounty'>
										<?php if($userObj->user_role == "city_admin"||$userObj->user_role == "operator"){ ?>
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
										<?php if(isset($substationId)) {?>
									       <?php foreach ($substationList as $substationObj){?>
									       <option <?php if($substationObj->id == $substationId){?> selected="selected" <?php }?> 
									       value="<?php echo htmlentities($substationObj->id,ENT_COMPAT,"UTF-8");?>">
									              <?php if($substationObj->county_code == $countyCode) echo htmlentities($substationObj->name,ENT_COMPAT,"UTF-8");?></option>	
									        <?php }?>	
									    <?php }?>	
									</select>
								</div>
								
								<label class="control-label" style="float: left;">所属机房</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择机房"
										name='selRoom' id='selRoom'>
										<option value=''>所有机房</option>
										<?php if(isset($substationId)) {?>
									    <?php foreach ($roomList as $roomListObj){?>
									    <option <?php if($roomListObj->id == $roomId){?> selected="selected" <?php }?> 
									      value="<?php echo htmlentities($roomListObj->id,ENT_COMPAT,"UTF-8");?>">
									           <?php if($roomListObj->substation_id == $substationId) echo htmlentities($roomListObj->name,ENT_COMPAT,"UTF-8");?></option>	
									    <?php }?>	
									    <?php }?>
									</select>
								</div>
							</div>										
							<div class="control-group">
								<label class="control-label" style="float: left;">激活状态</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select chzn-search-disabled "
										name='selActive' id='selActive'>
										<option value='all'>所有状态</option>
										<option
											<?php if($active == 'active'){?>
											selected='selected' <?php }?> value='active'>已激活</option>
										<option
											<?php if($active == 'deactive'){?>
											selected='selected' <?php }?> value='deactive'>未激活</option>
									</select>
								</div>
							<div  class="control-group">									
							<label class="control-label" style="float: left;">关键词</label>
									<div class="controls" style="margin-left: 20px; float: left;">
										<input type='text' name='keyWord' id='keyWord'
											value='<?php if(isset($keyWord)) echo $keyWord ?>' /> 
									</br><span style="color: red;">注：可为区域、局站、机房、采集单元、局站名称首字母
									</span>
									</div>
							</div>
							<div class="form-actions">
								<button class="btn btn-success" type="submit" id='btn-submit'>搜索</button>
								<button class="btn btn-success" name="export" value="exporttoexcel" type="submit" >导出报表</button>
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
						<h3>
							<i class="icon-list"></i> 门禁列表
						</h3>
					</div>
					<div class="widget-container">					
						<div class="row-fluid">
							<div class="span6 pagination">
							总计 <?php echo $count;?> 个门禁设备
							</div>
							<div class="span6">
						      <?php echo $pagination;?>
						  </div>
						</div>
						<br>
						<table id="dataTable"
							class="table table-bordered responsive table-striped">
							<thead>
								<tr>
									<th>序号</th>
									<th>分公司</th>
									<th>区域</th>
									<th>局站</th>
									<th>机房</th>
									<th>采集单元</th>
									<th>设备名</th>
									<th>数据ID</th>
									<th>是否激活</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
							<?php $i = $offset + 1; foreach ($devList as $devObj){?>
							<tr device_id='<?php echo htmlentities($devObj->id,ENT_COMPAT,"UTF-8"); ?>' dataId='<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?>'>
									<td><?php echo $i++;?></td>
									<td><?php echo htmlentities(Defines::$gCity[$devObj->city_code],ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities(Defines::$gCounty[$devObj->city_code][$devObj->county_code],ENT_COMPAT,"UTF-8");?></td>	
									<td><?php echo htmlentities($devObj->suname,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($devObj->room_name,ENT_COMPAT,"UTF-8");?></td>
									<td><a data-rel="popover"
										data-content="<?php echo "IP：". htmlentities($devObj->ip,ENT_COMPAT,"UTF-8");?>"
										data-placement="top" href="realtimedata/<?php echo htmlentities($devObj->roomId,ENT_COMPAT,"UTF-8");?>/smd_device" data-original-title="采集设备信息"><?php echo '(' . htmlentities($devObj->smd_device_no,ENT_COMPAT,"UTF-8"). ')' . htmlentities($devObj->smd_device_name,ENT_COMPAT,"UTF-8");?></a></td>
									<td><a href="realtimedata/<?php echo htmlentities($devObj->roomId,ENT_COMPAT,"UTF-8");?>/door" data_id='<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?>'><?php echo htmlentities($devObj->name,ENT_COMPAT,"UTF-8");?></a></td>
									<td><?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?></td>
									<td><a href='#'><?php if($devObj->active){?><span
											class="label label-success dev-lock">已激活</span><?php }else{?><span
											class="label label-warning dev-unlock">未激活</span><?php }?></a>
									</td>
									<td>										
										<a href="/portal/door_user/<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8"); ?>">
											用户权限管理
										</a>
										<a href="/portal/door_operate/<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8"); ?>">
											授权记录
										</a>
										<a href="/portal/door_record/<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8"); ?>">
											开门记录
										</a>
									</td>
								</tr>
							<?php }?>
							</tbody>
						</table>
						<div class="row-fluid">
							<div class="span6">
								总计 <?php echo $count;?> 个门禁设备
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
</div>