<table
	class="table table-bordered responsive table-striped table-sortable">
	<thead>
		<tr>
			<th>序号</th>
			<th>变量名</th>
			<th>当前值</th>
		</tr>
	</thead>
	<tbody  class='rt-data mec10' data_id='<?php echo $dataObj->data_id;?>'>
	<?php  $i=1; foreach(Defines::$gMec10 as $key){ ?>
         <tr id="mec10-<?php echo $dataObj->data_id."-".$i; ?>"> 
			<td><?php echo $i++;?></td>
			<td><?php echo $key; ?></td>
			<td><span></span></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
