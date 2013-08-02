<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class UsersController extends AppController {

	public function openSQLconnection() {
		$host = 'localhost';
		$username = 'root';
		$password = '';
		$database = 'ringidata';
		
		$link=mysql_connect($host, $username, $password);
		$ret = mysql_select_db($database, $link);
		
		return $ret;
	}

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('add', 'login','logout', 'secure_login');

	}

	//not used anymore
	public function secure_login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				// save username entered in the login form
				$username = $this->Auth->user('username');
				//$this->redirect(array('controller' => 'Ringi', 'action' => 'main_menu'));
				return $this->redirect($this->Auth->redirectUrl());
			} else {
				$this->Session->setFlash(__('Invalid username or password, try again'));
			}
		}
	}

	public function login() {
		include("authenticate.ctp");
		if ($this->request->is('post')) {
			$usr = $this->data['User']['username'];
			$pass = $this->data['User']['password'];

			// run information through authenticator
			if(authenticate($usr,$pass))
			{
				// authentication passed
				// Connect to MySQL
				$link = $this->openSQLconnection();

				$salted_pass = $this->Auth->password($pass);			//put salt on password

				$querynewpass = "UPDATE users SET `password`='".$salted_pass."' WHERE username='".$usr."'"; 
				mysql_query($querynewpass) or die(mysql_error());	//overwrite password

				if ($this->Auth->login()) {
					
					//return $this->redirect($this->Auth->redirectUrl());
					return $this->redirect(array('controller' => 'Ringi', 'action' => 'main_menu'));
				}
			}	
			else {
				
				$this->Session->setFlash(__('Invalid username or password, try again. If you forget your username or password, please ask administrator for help!'));
			}
		}
	}

	public function logout() {
		if ($this->Auth->logout()) {
			$this->redirect($this->Auth->logout());
		} else {
			$this->Session->setFlash(__('Expired your session'));
		}
	}

	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	public function view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}
	
	private function get_user_DN($fullname, $department){
		$ldapConf = Configure::read('ldap');
		$userDN = 	'CN='. $fullname. 
					','.
					'ou='. 	$department. 
					','.
					$ldapConf['DefaultDC'];
		return $userDN;
	}
	
	private function get_manager_DN($managerid){
		$sql = "SELECT DN FROM users WHERE username='".$managerid."'";
		$query=mysql_query($sql);
		$manager = mysql_fetch_assoc($query);
		if( $manager == NULL ){
			// this should not happen
			return 'DN_NOT_FOUND_FOR_THIS_MANAGER';
		}
		return $manager['DN'];
	}
	
	public function add() {
		$connection=$this->openSQLconnection();
		$username = $this->Auth->user('username');
		if ($this->request->is('post')) {
			$this->User->create();

			$link = $this->openSQLconnection();
			//$sql = "SELECT username FROM users WHERE username='".$newusername."'";
			//$query=mysql_query($sql);
			//$existing = mysql_fetch_assoc($query);
			//if ($existing==NULL) {
			//	
			$user = $this->data['username'];
			$usertype = isset($this->data['usertype'])?1:0;
			$fullname = $this->data['name'];
			$email = $this->data['email'];
			$department = $this->data['department'];
			$title = $this->data['title'];
			$manager = $this->get_manager_DN($this->data['manager']);
			$activeflag = isset($this->data['activeFlag'])?1:0;
			$userdn = $this->get_user_DN($fullname, $department);			
			
			$sql = "INSERT INTO users (DN, usertype, name, username, mail, department, title, manager, activeflag, creator_id, created_at)
				VALUES ('$userdn','$usertype','$fullname','$user','$email', '$department', '$title', '$manager', '$activeflag', '$username', now());";	

			$query = mysql_query($sql);
			if ($query != NULL)
			{
				// synchronize user table with LDAP, usertable.csv
				$this->exec_in_vendorpath('SynchronizeUser');
				
				$newPassword = $_POST['newPassword'];
				$salted_pass = $this->Auth->password($newPassword);			//put salt on password
				$querynewpass = "UPDATE users SET password='$salted_pass' WHERE username='$user'";
				//mysql_query($querynewpass) or die(mysql_error());	//overwrite password
				
				$ldapConfig = Configure::read('ldap');
				$ldapHost = $ldapConfig['Hostname'];
				$this->exec_in_vendorpath('ResetPassword', $ldapHost, '" '. $userdn. '"', $newPassword);
				
				$this->Session->setFlash(__("The user was created successfully"));
			}
			else{
				$this->Session->setFlash(__("Oops! Create Failed!"));
			}
		}
		
		//Name, title, departement
		$sql="SELECT usertype, name, department, title,  manager, mail, activeflag FROM users WHERE username = '$username'";
		//$sql="SELECT usertype, username, name, department, title, manager, email, activeflag,
		//	FROM users
		//	where username= admin direct username from pulldown";
		$query = mysql_query("$sql");
		$array = mysql_fetch_assoc($query);
		$this->set('usertype', $array['usertype']);
		$this->set('username', $username);
		$this->set('email', $array['mail']);
		$this->set('name', $array['name']);
		$this->set('department', $array['department']);
		$this->set('title', $array['title']);
		$this->set('manager', $array['manager']);
		$this->set('activeflag', $array['activeflag']);
		
		
		$sql="SELECT usertype, username, name, department, title, manager, mail, activeflag From users ORDER BY username";
		$query = mysql_query("$sql");
		if ($query != NULL){
			$userCount = mysql_num_rows($query);
		}
		$this->set('userCount', $userCount);
		if ($userCount > 0){
			for ($i = 0 ; $i < $userCount; $i++){
				$array = mysql_fetch_assoc($query);
				$allUsertype[$i] = $array['usertype'];
				$allUserame[$i] = $array['username'];
				$allName[$i] = $array['name'];
				$allDepartment[$i] = $array['department'];
				$allTitle[$i] = $array['title'];
				$allManager[$i] = $array['manager'];
				$allEmail[$i] = $array['mail'];
				$allActiveFlag[$i] = $array['activeflag'];
			}
			$this->set('allUsertype', $allUsertype);
			$this->set('allUsername', $allUserame);
			$this->set('allName', $allName);
			$this->set('allDepartment', $allDepartment);
			$this->set('allTitle', $allTitle);
			$this->set('allManager', $allManager);
			$this->set('allEmail', $allEmail);
			$this->set('allActiveFlag', $allActiveFlag);
		}
		
	}

	public function edit($id = null) {
		/*
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
			unset($this->request->data['User']['password']);
		}
		*/
	}

	public function delete($id = null) {
		/*if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));*/
		
	}
	
	public function password_change() {
		include("authenticate.ctp");
		$this->openSQLconnection();
		$username = $this->Auth->user('username');
		if ($this->request->is('post')) {
			$resourceflag = $this->data['resourceflag'];
			if($resourceflag == 'user'){
				// run information through authenticator
				if(authenticate($username,$_POST["currentPassword"]))
				{
					$newPassword = $_POST['newPassword'];
					$salted_pass = $this->Auth->password($newPassword);			//put salt on password
					$querynewpass = "UPDATE users SET password='$salted_pass' WHERE username='$username'"; 
					//mysql_query($querynewpass) or die(mysql_error());	//overwrite password
						
					$sql="SELECT DN FROM users WHERE username='$username'";
					$query = mysql_query($sql);
					$userdn = mysql_fetch_assoc($query);
					$ldapConfig = Configure::read('ldap');
					$ldapHost = $ldapConfig['Hostname'];
					$this->exec_in_vendorpath('ResetPassword', $ldapHost, '" '. $userdn. '"', $newPassword);
					
					$this->Session->setFlash(__("Your password was updated successfully"));
					//$this->redirect(array('controller' => 'Users', 'action' => 'password_change'));	
				}	
				else {
					
					$this->Session->setFlash(__('Invalid password, try again. If you forget your password, please ask administrator to reset!'));
				}
			}
			elseif ($resourceflag == 'admin'){
				$user = $_POST['users'];
				$newPassword = $_POST['newPassword'];
				$salted_pass = $this->Auth->password($newPassword);			//put salt on password
				$querynewpass = "UPDATE users SET password='$salted_pass' WHERE username='$user'";
				//mysql_query($querynewpass) or die(mysql_error());	//overwrite password
				
				$sql="SELECT DN FROM users WHERE username='$user'";
				$query = mysql_query($sql);
				$userdn = mysql_fetch_assoc($query);
				$ldapConfig = Configure::read('ldap');
				$ldapHost = $ldapConfig['Hostname'];
				$this->exec_in_vendorpath('ResetPassword', $ldapHost, '" '. $userdn. '"', $newPassword);
				
				$this->Session->setFlash(__("Your password was updated successfully"));
			}
		}
		
		//Name, title, departement
		$sql="SELECT usertype, name, department, title, name FROM users WHERE username = '$username'";
		//$sql="SELECT usertype, username, name, department, title, manager, email, activeflag,
		//	FROM users
		//	where username= admin direct username from pulldown";
		$query = mysql_query("$sql");
		$array = mysql_fetch_assoc($query);
		$this->set('usertype', $array['usertype']);
		$this->set('username', $username);
		$this->set('name', $array['name']);
		$this->set('department', $array['department']);
		$this->set('title', $array['title']);
		
		$sql="SELECT username From users ORDER BY username";
		$query = mysql_query("$sql");
		if ($query != NULL){
			$userCount = mysql_num_rows($query);
		}
		$this->set('userCount', $userCount);
		if ($userCount > 0){
			for ($i = 0 ; $i < $userCount; $i++){
				$array = mysql_fetch_assoc($query);
				$allUserame[$i] = $array['username'];
			}
			$this->set('allUsername', $allUserame);
		}
		
		
		
	}
	
	public function password_reset() {
		$this->openSQLconnection();
		if ($this->request->is('post')) {	
			if ($_POST["newpass"]!=="" && $_POST["selection"]!=="") {
				$user = $_POST["selection"];
				$sql="SELECT DN FROM users WHERE username='".$user."'";
				$query = mysql_query($sql);
				$userDN = mysql_fetch_assoc($query);
				
				$newPassword=$_POST["newpass"];
				$userdn = $userDN['DN'];
				$ldapConfig = Configure::read('ldap');
				$ldapHost = $ldapConfig['Hostname'];
				$this->exec_in_vendorpath('ResetPassword', $ldapHost, '" '. $userdn . '"', $newPassword);				
				$this->Session->setFlash(__("The password of ".$_POST["selection"]." was updated successfully"));
				$this->redirect(array('controller' => 'Ringi', 'action' => 'main_menu'));	
				
			}
			else {
				$this->Session->setFlash(__('Please select an appropriate password!'));
			}
			
		}
	
		$sql = "SELECT username FROM users";
		$query = mysql_query($sql);
		
		$allusers = array();
		$num = mysql_num_rows($query);
		for($j=0; $j<$num; $j++){
			$row = mysql_fetch_assoc($query);
			$allusers[$j] = $row['username'];
			//print_r($row);
		}

		//print_r($allusers);
		
		$this->set('allusers',$allusers);
		
	}
	
	public function user_setting(){
		$connection=$this->openSQLconnection();
		$username = $this->Auth->user('username');
		if ($this->request->is('post')) {
			$resourceflag = $this->data['resourceflag'];
			if ($resourceflag =="user"){
				$name = $this->data['userFullName'];
				$email = $this->data['userEmail'];
				$sql = "UPDATE users Set name = '$name', mail = '$email', updated_at = now(), updator_id  = '$username' WHERE username= '$username'";
				$query = mysql_query($sql);
				//$userDN = mysql_fetch_assoc($query);
				//exec('cd ../Vendor/scripts ; sh resetPassword.sh "' .$userDN['DN'].'" '.$newpassword);
				$this->Session->setFlash(__("Your profile was updated successfully"));
				//$this->redirect(array('controller' => 'Users', 'action' => 'user_setting'));	
				
			}
			elseif ($resourceflag == "admin"){
				$user = $this->data['users'];
				$usertype = isset($this->data['usertype'])?1:0;
				$fullname = $this->data['name'];
				$email = $this->data['email'];
				$department = $this->data['department'];
				$title = $this->data['title'];
				$manager = $this->data['manager'];
				$activeflag = isset($this->data['activeFlag'])?1:0;
				
				
				$sql="UPDATE users SET  usertype = '$usertype',
							name = '$fullname',
							mail = '$email',
							department = '$department',
							title = '$title',
							manager = '$manager',
							activeflag = '$activeflag',
							updated_at = now(),
							updator_id  = '$username'
					WHERE username= '$user'";
				$query = mysql_query($sql);
				$this->Session->setFlash(__("Your profile was updated successfully"));
			}
			
		}
		//Name, title, departement
		$sql="SELECT usertype, name, department, title,  manager, mail, activeflag FROM users WHERE username = '$username'";
		//$sql="SELECT usertype, username, name, department, title, manager, email, activeflag,
		//	FROM users
		//	where username= admin direct username from pulldown";
		$query = mysql_query("$sql");
		$array = mysql_fetch_assoc($query);
		$this->set('usertype', $array['usertype']);
		$this->set('username', $username);
		$this->set('email', $array['mail']);
		$this->set('name', $array['name']);
		$this->set('department', $array['department']);
		$this->set('title', $array['title']);
		$this->set('manager', $array['manager']);
		$this->set('activeflag', $array['activeflag']);
		
		
		
		$sql="SELECT usertype, username, name, department, title, manager, mail, activeflag From users ORDER BY username";
		$query = mysql_query("$sql");
		if ($query != NULL){
			$userCount = mysql_num_rows($query);
		}
		$this->set('userCount', $userCount);
		if ($userCount > 0){
			for ($i = 0 ; $i < $userCount; $i++){
				$array = mysql_fetch_assoc($query);
				$allUsertype[$i] = $array['usertype'];
				$allUserame[$i] = $array['username'];
				$allName[$i] = $array['name'];
				$allDepartment[$i] = $array['department'];
				$allTitle[$i] = $array['title'];
				$allManager[$i] = $array['manager'];
				$allEmail[$i] = $array['mail'];
				$allActiveFlag[$i] = $array['activeflag'];
			}
			$this->set('allUsertype', $allUsertype);
			$this->set('allUsername', $allUserame);
			$this->set('allName', $allName);
			$this->set('allDepartment', $allDepartment);
			$this->set('allTitle', $allTitle);
			$this->set('allManager', $allManager);
			$this->set('allEmail', $allEmail);
			$this->set('allActiveFlag', $allActiveFlag);
		}
		


		
	}
	
	
	
}

