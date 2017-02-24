<table
	class="table table-bordered responsive table-striped table-sortable">
	<thead>
		<tr class="trth">
			<th width="50">序号</th>
			<th>物理端口号</th>
			<th>设备名称</th>
			<th>激活状态</th>
			<th>通信状态</th>
		</tr>
	</thead>
	<tbody>
              <?php $index = 1;foreach ($diList as $dataObj){      	
                  if(in_array($dataObj->model, array('venv','vcamera')))
                      continue;
                  if($dataObj->active){?>
        <tr class='rt-data' data_type='aidi'
			data_id='<?php echo $dataObj->data_id;?>'
			model<?php echo $dataObj->data_id;?>='<?php echo $dataObj->model;?>'
			id='device-<?php echo $dataObj->data_id;?>'>
			<td><?php echo $index++;?></td>
			<td><?php if($dataObj->model == 'venv' || $dataObj->model == 'vcamera'){
						echo ' ';
					}else{
						echo '开关量DI-' . $dataObj->port;
					}?></td>
			<td><a class='dev-info' data_id='<?php echo $dataObj->data_id;?>'
				model='<?php echo $dataObj->model;?>'><?php echo htmlentities($dataObj->name, ENT_COMPAT, "UTF-8");?></a></td>
			<td><a href='#'><?php if($dataObj->active){?><span
											class="label label-success dev-lock">已激活</span><?php }else{?><span
											class="label label-warning dev-unlock">未激活</span><?php }?></a></td>
			<td></td>
		</tr>
		<?php }?>
              <?php } ?>
              <?php foreach ($aiList as $dataObj){ ?>
               <?php if($dataObj->active){?>
                  <tr class='rt-data' data_type='aidi'
			data_id='<?php echo $dataObj->data_id;?>'
			id='device-<?php echo $dataObj->data_id;?>'>
			<td><?php echo $index++;?></td>
			<td><?php echo '模拟量AI-' . $dataObj->port; ?></td>
			<td><a class='dev-info' data_id='<?php echo $dataObj->data_id;?>'
				model='<?php echo $dataObj->model;?>'><?php echo htmlentities($dataObj->name, ENT_COMPAT, "UTF-8");?></a></td>
			<td><a href='#'><?php if($dataObj->active){?><span
											class="label label-success dev-lock">已激活</span><?php }else{?><span
											class="label label-warning dev-unlock">未激活</span><?php }?></a></td>
			<td></td>
		</tr>
		<?php }?>
              <?php } ?>
              <?php foreach ($spList as $dataObj){ ?>
              <?php if($dataObj->active){?>
                  <tr class='rt-data' data_type='aidi'
			data_id='<?php echo $dataObj->data_id;?>'
			id='device-<?php echo $dataObj->data_id;?>'>
			<td><?php echo $index++;?></td>
			<td><?php echo '串口UART-' . $dataObj->port;   ?></td>
			<td><a class='dev-info' data_id='<?php echo $dataObj->data_id;?>'
				model='<?php echo $dataObj->model;?>'><?php echo htmlentities($dataObj->name, ENT_COMPAT, "UTF-8");?></a></td>
			<td><a href='#'><?php if($dataObj->active){?><span
											class="label label-success dev-lock">已激活</span><?php }else{?><span
											class="label label-warning dev-unlock">未激活</span><?php }?></a></td>
			<td></td>
		</tr>
		<?php }?>
              <?php } ?>
   </tbody>
</table>