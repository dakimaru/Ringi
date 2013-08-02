<div class="text-center" style="padding-left: 1em;">
	<?php echo $doc ?>
	<?php 
	if ($attachmentflag==0){
		echo("
		<form action='download' method='post'>
			<input type='hidden' name='ringino' value="."$ringino"." id='ringino'>
			<p><input type='submit' value='View Attachments'></p>
		</form>
		");
	}
		 ?>

	
	<form method="post" action="" name="commentform">	
		<textarea class="span9" style="resize: none; font-size:20px;" 
		placeholder = "Enter comment here" rows="8" name="comment"></textarea>
		<?php echo ("<input type='hidden' name='ringino' value="."$ringino"." id='ringino'>") ?>
		<br>
		
		<?php 
		if ($status=='002' && $resourceflag=='home') {
			echo ('
			<button class="btn btn-success" onclick="cancel1()">Cancel</button>');
		}
		if ($status=='002' && $resourceflag=='task') {
			echo ('
			<button class="btn btn-success" onclick="approve()">Approve</button>
			<button class="btn btn-success" onclick="accept()">Accept</button>
			<button class="btn btn-success" onclick="reject()">Reject</button>
			<button class="btn btn-success" onclick="hold()">Hold</button>
			<button class="btn btn-success" onclick="passback()">Passback</button>');
		}
		if ($status=='002' && $resourceflag=='other') {
			echo ('
			<button class="btn btn-success" onclick="cancel2()">Cancel</button>');
		}
		if ($status=='006' && $resourceflag=='other') {
			echo ('
			<button class="btn btn-success" onclick="reopen()">reopen</button>');
		}
		?>
	
	</form>
</div>


<script>
function approve()
{
 document.commentform.action ="approve";
}
function accept()
{
document.commentform.action = "accept";
}
function reject()
{
document.commentform.action = "reject";
}
function hold()
{
document.commentform.action = "hold";
}
function passback()
{
document.commentform.action = "passback";
}
function reopen()
{
document.commentform.action = "reopen";
}
function cancel1()
{
document.commentform.action = "cancel1";
}
function cancel2()
{
document.commentform.action = "cancel2";
}
</script>
