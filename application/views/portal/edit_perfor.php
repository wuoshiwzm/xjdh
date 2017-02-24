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
                						      						
					      <div class="control-group">
								<label class="control-label" style="float: left;">专业</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='major' id='major'
										value='<?php if(isset($perfor)) echo htmlentities($perfor->major, ENT_COMPAT, "UTF-8");?>' />
								</div>					
							<div class="control-group">
								<label class="control-label" style="float: left;">设备类型</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='device_type' id='device_type'
										value='<?php if(isset($perfor)) echo htmlentities($perfor->device_type, ENT_COMPAT, "UTF-8");?>' />
								</div>					
							</div>	
							
							<div class="control-group">
								<label class="control-label" style="float: left;">指标</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='quota' id='quota'
										value='<?php if(isset($perfor)) echo htmlentities($perfor->quota, ENT_COMPAT, "UTF-8");?>' />
								</div>					
							<div class="control-group">
								<label class="control-label" style="float: left;">采集周期</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='cycle' id='cycle'
										value='<?php if(isset($perfor)) echo htmlentities($perfor->cycle, ENT_COMPAT, "UTF-8");?>' />
								</div>					
							</div>	
							
							<div class="control-group">
								<label class="control-label" style="float: left;">阀值夜间</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='night' id='night'
										value='<?php if(isset($perfor)) echo htmlentities($perfor->night, ENT_COMPAT, "UTF-8");?>' />
								</div>					
							<div class="control-group">
								<label class="control-label" style="float: left;">阀值白天</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='day' id='day'
										value='<?php if(isset($perfor)) echo htmlentities($perfor->day, ENT_COMPAT, "UTF-8");?>' />
								</div>					
							</div>	
							
							<div class="control-group">
								<label class="control-label" style="float: left;">输出设备</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='output_device' id='output_device'
										value='<?php if(isset($perfor)) echo htmlentities($perfor->output_device, ENT_COMPAT, "UTF-8");?>' />
								</div>					
							<div class="control-group">
								<label class="control-label" style="float: left;">采集方式</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='acquisition_methods' id='acquisition_methods'
										value='<?php if(isset($perfor)) echo htmlentities($perfor->acquisition_methods, ENT_COMPAT, "UTF-8");?>' />
								</div>					
							</div>	
							
							<div class="control-group">
								<label class="control-label" style="float: left;">类型</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='type' id='type'
										value='<?php if(isset($perfor)) echo htmlentities($perfor->type, ENT_COMPAT, "UTF-8");?>' />
								</div>					
							<div class="control-group">
								<label class="control-label" style="float: left;">责任单位</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='responsible' id='responsible'
										value='<?php if(isset($perfor)) echo htmlentities($perfor->responsible, ENT_COMPAT, "UTF-8");?>' />
								</div>					
							</div>	
							
							<div class="control-group">
								<label class="control-label" style="float: left;">设定依据</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='set_basis' id='set_basis'
										value='<?php if(isset($perfor)) echo htmlentities($perfor->set_basis, ENT_COMPAT, "UTF-8");?>' />
								</div>					
							<div class="control-group">
								<label class="control-label" style="float: left;">输出方式</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='output_mode' id='output_mode'
										value='<?php if(isset($perfor)) echo htmlentities($perfor->output_mode, ENT_COMPAT, "UTF-8");?>' />
								</div>					
							</div>	
							
							<div class="control-group">
								<label class="control-label" style="float: left;">备注</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='remarks' id='remarks'
										value='<?php if(isset($perfor)) echo htmlentities($perfor->remarks, ENT_COMPAT, "UTF-8");?>' />
								</div>					
							<div class="control-group">
								<label class="control-label" style="float: left;">指标配置</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='config' id='config'
										value='<?php if(isset($perfor)) echo htmlentities($perfor->config, ENT_COMPAT, "UTF-8");?>' />
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