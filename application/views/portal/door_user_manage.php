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
								<label class="control-label" style="float: left;">用户名</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" name="username" value="<?php if($username) echo $username?>">
								</div>
								<label class="control-label" style="float: left;">姓名</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" name="fullName" value="<?php if($fullName) echo $fullName?>">
								</div>
                                </div>
								<div class="control-group">
								<label class="control-label" style="float: left;">手机号</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" name="mobile" value="<?php if($mobile) echo $mobile?>">
								</div>
								<label class="control-label" style="float: left;">门禁卡号</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" name="accessId" value="<?php  if(accessId) echo $accessId?>">
								</div>
								</div>
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
    							        <option value="<?php echo $userObj->city_code; ?>">
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
							<div class="form-actions">
								<button class="btn btn-success" type="submit" id='btn-submit'>提交</button>
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
					<div class="widget-container">
						<table
							class="table table-bordered responsive table-striped table-sortable">
							<thead>
								<tr>
									<th>序号</th>
									<th>用户名</th>
									<th>姓名</th>
									<th>手机号</th>
									<th>门禁卡号</th>
									<th>所属分公司</th>
									<th>所属区域</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
							<?php $index = $offset + 1; foreach ($userList as $userObj){?>
							 <tr user_id='<?php echo htmlentities($userObj->id,ENT_COMPAT,"UTF-8");?>'>
									<td><?php echo $index++;?></td>
									<td><?php echo htmlentities($userObj->username,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($userObj->full_name,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($userObj->mobile,ENT_COMPAT,"UTF-8");?></td>
                    				<td><?php echo htmlentities($userObj->accessid,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities(Defines::$gCity[$userObj->city_code],ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities(Defines::$gCounty[$userObj->city_code][$userObj->county_code],ENT_COMPAT,"UTF-8");?></td>
									<td>
									   <a href="/portal/door_user_list/<?php echo htmlentities($userObj->id,ENT_COMPAT,"UTF-8"); ?>">
											门禁管理
										</a>
										<a href="/portal/door_user_operate/<?php echo htmlentities($userObj->id,ENT_COMPAT,"UTF-8"); ?>">
											授权记录
										</a>
										<a href="/portal/door_user_record/<?php echo htmlentities($userObj->id,ENT_COMPAT,"UTF-8"); ?>">
											开门记录
										</a></td>
								</tr>
							<?php }?>
							</tbody>
						</table>
						<div class="row-fluid">
							<div class="span6">
						总计 <?php echo $count;?> 个用户记录
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