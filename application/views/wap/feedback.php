<style>
<!--
.feedback-area{
    padding: 30px;
    -moz-border-radius: 15px;      /* Gecko browsers */
    -webkit-border-radius: 15px;   /* Webkit browsers */
    border-radius:15px; 
    background-color: #f0f0f0;
}
.feedback-content{
    border-bottom: 1px solid #ffffff;
}
-->
</style>
<div class='row-fluid'>
	<div class='span12 feedback-area'>
		<div class='feedback-content'>
		  <p><?php echo $feedbackObj->content;?></p>
		  <p>反馈时间： <?php echo $feedbackObj->added_datetime;?></p>
		</div>
		<div>
		  <p><?php echo $feedbackObj->reply;?></p>
		  <p>回复时间： <?php echo $feedbackObj->reply_datetime;?></p>
		</div>
	</div>
</div>