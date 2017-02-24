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
                	   <li><a href="/portal/door_user/<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8"); ?>"><i class="icon-tasks"></i>用户权限管理</a></li>
                	   <li class="active"><a href="/portal/door_operate/<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8"); ?>"><i class="icon-tasks"></i>授权记录</a></li>
                	   <li><a href="/portal/door_record/<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8"); ?>"><i class="icon-tasks"></i>开门记录</a></li>
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
						<a class="widget-settings" href="#search-area" id='serarch-toggle'><i
							class="icon-hand-up"></i></a>
					</div>
					<div class="widget-container" 
						id='search-area'>
						<form class="form-horizontal">
						  <div class="control-group">
								<label class="control-label" style="float: left;">操作人员</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" name="operator_name" value="<?php if($operator_name) echo htmlentities($operator_name, ENT_COMPAT, "UTF-8"); ?>">
								</div>
								
								<label class="control-label" style="float: left;">手机号</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" name="operator_mobile" value="<?php if($operator_mobile) echo htmlentities($operator_mobile, ENT_COMPAT, "UTF-8"); ?>">
								</div>
								</div>
								<div class="control-group">
								<label class="control-label" style="float: left;">用户</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" name="full_name" value="<?php if($full_name) echo htmlentities($full_name, ENT_COMPAT, "UTF-8"); ?>">
								</div>
								
								<label class="control-label" style="float: left;">用户手机号</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" name="mobile" value="<?php if($mobile) echo htmlentities($mobile, ENT_COMPAT, "UTF-8"); ?>">
								</div>
								</div>
								
								<div class="control-group">
								<label class="control-label" style="float: left;">事件时间段</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" class=" form-control date-range-picker" name="time_range" value="<?php if($time_range)  echo htmlentities($time_range, ENT_COMPAT, "UTF-8");?>">
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
							<i class="icon-list"></i> 授权记录
						</h3>
					</div>
					<div class="widget-container">					
						<div class="row-fluid">
							<div class="span6 pagination">
							总计 <?php echo $count;?> 个授权记录
							</div>
							<div class="span6">
						      <?php echo $pagination;?>
						  </div>
						</div>
		<div class="row-fluid">
			<table
				class="table table-bordered responsive table-striped">
				<thead>
					<tr>
						<th>序号</th>
						<th>操作人员</th>
						<th>手机号</th>
						<th>用户</th>
						<th>用户手机号</th>
						<th>操作</th>
						<th>操作时间</th>
					</tr>
				</thead>
				<tbody id="userList">
				<?php $index = $offset + 1; foreach ($userList as $userObj){?>
				 <tr  door_id="<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8"); ?>" dooruser_id='<?php echo htmlentities($userObj->id,ENT_COMPAT,"UTF-8");?>'>
						<td><?php echo $index++;?></td>
						<td><?php echo htmlentities($userObj->operator_name,ENT_COMPAT,"UTF-8");?></td>
						<td><?php echo htmlentities($userObj->operator_mobile,ENT_COMPAT,"UTF-8"); ?></td>
						<td><?php echo htmlentities($userObj->full_name,ENT_COMPAT,"UTF-8");?></td>
						<td><?php echo htmlentities($userObj->mobile,ENT_COMPAT,"UTF-8"); ?></td>
						<td><?php echo htmlentities($userObj->desc,ENT_COMPAT,"UTF-8");?></td>
						<td><?php echo htmlentities($userObj->added_datetime,ENT_COMPAT,"UTF-8"); ?></td>
					</tr>
				<?php }?>
				</tbody>
			</table>
			<div class="row-fluid">
				<div class="span6 pagination">
					总计 <?php echo $count;?> 条授权记录
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
						<div class='span12'>
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
  