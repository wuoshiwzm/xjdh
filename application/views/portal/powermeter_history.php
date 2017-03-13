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
						<li class="active"><?php echo htmlentities($bcObj->title,ENT_COMPAT,"UTF-8");?></li>
						<?php }else {?>
						<li><a href='<?php echo htmlentities($bcObj->url,ENT_COMPAT,"UTF-8");?>'><?php echo htmlentities($bcObj->title,ENT_COMPAT,"UTF-8");?></a>
							<span class="divider"><i class="icon-angle-right"></i></span></li>
						<?php }?>
						<?php }?>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
		      <div class='span3'>
				<div class="content-widgets">
					<div class="widget-header-block">
						<h3>电表列表</h3>
						<div class="content-box">
						<input type="text" value=""
							style="box-shadow: inset 0 0 4px #eee; margin: 0; padding: 6px 12px; border-radius: 4px; border: 1px solid silver; font-size: 1.1em;"
							id="userQuery" placeholder="搜索" />
						<div id='pwTree'></div>
					   </div>
						<div id='area-tree' style="max-height: 500px; overflow-y: auto;">									
						</div>
					</div>					
				</div>
			</div>
			<div class="span9">
				<div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>综合查询</h3>
					</div>
					<div class="widget-container">
						<form class="form-horizontal">
						  <div class="control-group">
								<label class="control-label">当前选中电表<input type="hidden" id="data_id" name="data_id" 
								value="<?php echo $data_id;?>" /></label>
								<div class="controls" id="selPowerMeter">
									<?php if(isset($dataObj)){ 
									  echo Defines::$gCity[$dataObj->city_code].">".Defines::$gCounty[$dataObj->city_code][$dataObj->county_code].">".$dataObj->substation_name.">".$dataObj->room_name.">".$dataObj->name;
									}?>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">开始时间 - 终止时间</label>
								<div class="controls" style="margin-left: 20px; float: left;">
								<input type="text" class='form-control date-range-picker'
										name="dateRange" id="dateRange"
										value="<?php if(isset($dateRange)) echo htmlentities($dateRange, ENT_COMPAT, "UTF-8");?>">
										</div>
							</div>
							<div class="form-actions">
								<button id="btnSearch" class="btn btn-success" type="submit">查询</button>
								<button id="btnExport" name="export" class="btn btn-success" value="exporttoexcel" type="submit">导出报表</button>
							</div>
						</form>
					</div>
					<div class="widget-head bondi-blue">
						<h3>查询结果</h3>
					</div>
					<div class="widget-container">
					<div class="row-fluid">
							<div class="span6">
                                   总计 <?php echo $count;?> 个电表历史数据
                            </div>
							<div class="span6">
                            <?php echo $pagination;?>
                            </div>
						</div>
						<table class="table table-bordered responsive table-striped">
							<thead>
								<tr>
									<th>日期</th>
									<th>A相功率</th>
									<th>B相功率</th>
									<th>C相功率</th>
									<th>合相功率</th>
									<th>A相电压</th>
									<th>B相电压</th>
									<th>C相电压</th>
									<th>A相电流</th>
									<th>B相电流</th>
									<th>C相电流</th>
									<th>合相电流</th>
									<th>A相电能</th>
									<th>B相电能</th>
									<th>C相电能</th>
									<th>合相电能</th>
								</tr>
							</thead>
							<tbody>
					           <?php $i = $offset + 1; foreach($powerDataList as $powerDataObj){ ?>		 
							     <tr>
							        <td><?php echo htmlentities($powerDataObj->Date." ".$powerDataObj->Time,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo number_format($powerDataObj->pa,3);?></td>
									<td><?php echo number_format($powerDataObj->pb,3);?></td>
									<td><?php echo number_format($powerDataObj->pc,3);?></td>
									<td><?php echo number_format($powerDataObj->pt,3);?></td>									
									<td><?php echo number_format($powerDataObj->uaRms,3);?></td>
									<td><?php echo number_format($powerDataObj->ubRms,3);?></td>
									<td><?php echo number_format($powerDataObj->ucRms,3);?></td>
									<td><?php echo number_format($powerDataObj->iaRms,3);?></td>
									<td><?php echo number_format($powerDataObj->ibRms,3);?></td>
									<td><?php echo number_format($powerDataObj->icRms,3);?></td>
									<td><?php echo number_format($powerDataObj->itRms,3);?></td>
									<td><?php echo number_format($powerDataObj->epa,3);?></td>
									<td><?php echo number_format($powerDataObj->epb,3);?></td>
									<td><?php echo number_format($powerDataObj->epc,3);?></td>
									<td><?php echo number_format($powerDataObj->ept,3);?></td>
								</tr>
							 <?php }?>
							</tbody>
						</table>
						<div class="row-fluid">
							<div class="span6">
                                 总计 <?php echo $count;?> 个电表历史数据
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
