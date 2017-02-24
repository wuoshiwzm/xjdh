<div class='row-fluid'>
    <div class='span12'>
        <h3><?php echo '机房环境';?></h3>
    	<table class="table table-striped">
    		<thead>
    			<tr>
    				<th>#</th>
    				<th>名称</th>
    				<th>实时数据</th>
    				<th>更新时间</th>
    			</tr>
    		</thead>
    		<tbody>
    		<?php $index= 1; foreach ($devList as $devObj){?>
    			<tr class='rt-data' data_type='aidi' data_id='<?php echo $devObj->data_id;?>' id='device-<?php echo $devObj->data_id;?>'>
    				<td><?php echo $index++; ?></td>
    				<td><?php echo $devObj->name;?></td>
    				<td></td>
    				<td></td>
    			</tr>
    		<?php }?>
    		</tbody>
    	</table>
    </div>
</div>