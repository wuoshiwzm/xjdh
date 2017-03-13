<script type="text/javascript">
var parentcode = <?php echo json_encode($parentcode);?>;
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
			<style type="text/css">
#container {
	height: 600px;
	width:90%;
}

.loading {
	margin-top: 15em;
	text-align: center;
	color: gray;
}
</style>
			<div class="span12" id="container">
				<div class="loading">
					<i class="icon icon-spinner icon-spin icon-large"></i> 正在加载数据...
				</div>
			</div>
		</div>
	</div>
</div>