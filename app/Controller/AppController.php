<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('PhpReader', 'Configure');

//PHPExcel
App::import('Vendor','PHPExcel',array('file' => 'excel/phpexcel.php'));
App::import('Vendor','IOFactory',array('file' => 'excel/PHPExcel/IOFactory.php'));
App::import('Vendor','PHPExcelWriter',array('file' => 'excel/PHPExcel/Reader/Excel5.php'));
App::import('Vendor','PHPExcelWriter',array('file' => 'excel/PHPExcel/Writer/Excel5.php'));


//Testing class and function loading
if (!class_exists('PHPExcel')) {
    throw new CakeException('Vendor class PHPExcel not found!');
}

if (!method_exists('PHPExcel', 'setActiveSheetIndex')) {
   throw new CakeException('Vendor function setActiveSheetIndex not found!');
}

//excel_reader2 to be included

App::import('Vendor','php_reader',array('file' => 'excel_reader2.php'));
//require_once 'phpreader/excel_reader2.php';
//error_reporting(E_ALL ^ E_NOTICE);

if (!class_exists('Spreadsheet_Excel_Reader')) {
    throw new CakeException('Vendor class Spreadsheet_Excel_Reader not found!');
}

if (!method_exists('Spreadsheet_Excel_Reader', 'dump')) {
   throw new CakeException('Vendor function dump not found!');
}


/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	
	public $helpers = array('excel');	//enables usage of helpers
    
	public $components = array(
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'Ringi', 'action' => 'main_menu'),
            'logoutRedirect' => array('controller' => 'Users', 'action' => 'login')
        )
    );

    public function beforeFilter() {
        //$this->Auth->allow();
		Configure::load('parameters');
    }

    public function isAuthorized($user) {
    if (isset($user['usertype']) && $user['usertype'] === '1') {
        return true;
    }

    //Reject author management
        return false;
    }

	protected function exec_in_vendorpath($command, $arg1='', $arg2='', $arg3='', $arg4=''){
		
		//print_r("**exec_in_vendorpath with ". $command );
		
		$confDirectory = Configure::read('directories');
		$working_dir = $confDirectory['ScriptRoot'];
		
		$confScript = Configure::read('scripts');
		$script_to_run = $confScript[$command];
		$script_to_run = $script_to_run. " ". $arg1. " ". $arg2. " ". $arg3. " ". $arg4;

		//echo  $script_to_run;
		//print_r( "\n" );
		
		chdir( $working_dir );
		$retval = exec( $script_to_run );
		
		return $retval;	
	}
	
}
