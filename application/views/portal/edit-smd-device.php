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
							<i class="icon-pencil"></i> <?php echo $pageTitle;?>
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
								<i class="icon-ok-sign"></i><?php echo $successMsg;?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']?>"><font color='write'>继续添加/更新</font></a>
    					   </div>
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
											<?php  if(isset($smdDevObj) && $smdDevObj->city_code == $cityKey){?> selected="selected"
											<?php }?>><?php echo $cityVal;?>本地网</option>
    							        <?php }?>
    							        <?php }else if($this->userObj->user_role == "city_admin"){ ?>
    							        <option value="<?php echo $this->userObj->city_code; ?>">
    							            <?php echo Defines::$gCity[$this->userObj->city_code]; ?></option>
    							        <?php }?>
    								</select>
								</div>
								<label class="control-label" style="float: left;">区域</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择区域"
										name='selCounty' id='selCounty'>
										<?php if($this->userObj->user_role == "city_admin"){ ?>
											<option value="0">所有区域</option>
											<?php foreach (Defines::$gCounty[$this->userObj->city_code] as $key=> $val){?>
										    <option value='<?php echo $key;?>'
												<?php if(isset($smdDevObj) && $smdDevObj->county_code == $key){?>selected="selected"<?php }?>>
												<?php echo $val;?></option>
									        <?php } ?>
								        <?php }else{ ?>
										    <option value="0">所有区域</option>
										    <?php if(isset($smdDevObj)) foreach (Defines::$gCounty[$smdDevObj->city_code] as $key=> $val){?>
									            <option value='<?php echo $key;?>'
											    <?php if(isset($smdDevObj) && $smdDevObj->county_code == $key){?> selected="selected" <?php }?>>
											    <?php echo $val;?></option>
								            <?php }?>   
								        <?php }?>
									</select>
								</div>																
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">所属局站     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择局站"
										name='selSubstation' id='selSubstation'>
									<?php if(isset($substationList) || count($substation)) foreach ($substationList as $substationObj){?>
									   <option value='<?php echo htmlentities($substationObj->id,ENT_COMPAT,"UTF-8")?>'
											<?php if((isset($smdDevObj) && $substationObj->id == $smdDevObj->substation_id) || $substation == $substationObj->id){?>
											selected="selected" <?php }?>> <?php echo htmlentities($substationObj->name,ENT_COMPAT,"UTF-8");?></option>
									<?php }?>
									</select>
								</div>
								<label class="control-label" style="float: left;">所属机房     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择机房"
										name='selRoom' id='selRoom'>
									<?php if(isset($roomList)) foreach ($roomList as $roomObj){?>
									   <option value='<?php echo htmlentities($roomObj->id,ENT_COMPAT,"UTF-8")?>'
											<?php if(count($smdDevObj) && $roomObj->id == $smdDevObj->room_id){?>
											selected="selected" <?php }?>> <?php echo htmlentities($roomObj->name,ENT_COMPAT,"UTF-8");?></option>
									<?php }?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">设备编号     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='txtDevNo' id='txtDevNo' disabled="true"
										value='<?php if(!count($smdDevObj)){ echo $smdNo;}?><?php if(count($smdDevObj)){ echo htmlentities($smdDevObj->device_no,ENT_COMPAT,"UTF-8");}?>'
										<?php if(count($smdDevObj)){?> readonly class='ignore'
										<?php }?> />									
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">设备名     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='txtName' id='txtName'
										value='<?php if(count($smdDevObj)){ echo htmlentities($smdDevObj->name,ENT_COMPAT,"UTF-8");}?>' />
								</div>
								<label class="control-label" style="float: left;">IP地址     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='txtIP' id='txtIP'
										value="<?php if(count($smdDevObj))echo htmlentities($smdDevObj->ip,ENT_COMPAT,"UTF-8");?>" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">激活状态     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select chzn-search-disabled "
										name='selActive' id='selActive'>
										<option
											<?php if((count($smdDevObj) && $smdDevObj->active) || $this->input->post('selActive') == 'active'){?>
											selected='selected' <?php }?> value='active'>已激活</option>
										<option
											<?php if((count($smdDevObj) && !$smdDevObj->active) || $this->input->post('selActive') == 'deactive'){?>
											selected='selected' <?php }?> value='deactive'>未激活</option>
									</select>
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
