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
//PHPExcel
App::import('Vendor','PHPExcel',array('file' => 'excel/PHPExcel.php')); 
App::import('Vendor','PHPExcelWriter',array('file' => 'excel/PHPExcel/Writer/Excel2007.php'));
//Php-Excel-Reader
App::import('Vendor','excelreader2',array('file' => 'excel/excel_reader2.php'));


//Testing function loading
if (!class_exists('PHPExcel')) {
    throw new CakeException('Vendor class PHPExcel not found!');
}

if (!class_exists('Spreadsheet_Excel_Reader')) {
  	throw new CakeException('Vendor class Spreadsheet_Excel_Reader not found!');
}

//if (!class_exists('setActiveSheetIndex')) {
//   throw new CakeException('Vendor class setActiveSheetIndex not found!');
//}

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
            'loginRedirect' => array('controller' => 'Ringi', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'Users', 'action' => 'login')
        )
    );

    public function beforeFilter() {
        $this->Auth->allow('apply', 'apply_check', 'confirm', 'logout', 'login', 'confirm_check');
    }

    public function isAuthorized($user) {
    if (isset($user['role']) && $user['role'] === 'admin') {
        return true;
    }

    //Reject author management
        return false;
    }
}
