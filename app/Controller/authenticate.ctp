<?php 

function authenticate($user, $pass) {
	
	//ldap credentials
	$ldapConfig 	= Configure::read('ldap');
	$ldap_host 		= $ldapConfig['Hostname'];
	$ldapuser  		= $ldapConfig['BindDN']; 
	$ldappass  		= $ldapConfig['BindPassword'];
	
	//MySQL credentials
	$host = 'localhost';
	$username = 'root';
	$password = '';
	$database = 'ringidata';
	
	// Active Directory DN
	$ldap_dn = "ou=Development,dc=enspirea,dc=com";

	// Active Directory user group
	$ldap_user_group = "WebUsers";

	// Active Directory manager group
	$ldap_manager_group = "WebManagers";

	// Domain, for purposes of constructing $user
	$ldap_usr_dom = "";

	// connect to active directory
	$ldap = ldap_connect($ldap_host) or die("Could not connect to LDAP server.");

	// Connect to MySQL
	$link = mysql_connect($host, $username, $password);

	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db($database, $link);	//pointing at the right database

	//change username to DN
	$query = "SELECT DN FROM users WHERE username='".$user."'"; 
	$queryDN = mysql_query($query) or die(mysql_error());	//does the query, and gets a resource
	$querystring = mysql_fetch_assoc($queryDN);		//fetches the associated array
	$userDN = $querystring['DN'];

	
	if($bind = @ldap_bind($ldap, $userDN . $ldap_usr_dom, $pass)) {
		// valid
		// check presence in groups
		$filter = "(sAMAccountName=" . $user . ")";
		$attr = array("memberof");
		$result = ldap_search($ldap, $ldap_dn, $filter, $attr) or exit("Unable to search LDAP server");
		$entries = ldap_get_entries($ldap, $result);
		ldap_unbind($ldap);
		return true;

	} 
	else {
		// invalid name or password
		return false;
	}
}

?>