<script type="text/javascript">
var gMajor = <?php echo json_encode($gMajor); ?>;
var cwList = <?php echo json_encode($cwList); ?>;
var gProvinceCity = <?php echo json_encode($gProvinceCity); ?>;
</script>
<style>
.accordion-heading div.checker{
	float:left;
	margin:8px 6px;
}
</style>

<!-- BEGIN PAGE CONTAINER-->
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

<!-- BEGIN PAGE CONTENT-->
<div class="row-fluid">
   <div class="span12">
      <!-- BEGIN VALIDATION STATES-->
    <div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>
							<i class="icon-list"></i> 模块权限管理
						</h3>
					</div>
         <div class="widget-container">
         <?php if(isset($msg)){?>
            <div class="alert alert-success">
                <button data-dismiss="alert" class="close">×</button>
                <strong>成功!</strong> <?php echo $msg;?>
            </div>
            <?php }?>
            <?php if(isset($errMsg)){?>
            <div class="alert alert-error">
                <button data-dismiss="alert" class="close">×</button>
                <strong>失败!</strong> <?php echo $errMsg;?>
            </div>
            <?php }?>
               <div class="widget">
        
         <div class="widget-body form">         
            <!-- BEGIN FORM-->
            <form method="post" class="form-horizontal">
               <div class="control-group">
					<table class="table table-bordered table-hover">
						<thead>
						     <tr>
	                         <th>第一层权限</th>
	                         <th>第二层权限</th>
	                         </tr>
                         </thead>
                         <tbody id="tbAuth">
                                <?php $i = 0;
                                foreach($gUserAuth as $gAuthKey => $gAuthVal){$i++;
//                                 	var_dump(in_array($gAuthKey, $authArr));var_dump($gAuthKey);var_dump($authArr);
                                		?>
		                            <tr>
										<td><input type="checkbox" class="gFAuth" name="cbFirstAuth<?php echo $i;?>" value="<?php echo $gAuthKey; ?>" 
										<?php if(in_array($gAuthKey, $authArr)){ echo "checked='checked'"; }?> />
										<?php echo htmlentities($gAuthKey,ENT_COMPAT,"UTF-8"); ?>
										</td>
										<td>
										<?php 
										foreach($gAuthVal as $index => $key){
											$tmpArr = array();
											$tmpArr = explode(',',$key);
											foreach($tmpArr as $tmpObj){?>
											<input type="checkbox" class="gSAuth" name="cbSecondAuth<?php echo $i;?>[]" value="<?php echo $tmpObj; ?>" 
												<?php if(in_array($tmpObj, $authArr)){ echo "checked='checked'"; } ?> />
											<?php 	echo htmlentities($tmpObj,ENT_COMPAT,"UTF-8").'<br/>';
											}
										}
										?>
	                                	</td>
									</tr>			
	                            <?php }?>	
                          </tbody>
                      </table>                                
							
					</div>
            
               <div class="form-actions">
                  <button type="submit" class="btn btn-success" id='btnSave'>保存</button>
                  <a href="/admin/part_user_auth">取消</a>
               
               </div>
            </form>
            <!-- END FORM-->
         </div>
      </div>
            
         </div>
      </div>
      <!-- END VALIDATION STATES-->
   </div>
</div>
</div>
</div>
