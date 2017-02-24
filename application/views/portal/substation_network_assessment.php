<script type="text/javascript">
var n = <?php echo json_encode($n);?>;
var config = <?php echo json_encode($config);?>;
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
						<h3><?php  echo $substationObj->name ?>&nbsp&nbsp 电源网络安全指标列表</h3>
					<?php }else {?>
					    <h3>请单击局站以显示列表</h3>
					<?php }?>   
					</div>
					<?php if($substation_id!=0 && !strpos($string,"#")){?>
					<div class="widget-container">
						<div class="row-fluid">
							<div class="span6">
								<a type="button" class="btn btn-info"
								   href='<?php echo site_url('portal/substationSetting/'.$substation_id);?>'><i
								   class="icon-plus"></i> 添加局站安全评估规则</a>
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
									<th>指标值</th>
									<th>当前状态</th>
									<th>操作</th>	
								</tr>
							</thead>
							<tbody  id="networkList">
							   <?php $n = 0; ?>
					           <?php $i = $offset + 1; foreach($networkList as $networkObj){ ?>	
							     <tr id='<?php echo htmlentities($networkObj->network_id,ENT_COMPAT,"UTF-8");?>'
							         substation_id='<?php echo $substation_id;?>' >
							        <td><?php echo $i++;?></td>
									<td><?php echo htmlentities($networkObj->type,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($networkObj->property,ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities($networkObj->element,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($networkObj->name,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($networkObj->meaning,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($networkObj->requirements,ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities($networkObj->value,ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities($networkObj->state,ENT_COMPAT,"UTF-8"); ?></td>
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
