<script type="text/javascript">
$(document).ready(function(){
	$("#dataTable").tablesorter();
});</script>

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
								<label class="control-label" style="float: left;">激活状态</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select chzn-search-disabled "
										name='selActive' id='selActive'>
										<option value='1' selected='selected' >所有状态</option>
										<option value='2'>已激活</option>
										<option value='3'>未激活</option>
									</select>
								</div>
							</div>
							<label class="control-label" style="float: left;">设备IP</label>
							<div class="controls" style="margin-left: 20px; float: left;">
								<input type='text' name='txtIP' id='txtIP'
									value='<?php  echo $ip;?>' />
							</div>
							<div  class="control-group">									
							<label class="control-label" style="float: left;">关键词</label>
									<div class="controls" style="margin-left: 20px; float: left;">
										<input type='text' name='keyWord' id='keyWord'
											value='<?php if(isset($keyWord)) echo $keyWord ?>' /> 
									</br><span style="color: red;">注：可为区域、局站、机房、设备名、局站名称首字母</span>
									</div>
							</div>
							<div class="form-actions">
								<button class="btn btn-success" type="submit" id='btn-submit'>提交</button>
								<button class="btn btn-success" name="export" value="exporttoexcel" type="submit" >导出报表</button>
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
							<i class="icon-list"></i> 采集单元配置
						</h3>
					</div>
					<div class="widget-container">
						<div class="row-fluid">
							<div class="span6">
								<a href="/portal/edit_smd_device" class="btn btn-info"
									type="button"><i class="icon-plus"></i> 添加采集单元</a>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span6">

							</div>
							<div class="span6">
						      <?php echo $pagination;?>
						  </div>
						</div>
						<br>
						<table id="dataTable"
							class="table table-bordered responsive table-striped tablesorter"">
							<thead>
								<tr>
									<th>序号</th>
									<th>设备号</th>
									<th>分公司</th>
									<th>区域</th>
									<th>局站</th>
									<th>机房</th>
									<th>设备名称</th>
									<th>IP地址</th>
									<th>是否激活</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
							<?php $i = $offset + 1; foreach ($devList as $devObj){?>
							<tr smd_device_no='<?php echo htmlentities($devObj->device_no,ENT_COMPAT,"UTF-8");?>'>
									<td><?php echo $i++;?></td>
									<td><?php echo htmlentities($devObj->device_no,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities(Defines::$gCity[$devObj->city_code],ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities(Defines::$gCounty[$devObj->city_code][$devObj->county_code],ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($devObj->substation_name,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($devObj->room_name,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($devObj->name,ENT_COMPAT,"UTF-8"); ?></td>
									<td><?php echo htmlentities($devObj->ip,ENT_COMPAT,"UTF-8"); ?></td>
									<td>
									<a href='#'><?php if($devObj->active){?><span
											class="label label-success dev-lock">已激活</span><?php }else{?><span
											class="label label-warning dev-unlock">未激活</span><?php }?></a>
									</td>
									<td>
										<div class="btn-toolbar row-action">
											<div class="btn-group">
												<button class="btn btn-info" data-original-title="编辑"
													onclick='location.href="/portal/edit_smd_device/<?php echo $devObj->device_no; ?>"'>
													<i class="icon-edit"></i>
												</button>
												<button class="btn btn-danger delete-dev"
													data-original-title="删除">
													<i class="icon-remove"></i>
												</button>
											</div>
										</div>
									</td>
								</tr>
							<?php }?>
							</tbody>
						</table>
						<div class="row-fluid">
							<div class="span6">
														 总计 <?php echo $count;?> 个采集单元
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
