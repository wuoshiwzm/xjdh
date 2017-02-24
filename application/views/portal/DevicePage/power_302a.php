<div class="tab-pane active" id="device-<?echo $dataObj->data_id; ?>">
	<div class="span6">
		<h4>性能指标</h4>
    <?php if($_SESSION['XJTELEDH_USERROLE'] == 'admin'){?>
    <p>
			<a
				href='<?php echo site_url('portal/dynamicSetting/'.$dataObj->data_id);?>'
				target="_blank" class="btn btn-info">动态设置</a>
			<button class='btn btn-info dev-info'
				data_id='<?php echo $dataObj->data_id;?>'
				model='<?php echo $dataObj->model;?>'>详细信息</button>
		</p>    
    <?php }?>
    </div>
	<table
		class="table table-bordered table-striped responsive table-sortable">
		<thead>
			<tr>
				<th>序号</th>
				<th>信号量</th>
				<th>A相值</th>
				<th>B相值</th>
				<th>C相值</th>
				<th>合相值</th>
			</tr>
		</thead>
		<tbody class='rt-data 302a_power' data_id='<?php echo $dataObj->data_id;?>'>
		     <?php $i=1; foreach(Defines::$g302APower as $key){ ?>
				<?php if($key == "无功功率" || $key == "视在功率"){ continue; } ?>
             <tr id="power302a-<?php echo $dataObj->data_id."-".$i; ?>"> 
				<td><?php echo $i++;?></td>
				<td><?php echo $key; ?></td>
				<td><span></span></td>
				<td><span></span></td>
				<td><span></span></td>
				<td><span></span></td>
			</tr>
			<?php } ?>
            </tbody>
	</table>
</div>
