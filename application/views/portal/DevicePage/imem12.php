<div class="tab-pane active">
	<table
		class="paper-table table table-paper table-striped table-sortable">
		<thead>
			<tr>
				<th>名称</th>
				<th>实时功率(W)</th>
				<th>实时电能(kW·h)</th>
				<th>更新时间</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody class='rt-data imem_12' data_type='imem12' data_id='<?php echo $dataObj->data_id;?>'>
               <tr id='imem12_p_<?php echo $dataObj->data_id;?>'>
				<?php $i =1;?>
				<td><a class='dev-info' data_id='<?php echo $dataObj->data_id;?>'
					model='imem_12' imem_id='<?php echo $dataObj->id;?>'><?php echo $dataObj->name;?></a></td>
				<td><span style="display: block; width: 80px; float: left;"></span></td>
				<td>暂无数据</td>
				<td>暂无数据</td>
				<td><a
					href='<?php echo site_url('portal/dynamicSetting/'.$dataObj->data_id);?>'
					target="_blank" class="btn btn-info">动态设置</a>
					<button data_id='<?php echo $dataObj->data_id;?>' field=""
						class="btn btn-warning setThreshold">设置告警规则</button></td>
			</tr>
       </tbody>
	</table>
</div>
