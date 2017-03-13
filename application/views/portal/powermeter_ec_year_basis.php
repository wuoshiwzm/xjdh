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
							<label class="control-label" style="float: left;">业务维度</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择能耗类型"
										name='ecType' id='ecType'>
										<?php foreach(Defines::$gECType as $key=> $val){?>
										    <option  <?php if($ecType == $key){?> selected="selected"  <?php }?> value="<?php echo $key; ?>"><?php echo htmlentities($val,ENT_COMPAT,"UTF-8");?></option>	
										<?php } ?>

									</select>
								</div>
								<label class="control-label" style="float: left;">开始年度 - 终止年度</label>
								<div class="controls" style="margin-left: 20px; float: left;">
								    <?php $iStartYear = 2016;
								          $year = date('Y', time()) + 10;?>
								    <select name="startYear" id="startYear">
								        <?php while($iStartYear <= $year){ ?>
								            <option value="<?php echo $iStartYear; ?>" <?php if($iStartYear == $startYear){?>selected="selected"<?php } ?>><?php echo $iStartYear++; ?></option>
								        <?php } ?>
								    </select>
								    -
								    <select name="endYear" id="endYear">
								     <?php $iStartYear=2016; while($iStartYear <= $year){ ?>
								            <option value="<?php echo $iStartYear; ?>" <?php if($iStartYear == $endYear){?>selected="selected"<?php } ?>><?php echo $iStartYear++; ?></option>
								        <?php } ?>
								    </select>
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
					   <div class='span3'>
							<table class="table table-bordered responsive table-striped table-sortable">
							     <thead>
							         <tr>
    							         <th>年度</th>
    							         <th>能耗</th>
							         </tr>
							     </thead>
							     <tbody>
							         <?php foreach($yearArray as $year=>$ept){ ?>
							         <tr>
							             <td><?php echo $year; ?></td>
							             <td><?php echo $ept; ?></td>
							         </tr>
							         <?php } ?>
							     </tbody>
							</table>
						</div>
						<div class='span9'>
						      <div id="lineChart" style="height:400px;width:100%;"></div>
						      
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
var yearData = <?php echo json_encode($yearArray); ?>;
</script>