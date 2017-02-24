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
		<style>
.board-widgets-content .n-counter {
	font-size: 20px;
}
</style>
		<div class="row-fluid type-choose">
			<div class="span4">
				<div class="board-widgets brown">
					<div class="board-widgets-content">
						<span class="n-counter">电源设备告警每日统计</span>
					</div>
					<div class="board-widgets-botttom">
						<a class='open-form' href="###" data-type='device' data-time='day'>进入
							<i class="icon-double-angle-right"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="span4">
				<div class="board-widgets orange">
					<div class="board-widgets-content">
						<span class="n-counter">环境量告警每日统计</span>
					</div>
					<div class="board-widgets-botttom">
						<a class='open-form' href="###" data-type='env' data-time='day'>进入
							<i class="icon-double-angle-right"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="span4">
				<div class="board-widgets  blue-violate">
					<div class="board-widgets-content">
						<span class="n-counter">告警级别每日统计</span>
					</div>
					<div class="board-widgets-botttom">
						<a class='open-form' href="###" data-type='level' data-time='day'>进入
							<i class="icon-double-angle-right"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid type-choose">
			<div class="span4">
				<div class="board-widgets  magenta">
					<div class="board-widgets-content">
						<span class="n-counter">电源设备告警月度统计</span>
					</div>
					<div class="board-widgets-botttom">
						<a class='open-form' href="###" data-type='device'
							data-time='month'>进入 <i class="icon-double-angle-right"></i></a>
					</div>
				</div>
			</div>
			<div class="span4">
				<div class="board-widgets  bondi-blue">
					<div class="board-widgets-content">
						<span class="n-counter">环境量告警月度统计</span>
					</div>
					<div class="board-widgets-botttom">
						<a class='open-form' href="###" data-type='env' data-time='month'>进入
							<i class="icon-double-angle-right"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="span4">
				<div class="board-widgets  dark-yellow">
					<div class="board-widgets-content">
						<span class="n-counter">告警总量月度汇总</span>
					</div>
					<div class="board-widgets-botttom">
						<a class='open-form' href="###" data-type='summary'
							data-time='month'>进入 <i class="icon-double-angle-right"></i></a>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid hide" id='area-form'>
			<div class="span12">
				<div class="content-widgets light-gray">
					<div class="widget-head bondi-blue">
						<h3>综合查询</h3>
					</div>
					<div class="widget-container">
						<button class="btn btn-notification" id='btn-close'>
							<i class="icon-reply"></i>
						</button>
						<form class="form-horizontal" target="_blank">
							<input type="hidden" name='type' id='type'> <input type="hidden"
								name='time' id='time'>
							<div class="control-group">
								<label class="control-label" style="float: left;">分公司</label>
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
    							        <?php }else if($userObj->user_role == "city_admin"||$userObj->user_role == "noc"){ ?>
    							        <option value="<?php echo $userObj->city_code; ?>">
    							            <?php echo Defines::$gCity[$userObj->city_code]; ?></option>
    							        <?php }?>
    								</select>
								</div>
								<label class="control-label" style="float: left;">区域</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择区域"
										name='selCounty' id='selCounty'>
										<?php if($userObj->user_role == "city_admin"||$userObj->user_role == "noc"){ ?>
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
								<label class="control-label" style="float: left;">所属局站</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<select class="chzn-select" data-placeholder="选择局站"
										name='selSubstation' id='selSubstation'>
										<option value=''>所有局站</option>
									</select>
								</div>
								<label class="control-label" style="float: left;">选择时间</label>
								<div class="controls" style="margin-left: 20px; float: left;">
									<input type="text" class='datepicker' name='txtDate'
										id='txtDate' value="">
								</div>
							</div>
							<div class="form-actions">
								<button class="btn btn-success" type="submit">查询</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>