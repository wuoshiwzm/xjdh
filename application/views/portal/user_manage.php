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
								<label class="control-label" style="float: left;">所属分公司</label>
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
								<label class="control-label" style="float: left;">角色</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择角色"
										name='userRole' id='userRole'>
										
										<?php if($this->userObj->user_role == "city_admin"||$userObj->user_role == "operator"){?>
										 <?php if($this->userObj->user_role != "operator"){?>
										 <option value='' >所有角色</option>
										 <?php }?>
										 <option value="door_user" <?php if($userRole == "door_user"){?>selected="selected"<?php }?>>门禁用户</option>
										 <?php if($this->userObj->user_role == "city_admin"){?>
										 <option value="member" <?php if($userRole == "member"){?>selected="selected"<?php }?>> 普通用户</option>
										 <option value="operator" <?php if($userRole == "operator"){?>selected="selected"<?php }?>>门禁管理员</option><?php }?>
									    <?php }?>
									    <?php if($this->userObj->user_role == "admin"){?>
										 <option value='' >所有角色</option>
										 <option value="admin" <?php if($userRole == "admin"){?>selected="selected"<?php }?>> 系统管理员 </option>
										 <option value="member" <?php if($userRole == "member"){?>selected="selected"<?php }?>> 普通用户 </option>
										 <option value="city_admin" <?php if($userRole == "city_admin"){?>selected="selected"<?php }?>> 分公司管理员 </option>
										 <option value="noc" <?php if($userRole == "noc"){?>selected="selected"<?php }?>> 网络监控用户 </option>
										 <option value="operator" <?php if($userRole == "operator"){?>selected="selected"<?php }?>> 门禁管理员  </option>
										 <option value="door_user" <?php if($userRole == "door_user"){?>selected="selected"<?php }?>> 门禁用户 </option>
										 <?php }?>	
									</select>
								</div>
								<label class="control-label" style="float: left;">性别</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择性别"
										name='gender' id='gender'>
										<option value='' >所有</option>
										<option value="male" <?php if($gender == "male"){?>selected="selected"<?php }?>> 男 </option>
										<option value="female" <?php if($gender == "female"){?>selected="selected"<?php }?>> 女 </option> 	
									</select>
								</div>
								</div>
								
								<div class="control-group">
								<label class="control-label" style="float: left;">名字</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" name="fullName" value="<?php if($fullName) echo $fullName?>">
								</div>
								
								<label class="control-label" style="float: left;">手机号</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" name="mobile" value="<?php if($mobile) echo $mobile?>">
								</div>
								</div>
								<div class="control-group">
								<label class="control-label" style="float: left;">门禁卡号</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" name="accessId" value="<?php  echo htmlentities($AccessId, ENT_COMPAT, "UTF-8"); ?>">
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
			<?php if(isset($msg)){?>
			<div class="alert alert-success">
			<button data-dismiss="alert" class="close">×</button>
			<strong>导入成功!<?php echo $msg;?><a href='/portal/usermanage'><font
					size=2 color=red>刷新</font></a></strong>

		</div>
		<?php }?>
		<?php if(isset($errMsg)){?>
			<div class="alert alert-error">
			<button data-dismiss="alert" class="close">×</button>
			<strong>导入失败!<?php echo $errMsg;?></strong>

		</div>
		<?php }?>
		<div class="row-fluid">
			<div class="span12">
				<div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>
							<i class="icon-list"></i> 用户管理
						</h3>
					</div>
					<div class="widget-container">
						<div class="row-fluid">
							<div class="span6">
								<a type="button" class="btn btn-info"
									href='<?php echo site_url('portal/edituser');?>'><i
									class="icon-plus"></i> 添加用户</a>
							</div>
							<?php if(!in_array($_SESSION['XJTELEDH_USERROLE'],array('operator','city_admin'))){?>
							<div class="span4 btn btn-primary">
								<form id='formimport' class="form-horizontal" method='post'
									enctype="multipart/form-data">
									<div style="float: letf;">
										<input type="file" name="userfile" id='userfile'
											style="position: absolute; opacity: 0.6; left: 650px; top: 70px;" />
									</div>
									<div style="float: right;">
										<button type="submit" id='import' class="btn btn-info"
											name="import" value="importtodb">&nbsp;&nbsp;&nbsp;&nbsp;导入用户信息&nbsp;&nbsp;&nbsp;&nbsp;</button>
									</div>
								</form>
							</div>	
							<div class="span2">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<a href="/public/xls/user.xls" class="btn btn-primary" >&nbsp;&nbsp;&nbsp;&nbsp;下载用户信息模板&nbsp;&nbsp;&nbsp;&nbsp;</a>
							</div>					
						<?php }?>
						</div>
						<br>
						<table
							class="table table-bordered responsive table-striped table-sortable">
							<thead>
								<tr>
									<th>序号</th>
									<th>账户</th>
									<th>名字</th>
									<th>性别</th>
									<th>手机号</th>
									<th>邮箱</th>
									<th>用户角色</th>
									<th>门禁卡号</th>
									<th>所属分公司</th>
									<th>所属区域</th>
									<th>激活状态</th>
									<th>添加时间</th>									
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
							<?php $index = $offset + 1; foreach ($userList as $userObj){?>
							 <tr user_id='<?php echo htmlentities($userObj->id,ENT_COMPAT,"UTF-8");?>'>
									<td><?php echo $index++;?></td>
									<td><?php echo htmlentities($userObj->username,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($userObj->full_name,ENT_COMPAT,"UTF-8");?></td>
									<td><?php if($userObj->gender == 'male') echo '男'; else echo '女';?></td>
									<td><?php echo htmlentities($userObj->mobile,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($userObj->email,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo Defines::$gUserRole[$userObj->user_role]; ?></td>
                    				<td><?php echo htmlentities($userObj->accessid,ENT_COMPAT,"UTF-8");?></td>
									<td><?php if(!empty($userObj->city_code)){ echo htmlentities($gCity[$userObj->city_code],ENT_COMPAT,"UTF-8"); }?></td>
									<td><?php if(!empty($userObj->county_code)){ echo htmlentities($gCounty[$userObj->city_code][$userObj->county_code],ENT_COMPAT,"UTF-8"); } ?></td>									
									<td><a href='#'><?php if($userObj->is_active){?><span
											class="label label-success">已激活</span><?php }else{?><span
											class="label label-warning user-active">未激活</span><?php }?></a></td>
									<td><?php echo htmlentities($userObj->added_datetime,ENT_COMPAT,"UTF-8");?></td>

									<?php if($_SESSION['XJTELEDH_USERROLE'] == 'admin'){?>	
									<td>
									<a class="btn btn-info"
										href="<?php echo site_url("portal/edituser/".$userObj->id);?>"
										type="button"><i class="icon-pencil"></i> 编辑</a> <a
										class="btn btn-danger delete-user" href="#" type="button"><i
										class="icon-trash"></i> 删除</a>
									</td>
							       <?php }?>
							       <?php if($_SESSION['XJTELEDH_USERROLE'] == 'city_admin'){?>	
									<td><?php if($userObj->user_role == 'member' || $userObj->user_role == 'operator'|| $userObj->user_role == 'door_user'){?>
									<a class="btn btn-info"
										href="<?php echo site_url("portal/edituser/".$userObj->id);?>"
										type="button"><i class="icon-pencil"></i> 编辑</a> <a
										class="btn btn-danger delete-user" href="#" type="button"><i
										class="icon-trash"></i> 删除</a>
										 <?php }?>
									</td>
							       <?php }?>
							       <?php if($_SESSION['XJTELEDH_USERROLE'] == 'operator'){?>	
									<td><?php if($userObj->user_role == 'member' || $userObj->user_role == 'door_user'){?>
									<a class="btn btn-info"
										href="<?php echo site_url("portal/edituser/".$userObj->id);?>"
										type="button"><i class="icon-pencil"></i> 编辑</a> <a
										class="btn btn-danger delete-user" href="#" type="button"><i
										class="icon-trash"></i> 删除</a>
										 <?php }?>
									</td>
							       <?php }?>
							 <?php }?>
								</tr>
							</tbody>
						</table>
						<div class="row-fluid">
							<div class="span6">
							总计 <?php echo $count;?> 个用户信息
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
