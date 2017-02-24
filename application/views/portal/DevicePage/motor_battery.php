<?php if(isset($isMobile) && $isMobile){?>
<div class='row-fluid'>
	<div class='span12'>
		<h3>油机启动电池</h3>
<?php }?>          
    		<table
			class="paper-table table table-paper table-striped table-sortable">
			<thead>
				<tr>
					<th>序号</th>
					<th>名称</th>
					<th>实时数据</th>
					<th>更新时间</th>
                      <?php if((!isset($isMobile) || !$isMobile) && $_SESSION['XJTELEDH_USERROLE'] == 'admin'){?>
                      <th>设置告警规则</th>
                      <?php }?>
                  </tr>
			</thead>
			<tbody>
              <?php $i = 1 ;foreach ($motorBatList as $motorBatObj){?>
                  <tr class='rt-data' data_type='motor_battery'
					data_id='<?php echo $motorBatObj->data_id;?>'
					id='device-<?php echo $motorBatObj->data_id;?>'>
					<td><?php echo $i++;?></td>
					<td>
                      <?php if(isset($isMobile) && $isMobile){?>
                      <?php echo $motorBatObj->name;?>
                      <?php }else{?>
                      <a class='dev-info'
						data_id='<?php echo $motorBatObj->data_id;?>'
						model='<?php echo $motorBatObj->model;?>'><?php echo $motorBatObj->name;?></a>
                      <?php }?>
                      </td>
					<td></td>
					<td></td>
                      <?php if((!isset($isMobile) || !$isMobile) && $_SESSION['XJTELEDH_USERROLE'] == 'admin'){?>
                      <td class="hasThreshold">
						<button data_id='<?php echo $motorBatObj->data_id;?>' field=""
							class="btn btn-warning setThreshold">设置告警规则</button> <a
						href='<?php echo site_url('portal/dynamicSetting/'.$motorBatObj->data_id);?>'
						target="_blank" class="btn btn-info">动态设置</a>
					</td>
                      
                      <?php }?>
                  </tr>
              <?php }?>
              </tbody>
		</table>
<?php if(isset($isMobile) && $isMobile){?>
	</div>
</div>
<?php }?>