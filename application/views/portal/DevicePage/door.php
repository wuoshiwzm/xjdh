<script type="text/javascript" src="/public/portal/js/rt_data/rt_data-door.js"></script> 
<h5>开门状态:&nbsp;<span class="label label-success door"  id="door-<?php echo $dataObj->data_id;?>">关闭</span></h5>
<?php if($canOpen){ ?>
<p>
<button class='btn btn-info btnOpenDoor' data_id="<?php echo $dataObj->data_id; ?>" >远程开门</button>&nbsp;<button class='btn btn-info btnForceOpenDoor' data_id="<?php echo $dataObj->data_id; ?>">强制开门</button>
</p>
<?php } ?>
<div class="modal fade bs-example-modal-lg" role="dialog"
	id=<?php echo 'thresholdDialog3'.$dataObj->data_id?>
	style="left: 60%; width: 300px; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body modal-lg">
				<h4>请注明开门事由</h4>
				<p>开门须说明所在单位和手机号</p>
				<br>
                   <textarea name="openMessage" id="openMessage"  rows="10" cols="10"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-danger" data_id="<?php echo $dataObj->data_id; ?>" id='btn-ok-checks' >确定</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->