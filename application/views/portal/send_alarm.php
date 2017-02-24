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
							<i class="icon-search"></i> 手动下发告警
						</h3>
					</div>
					<div class="widget-container">
						<form class="form-horizontal">
							<div class="control-group">
								<label class="control-label" style="float: left;">分公司     <font size=4 color=red>&nbsp;*</font></label>
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
    							        <?php }else if($userObj->user_role == "city_admin"){ ?>
    							        <option value="<?php echo $userObj->city_code; ?>">
    							            <?php echo Defines::$gCity[$userObj->city_code]; ?></option>
    							        <?php }?>
    								</select>
								</div>

								<label class="control-label" style="float: left;">区域     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择区域"
										name='selCounty' id='selCounty'>
										<?php if($userObj->user_role == "city_admin"){ ?>
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
								<label class="control-label" style="float: left;">所属局站     <font size=4 color=red>&nbsp;*</font></label>
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
								<label class="control-label" style="float: left;">所属机房     <font size=4 color=red>&nbsp;*</font></label>
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
								<label class="control-label" style="float: left;">设备类型     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择设备类型"
										name='selDevModel' id='selDevModel'>
										<option value='' sys_code='00'>所有类型</option>
							             <?php
                    
                    foreach (Defines::$gDevModel as $key => $val) {
                        ?>
							             <option value='<?php echo $key;?>'
											<?php if($devModel == $key) {?> selected='selected' <?php }?>
											sys_code='<?php echo Defines::$gDevModelSystemCode[$key];?>'><?php echo $val;?></option>
							             <?php }?>
    							     </select>
								</div>
								<label class="control-label" style="float: left;">设备     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择设备"
										name='selDevice' id='selDevice'>

									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">告警级别     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择告警级别"
										name='level' id='selLevel'>
										<option value='1'>一级</option>
										<option value='2'>二级</option>
										<option value='3'>三级</option>
										<option value='4'>四级</option>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">局站类型     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择局站类型"
										name='selStationType' id='selStationType'>
										<option value='00'>特殊基站</option>
										<option value='01'>A类基站</option>
										<option value='02'>B类基站</option>
										<option value='03'>C类基站</option>
										<option value='04'>D类局站-接入网点和电信代维用户机房</option>
										<option value='05'>D级局站-基站</option>
										<option value='09'>监控系统</option>
									</select>
								</div>
								<label class="control-label" style="float: left;">信号类型     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择信号类型"
										name='selSignalType' id='selSignalType'>
										<option value='0'>遥信信号</option>
										<option value='1'>遥测信号</option>
										<option value='2'>遥控信号</option>
										<option value='3'>遥调信号</option>
									</select>
								</div> 
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">信号的流水号(2位)     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" name='txtSignalNum' id='txtSignalNum' value='01' />
								</div>
								<label class="control-label" style="float: left;">信号的顺序号(3位)     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" value='001' name='txtSignalSerial' id='txtSignalSerial' />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">信号ID     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" name='txtSignalId' id="txtSignalId" />
								</div>
								<label class="control-label" style="float: left;">信号名称     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
								<input type="text" name='txtSignalName' id="txtSignalName" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">告警描述     <font size=4 color=red>&nbsp;&nbsp;</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<textarea type="text" name='txtSubject' id="txtSubject"></textarea>
								</div>
							</div>
							<div class="form-actions">
								<button class="btn btn-success" type="button" id='btnSend'>发送</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal hide fade bs-example-modal-lg" id='sendDlg'>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"
			aria-hidden="true">&times;</button>
		<h4>手动下发告警</h4>
	</div>
	<div class="modal-body">
		<div class="widget-container">
			<ul class="profile-intro">
				<li><label>数据ID:</label><span id='span_dataId'></span></li>
				<li><label>告警级别:</label><span id='span_level'></span></li>
				<li><label>信号名称:</label><span id='span_signalName'></span></li>
				<li><label>信号ID:</label><span id='span_signalId'></span></li>
				<li><label>告警信息:</label><span id='span_subject'></span></li>
			</ul>
		</div>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal" aria-hidden="true">关闭</a>
		<a href="#" class="btn btn-primary" id='btnConfirm'>确定</a>
	</div>
</div>
