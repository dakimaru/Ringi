<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class UsersController extends AppController {

	public function openSQLconnection() {
		$host = 'localhost';
		$username = 'root';
		$password = '';

		// Connect to MySQL
		return mysql_connect($host, $username, $password);
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
				
				$database = 'ringidata';

				// Connect to MySQL
				$link = $this->openSQLconnection();

				if (!$link) {
					die('Could not connect: ' . mysql_error());
				}

				mysql_select_db($database, $link);	//pointing at the right database

				$salted_pass = $this->Auth->password($pass);			//put salt on password

				$querynewpass = "UPDATE users SET `password`='".$salted_pass."' WHERE username='".$usr."'"; 
				mysql_query($querynewpass, $link) or die(mysql_error());	//overwrite password

				//print_r ($this->data['User']);
				//$username = $this->Auth->user('username');
				if ($this->Auth->login()) {
					// save username entered in the login form
					$username = $this->Auth->user('username');
					
					return $this->redirect($this->Auth->redirectUrl());
					//return $this->redirect(array('controller' => 'Ringi', 'action' => 'overview'));
				}
			}	
			else {
				
				$this->Session->setFlash(__('Invalid username or password, try again'));
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

	public function add() {
		$database='ringidata';
		if ($this->request->is('post')) {
			$this->User->create();
			
			$link = $this->openSQLconnection();
			$db_selected = mysql_select_db($database, $link);
			$newusername = $this->data['User']['username'];
			$sql = "SELECT username FROM users WHERE username='".$newusername."'";
			$query=mysql_query($sql);
			$existing = mysql_fetch_assoc($query);
			if ($existing==NULL) {
				
				$user=$this->request->data;
				$user['User']['usertype'] = 0;
				$user['User']['activeflag'] = 1;
				if ($this->Auth->user('username')!==NULL) {
					$user['User']['creator_id'] = $this->Auth->user('username');
				}
				$user['User']['created_at'] = DboSource::expression('NOW()');	

				$this->User->save($user);

				if ($this->Auth->login()) {
					$this->Session->setFlash(__('The user has been saved'));
					return $this->redirect(array('controller' => 'Ringi', 'action' => 'main_menu'));
				}
			} 
			else {
				$this->Session->setFlash(__('A user with this username already exists'));
			}
		}
	}

	public function edit($id = null) {
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
	}

	public function delete($id = null) {
		if (!$this->request->is('post')) {
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
		$this->redirect(array('action' => 'index'));
	}
}
