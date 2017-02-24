<script type="text/javascript">
var substation_id = <?php echo json_encode($substation_id);?>;
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
						<h3>动态设置参量列表</h3>
					</div>
					<div class="widget-container">

						<div class="row-fluid">
							<button data_id='<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?>'
								class="btn btn-info" id='btn-addConfig'>
								<i class='icon icon-plus'></i>添加参量
							</button>
						</div>
						<br>
						<table
							class="table table-bordered responsive table-striped table-sortable">
							<thead>
								<tr>
									<th>序号</th>
									<th>表达式</th>
									<th>值</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
							<?php $i = 1;foreach ($perforSubList as $perforSubObj){?>
							 <tr>
									<td><?php echo $i++;?></td>
									<td><?php echo htmlentities($perforSubObj->nk_script,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($perforSubObj->nk_value,ENT_COMPAT,"UTF-8");?></td>
									<td nk_id='<?php echo htmlentities($perforSubObj->nk_id,ENT_COMPAT,"UTF-8");?>'
										substation_id="<?php echo $substation_id; ?>">
										<button type="button" class="btn btn-info btn-edit">
											<i class="icon-edit"></i> 编辑
										</button>
<!-- 										<button type="button" class="btn btn-primary btn-setalarm"> -->
<!-- 											<i class="icon-wrench"></i> 设置告警规则 -->
<!-- 										</button> -->
										<button class="btn btn-danger btn-del">
											<i class="icon-remove"></i> 删除
										</button>
									</td>
								</tr>
							 <?php }?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

<div class="modal fade bs-example-modal-lg" role="dialog"
	id='dynamicSettingDlg'
   style="left: 50%; margin-left: -575px; width: 1150px; display: none;" 
	>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h3>动态设置</h3>
			</div>
			<div class="modal-body modal-lg">
				<div class="row-fluid">
					<div class='span12'>
						<div class="content-widgets">
							<div class="widget-header-block">
								<h5 class="widget-header">
									<i class="icon-table"></i> 设备列表
								</h5>
							</div>
							<div class="content-box"
								style='max-height: auto; overflow-y: auto;'>
								<table
									class="paper-table table table-paper table-striped table-sortable"
									id='tbDevType'>
									<thead>
										<tr>
											<td>序号</td>
											<td>设备类型</td>
											<td>指标</td>											
											<th>阀值白天</th>
									        <th>阀值夜间</th>
											<td>指标值</td>
											<td>选择</td>
										</tr>
									</thead>
									<tbody>
							         <?php $i = 0; foreach ($devList as $devObj){?>
							             <tr>
											<td><?php echo ++$i;?></td>
											<td><?php echo htmlentities($devObj->device_type,ENT_COMPAT,"UTF-8");?></td>
											<td><?php echo htmlentities($devObj->quota,ENT_COMPAT,"UTF-8");?></td>
											<td><?php echo htmlentities($devObj->day,ENT_COMPAT,"UTF-8");?></td>
									        <td><?php echo htmlentities($devObj->night,ENT_COMPAT,"UTF-8");?></td>
											<td><?php echo htmlentities($devObj->value,ENT_COMPAT,"UTF-8");?></td>
											<td><input type="radio" class='rChoose' name='radio_device'
												substation_id='<?php echo $substation_id;?>'
												value='<?php echo htmlentities($devObj->value,ENT_COMPAT,"UTF-8");?>'
												perfortype='<?php echo htmlentities($devObj->device_type,ENT_COMPAT,"UTF-8");?>'></td>
										</tr>
						             <?php }?>
							         </tbody>
								</table>
							</div>
						</div>
					</div>
				<div class="row-fluid">
					<div class='span8'>
						<span>局站安全评估规则</span> <input type="text" class='span10'
							id='txtDcScript'>
					</div>
					<div class='span8'>
						<span class="control-label">运算符</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<div class="btn-group">
							<button class="btn btn-info btn-op">+</button>
							<button class="btn btn-info btn-op">-</button>
							<button class="btn btn-info btn-op">*</button>
							<button class="btn btn-info btn-op">/</button>
							<button class="btn btn-info btn-op">&gt;</button>
							<button class="btn btn-info btn-op">==</button>
							<button class="btn btn-info btn-op">&gt;=</button>
							<button class="btn btn-info btn-op">&lt;</button>
							<button class="btn btn-info btn-op">&lt;=</button>
							<button class="btn btn-info btn-op">and</button>
							<button class="btn btn-info btn-op">or</button>
							<button class="btn btn-info btn-op">not</button>
							<button class="btn btn-info btn-op">(</button>
							<button class="btn btn-info btn-op">)</button>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-danger" id='btn-save'>保存</button>
			</div>
			</div>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
