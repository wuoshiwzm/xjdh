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
	$signalArray = array('更新时间',"系统电压(100mV)","负载总电流(A)","电池组1的电流(A)","电池组2的电流(A)","电池组3的电流(A)","电池组4的电流(A)",
            "系统交流输入电压(V)","系统交流输入电流1(A)","系统交流输入电流2(A)","电池组1温度(°C)","电池组2温度(°C)","电池组3温度(°C)","电池组4温度(°C)","环境温度(°C)");
	foreach ($signalArray as $key => $val){?>
	   <tr>
			<td><?php echo $key + 1;?></td>
			<td><?php echo $val;?></td>
			<td id='dk04-<?php echo $dataObj->data_id.'-field'.$key;?>'></td>
       </tr>
   <?php }?>
	</tbody>
</table>