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

	var $components = array('Auth', 'Acl', 'Paginator', 'Session', 'Cookie', 'RequestHandler');
	
	var $helpers = array('Html', 'Form', 'Session', 'Paginator', 'Resize', 'Xhtml', 'Menu', 'Module', 'Number', 'Time');
	
	function beforeFilter() {
		$this->Auth->authenticate = array('Blowfish' => array('scope' => array('User.is_active' => true)));
		$this->Auth->authorize = array('Actions');
		$this->Auth->autoRedirect = false;
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'admin' => false, 'plugin' => false);
		$this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login', 'admin' => false, 'plugin' => false);
		$this->Auth->loginRedirect = array('controller' => 'signs', 'action' => 'dashboard', 'admin' => false, 'plugin' => false);
		$this->Auth->authError = '';
		$this->Auth->flash = array('element' => 'Flash/admin_error', 'key' => 'auth', 'params' => array());
		
		if (Configure::read('Mysite.offline') == 1) {
			$this->response->statusCode(503);
		}
		
	}
	
	function beforeRender() {
		if($this->name == 'CakeError') {
			$this->layout = 'error';
			$this->set('title_for_layout', __('OOPS! An error has occured!'));
		}
	}
	

}
