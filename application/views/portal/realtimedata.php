<div class="main-wrapper">
	<div class="container-fluid">
		<div class="row-fluid ">
			<div class="span12">
				<div class="primary-head">
					<h3 class="page-header">管理面板</h3>
					<ul class="breadcrumb">
						<li>
                            <a class="icon-home" href="/"></a> <span class="divider"><i
								class="icon-angle-right"></i></span></li>
						<?php foreach ($bcList as $bcObj){?>
						<?php if($bcObj->isLast){?>	
						<li class="active">
                            <?php echo htmlentities($bcObj->title,ENT_COMPAT,"UTF-8");?>
                        </li>
						<?php }else {?>
						<li>
                            <a href='<?php echo htmlentities($bcObj->url,ENT_COMPAT,"UTF-8");?>'>
                                <?php echo htmlentities($bcObj->title,ENT_COMPAT,"UTF-8");?>
                            </a>
							<span class="divider"><i class="icon-angle-right"></i></span></li>
						<?php }?>
						<?php }?>
					</ul>
				</div>
			</div>
		</div>
		<script type='text/javascript'>
		   var model = '<?php echo $model;?>';
        </script>
		<div class="row-fluid">
			<div class="span12">
				<div class='row-fluid'>
					<div class="span12">
						<div class="span6">
							<h4>机房性能指标</h4>
						</div>
						<div class="span6">
						    <?php if($_SESSION['XJTELEDH_USERROLE'] != 'noc') {?>
							<a href='<?php echo site_url('portal/manageRoom?roomCode=' . htmlentities($roomObj->code,ENT_COMPAT,"UTF-8"));?>'
							   class="btn btn-info pull-right">添加机房性能指标</a><?php }?>
						</div>
					</div>
					<table
						class="paper-table table table-paper table-striped table-sortable">
						<thead>
							<tr>
								<th class='center'>序号</th>
								<th class='center'>指标标签</th>
								<th class='center'>性能指标</th>
							</tr>
						</thead>
						<tbody>
				          <?php $i=1; $piSettings = json_decode($roomObj->pi_setting,true); if(count($piSettings))
				          {foreach ($piSettings as $piObj){?>
				          <tr>
								<td class='center'><?php echo $i++;?></td>
								<td class='center'><?php $keys = array_keys($piObj); echo $keys[0];?></td>
								<td class='room_pi center'
									id='room_pi_<?php echo $piObj[$keys[0]];?>'
									pi_key='<?php echo $piObj[$keys[0]];?>'></td>
							</tr>
				          <?php }}else{?>
				          <tr>
								<td class='center' colspan="3">未设定性能指标</td>
							</tr>
				          <?php }?>
				    </tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class='span12'>
				<div class="tab-widget">
					<ul class="nav nav-tabs">
                	<?php if(isset($deviceContentHeader)){ echo $deviceContentHeader; } ?>
					</ul>
				</div>
			   <div class="tab-content">
   	  
				<?php if(isset($deviceContentBody)){ echo $deviceContentBody; } ?>
   	  			</div>				
			</div>
		</div>
  </div>
</div>
 
  
  
  <div class="modal fade bs-example-modal-lg" role="dialog"
		id='thresholdDialog'
		style="left: 50%; margin-left: -575px; width: 1150px; display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body modal-lg">
					<div class="row-fluid">
						<div class='span12'>
							<div class="content-widgets">
								<div class="content-box">
									<h4>已设置批量设置规则</h4>
									<table
										class="paper-table table table-paper table-striped table-sortable">
										<thead>
											<tr>
												<th>序号</th>
												<th>阀值类型</th>
												<th>阈值</th>
												<th>信号名称</th>
												<th>信号ID(4,5,6,7,8位)</th>
												<th>告警级别</th>
												<th>告警文本</th>
												<th>屏蔽状态</th>
												<th>超时(秒)</th>
												<th>操作</th>
											</tr>
										</thead>
										<tbody id="tbDevThreshold" val="<?php echo $subid;?>" >
										
										</tbody>
										<tbody id="tbDevThresholds">
										
										</tbody>
									</table>
									<h4>设备告警规则</h4>
									<span class='text-error'>*设置完毕，请点击"保存"按钮对所有修改进行保存</span>
									<p>阀值类型：上限：当采样值增加大于上限触发。下限：当采样值减少小于下限时触发。阈值：采样值等于阀值时候触发。</p>
									<div class="row-fluid">
										<div class='span6'>
											<button type="button" class="btn btn-primary"
												id="btnAddRule">新建告警规则</button>
										</div>
									</div>
									<br>
									<table									    
										class="paper-table table table-paper table-striped table-sortable">
										<thead>
											<tr>
												<th>序号</th>
												<th>阀值类型</th>
												<th>阈值</th>
												<th>信号名称</th>
												<th>信号ID(4,5,6,7,8位)</th>
												<th>告警级别</th>
												<th>告警文本</th>
												<th>屏蔽状态</th>
												<th>超时(秒)</th>
												<th>操作</th>
											</tr>
										</thead>
										<tbody id="tbRule">
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary"
						data-dismiss="modal">取消</button>
					<button type="button" class="btn btn-danger" id='btn-ok-check'>保存</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
</div>
  