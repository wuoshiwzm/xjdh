<script type="text/javascript">
var areaTreeData = <?php echo json_encode($areaTreeData);?>;
</script>
<!-- <style> -->
/* <!-- */

/* #area-tree ul { */
/*     background: #efefef;  */
/*     background: linear-gradient(top, #efefef 0%, #bbbbbb 100%);   */
/*     background: -moz-linear-gradient(top, #efefef 0%, #bbbbbb 100%);  */
/*     background: -webkit-linear-gradient(top, #efefef 0%,#bbbbbb 100%);  */
/*     box-shadow: 0px 0px 9px rgba(0,0,0,0.15); */
/*     padding: 0 20px; */
/*     border-radius: 10px;   */
/*     list-style: none; */
/*     position: relative; */
/*     display: inline-table; */
/* } */
/* --> */
<!-- </style> -->
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
							<i class="icon-pencil"></i> 设置温度告警规则
						</h3>
					</div>
					<div class="widget-container">
						<button user_id='<?php echo $this->input->get('user_id');?>'
							type="button" id='btnSubmit' class="btn btn-primary btn-large">
							<i class="icon-ok"></i> 设置温度告警规则
						</button>
						<div class='row-fluid'>
							<div class='span6'>
								<div class="content-widgets">
									<div class="widget-header-block">
										<h3>区域权限</h3>
									</div>
									<div id='area-tree'
											style="max-height: 500px; overflow-y: auto;">
										<ul id="cityKey">
										
									<?php if($_SESSION['XJTELEDH_USERROLE'] == 'admin') {?>
										<?php foreach (Defines::$gCity as $cityKey => $cityVal) {?>
										  <li >
										     <?php echo $cityVal?>
										      <ul id="countyKey">
										       <?php foreach (Defines::$gCounty[$cityKey] as $countyKey => $countyVal) {?>
										       <li style="display:none;">
										          <?php echo $countyVal?>
										          <ul id="substationList">
										             <?php foreach ($substationList as $substationListObj){?>
										             <?php if($substationListObj->county_code == $countyKey){?>
										             <li>
										                <?php echo htmlentities($substationListObj->name,ENT_COMPAT,"UTF-8")?>
										                <ul id="roomList">
										                 <?php foreach ($deviceList as $roomListObj){?>
										                  <?php if($roomListObj->substation_id == $substationListObj->id){?>
										                  <li id="<?php echo htmlentities($roomListObj->devId,ENT_COMPAT,"UTF-8")?>">
										                      <?php echo $roomListObj->name?>/ <?php echo htmlentities($roomListObj->devName,ENT_COMPAT,"UTF-8")?>
										                  </li>
										                  <?php }?>
										                  <?php }?>
										                </ul>
										             </li>
										             <?php }?>
										             <?php }?>
										          </ul>
										       </li>
										       <?php }?>
										      </ul>										    
										  </li>
										 <?php }?>		 
									<?php }?>

								    <?php if($_SESSION['XJTELEDH_USERROLE'] == 'city_admin') {?>
									<?php foreach (Defines::$gCity as $cityKey => $cityVal) {?>
									    <?php $city_code = $this->userObj->city_code ?>
										        <?php if ($city_code == $cityKey ){ ?>
										  <li ><?php echo $cityVal?>
										      <ul id="countyKey">
										       <?php foreach (Defines::$gCounty[$cityKey] as $countyKey => $countyVal) {?>
										       <li style="display:none;">
										          <?php echo $countyVal?>
										          <ul id="substationList">
										             <?php foreach ($substationList as $substationListObj){?>
										             <?php if($substationListObj->county_code == $countyKey){?>
										             <li>
										                <?php echo htmlentities($substationListObj->name,ENT_COMPAT,"UTF-8")?>
										                <ul id="roomList">
										                 <?php foreach ($deviceList as $roomListObj){?>
										                  <?php if($roomListObj->substation_id == $substationListObj->id){?>
										                  <li id="<?php echo htmlentities($roomListObj->devId,ENT_COMPAT,"UTF-8")?>">
										                      <?php echo $roomListObj->name?>/ <?php echo htmlentities($roomListObj->devName,ENT_COMPAT,"UTF-8")?>
										                  </li>
										                  <?php }?>
										                  <?php }?>
										                </ul>
										             </li>
										             <?php }?>
										             <?php }?>
										          </ul>
										       </li>
										       <?php }?>
										      </ul>										    
										  </li>					 
									   <?php }?>
									 <?php }?>
									<?php }?>
										</ul>
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
<div class="modal fade bs-example-modal-lg" role="dialog"
	id='thresholdDialog'
	style="left: 50%; margin-left: -550px; width: 1100px; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body modal-lg">
				<h4>设置完毕，请点击"保存"按钮对所有修改进行保存</h4>
				<p>阀值类型：上限：当采样值增加大于上限触发。下限：当采样值减少小于下限时触发。阀值：采样值等于阀值时候触发。</p>
				<div class="row-fluid">
					<div class="span6">
						<button type="button" class="btn btn-primary" id="btnAddRule">新建告警规则</button>
					</div>
				</div>
				<br>
				<table
					class="paper-table table table-paper table-striped table-sortable">
					<thead>
						<tr>
							<th>序号</th>
							<th>阀值类型</th>
							<th>阀值</th>
							<th>告警级别</th>
							<th>信号名称</th>
							<th>信号ID</th>
							<th>告警文本</th>
<!-- 							<th>适用于<br/>局站类型</th> -->
							<th>屏蔽状态</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody id="tbRule">
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-danger" id='btn-ok-checks' >保存</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
 <div class="modal fade bs-example-modal-lg" role="dialog"
	id='thresholdDialog3'
	style="left: 50%; width: 500px; display: none;">
	
		<h4>你确定要进行修改吗？</h4>
	
		<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="qx" data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-danger" id="btn-ok-check" data-dismiss="modal" >确定</button>
			</div>
	</div>
