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
			<div class="span12">
				<div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>综合查询</h3>
					</div>
					<div class="widget-container" 
						id='search-area'>
						<form class="form-horizontal">
							<div class="control-group">
								<label class="control-label" style="float: left;">所属部门/分公司</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择分公司"
										name='selCity' id='selCity'>
										<?php if($userObj->user_role == "admin"){?>
    							        <option value=''>全网</option>
    							        <?php foreach (Defines::$gCity as $cityKey=>$cityVal){?>
							            <option value='<?php echo $cityKey;?>'
											<?php  if($cityCode == $cityKey){?> selected="selected"
											<?php }?>><?php echo $cityVal;?>本地网</option>
    							        <?php }?>
    							        <?php }else if($userObj->user_role == "city_admin"||$userObj->user_role == "noc"){ ?>
    							        <option value="<?php echo $userObj->city_code; ?>">
    							            <?php echo Defines::$gCity[$userObj->city_code]; ?></option>
    							        <?php }?>
    								</select>
								</div>
								
								<label class="control-label" style="float: left;">区域  </label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择区域"
										name='selCounty' id='selCounty'>
										<?php if($userObj->user_role == "city_admin"||$userObj->user_role == "noc"){ ?>
											<option value="0">所有区域</option>
											<?php foreach (Defines::$gCounty[$userObj->city_code] as $key=> $val){?>
										    <option value='<?php echo $key;?>'
												<?php if($countyCode == $key){?>selected="selected"<?php }?>>
												<?php echo $val;?></option>
									        <?php } ?>
								        <?php }else{ ?>
										    <option value="0">所有区域</option>
										    <?php if(count($cityCode)) foreach (Defines::$gCounty[$cityCode] as $key=> $val){?>
									            <option value='<?php echo $key;?>'
											    <?php if($countyCode == $key){?> selected="selected" <?php }?>>
											    <?php echo $val;?></option>
								            <?php }?>   
								        <?php }?>
									</select>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" style="float: left;">所属局站</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择局站"
										name='selSubstation' id='selSubstation'>
										<option value=''>所有局站</option>
										<?php if(isset($substationId)) {?>
									       <?php foreach ($substationList as $substationObj){?>
									       <option <?php if($substationObj->id == $substationId){?> selected="selected" <?php }?> 
									       value="<?php echo htmlentities($substationObj->id,ENT_COMPAT,"UTF-8");?>">
									              <?php if($substationObj->county_code == $countyCode) echo htmlentities($substationObj->name,ENT_COMPAT,"UTF-8");?></option>	
									        <?php }?>	
									    <?php }?>	
									</select>
								</div>
								
								<label class="control-label" style="float: left;">所属机房</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择机房"
										name='selRoom' id='selRoom'>
										<option value=''>所有机房</option>
										<?php if(isset($substationId)) {?>
									    <?php foreach ($roomList as $roomListObj){?>
									    <option <?php if($roomListObj->id == $roomId){?> selected="selected" <?php }?> 
									      value="<?php echo htmlentities($roomListObj->id,ENT_COMPAT,"UTF-8");?>">
									           <?php if($roomListObj->substation_id == $substationId) echo htmlentities($roomListObj->name,ENT_COMPAT,"UTF-8");?></option>	
									    <?php }?>	
									    <?php }?>
									</select>
								</div>
							</div>					
							<div class="control-group">
							<label class="control-label" style="float: left;">能耗类型</label>
							<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择能耗类型"
										name='ecType' id='ecType'>
										<?php foreach(Defines::$gECType as $key=> $val){?>
										    <option  <?php if($ecType == $key){?> selected="selected"  <?php }?> value="<?php echo $key; ?>"><?php echo htmlentities($val,ENT_COMPAT,"UTF-8");?></option>	
										<?php } ?>

									</select>
								</div>
							<label class="control-label" style="float: left;">数据粒度</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择能耗类型"
										name='ecGroup' id='ecGroup'>
										<?php foreach(Defines::$gECGroup as $key=> $val){?>
										    <option  <?php if($ecGroup == $key){?> selected="selected"  <?php }?> value="<?php echo $key; ?>"><?php echo htmlentities($val,ENT_COMPAT,"UTF-8");?></option>	
										<?php } ?>

									</select>
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
								<button class="btn btn-success" type="submit">查询</button>
								<button  style="display:none" class="btn btn-success" name="export" value="exporttoexcel" type="submit">导出报表</button>
							</div>
						</form>
					</div>
					<div class="widget-head bondi-blue">
						<h3>查询结果</h3>
					</div>
					<div class="widget-container">
					<div class="row-fluid">
					   <?php if(isset($count)){ ?>
					   <div class="row-fluid">
							<div class="span6">
                                  总计 <?php echo $count;?> 条记录
                            </div>
                        </div>
                        <?php } ?>
						<table class="table table-bordered responsive table-striped">
							<thead>
								<tr>
								    <th>序号</th>
									<th>日期时间</th>
									<th>A相能耗</th>
									<th>B相能耗</th>
									<th>C相能耗</th>
									<th>合相能耗</th>
								</tr>
							</thead>
							<tbody>
					           <?php $i = $offset + 1;foreach($powerDataList as $powerDataObj){ ?>		 
							     <tr>
							        <td><?php echo $i++;?></td>
							        <td><?php 
							         if(isset($powerDataObj->_id["Date"])){
                                         echo htmlentities($powerDataObj->_id["Date"],ENT_COMPAT,"UTF-8");
							             if(isset($powerDataObj->_id["Time"]))
							                 echo " ".str_pad($curHour,2,$powerDataObj->_id["Time"],STR_PAD_LEFT).":00:00 - ".str_pad($curHour,2,($powerDataObj->_id["Time"]),STR_PAD_LEFT).":59:59"; 
									 }else if(isset($powerDataObj->_id["year"])){
                                           echo $powerDataObj->_id["year"];
                                           if(isset($powerDataObj->_id["month"])){
                                                echo "-".$powerDataObj->_id["month"];
                                            }
                                      }?></td>
									<td><?php echo number_format($powerDataObj->epa_sum,2);?>度</td>
									<td><?php echo number_format($powerDataObj->epb_sum,2);?>度</td>
									<td><?php echo number_format($powerDataObj->epc_sum,2);?>度</td>
									<td><?php echo number_format($powerDataObj->ept_sum,2);?>度</td>
								</tr>
							 <?php }?>
							</tbody>
						</table>
						<?php if(isset($count)){ ?>
						<div class="row-fluid">
							<div class="span6">
                                    总计 <?php echo $count;?> 条记录
                            </div>
                        </div>
                        <?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
