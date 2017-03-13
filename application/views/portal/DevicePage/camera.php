<div class="tab-pane active" id='tab-sps'>
	<div class="tab-widget tabbable tabs-left chat-widget">
		<div class="tab-widget">	
			<ul id="cam-tab" data_id='<?php echo $dataObj->data_id;?>' class="nav nav-tabs">
				<li><a data_id='<?php echo $dataObj->data_id;?>' class="operate"
					href="##">摄像头操作</a></li>
        		<li><a data_id='<?php echo $dataObj->data_id;?>' class="list"
					href="##">录像查看</a></li>
			</ul>	
		</div>	
		<div class="tab-content op"  data_id='<?php echo $dataObj->data_id;?>' id='op-<?php echo $dataObj->data_id;?>' style="float: left;width:120px;height:600px;">
				<p align="center"><font size=3><b>摄像头操作</b></font></p>
				<br />
				<p align="center">
					<button class='btn btn-info scr' data_id='<?php echo $dataObj->data_id;?>'  id='scr-<?php echo $dataObj->data_id;?>'>截取图片</button>
				</p> 
				<p align="center">
					<button class='btn btn-info real' data_id='<?php echo $dataObj->data_id;?>'> 实时图像</button>
				</p>				
<!-- 				<p align="center"> -->
<!--					<button class='btn btn-info rst' data_id='<?php echo $dataObj->data_id;?>' style="width:74px;"> 重置摄像头</button> -->
<!-- 				</p> -->
		</div>
		<div class="tab-content realtime"  data_id='<?php echo $dataObj->data_id;?>' id='realtime-<?php echo $dataObj->data_id;?>'  style="display: none;height:600px;">
			实时监控视频加载中...
		</div>
		<div class="tab-content pic"  data_id='<?php echo $dataObj->data_id;?>' id='pic-<?php echo $dataObj->data_id;?>'  style="display: none;height:600px;">
		<img class="tab-content" src="/portal/camera_screenshort/{<?php echo $dataObj->data_id;?>}"  data_id='<?php echo $dataObj->data_id;?>' id='<?php echo $dataObj->data_id;?>-img'  style="display: none;height:600px;"/>
		</div>
		<div class="tab-content li"  data_id='<?php echo $dataObj->data_id;?>' id='li-<?php echo $dataObj->data_id;?>' style="display: none;float: left;width:120px;height:600px;">
			<p align="center"><font size=2><b>当前可查看时间段：</b></font></p>
			<p align="center" id='start-<?php echo $dataObj->data_id;?>'></p>
			<p align="center" id='to-<?php echo $dataObj->data_id;?>'></p>
			<p align="center" id='end-<?php echo $dataObj->data_id;?>'></p>
			<br />
			<p align="center"><font size=2><b>选择要查看的时间：</b></font></p>
			<p align="center"><select id='year-<?php echo $dataObj->data_id;?>' style="width:80px;"></select></p>
			<p align="center"><select id='month-<?php echo $dataObj->data_id;?>'  style="width:80px;"></select></p>
			<p align="center"><select id='day-<?php echo $dataObj->data_id;?>'  style="width:80px;"></select></p>
			<p align="center"><select id='hour-<?php echo $dataObj->data_id;?>'  style="width:80px;"></select></p>
			<p align="center"><select id='min-<?php echo $dataObj->data_id;?>'  style="width:80px;"></select></p>
			<p align="center"><button class='btn btn-info look' 
						data_id='<?php echo $dataObj->data_id;?>'  id='look-<?php echo $dataObj->data_id;?>'>查看</button></p>
		</div>
		<div class="tab-content video"  data_id='<?php echo $dataObj->data_id;?>' id='video-<?php echo $dataObj->data_id;?>'  style="display: none;height:600px;">
		</div>
	</div>
</div>
