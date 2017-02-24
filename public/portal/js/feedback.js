$(document).ready(function() {
	var feedback_id = null;
	var contentObj = null;
	tinymce.init({
	    selector: '#txtReply',
		language : 'zh_CN',
	    plugins: [
	        "advlist autolink lists link image charmap print preview anchor",
	        "searchreplace visualblocks code fullscreen",
	        "insertdatetime media table contextmenu paste"
	    ],
	    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
	});
	$('.btn-reply').click(function() {
		$('#replyDlg').modal('show');
		feedback_id = $(this).parent().attr('feedback_id');
		contentObj = $(this).parent().siblings().eq(4);
		var replyHtml = contentObj.html();
		tinymce.activeEditor.setContent(replyHtml);
	});
	$('#btnSubmit').click(function(){
		var reply = tinymce.activeEditor.getContent({format : 'raw'});
		$.post('/portal/reply',{feedback_id:feedback_id,reply:reply},function(ret){
			if(ret){
				contentObj.html(reply);
				var n = noty({
					text: '<span>回复成功。</span>',
					type: 'success',
					layout: 'topCenter',
					closeWith: ['hover','click','button']
				});
				$('#replyDlg').modal('hide');
			}else{
				var n = noty({
					text: '<span>回复失败，请重试。</span>',
					type: 'error',
					layout: 'topCenter',
					closeWith: ['hover','click','button']
				});
			}
		});
	});
	
	$('.btn-delete-reply').click(function(){
		contentObj = $(this).parent().siblings().eq(4);
		feedback_id = $(this).parent().attr('feedback_id');
		bootbox.dialog({
			message: "<h4 class='text-info'>是否删除回复？</h4>",
			buttons:{
				OK:{
					label : "确定",
					className : "btn-info",
					callback : function() {
						$.post('/portal/delete_reply',{feedback_id:feedback_id},function(ret){
							if(ret){
								var n = noty({
									text: '<span>删除成功。</span>',
									type: 'success',
									layout: 'topCenter',
									closeWith: ['hover','click','button']
								});
								setTimeout('window.location.reload()',1000);
							}else{
								var n = noty({
									text: '<span>删除失败，请重试。</span>',
									type: 'error',
									layout: 'topCenter',
									closeWith: ['hover','click','button']
								});
							}
						});
					}
				},
				Cancel:{
					label : "取消",
					className : "btn",
					callback : function() {}
				}
			},
			onEscape: true
		});
	});
	
	$('.btn-delete').click(function(){
		feedback_id = $(this).parent().attr('feedback_id');
		bootbox.dialog({
			message: "<h4 class='text-info'>是否删除该反馈？</h4>",
			buttons:{
				OK:{
					label : "确定",
					className : "btn-info",
					callback : function() {
						$.post('/portal/delete_feedback',{feedback_id:feedback_id},function(ret){
							if(ret){
								var n = noty({
									text: '<span>删除成功。</span>',
									type: 'success',
									layout: 'topCenter',
									closeWith: ['hover','click','button']
								});
								setTimeout('window.location.reload()',1000);
							}else{
								var n = noty({
									text: '<span>删除失败，请重试。</span>',
									type: 'error',
									layout: 'topCenter',
									closeWith: ['hover','click','button']
								});
							}
						});
					}
				},
				Cancel:{
					label : "取消",
					className : "btn",
					callback : function() {}
				}
			},
			onEscape: true
		});
	});
});