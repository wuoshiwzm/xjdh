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
							<i class="icon-pencil"></i>添加图片信息
						</h3>
					</div>
					<div class="widget-container">
						<form class="form-horizontal" enctype="multipart/form-data" enctype="multipart/form-data" method='post'>
												 <?php if(isset($errorMsg)){?>
                            <div class="alert alert-error">
								<button data-dismiss="alert" class="close" type="button">×</button>
								<i class="icon-exclamation-sign"></i><?php echo $errorMsg;?>
                    		</div>
                		<?php }else if($successMsg){?>
                		  <div class="alert alert-success">
								<button data-dismiss="alert" class="close" type="button">×</button>
								<i class="icon-ok-sign"></i><?php echo $successMsg;?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']?>"><font color='write'>继续添加</font></a>
    					   </div>
                		<?php }?>
							<div  class="control-group">								
									<label class="control-label" style="float: left;">上传图片</label>
									<div  id="new_up" class="controls" style="margin-left: 20px; float: left;">
                                         <input type="file" name="ufile">
									</div>	
								
								<label class="control-label" style="float: left;">修改分组：</label>
								<div class="controls" style="margin-left: 20px; float: left;">
								 <input type='text' value="<?php echo $value->newGrouping?>" name='txtName1' id='txtName1'
										 />
								</div>
							</div>
							<div  class="control-group">
							         <label class="control-label" style="float: left;">图片说明：</label>
									<div  id="new_up" class="controls" style="margin-left: 20px; float: left;">
                                          
							              <textarea name='explain' id='explain' rows="3" cols="11" style="width: 367px; height: 66px;"><?php echo $value->explain?></textarea>
									</div>	
							</div>	
								<div class="form-actions">
								<button class="btn btn-success" type="submit" name="btn-submit" value="<?php echo htmlentities($substation->id,ENT_COMPAT,"UTF-8")?>" id='btn-submits'>提交</button>
																								<a href=<?php echo site_url("portal/stationGather/"); ?>
							class="btn btn-success"><i class="icon-reply"></i> 返回</a>
							
							    </div>
								</form>			
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>