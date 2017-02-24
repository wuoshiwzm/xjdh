<script type="text/javascript">
$(document).ready(function(){
	$("#dataTable").tablesorter();
});</script>
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
							<i class="icon-search"></i> 选择要查看的实时状态
						</h3>
						<a class="widget-settings" href="#search-area" id='serarch-toggle'><i
							class="icon-hand-up"></i></a>
					</div>	
			<div class="widget-container" 
			id='search-area'>
			<form class="form-horizontal">
				<div class="control-group">
					<label class="control-label" style="float: left;">实时状态</label>
			               <div class="controls" style="margin-left: 20px; float: left;">
										<select class="chzn-select" data-placeholder="选择设备"
											name='model' id='model'>
											<option value=''>设备类型</option>	
	    							        <?php foreach (Defines::$gDevModel as $key=>$val){?>
								            <option value='<?php echo $key;?>'
												<?php  if($model == $key){?> selected="selected"
												<?php }?>><?php echo $val;?></option>
	    							        <?php }?>
	    								</select>
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
						<div class="form-horizontal">
							<div class="control-group">
								<label class="control-label" style="float: left;">所属部门/分公司</label>
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
								<label class="control-label" style="float: left;">区域</label>
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
								<label class="control-label" style="float: left;">激活状态</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select chzn-search-disabled "
										name='selActive' id='selActive'>
										<option value='all'>所有状态</option>
										<option
											<?php if($selActive == 'active'){?>
											selected='selected' <?php }?> value='active'>已激活</option>
										<option
											<?php if($selActive == 'deactive'){?>
											selected='selected' <?php }?> value='deactive'>未激活</option>
									</select>
								</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">设备名</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='txtName' id='txtName'
										value='<?php  echo $devName;?>' />
								</div>	
	                        </div>
							<div class="control-group">
								<label class="control-label" style="float: left;">数据ID</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='number' name='txtDataId' id='txtDataId'
										value="<?php echo $dataId;?>" />
								</div>
							<div  class="control-group">									
							<label class="control-label" style="float: left;">关键词</label>
									<div class="controls" style="margin-left: 20px; float: left;">
										<input type='text' name='keyWord' id='keyWord'
											value='<?php if(isset($keyWord)) echo $keyWord ?>' /> 
									</br><span style="color: red;">注：可为所属局站、机房、采集器IP、局站名称首字母</span>
								</div>
							</div>				
		<div class="form-actions">
								<button class="btn btn-success" type="submit" id='btn-submit'>提交</button>
								<button class="btn btn-success" name="export" value="exporttoexcel" type="submit" >导出报表</button>
							</div>
							</form>
        <div class="row-fluid">
			<div class="span12">
				<div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>
							<i class="icon-list"></i> 实时状态监测
						</h3>
					</div>
				</div>
               <div class="row-fluid">
					 <div class="span6">
					 </div>
					 <div class="span6">
						 <?php echo $pagination;?>
					 </div>
					</div>
				<div class="content-widgets light-gray">
					<div class="widget-container">
						<table id="dataTable"
							class="table table-bordered responsive table-striped tablesorter"">
							<thead>
								<tr>
									<th>序号</th>
								    <th>分公司&nbsp>
									        区域&nbsp>
									        局站</th>
									<th>机房</th>
									<th>采集器IP</th>
									<th>采集器编号</th>
									<th>设备名</th>
									<th>数据ID</th>
									<th>设备类型</th>
									<th>物理端口号</th>	
									<th>激活状态</th>
									<th>数据状态</th>
									<th>当前数据</th>
									<th>实时日志</th>
								</tr>
							</thead>
							<tbody id="tbDeviceVar">
							<?php $i =$offset + 1; foreach ($devList as $devObj){?>
								<tr>
									<td><?php echo $i++;?></td>
									<th><?php echo htmlentities(Defines::$gCity[$devObj->city_code],ENT_COMPAT,"UTF-8"); ?>&nbsp&nbsp
									    <?php echo htmlentities(Defines::$gCounty[$devObj->city_code][$devObj->county_code],ENT_COMPAT,"UTF-8"); ?><br/>	
									    <?php echo htmlentities($devObj->suname,ENT_COMPAT,"UTF-8"); ?>	</th>
									<td><?php echo htmlentities($devObj->room_name,ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities($devObj->ip,ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities($devObj->smd_device_no,ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities($devObj->name,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo Defines::$gDevModel[$devObj->model]; ?></td>
									<td><?php echo htmlentities($devObj->port,ENT_COMPAT,"UTF-8"); ?></td>									 
									<td><?php if($devObj->smd_device_active == 1){
									  	echo '<span class="label label-success">采集板已激活</span>';
									  } if($devObj->smd_device_active == 0){
									  	echo '<span class="label label-danger">采集板未激活</span>';
									  } if($devObj->active == 1){
									  	echo '<span class="label label-success">设备已激活</span>';
									  } if($devObj->active == 0){
									  	echo '<span class="label label-danger">设备未激活</span>';
									  }?></td>
									<td>
									    <?php if($devObj->data_status == "正常"){ ?>
									    <span class="label label-success"><?php echo htmlentities($devObj->data_status,ENT_COMPAT,"UTF-8"); ?></span>
									    <?php }else{ ?>
									    <span class="label label-warning"><?php echo htmlentities($devObj->data_status,ENT_COMPAT,"UTF-8"); ?></span>
									    <?php } ?>
							        </td>
									<td><?php if($devObj->model=="power_302a"){ ?>
        	                           <button
        	                           data_id='<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?>' 
        	                           class="btn btn-warning setThreshold">查看数据 </button>	
                                       <?php } ?>														
									<span class="label label-success "><?php								
			        if ($devObj->model == "temperature") {
			            echo htmlentities($devObj->value,ENT_COMPAT,"UTF-8") . "°C";
			        } else 
			            if ($devObj->model == "humid") {
			                echo htmlentities($devObj->value,ENT_COMPAT,"UTF-8") . "%";
			            } else 
			                if ($devObj->model == "water" || $devObj->model == "smoke") {
			                    echo $devObj->value == 0 ? "告警" : "正常";
			                }
			        ?></span></td>
						<td><a  href="/portal/rt_log/<?php echo htmlentities($devObj->smd_device_no,ENT_COMPAT,"UTF-8"); ?>">实时日志</a></td>
								</tr>
							<?php }?>
							</tbody>
						</table>
						<div class="row-fluid">
							<div class="span6">
						总计 <?php echo $count;?> 个设备
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
<div class="modal fade bs-example-modal-lg" id='roomPiDlg' style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h3> 查看智能电表数据  </h3>
			</div>
			<div class="modal-body modal-lg">
				<h4>性能指标</h4>				
				<br>
				<table
					class="paper-table table table-paper table-striped table-sortable">
					<thead>
						<tr>
							<th>序号</th>
							<th>信号量</th>
							<th>A相值</th>
							<th>B相值</th>
							<th>C相值</th>
							<th>合相值</th>
						</tr>
					</thead>
					<tbody class='rt-data ' id="302a_power">
		                <?php $i=1; foreach(Defines::$g302A as $key){ ?>
                        <tr> 
						    <td><?php echo $i++;?></td>
							<td><?php echo $key;?></td>
							<td><span></span></td>
							<td><span></span></td>
							<td><span></span></td>
							<td><span></span></td>
			            </tr>
			            <?php } ?>
                     </tbody>              
				 </table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
			</div>
		</div>
	</div>
</div>

