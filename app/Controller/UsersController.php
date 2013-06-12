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
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(__('Invalid username or password, try again'));
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
	
		$host = 'localhost';
		$username = 'root';
		$password = '';
		$database = 'ringidata';
		$someTable = 'users';
		
		// Connect to MySQL
		$link = mysql_connect($host, $username, $password);
		
		if (!$link) {
		    die('Could not connect: ' . mysql_error());
		}

		// Make RingiData the current database
		$db_selected = mysql_select_db($database, $link);

		if (!$db_selected) {
			// If we couldn't, then it either doesn't exist, or we can't see it. 
			$sql = "CREATE DATABASE $database";

			if (mysql_query($sql, $link)) {
				echo "<br>Database $database created successfully";
			} 
			else {
				echo '<br>Error creating database: ' . mysql_error();
			}
		}
				
		mysql_select_db($database, $link);	//pointing at the right database

		$sql = "CREATE TABLE IF NOT EXISTS $someTable (
			`id` int unsigned NOT NULL auto_increment PRIMARY KEY,
			`username` char(255),
			`password` char(255),
			`role` char(255),
			`created_at` timestamp,
			`updated_at` timestamp
		   ) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
	
		if (!mysql_query($sql, $link)) {
			echo '<br>Error creating table: ' . mysql_error();
		}	
	
		
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->login();
//$this->redirect(array('controller' => 'Ringi', 'action' => 'index'));
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
