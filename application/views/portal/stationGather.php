<script type="text/javascript">
<!--
var substationGather = <?php echo json_encode($substationGather); ?>;
var substationGatherimg = <?php echo json_encode($substationGatherimg); ?>;
//-->
$(document).ready(function(){
	$('a.videolink').click(function(e) {
	    e.preventDefault();

	    var container = $('<div/>');

	    container.flowplayer(
	        '/public/flowplayer-3.2.7.swf',
	        $(this).attr('href')
	    );

	    $.fancybox({
	        content: container,
	        width: 300, height: 200,
	        scrolling: 'no',
	        autoDimensions: false
	    });
	});
});
</script>
<style>
* { margin: 0; padding: 0;}
.dowebok { width: 920px; margin: 0 auto; list-style-type: none; zoom: 1;}
.dowebok:after { content: ''; display: table; clear: both;}
.dowebok li { float: left; width: 200px; height: 200px; margin: 20px 10px 0; display: inline;}
.dowebok1 { border: 2px solid #d9fff7;}
.dowebok1 img { width: 200px; height: 200px; vertical-align: top;}
.dowebok2 { border: 5px solid #d9fff7;}
</style>
<style>
* { margin: 0; padding: 0;}
.dowebokList { width: 300px; margin: 0 auto; list-style-type: none; zoom: 1;}
.dowebokList:after { content: ''; display: table; clear: both;}
.dowebokList li { float: left; width: 70px; height: 50px; margin: 20px 10px 0; display: inline;}
.dowebok1 { border: 2px solid #d9fff7;}
.dowebok1 img { width: 70px; height: 50px; vertical-align: top;}
.dowebok2 { border: 5px solid #d9fff7;}
</style>
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
						<li class="active"><a href="<?php echo $bcObj->url;?>"><?php echo $bcObj->title;?></a></li>
						<?php }?>
					</ul>
				</div>
			</div>
		</div>
		
		<?php if(!$stationimGnewGrouping){?>
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
								<label class="control-label" style="float: left;">所属部门/分公司</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择分公司"
										name='selCity' id='selCity'>
										<?php if($userObj->user_role == "admin"){?>
    							        <option value=''>全网</option>
    							        <?php foreach (Defines::$gCity as $cityKey=>$cityVal){?>
							            <option value='<?php echo $cityKey;?>'
											<?php  if($cityCode == $cityKey){?> selected="selected"
											<?php }?>><?php echo $cityVal;?>本地网</option>
    							        <?php }?>
    							        <?php }else if($userObj->user_role == "city_admin"){ ?>
    							        <option value="<?php echo $userObj->city_code; ?>">
    							            <?php echo Defines::$gCity[$userObj->city_code]; ?></option>
    							        <?php }?>
    								</select>
								</div>
								<label class="control-label" style="float: left;">所属区域</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择区域"
										name='selCounty' id='selCounty'>
									<?php if($userObj->user_role == "city_admin"){ ?>
											<option value="0">所有区域</option>
											<?php foreach (Defines::$gCounty[$userObj->city_code] as $key=> $val){?>
										    <option value='<?php echo $key;?>'
												<?php if($countyCode == $key){?>selected="selected"<?php }?>>
												<?php echo $val;?></option>
									        <?php } ?>
								        <?php }else{ ?>
										    <option value="0">所有区域</option>
										    <?php if(count($cityCode)) foreach (Defines::$gCounty[$cityCode] as $key=> $val){?>
									            <option value='<?php echo $key;?>'
											    <?php if($countyCode == $key){?> selected="selected" <?php }?>>
											    <?php echo $val;?></option>
								            <?php }?>   
								        <?php }?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" style="float: left;">局站名字</label>
								<div class="controls" style="margin-left: 20px; float: left;">

	                                    <input type='text' name='txtName' id='txtName'
										value='<?php  echo $txtName;?>' />

								</div>
							</div>						
							<div class="form-actions">
								<button class="btn btn-success" type="submit" id='btn-submit'>提交</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php }?>
		
		<div class="row-fluid">
			<div class="span12">
				<div class="content-widgets light-gray">
					<?php if($stationimGnewGrouping){?>
					<div class="widget-head bondi-blue">
						<h3>局站采集详情</h3>
					</div>
                      <div class="tab-widget tabbable tabs-left chat-widget">						
						 <div class="tab-content" style='height: 800px;'>				
                      <?php $i = $offset + 1;foreach ($stationimGnewGrouping as $substationObj){?>  
                      <br><h3><?php echo $substationObj->newGrouping?></h3><br>
                      <ul class="dowebok">
                                   <?php $i = $offset + 1;foreach ($substationGatherimg as $substationObjs){?> 
                                   <?php if($substationObjs->newGrouping == $substationObj->newGrouping){?>
                                <li class="dowebok1">                                 
                                 <a rel="group" href="/public/portal/Station_image/<?php echo $substationObjs->stationImage?>"><img class="example1" src="/portal/station_thumb/<?php echo $substationObjs->stationImage?>" /></a>
                                  <a class="deleteImg" val="<?php echo $substationObjs->id?>" href="#">删除</a>/<a href="/portal/updat_Stationimage/<?php echo $substationObjs->id?>">修改</a>/<a class="demo1" href="/public/portal/Station_image/<?php echo $substationObjs->stationImage?>" title="<?php echo $substationObjs->explain?>">文本</a>
                                </li>
                                 
								     <?php }?>   
						           <?php }?> 
					  </ul>           
                      <?php }?>
						 </div>
                        </div> 
						<?php }?>	
						<?php if(!$stationimGnewGrouping){?>	
						<div class="widget-head bondi-blue">
						<h3>局站采集列表</h3>
					    </div>				 
					<div class="widget-container">					
					   <?php if($roomCode != false){?>
					   <p>
							<a id="btn-close" class="btn btn-primary"
								href='/portal/manageRoom'><i class="icon-reply"></i> 查看所有局站</a>
						</p>
					   <?php }?>
						<div class="row-fluid">
							<div class="span6">

                            </div>
							<div class="span6">
                            <?php echo $pagination;?>
                            </div>
						</div>
						<br>
					   <table
							class="table table-bordered responsive table-striped table-sortable">
							<thead>
								<tr>

									<th>序号</th>
									<th>局站名字</th>
									<th>坐标</th>
									<th>时间</th>
									<th>部分图片</th>
									<th>图片数量</th>	
									<th width = 280>操作</th>							
								</tr>
							</thead>
							<tbody>
							<?php $i = $offset + 1;foreach ($substationList as $substationObj){?>  
							 <tr>
									<td><?php echo $i++;?></td>
									<td><?php echo htmlentities($substationObj['name'], ENT_COMPAT, "UTF-8");?></td>
									<td><?php echo htmlentities($substationObj['lat'], ENT_COMPAT, "UTF-8");?>/<?php echo htmlentities($substationObj['lng'], ENT_COMPAT, "UTF-8");?></td>	
									<td><?php echo htmlentities($substationObj['UploadTime'],ENT_COMPAT,"UTF-8")?></td>	
									<td>
									<ul class="dowebokList">
									<?php foreach ($substationObj['img'] as $imgObj){?>	
									<li class="dowebok1">
									<?php if( substr( $imgObj, strlen( $imgObj ) - strlen( "flv" ) ) === "flv"){ ?>
									<a class="videolink" href="/public/portal/Station_image/<?php echo $imgObj; ?>">查看视频</a>
									<?php }else{ ?>			
									<a rel="group" href="/public/portal/Station_image/<?php echo $imgObj?>">
									<img src="/portal/station_thumb/<?php echo $imgObj?>" />
									</a>
									<?php } ?>
									</li>
									<?php }?>
									</ul>
									</td>
									<td><?php echo htmlentities($substationObj['count'],ENT_COMPAT,"UTF-8")?></td>								
									<td><a class="btn btn-info" href="/portal/stationGather?substationid=<?php echo $substationObj['id'];?>">详细信息</a>
							            <a class="btn btn-info" id="editstations"  href="/portal/editsubstation?substationid=<?php echo $substationObj['id'];?>">确认采集局站</a>
							            <a hrefvalue="<?php echo $substationObj['id']?>" id="deletestation" class="btn btn-info hrefvalue">删除局站</a>	
							            <a class="btn btn-info" id="editstation"  href="/portal/editsubstationGather/<?php echo $substationObj['id'];?>">添加图片</a>								
									</td>						
								</tr>
							 <?php }?>
							</tbody>
						</table>
						<div class="row-fluid">
							<div class="span6">
                                 总计 <?php echo $count;?> 个局站
                            </div>
							<div class="span6">
                            <?php echo $pagination;?>
                            </div>
						</div>
					</div>
					<?php }?>
				</div>
			</div>
		</div>
	</div>
</div>