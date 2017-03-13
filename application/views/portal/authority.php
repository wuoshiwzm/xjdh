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
    							        <?php }else if($userObj->user_role == "city_admin"||$userObj->user_role == "operator"){ ?>
    							        <option value="<?php echo $userObj->city_code; ?>">
    							            <?php echo Defines::$gCity[$userObj->city_code]; ?></option>
    							        <?php }?>
    								</select>
								</div>
							<label class="control-label" style="float: left;">区域  </label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择区域"
										name='selCounty' id='selCounty'>
										<?php if($userObj->user_role == "city_admin"||$userObj->user_role == "operator"){ ?>
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
							   <label class="control-label" style="float: left;">用户名字</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" name='fullName' id='fullName'
										value="<?php echo $fullName;?>" />
								</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">用户角色</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择角色"
										name='userRole' id='userRole'>
										<?php if($this->userObj->user_role == "city_admin"||$this->userObj->user_role == "operator"){?>
										<?php if($this->userObj->user_role != "member"){?>
										 <option value='' >所有角色</option>
										 <?php }?>
										 <option value="door_user" <?php if($userRole == "door_user"){?>selected="selected"<?php }?>>门禁用户</option>
										  <?php if($this->userObj->user_role == "city_admin"){?>
										 <option value="operator" <?php if($userRole == "operator"){?>selected="selected"<?php }?>>门禁管理员</option>
										 <option value="member" <?php if($userRole == "member"){?>selected="selected"<?php }?>> 普通用户</option><?php }?>
									    <?php }?>
									    <?php if($this->userObj->user_role == "admin"){?>
										 <option value='' >所有角色</option>
										 <option value="admin" <?php if($userRole == "admin"){?>selected="selected"<?php }?>> 系统管理员 </option>
										 <option value="member" <?php if($userRole == "member"){?>selected="selected"<?php }?>> 普通用户 </option>
										 <option value="city_admin" <?php if($userRole == "city_admin"){?>selected="selected"<?php }?>> 分公司管理员 </option>
										 <option value="noc" <?php if($userRole == "noc"){?>selected="selected"<?php }?>> 网络监控用户 </option>
										 <option value="operator" <?php if($userRole == "operator"){?>selected="selected"<?php }?>> 门禁管理员  </option>
										 <option value="door_user" <?php if($userRole == "door_user"){?>selected="selected"<?php }?>> 门禁用户 </option>
										 <?php }?>	
									</select>
								</div>	</div>		
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
							<i class="icon-list"></i> 监控权限管理
						</h3>
					</div>
					<div class="widget-container">
						<table class="table table-bordered responsive table-striped">
							<thead>
								<tr>
									<th>序号</th>
									<th>名字</th>
									<th>用户角色</th>
									<th>所属分公司</th>
									<th>所属区域</th>
									<th>区域权限</th>
									<th>设备权限</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
							<?php $index = $offset + 1;foreach ($userList as $userObj){?>
							<tr>
									<td><?php echo $index++;?></td>
									<td><?php echo htmlentities($userObj->full_name,ENT_COMPAT,"UTF-8")?></td>
									<td><?php echo Defines::$gUserRole[$userObj->user_role]; ?></td>
									<td><?php if(!empty($userObj->city_code)){ echo htmlentities(Defines::$gCity[$userObj->city_code],ENT_COMPAT,"UTF-8"); }?></td>
									<td><?php if(!empty($userObj->county_code)){ echo htmlentities(Defines::$gCounty[$userObj->city_code][$userObj->county_code],ENT_COMPAT,"UTF-8"); } ?></td>
									<td><?php if ($userObj->user_role == 'admin'){
										           echo "所有区域";
										        } elseif ($userObj->user_role == 'city_admin') {
										           echo htmlentities(Defines::$gCity[$userObj->city_code],ENT_COMPAT,"UTF-8");
										        } elseif ($userObj->user_role == 'member' || $userObj->user_role == 'noc' || $userObj->user_role == 'operator') {
													$i = 0;
										            foreach ($substationList as $substationobj) {
										                if (in_array($substationobj->id, $userObj->area_privilege) && $i<2) {
										                    //echo htmlentities($substationobj->city,ENT_COMPAT,"UTF-8") . ' -> ' . htmlentities($substationobj->county,ENT_COMPAT,"UTF-8") . ' -> ' . htmlentities($substationobj->name,ENT_COMPAT,"UTF-8") . '<br>';
										                    echo htmlentities(Defines::$gCity[$substationobj->city_code],ENT_COMPAT,"UTF-8"). ' -> ' . htmlentities(Defines::$gCounty[$substationobj->city_code][$substationobj->county_code],ENT_COMPAT,"UTF-8") . ' -> ' . htmlentities($substationobj->name,ENT_COMPAT,"UTF-8") . '<br>';
										                    $i++;
										                }
										                elseif($i >= 2)
										                {
										                	echo '...'. '<br>';
										                	break;
										                }
										            }
										        }?>
							        </td>
									<td>
							     <?php
								        if ($userObj->user_role == 'admin' || $userObj->user_role == 'city_admin') {
								            echo "所有设备";
								        } elseif ($userObj->user_role == 'member' || $userObj->user_role == 'noc' || $userObj->user_role == 'operator') {	
                                             $i=0;
                                           foreach (Constants::$devConfigList as $k => $devConfig) {
                                                $n = 1;
								                foreach ($devConfig[0] as $key => $val){
								                   if(in_array($val, $userObj->dev_privilege))
								                   {   
								                	   if ($n == 1){
								                	      echo $devConfig[1] . '<br>';
								                	      $n++;$i=$i+1;
								                	   }	
								                   }
								                 }
								                 if($i == 2)
								                 {
								                 	echo '...'. '<br>';
								                 	break;
								                 }
								            }  
								        }
								        ?></td>
									<td>
							        <?php if($_SESSION['XJTELEDH_USERROLE'] == 'admin'){?>	
									<a class="btn btn-info"
										href="<?php echo site_url("portal/editprivilege?user_id=".$userObj->id);?>"
										type="button"><i class="icon-pencil"></i> 修改权限</a>
								       <?php }?>	
								       
							       <?php if($_SESSION['XJTELEDH_USERROLE'] == 'city_admin'){?>	
									<?php if($userObj->user_role == 'member' || $userObj->user_role == 'operator'|| $userObj->user_role == 'door_user'){?>
									<a class="btn btn-info"
										href="<?php echo site_url("portal/editprivilege?user_id=".$userObj->id);?>"
										type="button"><i class="icon-pencil"></i> 修改权限</a>
										 <?php }?>
							       <?php }?>
							       
							        <?php if($_SESSION['XJTELEDH_USERROLE'] == 'operator'){?>	
									<?php if($userObj->user_role == 'member' ||  $userObj->user_role == 'door_user'){?>
									<a class="btn btn-info"
										href="<?php echo site_url("portal/editprivilege?user_id=".$userObj->id);?>"
										type="button"><i class="icon-pencil"></i> 修改权限</a>
										 <?php }?>
							       <?php }?>

							        </td>
								    </tr>
							    <?php }?>
							</tbody>
						</table>
						<div class="row-fluid">
							<div class="span6">
							总计 <?php echo $count;?> 个设备
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
