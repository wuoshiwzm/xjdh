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
					</div>
					<div class="widget-container hide">
						<form class="form-horizontal">
							<div class="control-group">
								<label class="control-label" style="float: left;">分公司</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择分公司"
										name='selCity' id='selCity'>
    							    <?php if($_SESSION['XJTELEDH_USERROLE'] == 'admin' || $_SESSION['XJTELEDH_USERROLE'] == 'noc'){?>
    							        <option value=''>全网</option>
    							        <?php foreach (Defines::$gCity as $cityKey=>$cityVal){?>
							            <option value='<?php echo $cityKey;?>'
											<?php  if($selCity == $cityKey){?> selected="selected"
											<?php }?>><?php echo $cityVal;?>本地网</option>
    							        <?php }?>
    							        <?php }else if($userObj->user_role == "city_admin"||$userObj->user_role == "noc"||$userObj->user_role == "member"){ ?>
    							        <option value="<?php echo $userObj->city_code; ?>">
    							            <?php echo Defines::$gCity[$userObj->city_code]; ?></option>
    							        <?php }?>
    								</select>
								</div>

								<label class="control-label" style="float: left;">区域</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择区域"
										name='selCounty' id='selCounty'>
										<?php if($userObj->user_role == "city_admin"||$userObj->user_role == "noc"||$userObj->user_role == "member"){ ?>
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
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">所属局站</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择局站"
										name='selSubstation' id='selSubstation'>
										<option value="">所有局站</option>
									<?php if(isset($substationList)) foreach ($substationList as $substationObj){?>									
									   <option value='<?php echo htmlentities($substationObj->id,ENT_COMPAT,"UTF-8")?>'
											<?php if($substationObj->id == $substationId){?>
											selected="selected" <?php }?>> <?php echo htmlentities($substationObj->name,ENT_COMPAT,"UTF-8");?></option>
									<?php }?>
									</select>
								</div>
								<label class="control-label" style="float: left;">所属机房</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择机房"
										name='selRoom' id='selRoom'>
										<option value="">所有机房</option>
									<?php foreach ($roomList as $roomObj){?>
									   <option value='<?php echo htmlentities($roomObj->id,ENT_COMPAT,"UTF-8")?>'
											<?php if($roomObj->id == $roomId){?> selected="selected"
											<?php }?>> <?php echo htmlentities($roomObj->name,ENT_COMPAT,"UTF-8");?></option>
									<?php }?>
									</select>
								</div>
							</div>
							<div class="control-group">
					          <label class="control-label" style="float: left;">信号名称</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="信号名称"
										name='selSignalName'  id='selSignalName'>
										<option value=''>所有名称</option>
										<?php foreach($signalNameList as $signalName){?>
									    <option value='<?php echo htmlentities($signalName, ENT_COMPAT, "UTF-8"); ?>' <?php if(isset($getsignalName) && $signalName == $getsignalName){?> selected="selected" <?php }?> ><?php echo htmlentities($signalName, ENT_COMPAT, "UTF-8"); ?></option>
									    <?php }?>	   
									</select>
								</div>
							    <label class="control-label" style="float: left;">设备类型</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择设备类型"
										name='selDevModel' id='selDevModel'>
										<option value=''>所有类型</option>
										<?php foreach($devCategoryName as $key=>$val){?>
										<option <?php if($key == $selDevModel){?> selected="selected" <?php }?>
										value='<?php echo $key; ?>'><?php echo htmlentities($val, ENT_COMPAT, "UTF-8"); ?></option>	
										<?php }?>
									</select>
								</div>
							</div>						
							<div class="control-group">
								<label class="control-label" style="float: left;">告警级别</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择告警级别"
										name='level' id='selLevel'>
										<option value=''>所有级别</option>
										<option <?php if($level == 1){?> selected="selected" <?php }?>
											value='1'>一级</option>
										<option <?php if($level == 2){?> selected="selected" <?php }?>
											value='2'>二级</option>
										<option <?php if($level == 3){?> selected="selected" <?php }?>
											value='3'>三级</option>
										<option <?php if($level == 4){?> selected="selected" <?php }?>
											value='4'>四级</option>
									</select>
								</div>
                                 <label class="control-label" style="float: left;">上报时间段</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" class='form-control date-range-picker'
										name='reportdate'
										value="<?php if(isset($reportdate)) echo $reportdate;?>">
								</div>
							</div>							
							<table class="table table-bordered responsive table-striped table-sortable">
			
			                    <thead id="theads">
		
			                    </thead>
			               	
			                    <tbody class="classList">		
		
			                    </tbody>
		                   </table>
		                   <script type="text/javascript">
		                   var selDevModel = <?php echo json_encode(Defines::$gDevModel); ?>;
		                   var selRoom = <?php echo json_encode($roomList)?>;
		                   var selCity = <?php echo json_encode($cityList)?>;
		                   var selCounty = <?php echo json_encode($countyList)?>;
		                  
		                   </script>
							<div class="form-actions">
								<button class="btn btn-success" type="submit">查询</button>	
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
							<i class="icon-list"></i> <?php
    
						    switch ($level) {
						        case 1:
						            echo '一级';
						            break;
						        case 2:
						            echo '二级';
						            break;
						        case 3:
						            echo '三级';
						            break;
						        case 4:
						            echo '四级';
						            break;
						        default:
						            echo '所有';
						            break;
						    }
						    ?>告警</h3>
					</div>
					<div class="widget-container">
						<table
							class="table table-bordered responsive table-striped table-sortable">
							<thead>
								<tr>
									<th>序号</th>
									<th>分公司</th>
									<th>区域</th>
									<th>局站</th>
									<th>机房</th>
									<th>设备类型</th>
									<th>设备名称</th>
									<th>信号名称</th>
									<th>信号Id</th>
									<th>级别</th>
									<th>描述</th>
									<th>上报时间</th>
									<th>当前状态</th>
									<th>确认时间</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
							<?php $i = $offset + 1; foreach ($alarmList as $alarmObj){?>
							<tr>
									<td><?php echo $i++;?></td>
									<td><?php echo htmlentities(Defines::$gCity[$alarmObj->city_code],ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities(Defines::$gCounty[$alarmObj->city_code][$alarmObj->county_code],ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($alarmObj->substation_name,ENT_COMPAT,"UTF-8");?></td>	
									<td><?php echo htmlentities($alarmObj->room_name,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo $devModelName[$alarmObj->model]; ?></td>
									<td><a href='/portal/realtimedata/<?php echo htmlentities($alarmObj->room_id,ENT_COMPAT,"UTF-8");?>/<?php echo htmlentities($alarmObj->model,ENT_COMPAT,"UTF-8");?>'><?php echo htmlentities($alarmObj->dev_name,ENT_COMPAT,"UTF-8");?></a></td>
									<td><?php echo htmlentities($alarmObj->signal_name,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($alarmObj->signal_id,ENT_COMPAT,"UTF-8");?></td>
									<td><?php
        
							        switch ($alarmObj->level) {
							            case 1:
							                echo '<span class="brown badge ">一级</span>';
							                break;
							            case 2:
							                echo '<span class="badge orange">二级</span>';
							                break;
							            case 3:
							                echo '<span class="dark-yellow badge ">三级</span>';
							                break;
							            case 4:
							            default:
							                echo '<span class="badge blue">四级</span>';
							                break;
							        }
							        ?>
							     </td>
									<td><?php echo htmlentities($alarmObj->subject,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($alarmObj->added_datetime,ENT_COMPAT,"UTF-8");?></td>									
									<td><?php if ($alarmObj->status == 'unresolved')
 								        echo '<span class="label label-important">正在告警</span>';?></td>
									<td><?php echo htmlentities($alarmObj->restore_datetime,ENT_COMPAT,"UTF-8");?></td>
									<td>
									    <?php if ($alarmObj->status == 'unresolved') {?>
										<button alert_id='<?php echo htmlentities($alarmObj->id,ENT_COMPAT,"UTF-8");?>' type="button"
											class="btn btn-warning block-alert">
											<i class="icon-remove-sign"></i>确认告警
										</button>
										<?php }else{?>	
										<?php }?>
									</td>
								</tr>
							<?php }?>
							</tbody>
						</table>
						<div class="row-fluid">
							<div class="span6">
								<div class="dataTables_info">总共 <?php echo $alarmCount;?> 条告警，显示<?php echo '第 '.($offset+1).' 至 '.($i - 1);?> 条</div>
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
