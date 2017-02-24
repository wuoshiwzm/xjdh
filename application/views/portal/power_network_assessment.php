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
						<label class="control-label" style="float: left;">局站类型</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select chzn-search-disabled "
										name='type' id='type'>
										<option value='0' selected='selected' >所有类型</option>
										<option value='A'<?php if($type == "A"){?>selected="selected"<?php }?>>A类局站</option>
										<option value='B'<?php if($type == "B"){?>selected="selected"<?php }?>>B类局站</option>
										<option value='C'<?php if($type == "C"){?>selected="selected"<?php }?>>C类局站</option>
									</select>
								</div>
							<label class="control-label" style="float: left;">指标性质</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select chzn-search-disabled "
										name='property' id='property'>
										<option value='0' selected='selected' >所有性质</option>
										<option value='关键'<?php if($property == "关键"){?>selected="selected"<?php }?>>关键</option>
										<option value='重要'<?php if($property == "重要"){?>selected="selected"<?php }?>>重要</option>
										<option value='一般'<?php if($property == "一般"){?>selected="selected"<?php }?>>一般</option>
									</select>
								</div>
							</div>
							<div class="control-group">
							<label class="control-label" style="float: left;">指标网元</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select name="element">
									   <option value="">所有网元</option>
									   <?php foreach(Defines::$gElement as $key=>$val){ ?>
									   <option
											<?php if($element == $val) {?>
											selected="selected" <?php }?> value='<?php echo $val;?>'><?php echo $val;?></option>
									   <?php }?>
									</select>	
								</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">指标名称</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='name' id='name'value='<?php if($name) echo $name;?>' />
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
									href='<?php echo site_url('portal/edit_network');?>'><i
									class="icon-plus"></i> 添加电源网络安全评估</a>
							</div>
						</div>
					
						<table class="table table-bordered responsive table-striped">
							<thead>
								<tr>
									<th>序号</th>
									<th>局站类别</th>
									<th>指标性质</th>
									<th>指标网元</th>
									<th>指标名称</th>
									<th>指标含义</th>
									<th>指标要求</th>
									<th>参考依据</th>
									<th>指标配置</th>
									<th>操作</th>	
								</tr>
							</thead>
							<tbody>
					           <?php $i = $offset + 1; foreach($networkList as $networkObj){ ?>		 
							     <tr id='<?php echo htmlentities($networkObj->network_id,ENT_COMPAT,"UTF-8");?>'>
							        <td><?php echo $i++;?></td>
									<td><?php echo htmlentities($networkObj->type,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($networkObj->property,ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities($networkObj->element,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($networkObj->name,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($networkObj->meaning,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($networkObj->requirements,ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities($networkObj->reference,ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities($networkObj->config,ENT_COMPAT,"UTF-8"); ?></td>
									<td>
										<div class="btn-toolbar row-action">
											<div class="btn-group">
												<button class="btn btn-info" data-original-title="编辑"
													onclick='location.href="/portal/edit_network/<?php echo htmlentities($networkObj->id,ENT_COMPAT,"UTF-8");?>"'>
													<i class="icon-edit"></i>
												</button>
												<button class="btn btn-danger deletenetwork"
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
                                                        总计 <?php echo $count;?> 个电源网络安全评估
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

