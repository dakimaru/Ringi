<div style="padding-left: 1em;">
	<h1 class="text-center"><?php echo $project_name; ?></h1><hr>
	<form method="post" action="./confirm_check" name="confirm_check1">
		<?php print_r("$doc"); ?>
		<div class="text-center">
			<hr>
			<br>
			<textarea class="span9" style="resize: none; font-size:20px;" 
			placeholder = "Enter comment here" rows="8" name="xxxxxcomment"></textarea>
		</div>
		<input type="hidden" name="idlist2" value='<?php echo $attachmentid ?>'>
		<div class="text-center">
			<button class="btn btn-success">Confirm</button>
		</div>
	</form>
</div>