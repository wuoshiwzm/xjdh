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
								<label class="control-label" style="float: left;">智能设备型号</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='name' id='name'
										value='<?php  echo $name;?>' />
								</div>
		                     <div class="control-group">
							<label class="control-label" style="float: left;">波特率</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select name="baud_rate">
									   <option value="">所有波特率</option>
									   <?php foreach(Defines::$gBaudRate as $key=>$val){ ?>
									   <option
											<?php if($baud_rate == $val) {?>
											selected="selected" <?php }?> value='<?php echo $val;?>'><?php echo $val;?></option>
									   <?php }?>
									</select>	
								</div>
								</div>
							
							<div class="control-group">
								<label class="control-label" style="float: left;">发送命令</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='cmd' id='cmd'
										value='<?php  echo $cmd;?>' />
								</div>
								<div class="control-group">
								<label class="control-label" style="float: left;">接受回应</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='reply' id='reply'
										value='<?php  echo $reply;?>' />
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
	
		<div class="row-fluid">
			<div class="span12">
				<div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>智能设备测试协议列表</h3>
					</div>
					<div class="widget-container">
					   <div class="row-fluid">
							<div class="span6">
								<a type="button" class="btn btn-info"
									href='<?php echo site_url('portal/edit_spedv');?>'><i
									class="icon-plus"></i> 添加智能设备测试协议</a>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span6">
                                 总计 <?php echo $count;?> 个智能设备测试协议
                            </div>
							<div class="span6">
                            <?php echo $pagination;?>
                            </div>
						</div>
					   <table
							class="table table-bordered responsive table-striped table-sortable">
							<thead>
								<tr>
									<th>序号</th>
									<th>智能设备型号</th>
									<th>波特率</th>
									<th>发送命令</th>
									<th>接受回应</th>	
									<th>操作</th>							
								</tr>
							</thead>
							<tbody>
							<?php $i = $offset + 1;foreach ($spedvlist as $spdevObj){?>  
							 <tr>
									<td><?php echo $i++;?></td>
								
									<td><?php echo htmlentities($spdevObj->name, ENT_COMPAT, "UTF-8");?></td>
									<td><?php echo htmlentities($spdevObj->baud_rate, ENT_COMPAT, "UTF-8"); ?></td>
									<td><?php echo htmlentities($spdevObj->cmd, ENT_COMPAT, "UTF-8");?></td>
									<td><?php echo htmlentities($spdevObj->reply, ENT_COMPAT, "UTF-8");?></td>	
									<td><a href="####" hrefvalue="<?php echo htmlentities($spdevObj->id,ENT_COMPAT,"UTF-8")?>" class="deletespedv" href="##">删除</a>/
									<a href="/portal/edit_spedv/<?php echo htmlentities($spdevObj->id,ENT_COMPAT,"UTF-8");?>">修改</a> </td>
								</tr>
							 <?php }?>
							</tbody>
						</table>
						<div class="row-fluid">
							<div class="span6">
                                 总计 <?php echo $count;?> 个智能设备测试协议
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