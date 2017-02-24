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
						<form class="form-horizontal" method='post'
							enctype="multipart/form-data">
						 <?php if(isset($errorMsg)){?>
                            <div class="alert alert-error">
								<button data-dismiss="alert" class="close" type="button">×</button>
								<i class="icon-exclamation-sign"></i><?php echo $errorMsg;?>
                    		</div>
                		<?php }else if($successMsg){?>
                		  <div class="alert alert-success">
								<button data-dismiss="alert" class="close" type="button">×</button>
								<i class="icon-ok-sign"></i><?php echo $successMsg;?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']?>"><font color='write'>继续添加</font></a>
    					   </div>
                		<?php }?>
							<div class="control-group">
								<label class="control-label" style="float: left;">所属部门/分公司     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择分公司"
										name='selCity' id='selCity'>
										<?php if($userObj->user_role == "admin"){?>
    							        <option value=''>全网</option>
    							        <?php foreach (Defines::$gCity as $cityKey=>$cityVal){?>
							            <option value='<?php echo $cityKey;?>'
											<?php  if(isset($devObj) && $devObj->city_code == $cityKey){?> selected="selected"
											<?php }?>><?php echo $cityVal;?>本地网</option>
    							        <?php }?>
    							        <?php }else if($userObj->user_role == "city_admin"){ ?>
    							        <option value="<?php echo $userObj->city_code; ?>">
    							            <?php echo Defines::$gCity[$userObj->city_code]; ?></option>
    							        <?php }?>
    								</select>
								</div>
								<label class="control-label" style="float: left;">区域  <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择区域"
										name='selCounty' id='selCounty'>
									<?php if($this->userObj->user_role == "city_admin"){ ?>
											<option value="0">所有区域</option>
											<?php foreach (Defines::$gCounty[$this->userObj->city_code] as $key=> $val){?>
										    <option value='<?php echo $key;?>'
												<?php if(isset($devObj) && $devObj->county_code == $key){?>selected="selected"<?php }?>>
												<?php echo $val;?></option>
									        <?php } ?>
								        <?php }else{ ?>
										    <option value="0">所有区域</option>
										    <?php if(isset($devObj)) foreach (Defines::$gCounty[$devObj->city_code] as $key=> $val){?>
									            <option value='<?php echo $key;?>'
											    <?php if(isset($devObj) && $devObj->county_code == $key){?> selected="selected" <?php }?>>
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
											<?php if((count($devObj) && $substationObj->id == $devObj->substation_id) || $substation == $substationObj->id){?>
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
											<?php if(count($devObj) && $roomObj->id == $devObj->room_id){?>
											selected="selected" <?php }?>> <?php echo htmlentities($roomObj->name,ENT_COMPAT,"UTF-8");?></option>
									<?php }?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">所属采集板     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择采集板"
										name='selSmdDev' id='selSmdDev'>
									   <?php if(isset($smdDevList)) foreach ($smdDevList as $smdDevObj){?>
									   <option value='<?php echo htmlentities($smdDevObj->device_no,ENT_COMPAT,"UTF-8")?>'
											<?php if(count($devObj) && $devObj->smd_device_no == $smdDevObj->device_no){?>
											selected="selected" <?php }?>><?php echo htmlentities($smdDevObj->name,ENT_COMPAT,"UTF-8");?></option>
									   <?php }?>
									</select>
								</div>
								<label class="control-label" style="float: left;">设备名     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='txtName' id='txtName'
										value='<?php if(count($devObj)){ echo htmlentities($devObj->name,ENT_COMPAT,"UTF-8");}?>' />
								</div>
							</div>
														
							<div class="control-group">
								<label class="control-label"  style="float: left;">设备类型   <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择设备类型"
										name='selModel' id='selModel' >
										<option value=''>选择设备类型</option>
									   <?php foreach (Defines::$gDevModel as $key=>$val){?>
									   <option
											<?php if(count($devObj) && $devObj->model == $key) {?>
											selected="selected" <?php }?> value='<?php echo $key;?>'><?php echo $val;?></option>
									   <?php }?>
									</select>
								</div>
								<label class="control-label"  id='group' style="float: left; display: none;">所属分组<span id='must' style="display: none;"><font size=4 color=red>&nbsp;*</font></span></label>
									<div class="controls" style="margin-left: 20px; float: left;">
										<input type="text"  name='devgroup' id='devgroup' style="display: none;" <?php if(count($devObj)){?>
										value="<?php echo htmlentities($devObj->dev_group,ENT_COMPAT,"UTF-8");?>" <?php }?>/>
									</div>
									<span class="help-block error" id='text1'   style="display: none;">
															&nbsp;&nbsp;注：请输入电源分组名，以区分交、直、整流屏电源。
									</span>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">厂家 <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择厂家"
										name='manufacturers' id='manufacturers'>
										<option value=''>--默认为空--</option>
    							        <?php foreach (Defines::$gBrand as $brandKey=>$brandVal){?>
							            <option value='<?php echo $brandKey;?>'<?php if(isset($devObj) && $devObj->manufacturers == $brandKey){?>
											selected="selected" <?php }?>><?php echo $brandKey;?></option>
    							        <?php }?>
    								</select>
								</div>
							<label class="control-label" style="float: left;">品牌<font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择型号"
										name='version' id='version'>
										<option value=''>--默认为空--</option>
    							        <?php if(isset($devObj)) foreach (Defines::$gBrand[$devObj->manufacturers] as $key=>$val){?>
							            <option value='<?php echo $val;?>'
							            <?php if(isset($devObj) && $devObj->version == $key){?> selected="selected" <?php }?>>
							            <?php echo $val;?></option>
    							        <?php }?>
    								</select>
								</div>
							</div>		
							<div class="control-group">
								<label class="control-label" style="float: left;">数据ID  <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='txtDataId' id='txtDataId' data_id='<?php echo $data_id?>' readonly="readonly"
										<?php if(count($devObj)){?>
										value="<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?>"
										<?php }?> />
								</div>
								<label id='labelport' class="control-label" style="float: left;">端口号     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;" id='port'>
									<select class="chzn-select chzn-search-disabled" name='selPort'
										id='selPort'>
									<?php for($i = 0; $i < 13 ; $i++){?>
									   <option <?php if(count($devObj) && $devObj->port == $i) {?>
											selected="selected" <?php }?> value='<?php echo $i;?>'><?php echo $i;?></option>
								   <?php }?>
									</select>
								</div>						
							</div>
							<div class="control-group">	
								<label class="control-label" style="float: left;">激活状态     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select chzn-search-disabled "
										name='selActive' id='selActive'>
										<option
											<?php if((count($devObj) && $devObj->active) || $this->input->post('selActive') == 'active'){?>
											selected='selected' <?php }?> value='active'>已激活</option>
										<option
											<?php if((count($devObj) && !$devObj->active) || $this->input->post('selActive') == 'deactive'){?>
											selected='selected' <?php }?> value='deactive'>未激活</option>
									</select>
								</div>
								<label class="control-label" style="float: left;">逻辑参数     <font size=4 color=red>&nbsp;&nbsp;</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='txtExtraParam' id='txtExtraParam'
										value='<?php if (count($devObj)) echo htmlentities($devObj->extra_para,ENT_COMPAT,"UTF-8");?>' />
								</div>		
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">设备品牌     <font size=4 color=red>&nbsp;&nbsp;</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='devicebrand' id='txtdevicebrand'
										value='<?php if (count($devObj)) echo htmlentities($devObj->devicebrand,ENT_COMPAT,"UTF-8");?>' />
								</div>
								<label class="control-label" style="float: left;">生产日期     <font size=4 color=red>&nbsp;&nbsp;</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" id="txtProductionDate"
										name="txtProductionDate" class="datepicker"
										value='<?php if (count($devObj)) echo htmlentities($devObj->production_date,ENT_COMPAT,"UTF-8");?>'>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">设备型号    <font size=4 color=red>&nbsp;&nbsp;</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='txtDeviceModel' id='txtDeviceModel'
										value='<?php if (count($devObj)) echo htmlentities($devObj->device_model,ENT_COMPAT,"UTF-8");?>' />
								</div>
								<label class="control-label" style="float: left;">额定功率     <font size=4 color=red>&nbsp;&nbsp;</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='txtRatedPower' id='txtRatedPower'
										value='<?php if (count($devObj)) echo htmlentities($devObj->rated_power,ENT_COMPAT,"UTF-8");?>' />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">配电设备     <font size=4 color=red>&nbsp;&nbsp;</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='file' name='fDistributionEquipment'
										id='fDistributionEquipment'>
								    <?php if (count($devObj) && strlen($devObj->distribution_equipment) > 0) { $dEqObj = json_decode($devObj->distribution_equipment); ?>
								    <a
										href='<?php echo site_url('/attachments/'.$dEqObj->file_name)?>'
										target="_blank"><?php echo htmlentities($dEqObj->orig_name,ENT_COMPAT,"UTF-8");?></a>
								    <?php }?>
								    <span class="help-block error">注：请上传附件，可为Word，Excel，PPT，PDF<br />压缩文件（zip,rar,7z,tar,bz2,gz），上传新附件将覆盖老的文件。
									</span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">备注</label>
								<div class="controls">
									<div class='span6'>
										<textarea class="span5" rows='6' name='txtMemo' id='txtMemo'><?php if (count($devObj)) echo htmlentities($devObj->memo, ENT_COMPAT, "UTF-8");?></textarea>
									</div>
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
<script type="text/javascript">
function sortRule(a,b) {
	var x = a._text;
	var y = b._text;
	return x.localeCompare(y);
}
function op(){
	var _value;
	var _text;
}
function sortOption(){
	var obj = $('#selBrand')[0];
	var tmp = new Array();
	for(var i=0;i<obj.options.length;i++){
	var ops = new op();
	ops._value = obj.options[i].value;
	ops._text = obj.options[i].text;
	tmp.push(ops);
	}
	tmp.sort(sortRule);
	for(var j=0;j<tmp.length;j++){
		obj.options[j].value = tmp[j]._value;
		obj.options[j].text = tmp[j]._text;
	}
}
sortOption();
</script>