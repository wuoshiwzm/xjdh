<h3><?php echo $aegObj->name;?></h3>
<h4>性能指标</h4>
<p>
<?php if($_SESSION['XJTELEDH_USERROLE'] == 'admin'){?>
    <a
		href='<?php echo site_url('portal/dynamicSetting/'.$aegObj->data_id);?>'
		target="_blank" class="btn btn-info">动态设置</a>
<?php }?>
    <button class='btn btn-info dev-info'
		data_id='<?php echo $aegObj->data_id;?>'
		model='<?php echo $aegObj->model;?>'>详细信息</button>
</p>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $aegObj->data_id;?>-dc'>
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

if ($aegObj->model == 'aeg-ms10se') {
    $reg1 = array('频率F','相电压V1','相电压V2','相电压V3','相电压均值Vvavg','线电压V12','线电压V23','线电压V31','线电压均值Vlavg','相（线）电流I1','相（线）电流I2','相（线）电流I3','三相电流均值Iavg','中线电流In',
            '分相有功功率P1','分相有功功率P2','分相有功功率P3','系统有功功率Psum','分相无功功率Q1','分相无功功率Q2','分相无功功率Q3','系统无功功率Qsum','分相视在功率S1','分相视在功率S2','分相视在功率S3','系统视在功率Ssum',
            '分相功率因数PF1','分相功率因数PF2','分相功率因数PF3','系统功率因数PF','系统有功功率Psum','系统无功功率Qsum','系统视在功率Ssum');
    $reg2 = array('有功电度 Ep_imp','有功电度 Ep_exp','感性无功电度 Eq_imp','容性无功电度 Eq_exp','总有功电度 Ep_total','净有功电度 Ep_net','总电度 Eq_total','净无功电度 Eq_net');
    $di = array('DI1','DI2','DI3','DI4','DI5','DI6');
    $d_o = array('DO1','DO2','DO3','DO4','DO5','DO6');
    ?>

<h4>基本测量参数</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $aegObj->data_id;?>-aeg-ms10se-reg1'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前值</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($reg1 as $key => $val){?>
	   <tr>
			<td><?php echo $key + 1;?></td>
			<td><?php echo $val;?></td>
			<td id='aeg-ms10se-reg1-<?php echo $aegObj->data_id.'-field'.$key;?>'></td>
		</tr>
   <?php }?>
	</tbody>
</table>

<h4>电度测量参数</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $aegObj->data_id;?>-aeg-ms10se-reg2'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前值</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($reg2 as $key => $val){?>
	   <tr>
			<td><?php echo $key + 1;?></td>
			<td><?php echo $val;?></td>
			<td id='aeg-ms10se-reg2-<?php echo $aegObj->data_id.'-field'.$key;?>'></td>
		</tr>
   <?php }?>
	</tbody>
</table>


<h4>DI数据参数</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $aegObj->data_id;?>-aeg-ms10se-di'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前值</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($di as $key => $val){?>
	   <tr>
			<td><?php echo $key + 1;?></td>
			<td><?php echo $val;?></td>
			<td id='aeg-ms10se-di-<?php echo $aegObj->data_id.'-field'.$key;?>'></td>
		</tr>
   <?php }?>
	</tbody>
</table>


<h4>DO数据参数</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $aegObj->data_id;?>-aeg-ms10se-do'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前值</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($d_o as $key => $val){?>
	   <tr>
			<td><?php echo $key + 1;?></td>
			<td><?php echo $val;?></td>
			<td id='aeg-ms10se-do-<?php echo $aegObj->data_id.'-field'.$key;?>'></td>
		</tr>
   <?php }?>
	</tbody>
</table>
<?php
} elseif ($aegObj->model == 'aeg-ms10m') {
    $pRt = array('A相电压','B相电压','C相电压','相平均电压','AB相电压','BC相电压','CA相电压','线平均电压','A相电流','B相电流','C相电流','相平均电流','零序电流','A相有功功率','B相有功功率','C相有功功率','三相有功功率','A相无功功率',
            'B相无功功率','C相无功功率','三相无功功率','A相视在功率','B相视在功率','C相视在功率','三相视在功率','A相功率因数','B相功率因数','C相功率因数','三相功率因数','频率','开入量','有功输入电度','有功输出电度','无功输入电度','无功输出电度',
            '开出量当前状态(实时)');
    $pAvg = array('A相电压','B相电压','C相电压','AB相电压','BC相电压','CA相电压','A相电流','B相电流','C相电压','零序电流','三相有功功率','三相无功功率','三相视在功率','频率');
    $pMax = array('A相电压','B相电压','C相电压','AB相电压','BC相电压','CA相电压','A相电流','B相电流','C相电压','零序电流','三相有功功率','三相无功功率','三相视在功率','频率');
    $pWave = array('A相电压谐波畸变率','B相电压谐波畸变率','C相电压谐波畸变率','A相电流谐波畸变率','B相电流谐波畸变率','C相电流谐波畸变率','31次谐波含量数据区','31次谐波含量数据区','31次谐波含量数据区','31次谐波含量数据区','31次谐波含量数据区',
            '31次谐波含量数据区');
    ?>
<h4>实时基本测量数据</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $aegObj->data_id;?>-aeg-ms10m-rt'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前值</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($pRt as $key => $val){?>
	   <tr>
			<td><?php echo $key + 1;?></td>
			<td><?php echo $val;?></td>
			<td id='aeg-ms10se-rt-<?php echo $aegObj->data_id.'-field'.$key;?>'></td>
		</tr>
   <?php }?>
	</tbody>
</table>

<h4>单位时间内最大数据</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $aegObj->data_id;?>-aeg-ms10m-max'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前值</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($pAvg as $key => $val){?>
	   <tr>
			<td><?php echo $key + 1;?></td>
			<td><?php echo $val;?></td>
			<td id='aeg-ms10se-max-<?php echo $aegObj->data_id.'-field'.$key;?>'></td>
		</tr>
   <?php }?>
	</tbody>
</table>
<h4>单位时间内平均数据</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $aegObj->data_id;?>-aeg-ms10m-avg'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前值</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($pAvg as $key => $val){?>
	   <tr>
			<td><?php echo $key + 1;?></td>
			<td><?php echo $val;?></td>
			<td id='aeg-ms10se-avg-<?php echo $aegObj->data_id.'-field'.$key;?>'></td>
		</tr>
   <?php }?>
	</tbody>
</table>
<h4>谐波分析数据</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $aegObj->data_id;?>-aeg-ms10m-wave'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前值</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($pAvg as $key => $val){?>
	   <tr>
			<td><?php echo $key + 1;?></td>
			<td><?php echo $val;?></td>
			<td id='aeg-ms10se-wave-<?php echo $aegObj->data_id.'-field'.$key;?>'></td>
		</tr>
   <?php }?>
	</tbody>
</table>
<?php }?>
