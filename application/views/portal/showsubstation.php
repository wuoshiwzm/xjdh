
<!doctype html>

<html  lang="en">
<script type="text/javascript">
var lng = <?php echo json_encode($lng); ?>;
var lat = <?php echo json_encode($lat); ?>;
var name = <?php echo json_encode($name); ?>;
var count = <?php echo $count; ?>;
var layer = <?php echo json_encode($layer); ?>;
</script>
<head>
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
<style type="text/css">
#container {width:1000px; height: 500px; MARGIN-RIGHT: auto; MARGIN-LEFT: auto; }  
     .panel {
        background-color: #ddf;
        color: #333;
        border: 1px solid silver;
        box-shadow: 3px 4px 3px 0px silver;
        position: absolute;
        top: 10px;
        right: 10px;
        border-radius: 5px;
        overflow: hidden;
        line-height: 20px;
      }
      #input{
        width: 250px;
        height: 25px;
        border: 0;
        background-color: white;
      }
        #tip {
            background-color: #ddf;
            color: #333;
            border: 1px solid silver;
            box-shadow: 3px 4px 3px 0px silver;
            position: absolute;
            top: 10px;
            right: 10px;
            border-radius: 5px;
            overflow: hidden;
            line-height: 20px;
        }
        #tip input[type="text"] {
            height: 25px;
            border: 0;
            padding-left: 5px;
            width: 280px;
            border-radius: 3px;
            outline: none;
        }
</style>
</head>
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
							<i class="icon-pencil"></i>显示全部局站位置
						</h3>
					</div>
  				   <form action="" method="get"> 
					<div class="widget-container">
				       <div id="container" class="map" tabindex="0" style="position:relative;">
                          <div id="tip" >
                             <input style="position:relative; z-index:9999;text;" id="keyword" name="keyword" value="请输入关键字：(选定后搜索)" onfocus='this.value=""'/>
                             <input style="position:relative; z-index:9999;text;" id="txtLnglat" value="单击地图可以查看经纬度" />
                          </div>
                          <div class="button-group">
                             <input style="position:relative; z-index:9999;text;" id="road" name="road" class="button" value="实时路况" type="button"/>
                             <input style="position:relative; z-index:9999;text;" id="floor" class="button" value="3D楼块图层" type="button"/>
                             <input style="position:relative; z-index:9999;text;" id="satellite" class="button" value="卫星图层" type="button"/>
                          </div>
					   </div>
				    </div>
				    </form>
				  </div>
				</div>
			</div>	
		</div>
	</div>

