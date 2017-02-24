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
			<div class="span6">
				<div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>动态设置参量列表————<?php echo htmlentities($devObj->name,ENT_COMPAT,"UTF-8");?></h3>
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
									<th>变量名</th>
									<th>表达式</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
							<?php $i = 1;foreach ($devDcList as $devDcObj){?>
							 <tr>
									<td><?php echo $i++;?></td>
									<td><?php echo htmlentities($devDcObj->dc_name,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($devDcObj->dc_script,ENT_COMPAT,"UTF-8");?></td>
									<td dc_id='<?php echo htmlentities($devDcObj->id,ENT_COMPAT,"UTF-8");?>'
										data_id="<?php echo htmlentities($devDcObj->data_id,ENT_COMPAT,"UTF-8"); ?>">
										<button type="button" class="btn btn-info btn-edit">
											<i class="icon-edit"></i> 编辑
										</button>
										<button type="button" class="btn btn-primary btn-setalarm">
											<i class="icon-wrench"></i> 设置告警规则
										</button>
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
			<div class="span6">
				<div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>
							告警配置<span id='alarmSettingTitle'></span>
						</h3>
					</div>
					<div class="widget-container" id='dcSignalArea'>
						<div class="row-fluid">
							<button class="btn btn-info hide" id='btn-addAlarmRule'>
								<i class='icon icon-plus'></i>添加告警配置
							</button>
						</div>
						<br>
					<?php foreach ($devDcList as $devDcObj){?>
					   <table
							class="table table-bordered responsive table-striped table-sortable"
							id='tbSignal-<?php echo htmlentities($devDcObj->id,ENT_COMPAT,"UTF-8");?>' style='display: none;'>
							<thead>
								<tr>
									<th>序号</th>
									<th>告警级别</th>
									<th>信号名称</th>
									<th>信号ID</th>
									<th>运算符号</th>
									<th>比较值</th>
									<th>告警信息</th>
									<th>延时(秒)</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
							<?php $i = 1; $configList = json_decode($devDcObj->dc_config); foreach ($configList as $configObj){?>
							 <tr>
									<td class="center"><?php echo $i++;?></td>
									<td class="center" level='<?php echo htmlentities($configObj->level,ENT_COMPAT,"UTF-8");?>'>
							         <?php
            
            switch ($configObj->level) {
                case 0:
                    echo '正常';
                    break;
                case 1:
                    echo '一级告警';
                    break;
                case 2:
                    echo '二级告警';
                    break;
                case 3:
                    echo '三级告警';
                    break;
                case 4:
                    echo '四级告警';
                    break;
            }
            ?>
						         </td>
									<td class="center"><?php echo htmlentities($configObj->signal_name,ENT_COMPAT,"UTF-8");?></td>
									<td class="center"><?php echo htmlentities($configObj->signal_id,ENT_COMPAT,"UTF-8");?></td>
									<td class="center" op="<?php echo htmlentities($configObj->op,ENT_COMPAT,"UTF-8"); ?>"><?php echo htmlentities($configObj->op,ENT_COMPAT,"UTF-8");?></td>
									<td class="center"><?php echo htmlentities($configObj->value,ENT_COMPAT,"UTF-8");?></td>
									<td class="center"><?php echo htmlentities($configObj->msg,ENT_COMPAT,"UTF-8");?></td>
									<td class="center"><?php echo htmlentities($configObj->time,ENT_COMPAT,"UTF-8");?></td>									
									<td class="center">
										<div class="btn-toolbar row-action">
											<div class="btn-group">
												<button class="btn btn-info dv_btn_edit"
													data-original-title="修改">
													<i class="icon-edit"></i>
												</button>
												<button class="btn btn-inverse hide dv_btn-inverse"
													data-original-title="取消">
													<i class=" icon-remove-sign"></i>
												</button>
												<button
													class="btn btn-success hide dv_btn-success dv_btn_save"
													data-original-title="保存">
													<i class=" icon-ok"></i>
												</button>
												<button class="btn btn-danger dv_btn_del" title="删除">
													<i class="icon-remove"></i>
												</button>
											</div>
										</div>
									</td>
								</tr>
							 <?php }?>
							</tbody>
						</table>						
						 <?php }?>
					</div>
					<div class="form-actions">
						<button class="btn btn-success hide" id='btn-saveAlarmRule'>
							<i class='icon icon-ok'></i>保存告警配置
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade bs-example-modal-lg" role="dialog"
	id='dynamicSettingDlg'
	style="left: 50%; margin-left: -575px; width: 1150px; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h3>动态设置</h3>
			</div>
			<div class="modal-body modal-lg">
				<div class="row-fluid">
					<div class='span6'>
						<div class="content-widgets">
							<div class="widget-header-block">
								<h5 class="widget-header">
									<i class="icon-table"></i> 设备列表
								</h5>
							</div>
							<div class="content-box"
								style='max-height: 250px; overflow-y: auto;'>
								<table
									class="paper-table table table-paper table-striped table-sortable"
									id='tbDevType'>
									<thead>
										<tr>
											<td>序号</td>
											<td>设备名称</td>
											<td>选择</td>
										</tr>
									</thead>
									<tbody>
							         <?php $i = 0; foreach ($devList as $devObj){ if(in_array($devObj->model, array('water','temperature','humid','smoke'))) continue;?>
							             <tr>
											<td><?php echo ++$i;?></td>
											<td><?php echo htmlentities($devObj->name,ENT_COMPAT,"UTF-8");?>--<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?></td>
											<td><input type="radio" class='rChoose' name='radio_device'
												dev_model='<?php echo htmlentities($devObj->model,ENT_COMPAT,"UTF-8")?>'
												data_id='<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8");?>'></td>
										</tr>
						             <?php }?>
							         </tbody>
								</table>
							</div>
						</div>
					</div>
					<div class='span6'>
						<div class="content-widgets">
							<div class="widget-header-block">
								<h5 class="widget-header">
									<i class="icon-table"></i> 信号选择列表
								</h5>
							</div>
							<div class="content-box"
								style='max-height: 250px; overflow-y: auto;'>
								<table
									class="paper-table table table-paper table-striped table-sortable"
									id='tbSignal'>
									<thead>
										<tr>
											<td>序号</td>
											<td>信号</td>
											<td>选择</td>
										</tr>
									</thead>
									<tbody>

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class='span4'>
						<span>信号告警过滤名称</span> <input type="text" id='txtDcName'>
					</div>
					<div class='span8'>
						<span>信号告警过滤表达式</span> <input type="text" class='span10'
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
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-danger" id='btn-save'>保存</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
