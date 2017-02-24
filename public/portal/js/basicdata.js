$(document).ready(function(){
	$('#btn-add').click(function(){
		var tTr = $("<tr >\
	        <td><input type=\"text\" name=\"txtKey[]\" class=\"input-large\"\
				></td>\
	        <td>\
	        	<input type=\"text\" name=\"txtValue[]\" class=\"input-xlarge\" >\
			</td>\
	        <td><a href=\"#\" title='' class=\"delete\">删除</a></td>\
			</tr>");
		$('#tbodycategory').append(tTr);
		tTr.find('.delete').click(function(){
			$('#modalMsg').html('是否删除该记录？');
			$('#deleteDialog').modal({
				 keyboard: true,
				 show	: true
			});		
			trObj =  $(this).parents('tr');
			category_id = $(this).parents('tr').attr('category_id');
		});
		tTr.find('[name="txtValue[]"]').tagsInput({width:'auto',defaultText:'添加'});
	});
	
	var trObj = null;
	$('.delete').click(function(){
		$('#modalMsg').html('是否删除该记录？');
		$('#deleteDialog').modal({
			 keyboard: true,
			 show	: true
		});		
		trObj =  $(this).parents('tr');
		category_id = $(this).parents('tr').attr('category_id');
	});
	
	$('#btn-ok-del').click(function(){
		$('#deleteDialog').modal('hide');
		//前台删除
		trObj.remove();
	});
	$('[name="txtValue[]"]').tagsInput({width:'auto',defaultText:'添加'});
});