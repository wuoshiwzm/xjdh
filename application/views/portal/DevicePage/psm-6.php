<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $dataObj->data_id;?>'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前值</th>
		</tr>
	</thead>
	<tbody>
 	<?php
		$signalArray = array (
				'更新时间',
				"交流输入类型",
				"输入交流过压保护值(V)",
				"输入交流低压保护值(V)",
				"配电输出总数",
				"电源系统整流模块总数",
				"系统控制方式",
				"电池总数(组)",
				"电池容量(Ah)",
				"浮充电压(V)",
				"均充电压(V)",
				"均充时间间隔(天)",
				"均充定时时间(小时)",
				"充电系数",
				"馈线电阻(mΩ)",
				"电流充电限流值(A)",
				"均浮充转换电流(A)",
				"电池欠压报警值",
				"电池欠压保护值",
				"电池欠压是否自动保护",
				"配电监控单元地址(00-99)",
		);
		foreach ( $signalArray as $key => $val ) {?>
   	<tr>
			<td><?php echo $key + 1;?></td>
			<td><?php echo $val;?></td>
			<td id='psm06-<?php echo $dataObj->data_id.'-field'.$key;$dataObj->output_count = id;?>'></td>
			</tr>
   <?php }?>
        </tbody>
</table>
<h4>各路配电输出序号</h4>
<?php
		$params = array ();
		for($i = 1; $i <= 20; $i++) {
			$params [$i] = $i.'路';
		}
 ?>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $dataObj->data_id;?>-1'>
	<thead>
		<tr>
			<th>配电输出路</th>
			<th>配电输出序号</th>
		</tr>
	</thead>
	<tbody>
        <?php foreach ($params as $key => $val){?>
        <tr>
			<td><?php echo $val;?></td>
			<td id='psm06-output-<?php echo $dataObj->data_id.'-field'.($key-1)?>'></td>
		</tr>
        <?php }?>
    </tbody>
</table>
<h4>各整流模块地址</h4>
<?php
	$params = array ();
	for($i = 1; $i <= 10; $i++) {
		$params [$i] = '模块' . $i;
	}
            ?>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $dataObj->data_id;?>-2'>
	<thead>
		<tr>
			<th>模块序号</th>
			<th>模块地址</th>
		</tr>
	</thead>
	<tbody>
        <?php foreach ($params as $key=> $val){?>
        <tr>
			<td><?php echo $val;?></td>
			<td id='psm06-model-<?php echo $dataObj->data_id.'-field'.($key-1)?>'></td>
		</tr>
        <?php }?>
    </tbody>
</table>
