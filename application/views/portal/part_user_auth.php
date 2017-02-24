<div class="main-wrapper">
    <div class="container-fluid">
    <!-- BEGIN PAGE HEADER-->
    <div class="row-fluid">
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
							   <label class="control-label" style="float: left;">用户名</label>
								<div class="controls" style="margin-left: 20px; float: left;">
                                         <input type="text" name='userName' id='userName'
										value="<?php if($userName) echo $userName?>" >
								</div>
							<div class="control-group">
							   <label class="control-label" style="float: left;">姓名</label>
								<div class="controls" style="margin-left: 20px; float: left;">
                                         <input type="text" name='txtFullName' id='txtFullName'
										value="<?php if($fullName) echo $fullName?>" >
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
    <!-- END PAGE HEADER-->
    <div class="row-fluid">
       <div class="span12">
            <!-- BEGIN BORDERED TABLE widget-->
            <div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>
							<i class="icon-list"></i> 模块权限管理
						</h3>
					</div>
					<div class="widget-container">
                   
                    <table class="table table-bordered table-striped  table-hover">
                        <thead>
                            <tr>
                                
                                <th>序号</th>
                                <th>用户名</th>
                                <th>姓名</th>
                                <th>证件号码</th>                               
                                <th>权限列表</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody id="userList">
                            <?php $index = $offset + 1; foreach ($userList as $userObj){?>
                            <tr user_id='<?php echo htmlentities($userObj->id,ENT_COMPAT,"UTF-8");?>' id_type="<?php echo htmlentities($userObj->ID_type, ENT_COMPAT, "UTF-8"); ?>" id_number="<?php echo htmlentities($userObj->ID_number, ENT_COMPAT, "UTF-8"); ?>" id_img="<?php echo htmlentities($userObj->idcard_img,ENT_COMPAT,"UTF-8"); ?>" user_img="<?php echo htmlentities($userObj->user_img,ENT_COMPAT,"UTF-8"); ?>" >
                                
                              	<td><?php echo $index++; ?><?php ?>
                              	<td><?php echo htmlentities($userObj->username,ENT_COMPAT,"UTF-8"); ?></td>
                                <td><?php echo htmlentities($userObj->full_name, ENT_COMPAT, "UTF-8");?></td>
                                  <td><?php echo htmlentities($userObj->ID_number,ENT_COMPAT,"UTF-8");?></td>
                                <td>
                                <?php $authList = array();
                                	  $authList = User::GetAuthListAll($userObj->id);
                                	  foreach($authList as $authObj){
										echo htmlentities($authObj->first_auth,ENT_COMPAT,"UTF-8");										
										echo "&nbsp&nbsp&nbsp---".htmlentities($authObj->second_auth,ENT_COMPAT,"UTF-8")."<br/>";
									  }		?>
                                </td>
                                <td>
                                <a href="<?php echo site_url('portal/edit_user_auth/' . htmlentities($userObj->id,ENT_COMPAT,"UTF-8"));?>">编辑</a>
                                </td>
                            </tr>
                            <?php }?>                          
                        </tbody>
                    </table>
                    <div class="row-fluid">
                        <div class="span6">
					总计 <?php echo $count;?> 个设备
							</div>
                            <div class="pagination pagination-large pagination-right">
                                <?php echo $pagination;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END BORDERED TABLE widget-->
        </div>
    </div>
</div>
            </div>
            