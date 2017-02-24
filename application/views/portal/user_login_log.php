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
							<i class="icon-search"></i>综合查询
						</h3>
						<a class="widget-settings" href="#search-area" id='serarch-toggle'><i
							class="icon-hand-up"></i></a>
					</div>
					<div class="widget-container" 
						id='search-area'>
						<form class="form-horizontal">
							<div class="control-group">
							   <label class="control-label" style="float: left;">姓名</label>
								<div class="controls" style="margin-left: 20px; float: left;">
                                         <input type="text" name='txtName' id='txtName'
										value="<?php echo $txtName;?>" />
								</div>
							   <label class="control-label" style="float: left;">角色</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择角色"
										name='userRole' id='userRole'>
										<?php if($this->userObj->user_role == "city_admin"||$this->userObj->user_role == "operator"){?>
										 <option value='' >所有角色</option>
										 <option value="door_user" <?php if($userRole == "door_user"){?>selected="selected"<?php }?>>门禁用户</option>
										 <option value="member" <?php if($userRole == "member"){?>selected="selected"<?php }?>> 普通用户</option>
										 <option value="operator" <?php if($userRole == "operator"){?>selected="selected"<?php }?>>门禁管理员</option><?php }?>
									     <?php if($this->userObj->user_role == "city_admin"){?>
									     <option value="city_admin" <?php if($userRole == "city_admin"){?>selected="selected"<?php }?>> 分公司管理员 </option>
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
							   <label class="control-label" style="float: left;">终端</label>
								<div class="controls" style="margin-left: 20px; float: left;">
                                      <select class="chzn-select" data-placeholder="选择终端"
										name='userAgent' id='userAgent'>
										 <option value='' >所有终端</option>
										 <option value="pc" <?php if($userAgent == "pc"){?>selected="selected"<?php }?>>
										      PC
										 </option>
										 	 <option value="mobile" <?php if($userAgent == "mobile"){?>selected="selected"<?php }?>>
										 	 移动终端
										 </option>
										 	 
									</select>
								</div>
								
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">所属部门/分公司</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择分公司"
										name='selCity' id='selCity'>
										<?php if($userObj->user_role == "admin"){?>
    							        <option value=''>全网</option>
    							        <?php foreach (Defines::$gCity as $cityKey=>$cityVal){?>
							            <option value='<?php echo $cityKey;?>'
											<?php  if($selCity == $cityKey){?> selected="selected"
											<?php }?>><?php echo $cityVal;?>本地网</option>
    							        <?php }?>
    							        <?php }else if($userObj->user_role == "city_admin"||$userObj->user_role == "operator"){ ?>
    							        <option value="<?php echo $userObj->city_code; ?>">
    							            <?php echo Defines::$gCity[$userObj->city_code]; ?></option>
    							        <?php }?>
    								</select>
								</div>
								<label class="control-label" style="float: left;">所属区域</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择区域"
										name='selCounty' id='selCounty'>
									<?php if($userObj->user_role == "city_admin"||$userObj->user_role == "operator"){ ?>
											<option value="0">所有区域</option>
											<?php foreach (Defines::$gCounty[$userObj->city_code] as $key=> $val){?>
										    <option value='<?php echo $key;?>'
												<?php if($selCounty == $key){?>selected="selected"<?php }?>>
												<?php echo $val;?></option>
									        <?php } ?>
								        <?php }else{ ?>
										    <option value="0">所有区域</option>
										    <?php if(count($selCity)) foreach (Defines::$gCounty[$selCity] as $key=> $val){?>
									            <option value='<?php echo $key;?>'
											    <?php if($selCounty == $key){?> selected="selected" <?php }?>>
											    <?php echo $val;?></option>
								            <?php }?>   
								        <?php }?>
									</select>
								</div>
							
							   <label class="control-label" style="float: left;">所属局站</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择局站"
										name='selSubstation' id='selSubstation'>
									<?php if(isset($selSubstation)) {?>
									<?php foreach ($substationList as $substationObj){?>
									
									 <option <?php if($substationObj->id == $selSubstation){?> selected="selected" <?php }?>><?php echo htmlentities($substationObj->name,ENT_COMPAT,"UTF-8");?></option>	
									
									<?php }?>	
									<?php }?>						
									</select>
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
								<button class="btn btn-success" type="submit" id='btn-submit'>查询</button>
								<button class="btn btn-success" id='btn-clear'>清空查询条件</button>
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
							<i class="icon-list"></i> 登录日志
						</h3>
					</div>
					<div class="widget-container">
						<table class="table table-bordered responsive table-striped">
							<thead>
								<tr>
									<th>序号</th>
									<th>用户名</th>
									<th>姓名</th>
									<th>用户角色</th>
									<th>终端</th>
									<th>登录IP</th>
									<th>登录时间</th>

								</tr>
							</thead>
							<tbody>
							
							<?php
							if(is_array($logList) && count($logList) > 0){ $offset+=1; 
							     foreach ($logList as $logObj){
							?>
							<tr>
							 <td><?php echo $offset++; ?></td>
							 <td><?php echo htmlentities($logObj->username, ENT_COMPAT, "UTF-8"); ?></td>
							 <td><?php echo htmlentities($logObj->full_name, ENT_COMPAT, "UTF-8"); ?></td>
							 <td><?php
                            if ($logObj->user_role == 'admin')
                                echo "系统管理员";
                            else if ($logObj->user_role == 'noc')
                                echo "NOC";
                            else if ($logObj->user_role == 'city_admin')
                                echo "分公司管理员";
                            else if ($logObj->user_role == 'member')
                                echo "普通用户";
                            else if ($logObj->user_role == 'operator')
                                echo "门禁管理员";
							else if ($logObj->user_role == 'door_user')
                                echo "门禁用户";
                            ?></td>
							 <td><?php echo $logObj->agent == 'pc'?'PC':'MOBILE'; ?></td>
							 <td><?php echo htmlentities($logObj->ip, ENT_COMPAT, "UTF-8"); ?></td>
							 <td><?php echo htmlentities($logObj->time,ENT_COMPAT, "UTF-8"); ?></td>
							</tr>
							<?php
							 }}else{
							 ?>
							<tr>
							 <td style="text-align: center;" colspan="7">未发现相关书据！</td>
							</tr>
							<?php }?>
							</tbody>
						</table>
						<div class="row-fluid">
							<div class="span6">
						总计 <?php echo $count;?> 条记录
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
