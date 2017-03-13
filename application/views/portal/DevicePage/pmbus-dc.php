<div class="alert"  id="<?php echo $dataObj->data_id;?>-alert" style="display:none;">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<i class="icon-exclamation-sign"></i><strong>警告！</strong>  协议未完全匹配，个别数据可能无效!
</div>
<h4>性能指标</h4>
<p>
  <?php if($_SESSION['XJTELEDH_USERROLE'] == 'admin'){?>
	<button class='btn btn-info settings' data_id='<?php echo $dataObj->data_id;?>'>动态设置</button>
  <?php }?>
  <button class='btn btn-info dev-info'	data_id='<?php echo $dataObj->data_id;?>'
		model='<?php echo $dataObj->model;?>'>详细信息</button>
</p>
<p>最后更新时间:<span id="<?php echo $dataObj->data_id;?>-update_datetime"></span>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='<?php echo $dataObj->data_id;?>-sps-dc-1'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前值</th>
		<tr>	
	</thead>
	<tbody>
	<tr>
	<td>1</td>
	<td>直流输出电压</td>
	<td id="<?php echo $dataObj->data_id.'-v'; ?>"></td>
	</tr>
	<tr>
	<td>2</td>
	<td>总负载电流</td>
	<td id="<?php echo $dataObj->data_id.'-i'; ?>"></td>
	</tr>
	<tr>
	<td>3</td>
	<td>监测电池分路电流数量</td>
	<td id="<?php echo $dataObj->data_id.'-m'; ?>"></td>
	</tr>
	<?php for($i=0; $i < $m; $i++){ ?>
	<tr class="dc_m">
    	<td></td>
    	<td>电池电流<?php echo $i+1; ?></td>
    	<td id="<?php echo $dataObj->data_id.'-m'.$i; ?>"></td>
	</tr>
	<?php } ?>
	<tr>
	<td></td>
	<td>监测直流分路电流数</td>
	<td id="<?php echo $dataObj->data_id.'-n'; ?>"></td>
	</tr>
	<?php for($i=0; $i < $n; $i++){ ?>
	<tr class="dc_n">
    	<td></td>
    	<td>直流分路电流<?php echo $i+1; ?></td>
    	<td id="<?php echo $dataObj->data_id.'-n'.$i; ?>"></td>
	</tr>
	<?php } ?>
	<?php if($dataObj->model == "zxdu58-b121v21-dc"){ ?>
	<tr>
	<td></td>
	<td>有无测试报告</td>
	<td id="<?php echo $dataObj->data_id.'-has_report'; ?>"></td>
	</tr>
	<tr>
	<td></td>
	<td>电池测试结束时间</td>
	<td id="<?php echo $dataObj->data_id.'-test_end'; ?>"></td>
	</tr>
	<tr>
	<td></td>
	<td>电池测试持续时间（分钟）</td>
	<td id="<?php echo $dataObj->data_id.'-duration_minutes'; ?>"></td>
	</tr>
	<tr>
	<td></td>
	<td>电池放电容量（Ah）</td>
	<td id="<?php echo $dataObj->data_id.'-discharge_capacity'; ?>"></td>
	</tr>
	<?php } ?>
	<?php $pi=-1;foreach($p_label as $pl=>$show){
	          $pi++; 
	          if(!$show)continue;?>
	<tr>
	<td></td>
	<td><?php echo $pl.'(用户自定义)'; ?></td>
	<td class="dc_p" id="<?php echo $dataObj->data_id."-dc_p".$pi; ?>"></td>
	</tr>
	<?php } ?>
	<tr id="<?php echo $dataObj->data_id.'-lastTr'; ?>">
	<td></td>
	<td>直流电压告警</td>
	<td id="<?php echo $dataObj->data_id.'-alert_v'; ?>"></td>
	</tr>
	
    </tbody>
</table>
<h4>直流熔断丝告警</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='<?php echo $dataObj->data_id;?>-sps-dc-2'>
	<thead>
		<tr>
			<th>熔丝序号</th>
			<th>当前状态</th>
			<th>熔丝序号</th>
			<th>当前状态</th>
			<th>熔丝序号</th>
			<th>当前状态</th>
			<th>熔丝序号</th>
			<th>当前状态</th>
			<th>熔丝序号</th>
			<th>当前状态</th>
			<th>熔丝序号</th>
			<th>当前状态</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
<h4>告警</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='<?php echo $dataObj->data_id;?>-sps-dc-5'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前状态</th>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前状态</th>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前状态</th>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前状态</th>
		</tr>
	</thead>
	<tbody>
        <?php $api = -1; $pi = -1; foreach ($alert_p_label as $key => $val){
                $pi++;
                if(is_array($val))
                {
                    foreach($val as $ak=>$av)
                    {
                        if(!$av)
                        {
                            continue;
                        }
                        $api++;
                        if($api%4 == 0)
                        {
                            echo "<tr>";
                        }
                        ?>
            			<td><?php echo $api+1; ?></td>
            			<td><?php echo $ak; ?></td>
            			<td><span class="label label-success"  id='<?php echo $dataObj->data_id.'-alert_p'.$api; ?>'></span></td>
                    <?php }
                }else{
                    if(!$val){ 
                        continue;
                    }
                    $api++;
                    if($api%4 == 0)
                    {
                        echo "<tr>";
                    }
                    ?>
        			<td><?php echo $api+1;?></td>
        			<td><?php echo $key;?></td>
        			<td><span class="label label-success"  id='<?php echo $dataObj->data_id.'-alert_p'.$api?>'></span></td>
    		   <?php }  
         if($api%4 == 3)
               {
                   echo "</tr>";
               }    
                     
        }
        if($api%4 != 3)
        {
            for($i=0; $i < (3-$api%4); $i++)
            {
                echo "<td></td><td></td><td></td>";
            }
            echo "</tr>";
        }
        ?>
    </tbody>
</table>