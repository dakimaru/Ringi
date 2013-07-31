<?php
	$vendorpath = $_SERVER['DOCUMENT_ROOT']."/Ringi/app/Vendor/scripts/";
	$folderpath = $_SERVER['DOCUMENT_ROOT']."/Ringi/uploads/attachments/";

	$shellname = "sh ";
	$ext = ".sh";
	if( PHP_OS == "WINNT" ){
		$shellname = "c:\WINDOWS\system32\cmd.exe /c ";
		$ext = ".bat";
	}
	$scr_create_budget_tables 	= $shellname. $vendorpath. "createBudgetTables". $ext;
	$scr_create_folder 		= $shellname. $vendorpath. "createFolder". $ext;
	$scr_create_ldap_tree		= $shellname. $vendorpath. "createLDAPTree". $ext;
	$scr_create_ringi_tables 	= $shellname. $vendorpath. "createRingiTables". $ext;
	$scr_import_ad_to_mysql		= $shellname. $vendorpath. "importADToMySql".$ext;

?>
