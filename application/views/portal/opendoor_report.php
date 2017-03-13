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
										<?php if($this->userObj->user_role == "admin"){?>
    							        <option value=''>全网</option>
    							        <?php foreach (Defines::$gCity as $cityKey=>$cityVal){?>
							            <option value='<?php echo $cityKey;?>'
											<?php  if($cityCode == $cityKey){?> selected="selected"
											<?php }?>><?php echo $cityVal;?>本地网</option>
    							        <?php }?>
    							        <?php }else if($this->userObj->user_role == "city_admin"||$this->userObj->user_role == "operator"){ ?>
    							        <option value="<?php echo $this->userObj->city_code; ?>">
    							            <?php echo Defines::$gCity[$this->userObj->city_code]; ?></option>
    							        <?php }?>
    								</select>
								</div>
								<label class="control-label" style="float: left;">区域</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择区域"
										name='selCounty' id='selCounty'>
										<?php if($this->userObj->user_role == "city_admin"||$this->userObj->user_role == "operator"){ ?>
											<option value="0">所有区域</option>
											<?php foreach (Defines::$gCounty[$this->userObj->city_code] as $key=> $val){?>
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
    							
								<label class="control-label" style="float: left;">姓名</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" name="fullName" value="<?php if($fullName) echo htmlentities($fullName, ENT_COMPAT, "UTF-8"); ?>">
								</div>
						
								<label class="control-label" style="float: left;">手机号</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" name="mobile" value="<?php if($mobile) echo htmlentities($mobile, ENT_COMPAT, "UTF-8"); ?>">
								</div>
								</div>
								<div class="control-group">
								<label class="control-label" style="float: left;">门禁卡号</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" name="card" value="<?php if($card) echo htmlentities($card, ENT_COMPAT, "UTF-8"); ?>">
								</div>
							
								<label class="control-label" style="float: left;">事件时间段</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" class=" form-control date-range-picker" name="time_range" value="<?php if($time_range)  echo htmlentities($time_range, ENT_COMPAT, "UTF-8");?>">
								</div>
						    </div>
							<div class="form-actions">
								<button class="btn btn-success" type="submit" id='btn-submit'>查询</button>
							    <button class="btn btn-success" name="export" value="exporttoexcel" type="submit" >导出报表</button>
							</div>
						</form>
					</div>
				</div>
			</div>
	
		<div class="row-fluid">
			<div class="span12">
				<div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>
							<i class="icon-list"></i> 开门记录
						</h3>
					</div>
					<div class="widget-container">					
						<div class="row-fluid">
							<div class="span6 pagination">
							总计 <?php echo $count;?> 条开门记录
							</div>
							<div class="span6">
						      <?php echo $pagination;?>
						  </div>
						</div>
		<div class="row-fluid">
			<table
				class="table table-bordered responsive table-striped">
				<thead>
					<tr>
						<th>序号</th>
						<th>分公司</th>
    					<th>区域</th>
    					<th>局站</th>
    					<th>机房</th>
						<th>门禁设备</th>
						<th>姓名</th>
						<th>手机号</th>
						<th>卡号</th>
						<th>操作</th>
						<th>操作时间</th>
					</tr>
				</thead>
				<tbody id="userList">
				<?php $index = $offset + 1; foreach ($recordList as $recordObj){?>
				 <tr >
						<td><?php echo $index++;?></td>
						<td><?php echo htmlentities(Defines::$gCity[$recordObj->city_code],ENT_COMPAT,"UTF-8"); ?></td>
						<td><?php echo htmlentities(Defines::$gCounty[$recordObj->city_code][$recordObj->county_code],ENT_COMPAT,"UTF-8"); ?></td>
						<td><?php echo htmlentities($recordObj->substation_name, ENT_COMPAT, "UTF-8"); ?></td>
						<td><?php echo htmlentities($recordObj->room_name, ENT_COMPAT, "UTF-8"); ?></td>
						<td><?php echo htmlentities($recordObj->name, ENT_COMPAT, "UTF-8"); ?></td>
						<td><?php echo htmlentities($recordObj->full_name,ENT_COMPAT,"UTF-8"); ?></td>
						<td><?php echo htmlentities($recordObj->mobile,ENT_COMPAT,"UTF-8");?></td>
						<td><?php echo htmlentities($recordObj->card_no,ENT_COMPAT,"UTF-8"); ?></td>
						<td><?php echo htmlentities($recordObj->desc,ENT_COMPAT,"UTF-8");?></td>
						<td><?php echo htmlentities($recordObj->added_datetime,ENT_COMPAT,"UTF-8"); ?></td>
					</tr>
				<?php }?>
				</tbody>
			</table>
			<div class="row-fluid">
				<div class="span6 pagination">
					总计 <?php echo $count;?> 条开门记录
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