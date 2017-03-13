<h4>性能指标</h4>
<p>
  <?php if($_SESSION['XJTELEDH_USERROLE'] == 'admin'){?>
	<button class='btn btn-info settings'
		data_id='<?php echo $dataObj->data_id;?>'>动态设置</button>
  <?php }?>
  <button class='btn btn-info dev-info'
		data_id='<?php echo $dataObj->data_id;?>'
		model='<?php echo $dataObj->model;?>'>详细信息</button>
</p>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $dataObj->data_id;?>-dc'>
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
if ($dataObj->model == 'psma-ac') {
    $params = array('更新时间','A相输入电流','B相输入电流','C相输入电流','交流输入路数','交流切换状态','事故照明灯状态','当前工作路号','A相输入电流告警量','B相输入电流告警量','C相输入电流告警量');
    ?>

<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $dataObj->data_id;?>-sps-ac-1'>
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
			<td id='sps-ac-<?php echo $dataObj->data_id.'-field'.$key;?>'></td>	       
			<?php if(!isset($isShowSettingField) || $isShowSettingField  ){?>
	       <?php if($key > 0 && $key < 4){ ?>
	       <td class="hasThreshold"><button
					data_id='<?php echo $dataObj->data_id;?>'
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
	id='table-<?php echo $dataObj->data_id;?>-sps-ac-2'>
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
	id='table-<?php echo $dataObj->data_id;?>-sps-ac-3'>
	<thead>
		<tr>
			<th>序号</th>
			<th>输入线/相电压AB/A告警</th>
			<th>输入线/相电压BC/B告警</th>
			<th>输入线/相电压CA/C告警</th>
			<th>频率告警</th>
			<th>交流输入空开跳</th>
			<th>交流输出空开跳</th>
			<th>防雷器断</th>
			<th>交流输入1停电</th>
			<th>交流输入2停电</th>
			<th>交流输入3停电</th>
			<th>市电切换失败</th>
			<th>交流屏通讯中断</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>
<?php }else if($dataObj->model == 'psma-rc'){ $params = array('更新时间','整流模块输出电压','整流模块数量');?>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $dataObj->data_id;?>-sps-rc-1'>
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
			<td id='sps-rc-<?php echo $dataObj->data_id.'-field'.$key;?>'></td>
		</tr>
    <?php }?>
	</tbody>
</table>
<h4>整流输入各路状态</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $dataObj->data_id;?>-sps-rc-2'>
	<thead>
		<tr>
			<th>序号</th>
			<th>整流模块输出电流</th>
			<th>模块温度</th>
			<th>模块限流点（百分数）</th>
			<th>模块输出电压</th>
			<th>输出电压保护点</th>
			<th>开机/关机状态</th>
			<th>限流/不限流状态</th>
			<th>浮充/均充/测试状态</th>
			<th>模块的控制状态,自动或手动</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>
<h4>整流输入各路告警状态</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $dataObj->data_id;?>-sps-rc-3'>
	<thead>
		<tr>
			<th>序号</th>
			<th>整流模块故障</th>
			<th>模块保护</th>
			<th>风扇故障</th>
			<th>模块过温</th>
			<th>模块通讯中断</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>
<?php
    } else 
        if ($dataObj->model == 'psma-dc') {
            $params = array('更新时间','直流输出电压','总负载电流','蓄电池组数','监测直流分路电流数','直流电压告警','直流熔断丝数量','电池组1电压','电池组2电压','电池房温度','测点1温度','测点2温度');
            ?>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $dataObj->data_id;?>-sps-dc-1'>
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
			<td id='sps-dc-<?php echo $dataObj->data_id.'-field'.$key;?>'></td>
		</tr>
    <?php }?>
    </tbody>
</table>
<h4>蓄电池组分路电流</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $dataObj->data_id;?>-sps-dc-2'>
	<tr>
		<td>组一</td>
		<td></td>
	</tr>
	<tr>
		<td>组二</td>
		<td></td>
	</tr>
</table>

<h4>蓄电池充、放电电流</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $dataObj->data_id;?>-sps-dc-3'>
	<tr>
		<td>分路一</td>
		<td></td>
		<td>分路二</td>
		<td></td>
		<td>分路三</td>
		<td></td>
	</tr>
	<tr>
		<td>分路四</td>
		<td></td>
		<td>分路五</td>
		<td></td>
		<td>分路六</td>
		<td></td>
	</tr>
</table>
<h4>直流熔断丝告警</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $dataObj->data_id;?>-sps-dc-4'>
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
<?php $params = array('电池组1熔丝断','电池组2熔丝断','电池组1充电过流','电池组2充电过流','电池组1保护','电池组2保护','二次下电','电池房过温','测点1过温','测点2过温','直流屏通讯中断','电池组1电压异常','电池组2电压异常');?>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $dataObj->data_id;?>-sps-dc-5'>
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
			<td id='sps-dc-alarm-<?php echo $dataObj->data_id.'-field'.$key?>'></td>
		</tr>
        <?php }?>
    </tbody>
</table>
<?php }?>
