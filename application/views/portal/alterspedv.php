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
							<i class="icon-pencil"></i> 修改数据信息
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
							<label class="control-label">智能设备型号</label>
								<div class="controls">
									<input type='text' name='name' id='name' class="span12"
										value='<?php if(isset($spedv)) echo htmlentities($spedv->name, ENT_COMPAT, "UTF-8")?>' />
								</div>
								</div>
							<div class="control-group">
							<label class="control-label">波特率</label>
								<div class="controls">
									<select name="baudRate">
									   <?php foreach(Defines::$gBaudRate as $value){ ?>
									   <option value="<?php echo $value; ?>" <?php if(isset($spedv) && $spedv->baud_rate == $value){ echo "selected"; } ?> ><?php echo $value; ?></option>
									   <?php } ?>
									</select>
									
								</div>
								</div>
								<div class="control-group">																			
							<label class="control-label">发送命令</label>
								<div class="controls" >
									<input type='text' name='cmd' id='cmd' class="span12"
										value='<?php if(isset($spedv)) echo htmlentities($spedv->cmd, ENT_COMPAT, "UTF-8");?>' />
								</div>
								</div>
							<div class="control-group">
							<label class="control-label">接收回应</label>
								<div class="controls" >
									<input type='text' name='reply' id='reply' class="span12"
										value='<?php if(isset($spedv)) echo htmlentities($spedv->reply, ENT_COMPAT, "UTF-8");?>' />
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