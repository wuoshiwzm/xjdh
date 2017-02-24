<style>
<!--
.form-horizontal .control-label
{
	float:left;
	width:130px;
}
.form-horizontal .controls
{
	float:left;
	width:160px;
	margin-left:5px;
}
-->
</style>
<div class="main-wrapper">
	<div class="container-fluid">
		<div class="row-fluid ">
			<div class="span12">
				<div class="primary-head">
					<h3 class="page-header">管理面板</h3>
					<ul class="breadcrumb">
						<li><a class="icon-home" href="/"></a> <span class="divider"><i
								class="icon-angle-right"></i></span></li>
						<?php foreach ($bcList as $bcObj){?>
						<?php if($bcObj->isLast){?>	
						<li class="active"><?php echo $bcObj->title;?></li>
						<?php }else {?>
						<li><a href='<?php echo $bcObj->url;?>'><?php echo $bcObj->title;?></a>
							<span class="divider"><i class="icon-angle-right"></i></span></li>
						<?php }?>
						<?php }?>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>
							<i class="icon-search"></i> 综合查询
						</h3>
					</div>
					<div class="widget-container">
						<form class="form-horizontal">
							<div class="control-group">
								<label class="control-label" style="float: left;">分公司</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择分公司"
										name='selCity' id='selCity'>
    							    <?php if($_SESSION['XJTELEDH_USERROLE'] == 'admin' || $_SESSION['XJTELEDH_USERROLE'] == 'noc'){?>
    							        <option value=''>全网</option>
							        <?php }?>
    							        <?php $cityList = json_decode($_SESSION['CITYLIST'],TRUE); foreach ($cityList as $cityKey=>$cityVal){?>
    							            <option value='<?php echo $cityKey;?>'
											<?php if($cityCode == $cityKey){?> selected="selected"
											<?php }?>><?php echo $cityVal;?>本地网</option>
    							        <?php }?>
    								</select>
								</div>

								<label class="control-label" style="float: left;">区域</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择区域"
										name='selCounty' id='selCounty'>
										<option value="">所有区域</option>
									<?php $countyList = json_decode($_SESSION['COUNTYLIST'],TRUE); foreach ($countyList[$cityCode] as $key=> $val){?>
									   <option value='<?php echo $key;?>'
											<?php if($countyCode == $key){?> selected="selected"
											<?php }?>><?php echo $val;?></option>
								   <?php }?>
									</select>
								</div>
							</div>
							<div class="form-actions">
								<button class="btn btn-success" name="action" value="search"
									type="submit">查询</button>
								<button class="btn btn-success" name="action" value="export"
									type="submit">导出报表</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>
							<i class="icon-list"></i> 局站列表
						</h3>
					</div>
					<div class="widget-container">
						<table
							class="table table-bordered responsive table-striped table-sortable">
							<thead>
								<tr>
									<th>序号</th>
									<th>分公司</th>
									<th>区域</th>
									<th>局站</th>
									<th>总耗电功率</th>
									<th>主设备功率</th>
									<th>瞬时PUE</th>
									<th>总能耗</th>
									<th>主设备能耗</th>
									<th>年度PUE</th>
									<th>更新时间</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody id="devList">
							<?php $i = $offset + 1; foreach ($stationList as $stationObj){?>
							<tr id="<?php echo $stationObj->id; ?>">
									<td><?php echo $i++;?></td>
									<td><?php echo $stationObj->city;?></td>
									<td><?php echo $stationObj->county;?></td>
									<td><?php echo $stationObj->name; ?></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>
										<button type="button"
											class="btn btn-warning block-alert setting">设置</button>
									</td>
								</tr>
							<?php }?>
							</tbody>
						</table>
						<div class="row-fluid">
							<div class="span6">
								<div class="dataTables_info">总共 <?php echo count($stationList);?> 个局站</div>
							</div>
							<div class="span6">
						      <?php echo $pagination;?>
						  </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade bs-example-modal-lg" role="dialog"
	id='settingDialog' style="display: none;width:950px;left:40%;">
	<div class="modal-dialog">
		<div class="modal-header">
			<h4>设置局站能耗补偿参数</h4>
		</div>
		<div class="modal-content">
			<div class="modal-body modal-lg">
				<div class="row-fluid">
					<div class='span12'>
						<div class="content-widgets">
							<h5>补偿瞬时PUE能耗指标=(当前局站总功率+局站总功率补偿)/(当前主设备总功率+主设备功率补偿)</h5>
							<div class="content-box form-horizontal">
								<div class="control-group">
									<label class="control-label">当前局站总功率:</label>
									<div class="controls" id="allPower"></div>
									<label class="control-label">当前主设备总功率:</label>
									<div class="controls" id="mainPower"></div>
									<label class="control-label">当前瞬时PUE能耗指标:</label>
									<div class="controls" id="pue"></div>
								</div>
								<div class="control-group">
									<label class="control-label">局站总功率补偿:</label>
									<div class="controls">
										<input type="text" id="txtAllDevicePower" class="span" />
									</div>
									<label class="control-label">主设备功率补偿:</label>
									<div class="controls">
										<input type="text" id="txtMainDevicePower" class="span" />
									</div>
									<label class="control-label">补偿瞬时PUE能耗指标:</label>
									<div class="controls" id="ComPue">&nbsp;
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">当前局站总耗电量:</label>
									<div class="controls" id="allPowerConsumption">
									</div>
									<label class="control-label">当前主设备总功率:</label>
									<div class="controls" id="mainPowerConsumption">
									</div>
								、	<label class="control-label">当前年度PUE能耗指标:</label>
									<div class="controls" id="AccPue">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">局站总耗电量补偿:</label>
									<div class="controls">
										<input type="text" id="txtAllDevicePowerConsumption" class="span" />
									</div>
									<label class="control-label">主设备耗电量补偿:</label>
									<div class="controls">
										<input type="text" id="txtMainDevicePowerConsumption" class="span" />
									</div>
										<label class="control-label">补偿年度PUE能耗指标:</label>
									<div class="controls" id="ComAccPue">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary"
				data-dismiss="modal">取消</button>
			<button type="button" class="btn btn-danger" id='btn-ok-check'>保存</button>
		</div>
	</div>
</div>
