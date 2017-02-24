<div class='row-fluid'>
	<div class="span6">
		<h4>远程控制</h4>
		<?php if($_SESSION['XJTELEDH_USERROLE'] != 'noc') {?>
		<a href="####" class="remote_open btn btn-info">远程开机</a> <a
			href="####" class="remote_close btn btn-info">远程关机</a><?php }?>	
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
				<td>室内温度1</td>
				<td class="hasThreshold"
					id='fresh-air-<?php echo $dataObj->data_id;?>-1'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>' field="temperature1"
						class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>2</td>
				<td>室内温度2</td>
				<td class="hasThreshold"
					id='fresh-air-<?php echo $dataObj->data_id;?>-2'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>' field="temperature2"
						class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>3</td>
				<td>室内温度3</td>
				<td class="hasThreshold"
					id='fresh-air-<?php echo $dataObj->data_id;?>-3'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>' field="temperature3"
						class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>4</td>
				<td>室内温度4</td>
				<td class="hasThreshold"
					id='fresh-air-<?php echo $dataObj->data_id;?>-4'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>' field="temperature4"
						class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>5</td>
				<td>室内温度5</td>
				<td class="hasThreshold"
					id='fresh-air-<?php echo $dataObj->data_id;?>-5'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>' field="temperature5"
						class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>6</td>
				<td>室内湿度1</td>
				<td class="hasThreshold"
					id='fresh-air-<?php echo $dataObj->data_id;?>-6'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>' field="humid1"
						class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>7</td>
				<td>室内湿度2</td>
				<td class="hasThreshold"
					id='fresh-air-<?php echo $dataObj->data_id;?>-7'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>' field="humid2"
						class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>8</td>
				<td>室内湿度3</td>
				<td class="hasThreshold"
					id='fresh-air-<?php echo $dataObj->data_id;?>-8'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>' field="humid3"
						class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>9</td>
				<td>室内湿度4</td>
				<td class="hasThreshold"
					id='fresh-air-<?php echo $dataObj->data_id;?>-9'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>' field="humid4"
						class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>10</td>
				<td>室内湿度5</td>
				<td class="hasThreshold"
					id='fresh-air-<?php echo $dataObj->data_id;?>-10'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>' field="humid5"
						class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>11</td>
				<td>出风温度</td>
				<td class="hasThreshold"
					id='fresh-air-<?php echo $dataObj->data_id;?>-11'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>'
						field="wind_temperature" class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>12</td>
				<td>出风湿度</td>
				<td class="hasThreshold"
					id='fresh-air-<?php echo $dataObj->data_id;?>-12'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>'
						field="wind_humidity" class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>13</td>
				<td>室外温度</td>
				<td class="hasThreshold"
					id='fresh-air-<?php echo $dataObj->data_id;?>-13'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>'
						field="outside_temperature" class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>14</td>
				<td>室外湿度</td>
				<td class="hasThreshold"
					id='fresh-air-<?php echo $dataObj->data_id;?>-14'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>'
						field="outside_humidity" class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>15</td>
				<td>加湿器电流</td>
				<td class="hasThreshold"
					id='fresh-air-<?php echo $dataObj->data_id;?>-15'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>'
						field="humidifier_current" class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>16</td>
				<td>平均温度</td>
				<td class="hasThreshold"
					id='fresh-air-<?php echo $dataObj->data_id;?>-16'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>'
						field="average_temperature" class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>17</td>
				<td>平均湿度</td>
				<td class="hasThreshold"
					id='fresh-air-<?php echo $dataObj->data_id;?>-17'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>'
						field="average_humid" class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>18</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>19</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>20</td>
				<td>最高室内温度</td>
				<td class="hasThreshold"
					id='fresh-air-<?php echo $dataObj->data_id;?>-20'><span></span>&nbsp;
					<button style="display: none;"
						data_id='<?php echo $dataObj->data_id;?>'
						field="highest_temperature" class="btn btn-warning setThreshold">设置阀值</button></td>
			</tr>
			<tr>
				<td>21</td>
				<td>湿帘加湿水泵</td>
				<td id='fresh-air-<?php echo $dataObj->data_id;?>-21'></td>
			</tr>
			<tr>
				<td>22</td>
				<td>外部空调</td>
				<td id='fresh-air-<?php echo $dataObj->data_id;?>-22'></td>
			</tr>
			<tr>
				<td>23</td>
				<td>告警状态</td>
				<td id='fresh-air-<?php echo $dataObj->data_id;?>-23'></td>
			</tr>
			<tr>
				<td>24</td>
				<td>温度设定点</td>
				<td id='fresh-air-<?php echo $dataObj->data_id;?>-24'></td>
			</tr>
			<tr>
				<td>25</td>
				<td>湿度设定点</td>
				<td id='fresh-air-<?php echo $dataObj->data_id;?>-25'></td>
			</tr>
			<tr>
				<td>26</td>
				<td>高温告警点</td>
				<td id='fresh-air-<?php echo $dataObj->data_id;?>-26'></td>
			</tr>
			<tr>
				<td>27</td>
				<td>低温告警点</td>
				<td id='fresh-air-<?php echo $dataObj->data_id;?>-27'></td>
			</tr>
			<tr>
				<td>28</td>
				<td>高湿报警点</td>
				<td id='fresh-air-<?php echo $dataObj->data_id;?>-28'></td>
			</tr>
			<tr>
				<td>29</td>
				<td>低湿报警点</td>
				<td id='fresh-air-<?php echo $dataObj->data_id;?>-29'></td>
			</tr>
			<tr>
				<td>30</td>
				<td>更新时间</td>
				<td id='fresh-air-<?php echo $dataObj->data_id;?>-30'></td>
			</tr>
		</tbody>
	</table>
</div>
