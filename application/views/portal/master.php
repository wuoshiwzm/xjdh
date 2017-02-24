<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="zh-CN" lang="zh-CN">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="always" name="referrer">
<title><?php echo $siteName;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="新疆电信动环能耗综合网管">
<!-- styles -->
<link href="/public/css/bootstrap.css" rel="stylesheet">
<link href="/public/css/jquery.gritter.css" rel="stylesheet">
<link href="/public/css/bootstrap-responsive.css" rel="stylesheet">
<link rel="stylesheet" href="/public/css/font-awesome.css">
<link rel="stylesheet" href="/public/css/chosen.css">
<link rel="stylesheet" href="/public/css/styles.css">
<!--[if IE 7]>
    <link rel="stylesheet" href="/public/css/font-awesome-ie7.min.css">
    <![endif]-->
<link href="/public/css/tablecloth.css" rel="stylesheet">
<link href="/public/css/styles.css" rel="stylesheet">
<link href="/public/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet">
<!--[if IE 7]>
    <link rel="stylesheet" type="text/css" href="/public/css/ie/ie7.css" />
    <![endif]-->
<!--[if IE 8]>
    <link rel="stylesheet" type="text/css" href="/public/css/ie/ie8.css" />
    <![endif]-->
<!--[if IE 9]>
    <link rel="stylesheet" type="text/css" href="/public/css/ie/ie9.css" />
    <![endif]-->
<!--fav and touch icons -->
<link rel="icon" href="/public/ico/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/public/ico/favicon.ico"
	type="image/x-icon" />
<link rel="apple-touch-icon-precomposed" sizes="144x144"
	href="/public/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114"
	href="/public/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72"
	href="/public/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed"
	href="/public/ico/apple-touch-icon-57-precomposed.png">
<!--============ javascript ===========-->
<script src="/public/js/jquery-1.11.2.min.js"></script>
<script src="/public/js/bootstrap.js"></script>
<link href="/public/css/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<script src="/public/js/jquery-ui-1.10.1.custom.min.js"></script>
<script src="/public/js/jquery.tablecloth.js"></script>
<script src="/public/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="/public/js/jquery.noty.packaged.js"></script>
<script type="text/javascript">
    var nua = navigator.userAgent;
    var isMobile = /Android|Windows Phone|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent);
    function includeStyleElement(styles,styleId) {
        if (document.getElementById(styleId)) {
            return;
        }
        var style = document.createElement("style");
        style.id = styleId;
        (document.getElementsByTagName("head")[0] || document.body).appendChild(style);
        if (style.styleSheet) { //for ie
            style.styleSheet.cssText = styles;
        } else {//for w3c
            style.appendChild(document.createTextNode(styles));
        }
    }
    if(!isMobile)
    {
    	var styles = ".leftbar{width:50px;} .main-wrapper{margin-left:50px;}";
        includeStyleElement(styles,"newstyle");    
    }    
    </script>
</head>

