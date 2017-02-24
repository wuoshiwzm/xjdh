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
			<?php if($type == 0){ ?> 
			<div class="row-fluid">
			<div class="span12">
				<div class="content-widgets">
					<div>
						<div class="widget-header-block">
							<h4 class="widget-header">
								<i class=" icon-table"></i>采集器：<?php echo htmlentities($smdDev->name,ENT_COMPAT,"UTF-8"); ?> 编号：<?php echo htmlentities($smdDev->device_no,ENT_COMPAT,"UTF-8"); ?></h4>
						</div>
						<div class="content-box" style="height: 200px; overflow: scroll;">
							<ul class="rtlog" data_id="<?php echo htmlentities($smdDev->device_no,ENT_COMPAT,"UTF-8"); ?>">
							</ul>
						</div>
					</div>
				</div>
			</div>

		</div>
			<?php foreach($devList as $devObj){ ?>
			
			<div class="row-fluid">
			<div class="span12">
				<div class="content-widgets">
					<div>
						<div class="widget-header-block">
							<h4 class="widget-header">
								<i class=" icon-table"></i>设备名：<?php echo htmlentities($devObj->name,ENT_COMPAT,"UTF-8"); ?> 数据ID：<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8"); ?></h4>
						</div>
						<div class="content-box" style="height: 200px; overflow: scroll;">
							<ul class="rtlog" data_id="<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8"); ?>">
							</ul>
						</div>
					</div>
				</div>
			</div>

		</div>
			<?php } ?>
			<?php }else{ ?>
			<div class="row-fluid">
			<div class="span12">
				<div class="content-widgets">
					<div>
						<div class="widget-header-block">
							<h4 class="widget-header">
								<i class=" icon-table"></i>设备名：<?php echo htmlentities($devObj->name,ENT_COMPAT,"UTF-8"); ?> 数据ID：<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8"); ?></h4>
						</div>
						<div class="content-box" style="height: 200px; overflow: scroll;">
							<ul class="rtlog" data_id="<?php echo htmlentities($devObj->data_id,ENT_COMPAT,"UTF-8"); ?>">
							</ul>
						</div>
					</div>
				</div>
			</div>

		</div>
			<?php } ?>
			
	</div>
</div>
