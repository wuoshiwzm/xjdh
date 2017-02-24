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
							<div class="control-group">
								<label class="control-label" style="float: left;">设备类型</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='device_type' id='device_type'
										value='<?php  echo $device_type;?>' />
								</div>					
							<div class="control-group">
								<label class="control-label" style="float: left;">指标</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='quota' id='quota'
										value='<?php  echo $quota;?>' />
								</div>					
							</div>	
							<div class="control-group">
								<label class="control-label" style="float: left;">输出设备</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='output_device' id='output_device'
										value='<?php  echo $output_device;?>' />
								</div>					
							<div class="control-group">
								<label class="control-label" style="float: left;">采集方式</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='acquisition_methods' id='acquisition_methods'
										value='<?php  echo $acquisition_methods;?>' />
								</div>					
							</div>	
							<div class="form-actions">
							<button class="btn btn-success" type="submit" id='btn-submit'>提交</button>
							</div>
						</form>
					</div>
				</div>
			</div>
	
		<div class="row-fluid">
			<div class="span12">
				<div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>查询列表</h3>
					</div>
					<div class="widget-container">
					<div class="row-fluid">
							<div class="span6">
								<a type="button" class="btn btn-info"
									href='<?php echo site_url('portal/edit_perfor');?>'><i
									class="icon-plus"></i> 添加性能列表</a>
							</div>
						</div>
						<table class="table table-bordered responsive table-striped">
							<thead>
								<tr>
									<th>序号</th>
									<th>专业</th>
									<th>设备类型</th>
									<th>指标</th>
									<th>阀值白天</th>
									<th>阀值夜间</th>
									<th>采集周期</th>
									<th>输出设备</th>
									<th>采集方式</th>
									<th>类型</th>
									<th>责任单位</th>
									<th>设定依据</th>
									<th>输出方式</th>
									<th>指标配置</th>
									<th>操作</th>	
								</tr>
							</thead>
							<tbody>
					           <?php $i = $offset + 1; foreach($perforList as $perforObj){ ?>		 
							     <tr id='<?php echo htmlentities($perforObj->id,ENT_COMPAT,"UTF-8");?>'>
							        <td><?php echo $i++;?></td>
									<td><?php echo htmlentities($perforObj->major,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($perforObj->device_type,ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities($perforObj->quota,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($perforObj->day,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($perforObj->night,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($perforObj->cycle,ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities($perforObj->output_device,ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities($perforObj->acquisition_methods	,ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities($perforObj->type,ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities($perforObj->responsible,ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities($perforObj->set_basis,ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities($perforObj->output_mode,ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities($perforObj->config,ENT_COMPAT,"UTF-8"); ?></td>
									<td>
										<div class="btn-toolbar row-action">
											<div class="btn-group">
												<button class="btn btn-info" data-original-title="编辑"
													onclick='location.href="/portal/edit_perfor/<?php echo htmlentities($perforObj->id,ENT_COMPAT,"UTF-8");?>"'>
													<i class="icon-edit"></i>
												</button>
												<button class="btn btn-danger deleteperfor"
													data-original-title="删除">
													<i class="icon-remove"></i>
												</button>
											</div>
										</div>
									</td>
								</tr>
							 <?php }?>
							</tbody>
							</tbody>
						</table>
						<div class="row-fluid">
							<div class="span6">
                                                                   总计 <?php echo $count;?> 个性能列表
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

