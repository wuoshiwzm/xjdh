<script type="text/javascript">
var modelList = <?php echo json_encode(Defines::$gDevModel); ?>;
var aa=<?php echo json_encode($aa);?>;
var parkey=<?php echo json_encode($parkey);?>;
var selSubstation=<?php echo json_encode($selSubstation);?>;
var selCity=<?php echo json_encode($selCity);?>;
var gDeviceThresholdParam = <?php echo json_encode(Defines::$gDeviceThresholdParams);?>;
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
		<div class="row-fluid" id="query">
			<div class="span12">
				<div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>
							<i class="icon-search"></i> 综合查询
						</h3>
					</div>
					<div class="widget-container">
						<form class="form-horizontal">
							<div class="control-group"> 
								<label class="control-label" style="float: left;">所属分公司</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择分公司"
										name='selCity' id='selCity'>
									    <?php if($userObj->user_role == "admin"){?>
    							        <option value=''>全网</option>
    							        <?php foreach (Defines::$gCity as $cityKey=>$cityVal){?>
							            <option value='<?php echo $cityKey;?>'
											<?php  if($selCity == $cityKey){?> selected="selected"
											<?php }?>><?php echo $cityVal;?>本地网</option>
    							        <?php }?>
    							        <?php }else if($userObj->user_role == "city_admin"){ ?>
    							        <option value="<?php echo $userObj->city_code; ?>">
    							            <?php echo Defines::$gCity[$userObj->city_code]; ?></option>
    							        <?php }?>
    								</select>
								</div>
								<label class="control-label" style="float: left;">区域</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择区域"
										name='selCounty' id='selCounty'>
										<?php if($userObj->user_role == "city_admin"){ ?>
											<option value="0">所有区域</option>
											<?php foreach (Defines::$gCounty[$userObj->city_code] as $key=> $val){?>
										    <option value='<?php echo $key;?>'
												<?php if($selCounty == $key){?>selected="selected"<?php }?>>
												<?php echo $val;?></option>
									        <?php } ?>
								        <?php }else{ ?>
										    <option value="0">所有区域</option>
										    <?php if(count($selCity)) foreach (Defines::$gCounty[$selCity] as $key=> $val){?>
									            <option value='<?php echo $key;?>'
											    <?php if($selCounty == $key){?> selected="selected" <?php }?>>
											    <?php echo $val;?></option>
								            <?php }?>   
								        <?php }?>
									</select>
								</div>
								<label class="control-label" style="float: left;">所属局站</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择局站"
										name='selSubstation' id='selSubstation'>
										<option value=''>所有区域</option>
									    <?php foreach ($substation as $substationObj){?>
									    
									   <option <?php if($substationObj->id == $selSubstation){?>
											selected="selected" <?php }?>
											value="<?php echo $substationObj->id;?>"><?php echo htmlentities($substationObj->name,ENT_COMPAT,"UTF-8");?></option>	
									   
									    <?php }?>	
									</select>
								</div>
							</div>
							<div class="form-actions">
								<button class="btn btn-success" name="action" value="search"
									type="submit">查询</button>
								<button class="btn btn-success" name="action" value="search" style="dislplay:none;"
									type="submit">设置分局</button>
								
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php if(isset($msg)){?>
			<div class="alert alert-success">
			<button data-dismiss="alert" class="close">×</button>
			<strong>导入成功!<?php echo $msg;?><a href='/portal/device_threshold'><font
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
				<div class="switch-board gray">批量设置阀值会作用到所有同类型的设备上。</div>
				<div class="content-widgets light-gray">
					<div class="widget-container">
						<div class="row-fluid">
							<div class="span4 btn btn-primary">
								<form id='formimport' class="form-horizontal" method='post'
									enctype="multipart/form-data">
									<div style="float: letf;">
										<input type="file" name="userfile" id='userfile'
											style="position: absolute; opacity: 0.6; left: 40px; top: 30px;" />
									</div>
									<div style="float: right;">
										<button type="submit" id='import' class="btn btn-info"
											name="import" value="importtodb">&nbsp;&nbsp;&nbsp;&nbsp;导入告警规则&nbsp;&nbsp;&nbsp;&nbsp;</button>
									</div>
								</form>
							</div>
							<div class="span2">
								<form id='formexport' class="form-horizontal" method='post'>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<button class="btn btn-primary" id='export' name="export"
										value="exporttoexcel" type="submit">&nbsp;&nbsp;&nbsp;&nbsp;导出告警规则&nbsp;&nbsp;&nbsp;&nbsp;</button>
								</form>
							</div>
							<div class="span2">
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<button type="button" class="btn btn-primary"
									id="btnAddDeviceVar">添加设备数据变量</button>

							</div>


						</div>

					</div>
					<br />
					<div class="row-fluid">
							<div class="span6">
								选定局站区域内共查询到 <?php echo count($dtList);?> 条告警规则
							</div>
						</div>
					<table id="dataTable"
						class="table table-bordered responsive table-striped">
						<thead>
							<tr>
								<th class="center">序号</th>
								<th class="center">所属分公司/区域/局站</th>
								<th class="center">设备类型</th>
								<th class="center">数据变量标签</th>
								<th class="center">数据变量</th>
								<th class="center">设置告警规则</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody id="tbDeviceVar">
							<?php $index=1; foreach($dtList as $dtObj){ ?>
								<tr
								oid="<?php echo htmlentities($dtObj->id,ENT_COMPAT,"UTF-8");?>">
								<td class="center"><?php echo $index++; ?></td>
								<td class="center"><?php echo htmlentities($dtObj->apply_area, ENT_COMPAT, "UTF-8"); ?></td>
								<td class="center"
									dev_type="<?php echo htmlentities($dtObj->dev_type,ENT_COMPAT,"UTF-8");?>"><?php echo Defines::$gDevModel[$dtObj->dev_type]; ?></td>
								<td class="center"><?php echo htmlentities($dtObj->var_label, ENT_COMPAT, "UTF-8"); ?></td>
								<td class="center"><?php echo htmlentities($dtObj->var_name,ENT_COMPAT,"UTF-8"); ?></td>
								<td class="center">
									<button
										oid="<?php echo htmlentities($dtObj->id,ENT_COMPAT,"UTF-8"); ?>"
										class="btn btn-warning setThreshold">设置告警规则</button>
								</td>
								<td>
									<div class="btn-toolbar row-action">
										<div class="btn-group">
											<button class="btn btn-info dv_btn_edit"
												data-original-title="修改">
												<i class="icon-edit"></i>
											</button>
											<button style="display: none"
												class="btn btn-inverse dv_btn-inverse"
												data-original-title="取消">
												<i class=" icon-remove-sign"></i>
											</button>
											<button style="display: none"
												class="btn btn-success dv_btn-success dv_btn_save"
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
							<?php } ?>
							</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade bs-example-modal-lg" role="dialog"
	id='thresholdDialog'
	style="left: 50%; margin-left: -550px; width: 1100px; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body modal-lg">
				<h4>设置完毕，请点击"保存"按钮对所有修改进行保存</h4>
				<p>阀值类型：上限：当采样值增加大于上限触发。下限：当采样值减少小于下限时触发。阀值：采样值等于阀值时候触发。</p>
				<div class="row-fluid">
					<div class="span6">
					   <h4>上级告警规则</h4>选中即可应用与本告警规则集合
				    </div>
				</div>
				<table
					class="paper-table table table-paper table-striped table-sortable">
					<thead>
						<tr>
						   <th></th>						    
							<th>序号</th>
							<th>所属分公司/区域/局站</th>
							<th>阀值类型</th>
							<th>阀值</th>
							<th>告警级别</th>
							<th>信号名称</th>
							<th>信号ID</th>
							<th>告警文本</th>
							<th>屏蔽状态</th>
							<th>超时(秒)</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody id="tbHighRule">
					</tbody>
				</table>
				<div class="row-fluid">
					<div class="span6">
						<button type="button" class="btn btn-primary" id="btnAddRule">新建告警规则</button>
					</div>
				</div>
				<br>
				<table
					class="paper-table table table-paper table-striped table-sortable">
					<thead>
						<tr>
							<th>序号</th>
							<th>阀值类型</th>
							<th>阀值</th>
							<th>告警级别</th>
							<th>信号名称</th>
							<th>信号ID</th>
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
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-danger" id='btn-ok-checks'>保存</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade bs-example-modal-lg" role="dialog"
	id='thresholdDialog3' style="left: 50%; width: 500px; display: none;">

	<h4>你确定要进行修改吗？</h4>

	<div class="modal-footer">
		<button type="button" class="btn btn-primary" id="qx"
			data-dismiss="modal">取消</button>
		<button type="button" class="btn btn-danger" id="btn-ok-check"
			data-dismiss="modal">确定</button>
	</div>
</div>
<div class="modal fade bs-example-modal-lg" role="dialog"
	id='dataParamDialog'>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body modal-lg">
				<h4>选择数据变量</h4>
				<table
					class="paper-table table table-paper table-striped table-sortable">
					<thead>
						<tr>
							<th>序号</th>
							<th>数据变量标签</th>
							<th>数据变量</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody id="tbDataParam">
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
