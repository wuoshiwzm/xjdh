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
							<i class="icon-pencil"></i> <?php echo $pageTitle;?>
						</h3>
					</div>
					<div class="widget-container">
                		  <div class="alert alert-success">
                		  		<p>机房环境	</p>
								<button data-dismiss="alert" class="close" type="button">×</button>
								<i class="icon-ok-sign"></i><?php echo $successMsg.$i;?>个机房 <br />
																			<?php echo $errorMsg.$j;?>个机房 <br />
																			<?php echo $fine.$k;?>个机房 <br />
    					   </div>
    					   <div class="alert alert-success">
                		  		<p>监控设备	</p>
								<button data-dismiss="alert" class="close" type="button">×</button>
								<i class="icon-ok-sign"></i><?php echo $successMsg.$x;?>个机房 <br />
																			<?php echo $errorMsg.$y;?>个机房 <br />
																			<?php echo $fine.$z;?>个机房 <br />
    					   </div>
                		</div>
                		</div>
                		</div>
                		</div>
                		</div>
                		</div>
           
                		