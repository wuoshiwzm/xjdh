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
							<i class="icon-pencil"></i> 编辑/添加用户
						</h3>
					</div>
					<div class="widget-container">
						<form class="form-horizontal" method='post'>
						 <?php if(isset($errorMsg)){?>
                            <div class="alert alert-error">
								<button data-dismiss="alert" class="close" type="button">×</button>
								<i class="icon-exclamation-sign"></i><?php echo $errorMsg;?>
                    		</div>
                		<?php }else if($successMsg){?>
                		  <div class="alert alert-success">
								<button data-dismiss="alert" class="close" type="button">×</button>
								<i class="icon-ok-sign"></i><?php echo $successMsg;?>
    					   </div>
                		<?php }?>
						<?php if($userObj != null){?>
						  <input type='hidden' name='txtUserId' id='txtUserId'
								value='<?php echo htmlentities($userObj->id,ENT_COMPAT,"UTF-8");?>' />
						<?php }?>
							<div class="control-group">
								<label class="control-label" style="float: left;">所属部门/分公司</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择分公司"
										name='selCity' id='selCity'>
										<?php if($this->userObj->user_role == "admin"){?>
    							        <option value=''>全网</option>
    							        <?php foreach (Defines::$gCity as $cityKey=>$cityVal){?>
							            <option value='<?php echo $cityKey;?>'
											<?php  if(count($userObj) && $userObj->city_code == $cityKey){?> selected="selected"
											<?php }?>><?php echo $cityVal;?>本地网</option>
    							        <?php }?>
    							        <?php }else if($this->userObj->user_role == "city_admin"||$this->userObj->user_role == "operator"){ ?>
    							        <option value="<?php echo $this->userObj->city_code; ?>">
    							            <?php echo Defines::$gCity[$this->userObj->city_code]; ?></option>
    							        <?php }?>
    								</select>
								</div>
								<label class="control-label" style="float: left;">区域  </label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择区域"
										name='selCounty' id='selCounty'>
										<?php if($this->userObj->user_role == "city_admin"||$this->userObj->user_role == "operator"){ ?>
											<option value="0">所有区域</option>
											<?php foreach (Defines::$gCounty[$this->userObj->city_code] as $key=> $val){?>
										    <option value='<?php echo $key;?>'
												<?php if(isset($userObj) && $userObj->county_code == $key){?>selected="selected"<?php }?>>
												<?php echo $val;?></option>
									        <?php } ?>
								        <?php }else{ ?>
										    <option value="0">所有区域</option>
										    <?php if(isset($userObj)) foreach (Defines::$gCounty[$userObj->city_code] as $key=> $val){?>
									            <option value='<?php echo $key;?>'
											    <?php if(isset($userObj) && $userObj->county_code == $key){?> selected="selected" <?php }?>>
											    <?php echo $val;?></option>
								            <?php }?>   
								        <?php }?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">所属局站  </label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择局站"
										name='selSubstation' id='selSubstation'>
										<option value="0">所有局站</option>
									<?php if(isset($substationList)) foreach ($substationList as $substationObj){?>
									   <option value='<?php echo htmlentities($substationObj->id,ENT_COMPAT,"UTF-8")?>'
											<?php if($userObj != null && $substationObj->id == $userObj->substation_id){?>
											selected="selected" <?php }?>> <?php echo htmlentities($substationObj->name,ENT_COMPAT,"UTF-8");?></option>
									<?php }?>
									</select>
								</div>
								<label class="control-label" style="float: left;">用户名     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='txtUsername' id='txtUsername'
										value='<?php if($userObj != null) echo htmlentities($userObj->username,ENT_COMPAT,"UTF-8"); else echo $this->input->post('txtUsername');?>'
										<?php if($userObj != null){?> disabled <?php }?> />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">密码     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='password' name='txtPasswd' id='txtPasswd'
										<?php if($userObj != null){?> placeholder='如不更改，请留空' <?php }?> />
								</div>
								<label class="control-label" style="float: left;">确认密码     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='password' name='txtPasswdConfirm'
										id='txtPasswdConfirm' <?php if($userObj != null){?>
										placeholder='如不更改，请留空' <?php }?> />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">姓名     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='txtFullName' id='txtFullName'
										value='<?php if($userObj != null) echo htmlentities($userObj->full_name,ENT_COMPAT,"UTF-8"); else echo $this->input->post('txtFullName');?>' />
								</div>
								<label class="control-label" style="float: left;">性别     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select chzn-search-disabled"
										name='selGender' id='selGender'>
										<option
											<?php if($userObj->gender == 'male' || $this->input->post('selGender') == 'male'){?>
											selected='selected' <?php }?> value='male'>男</option>
										<option
											<?php if($userObj->gender == 'female' || $this->input->post('selGender') == 'female'){?>
											selected='selected' <?php }?> value='female'>女</option>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">用户角色     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select chzn-search-disabled"
										name='selUserRole' id='selUserRole'>
										<?php if($this->userObj->user_role == "admin") foreach(Defines::$gUserRole as $roleCode=>$roleValue){ 
										      if($currentUser->user_role == "city_admin" && $roleCode == "admin")
										      {
										          continue;
										      }   
										      ?>
										      <option
											<?php if(count($userObj) && $userObj->user_role == $roleCode){?>
											selected='selected' <?php }?> value='<?php echo $roleCode; ?>'><?php echo $roleValue; ?></option>
										<?php } ?>
										<?php if($this->userObj->user_role == "city_admin"){?>
										 <option value="door_user" <?php if($userRole == "door_user"){?>selected="selected"<?php }?>>
										    门禁用户
										 </option>
										 <option value="member" <?php if($userRole == "member"){?>selected="selected"<?php }?>>
										    普通用户
										 </option>
										 <option value="operator" <?php if($userRole == "operator"){?>selected="selected"<?php }?>>
										  门禁管理员
										 </option>
									    <?php }?>
									    <?php if($this->userObj->user_role == "operator"){?>
										 <option value="door_user" <?php if($userRole == "door_user"){?>selected="selected"<?php }?>>
										    门禁用户
									    <?php }?>		      									
										
										
									</select>
								</div>
								<label class="control-label" style="float: left;">手机号码     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='txtMobile' id='txtMobile'
										value='<?php if($userObj != null) echo htmlentities($userObj->mobile,ENT_COMPAT,"UTF-8"); else echo $this->input->post('txtMobile');?>' />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">邮箱     <font size=4 color=red>&nbsp;</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='email' name='txtEmail' id='txtEmail'
										value='<?php if($userObj != null) echo htmlentities($userObj->email,ENT_COMPAT,"UTF-8"); else echo $this->input->post('txtEmail');?>' />
								</div>
								<label class="control-label" style="float: left;">激活状态     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select chzn-search-disabled "
										name='selActive' id='selActive'>
										<option
											<?php if($userObj->is_active || $this->input->post('selActive') == 'active'){?>
											selected='selected' <?php }?> value='active'>激活</option>
										<option
											<?php if(!$userObj->is_active || $this->input->post('selActive') == 'deactive'){?>
											selected='selected' <?php }?> value='deactive'>锁定</option>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">门禁卡号</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='accessid'  id='accessid'
										value='<?php if($userObj != null) echo htmlentities($userObj->accessid,ENT_COMPAT,"UTF-8"); else echo $this->input->post('accessid');?>' />
								</div>
							</div>
							<div class="form-actions">
								<button class="btn btn-success" type="submit" id='btn-submit'>提交</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
