<?php

	$shellname = "sh ";
	$ext = ".sh";
	if( PHP_OS == "WINNT" ){
		$shellname = "c:\WINDOWS\system32\cmd.exe /c ";
		$ext = ".bat";
	}
	
	$config['directories'] = array(
		'ScriptRoot' 	=> $_SERVER['DOCUMENT_ROOT']."/Ringi/app/Vendor/scripts/",
		'FolderPath'	=> $_SERVER['DOCUMENT_ROOT']."/Ringi/app/attachments/"
	);
	
	$config['scripts'] = array(
		'CreateBudget' 		=> $shellname. "createBudgetTables". $ext, 
		'CreateFolder' 		=> $shellname. "createFolder". $ext,
		'CreateLdap'		=> $shellname. "createLDAPTree". $ext,
		'CreateRingiTable'	=> $shellname. "createRingiTables". $ext,
		'LoadUser'			=> $shellname. "importADToMySql".$ext,
		'ResetPassword'		=> $shellname. "ResetPassworc".$ext
	);

	$config['workflow'] = array(
		'MaxLayer'			=> 5
	);
?>
