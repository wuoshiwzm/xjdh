<div class="main-wrapper">
	<div class="row">
		<div class="span4 offset2">
			<div class="error-code">
				<?php echo $error_code;?>
				<div></div>
			</div>
		</div>
		<div class="span4">
			<div class="error-message">
				<h4><?php echo $error_title;?></h4>
				<p><?php echo $error_msg;?></p>
				<ul class="error-suggestion">
				<?php foreach ($errSuggestionList as $value){?>
					<li><?php echo $value?></li>
				<?php }?>
				</ul>
			</div>
		</div>
	</div>
</div>