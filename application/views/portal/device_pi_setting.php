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
				<div class="switch-board gray">
					<ul class="clearfix switch-item">
						<li><a class=" magenta"
							href="<?php echo site_url("portal/device_pi_setting/imem_12"); ?>"><i
								class="icon-bar-chart"></i><span>智能电表</span></a></li>
						<li><a class=" magenta"
							href="<?php echo site_url("portal/device_pi_setting/battery_24"); ?>"><i
								class="icon-bar-chart"></i><span>24节电池组</span></a></li>
						<li><a class=" magenta"
							href="<?php echo site_url("portal/device_pi_setting/battery_32"); ?>"><i
								class="icon-bar-chart"></i><span>32节电池组</span></a></li>
						<li><a class=" magenta"
							href="<?php echo site_url("portal/device_pi_setting/psma-ac"); ?>"><i
								class="icon-bar-chart"></i><span>PSMA-AC</span></a></li>
						<li><a class=" magenta"
							href="<?php echo site_url("portal/device_pi_setting/psma-rc"); ?>"><i
								class="icon-bar-chart"></i><span>PSMA-RC</span></a></li>
						<li><a class=" magenta"
							href="<?php echo site_url("portal/device_pi_setting/psma-dc"); ?>"><i
								class="icon-bar-chart"></i><span>PSMA-DC</span></a></li>
						<li><a class=" magenta"
							href="<?php echo site_url("portal/device_pi_setting/fresh_air"); ?>"><i
								class="icon-bar-chart"></i><span>新风空调</span></a></li>
						<li><a class=" magenta"
							href="<?php echo site_url("portal/device_pi_setting/liebert-ups"); ?>"><i
								class="icon-bar-chart"></i><span>liebert UPS</span></a></li>
					</ul>
				</div>

			</div>
		</div>
		<div class='row-fluid'>
			<div class="span12">
				<div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>
							<i class="icon-bookmark-empty"></i>
						  <?php if($mode == "battery_24"){ ?>
		    		      	  		2V × 24电池组监控可供使用的变量
		    		      	 	<?php }else if($mode == "battery_32"){ ?>
		    		      	 		12V x 32电池组监控可使用的变量
		    		      	 	<?php } ?> 
						</h3>
					</div>
					<div class="widget-container">
						<form method='post'>
							<input type="hidden" id="hdType" value="<?php echo $mode; ?>" />
							<input type="submit" id="btnSaveAll"
								class="btn btn-success btn-large" value="保存所有设置" /> <br> <br>
							<h4>性能指标执行代码(LUA)：</h4>
							<h5>全局区：(代码只运算一次,适合初始化全局变量和函数)</h5>
							<textarea id="piGlobal" name="piGlobal" rows="8" class="span12"><?php if(count($piObj)){ echo htmlentities($piObj->global,ENT_COMPAT,"UTF-8"); } ?></textarea>
							<h5>运算区: (代码每次都运算)</h5>
							<textarea id="piScript" name="piScript" rows="8" class="span12"><?php if(count($piObj)){ echo htmlentities($piObj->script,ENT_COMPAT,"UTF-8"); } ?></textarea>
							<button id="addPi" type="button"
								class="btn btn-small btn-info dataTables_filter">
								<i class="icon-plus icon-white"></i> 添加性能指标
							</button>
							<table
								class="paper-table table table-paper table-striped table-sortable">
								<thead>
									<tr>
										<th width="50">序号</th>
										<th width="100">性能指标变量名</th>
										<th width="200">性能指标变量标签</th>
										<th width="100">操作</th>
									</tr>
								</thead>
								<tbody id="piTable">
    		                  <?php $i = 1 ;foreach ($varList as $varObj){?>
    		                      <tr>
										<td><?php echo $i++; ?></td>
										<td><input name="piName[]" type="text"
											value="<?php echo htmlentities($varObj->name,ENT_COMPAT,"UTF-8"); ?>" readonly /></td>
										<td><input name="piLabel[]" type="text"
											value="<?php echo htmlentities($varObj->label,ENT_COMPAT,"UTF-8"); ?>" readonly /></td>
										<td>
											<div class="btn-toolbar row-action">
												<div class="btn-group">
													<button style="display: none" type="button"
														class="btn btn-inverse" data-original-title="取消">
														<i class=" icon-remove-sign"></i>
													</button>
													<button style="display: none" type="button"
														class="btn btn-success" data-original-title="保存">
														<i class=" icon-ok"></i>
													</button>
													<button class="btn btn-info btn_edit" type="button"
														title="修改">
														<i class="icon-edit"></i>
													</button>
													<button class="btn btn-danger" type="button" title="删除">
														<i class="icon-remove"></i>
													</button>
												</div>
											</div>
										</td>
									</tr>
    		                  <?php }?>
    		                  </tbody>
							</table>
							<button id="addAlert" type="button"
								class="btn btn-small btn-info dataTables_filter">
								<i class="icon-plus icon-white"></i> 添加告警变量
							</button>
							<table
								class="paper-table table table-paper table-striped table-sortable">
								<thead>
									<tr>
										<th width="50">序号</th>
										<th width="100">告警变量名</th>
										<th width="100">告警变量标签</th>
										<th width="300">信号名称</th>
										<th width="300">信号ID</th>
										<th width="100">告警级别</th>
										<th width="300">告警文本</th>
										<th width="100">操作</th>
									</tr>
								</thead>
								<tbody id="alertTable">
		                  <?php $i = 1 ;foreach ($alertList as $alertObj){?>
		                      <tr>
										<td><?php echo $i++; ?></td>
										<td><input name="alertName[]" type="text"
											value="<?php echo htmlentities($alertObj->name,ENT_COMPAT,"UTF-8"); ?>" readonly class="span" /></td>
										<td><input name="alertLabel[]" type="text"
											value="<?php echo htmlentities($alertObj->label,ENT_COMPAT,"UTF-8"); ?>" readonly class="span" /></td>
										<td><input name="signalName[]" type="text"
											value="<?php echo htmlentities($alertObj->signal_name,ENT_COMPAT,"UTF-8"); ?>" readonly
											class="span" /></td>
										<td><input name="signalId[]" type="text"
											value="<?php echo htmlentities($alertObj->signal_id,ENT_COMPAT,"UTF-8"); ?>" readonly
											class="span" /></td>
										<td><input type="hidden" name="alertLevel[]"
											value="<?php echo htmlentities($alertObj->level,ENT_COMPAT,"UTF-8"); ?>" /> <select disabled
											class="span">
												<option value="1"
													<?php if($varObj->type == "1"){ echo "selected"; } ?>>一级告警</option>
												<option value="2"
													<?php if($varObj->type == "2"){ echo "selected"; } ?>>二级告警</option>
												<option value="3"
													<?php if($varObj->type == "3"){ echo "selected"; } ?>>三级告警</option>
												<option value="4"
													<?php if($varObj->type == "4"){ echo "selected"; } ?>>四级告警</option>
										</select></td>
										<td><input name="alertMsg[]" type="text"
											value="<?php echo htmlentities($alertObj->msg,ENT_COMPAT,"UTF-8"); ?>" readonly class="span" /></td>
										<td><div class="btn-toolbar row-action">
												<div class="btn-group">
													<button style="display: none" type="button"
														class="btn btn-inverse alert-btn-inverse"
														data-original-title="取消">
														<i class=" icon-remove-sign"></i>
													</button>
													<button style="display: none" type="button"
														class="btn btn-success alert-btn-success"
														data-original-title="保存">
														<i class=" icon-ok"></i>
													</button>

													<button class="btn btn-info alert-btn_edit" type="button"
														title="修改">
														<i class="icon-edit"></i>
													</button>
													<button class="btn btn-danger alert-btn-danger"
														type="button" title="删除">
														<i class="icon-remove"></i>
													</button>
												</div>
											</div></td>
									</tr>
		                  <?php }?>
		                  </tbody>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
