
<!doctype html>

<html  lang="en">
<script type="text/javascript">
var lng = <?php echo json_encode($lng); ?>;
var lat = <?php echo json_encode($lat); ?>;
var id = <?php echo json_encode($id); ?>;
var layer = <?php echo json_encode($layer); ?>;
</script>
<head>
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
<style type="text/css">
#container {width:800px; height: 400px; MARGIN-RIGHT: auto; MARGIN-LEFT: auto; }  
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
							<i class="icon-pencil"></i> 编辑/添加局站信息
						</h3>
					</div>
					<div class="widget-container">
						<form class="form-horizontal" method='post'>
						 <?php if(isset($errorMsg)){?>
                            <div class="alert alert-error">
								<button data-dismiss="alert" class="close" type="button">×</button>
								<i class="icon-exclamation-sign"></i><?php echo $errorMsg;?>
                    		</div>
                		<?php }else if($successMsg){?>
                		  <div class="alert alert-success">
								<button data-dismiss="alert" class="close" type="button">×</button>
								<i class="icon-ok-sign"></i><?php echo $successMsg;?>
    					   </div>
                		<?php }?>
							<div class="control-group">
								<label class="control-label" style="float: left;">所属部门/分公司</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择分公司"
										name='selCity' id='selCity'>
										<?php if($this->userObj->user_role == "admin"){?>
    							        <option value=''>全网</option>
    							        <?php foreach (Defines::$gCity as $cityKey=>$cityVal){?>
							            <option value='<?php echo $cityKey;?>'
											<?php  if(isset($substation) && $substation->city_code == $cityKey){?> selected="selected"
											<?php }?>><?php echo $cityVal;?>本地网</option>
    							        <?php }?>
    							        <?php }else if($this->userObj->user_role == "city_admin"){ ?>
    							        <option value="<?php echo $this->userObj->city_code; ?>">
    							            <?php echo Defines::$gCity[$this->userObj->city_code]; ?></option>
    							        <?php }?>
    								</select>
								</div>
								<label class="control-label" style="float: left;">区域</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择区域"
										name='selCounty' id='selCounty'>
										<?php if($this->userObj->user_role == "city_admin"){ ?>
											<option value="0">所有区域</option>
											<?php foreach (Defines::$gCounty[$this->userObj->city_code] as $key=> $val){?>
										    <option value='<?php echo $key;?>'
												<?php if(isset($substation) && $substation->county_code == $key){?>selected="selected"<?php }?>>
												<?php echo $val;?></option>
									        <?php } ?>
								        <?php }else{ ?>
										    <option value="0">所有区域</option>
										    <?php if(isset($substation)) foreach (Defines::$gCounty[$substation->city_code] as $key=> $val){?>
									            <option value='<?php echo $key;?>'
											    <?php if(isset($substation) && $substation->county_code == $key){?> selected="selected" <?php }?>>
											    <?php echo $val;?></option>
								            <?php }?>   
								        <?php }?>
									</select>
								</div>																
							</div>
							<div class="control-group">
							<label class="control-label" style="float: left;">局站名</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='txtName' id='txtName'
										value='<?php if(isset($substation)) echo htmlentities($substation->name, ENT_COMPAT, "UTF-8");?>' />
								</div>
								<label class="control-label" style="float: left;">局站类型     <font size=4 color=red>&nbsp;*</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select id="selType" name="selType">
										<option value="A" <?php if(isset($substation) && $substation->type == "A") echo "selected"; ?>>A级局站</option>
										<option value="B" <?php if(isset($substation) && $substation->type == "B") echo "selected"; ?>>B级局站</option>
										<option value="C" <?php if(isset($substation) && $substation->type == "C") echo "selected"; ?>>C级局站</option>
										<option value="D" <?php if(isset($substation) && $substation->type == "D") echo "selected"; ?>>D级局站</option>
										<option value="D1" <?php if(isset($substation) && $substation->type == "D1") echo "selected"; ?>>D级局站-无线基站</option>
									</select>
								</div>											
							</div>
						<div  class="control-group">
						<label class="control-label" style="float: left;">经维度     <font size=4 color=red>&nbsp;&nbsp;</font></label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type='text' name='txtLnglat' id='txtLnglat'
										value='<?php if(isset($substation)) echo htmlentities($substation->lng,ENT_COMPAT,"UTF-8") . ',' . htmlentities($substation->lat,ENT_COMPAT,"UTF-8");?>' />
								</div>							
							<label class="control-label" style="float: left;">局站编码</label>
									<div class="controls" style="margin-left: 20px; float: left;">
										<input type='text' name='Stationcode' id='Stationcode'
											value='<?php if(isset($substation)) echo substr($substation->Stationcode,-5);?>' /> </br><span style="color: red;">---局站编码为局站地址大写首字母缩写，最多为5位字母！</span>
									</div>
							</div>
								<div class="form-actions">
								<button class="btn btn-success" type="submit" name="btn-submit" value="<?php echo htmlentities($substation->id,ENT_COMPAT,"UTF-8")?>" id='btn-submits'>提交</button>
							    </div>
                            </form>	
							    <div id="container" class="map" tabindex="0" style="position:relative;">
                                   <div id="tip" >
                                       <input style="position:relative; z-index:9999;text;" id="keyword" name="keyword" value="请输入关键字：(选定后搜索)" onfocus='this.value=""'/>
                                   </div>
                                   <div class="button-group">
                                       <input style="position:relative; z-index:9999;text;" id="road" name="road" class="button" value="实时路况" type="button"/>
                                       <input style="position:relative; z-index:9999;text;" id="floor" class="button" value="3D楼块图层" type="button"/>
                                       <input style="position:relative; z-index:9999;text;" id="satellite" class="button" value="卫星图层" type="button"/>
                                   </div>
							   </div>
					    </div>
				   </div>
			 </div>
		</div>
	</div>

