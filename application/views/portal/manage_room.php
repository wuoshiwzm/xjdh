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
<!-- 		//   添加查询--------------------------------------------------------------------115 -->
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
								<label class="control-label" style="float: left;">所属区域</label>
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
							<div  class="control-group">									
							<label class="control-label" style="float: left;">关键词</label>
									<div class="controls" style="margin-left: 20px; float: left;">
										<input type='text' name='keyWord' id='keyWord'
											value='<?php if(isset($keyWord)) echo $keyWord ?>' /> 
									</br><span style="color: red;">注：可为区域、局站、机房、局站名称首字母
									</span>
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
						<h3>机房列表</h3>
					</div>
					<div class="widget-container">
					   <?php if($roomCode != false){?>
					   <p>
							<a id="btn-close" class="btn btn-primary"
								href='/portal/manageRoom'><i class="icon-reply"></i> 查看所有机房</a>
						</p>
					   <?php }?>
					   <div class="row-fluid">
							<div class="span6">
								<a type="button" class="btn btn-info"
									href='/portal/editroom'><i
									class="icon-plus"></i> 添加机房</a>
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
					   <table
							class="table table-bordered responsive table-striped table-sortable">
							<thead>
								<tr>
									<th>序号</th>
									<th>分公司</th>
									<th>区域</th>
									<th>局站</th>
									<th>机房</th>
									<th>机房编码</th>
									<th>地理位置(经度，纬度)</th>
									<th>性能指标</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
							<?php $i = $offset + 1;foreach ($roomList as $roomObj){?>  
							 <tr>
									<td><?php echo $i++;?></td>
									<td><?php echo htmlentities(Defines::$gCity[$roomObj->city_code],ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities(Defines::$gCounty[$roomObj->city_code][$roomObj->county_code],ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($roomObj->substation_name, ENT_COMPAT, "UTF-8");?></td>
									<td><?php echo htmlentities($roomObj->name, ENT_COMPAT, "UTF-8");?></td>
									<td><?php echo htmlentities($roomObj->code, ENT_COMPAT, "UTF-8");?></td>
									<td><?php echo htmlentities($roomObj->location, ENT_COMPAT, "UTF-8");?> <br /> <?php echo htmlentities($roomObj->lng,ENT_COMPAT,"UTF-8");?>， <?php echo htmlentities($roomObj->lat,ENT_COMPAT,"UTF-8");?></td>
									<td>
							         <?php echo htmlentities($roomObj->pi_setting, ENT_COMPAT, "UTF-8");?>
						         </td>
									<td room_id='<?php echo htmlentities($roomObj->id,ENT_COMPAT,"UTF-8");?>'>
									<?php if($_SESSION['XJTELEDH_USERROLE']!='member'){?>
									    <a type="button" class="btn btn-delete" roomid="<?php echo htmlentities($roomObj->id,ENT_COMPAT,"UTF-8"); ?>">
											<i class="icon-edit"></i>删除机房信息</a>
											<?php }?>
										<a type="button" class="btn btn-info" href="/portal/editroom/<?php echo htmlentities($roomObj->id,ENT_COMPAT,"UTF-8"); ?>">
											<i class="icon-edit"></i>编辑机房信息</a>
										<a type="button" href="/portal/realtimedata/<?php echo htmlentities($roomObj->id,ENT_COMPAT,"UTF-8");?>"class="btn btn-link">
											<i class="icon-search"></i>查看机房监控</a>
										<a type="button" class="btn btn-primary btn-addPi"
											pi_setting='<?php echo htmlentities($roomObj->pi_setting,ENT_COMPAT,"UTF-8");?>'>
											<i class="icon-plus"></i> 添加性能指标</a>										
									</td>
								</tr>
							 <?php }?>
							</tbody>
						</table>
						<div class="row-fluid">
							<div class="span6">
                                                                        总计 <?php echo $count;?> 个机房
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
</div>
<div class="modal fade bs-example-modal-lg" role="dialog" id='roomPiDlg'>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h3>编辑性能指标</h3>
			</div>
			<div class="modal-body modal-lg">
				<h4>设置完毕，请点击"保存"按钮对所有修改进行保存</h4>
				<div class="row-fluid">
					<div class="span6">
						<button type="button" class="btn btn-primary" id="btnAddPi">新建性能指标</button>
					</div>
				</div>
				<br>
				<table
					class="paper-table table table-paper table-striped table-sortable">
					<thead>
						<tr>
							<th>序号</th>
							<th>性能指标变量标签</th>
							<th>性能指标变量名</th>
							<th>删除</th>
						</tr>
					</thead>
					<tbody id="tbRoomPi">
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-danger" id='btn-ok'>保存</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
