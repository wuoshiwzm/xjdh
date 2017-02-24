<script type="text/javascript">
$(document).ready(function(){
	$("#dataTable").tablesorter();
});
</script>

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
							<i class="icon-list"></i> 更新历史
						</h3>
					</div>
					<div class="widget-container">
						<div class="row-fluid">
							<div class="span6">
								<button href="###" class="btn btn-info" type="button"
									id='btnAddApp'>
									<i class="icon-plus"></i> 上传APP
								</button>
							</div>
						</div>
						<br>
						<table id="dataTable"
							class="table table-bordered responsive table-striped tablesorter"">
							<thead>
								<tr>
									<th>序号</th>
									<th>版本号</th>
									<th>版本名称</th>
									<th>下载链接地址</th>
									<th>更新日志</th>
									<th>更新时间</th>
								</tr>
							</thead>
							<tbody>
							<?php $i = 1; foreach ($updateList as $updateObj){?>
							<tr>
									<td><?php echo $i++;?></td>
									<td><?php echo htmlentities($updateObj->version_code,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($updateObj->version_name,ENT_COMPAT,"UTF-8");?></td>
									<td><a target="_blank"
										href='<?php echo htmlentities($updateObj->download_url,ENT_COMPAT,"UTF-8");?>'><?php echo htmlentities($updateObj->download_url,ENT_COMPAT,"UTF-8");?></a></td>
									<td><?php echo htmlentities($updateObj->update_log,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($updateObj->update_datetime,ENT_COMPAT,"UTF-8");?></td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bs-example-modal-lg" role="dialog"
	id='uploadDialog'>
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" class="form-horizontal"
				enctype="multipart/form-data">
				<div class="modal-body modal-lg">
					<h4>选择数据变量</h4>
					<div class="control-group">
						<label class="control-label">选择文件</label>
						<div class="controls">
							<div data-provides="fileupload" class="fileupload fileupload-new">
								<div class="input-append">
									<div class="uneditable-input span2">
										<i class="icon-file fileupload-exists"></i><span
											class="fileupload-preview"></span>
									</div>
									<span class="btn btn-file"><span class="fileupload-new">选择</span><span
										class="fileupload-exists">修改</span> <input type="file"
										name="fUpload"> </span><a data-dismiss="fileupload"
										class="btn fileupload-exists" href="#">删除</a>
								</div>
							</div>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">版本号</label>
						<div class="controls">
							<input type="number" name="txtVersionCode">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">版本名称</label>
						<div class="controls">
							<input type="text" name="txtVersionName" id="txtVersionName">
						</div>
					</div>
					<!--     			<div class="control-group"> -->
					<!--     				<label class="control-label">下载地址</label> -->
					<!--     				<div class="controls"> -->
					<!--     					<input type="text" name="txtDownloadUrl" id="txtDownloadUrl"> -->
					<!--     				</div> -->
					<!--     			</div> -->
					<div class="control-group">
						<label class="control-label">更新描述</label>
						<div class="controls">
							<textarea name="txtUpdateLog"></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-info">提交</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script type="text/javascript">
$(document).ready(function(){
	$('fUpload')
	$('#btnAddApp').click(function(){
		$('#uploadDialog').modal('show');
	});
	$('#txtVersionName').change(function(){
		//$('#txtDownloadUrl').val('http://' + window.location.host + 'xjdh-v' + $(this).val() + '.apk');
	});
	<?php if(isset($ret)){?>
	<?php if($ret){?>
    	var n = noty({
    		text: '<span>上传成功。</span>',
    		type: 'success',
    		layout: 'topCenter',
    		closeWith: ['hover','click','button']
    	});
	<?php }else{?>
    	var n = noty({
    		text: '<span>上传失败，请重试。</span>',
    		type: 'error',
    		layout: 'topCenter',
    		closeWith: ['hover','click','button']
    	});
	<?php }?>	
	<?php }?>
});
</script>