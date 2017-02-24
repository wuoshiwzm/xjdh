<div class="main-wrapper">
	<div class="container-fluid">
	<?php if(!isset($isWap) || $isWap == FALSE){?>
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
								<span>总计 <?php echo count($userList);?> 位用户在线</span>
							</div>
						</div>
						<br>
						<table
							class="table table-bordered responsive table-striped table-sortable">
							<thead>
								<tr>
									<th>序号</th>
									<th>用户名</th>
									<th>姓名</th>
									<th>性别</th>
									<th>手机号</th>
									<th>分公司</th>
									<th>用户角色</th>
									<th>登录状态</th>
								</tr>
							</thead>
							<tbody>
							<?php $index = 1; foreach ($userList as $userObj){?>
							 <tr user_id='<?php echo htmlentities($userObj->id,ENT_COMPAT,"UTF-8");?>'>
									<td><?php echo $index++;?></td>
									<td><?php echo htmlentities($userObj->username,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($userObj->full_name,ENT_COMPAT,"UTF-8");?></td>
									<td><?php if($userObj->gender == 'male') echo '男'; else echo '女';?></td>
									<td><?php echo htmlentities($userObj->mobile,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities(Defines::$gCity[$userObj->city_code],ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities(Defines::$gUserRole[$userObj->user_role],ENT_COMPAT,"UTF-8");?></td>
									<td>
										<table>
											<tbody>
				                        <?php foreach (Defines::$gPlatform as $key=>$val){ if($userObj->$key != FALSE){?>
				                        <tr>
													<td><?php echo $val;?>在线</td>
													<td><?php echo htmlentities($userObj->$key,ENT_COMPAT,"UTF-8");?></td>
												</tr>
        							     <?php } }?>
				                        </tbody>
										</table>

									</td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
setInterval("window.location.reload()",30000);
</script>
