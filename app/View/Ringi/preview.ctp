<?php

$doc = file_get_contents($_SERVER['DOCUMENT_ROOT']."/uploads/upload.php");

//if input:...is found
while (preg_match('/input:.+:.+/', $doc, $matches) == 1) {
	$temp = preg_split('/[:]/',$matches[0]);
	
	 $doc = preg_replace('/input:(.+):.+/', '<textarea class="replacement" style="width: 100%; height: 100%; min-height:3em; box-sizing: border-box; resize: none; border:none;" id='. $temp[1] .' name='. $temp[1] .'></textarea>' , $doc, 1);
	
}

print_r("$doc");

?>

<form action="upload_confirmation" method="post" align="center">
	<button class="btn btn-primary" name="submit" value="confirm">Confirm</button>
</form>