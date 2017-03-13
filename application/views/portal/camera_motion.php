<script type="text/javascript">
$(document).ready(function(){
	$("#dataTable").tablesorter();
});
</script>
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
						<h3>
							<i class="icon-search"></i> 综合查询
						</h3>
						<a class="widget-settings" href="#search-area" id='serarch-toggle'><i
							class="icon-hand-up"></i></a>
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
    							        <?php }else if($userObj->user_role == "city_admin"){ ?>
    							        <option value="<?php echo $userObj->city_code; ?>">
    							            <?php echo Defines::$gCity[$userObj->city_code]; ?></option>
    							        <?php }?>
    								</select>
								</div>
								<label class="control-label" style="float: left;">区域</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择区域"
										name='selCounty' id='selCounty'>
										<?php if($userObj->user_role == "city_admin"){ ?>
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
								<label class="control-label" style="float: left;">开始时间 - 终止时间</label>
								<div class="controls" style="margin-left: 20px; float: left;">
								<input type="text" class='form-control date-range-picker'
										name="dateRange" id="dateRange"
										value="<?php if(isset($dateRange)) echo htmlentities($dateRange, ENT_COMPAT, "UTF-8");?>">
								</div>
								<label class="control-label" style="float: left;">数据ID</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='number' name='data_id' id='data_id'
										value="<?php echo $data_id;?>" />
								</div>
							</div>		
							<div class="form-actions">
								<button class="btn btn-success" type="submit" id='btn-submit'>提交</button>
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
							<i class="icon-list"></i> 侦测记录
						</h3>
					</div>
					<div class="widget-container">					
						<div class="row-fluid">
							<div class="span6">
						总计 <?php echo $count;?> 条记录
							</div>
							<div class="span6">
						      <?php echo $pagination;?>
						  </div>
						</div>
					</div>
						<br>
						<table id="dataTable" class="table table-bordered responsive table-striped">
						
							<thead>
								<tr>
									<th>序号</th>
									<th>分公司</th>
									<th>区域</th>
									<th>局站</th>
									<th>机房</th>
									<th>数据ID</th>
									<th>更新时间</th>
									<th>截图</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
							<?php $page  = $offset + 1; for ($i=0; $i<$count; $i++){?>
							<tr>
								<td><?php echo $i+1;?></td>
								<td><?php echo htmlentities(Defines::$gCity[$result[$i]['city_code']],ENT_COMPAT,"UTF-8");?></td>
								<td><?php echo htmlentities(Defines::$gCounty[$result[$i]['city_code']][$result[$i]['county_code']],ENT_COMPAT,"UTF-8");?></td>	
								<td><?php echo htmlentities($result[$i]['suname'],ENT_COMPAT,"UTF-8");?></td>
								<td><?php echo htmlentities($result[$i]['room_name'],ENT_COMPAT,"UTF-8");?></td>
								<td><?php echo htmlentities($result[$i]['data_id'],ENT_COMPAT,"UTF-8");?></td>
								<td><?php echo htmlentities($result[$i]['Data'].$result[$i]['Time'],ENT_COMPAT,"UTF-8");?></td>
								<td><a rel="group" href="/public/portal/Camera_image/<?php echo $result[$i]['FileName'];?>" >								
									<img src="/portal/camera_thumb/<?php echo $result[$i]['FileName'];?>" alt="" /></a></td>
								<td><button class='btn btn-info'  onclick='location.href="/portal/realtimedata/<?php echo htmlentities($result[$i]['room_id'],ENT_COMPAT,"UTF-8");?>/camera/<?php echo htmlentities($result[$i]['data_id'],ENT_COMPAT,"UTF-8"); ?>'>查看监控</button></td>
							</tr>
							<?php }?>
							</tbody>
						</table>
						<div class="widget-container">					
						   <div class="row-fluid">
							  <div class="span6">
						    总计 <?php echo $count;?> 条记录
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
</div>