<body>
	<div class="layout">
		<!-- Navbar================================================== -->
		<div class="navbar navbar-inverse top-nav">
			<div class="navbar-inner">
				<div class="container">
					<span class="home-link"><a class="icon-home" href="/"></a> </span><a
						href="/" class="brand" style="margin-top: 15px">新疆电信动环能耗综合网管</a>
					<div class="btn-toolbar pull-right notification-nav">
                    <?php if(false){?>
                        <div class="btn-group">
							<div class="dropdown">
								<a data-toggle="dropdown"
									class="btn btn-notification dropdown-toggle"> <i
									class="icon-globe"><span class="notify-tip">20</span> </i>
								</a>
								<div class="dropdown-menu pull-right ">
									<span class="notify-h"> 您有20个新通知</span> <a
										class="msg-container clearfix"> <span
										class="notification-thumb"><i class="icon-file"></i></span> <span
										class="notification-intro">XX电力室采集设备掉线 <span
											class="notify-time"> 1小时前 </span></span>
									</a>
									<button class="btn btn-primary btn-large btn-block">查看所有通知</button>
								</div>
							</div>
						</div>
                        <?php }?>
                        <div class="btn-group">
							<div class="dropdown">
							<a href="/portal/change_password" class="brand" style="margin-top: 15px">修改密码</a>
								<a class="btn btn-notification" href='/logout'><i
									class="icon-signout"></i> </a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="leftbar leftbar-close clearfix">
			<div class="left-nav clearfix">
				<div class="left-primary-nav">
					<ul id="myTab">
						<li
							<?php if((isset($actTab) && in_array($actTab,array('rt_data','index'))) || !isset($actTab)){?>
							class="active" <?php }?>><a class="icon-desktop" href="#rt_data"
							data-original-title="实时数据管理"></a></li>
				     	 <?php if(!in_array($userObj->user_role,array('operator','member'))){?>
							<li
							<?php if((isset($actTab) && in_array($actTab,array('fluctuation','pue','performance'))) || !isset($actTab)){?>
							class="active" <?php }?>><a class="icon-th-large" href="#performance"
							title=""></a></li>
						<?php }?>
						<!--             <li <?php if(isset($actTab) && $actTab == 'remote_control'){?>class="active"<?php }?>> -->
						<!--                             <a class="icon-th-large" href="#remote_control" data-original-title="远程控制"></a> -->
						<!--                         </li> -->
                          <?php if(!in_array($userObj->user_role,array('operator'))){?>
						<li <?php if(isset($actTab) && $actTab == 'alarm'){?>
							class="active" <?php }?>><a class="icon-bell-alt" href="#alarm"
							data-original-title="告警管理"></a></li>
                          <?php }?>
							<?php if(User::IsUserHasFirst($userObj->id, "门禁管理") || in_array($userObj->user_role,array('operator','city_admin','admin'))) { ?>
						<li <?php if(isset($actTab) && $actTab == 'door'){?>
							class="active" <?php }?>><a class="icon-lock" href="#door"
							data-original-title="门禁管理"></a></li>
							<?php } ?>
						  <?php if(!in_array($userObj->user_role,array('operator','member'))){?>
						<li <?php if(isset($actTab) && $actTab == 'charts'){?>
							class="active" <?php }?>><a class="icon-bar-chart" href="#charts"
							data-original-title="统计报表"></a></li>
							<?php }?>
						<!--                         <li> -->
						<!--                             <a class="icon-dashboard" href="#motor" data-original-title="油机管理"></a> -->
						<!--                         </li> -->
						
                        <?php if(in_array($userObj->user_role,array('admin','city_admin'))){?>
                        <li
							<?php if(isset($actTab) && $actTab == 'settings'){?>
							class="active" <?php }?>><a class="icon-cogs" href="#settings"
							data-original-title="系统配置"></a></li>
							<?php if(User::IsUserHasFirst($userObj->id, "人员管理") || in_array($userObj->user_role,array('admin','city_admin'))) { ?>
						<li <?php if(isset($actTab) && $actTab == 'users'){?>
							class="active" <?php }?>><a class="icon-user" href="#users"
							data-original-title="人员管理"></a></li>
							<?php }?>
						<?php }?>
						
						<?php if(in_array($userObj->user_role,array('operator'))){?>
						<li <?php if(isset($actTab) && $actTab == 'users'){?>
							class="active" <?php }?>><a class="icon-user" href="#users"
							data-original-title="人员管理"></a></li>
							<?php }?>
                    </ul>
				</div>
				<div class="responsive-leftbar">
					<i class="icon-list"></i>
				</div>
				<div class="left-secondary-nav tab-content">
					<div id="rt_data" class="tab-pane">
						<h4 class="side-head">实时数据管理</h4>
						<div class="search-box">
							<div class="input-append input-icon">
								<input type="text" placeholder="快速查找" class="search-input"
									id="stationKeyword" value=''> <i
									class=" icon-search"></i>
								<button type="button" class="btn" id='btn-search'>查找</button>
							</div>
						</div>
						<ul class="accordion-nav">
						    <?php if(in_array($userObj->user_role, array("admin","noc"))){ ?>
						    <?php foreach(Defines::$gCity as $city_code=>$city_name){ ?>
							 <li><a href="/portal/substation_list/<?php echo $city_code; ?>"><i class="icon-share"></i><?php echo $city_name; ?></a></li>
							<?php }
							}else if(!empty($userObj->city_code)){ ?>
							 <li><a href="/portal/substation_list/<?php echo $userObj->city_code; ?>"><i class="icon-share"></i><?php echo Defines::$gCity[$userObj->city_code]; ?></a></li>
							<?php } ?>	
						</ul>
					</div>
					<div id="performance" class="tab-pane">
						<h4 class="side-head">能耗分析模型</h4>
						<ul class="metro-sidenav clearfix">
						    <li><a class="bondi-blue" href="/portal/powermeter_history"><i class="icon-key"></i><span>电表历史数据查询</span></a></li>
						    <li><a class="bondi-blue" href="/portal/powermeter_ec_history"><i class="icon-key"></i><span>能耗历史数据查询</span></a></li>
						    <li><a class="bondi-blue" href="/portal/powermeter_ec_struct"><i class="icon-key"></i><span>能耗结构图查询</span></a></li>
						    <li><a class="bondi-blue" href="/portal/powermeter_ec_year_basis"><i class="icon-key"></i><span>能耗同比（趋势）查询</span></a></li>
						    <li><a class="bondi-blue" href="/portal/powermeter_ec_link_relative_ratio"><i class="icon-key"></i><span>能耗同、环比查询</span></a></li>
						    <li><a class="bondi-blue" href="/portal/powermeter_ec_compare"><i class="icon-key"></i><span>能耗对比分析查询</span></a></li>
							<li><a
								class="bondi-blue" href="/portal/fluctuation"><i class="icon-key"></i><span>负载波动率</span>
							</a></li>
							<!-- <li><a
								class=" blue-violate" href="/portal/alarm?level=1"><i
									class="icon-key"></i><span>带载率指标</span> </a></li>
							<li>
								<a class="brown" href="####"><i class="icon-key"></i><span>空调冗余度</span></a>
								</li> -->
								<li>
								<a class="dark-yellow" href="/portal/pue"><i class="icon-key"></i><span>PUE能效指标</span></a>
								</li>
						</ul>
					</div>
					<div id="alarm" class="tab-pane">
						<h4 class="side-head">告警管理</h4>
						<ul class="metro-sidenav clearfix">

							<li><span class="notify-tip" id='notify-alert-all'>0</span> <a
								class="bondi-blue" href="/portal/alarm"><i class="icon-bell-alt"></i><span>所有告警</span>
							</a></li>
							<li><span class="notify-tip" id='notify-alert-level1'>0</span> <a
								class="brown" href="/portal/alarm?level=1"><i
									class="icon-bell-alt"></i><span>一级告警</span> </a></li>
							<li><span class="notify-tip" id='notify-alert-level2'>0</span> <a
								class="orange" href="/portal/alarm?level=2"><i
									class="icon-bell-alt"></i><span>二级告警</span> </a></li>
							<li><span class="notify-tip" id='notify-alert-level3'>0</span> <a
								class="dark-yellow" href="/portal/alarm?level=3"><i
									class="icon-bell-alt"></i><span>三级告警</span> </a></li>
							<li><span class="notify-tip" id='notify-alert-level4'>0</span> <a
								class="blue" href="/portal/alarm?level=4"><i
									class="icon-bell-alt"></i><span>四级告警</span> </a></li>

                             <?php if(User::IsUserHasPermission($userObj->id, "手动下发告警") || in_array($userObj->user_role, array('admin'))){ ?>
                            <li><a class=" blue-violate"
								href="/portal/sendalarm"><i class="icon-cogs"></i><span>手动下发告警</span></a>
							</li>
							 <?php }?>
							<?php if(User::IsUserHasPermission($userObj->id, "修复告警状态") || in_array($userObj->user_role, array('admin'))){ ?>
							<li><a class=" blue-violate"
								href="/portal/fix_alert"><i class="icon-cogs"></i><span>修复告警状态</span></a>
							</li>
                            <?php }?>
                            <?php if(User::IsUserHasPermission($userObj->id, "预告警") || in_array($userObj->user_role, array('admin'))){ ?>
                            <li> <a
								class="bondi-blue" href="/portal/takealarm"><i class="icon-bell-alt"></i><span>预告警</span>
							</a></li>
							 <?php }?>
                        </ul>
					</div>
					<?php if(User::IsUserHasFirst($userObj->id, "门禁管理")||in_array($userObj->user_role,array('operator','city_admin','admin'))) { ?>
					<div id="door" class="tab-pane">
						<h4 class="side-head">门禁管理</h4>
						<ul class="metro-sidenav clearfix">
						  <?php if(User::IsUserHasPermission($userObj->id, "门禁权限管理")||in_array($userObj->user_role,array('operator','city_admin','admin'))) { ?>
							<li> <a
								class="bondi-blue" href="/portal/door_manage"><i class="icon-lock"></i><span>门禁权限管理</span>
							</a></li>
							<?php } ?>
							<?php if(User::IsUserHasPermission($userObj->id, "用户门禁管理")||in_array($userObj->user_role,array('operator','city_admin','admin'))) { ?>
							<li> <a
								class="brown" href="/portal/door_user_manage"><i
									class="icon-lock"></i><span>用户门禁管理</span> </a></li>
									<?php } ?>
									
							<?php if(User::IsUserHasPermission($userObj->id, "视频监控中心")||in_array($userObj->user_role,array('operator','city_admin','admin'))) { ?>
<!-- 							<li> <a -->
<!-- 								class="orange" href="/portal/camera_monitor"><i class="icon-lock"></i><span>视频监控中心</span> -->
<!-- 							</a></li> -->
							<?php } ?>
							<?php if(User::IsUserHasPermission($userObj->id, "视频移动侦测记录")||in_array($userObj->user_role,array('operator','city_admin','admin'))) { ?>
<!-- 							<li> <a -->
<!-- 								class="dark-yellow" href="/portal/camear_motion"><i -->
<!-- 									class="icon-lock"></i><span>视频移动侦测记录</span> </a></li> -->
									<?php } ?>
                        </ul>
					</div>
					<?php } ?>
					<div id="charts" class="tab-pane">
						<h4 class="side-head">统计报表</h4>
						<ul class="metro-sidenav clearfix">
							<li><a class="orange" href="/portal/charts"><i
									class="icon-search"></i><span>报表查询</span> </a></li>
						<!--	<li><a class="magenta" href="/portal/charts"><i
									class="icon-bar-chart"></i><span>报表自定义</span> </a></li> -->
							<li><a class="dark-yellow"
								href="<?php echo site_url("portal/export"); ?>"><i
									class="icon-file-alt"></i><span> 报表导出</span> </a></li>
