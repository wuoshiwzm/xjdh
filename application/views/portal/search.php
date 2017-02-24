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
						<h3>搜索 <?php echo htmlentities($queryStr, ENT_COMPAT, "UTF-8"); ?> 局站查询结果</h3>
					</div>
					<div class="widget-container">
						<table
							class="table table-bordered responsive table-striped table-sortable">
							<thead>
								<tr>
									<th>序号</th>
									<th>分公司</th>
									<th>区域</th>
									<th>局站</th>
									<th>局站类型</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
							<?php $i = $offset + 1;foreach ($substationList as $substationObj){?>
							 <tr>
									<td><?php echo $i++;?></td>
									<td><?php echo htmlentities(Defines::$gCity[$substationObj->city_code],ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities(Defines::$gCounty[$substationObj->city_code][$substationObj->county_code],ENT_COMPAT,"UTF-8");?></td>
									<td><?php echo htmlentities($substationObj->name, ENT_COMPAT, "UTF-8"); ?></td>
									<td><?php echo htmlentities($substationObj->type, ENT_COMPAT, "UTF-8"); ?></td>
									<td><a type="button"
										href="/portal/room_list/<?php echo htmlentities($substationObj->id,ENT_COMPAT,"UTF-8");?>"
										class="btn btn-info"><i class="icon-search"></i> 查看局站</a></td>
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
