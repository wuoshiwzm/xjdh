<script type="text/javascript">
var substationList=<?php echo json_encode($substationList);?>;
</script>
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
							<i class="icon-pencil"></i> 编辑/添加机房信息
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
							<div class="control-group">
								<label class="control-label" style="float: left;">所属分公司     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择分公司"
										name='citycode' id='selCity'>
										<?php if($userObj->user_role == "admin"){?>
    							        <option value=''>全网</option>
    							        <?php foreach (Defines::$gCity as $cityKey=>$cityVal){?>
							            <option value='<?php echo $cityKey;?>'
											<?php  if(isset($roomObj) && $roomObj->city_code == $cityKey){?> selected="selected"
											<?php }?>><?php echo $cityVal;?>本地网</option>
    							        <?php }?>
    							        <?php }else if($userObj->user_role == "city_admin"){ ?>
    							        <option value="<?php echo $userObj->city_code; ?>">
    							            <?php echo Defines::$gCity[$userObj->city_code]; ?></option>
    							        <?php }?>
    								</select>
								</div>
								<label class="control-label" style="float: left;">区域<font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择区域"
										name='selCounty' id='selCounty'>
										<?php if($this->userObj->user_role == "city_admin"){ ?>
											<option value="0">所有区域</option>
											<?php foreach (Defines::$gCounty[$this->userObj->city_code] as $key=> $val){?>
										    <option value='<?php echo $key;?>'
												<?php if(isset($roomObj) && $roomObj->county_code == $key){?>selected="selected"<?php }?>>
												<?php echo $val;?></option>
									        <?php } ?>
								        <?php }else{ ?>
										    <option value="0">所有区域</option>
										    <?php if(isset($roomObj)) foreach (Defines::$gCounty[$roomObj->city_code] as $key=> $val){?>
									            <option value='<?php echo $key;?>'
											    <?php if(isset($roomObj) && $roomObj->county_code == $key){?> selected="selected" <?php }?>>
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
										<option value=''>所有局站</option>
										<?php if(isset($substationList)||count($substation)) foreach ($substationList as $substationObj){?>
									   <option value='<?php echo htmlentities($substationObj->id,ENT_COMPAT,"UTF-8")?>'
											<?php if(isset($roomObj) && $substationObj->id == $roomObj->substation_id){?>
											selected="selected" <?php }?>> <?php echo htmlentities($substationObj->name,ENT_COMPAT,"UTF-8");?></option>
									<?php }?>
									</select>
								</div>
								<label class="control-label" style="float: left;">机房名     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='txtName' id='txtName'
										value='<?php if(isset($roomObj)) echo htmlentities($roomObj->name, ENT_COMPAT, "UTF-8");?>' />
								</div>
							</div>
							<div class="control-group">
								
								
								<label class="control-label" style="float: left;">机房编码  <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' disabled="true" name='SubstationformatCode' id='SubstationformatCode' value="<?php echo htmlentities($roomObj->code, ENT_COMPAT, "UTF-8");?>"
									 	/>
								</div>	
									<label class="control-label" style="float: left;" >机房位置<font size=4 color=red>&nbsp;&nbsp;</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='txtLoc' id='txtLoc'
										value='<?php if(isset($roomObj)) echo htmlentities($roomObj->location, ENT_COMPAT, "UTF-8");?>' />
								</div>								
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">经度     <font size=4 color=red>&nbsp;&nbsp;</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='txtLng' id='txtLng'
										value='<?php if(isset($roomObj)) echo htmlentities($roomObj->lng, ENT_COMPAT, "UTF-8");?>' />
								</div>
								<label class="control-label" style="float: left;">维度     <font size=4 color=red>&nbsp;&nbsp;</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='txtLat' id='txtLat'
										value='<?php if(isset($roomObj)) echo htmlentities($roomObj->lat, ENT_COMPAT, "UTF-8");?>' />
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
