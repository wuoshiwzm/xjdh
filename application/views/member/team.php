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
						<a class="widget-settings" href="#search-area" id='serarch-toggle'><i
							class="icon-hand-up"></i></a>
					</div>
					<div class="widget-container" 
						id='search-area'>
						<form class="form-horizontal">

								<div class="control-group">
								<label class="control-label" style="float: left;">角色</label>

								<label class="control-label" style="float: left;">性别</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择性别"
										name='gender' id='gender'>
										<option value='' >所有</option>
										<option value="male" <?php if($gender == "male"){?>selected="selected"<?php }?>> 男 </option>
										<option value="female" <?php if($gender == "female"){?>selected="selected"<?php }?>> 女 </option> 	
									</select>
								</div>
								</div>

							<div class="form-actions">
								<button class="btn btn-success" type="submit" id='btn-submit'>提交</button>
								<button class="btn btn-success" name="export" value="exporttoexcel" type="submit" >导出报表</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
			<?php if(isset($msg)){?>
			<div class="alert alert-success">
			<button data-dismiss="alert" class="close">×</button>
			<strong>导入成功!<?php echo $msg;?><a href='/portal/usermanage'><font
					size=2 color=red>刷新</font></a></strong>

		</div>
		<?php }?>
		<?php if(isset($errMsg)){?>
			<div class="alert alert-error">
			<button data-dismiss="alert" class="close">×</button>
			<strong>导入失败!<?php echo $errMsg;?></strong>

		</div>
		<?php }?>
		<div class="row-fluid">
			<div class="span12">
				<div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>
							<i class="icon-list"></i> 用户管理
						</h3>
					</div>
					<div class="widget-container">
						<div class="row-fluid">
							<div class="span6">
								<a type="button" class="btn btn-info"
									href='<?php echo site_url('portal/edituser');?>'><i
									class="icon-plus"></i> 添加用户</a>
							</div>
							<?php if(!in_array($_SESSION['XJTELEDH_USERROLE'],array('operator','city_admin'))){?>
							<div class="span4 btn btn-primary">
								<form id='formimport' class="form-horizontal" method='post'
									enctype="multipart/form-data">
									<div style="float: letf;">
										<input type="file" name="userfile" id='userfile'
											style="position: absolute; opacity: 0.6; left: 650px; top: 70px;" />
									</div>
									<div style="float: right;">
										<button type="submit" id='import' class="btn btn-info"
											name="import" value="importtodb">&nbsp;&nbsp;&nbsp;&nbsp;导入用户信息&nbsp;&nbsp;&nbsp;&nbsp;</button>
									</div>
								</form>
							</div>	
							<div class="span2">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<a href="/public/xls/user.xls" class="btn btn-primary" >&nbsp;&nbsp;&nbsp;&nbsp;下载用户信息模板&nbsp;&nbsp;&nbsp;&nbsp;</a>
							</div>					
						<?php }?>
						</div>
						<br>
						<table
							class="table table-bordered responsive table-striped table-sortable">
							<thead>
								<tr>
									<th>序号</th>
									<th>队伍名</th>
									<th>成员列表</th>

									<th>操作</th>
								</tr>
							</thead>
							<tbody>
							<?php $index = $offset + 1; foreach ($userList as $userObj){?>
							 <tr user_id='<?php echo htmlentities($userObj->id,ENT_COMPAT,"UTF-8");?>'>
									<td><?php echo $index++;?></td>
									<td><?php echo $userObj->name ?></td>
									<td><?php echo $userObj->member ?></td>
									<td width="15%">
									<a class="btn btn-info"
										href="<?php echo site_url("portal/edituser/".$userObj->id);?>"
										type="button"><i class="icon-pencil"></i> 编辑</a> <a
										class="btn btn-danger delete-user" href="#" type="button"><i
										class="icon-trash"></i> 删除</a>
									</td>


							       <?php if($_SESSION['XJTELEDH_USERROLE'] == 'operator'){?>
									<td><?php if($userObj->user_role == 'member' || $userObj->user_role == 'door_user'){?>
									<a class="btn btn-info"
										href="<?php echo site_url("portal/edituser/".$userObj->id);?>"
										type="button"><i class="icon-pencil"></i> 编辑</a> <a
										class="btn btn-danger delete-user" href="#" type="button"><i
										class="icon-trash"></i> 删除</a>
										 <?php }?>
									</td>
							       <?php }?>
							 <?php }?>
								</tr>
							</tbody>
						</table>
						<div class="row-fluid">
							<div class="span6">
							总计 <?php echo $count;?> 个用户信息
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
