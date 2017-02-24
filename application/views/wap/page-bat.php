<script type="text/javascript">
var type = <?php echo json_encode($type); ?>
</script>
<div class='row-fluid'> 
    <div class='span12 rt-data' <?php if($batObj->model == 'battery_24'){?> data_type='bat24' 
                <?php }else if($batObj->model == "battery_32"){ ?>
                data_type='bat32'<?php }else if($batObj->model == "battery24_voltage") { ?>
                data_type='battery24voltage'
                <?php } ?>
                data_id='<?php echo $batObj->data_id;?>' id='bat_<?php echo $batObj->data_id;?>'>
        <h3 class="text-center"><?php echo $batObj->name;?></h3>
        <div class='row-fluid'>
		      <h4>性能指标</h4>
		      <table class="table table-bordered table-striped responsive table-sortable" id='bat_pi-<?php echo $batObj->data_id;?>'>
                  <thead>
                      <tr>        	                          
                          <th>序号</th>
                          <th>变量标签</th>
                          <th>变量值</th>
                      </tr>
                  </thead>
                  <tbody>
                    <tr><td colspan="3">无</td></tr>
                  </tbody>
              </table>
	    </div>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td>1</td>
                    <td>整组电压</td>
                    <td><span class="group_v" >#伏</span></td>
                </tr>
                <?php if($batObj->model != "battery24_voltage"){ ?>
                <tr>
                    <td>2</td>
                    <td>整组电流</td>
                    <td><span class="group_i" ></span></td>
                </tr>            
                <tr>
                    <td>3</td>
                    <td>电池温度</td>
                    <td><span class="bat_temp" ></span></td>
                </tr>
                <?php } ?>
                <tr>
                    <td>4</td>
                    <td>更新时间</td>
                    <td><span class="update_datetime" ></span></td>
                </tr>
            </tbody>
        </table>
        <?php if($batObj->model != "battery24_voltage"){ ?>
        <h2>单体电压</h2>
        <table class="table table-striped" id="bat_voltage_<?php echo $batObj->data_id;?>">
            <thead>
                <tr>        	                          
                    <th>节号</th>
                    <th>电压</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if($batObj->model=='battery_24') $row = 24; else $row = 32;
            if($type != "44" && $type != "11" && $type != "44i"){
            for($j = 0 ; $j < $row; $j++){?>
              <tr>
                  <td><?php echo $j+1;?></td>
                  <td><span></span></td>
              </tr>
           <?php }?>
          <?php }?>
           <?php if($type == "44"||$type == "44i"){?>
               <?php $row = 4; $row2 = 24;?>
               <?php for($j = 0 ; $j < $row; $j++){?>
                 <tr>
                     <td><?php echo $j+1;?></td>
                     <td><span></span></td>
                 </tr>
               <?php }?> 
               <?php for($j = 20 ; $j < $row2; $j++){?> 
                 <tr>
                     <td><?php echo $j+1;?></td>
                     <td><span></span></td>
                 </tr>
               <?php }?>
               <?php $row = 4; $row2 = 24;?>
               <?php for($j = 0 ; $j < $row; $j++){?>
                 <tr>
                     <td><?php echo $j+1;?></td>
                     <td><span></span></td>
                 </tr>
               <?php }?> 
               <?php for($j = 20 ; $j < $row2; $j++){?> 
                 <tr>
                     <td><?php echo $j+1;?></td>
                     <td><span></span></td>
                 </tr>
               <?php }?>
          <?php }?>
          
          <?php if($type == "11"){?>
               <?php $row = 11;?>
               <?php for($j = 0 ; $j < $row; $j++){?>
                 <tr>
                     <td><?php echo $j+1;?></td>
                     <td><span></span></td>
                 </tr>
               <?php }?> 
               <?php $row = 11;?>
               <?php for($j = 0 ; $j < $row; $j++){?>
                 <tr>
                     <td><?php echo $j+1;?></td>
                     <td><span></span></td>
                 </tr>
               <?php }?>
          <?php }?>
          
          
          
            </tbody>
        </table>
        <?php } ?>
    </div>
</div>
