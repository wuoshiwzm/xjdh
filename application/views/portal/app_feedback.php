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
							<i class="icon-list"></i> 意见建议
						</h3>
					</div>
					<div class="widget-container">
						<ul id="myTab1" class="nav nav-tabs">
							<li <?php if($status == 'unreplied'){?> class="active" <?php }?>><a
								href="<?php echo site_url('portal/feedback/unreplied')?>"><i
									class=" icon-file"></i> 未回复</a></li>
							<li <?php if($status == 'replied'){?> class="active" <?php }?>><a
								href="<?php echo site_url('portal/feedback/replied')?>"><i
									class="icon-user"></i> 已回复</a></li>
							<li <?php if($status == 'all'){?> class="active" <?php }?>><a
								href="<?php echo site_url('portal/feedback/all')?>"><i
									class=" icon-tasks"></i> 全部</a></li>
						</ul>
						<table
							class="table table-bordered responsive table-striped table-sortable">
							<thead>
								<tr>
									<th>序号</th>
									<th>标题</th>
									<th>内容</th>
									<th>姓名</th>
									<th>时间</th>
									<th>回复信息</th>
									<th>回复时间</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
							<?php $index = 1; foreach ($feedbackList as $feedbackObj){?>
							 <tr>
									<td><?php echo $index++;?></td>
									<td><?php echo htmlentities($feedbackObj->title,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($feedbackObj->content,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($feedbackObj->full_name,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($feedbackObj->added_datetime,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($feedbackObj->reply,ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($feedbackObj->reply_datetime,ENT_COMPAT,"UTF-8");?></td>
									<td feedback_id='<?php echo htmlentities($feedbackObj->id,ENT_COMPAT,"UTF-8");?>'>
							     <?php if($feedbackObj->reply == ''){?>
							         <a class="btn btn-info btn-reply" href="###"
										type="button"><i class="icon-pencil"></i> 回复</a>
							     <?php } if($feedbackObj->reply != ''){?>
							         <a class="btn btn-info btn-reply" href="###"
										type="button"><i class="icon-pencil"></i> 修改回复</a> <a
										class="btn btn-danger btn-delete-reply" href="###"
										type="button"><i class="icon-trash"></i> 删除回复</a>
							     <?php }?>
						              <a class="btn btn-danger btn-delete" href="###"
										type="button"><i class="icon-remove"></i> 删除</a>
									</td>
								</tr>
							<?php }?>
							</tbody>
						</table>
						<div class="row-fluid">
							<div class="span6"></div>
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
<div class="modal hide fade bs-example-modal-lg" id='replyDlg'
	style="left: 50%; margin-left: -550px; width: 1100px;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"
			aria-hidden="true">&times;</button>
		<h4>反馈回复</h4>
	</div>
	<div class="modal-body">
		<div class="widget-container">
			<textarea id="txtReply" class="tinymce-simple" style="width: 100%;"
				rows="5"></textarea>
		</div>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal" aria-hidden="true">关闭</a>
		<a href="#" class="btn btn-primary" id='btnSubmit'>确定</a>
	</div>
</div>