<h4>性能指标</h4>
<p>
  <?php if($_SESSION['XJTELEDH_USERROLE'] == 'admin'){?>
      <a
		href='<?php echo site_url('portal/dynamicSetting/'.$access4000xObj->data_id);?>'
		target="_blank" class="btn btn-info">动态设置</a>
  <?php }?>
  <button class='btn btn-info dev-info'
		data_id='<?php echo $access4000xObj->data_id;?>'
		model='<?php echo $access4000xObj->model;?>'>详细信息</button>
</p>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $access4000xObj->data_id;?>-dc'>
	<thead>
		<tr>
			<th>序号</th>
			<th>变量名</th>
			<th>当前值</th>
			<th>告警级别</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $access4000xObj->data_id;?>-motor'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前值</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach (Defines::$gAccess4000x as $key => $val){?>
	   <tr>
			<td><?php echo $key + 1;?></td>
			<td><?php echo $val;?></td>
			<td id='access4000x-<?php echo $access4000xObj->data_id.'-field'.$key;?>'></td>
		</tr>
   <?php }?>
	</tbody>
</table>
