<!DOCTYPE HTML>
<html  xmlns="http://www.w3.org/1999/xhtml"  xml:lang="zh-CN" lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title><?php echo $this->config->item('site_name');?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="新疆电信动环监控系统">
    <!-- styles -->
    <link href="/public/css/bootstrap.css" rel="stylesheet">
    <link href="/public/css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/font-awesome.css">
    <link href="/public/css/styles.css" rel="stylesheet">
    <link href="/public/css/aristo-ui.css" rel="stylesheet">
    <link href="/public/css/elfinder.css" rel="stylesheet">
    <!--fav and touch icons -->
    <link rel="icon" href="/public/ico/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="/public/ico/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/public/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/public/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/public/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/public/ico/apple-touch-icon-57-precomposed.png">
    <!--============j avascript===========-->
    <script src="/public/js/jquery.js"></script>
    <script src="/public/js/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="/public/js/bootstrap.js"></script>
</head>
	<body>
		<div class="container">
			<form class="form-signin" method='POST'>
			<?php if(isset($msg)){?>
	            <div class="alert">
					<button data-dismiss="alert" class="close" type="button">×</button>
					<i class="icon-exclamation-sign"></i><?php echo $msg;?>
	    		</div>
			<?php }?>
				<h3 class="form-signin-heading">新疆电信动环监控平台--修改密码</h3>
				<div class="controls input-icon">
					<i class=" icon-key"></i> <input type="text" placeholder="旧密码"
						class="input-block-level" id='txtPasswdold' name='txtPasswdold'>
				</div>
				<div class="controls input-icon">
					<i class=" icon-key"></i><input type="password" placeholder="新密码"
						class="input-block-level" id='txtPasswdnew' name='txtPasswdnew'>
				</div>
				<div class="controls input-icon">
					<i class=" icon-key"></i><input type="password" placeholder="确认密码"
						class="input-block-level" id='txtPasswdagain' name='txtPasswdagain'>
				</div>
				<button type="submit" class="btn  btn-success btn-block">确认修改</button>
				<h4></h4>
				<?php $updateObj = $this->mp_xjdh->Get_LatestUpdateInfo();?>
				<p>
					<a href="<?php echo $updateObj->download_url;?>">点击下载最新APP</a>
				</p>
				<p style="text-align:center;"><img src="/Welcome/qrcode" width="200" height="200" /></p>
			</form>
		</div>	
</body>
</html>