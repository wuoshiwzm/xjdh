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
    <!--[if IE 7]>
        <link rel="stylesheet" href="/public/css/font-awesome-ie7.min.css">
    <![endif]-->
    <link href="/public/css/styles.css" rel="stylesheet">
    <!--[if IE 7]>
        <link rel="stylesheet" type="text/css" href="/public/css/ie/ie7.css" />
    <![endif]-->
    <!--[if IE 8]>
        <link rel="stylesheet" type="text/css" href="/public/css/ie/ie8.css" />
    <![endif]-->
    <!--[if IE 9]>
    <   link rel="stylesheet" type="text/css" href="/public/css/ie/ie9.css" />
    <![endif]-->
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
			<h3 class="form-signin-heading">新疆电信动环监控平台--登录</h3>
			<div class="controls input-icon">
				<i class=" icon-user-md"></i> <input type="text" placeholder="账户"
					class="input-block-level" id='txtUsername' name='txtUsername'>
			</div>
			<div class="controls input-icon">
				<i class=" icon-key"></i><input type="password" placeholder="密码"
					class="input-block-level" id='txtPasswd' name='txtPasswd'>
			</div>
			<label class="checkbox"> <input type="checkbox" value="true"
				name='cbIsRemember'> 记住我
			</label>
			<button type="submit" class="btn  btn-success btn-block">登录</button>
			<?php if(false){?>
			<h4>忘记密码 ?</h4>
			<p>
				点击<a href="#">这里</a>找回密码.
			</p>
			<?php }?>
			<h4></h4>
			<?php $updateObj = $this->mp_xjdh->Get_LatestUpdateInfo();?>
			<p>
				<a href="<?php echo $updateObj->download_url;?>">点击下载最新APP</a>
			</p>
			<p style="text-align:center;"><img src="/Welcome/qrcode" width="200" height="200" /></p>
		</form>
		
	<div class="copyright">
        <p>&copy; <?php echo date('Y');?> <a href='http://www.chinatelecom.com.cn' target="_blank">中国电信集团公司</a></p>
    </div>
	</div>
</body>
</html>