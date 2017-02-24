<script type="text/javascript">
var areaTreeData = <?php echo json_encode($areaTreeData);?>;
var devTreeData = <?php echo json_encode($devTreeData);?>;
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
				<div class="content-widgets">
					<div class="widget-head bondi-blue">
						<h3>
							<i class="icon-pencil"></i> 编辑用户权限
						</h3>
					</div>
					<div class="widget-container">
						<a href='<?php echo $_SERVER['HTTP_REFERER'];?>'
							class="btn btn-info btn-large"><i class="icon-reply"></i> 返回</a>
						<button user_id='<?php echo $this->input->get('user_id');?>'
							type="button" id='btnSubmit' class="btn btn-primary btn-large">
							<i class="icon-ok"></i> 提交修改
						</button>
						<div class='row-fluid'>
							<div class='span6'>
								<div class="content-widgets">
									<div class="widget-header-block">
										<h3>区域权限</h3>
									</div>
									<div class="content-box">
										<input type="text" value=""
											style="box-shadow: inset 0 0 4px #eee; margin: 0; padding: 6px 12px; border-radius: 4px; border: 1px solid silver; font-size: 1.1em;"
											id="areaQuery" placeholder="搜索" />
										<div id='area-tree'
											style="max-height: 500px; overflow-y: auto;"></div>
									</div>
								</div>
							</div>
							<div class='span6'>
								<div class="content-widgets">
									<div class="widget-header-block">
										<h3>设备权限</h3>
									</div>
									<div class="content-box"
										style="max-height: 500px; overflow-y: auto;">
										<div id='dev-tree'></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
