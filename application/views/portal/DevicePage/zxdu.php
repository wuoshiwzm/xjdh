<h4>性能指标</h4>
<p>
  <?php if($_SESSION['XJTELEDH_USERROLE'] == 'admin'){?>
      <button class='btn btn-info settings'
		data_id='<?php echo $zxduObj->data_id;?>'>动态设置</button>
  <?php }?>
  <button class='btn btn-info dev-info'
		data_id='<?php echo $zxduObj->data_id;?>'
		model='<?php echo $zxduObj->model;?>'>详细信息</button>
</p>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $zxduObj->data_id;?>-dc'>
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
<?php

if ($zxduObj->model == 'zxdu-ac') {
    $params = array('更新时间','A相输出电流','B相输出电流','C相输出电流','交流输入路数',
    		'开关数量','用户自定义状态数量','交流输入空开1','交流输入空开2','交流辅助输出开关','交流供电方式','输出电流L1');
    ?>

<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $zxduObj->data_id;?>-sps-ac-1'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前值</th>
			<?php if(!isset($isShowSettingField) || $isShowSettingField  ){?>
            <th>设置告警规则</th>
            <?php }?>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($params as $key => $val){?>
	   <tr>
			<td><?php echo $key + 1;?></td>
			<td><?php echo $val;?></td>
			<td id='sps-ac-<?php echo $zxduObj->data_id.'-field'.$key;?>'></td>	       
			<?php if(!isset($isShowSettingField) || $isShowSettingField  ){?>
	       <?php if($key > 0 && $key < 4){ ?>
	       <td class="hasThreshold"><button
					data_id='<?php echo $zxduObj->data_id;?>'
					field="<?php echo $key;?>" class="btn btn-warning setThreshold">设置告警规则</button></td>
	       <?php }else{ ?>
	       <td></td>
	       <?php } ?>
	       <?php }?>
       </tr>
   <?php }?>
	</tbody>
</table>
<h4>交流输入各路当前状态</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $zxduObj->data_id;?>-sps-ac-2'>
	<thead>
		<tr>
			<th>序号</th>
			<th>输入线/相电压AB/A</th>
			<th>输入线/相电压BC/B</th>
			<th>输入线/相电压CA/C</th>
			<th>输入频率</th>
			<th>自定义告警数</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
<h4>交流输入各路告警状态</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $zxduObj->data_id;?>-sps-ac-3'>
	<thead>
		<tr>
			<th>序号</th>
			<th>输入线/相电压AB/A告警</th>
			<th>输入线/相电压BC/B告警</th>
			<th>输入线/相电压CA/C告警</th>
			<th>交流主空开断</th>
			<th>交流停电</th>
			<th>交流防雷器异常</th>
			<th>交流辅助输出断</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>
<?php }else if($zxduObj->model == 'zxdu-rc'){ $params = array('更新时间','整流模块输出电压','整流模块数量');?>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $zxduObj->data_id;?>-sps-rc-1'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前状态</th>
		</tr>
	</thead>
	<tbody>
    <?php foreach ($params as $key => $val){?>
        <tr>
			<td><?php echo $key + 1;?></td>
			<td><?php echo $val;?></td>
			<td id='sps-rc-<?php echo $zxduObj->data_id.'-field'.$key;?>'></td>
		</tr>
    <?php }?>
	</tbody>
</table>
<h4>整流输入各路状态</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $zxduObj->data_id;?>-sps-rc-2'>
	<thead>
		<tr>
			<th>序号</th>
			<th>整流模块输出电流</th>
			<th>在位状态</th>
			<th>整流模块故障</th>
			<th>开机/关机状态</th>
			<th>限流/不限流状态</th>
			<th>浮充/均充/测试状态</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>
<?php
    } else 
        if ($zxduObj->model == 'zxdu-dc') {
            $params = array('更新时间','直流屏数量','直流输出电压','负载总电流','监测电池分路电流数量',
            		'电池电流1','电池电流2','电池电流3','电池电流4','用户自定义测量数','直流电压',
            		'直流负载熔丝/开关数量（m=15）','一次下电','二次下电',
            		'直流避雷器状态','负载断路器1状态','负载断路器2状态','蓄电池状态',
            		'电池放电状态');
            ?>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $zxduObj->data_id;?>-sps-dc-1'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前状态</th>
		
		
		<tr>
	
	</thead>
	<tbody>
    <?php foreach ($params as $key => $val){?>
        <tr>
			<td><?php echo $key+1;?></td>
			<td><?php echo $val;?></td>
			<td id='sps-dc-<?php echo $zxduObj->data_id.'-field'.$key;?>'></td>
		</tr>
    <?php }?>
    </tbody>
</table>


<h4>各组电池状态</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $zxduObj->data_id;?>-sps-dc-2'>
	<thead>
		<tr>
			<th>序号</th>
			<th>电池温度</th>
			<th>电池电压</th>
			<th>实时容量百分比</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>

<h4>负载熔丝告警状态</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $zxduObj->data_id;?>-sps-dc-3'>
	<thead>
		<tr>
			<th>熔丝1断</th>
			<th>熔丝2断</th>
			<th>熔丝3断</th>
			<th>熔丝4断</th>
			<th>熔丝5断</th>
			<th>熔丝6断</th>
			<th>熔丝7断</th>
			<th>熔丝8断</th>
			<th>熔丝9断</th>
			<th>熔丝10断</th>
			<th>熔丝11断</th>
			<th>熔丝12断</th>
			<th>熔丝13断</th>
			<th>熔丝14断</th>
			<th>熔丝15断</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>

<h4>电池状态告警量</h4>
<table
        class="table table-bordered responsive table-striped table-sortable"
        id='table-<?php echo $zxduObj->data_id;?>-sps-dc-5'>
        <thead>
                <tr>
                        <th>序号</th>
                        <th>回路断</th>
                        <th>电压低</th>
                        <th>温度高</th>
                        <th>温度低</th>
                        <th>温度无效</th>
                </tr>
        </thead>
        <tbody>

        </tbody>
</table>
<?php }?>
