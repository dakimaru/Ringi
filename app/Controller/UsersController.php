<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class UsersController extends AppController {
		
		
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add');
    }

    public function login() {
	
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
				// save username entered in the login form
				$username = $this->Auth->user('username');
                $this->redirect(array('controller' => 'Ringi', 'action' => 'main_menu'));
            } else {
                $this->Session->setFlash(__('Invalid username or password, try again'));
            }
        }
    }

    public function secure_login() {

		if(isset( $this->data['userLogin'])){
			$user = $this->data['userLogin'];
		
			$ldap_host = "192.168.1.3";
			$ldapuser      = 'cn=Manager,dc=enspirea,dc=com';  
			$ldappass     = '820davis';

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

			// verify user and password

			if($bind = @ldap_bind($ldap, $user . $ldap_usr_dom, $password)) {

				// valid
				// check presence in groups
				$filter = "(sAMAccountName=" . $user . ")";
				$attr = array("memberof");
				$result = ldap_search($ldap, $ldap_dn, $filter, $attr) or exit("Unable to search LDAP server");
				$entries = ldap_get_entries($ldap, $result);
				ldap_unbind($ldap);

				$access=1;

				if ($access != 0) {
					// establish session variables
					$_SESSION['user'] = $user;
					$_SESSION['access'] = $access;
					return true;
				} 
				
				if ($this->Auth->login()) {
					echo "string";
				}
					
				else {
					// user has no rights
					return false;
				}
			} 
			else {
				// invalid name or password
				return false;
			}
	  	}
	}

    public function logout() {
        if ($this->request->is('post')) {
            if ($this->Auth->logout()) {
                $this->redirect($this->Auth->logout());
            } else {
                $this->Session->setFlash(__('Expired your session'));
            }
        }
        //$this->redirect($this->Auth->logout());
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
			
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->login();
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
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
