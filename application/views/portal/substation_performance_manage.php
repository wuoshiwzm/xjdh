
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
		      <div class='span3'>
				<div class="content-widgets">
					<div class="widget-header-block">
						<h3>局站列表</h3>
						<div class="content-box">
						<input type="text" value=""
							style="box-shadow: inset 0 0 4px #eee; margin: 0; padding: 6px 12px; border-radius: 4px; border: 1px solid silver; font-size: 1.1em;"
							id="areaQuery" placeholder="搜索" />
						<div id='pwTree'></div>
					   </div>
						<div id='area-tree' style="max-height: 500px; overflow-y: auto;">									
						</div>
					</div>					
				</div>
			</div>
			<div class="span9">
				<div class="widget-container" 
						id='search-area'>	
					</div>
					<div class="widget-head bondi-blue">
						<?php if($substation_id!=0 && !strpos($string,"#")){?>
						   <h3><?php  echo $substationObj->name ?>&nbsp&nbsp 性能管理指标列表</h3>
					    <?php }else {?>
					       <h3>请单击局站以显示列表</h3>
					    <?php }?>   
					</div>
					<?php if($substation_id!=0 && !strpos($string,"#")){?>
					<div class="widget-container">
					<div class="row-fluid">
							<div class="span6">
								<a type="button" class="btn btn-info"
								   href='<?php echo site_url('portal/perforSetting/'.$substation_id);?>'><i
								   class="icon-plus"></i> 添加局站性能管理评估规则</a>
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
									<th>指标值</th>
									<th>当前状态</th>
									<th>操作</th>	
								</tr>
							</thead>
							<tbody  id="perforList">
							   <?php $n = 0; ?>
					           <?php $i = $offset + 1; foreach($perforList as $perforObj){ ?>	
					             	<?php $value = $index_value[$n]; $n = $n + 1; ?> 
							     <tr id='<?php echo htmlentities($perforObj->perfor_id,ENT_COMPAT,"UTF-8");?>'
							         substation_id='<?php echo $substation_id;?>' >
							        <td><?php echo $i++;?></td>
									<td><?php echo htmlentities($perforObj->major,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($perforObj->device_type,ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities($perforObj->quota,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($perforObj->day,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($perforObj->night,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($perforObj->cycle,ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities($perforObj->output_device,ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities($perforObj->value,ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities($perforObj->state,ENT_COMPAT,"UTF-8"); ?></td>
									<td>
										<button type="button"
										class="btn btn-warning block-alert setting">添加指标值</button>
									</td>
								</tr>
							 <?php }?>
							</tbody>
						</table>
						<div class="row-fluid">
							<div class="span6">
                                                                 总计 <?php echo $count;?> 条数据
                            </div>
					</div>
					<?php }?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade bs-example-modal-lg" role="dialog"
	id='settingDialog' style="display: none;width:600px;left:40%;">
	<div class="modal-dialog">
		<div class="modal-header">
			<h3>设置指标值</h3>
		</div>
		<div class="modal-content">
			<div class="modal-body modal-lg">
				<div class="row-fluid">
					<div class='span12'>
						<div class="content-widgets">
							<div class="content-box form-horizontal"  id='network'>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
			<button type="button" class="btn btn-danger" id='btn-ok-check'>保存</button>
		</div>
	</div>
</div>
