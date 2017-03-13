<div class="alert"  id="<?php echo $dataObj->data_id;?>-alert" style="display:none;">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<i class="icon-exclamation-sign"></i><strong>警告！</strong> 协议未完全匹配，个别数据可能无效!
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
	id='<?php echo $dataObj->data_id;?>-sps-ac-1'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前值</th>
		</tr>
	</thead>
	<tbody>
	 <?php if(isset($ia_support) && $ia_support){ ?>
	 <tr>
	   <td>1</td>
	   <td>交流屏输出电流A</td>
	   <td><span class="label label-success"  id="<?php echo $dataObj->data_id.'-ia'; ?>"></span></td>
	 </tr>
	 <?php } ?>
	  <?php if(isset($ib_support) && $ib_support){ ?>
	 <tr>
	   <td>2</td>
	   <td>交流屏输出电流B</td>
	   <td><span class="label label-success"  id="<?php echo $dataObj->data_id.'-ib'; ?>"></span></td>
	 </tr>
	 <?php } ?>
	  <?php if(isset($ic_support) && $ic_support){ ?>
	 <tr>
	   <td>3</td>
	   <td>交流屏输出电流C</td>
	   <td><span class="label label-success" id="<?php echo $dataObj->data_id.'-ic'; ?>"></span></td>
	 </tr>
	 <?php } ?>
	 <tr>
	   <td>4</td>
	   <td>交流输入路数</td>
	   <td><span class="label label-success" id="<?php echo $dataObj->data_id.'-channel_count'; ?>"></span></td>
	 </tr>
	 <?php $p40_43_index = -1; 
	   foreach ($p40_43_label as $key => $val){
            if(!$val)continue;  $p40_43_index++;?>
	   <tr id="<?php echo $dataObj->data_id.'-p40_43'.$p40_43_index; ?>">
			<td></td>
			<td><?php echo $key;?></td>
			<td><span class="label label-success" id='<?php echo $dataObj->data_id.'-p40_43-field'.$p40_43_index;?>'></span></td>	       
       </tr>
    <?php }?>   
	 <?php if(isset($ia_alert_support) && $ia_alert_support){ ?>
	 <tr>
	   <td></td>
	   <td>A相输入电流告警状态</td>
	   <td><span class="label label-success" id="<?php echo $dataObj->data_id.'-ia_alert'; ?>"></span></td>
	 </tr>
	 <?php } ?>
	  <?php if(isset($ib_alert_support) && $ib_alert_support){ ?>
	 <tr>
	   <td></td>
	   <td>B相输入电流告警状态</td>
	   <td><span class="label label-success"  id="<?php echo $dataObj->data_id.'-ib_alert'; ?>"></span></td>
	 </tr>
	 <?php } ?>
	  <?php if(isset($ic_alert_support) && $ic_alert_support){ ?>
	 <tr>
	   <td></td>
	   <td>C相输入电流告警状态</td>
	   <td><span class="label label-success"  id="<?php echo $dataObj->data_id.'-ic_alert'; ?>"></span></td>
	 </tr>
	 <?php } ?>
	 <tr  id="<?php echo $dataObj->data_id."-lastTr"; ?>">
	   <td></td>
	   <td>输出空开数量</td>
	   <td id="<?php echo $dataObj->data_id.'-airlock_count'; ?>"></td>
	 </tr>
	</tbody>
</table>
<h4>交流输入各路当前状态</h4>
<table  id='<?php echo $dataObj->data_id;?>-sps-ac-2'
	class="table table-bordered responsive table-striped table-sortable">
	<thead>
		<tr>
			<th>序号</th>
			<th>输入线/相电压AB/A</th>
			<th>输入线/相电压BC/B</th>
			<th>输入线/相电压CA/C</th>
			<th>输入频率</th>
			<?php foreach($p40_41_label as $key=>$support){
			    if(!$support)continue; ?>
			<th><?php echo $key; ?></th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
<h4>交流输入各路告警状态</h4>
<table id='<?php echo $dataObj->data_id;?>-sps-ac-3'
	class="table table-bordered responsive table-striped table-sortable"
	>
	<thead>
		<tr>
			<th>序号</th>
			<th>输入线/相电压AB/A告警</th>
			<th>输入线/相电压BC/B告警</th>
			<th>输入线/相电压CA/C告警</th>
			<th>频率告警</th>
			<?php foreach($p40_44_label as $key=>$show){
			     if(!$show)continue; ?>
			<th><?php echo $key; ?></th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>