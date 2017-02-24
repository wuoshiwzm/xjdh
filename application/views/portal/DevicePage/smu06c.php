<h4>性能指标</h4>
<p>
  <?php if($_SESSION['XJTELEDH_USERROLE'] == 'admin'){?>
  	<button class='btn btn-info settings'
		data_id='<?php echo $smu06cObj->data_id;?>'>动态设置</button>
  <?php }?>
  <button class='btn btn-info dev-info'
		data_id='<?php echo $smu06cObj->data_id;?>'
		model='<?php echo $smu06cObj->model;?>'>详细信息</button>
</p>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $smu06cObj->data_id;?>-dc'>
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

/* if ($smu06cObj->model == 'smu06c-ac') {
    $params = array('更新时间','A相输入电流','B相输入电流','C相输入电流','交流输入路数','交流切换状态','事故照明灯状态','当前工作路号','A相输入电流告警量','B相输入电流告警量','C相输入电流告警量');
    ?> */
    
if ($smu06cObj->model == 'smu06c-ac') {
    $params = array('更新时间','交流输入路数','交流切换状态','空开数量','用户自定义数量');
    ?>

<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $smu06cObj->data_id;?>-sps-ac-1'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前值</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($params as $key => $val){?>
	   <tr>
			<td><?php echo $key + 1;?></td>
			<td><?php echo $val;?></td>
			<td id='sps-ac-<?php echo $smu06cObj->data_id.'-field'.$key;?>'></td>	       
			<?php if(!isset($isShowSettingField) || $isShowSettingField  ){?>
	       <?php if($key > 0 && $key < 4){ ?>
	       <td></td>
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
	id='table-<?php echo $smu06cObj->data_id;?>-sps-ac-2'>
	<thead>
		<tr>
			<th>序号</th>
			<th>输入线/相电压AB/A</th>
			<th>输入线/相电压BC/B</th>
			<th>输入线/相电压CA/C</th>
			<th>输入频率</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>
<h4>交流输入各路告警状态</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $smu06cObj->data_id;?>-sps-ac-3'>
	<thead>
		<tr>
			<th>序号</th>
			<th>输入线/相电压AB/A告警</th>
			<th>输入线/相电压BC/B告警</th>
			<th>输入线/相电压CA/C告警</th>
			<th>交流防雷器丝断告警</th>
			<th>第一路交流输入停电告警</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>
<?php }else if($smu06cObj->model == 'smu06c-rc'){ $params = array('更新时间','整流模块输出电压','整流模块数量');?>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $smu06cObj->data_id;?>-sps-rc-1'>
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
			<td id='sps-rc-<?php echo $smu06cObj->data_id.'-field'.$key;?>'></td>
		</tr>
    <?php }?>
	</tbody>
</table>
<h4>整流输入各路状态</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $smu06cObj->data_id;?>-sps-rc-2'>
	<thead>
		<tr>
			<th>序号</th>
			<th>整流模块输出电流</th>
<!-- 			<th>模块温度</th> -->
			<th>模块限流点（百分数）</th>
			<th>模块输出电压</th>
			<th>交流AB线电压</th>
			<th>交流BC线电压</th>
			<th>交流CA线电压</th>
<!-- 			<th>模块位置号</th> -->
			<th>开机/关机状态</th>
			<th>限流/不限流状态</th>
			<th>浮充/均充/测试状态</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>
<h4>整流输入各路告警状态</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $smu06cObj->data_id;?>-sps-rc-3'>
	<thead>
		<tr>
			<th>序号</th>
<!-- 			<th>交流限功率状态</th> -->
<!-- 			<th>温度限功率状态</th> -->
<!-- 			<th>风扇全速状态</th> -->
			<th>WALK-In状态</th>
 			<th>模块顺序起机使能状态</th>
			<th>整流模块故障</th>
			<th>模块保护</th>
<!-- 			<th>风扇故障</th> -->
<!-- 			<th>模块过温</th> -->
			<th>模块通讯中断</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>
<?php
    } else 
        if ($smu06cObj->model == 'smu06c-dc') {
            $params = array('更新时间','直流电压上限','直流电压下限','第一屏电池组数','用户自定义数量P',
            		'定时测试间隔','电池测试终止时间','定时均充间隔');
            ?>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $smu06cObj->data_id;?>-sps-dc-1'>
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
			<td id='sps-dc-<?php echo $smu06cObj->data_id.'-field'.$key;?>'></td>
		</tr>
    <?php }?>
    </tbody>
</table>
<h4>电池参数</h4>
<?php
     $params = array('电池充电限流点(单位：A)','浮充电压（单位：V）','均充电压（单位：V）','电池下电电压（单位：V）','电池上电电压（单位：V）','LLVD1下电电压（单位：V）','LLVD1上电电压（单位：V）','每组电池额定容量（单位：Ah）','电池测试终止电压（单位：V）','电池组温补系数(单位：mV/℃)','电池温补中心点(单位：V）');
            ?>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $smu06cObj->data_id;?>-sps-dc-2'>
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
			<td><?php echo $key+1;?></td>
			<td><?php echo $val;?></td>
			<td id='sps-dc-battery<?php echo $smu06cObj->data_id.'-field'.$key?>'></td>
		</tr>
        <?php }?>
    </tbody>
</table>
<h4>告警参数</h4>
<?php
            $params = array('电池过压告警点(单位：V)','电池欠压告警点（单位：V）','电池充电过流告警点（单位：A）','电池过温告警点（单位：℃）','电池欠温告警点（单位：℃）','环境过温告警点（单位：℃）','环境欠温告警点（单位：℃）','环境过湿告警点（单位：℃）','环境欠湿告警点(单位：℃)');
            ?>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $smu06cObj->data_id;?>-sps-dc-3'>
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
			<td><?php echo $key+1;?></td>
			<td><?php echo $val;?></td>
			<td id='sps-dc-alert<?php echo $smu06cObj->data_id.'-field'.$key?>'></td>
		</tr>
        <?php }?>
    </tbody>
</table>
<?php }?>
