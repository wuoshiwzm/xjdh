<div class="alert" id="<?php echo $dataObj->data_id;?>-alert" style="display:none;">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<i class="icon-exclamation-sign"></i><strong>警告！</strong>  协议未完全匹配，个别数据可能无效!
</div>
<h4>性能指标</h4>
<p>
  <?php if($_SESSION['XJTELEDH_USERROLE'] == 'admin'){?>
	<button class='btn btn-info settings' data_id='<?php echo $dataObj->data_id;?>'>动态设置</button>
  <?php }?>
  <button class='btn btn-info dev-info'	data_id='<?php echo $dataObj->data_id;?>'
		model='<?php echo $dataObj->model;?>'>详细信息</button>
</p>
<p>最后更新时间:<span id="<?php echo $dataObj->data_id;?>-update_datetime"></span>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='<?php echo $dataObj->data_id;?>-rc'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前值</th>
		</tr>
	</thead>
	<tbody>
        <tr>
			<td>1</td>
			<td>整流模块输出电压</td>
			<td id='<?php echo $dataObj->data_id.'-out_v';?>'></td>
		</tr>
		<tr>
			<td>2</td>
			<td>整流模块数量</td>
			<td id='<?php echo $dataObj->data_id.'-channel_count';?>'></td>
		</tr>
	</tbody>
</table>
<h4>整流输入各路状态</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='<?php echo $dataObj->data_id;?>-sps-rc-2'>
	<thead>
		<tr>
			<th>序号</th>
			<th>整流模块输出电流</th>
			<?php foreach($p41_41_label as $key=>$show){
			    if(!$show)continue; ?>
			<th class="p41_41"><?php echo $key; ?></th>
			<?php } ?>
			<th>开机/关机状态</th>
			<th>限流/不限流状态</th>
			<th>浮充/均充/测试状态</th>
			<?php foreach($p41_43_label as $key=>$show){
			    if(!$show)continue; ?>
			<th class="p41_43"><?php echo $key; ?></th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
<h4>整流输入各路告警状态</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='<?php echo $dataObj->data_id;?>-sps-rc-3'>
	<thead>
		<tr>
			<th>序号</th>
			<th>整流模块故障</th>
			<?php foreach($p41_44_label as $key=>$show){
			    if(!$show)continue; ?>
			<th><?php echo $key; ?></th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>