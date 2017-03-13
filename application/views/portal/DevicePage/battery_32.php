<script type="text/javascript">
<!--
var No1 = <?php echo json_encode(json_decode($dataObj->extra_para)->No1);?>;
var No2 = <?php echo json_encode(json_decode($dataObj->extra_para)->No2);?>;
//-->
var type = <?php echo json_encode($type); ?>
</script>
<div class='row-fluid'>
				<h4>性能指标</h4>
		      <?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?>
		      <p>
					<a class="btn btn-warning"
						href='<?php echo site_url('portal/device_pi_setting/'.$dataObj->model);?>'>设置性能指标</a>
					<a
						href='<?php echo site_url('portal/dynamicSetting/'.$dataObj->data_id);?>'
						target="_blank" class="btn btn-info">动态设置</a>
					<button class='btn btn-info dev-info'
						data_id='<?php echo $dataObj->data_id;?>'
						model='<?php echo $dataObj->model;?>'>详细信息</button>
				</p>
		      <?php }?>
		      <table
					class="table table-bordered responsive table-striped table-sortable"
					id='tb-<?php echo $dataObj->data_id;?>-dc'>
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
					id='bat_pi-<?php echo $dataObj->data_id;?>'>
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
						<?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?>
						<th>设置告警规则</th>
						<?php } ?>
					</tr>
					<tr>
						<td>整组电压</td>
						<td class="group_v"></td>
						<td class="update_datetime"><?php echo date('Y-m-d H:i:s');?></td>
						<?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?>
						<td class="hasThreshold"><button data_id='<?php echo $dataObj->data_id;?>'
									field="group_voltage" class="btn btn-warning setThreshold">设置阀值</button></td>
					    <?php } ?>
					</tr>
				</table>	
				<?php if(json_decode($dataObj->extra_para)->No1){?>
							<table
							class="table table-bordered table-striped responsive table-sortable"
							id="bat_voltageNo1_<?php echo $dataObj->data_id;?>">
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
			  	$row = explode(',',json_decode($dataObj->extra_para)->No1);
			    for ($j=0; $j<count($row); $j+=4) {
			        ?>
                  <tr>
						<td><?php echo $row[$j];?></td>
						<td bat_num='<?php echo $j;?>'><span></span>&nbsp;</td>
						<td class="hasThreshold">
						<?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?>
						<button
								data_id='<?php echo $dataObj->data_id;?>'
								field="battery_<?php echo $j;?>_value"
								class="btn btn-warning setThreshold">设置阀值</button>
					    <?php } ?>
					    </td>
						<td><?php echo $row[$j+1];?></td>
						<td bat_num='<?php echo $j+1;?>'><span></span>&nbsp;</td>
						<td class="hasThreshold">
						<?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?>
						<button
								data_id='<?php echo $dataObj->data_id;?>'
								field="battery_<?php echo $j+1;?>_value"
								class="btn btn-warning setThreshold">设置阀值</button>
					     <?php } ?></td>
						<td><?php echo$row[$j+2];?></td>
						<td bat_num='<?php echo $j+2;?>'><span></span>&nbsp;</td>
						<td class="hasThreshold">
						<?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?>
						<button
								data_id='<?php echo $dataObj->data_id;?>'
								field="battery_<?php echo $j+2;?>_value"
								class="btn btn-warning setThreshold">设置阀值</button>
						<?php } ?></td>
						<td><?php echo $row[$j+3];?></td>
						<td bat_num='<?php echo $j+3;?>'><span></span>&nbsp;</td>
						<td class="hasThreshold">
						<?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?>
						<button
								data_id='<?php echo $dataObj->data_id;?>'
								field="battery_<?php echo $j+3;?>_value"
								class="btn btn-warning setThreshold">设置阀值</button>
						<?php } ?></td>
					</tr>
			                  <?php }?>                  
			                  </tbody>
						</table>
				<?php }?>
					<?php if(json_decode($dataObj->extra_para)->No2){?>
							<table
							class="table table-bordered table-striped responsive table-sortable"
							id="bat_voltageNo2_<?php echo $dataObj->data_id;?>">
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
			  	$row = explode(',',json_decode($dataObj->extra_para)->No2);
			    for ($j=0; $j<count($row); $j+=4) {
			        ?>
                  <tr>
						<td><?php echo $row[$j];?></td>
						<td bat_num='<?php echo $j;?>'><span></span>&nbsp;</td>
						<td class="hasThreshold"><button
								data_id='<?php echo $dataObj->data_id;?>'
								field="battery_<?php echo $j;?>_value"
								class="btn btn-warning setThreshold">设置阀值</button></td>
						<td><?php echo $row[$j+1];?></td>
						<td bat_num='<?php echo $j+1;?>'><span></span>&nbsp;</td>
						<td class="hasThreshold"><button
								data_id='<?php echo $dataObj->data_id;?>'
								field="battery_<?php echo $j+1;?>_value"
								class="btn btn-warning setThreshold">设置阀值</button></td>
						<td><?php echo$row[$j+2];?></td>
						<td bat_num='<?php echo $j+2;?>'><span></span>&nbsp;</td>
						<td class="hasThreshold"><button
								data_id='<?php echo $dataObj->data_id;?>'
								field="battery_<?php echo $j+2;?>_value"
								class="btn btn-warning setThreshold">设置阀值</button></td>
						<td><?php echo $row[$j+3];?></td>
						<td bat_num='<?php echo $j+3;?>'><span></span>&nbsp;</td>
						<td class="hasThreshold"><button
								data_id='<?php echo $dataObj->data_id;?>'
								field="battery_<?php echo $j+3;?>_value"
								class="btn btn-warning setThreshold">设置阀值</button></td>
					</tr>
			                  <?php }?>                  
			                  </tbody>
						</table>
				<?php }?>
				
			         	<?php if($type == "44"||$type == "44i"){?>
							<table
							class="table table-bordered table-striped responsive table-sortable"
				            id="bat_voltage_<?php echo $dataObj->data_id;?>">
                                                        <h5>第一组</h5>
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
                   <tr >		
						<td>1</td>
						<td bat_num='0'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_0_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>2</td>
						<td bat_num='1'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_1_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>3</td>
						<td bat_num='2'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_2_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>4</td>
						<td bat_num='3'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_3_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
					</tr>
					<tr>		
						<td>21</td>
						<td bat_num='20'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_20_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>22</td>
						<td bat_num='21'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_21_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>23</td>
						<td bat_num='22'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_22_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>24</td>
						<td bat_num='23'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_23_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
					</tr>
                                        </tbody>
					</table>
					<table  class="table table-bordered table-striped responsive table-sortable"
				            id="bat_voltage2_<?php echo $dataObj->data_id;?>">
				       <h5>第二组</h5>
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

					<tr>		
						<td>1</td>
						<td bat_num='0'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_0_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>2</td>
						<td bat_num='1'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_1_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>3</td>
						<td bat_num='2'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_2_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>4</td>
						<td bat_num='3'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_3_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
					</tr>
					<tr>		
						<td>21</td>
						<td bat_num='20'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_20_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>22</td>
						<td bat_num='21'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_21_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>23</td>
						<td bat_num='22'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_22_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>24</td>
						<td bat_num='23'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_23_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
					</tr>                  
			            </tbody>
					</table>
                                    <?php }?>	
				<?php if($type == "11"){?>
                                      <h5>第一组</h5>
					<table class="table table-bordered table-striped responsive table-sortable"  id="bat_voltage_<?php echo $dataObj->data_id;?>">
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
                                        <tr>		
						<td>1</td>
						<td bat_num='0'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_0_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>2</td>
						<td bat_num='1'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_1_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>3</td>
						<td bat_num='2'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_2_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>4</td>
						<td bat_num='3'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>'field="battery_3_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
					</tr>
					<tr>		
						<td>5</td>
						<td bat_num='4'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_4_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>6</td>
						<td bat_num='5'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_5_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>7</td>
						<td bat_num='6'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_6_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>8</td>
						<td bat_num='7'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_7_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
					</tr>
					<tr>		
						<td>9</td>
						<td bat_num='8'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_8_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>10</td>
						<td bat_num='9'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_9_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>11</td>
						<td bat_num='10'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_10_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
                                                <td></td><td></td><td></td>
					</tr>
					</tbody>
					</table>
					<table class="table table-bordered table-striped responsive table-sortable" id="bat_voltage2_<?php echo $dataObj->data_id;?>">
					<thead>
							<h5>第二组</h5>
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
					<tr>		
						<td>1</td>
						<td bat_num='0'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_0_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>2</td>
						<td bat_num='1'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_1_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>3</td>
						<td bat_num='2'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_2_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>4</td>
						<td bat_num='3'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>'field="battery_3_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
					</tr>
					<tr>		
						<td>5</td>
						<td bat_num='4'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_4_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>6</td>
						<td bat_num='5'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_5_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>7</td>
						<td bat_num='6'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_6_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>8</td>
						<td bat_num='7'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_7_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
					</tr>
					<tr>		
						<td>9</td>
						<td bat_num='8'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_8_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>10</td>
						<td bat_num='9'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_9_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td>11</td>
						<td bat_num='10'><span></span>&nbsp;</td>
						<td class="hasThreshold"><?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?><button data_id='<?php echo $dataObj->data_id;?>' field="battery_10_value" class="btn btn-warning setThreshold">设置阀值</button><?php } ?></td>
						<td></td><td></td><td></td>
					</tr>              
			            </tbody>
					</table>
				   <?php }?> 		
			<?php if($dataObj->model == "battery_24" || $dataObj->model == "battery_32"){ ?>
			<?php if($type != "44" && $type != "11" && $type != "44i"){?>
			<table
				class="table table-bordered table-striped responsive table-sortable"
				id="bat_voltage_<?php echo $dataObj->data_id;?>">
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
  	$row =	json_decode($dataObj->extra_para)->amount;
    for ($j = 0; $j < $row; $j += 4) {
        ?>
                  <tr>
						<td><?php echo $j+1;?></td>
						<td bat_num='<?php echo $j;?>'><span></span>&nbsp;</td>
						<td class="hasThreshold">
						<?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?>
						<button
								data_id='<?php echo $dataObj->data_id;?>'
								field="battery_<?php echo $j;?>_value"
								class="btn btn-warning setThreshold">设置阀值</button>
						<?php } ?></td>
						<td><?php echo $j+2;?></td>
						<td bat_num='<?php echo $j+1;?>'><span></span>&nbsp;</td>
						<td class="hasThreshold">
						<?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?>
						<button
								data_id='<?php echo $dataObj->data_id;?>'
								field="battery_<?php echo $j+1;?>_value"
								class="btn btn-warning setThreshold">设置阀值</button>
						<?php } ?></td>
						<td><?php echo $j+3;?></td>
						<td bat_num='<?php echo $j+2;?>'><span></span>&nbsp;</td>
						<td class="hasThreshold">
						<?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?>
						<button
								data_id='<?php echo $dataObj->data_id;?>'
								field="battery_<?php echo $j+2;?>_value"
								class="btn btn-warning setThreshold">设置阀值</button>
								<?php } ?></td>
						<td><?php echo $j+4;?></td>
						<td bat_num='<?php echo $j+3;?>'><span></span>&nbsp;</td>
						<td class="hasThreshold">
						<?php if(in_array($userObj->user_role, array("admin","city_admin"))){ ?>
						<button
								data_id='<?php echo $dataObj->data_id;?>'
								field="battery_<?php echo $j+3;?>_value"
								class="btn btn-warning setThreshold">设置阀值</button>
					       <?php } ?></td>
					</tr>
                  <?php }?>         
                                  
                  </tbody>
			</table>
			            <?php }?>
            <?php } ?>
