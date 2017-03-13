<script type="text/javascript">
var door_id = <?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8"); ?>;
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
    		  <h4><?php echo htmlentities($devObj->name, ENT_COMPAT, "UTF-8"); ?></h4>
    		</div>
    	</div>
		<div class="row-fluid">
			<div class='span12'>
				<div class="tab-widget">
					<ul class="nav nav-tabs">
                	   <li class="active"><a href="/portal/door_user/<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8"); ?>"><i class="icon-tasks"></i>用户权限管理</a></li>
                	   <li><a href="/portal/door_operate/<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8"); ?>"><i class="icon-tasks"></i>授权记录</a></li>
                	   <li><a href="/portal/door_record/<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8"); ?>"><i class="icon-tasks"></i>开门记录</a></li>
					</ul>
				</div>
				<a type="button" class="btn btn-info" id="btnAddPermission"
									href='####'><i
									class="icon-plus"></i> 添加用户授权</a>
			 <a type="button" class="btn btn-info" id="btnDownAll"
									href='####'><i
									class="icon-plus"></i> 强制下发所有用户</a>
			<h4>说明：添加用户授权后，系统会自动将用户下发到门禁控制器，无需手动操作</h4>
			<h4>说明："强制下发所有用户"将所有用户重新下发到门禁控制器</h4>
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
								<label class="control-label" style="float: left;">用户名</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" name="username" value="<?php if($username) echo htmlentities($username, ENT_COMPAT, "UTF-8"); ?>">
								</div>
								
								<label class="control-label" style="float: left;">名字</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" name="full_name" value="<?php if($full_name) echo htmlentities($full_name, ENT_COMPAT, "UTF-8"); ?>">
								</div>
								</div>
								<div class="control-group">
								<label class="control-label" style="float: left;">手机号</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" name="mobile" value="<?php if($mobile) echo htmlentities($mobile, ENT_COMPAT, "UTF-8"); ?>">
								</div>
								
								<label class="control-label" style="float: left;">门禁卡号</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" name="accessid" value="<?php if($accessid) echo htmlentities($accessid, ENT_COMPAT, "UTF-8"); ?>">
								</div>
								</div>
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
    							        <?php }else if($this->userObj->user_role == "city_admin"){ ?>
    							        <option value="<?php echo $userObj->city_code; ?>">
    							            <?php echo Defines::$gCity[$userObj->city_code]; ?></option>
    							        <?php }?>
    								</select>
								</div>
								<label class="control-label" style="float: left;">区域</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择区域"
										name='selCounty' id='selCounty'>
										<?php if($this->userObj->user_role == "city_admin"){ ?>
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
								<label class="control-label" style="float: left;">授权用户名</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" name="assigner_name" value="<?php if($assigner_name) echo htmlentities($assigner_name, ENT_COMPAT, "UTF-8"); ?>">
								</div>
								
							</div>										
							<div class="control-group">
							<div class="form-actions">
								<button class="btn btn-success" type="submit" id='btn-submit'>搜索</button>
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
							总计 <?php echo $count;?> 个授权用户
							</div>
							<div class="span6">
						      <?php echo $pagination;?>
						  </div>
						</div>
		<div class="row-fluid">
		    <div class="span9"><a type="button" class="btn btn-danger" id="btnRevoke"
									href='####'><i
									class="icon-plus"></i> 批量移除用户授权</a></div>
			<table
				class="table table-bordered responsive table-striped">
				<thead>
					<tr>
					    <th><input type="checkbox" id="cbAll" /></th>
						<th>序号</th>
						<th>用户名</th>
						<th>名字</th>
						<th>手机号</th>
						<th>门禁卡号</th>
						<th>所属分公司</th>
						<th>所属区域</th>
						<th>所属局站</th>
						<th>授权用户名</th>
						<th>授权时间</th>
						<th>有效期</th>
						<th>控制权限</th>
						<th>下发状态</th>
						<th>门禁状态</th>
						<th>自动删除次数</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody id="userList">
				<?php $index = $offset + 1; foreach ($userList as $userObj){?>
				 <tr  door_id="<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8"); ?>" dooruser_id='<?php echo htmlentities($userObj->user_id,ENT_COMPAT,"UTF-8");?>' device_id='<?php echo htmlentities($userObj->user_id,ENT_COMPAT,"UTF-8");?>' >
				        <td><input type="checkbox" /></td>
						<td><?php echo $index++;?></td>
						<td><?php echo htmlentities($userObj->username,ENT_COMPAT,"UTF-8");?></td>
						<td><?php echo htmlentities($userObj->full_name,ENT_COMPAT,"UTF-8");?></td>
						<td><?php echo htmlentities($userObj->mobile,ENT_COMPAT,"UTF-8");?></td>
        				<td><?php echo htmlentities($userObj->accessid,ENT_COMPAT,"UTF-8");?></td>
						<td><?php echo htmlentities(Defines::$gCity[$userObj->city_code],ENT_COMPAT,"UTF-8");?></td>
						<td><?php echo htmlentities(Defines::$gCounty[$userObj->city_code][$userObj->county_code],ENT_COMPAT,"UTF-8");?></td>
						<td><?php echo htmlentities($userObj->statioin_name,ENT_COMPAT,"UTF-8");?></td>
						<td><?php echo htmlentities($userObj->assigner_name,ENT_COMPAT,"UTF-8");?></td>
						<td><?php echo htmlentities($userObj->added_datetime,ENT_COMPAT,"UTF-8");?></td>
						<td><?php echo htmlentities($userObj->expire_date,ENT_COMPAT,"UTF-8"); ?></td>
						<td><?php if($userObj->card_control){ ?>
						      <span  class="label label-success">刷卡开门</span>
						    <?php }else{ ?>
						      <span class="label label-danger">无刷卡开门</span>
						    <?php } ?>
						    <?php if($userObj->remote_control){ ?>
						      <span  class="label label-success">远程开门</span>
						    <?php }else{ ?>
						      <span class="label label-danger">无远程开门</span>
						    <?php } ?></td>
						<td><?php if($userObj->status == "待下发"){?>
							<a class="label label-warning dev-unlock" type="button" >待下发</a>
							<?php } ?>
							<?php if($userObj->status == "已下发"){?>
							<a class="label label-success dev-lock" type="button" >已下发</a>
							<?php } ?> 
							<?php if($userObj->status == "待删除"){ ?>
							<a class="label label-danger">待删除</a>
							<?php } ?>		  
						</td>	
						<td>
							<?php if($userObj->smd_device_active == "1"){
								  echo '<span class="label label-success">采集板已激活</span>';
								} if($userObj->smd_device_active == "0"){
								  echo '<span class="label label-danger">采集板未激活</span>';
							    } if($userObj->device_active == "1"){
								  echo '<span class="label label-success">设备已激活</span>';
								} if($userObj->device_active == "0"){
								  echo '<span class="label label-danger">设备未激活</span>';
							 }?>
						</td>
						<td><?php if($userObj->delete_check_count == 0){ ?>
						      未使用
						  <?php }else{ 
						      echo $userObj->delete_check_count; 
							 }?></td>	     				     
						<td>
						  <a class="btn btn-primary" href="####" type="button"><i class="icon-trash"></i>设置属性</a>
						    <?php if($userObj->status != "待删除"){ ?>
						    <a class="btn btn-danger delete-user" href="####" type="button">
						    <i class="icon-trash"></i>移除授权</a>
					        <?php } ?>
					   
					        <?php if($userObj->status != "待删除"){ ?>
<!-- 					        <a class="btn btn-danger change-status" type="button"> -->
<!--                             <i class="icon-edit"></i>修改下发状态</a> -->
					        <?php } ?> 
					   </td>
					</tr>
				<?php }?>
				</tbody>
			</table>
			<div class="row-fluid">
				<div class="span6 pagination">
					总计 <?php echo $count;?> 个授权用户
				</div>
				<div class="span6">
			      <?php echo $pagination;?>
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
								<h4>请勾选要添加开门权限的用户</h4>									
							</div>								
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class='span9'>
							<div class="content-widgets">
								<div class="widget-header-block">
									<h3>用户列表</h3>
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

<div class="modal fade bs-example-modal-lg" role="dialog"
	id='propertyDialog'
	style="left: 50%; margin-left: -575px; width: 1150px; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body modal-lg">
				<div class="row-fluid">
					<div class='span12'>
						<div class="content-widgets">
						     <div class="content-box">
								<h3>属性设置</h3>									
							</div>								
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class='span12'>
						<div class="content-widgets">
							<div class="widget-header-block">
								<h3>设置每月打卡不达标的次数</h3>
							</div>
							<div class="content-box">
							   提示：若设置本属性，本月未达到刷卡次数的人员，次月自动删除门禁权限。
							</div>
							<div class="content-box">
							   刷卡次数: <input type="number" max="100" min="0" id="txtTimes" />（值范围:0-100,0为不激活)
							</div>
						</div>
					</div>
				</div>
            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary"
					data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-danger" data_id="<?php echo $devObj->data_id; ?>" id='btnDoorSet'>保存</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
  