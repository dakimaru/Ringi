<?php

	$shellname = "sh ";
	$ext = ".sh";
	if( PHP_OS == "WINNT" ){
		$shellname = "c:\WINDOWS\system32\cmd.exe /c ";
		$ext = ".bat";
	}
	$config['ldap'] = array(
		'DefaultDC' 		=> "dc=enspirea,dc=com",
		'Hostname'			=> "192.168.1.3", // "localhost",
		'BindDN'			=> 'cn=Manager,dc=enspirea,dc=com',
		'BindPassword' 		=> '820davis'
	);
	
	$config['directories'] = array(
		'ScriptRoot' 	=> $_SERVER['DOCUMENT_ROOT']."/Ringi/app/Vendor/scripts/",
		'FolderPath'	=> $_SERVER['DOCUMENT_ROOT']."/Ringi/app/attachments/"
	);
	
	$config['scripts'] = array(
		'CreateBudget' 		=> $shellname. "createBudgetTables". $ext, 
		'CreateFolder' 		=> $shellname. "createFolder". $ext,
		'CreateLdap'		=> $shellname. "createLDAPTree". $ext,
		'CreateRingiTable'	=> $shellname. "createRingiTables". $ext,
		'CreateZip'	        => $shellname. "createZip". $ext,
		'LoadUser'			=> $shellname. "importADToMySql".$ext,
		'ResetPassword'		=> $shellname. "ResetPassword".$ext,
		'SynchronizeUser'	=> $shellname. "SynchronizeUser"
	);

	$config['workflow'] = array(
		'MaxLayer'			=> 5
	);
?>
