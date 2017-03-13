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
