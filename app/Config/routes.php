<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
	Router::connect('/login', array('controller' => 'Users', 'action' => 'login', 'login'));
	Router::connect('/secure_login', array('controller' => 'Users', 'action' => 'secure_login', 'secure_login'));
	Router::connect('/logout', array('controller' => 'Users', 'action' => 'logout', 'logout'));
	
	Router::connect('/delete', array('controller' => 'Users', 'action' => 'delete', 'delete'));
	

	Router::connect('/setup', array('controller' => 'Ringi', 'action' => 'setup', 'setup'));
	Router::connect('/main_menu', array('controller' => 'Ringi', 'action' => 'main_menu', 'main_menu'));
        
	Router::connect('/password_change', array('controller' => 'Users', 'action' => 'password_change', 'password_change'));
	Router::connect('/password_reset', array('controller' => 'Users', 'action' => 'password_reset', 'password_reset'));
	Router::connect('/support', array('controller' => 'Ringi', 'action' => 'support', 'support'));
	Router::connect('/credit', array('controller' => 'Ringi', 'action' => 'credit', 'credit'));
	
	Router::connect('/upload_layout', array('controller' => 'Ringi', 'action' => 'upload_layout', 'upload_layout'));
	Router::connect('/preview', array('controller' => 'Ringi', 'action' => 'preview', 'preview'));
	Router::connect('/upload_confirmation', array('controller' => 'Ringi', 'action' => 'upload_confirmation', 'upload_confirmation'));
	Router::connect('/apply', array('controller' => 'Ringi', 'action' => 'apply', 'apply'));
	Router::connect('/apply_check', array('controller' => 'Ringi', 'action' => 'apply_check', 'apply_check'));
	Router::connect('/pass_back_check', array('controller' => 'Ringi', 'action' => 'pass_back_check', 'pass_back_check'));
	Router::connect('/reject', array('controller' => 'Ringi', 'action' => 'reject', 'reject'));
	Router::connect('/application_details', array('controller' => 'Ringi', 'action' => 'application_details', 'application_details'));
	
	Router::connect('/edit', array('controller' => 'Ringi', 'action' => 'edit', 'edit'));
	
	Router::connect('/pattern3', array('controller' => 'Ringi', 'action' => 'pattern3', 'pattern3'));
	
	Router::connect('/reapply', array('controller' => 'Ringi', 'action' => 'reapply', 'reapply'));

	Router::connect('/approve', array('controller' => 'Ringi', 'action' => 'approve', 'approve'));
	Router::connect('/accept', array('controller' => 'Ringi', 'action' => 'accept', 'accept'));
	Router::connect('/reject', array('controller' => 'Ringi', 'action' => 'reject', 'reject'));
	Router::connect('/hold', array('controller' => 'Ringi', 'action' => 'hold', 'hold'));
	Router::connect('/passback', array('controller' => 'Ringi', 'action' => 'passback', 'passback'));
	Router::connect('/reopen', array('controller' => 'Ringi', 'action' => 'reopen', 'reopen'));
	Router::connect('/cancel1', array('controller' => 'Ringi', 'action' => 'cancel1', 'cancel1'));
	Router::connect('/cancel2', array('controller' => 'Ringi', 'action' => 'cancel2', 'cancel2'));
	
	Router::connect('/task', array('controller' => 'Ringi', 'action' => 'task', 'task'));
	Router::connect('/other', array('controller' => 'Ringi', 'action' => 'other', 'other'));

	Router::connect('/user_setting', array('controller' => 'Users', 'action' => 'user_setting', 'user_setting'));
    Router::connect('/report', array('controller' => 'Ringi', 'action' => 'report', 'report'));
    Router::connect('/download', array('controller' => 'Ringi', 'action' => 'download', 'download'));


/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
