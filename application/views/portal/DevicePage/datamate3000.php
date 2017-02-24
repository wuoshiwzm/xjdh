<div class='row-fluid'>
	<div class="span6">
		
		<h4>远程控制</h4>
		<?php if($_SESSION['XJTELEDH_USERROLE'] != 'noc') {?>
		<a href="####" class="remote_open btn btn-info">远程开机</a>
		<a href="####" class="remote_close btn btn-info">远程关机</a>
		<?php }?>	
		<h4>性能指标</h4>
    <?php if($_SESSION['XJTELEDH_USERROLE'] == 'admin'){?>
    <p>
			<a
				href='<?php echo site_url('portal/dynamicSetting/'.$dataObj->data_id);?>'
				target="_blank" class="btn btn-info">动态设置</a>
			<button class='btn btn-info dev-info'
				data_id='<?php echo $dataObj->data_id;?>'
				model='<?php echo $dataObj->model;?>'>详细信息</button>
		</p>    
    <?php }?>
    </div>
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
</div>
<div class="row-fluid ">
	<table
		class="table table-bordered table-striped responsive table-sortable">
		<thead>
			<tr>
				<th>序号</th>
				<th>信号量</th>
				<th>当前值</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1</td>
				<td>室内温度</td>
				<td class="hasThreshold"
					id='datamate3000-<?php echo $dataObj->data_id;?>-1'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>' field="temperature1"
						class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>2</td>
				<td>室内湿度</td>
				<td class="hasThreshold"
					id='datamate3000-<?php echo $dataObj->data_id;?>-2'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>' field="temperature2"
						class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>3</td>
				<td>室外温度</td>
				<td class="hasThreshold"
					id='datamate3000-<?php echo $dataObj->data_id;?>-3'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>' field="temperature3"
						class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>4</td>
				<td>空调开关机状态</td>
				<td class="hasThreshold"
					id='datamate3000-<?php echo $dataObj->data_id;?>-4'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>' field="temperature4"
						class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>5</td>
				<td>开机温度</td>
				<td class="hasThreshold"
					id='datamate3000-<?php echo $dataObj->data_id;?>-5'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>' field="temperature5"
						class="btn btn-info changeSetting">修改设置</button></td>
			</tr>
			<tr>
				<td>6</td>
				<td>关机湿度</td>
				<td class="hasThreshold"
					id='datamate3000-<?php echo $dataObj->data_id;?>-6'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>' field="humid1"
						class="btn btn-important changeSetting">修改设置</button></td>
			</tr>
			<tr>
				<td>7</td>
				<td>温度设定点</td>
				<td class="hasThreshold"
					id='datamate3000-<?php echo $dataObj->data_id;?>-7'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>' field="humid2"
						class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>8</td>
				<td>温度偏差</td>
				<td class="hasThreshold"
					id='datamate3000-<?php echo $dataObj->data_id;?>-8'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>' field="humid3"
						class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>9</td>
				<td>湿度设定点</td>
				<td class="hasThreshold"
					id='datamate3000-<?php echo $dataObj->data_id;?>-9'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>' field="humid4"
						class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>10</td>
				<td>湿度偏差</td>
				<td class="hasThreshold"
					id='datamate3000-<?php echo $dataObj->data_id;?>-10'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>' field="humid5"
						class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>11</td>
				<td>开/关机状态</td>
				<td id='datamate3000-<?php echo $dataObj->data_id;?>-11'><span></span></td>
			</tr>
			<tr>
				<td>12</td>
				<td>风机状态</td>
				<td class="hasThreshold"
					id='datamate3000-<?php echo $dataObj->data_id;?>-12'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>'
						field="outside_temperature" class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>13</td>
				<td>制冷状态</td>
				<td class="hasThreshold"
					id='datamate3000-<?php echo $dataObj->data_id;?>-13'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>'
						field="outside_humidity" class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>14</td>
				<td>加热状态</td>
				<td class="hasThreshold"
					id='datamate3000-<?php echo $dataObj->data_id;?>-14'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>'
						field="humidifier_current" class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>15</td>
				<td>加湿状态</td>
				<td class="hasThreshold"
					id='datamate3000-<?php echo $dataObj->data_id;?>-15'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>'
						field="average_temperature" class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>16</td>
				<td>除湿状态</td>
				<td class="hasThreshold"
					id='datamate3000-<?php echo $dataObj->data_id;?>-16'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>'
						field="average_humid" class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
			     <td>17</td>
			     <td>机组状态</td>
			     <td id='datamate3000-<?php echo $dataObj->data_id;?>-17'>
			     </td>
			</tr>
			<tr>
			     <td>18</td>
			     <td>机组属性</td>
			     <td  id='datamate3000-<?php echo $dataObj->data_id;?>-18'>
			     </td>
			</tr>
			<tr>
			     <td>19</td>
			     <td>高压锁定状态</td>
			     <td  id='datamate3000-<?php echo $dataObj->data_id;?>-19'>
			     </td>
			</tr>
			<tr>
			     <td>20</td>
			     <td>低压锁定状态</td>
			     <td  id='datamate3000-<?php echo $dataObj->data_id;?>-20'>
			     </td>
			</tr>
			<tr>
			     <td>21</td>
			     <td>排气锁定状态</td>
			     <td  id='datamate3000-<?php echo $dataObj->data_id;?>-21'>
			     </td>
			</tr>
			<tr>
				<td>22</td>
				<td>更新时间</td>
				<td id='datamate3000-<?php echo $dataObj->data_id;?>-22'></td>
			</tr>
		</tbody>
	</table>
	<h4>报警状态</h4>
<table
	class="table table-bordered responsive table-striped table-sortable"
	id='table-<?php echo $dataObj->data_id;?>-alarm'>
	<thead>
		<tr>
			<th>报警名称</th>
			<th>当前状态</th>
			<th>报警名称</th>
			<th>当前状态</th>
			<th>报警名称</th>
			<th>当前状态</th>
			<th>报警名称</th>
			<th>当前状态</th>
		</tr>
	</thead>
	<tbody>
        <tr>
            <td>高压报警</td>
            <td></td>
            <td>低压报警</td>
            <td></td>
            <td>高温报警</td>
            <td></td>
            <td>低温报警</td>
            <td></td>
        </tr>
        <tr>
            <td>高湿报警</td>
            <td></td>
            <td>低湿报警</td>
            <td></td>
            <td>电源故障报警</td>
            <td></td>
            <td>短周期报警</td>
            <td></td>
        </tr>
        <tr>
            <td>用户自定义1报警</td>
            <td></td>
            <td>用户自定义2报警</td>
            <td></td>
            <td>主风机维护报警</td>
            <td></td>
            <td>加湿器维护报警</td>
            <td></td>
        </tr>        
        <tr>
            <td>过滤网维护报警</td>
            <td></td>
            <td>通讯故障报警</td>
            <td></td>
            <td>盘管冻结报警</td>
            <td></td>
            <td>加湿器故障报警</td>
            <td></td>
        </tr>
        <tr>
            <td>传感器板丢失报警</td>
            <td></td>
            <td>排气温度故障报警</td>
            <td></td>
            <td>电源丢失故障报警</td>
            <td></td>
            <td>电源过欠压报警</td>
            <td></td>
        </tr>
        <tr>
            <td>电源缺相报警</td>
            <td></td>
            <td>电源频率偏移报警</td>
            <td></td>
            <td>地板溢水报警</td>
            <td></td>
            <td>节能卡报警</td>
            <td></td>
        </tr>
	</tbody>
</table>
</div>
