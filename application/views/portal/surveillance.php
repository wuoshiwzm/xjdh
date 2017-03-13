<html>
<head>
<title>集中视频监控</title>
<style type="text/css">
</style>
<script src="/public/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
var devList = <?php echo json_encode($devList); ?>;
var number = <?php echo $number; ?>;
var second = <?php echo $second; ?>;
</script>
<script src="/public/portal/js/surveillance.js"></script>
</head>
<body>
<div>
<div style="float:left;width:20vh;height:100%;line-height:3vh;font-size: 2vh;">
<form method="get">
<div>
<label>视频个数:</label>
<select name="number" style="line-height:3vh;font-size: 2vh;">
<option value="6" <?php if($number == 6){?>selected<?php } ?>>6</option>
<option value="9"<?php if($number == 9){?>selected<?php } ?>>9</option>
<option value="12"<?php if($number == 12){?>selected<?php } ?>>12</option>
<option value="15"<?php if($number == 15){?>selected<?php } ?>>15</option>
</select>
</div>
<div>
<label>轮转秒数:</label>
<select name="second" style="line-height:3vh;font-size: 2vh;">
<option value="30" <?php if($second == 30){?>selected<?php } ?>>30</option>
<option value="60" <?php if($second == 60){?>selected<?php } ?>>60</option>
<option value="90" <?php if($second == 90){?>selected<?php } ?>>90</option>
<option value="120" <?php if($second == 120){?>selected<?php } ?>>120</option>
<option value="150" <?php if($second == 150){?>selected<?php } ?>>150</option>
</select>
</div>
<input type="submit" value="启用设置"  style="line-height:3vh;font-size: 2vh;"/>
</form>
<table>
<tr>
    <td><input type="button" value="上一组" id="btnPrev"  style="line-height:3vh;font-size: 2vh;"/></td>
    <td><input type="button" value="下一组" id="btnNext"  style="line-height:3vh;font-size: 2vh;"/></td>
</tr>
</table>
<div>共<?php echo count($devList); ?>摄像头</div>
<div>当前显示第<span id="showRange"></span></div>
<div>下一组视频列表</div>
<div id="videoList">
</div>
</div>
<div style="margin-left:width:15vh;width:100%;border:solid black 2px;display:block;">
<?php for($i=0; $i < $number; $i++){ ?>
<div style="float:left;border:solid black 1px;">
    <div class="video" style="width:720px;height:600px;">
    </div>
    <div class="title" style="text-align:center;font-size:20px;"></div>
</div>
<?php } ?>
</div>
</div>
</body>
</html>