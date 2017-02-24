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
						<h3>设备列表</h3>
					</div>
					<div class="widget-container">
					  <h4>设备与机房不匹配:</h4>
					  	<table id="dataTable"
							class="table table-bordered responsive table-striped">
							<thead>
								<tr>
									<th>序号</th>
									<th>分公司</th>
									<th>区域</th>
									<th>机房</th>
									<th>采集单元</th>
									<th>设备名</th>
									<th>数据ID</th>
									<th>设备类型</th>
									<th>物理端口号</th>
									<th>逻辑参数</th>
									<th>是否激活</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
							<?php $i = 1; foreach ($RoomDeviceObj as $devObj){?>
							<tr device_id='<?php echo htmlentities($devObj->id,ENT_COMPAT,"UTF-8"); ?>'>
									<td><?php echo $i++;?></td>
									<td><?php echo htmlentities(Defines::$gCity[$devObj->city_code],ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities(Defines::$gCounty[$devObj->city_code][$devObj->county_code],ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($devObj->room_name,ENT_COMPAT,"UTF-8");?></td>
									<td><a data-rel="popover"
										data-content="<?php echo "IP：" . htmlentities($devObj->ip,ENT_COMPAT,"UTF-8");?>"
										data-placement="top" href="###" data-original-title="采集设备信息"><?php echo '(' . htmlentities($devObj->smd_device_no,ENT_COMPAT,"UTF-8") . ')' . htmlentities($devObj->smd_device_name,ENT_COMPAT,"UTF-8");?></a></td>
									<td><a href="/portal/realtimedata/<?php echo htmlentities($devObj->room_id,ENT_COMPAT,"UTF-8");?>/<?php echo $devModelGroup[$devObj->model]; ?>/<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8"); ?>" data_id='<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?>'><?php echo htmlentities($devObj->name,ENT_COMPAT,"UTF-8");?></a></td>
									<td><?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo Defines::$gDevModel[$devObj->model]; ?></td>
									<td>
							         <?php
        if (in_array($devObj->model, array('water','smoke')))
            echo '开关量DI-' . $devObj->port;
        else 
            if (in_array($devObj->model, array('temperature','humid')))
                echo '模拟量AD-' . $devObj->port;
            else
                echo '串口UART-' . $devObj->port;
        ?>
						         </td>
									<td><?php echo htmlentities($devObj->extra_para,ENT_COMPAT,"UTF-8"); ?></td>
									<td><a href='#'><?php if($devObj->active){?><span
											class="label label-success dev-lock">已激活</span><?php }else{?><span
											class="label label-warning dev-unlock">未激活</span><?php }?></a>
									</td>
									<td>
										<div class="btn-toolbar row-action">
											<div class="btn-group">
												<button class="btn btn-info" data-original-title="编辑"
													onclick='location.href="/portal/edit_device/1?data_id=<?php echo $devObj->data_id;?>"'>
													<i class="icon-edit"></i>
												</button>
												<button class="btn btn-danger delete-dev"
													data-original-title="删除">
													<i class="icon-remove"></i>
												</button>
											</div>
										</div>
									</td>
								</tr>
							<?php }?>
							</tbody>
						</table>	
					</div>
					<div class="widget-container">
					  <h4>设备与采集板不匹配:</h4>
					  	<table id="dataTable"
							class="table table-bordered responsive table-striped">
							<thead>
								<tr>
									<th>序号</th>
									<th>分公司</th>
									<th>区域</th>
									<th>机房</th>
									<th>采集单元</th>
									<th>设备名</th>
									<th>数据ID</th>
									<th>设备类型</th>
									<th>物理端口号</th>
									<th>逻辑参数</th>
									<th>是否激活</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
							<?php $i = 1; foreach ($RoomSmdDeviceObj as $devObj){?>
							<tr device_id='<?php echo htmlentities($devObj->id,ENT_COMPAT,"UTF-8"); ?>'>
									<td><?php echo $i++;?></td>
									<td><?php echo htmlentities(Defines::$gCity[$devObj->city_code],ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities(Defines::$gCounty[$devObj->city_code][$devObj->county_code],ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($devObj->room_name,ENT_COMPAT,"UTF-8");?></td>
									<td><a data-rel="popover"
										data-content="<?php echo "IP：".htmlentities($devObj->ip,ENT_COMPAT,"UTF-8");?>"
										data-placement="top" href="###" data-original-title="采集设备信息"><?php echo '('.htmlentities($devObj->smd_device_no,ENT_COMPAT,"UTF-8").')'.htmlentities($devObj->smd_device_name,ENT_COMPAT,"UTF-8");?></a></td>
									<td><a href="###" data_id='<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?>'><?php echo htmlentities($devObj->name,ENT_COMPAT,"UTF-8");?></a></td>
									<td><?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo Defines::$gDevModel[$devObj->model]; ?></td>
									<td>
							         <?php
        if (in_array($devObj->model, array('water','smoke')))
            echo '开关量DI-' . $devObj->port;
        else 
            if (in_array($devObj->model, array('temperature','humid')))
                echo '模拟量AD-' . $devObj->port;
            else
                echo '串口UART-' . $devObj->port;
        ?>
						         </td>
									<td><?php echo htmlentities($devObj->extra_para,ENT_COMPAT,"UTF-8"); ?></td>
									<td><a href='#'><?php if($devObj->active){?><span
											class="label label-success dev-lock">已激活</span><?php }else{?><span
											class="label label-warning dev-unlock">未激活</span><?php }?></a>
									</td>
									<td>
										<div class="btn-toolbar row-action">
											<div class="btn-group">
												<button class="btn btn-info" data-original-title="编辑"
													onclick='location.href="/portal/edit_device/1?data_id=<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?>"'>
													<i class="icon-edit"></i>
												</button>
												<button class="btn btn-danger delete-dev"
													data-original-title="删除">
													<i class="icon-remove"></i>
												</button>
											</div>
										</div>
									</td>
								</tr>
							<?php }?>
							</tbody>
						</table>	
					</div>
					<div class="widget-container">
					  <h4>采集板与机房不匹配:</h4>
					  	<table id="dataTable"
							class="table table-bordered responsive table-striped">
							<thead>
								<tr>
									<th>序号</th>
									<th>分公司</th>
									<th>区域</th>
									<th>机房</th>
									<th>采集单元</th>
									<th>设备名</th>
									<th>数据ID</th>
									<th>设备类型</th>
									<th>物理端口号</th>
									<th>逻辑参数</th>
									<th>是否激活</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
							<?php $i = 1; foreach ($SmdDeviceObj as $devObj){?>
							<tr device_id='<?php echo htmlentities($devObj->id,ENT_COMPAT,"UTF-8"); ?>'>
									<td><?php echo $i++;?></td>
									<td><?php echo htmlentities(Defines::$gCity[$devObj->city_code],ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities(Defines::$gCounty[$devObj->city_code][$devObj->county_code],ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($devObj->room_name,ENT_COMPAT,"UTF-8");?></td>
									<td><a data-rel="popover"
										data-content="<?php echo "IP：".htmlentities($devObj->ip,ENT_COMPAT,"UTF-8");?>"
										data-placement="top" href="###" data-original-title="采集设备信息"><?php echo '('.htmlentities($devObj->smd_device_no,ENT_COMPAT,"UTF-8").')'.htmlentities($devObj->smd_device_name,ENT_COMPAT,"UTF-8");?></a></td>
									<td><a href="###" data_id='<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?>'><?php echo htmlentities($devObj->name,ENT_COMPAT,"UTF-8");?></a></td>
									<td><?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo Defines::$gDevModel[$devObj->model]; ?></td>
									<td>
							         <?php
								        if (in_array($devObj->model, array('water','smoke')))
								            echo '开关量DI-' . $devObj->port;
								        else 
								            if (in_array($devObj->model, array('temperature','humid')))
								                echo '模拟量AD-' . $devObj->port;
								            else
								                echo '串口UART-' . $devObj->port;
								        ?>
						         </td>
									<td><?php echo htmlentities($devObj->extra_para,ENT_COMPAT,"UTF-8"); ?></td>
									<td><a href='#'><?php if($devObj->active){?><span
											class="label label-success dev-lock">已激活</span><?php }else{?><span
											class="label label-warning dev-unlock">未激活</span><?php }?></a>
									</td>
									<td>
										<div class="btn-toolbar row-action">
											<div class="btn-group">
												<button class="btn btn-info" data-original-title="编辑"
													onclick='location.href="/portal/edit_device/1?data_id=<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?>"'>
													<i class="icon-edit"></i>
												</button>
												<button class="btn btn-danger delete-dev"
													data-original-title="删除">
													<i class="icon-remove"></i>
												</button>
											</div>
										</div>
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
</div>
</div>
<div class="modal fade bs-example-modal-lg" role="dialog" id='roomPiDlg'>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h3>编辑性能指标</h3>
			</div>
			<div class="modal-body modal-lg">
				<h4>设置完毕，请点击"保存"按钮对所有修改进行保存</h4>
				<div class="row-fluid">
					<div class="span6">
						<button type="button" class="btn btn-primary" id="btnAddPi">新建性能指标</button>
					</div>
				</div>
				<br>
				<table
					class="paper-table table table-paper table-striped table-sortable">
					<thead>
						<tr>
							<th>序号</th>
							<th>性能指标变量标签</th>
							<th>性能指标变量名</th>
							<th>删除</th>
						</tr>
					</thead>
					<tbody id="tbRoomPi">
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-danger" id='btn-ok'>保存</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

