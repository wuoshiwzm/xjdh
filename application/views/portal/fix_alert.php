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
						<h3><i class="icon-pencil"></i> 修复告警状态</h3>
					</div>
					<?php if($successMsg){?>
				    <br/>
                	<div class="alert alert-success">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-ok-sign"></i><?php echo $successMsg;?>
    				</div>
                	<?php }?>
					<div class="widget-container">
						<form class="form-horizontal" method='post'>						
							<div class="control-group">
								<label class="control-label" style="float: left;">数据ID</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='txtDataId' id='txtDataId' value='<?php echo $dataId; ?>' />
								</div>
								<label class="control-label" style="float: left;">告警信号ID</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='txtSignalId' id='txtSignalId' value='<?php echo $signalId; ?>' />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">告警级别</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择告警级别"
										name='txtLevel' id='txtLevel'>
										<option value='' >所有级别</option>
										<option <?php if($level == 1){?> selected="selected" <?php } ?>
											value='1'>一级</option>
										<option <?php if($level == 2){?> selected="selected" <?php } ?>
											value='2'>二级</option>
										<option <?php if($level == 3){?> selected="selected" <?php } ?>
											value='3'>三级</option>
										<option <?php if($level == 4){?> selected="selected" <?php } ?>
											value='4'>四级</option>
									</select>
								</div>
							</div>
							<div class="form-actions">
								<button class="btn btn-success" type="submit" id='btn-submit' name="action" value="query">查询</button>
								<button class="btn btn-success" type="submit" id='btn-submit' name="action" value="fix">修复</button>
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
						<h3><i class="icon-list"></i>告警</h3>
					</div>
					<div class="widget-container">
					  <a type="button" class="btn btn-danger" id="btnRevoke"href='####'>
					     <i class="icon-plus"></i> 修复选中项</a>
					</div>
					 <table class="table table-bordered responsive table-striped">
							<thead>
								<tr>
								 <th><input type="checkbox" id="cbAll" /></th>
									<th>序号</th>
									<th>分公司</th>
									<th>区域</th>
									<th>局站</th>
									<th>设备id</th>
									<th>信号名称</th>
									<th>信号ID</th>
									<th>级别</th>
									<th>描述</th>
									<th>上报时间</th>
									<th>当前状态</th>
								</tr>
							</thead>
							<tbody id="userList">
							<?php $i = $offset + 1; foreach ($alertList as $alertObjs){?>
							<?php $j = $j + 1; foreach ($alertObjs as $alertObj){?>
							<tr alertId='<?php echo htmlentities($alertObj->id,ENT_COMPAT,"UTF-8");?>' devId='<?php echo htmlentities($alertObj->data_id,ENT_COMPAT,"UTF-8");?>' 
							    signalId='<?php echo htmlentities($alertObj->signal_id,ENT_COMPAT,"UTF-8");?>' level='<?php echo htmlentities($alertObj->level,ENT_COMPAT,"UTF-8");?>'>
							        <td><input type="checkbox"/></td>
									<td><?php echo $i++;?></td>
									<td><?php echo htmlentities(Defines::$gCity[$alertObj->city_code],ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities(Defines::$gCounty[$alertObj->city_code][$alertObj->county_code],ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($alertObj->sub_name,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($alertObj->data_id,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($alertObj->signal_name,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($alertObj->signal_id,ENT_COMPAT,"UTF-8");?></td>
									<td><?php switch ($alertObj->level) {
								                 case 1:
								                      echo '<span class="brown badge ">一级</span>';
								                      break;
								                 case 2:
								                      echo '<span class="badge orange">二级</span>';
								                      break;
								                 case 3:
								                      echo '<span class="dark-yellow badge ">三级</span>';
								                      break;
								                 case 4:
								                      default:
								                      echo '<span class="badge blue">四级</span>';
								                      break;}?>
							        </td>
									<td><?php echo htmlentities($alertObj->subject,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($alertObj->added_datetime,ENT_COMPAT,"UTF-8");?></td>
									<td><?php
									        if ($alertObj->status == 'unresolved')
									            echo '<span class="label label-important">未处理</span>';
									        else 
									            if ($alertObj->confirm_datetime != '0000-00-00 00:00:00')
									                echo '<span class="label label-info">已确认</span>';
									            else 
									                if ($alertObj->status == 'solved')
									                    echo '<span class="label label-success">已恢复</span>';?>
								    </td>
								</tr>
								<?php }?>
							<?php }?>	
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</div>	
				