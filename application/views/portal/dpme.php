<div class="tab-widget tabbable tabs-left chat-widget">
	<ul id="battery-tab" class="nav nav-tabs">
	<?php $index = 0;foreach ($batList as $batObj){?>
		<li <?php if($index++ == 0){?> class="active" <?php }?>><a
			href="#bat_<?php echo htmlentities($batObj->data_id,ENT_COMPAT,"UTF-8");?>"> <?php echo htmlentities($batObj->name,ENT_COMPAT,"UTF-8");?> </a></li>
	<?php }?>
	</ul>
	<div class="tab-content" style='height: 800px;'>
	<?php $index = 0;foreach ($batList as $batObj){?>
		<div id="bat_<?php echo htmlentities($batObj->data_id,ENT_COMPAT,"UTF-8");?>"
			data_id='<?php echo htmlentities($batObj->data_id,ENT_COMPAT,"UTF-8");?>'
			<?php if ($batObj->model == 'battery_24'){?> data_type='bat24'
			<?php }else{?> data_type='bat32' <?php }?>
			class="tab-pane rt-data <?php if($index++ == 0){?>active<?php }?>">
			<h3><?php echo htmlentities($batObj->name,ENT_COMPAT,"UTF-8");?></h3>
			<div class='row-fluid'>
				<h4>性能指标</h4>
		      <?php if($_SESSION['XJTELEDH_USERROLE'] == 'admin'){?>
		      <p>
					<a class="btn btn-warning"
						href='<?php echo site_url('portal/device_pi_setting/'.htmlentities($batObj->model,ENT_COMPAT,"UTF-8"));?>'>设置性能指标</a>
					<a
						href='<?php echo site_url('portal/dynamicSetting/'.htmlentities($batObj->data_id,ENT_COMPAT,"UTF-8"));?>'
						target="_blank" class="btn btn-info">动态设置</a>
					<button class='btn btn-info dev-info'
						data_id='<?php echo htmlentities($batObj->data_id,ENT_COMPAT,"UTF-8");?>'
						model='<?php echo htmlentities($batObj->model,ENT_COMPAT,"UTF-8");?>'>详细信息</button>
				</p>
		      <?php }?>
		      <table
					class="table table-bordered responsive table-striped table-sortable"
					id='tb-<?php echo htmlentities($batObj->data_id,ENT_COMPAT,"UTF-8");?>-dc'>
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
					class="table table-bordered table-striped responsive table-sortable"
					id='bat_pi-<?php echo htmlentities($batObj->data_id,ENT_COMPAT,"UTF-8");?>'>
					<thead>
						<tr>
							<th>序号</th>
							<th>变量标签</th>
							<th>变量值</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="3">无</td>
						</tr>
					</tbody>
				</table>			
			</div>		
			<table
					class="table table-bordered table-striped responsive table-sortable">
				<tr>
						<th>类型</th>
						<th>数据</th>
						<th>更新时间</th>
						<th>设置告警规则</th>
					</tr>
					<tr>
						<td>整组电压</td>
						<td class="group_v"></td>
						<td class="update_datetime"><?php echo date('Y-m-d H:i:s');?></td>
						<td class="hasThreshold"><button data_id='<?php echo htmlentities($batObj->data_id,ENT_COMPAT,"UTF-8");?>'
									field="group_voltage" class="btn btn-warning setThreshold">设置阀值</button></span></td>
					</tr>
				</table>	
			<table
				class="table table-bordered table-striped responsive table-sortable"
				id="bat_voltage_<?php echo htmlentities($batObj->data_id,ENT_COMPAT,"UTF-8");?>">
				<thead>
				
					<tr>
						<th>节号</th>
						<th>电压</th>
						<th>设置告警规则</th>
						<th>节号</th>
						<th>电压</th>
						<th>设置告警规则</th>
						<th>节号</th>
						<th>电压</th>
						<th>设置告警规则</th>
						<th>节号</th>
						<th>电压</th>
						<th>设置告警规则</th>
					</tr>
				</thead>
				<tbody>				
                  <?php    
  	$row =	json_decode($batObj->extra_para)->amount;
    for ($j = 0; $j < $row; $j += 4) {
        ?>
                  <tr>
						<td><?php echo $j+1;?></td>
						<td bat_num='<?php echo $j;?>'><span></span>&nbsp;</td>
						<td class="hasThreshold"><button
								data_id='<?php echo htmlentities($batObj->data_id,ENT_COMPAT,"UTF-8");?>'
								field="battery_<?php echo $j;?>_value"
								class="btn btn-warning setThreshold">设置阀值</button></td>
						<td><?php echo $j+2;?></td>
						<td bat_num='<?php echo $j+1;?>'><span></span>&nbsp;</td>
						<td class="hasThreshold"><button
								data_id='<?php echo htmlentities($batObj->data_id,ENT_COMPAT,"UTF-8");?>'
								field="battery_<?php echo $j+1;?>_value"
								class="btn btn-warning setThreshold">设置阀值</button></td>
						<td><?php echo $j+3;?></td>
						<td bat_num='<?php echo $j+2;?>'><span></span>&nbsp;</td>
						<td class="hasThreshold"><button
								data_id='<?php echo htmlentities($batObj->data_id,ENT_COMPAT,"UTF-8");?>'
								field="battery_<?php echo $j+2;?>_value"
								class="btn btn-warning setThreshold">设置阀值</button></td>
						<td><?php echo $j+4;?></td>
						<td bat_num='<?php echo $j+3;?>'><span></span>&nbsp;</td>
						<td class="hasThreshold"><button
								data_id='<?php echo htmlentities($batObj->data_id,ENT_COMPAT,"UTF-8");?>'
								field="battery_<?php echo $j+3;?>_value"
								class="btn btn-warning setThreshold">设置阀值</button></td>
					</tr>
                  <?php }?>                  
                  </tbody>
			</table>
		</div>
	<?php }?>
	</div>
</div>
<script type="text/javascript">
$(function(){
    $('#battery-tab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
});
</script>
