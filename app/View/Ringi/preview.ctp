<?php

$path = $_SERVER['DOCUMENT_ROOT']."/Ringi/uploads/";

if (isset($diff1)&&isset($diff2)) {
	if ($diff1) {
		foreach ($diff1 as $value) {
			echo '<div class="alert alert-block">Column ' . $value . ' was deactivated <br></div>';
		}

	}
	if ($diff2) {
		foreach ($diff2 as $value) {
			echo '<div class="alert alert-error">Column ' . $value . ' was added <br></div>';
		}
	}
}

$doc = file_get_contents($path."upload.php");

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