<!--  							<li><a class="green" href="/portal/charts"><i -->
<!-- 									class="icon-shopping-cart"></i><span>辅助功能</span> </a></li>   -->
						   <li><a class="orange"
								href="<?php echo site_url("portal/device_history"); ?>"><i
									class="icon-file-alt"></i><span> 设备历史数据查询</span> </a></li>
						   <li><a class="orange"
								href="<?php echo site_url("portal/door_report"); ?>"><i
									class="icon-file-alt"></i><span> 门禁报表</span> </a></li>
						</ul>
					</div>
					<div id="motor" class="tab-pane">
						<h4 class="side-head">油机管理</h4>
						<ul class="metro-sidenav clearfix">
							<li><a class="orange"
								href="<?php echo site_url("portal/basicdata/gCity"); ?>"><i
									class="icon-cogs"></i><span>信息管理</span> </a></li>
							<li><a class="blue-violate"
								href="<?php echo site_url("portal/basicdata/gCounty"); ?>"><i
									class="icon-lightbulb"></i><span>巡检管理</span> </a></li>
							<li><a class="magenta"
								href="<?php echo site_url("portal/basicdata/gStation"); ?>"><i
									class="icon-bar-chart"></i><span>维护管理</span> </a></li>
							<li><a class="green"
								href="<?php echo site_url("portal/device_manage"); ?>"><i
									class="icon-shopping-cart"></i><span>维护计划</span> </a></li>
							<li><a class="dark-yellow"
								href="<?php echo site_url("portal/smd_device_manage"); ?>"><i
									class="icon-file-alt"></i><span>故障管理</span> </a></li>
						</ul>
					</div>
                <?php if($userObj->user_role=='admin'||$userObj->user_role=='city_admin'||$userObj->user_role=='operator'){?>
                    <div id="settings" class="tab-pane">
						<h4 class="side-head">系统配置</h4>
						<ul class="metro-sidenav clearfix">
						<?php if($userObj->user_role=='admin'){?>
							<li><a class="orange"
								href="<?php echo site_url("portal/basicdata/gCity"); ?>"><i
									class="icon-cogs"></i><span>分公司配置</span> </a></li>
							<?php }?>		
							<li><a class="blue-violate"
								href="<?php echo site_url("portal/basicdata/gCounty"); ?>"><i
									class="icon-lightbulb"></i><span>区域配置</span> </a></li>
							<li><a class="blue-violate"
								href="<?php echo site_url("portal/substation"); ?>"><i
									class="icon-lightbulb"></i><span>局站配置</span> </a></li>
							<li><a class="brown"
								href="<?php echo site_url("portal/manageRoom"); ?>"><i
									class="icon-building"></i><span>机房管理</span> </a></li>
							<li><a class="dark-yellow"
								href="<?php echo site_url("portal/smd_device_manage"); ?>"><i
									class="icon-file-alt"></i><span>采集单元配置</span> </a></li>
							<li><a class="green"
								href="<?php echo site_url("portal/device_manage"); ?>"><i
									class="icon-shopping-cart"></i><span>设备配置</span> </a></li>
							
							<?php if($userObj->user_role=='admin'){?>
							<li><a class="orange"
                                href="<?php echo site_url("portal/basicdata/gBrand"); ?>"><i
                                    class="icon-cogs"></i><span>厂家品牌配置</span> </a></li>
                            <?php }?>		
							
							<li><a class="blue"
								href="<?php echo site_url("portal/device_threshold"); ?>"><i
									class="icon-copy"></i><span>告警条件配置</span> </a></li>
<!-- 						<li><a class="green" href="<?php echo site_url("portal/virtual_device_manage"); ?>"><i -->
<!-- 							class="icon-shopping-cart"></i><span>虚拟设备检查</span> </a></li> -->
							<li><a class="green"
								href="<?php echo site_url("portal/editPrTempAlarm"); ?>"><i
									class="icon-shopping-cart"></i><span>温度告警设置</span> </a></li>
<!-- 							<li><a class="green" href="<?php echo site_url("portal/xunishebei"); ?>"><i  -->
<!-- 									class="icon-shopping-cart"></i><span>虚拟设备名称处理</span> </a></li> -->
							<?php if($userObj->user_role=='admin'){?>		
							<li><a class="blue-violate"
								href="<?php echo site_url("portal/basicdata/gUserAuth"); ?>"><i
									class="icon-lightbulb"></i><span>权限名称配置</span> </a></li>
							<?php }?>			
							<?php if($userObj->user_role=='admin'){?>	
							<li><a class="blue-violate"
								href="<?php echo site_url("portal/basicdata/signalName"); ?>"><i
									class="icon-lightbulb"></i><span>信号名称配置</span> </a></li>
							<?php }?>
							<li><a class="brown" href="/portal/data_monitor"><i
									class="icon-time"></i><span>实时状态监测</span> </a></li>
						    <li><a class="green" 
							    href="<?php echo site_url("portal/station_image_manage/"); ?>"><i
									class="icon-shopping-cart"></i><span>局站采集</span> </a></li> 
							<li><a class="dark-yellow"
								href="<?php echo site_url("portal/smd_device_status"); ?>"><i
									class="icon-file-alt"></i><span>查看采集单元状态</span> </a></li>
							<?php if($userObj->user_role=='admin'){?>	
						    <li><a class="brown" href="<?php echo site_url("portal/GetRoomDevice/"); ?>"><i
									class="icon-time"></i><span>数据库一致性检查</span> </a></li>							
						    <li><a class="brown" href="<?php echo site_url("portal/GetDataID/"); ?>"><i
									class="icon-time"></i><span>数据ID检查</span> </a></li>
							<?php }?>
							
							<li><a class="bondi-blue" href="/portal/power_network_assessment"><i 
							       class="icon-key"></i><span>电源网络安全评估</span></a></li>
							<li><a class="bondi-blue" href="/portal/substation_network_assessment"><i 
							       class="icon-key"></i><span>局站电源安全评估</span></a></li>
							       
							<li><a class="bondi-blue" href="/portal/performance_manage"><i 
							       class="icon-key"></i><span>性能管理</span></a></li>
							<li><a class="bondi-blue" href="/portal/substation_performance_manage"><i 
							       class="icon-key"></i><span>局站性能管理</span></a></li>
								
						<!--	<li><a class="magenta"
								href="<?php echo site_url("portal/basicdata/gStation"); ?>"><i
									class="icon-bar-chart"></i><span>局站配置</span> </a></li>   -->	
						  
<!-- 							<li><a class="brown" href="#"><i class="icon-dashboard"></i><span>油机管理</span> -->
<!-- 							</a></li>	  -->
							
<!-- 							<li><a class="bondi-blue" href="/portal/device_pi_setting"><i -->
<!-- 									class="icon-bookmark-empty"></i><span>性能指标设置</span></a></li> -->
						    <?php if($userObj->user_role=='admin'){?>
							<li><a class="blue-violate"
								href="<?php echo site_url("portal/spdev_manages"); ?>"><i
									class="icon-lightbulb"></i><span>协议管理</span> </a></li>
							<?php }?>	
						</ul>
					</div>
					<?php if(User::IsUserHasFirst($userObj->id, "人员管理") || in_array($userObj->user_role,array('admin','city_admin','operator'))) { ?>
					<div id="users" class="tab-pane">
						<h4 class="side-head">人员管理</h4>
						<ul class="metro-sidenav clearfix">
						
							<li><a class="orange"
								href="<?php echo site_url("portal/usermanage"); ?>"><i
									class="icon-user"></i><span>用户管理</span> </a></li>
							<li><a class="blue-violate"
								href="<?php echo site_url("portal/authority"); ?>"><i
									class="icon-lock"></i><span>监控权限管理</span> </a></li>
							<?php if(User::IsUserHasPermission($userObj->id, "模块权限管理")||in_array($userObj->user_role,array('admin','city_admin'))) { ?>
							<li><a class="blue-violate"
								href="<?php echo site_url("portal/part_user_auth"); ?>"><i
									class="icon-lock"></i><span>模块权限管理</span> </a></li>
							<?php }?>
							<li><a class="green"
								href="<?php echo site_url("portal/onlineuser"); ?>"><i
									class=" icon-group"></i><span>在线用户</span> </a></li>
							<?php if(in_array($userObj->user_role,array('admin','city_admin','operator'))){ ?>
						    <li><a class="green"
								href="<?php echo site_url("portal/loginloguser"); ?>"><i
									class="icon-file-alt"></i><span>登录日志</span> </a></li>
					        <?php }?>
							<?php if($userObj->user_role == 'admin'){?>		
							<li><a class="brown"
								href="<?php echo site_url("portal/feedback"); ?>"><i
									class="icon-heart-empty"></i><span>意见反馈</span> </a></li>
							<?php }?>		
						</ul>
					</div>
					<?php }?>
					<?php }?>
					<?php if(User::IsUserHasFirst($userObj->id, "人员管理")) { ?>
					<div id="users" class="tab-pane">
						<h4 class="side-head">人员管理</h4>
						<ul class="metro-sidenav clearfix">
						 <?php if(User::IsUserHasPermission($userObj->id, "用户管理")||in_array($userObj->user_role,array('admin','city_admin','operator'))   ) { ?>
							<li><a class="orange"
								href="<?php echo site_url("portal/usermanage"); ?>"><i
									class="icon-user"></i><span>用户管理</span> </a></li>
						<?php }?>
						<?php if(User::IsUserHasPermission($userObj->id, "监控权限管理")||in_array($userObj->user_role,array('admin'))) { ?>
							<li><a class="blue-violate"
								href="<?php echo site_url("portal/authority"); ?>"><i
									class="icon-lock"></i><span>监控权限管理</span> </a></li>
						<?php }?>
						<?php if(User::IsUserHasPermission($userObj->id, "模块权限管理")||in_array($userObj->user_role,array('admin'))) { ?>
							<li><a class="blue-violate"
								href="<?php echo site_url("portal/part_user_auth"); ?>"><i
									class="icon-lock"></i><span>模块权限管理</span> </a></li>
						<?php }?>
					    <?php if(User::IsUserHasPermission($userObj->id, "在线用户")||in_array($userObj->user_role,array('admin','city_admin'))) { ?>
							<li><a class="green"
								href="<?php echo site_url("portal/onlineuser"); ?>"><i
									class=" icon-group"></i><span>在线用户</span> </a></li>
						<?php }?>
						<?php if(User::IsUserHasPermission($userObj->id, "登录日志")||in_array($userObj->user_role,array('admin','city_admin'))) { ?>
						    <li><a class="green"
								href="<?php echo site_url("portal/loginloguser"); ?>"><i
									class="icon-file-alt"></i><span>登录日志</span> </a></li>
					    <?php }?>
					    <?php if(User::IsUserHasPermission($userObj->id, "意见反馈")||in_array($userObj->user_role,array('admin'))) { ?>
							<li><a class="brown"
								href="<?php echo site_url("portal/feedback"); ?>"><i
									class="icon-heart-empty"></i><span>意见反馈</span> </a></li>
									<?php }?>
						</ul>
					 </div>
				   <?php }?>					
                </div>
			</div>
		</div>
        <?php echo $mainPlaceHolder; ?>
        <div class="copyright">
			<p>&copy; <?php echo date('Y');?> <a href='http://www.chinatelecom.com.cn'
					target="_blank">中国电信集团公司</a>
			</p>
		</div>
		<div class="scroll-top" style="display: none;">
			<a title="回到顶部" class="tip-top" href="#"><i
				class="icon-double-angle-up"></i> </a>
		</div>
	</div>
	<script src="/public/js/chosen.jquery.js"></script>
	<script type="text/javascript"
		src="/public/js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript"
		src="/public/js/bootstrap-datetimepicker.zh-CN.js"></script>
	<script src="/public/js/custom.js"></script>
	<script src="/public/js/respond.min.js"></script>
	<script src="/public/js/ios-orientationchange-fix.js"></script>
    <?php echo $headerPlaceHolder;?>
    
</body>

</html>
