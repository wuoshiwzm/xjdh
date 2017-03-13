<p>最后更新时间:<span id="<?php echo $dataObj->data_id;?>-update_datetime"></span>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $dataObj->data_id;?>'>
	<thead>
		<tr>
			<th>序号</th>
			<th>信号名称</th>
			<th>当前值</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$signalArray = array("系统电压","负载总电流(A)","电池组1的电流(A)","电池组2的电流(A)",
            "电池温度(℃)","环境温度(℃)","电池组1当前容量(小时)","电池组2当前容量(小时)",
            "单相交流输入电压(V)","单相交流输入电流(A)","单相交流输入频率(Hz)","三相交流输入电压1(V)","三相交流输入电压2(V)",
            "三相交流输入电压3(V)","三相交流输入电流1(A)","三相交流输入电流2(A)","三相交流输入电流3(A)","三相交流输入频率(Hz)");
	foreach ($signalArray as $key => $val){?>
	   <tr>
			<td><?php echo $key + 1;?></td>
			<td><?php echo $val;?></td>
			<td id='dk04-<?php echo $dataObj->data_id.'-field'.$key;?>'></td>
       </tr>
   <?php }?>
	</tbody>
</table>
<h4>告警状态</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='<?php echo $dataObj->data_id;?>-sps-rc-2'>
	<thead>
	   <tr>
	       <th>信号名</th>
	       <th>状态</th>
	       <th>信号名</th>
	       <th>状态</th>
	       <th>信号名</th>
	       <th>状态</th>
	       <th>信号名</th>
	       <th>状态</th>
	       <th>信号名</th>
	       <th>状态</th>
	       <th>信号名</th>
	       <th>状态</th>
	</thead>
	<tbody id="tbAlarm">
	   <tr>
	       <td>EEPROM内的参数超出范围</td>
	       <td><span class="label label-success alarm0"></span></td>
	       <td>整流模块非紧急告警</td>
	       <td><span class="label label-success alarm1"></span></td>
	       <td>整流模块紧急告警</td>
	       <td><span class="label label-success alarm2"></span></td>
	       <td>熔丝故障</td>
	       <td><span class="label label-success alarm3"></span></td>
	       <td>低压断路（LVDS）开关断开</td>
	       <td><span class="label label-success alarm4"></span></td>
	       <td>输出电压过高告警</td>
	       <td><span class="label label-success alarm5"></span></td>
	   </tr>
	   <tr>
	       <td>输出电压过低告警</td>
	       <td><span class="label label-success alarm6"></span></td>
	       <td>电池处于放电状态</td>
	       <td><span class="label label-success alarm7"></span></td>
	       <td>整流模块通信故障</td>
	       <td><span class="label label-success alarm8"></span></td>
	       <td>交流输入电压告警</td>
	       <td><span class="label label-success alarm9"></span></td>
	       <td>交流输入频率告警</td>
	       <td><span class="label label-success alarm10"></span></td>
	       <td>环境温度过高告警</td>
	       <td><span class="label label-success alarm11"></span></td>
	    </tr>
	    <tr>
	       <td>电池温度过高告警</td>
	       <td><span class="label label-success alarm12"></span></td>
	       <td>电池充电限流</td>
	       <td><span class="label label-success alarm13"></span></td>
	       <td>电池组放电不平衡(Ibat1&lt;Ibat2)</td>
	       <td><span class="label label-success alarm14"></span></td>
	       <td>电池组放电不平衡(Ibat1&gt;Ibat2)</td>
	       <td><span class="label label-success alarm15"></span></td>
	       <td>均衡充电状态</td>
	       <td><span class="label label-success alarm16"></span></td>
	       <td>整流模块输出电压过高关机</td>
	       <td><span class="label label-success alarm17"></span></td>
	    </tr>
	    <tr>
	       <td>电池开关断开</td>
	       <td><span class="label label-success alarm18"></span></td>
	       <td>电池温度传感器故障</td>
	       <td><span class="label label-success alarm19"></span></td>
	       <td>整流模块故障</td>
	       <td><span class="label label-success alarm20"></span></td>
	       <td>整流模块参数超出范围</td>
	       <td><span class="label label-success alarm21"></span></td>
	       <td></td>
	       <td></td>
	       <td></td>
	       <td></td>
	    </tr>
	</tbody>
</table>
<h4>整流各路状态</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='<?php echo $dataObj->data_id;?>-sps-rc-3'>
	<thead>
		<tr>
			<th>序号</th>
			<th>整流模块电压</th>
			<th>整流模块输出电流</th>
			<th>散热器温度</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
<h4>整流输入各路告警状态</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='<?php echo $dataObj->data_id;?>-sps-rc-4'>
	<thead>
		<tr>
			<th>序号</th>
			<th>整流模块号码</th>
			<th>输出电压过高</th>
			<th>输出电压过低</th>
			<th>地址错误</th>
			<th>输入开关断开</th>
			<th>内部直流部分故障</th>
			<th>内部控制回路电压低</th>
			<th>温度过高</th>
			<th>回路故障</th>
			<th>输出限流</th>
			<th>风扇故障</th>
			<th>负载过轻</th>
			<th>输入开关跳开</th>
			<th>关机</th>
			<th>接收MCSU指令而关机</th>
			<th>内部参考电压超出范围</th>
			<th>通信故障</th>
			<th>输出电压过高关机</th>
			<th>交流输入故障</th>
			<th>输出功率限制</th>
			<th>继电器故障</th>
			<th>故障关机</th>
			<th>处于均衡工作状态</th>
			<th>告警</th>
			<th>警告</th>
			<th>温度传感器故障</th>
			<th>内部直流-直流变换部分故障</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>