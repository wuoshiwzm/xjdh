<script type="text/javascript">
var user_id = <?php echo htmlentities($userObj->id,ENT_COMPAT,"UTF-8"); ?>
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
    		<div class='span12'>
    		  <h4><?php echo htmlentities($userObj->full_name, ENT_COMPAT, "UTF-8"); ?>门禁列表</h4>
    		</div>
    	</div>
		<div class="row-fluid">
			<div class='span12'>
				<div class="tab-widget">
					<ul class="nav nav-tabs">
                	   <li class="active"><a href="/portal/door_user_list/<?php echo htmlentities($userObj->id,ENT_COMPAT,"UTF-8"); ?>"><i class="icon-tasks"></i>门禁管理</a></li>
                	   <li><a href="/portal/door_user_operate/<?php echo htmlentities($userObj->id,ENT_COMPAT,"UTF-8"); ?>"><i class="icon-tasks"></i>授权记录</a></li>
                	   <li><a href="/portal/door_user_record/<?php echo htmlentities($userObj->id,ENT_COMPAT,"UTF-8"); ?>"><i class="icon-tasks"></i>开门记录</a></li>
					</ul>
				</div>
				<a type="button" userId='<?php echo $user_id?>' class="btn btn-info" id="btnAddPermission"
									href='####'><i
									class="icon-plus"></i> 添加门禁授权</a>
			 <a type="button" class="btn btn-info" id="btnDownAll"
									href='####'><i
									class="icon-plus"></i> 强制下发所有门禁</a>
			<h4>说明：添加用户授权后，系统会自动将用户下发到门禁控制器，无需手动操作</h4>
			<h4>说明："强制下发所有门禁"将相关门禁控制器的所有用户重新下发</h4>
			<h4>说明：用户如果没有设置门禁卡号无法下发</h4>
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
    							            <?php echo Defines::$gCity[$userObj->city_code]; ?></option>
    							        <?php }?>
    								</select>
								</div>
								<label class="control-label" style="float: left;">区域</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择区域"
										name='selCounty' id='selCounty'>
										<?php if($this->userObj->user_role == "city_admin"||$this->userObj->user_role == "operator"){ ?>
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
    							<label class="control-label" style="float: left;">设备名</label>
    								<div class="controls" style="margin-left: 20px; float: left;">
    									<input type='text' name='txtName' id='txtName'
    										value='<?php echo $devName;?>' />
    								</div>
    								<label class="control-label" style="float: left;">数据ID</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='number' name='txtDataId' id='txtDataId'
										value="<?php echo $dataId;?>" />
								</div>
							</div>
							<div class="control-group">
								
								
								<label class="control-label" style="float: left;">激活状态</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select chzn-search-disabled "
										name='selActive' id='selActive'>
										<option value='all'>所有状态</option>
										<option
											<?php if($active == 'active'){?>
											selected='selected' <?php }?> value='active'>已激活</option>
										<option
											<?php if($active == 'deactive'){?>
											selected='selected' <?php }?> value='deactive'>未激活</option>
									</select>
								</div>
							<div  class="control-group">									
							<label class="control-label" style="float: left;">关键词</label>
									<div class="controls" style="margin-left: 20px; float: left;">
										<input type='text' name='keyWord' id='keyWord'
											value='<?php if(isset($keyWord)) echo $keyWord ?>' /> 
									</br><span style="color: red;">注：可为区域、局站、机房、采集单元、局站名称首字母</span>
									</div>
							</div>
							<div class="form-actions">
								<button class="btn btn-success" type="submit" id='btn-submit'>搜索</button>
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
		              <div class="row-fluid">
						<div class="span9"><a type="button" class="btn btn-danger" id="btnRevoke"
									href='####'><i
									class="icon-plus"></i> 批量移除门禁授权</a></div>
					</div>
						<table id="dataTable"
							class="table table-bordered responsive table-striped">
							<thead>
								<tr>
								    <th><input type="checkbox" id="cbAll" /></th>
									<th>序号</th>
									<th>分公司</th>
									<th>区域</th>
									<th>局站</th>
									<th>机房</th>
									<th>采集单元</th>
									<th>设备名</th>
									<th>数据ID</th>									
						            <th>控制权限</th>
									<th>下发状态</th>
									<th>门禁状态</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody id="userList">
							<?php $i = $offset + 1; foreach ($devList as $devObj){?>
							<tr device_id='<?php echo htmlentities($devObj->id,ENT_COMPAT,"UTF-8"); ?>' dataId='<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?>'>
							         <td><input type="checkbox" /></td>
									<td><?php echo $i++;?></td>
									<td><?php echo htmlentities(Defines::$gCity[$devObj->city_code],ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities(Defines::$gCounty[$devObj->city_code][$devObj->county_code],ENT_COMPAT,"UTF-8");?></td>	
									<td><?php echo htmlentities($devObj->suname,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($devObj->room_name,ENT_COMPAT,"UTF-8");?></td>
									<td><a data-rel="popover"
										data-content="<?php echo "IP：". htmlentities($devObj->ip,ENT_COMPAT,"UTF-8");?>"
										data-placement="top" href="/portal/realtimedata/<?php echo htmlentities($devObj->roomId,ENT_COMPAT,"UTF-8");?>/smd_device" data-original-title="采集设备信息"><?php echo '(' . htmlentities($devObj->smd_device_no,ENT_COMPAT,"UTF-8"). ')' . htmlentities($devObj->smd_device_name,ENT_COMPAT,"UTF-8");?></a></td>
									<td><a href="/portal/realtimedata/<?php echo htmlentities($devObj->roomId,ENT_COMPAT,"UTF-8");?>/door" data_id='<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?>'><?php echo htmlentities($devObj->name,ENT_COMPAT,"UTF-8");?></a></td>
									<td><?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?></td>
									<td><?php if($devObj->card_control){ ?>
        						      <span  class="label label-success">刷卡开门</span>
        						    <?php }else{ ?>
        						      <span class="label label-danger">无刷卡开门</span>
        						    <?php } ?>
        						    <?php if($devObj->remote_control){ ?>
        						      <span  class="label label-success">远程开门</span>
        						    <?php }else{ ?>
        						      <span class="label label-danger">无远程开门</span>
        						    <?php } ?></td>
									<td><?php switch($devObj->status){
									    case "待下发":
									        echo '<span class="label label-warning">'.$devObj->status.'</span>';
									        break;
									    case "已下发":
									        echo '<span class="label label-success">'.$devObj->status.'</span>';
									        break;
									    case "待删除":
									        echo '<span class="label label-danger">'.$devObj->status.'</span>';
									        break;
									   }
									     ?>										
									<td>
									  <?php if($devObj->smd_device_active == 1){
									  	echo '<span class="label label-success">采集板已激活</span>';
									  } if($devObj->smd_device_active == 0){
									  	echo '<span class="label label-danger">采集板未激活</span>';
									  } if($devObj->active == 1){
									  	echo '<span class="label label-success">设备已激活</span>';
									  } if($devObj->active == 0){
									  	echo '<span class="label label-danger">设备未激活</span>';
									  }?>
									</td>
									<td>
									<?php if($devObj->status != "待删除"){ ?>
                						<a class="btn btn-danger delete-user" href="#" type="button"><i
                								class="icon-trash"></i> 移除授权</a>
                						<br/>
                					   <?php } ?>								
										<a href="/portal/door_user/<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8"); ?>">
											用户权限管理
										</a>
										<a href="/portal/door_operate/<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8"); ?>">
											授权记录
										</a>
										<a href="/portal/door_record/<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8"); ?>">
											开门记录
										</a>
									</td>
								</tr>
							<?php }?>
							</tbody>
						</table>
						<div class="row-fluid">
							<div class="span6">
							总计 <?php echo $count;?> 个门禁设备
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



  <div class="modal fade bs-example-modal-lg" role="dialog"
		id='userDialog'
		style="left: 50%; margin-left: -575px; width: 1150px; display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body modal-lg">
					<div class="row-fluid">
						<div class='span12'>
							<div class="content-widgets">
							     <div class="content-box">
									<h4>请勾选要添加开门权限的门禁</h4>									
								</div>								
							</div>
						</div>
					</div>
					<div class="row-fluid">
						<div class='span9'>
								<div class="content-widgets">
									<div class="widget-header-block">
										<h3>门禁列表</h3>
									</div>
									<div class="content-box">
										<input type="text" value=""
											style="box-shadow: inset 0 0 4px #eee; margin: 0; padding: 6px 12px; border-radius: 4px; border: 1px solid silver; font-size: 1.1em;"
											id="userQuery" placeholder="搜索" />
										<div id='userTree'
											style="max-height: 500px; overflow-y: auto;"></div>
									</div>
								</div>
							</div>
							<div class='span3'>
								<div class="content-widgets">
									<div class="widget-header-block">
										<h3>参数设置</h3>
									</div>
									<div class="content-box">
									   授权有效期: <input type="text" class="datepicker" id="txtExpire" />
									</div>
									<div class="content-box">
									   控制权限: <label><input type="checkbox" id="cbCard" checked="checked" />刷卡开门</label>
									           <label><input type="checkbox" id="cbRemote" />远程开门</label>
									</div>
								</div>
							</div>
					</div>
                </div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary"
						data-dismiss="modal">取消</button>
					<button type="button" class="btn btn-danger" door_id="<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8"); ?>" id='btnDoorAddUser'>添加</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
</div>
  