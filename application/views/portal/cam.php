<div class="tab-pane active" id='tab-sps'>
	<div class="tab-widget tabbable tabs-left chat-widget">
		<div class="tab-widget">	
			<ul id="cam-tab" data_id='<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>' class="nav nav-tabs">
				<li><a data_id='<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>' class="operate"
					href="##">摄像头操作</a></li>
        		<li><a data_id='<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>' class="list"
					href="##">录像查看</a></li>
			</ul>	
		</div>	
		<div class="tab-content op"  data_id='<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>' id='op-<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>' style="float: left;width:120px;height:600px;">
				<p align="center"><font size=3><b>摄像头操作</b></font></p>
				<br />
				<p align="center">
					<button class='btn btn-info scr' data_id='<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>'  id='scr-<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>'>截取图片</button>
				</p> 
				<p align="center">
					<button class='btn btn-info real' data_id='<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>' id='real-<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>'> 实时图像</button>
				</p>
		</div>
		<div class="tab-content realtime"  data_id='<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>' id='realtime-<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>'  style="display: none;height:600px;">
		</div>
		<div class="tab-content pic"  data_id='<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>' id='pic-<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>'  style="display: none;height:600px;">
		</div>
		<div class="tab-content li"  data_id='<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>' id='li-<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>' style="display: none;float: left;width:120px;height:600px;">
			<p align="center"><font size=2><b>当前可查看时间段：</b></font></p>
			<p align="center" id='start-<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>'></p>
			<p align="center" id='to-<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>'></p>
			<p align="center" id='end-<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>'></p>
			<br />
			<p align="center"><font size=2><b>选择要查看的时间：</b></font></p>
			<p align="center"><select id='year-<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>' style="width:80px;"></select></p>
			<p align="center"><select id='month-<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>'  style="width:80px;"></select></p>
			<p align="center"><select id='day-<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>'  style="width:80px;"></select></p>
			<p align="center"><select id='hour-<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>'  style="width:80px;"></select></p>
			<p align="center"><select id='min-<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>'  style="width:80px;"></select></p>
			<p align="center"><button class='btn btn-info look' 
						data_id='<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>'  id='look-<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>'>查看</button></p>
		</div>
		<div class="tab-content video"  data_id='<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>' id='video-<?php echo htmlentities($CameraObj->data_id,ENT_COMPAT,"UTF-8");?>'  style="display: none;height:600px;">
		</div>
	</div>
</div>
