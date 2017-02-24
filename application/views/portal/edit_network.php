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
							<i class="icon-pencil"></i> 插入/修改数据信息
						</h3>
					</div>
					<div class="widget-container">
						<form class="form-horizontal" action=" " method='post'>
						 <?php if(isset($errorMsg)){?>
                            <div class="alert alert-error">
								<button data-dismiss="alert" class="close" type="button">×</button>
								<i class="icon-exclamation-sign"></i><?php echo $errorMsg;?>
                    		</div>
                		<?php }else if($successMsg){?>
                		  <div class="alert alert-success">
								<button data-dismiss="alert" class="close" type="button">×</button>
								<i class="icon-ok-sign"></i><?php echo $successMsg;?>
    					   </div>
                		<?php }?>	
                						      						
					<label class="control-label" style="float: left;">局站类别</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select chzn-search-disabled "
										name='type' id='type'>
										<option value='0' selected='selected' >所有类别</option>
										<option value='A'<?php if(isset($network) && $network->type == "A"){?>selected="selected"<?php }?>>A</option>
										<option value='B'<?php if(isset($network) && $network->type == "B"){?>selected="selected"<?php }?>>B</option>
										<option value='C'<?php if(isset($network) && $network->type == "C"){?>selected="selected"<?php }?>>C</option>
									</select>
								</div>
		                     <div class="control-group">
							<label class="control-label" style="float: left;">指标性质</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select chzn-search-disabled "
										name='property' id='property'>
										<option value='0' selected='selected' >所有性质</option>
										<option value='关键'<?php if(isset($network) && $network->property == "关键"){?>selected="selected"<?php }?>>关键</option>
										<option value='重要'<?php if(isset($network) && $network->property == "重要"){?>selected="selected"<?php }?>>重要</option>
										<option value='一般'<?php if(isset($network) && $network->property == "一般"){?>selected="selected"<?php }?>>一般</option>
									</select>
								</div>
							</div>
							<div class="control-group">
							<label class="control-label" style="float: left;">指标网元</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select name="element">
									   <option value="">所有网元</option>
									   <?php foreach(Defines::$gElement as $value){ ?>
									   <option value="<?php echo $value; ?>" <?php if(isset($network) && $network->element == $value){ echo "selected"; } ?> ><?php echo $value; ?></option>
									   <?php } ?>
									</select>	
								</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">指标名称</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='name' id='name'
										value='<?php if(isset($network)) echo htmlentities($network->name, ENT_COMPAT, "UTF-8");?>' />
								</div>					
							</div>	
							
							<div class="control-group">
								<label class="control-label" style="float: left;">指标含义</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='meaning' id='meaning'
										value='<?php if(isset($network)) echo htmlentities($network->meaning, ENT_COMPAT, "UTF-8");?>' />
								</div>					
							<div class="control-group">
								<label class="control-label" style="float: left;">指标要求</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='requirements' id='requirements'
										value='<?php if(isset($network)) echo htmlentities($network->requirements, ENT_COMPAT, "UTF-8");?>' />
								</div>					
							</div>	
							
							<div class="control-group">
								<label class="control-label" style="float: left;">参考依据</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='reference' id='reference'
										value='<?php if(isset($network)) echo htmlentities($network->reference, ENT_COMPAT, "UTF-8");?>' />
								</div>					
							<div class="control-group">
								<label class="control-label" style="float: left;">备注</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='remarks' id='remarks'
										value='<?php if(isset($network)) echo htmlentities($network->remarks, ENT_COMPAT, "UTF-8");?>' />
								</div>					
							</div>	
							
							<div class="control-group">
								<label class="control-label" style="float: left;">指标配置</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<textarea name='config' id='config'/><?php if(isset($network)) echo htmlentities($network->config, ENT_COMPAT, "UTF-8");?></textarea>
								</div>					
							</div>	
								
								<div class="form-actions">
							   <button class="btn btn-success" type="submit" name="btn-submit" value="<?php echo htmlentities($data->id,ENT_COMPAT,"UTF-8")?>" id='btn-submits'>提交</button>
							   </div>
						  </form>			
					   </div>
					</div>
				</div>
			</div>
		</div>
	</div>