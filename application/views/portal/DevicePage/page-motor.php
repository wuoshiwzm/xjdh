<h4>性能指标</h4>
<p>
  <?php if($_SESSION['XJTELEDH_USERROLE'] == 'admin'){?>
      <a
		href='<?php echo site_url('portal/dynamicSetting/'.$motorObj->data_id);?>'
		target="_blank" class="btn btn-info">动态设置</a>
  <?php }?>
  <button class='btn btn-info dev-info'
		data_id='<?php echo $motorObj->data_id;?>'
		model='<?php echo $motorObj->model;?>'>详细信息</button>
</p>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $motorObj->data_id;?>-dc'>
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
<?php

if ($motorObj->model == 'access4000x') {
    $params = array();
    ?>

<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $motorObj->data_id;?>-motor'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前值</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($params as $key => $val){?>
	   <tr>
			<td><?php echo $key + 1;?></td>
			<td><?php echo $val;?></td>
			<td id='motor-<?php echo $motorObj->data_id.'-field'.$key;?>'></td>
		</tr>
   <?php }?>
	</tbody>
</table>
<?php }?>
