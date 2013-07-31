<?php
	$vendorpath = $_SERVER['DOCUMENT_ROOT']."/Ringi/app/Vendor/scripts/";
	$folderpath = $_SERVER['DOCUMENT_ROOT']."/Ringi/uploads/attachments/";

	$ext = "sh";
	if( PHP_OS == "WINNT" ){
		$ext = "bat";
	}
	$scr_create_budget_tables 	= "createBudgetTables". $ext;
	$scr_create_folder 		= "createFolder". $ext;
	$scr_create_ldap_tree		= "createLDAPTree". $ext;
	$scr_create_ringi_tables 	= "createRingiTables". $ext;
	$scr_import_ad_to_mysql		= "importADToMySql".$ext;

?>
