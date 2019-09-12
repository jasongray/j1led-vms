<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

	public function beforeFilter() {
	    parent::beforeFilter();
		$this->Auth->allowedActions = array('login', 'logout', 'forgotten');
	}

/**
 * login method
 *
 * @return void
 */		
	public function login() {
		$this->layout = 'login';
		$this->set('title_for_layout', __('Login'));
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->log(__('User logged in.'), 'info', 'activity');
				$this->User->id = $this->Session->read('Auth.User.id');
				$this->User->saveField('last_login', date('Y-m-d H:i:s'));
				$this->Session->delete('Message.auth');
				$this->redirect($this->Auth->redirect());
			} else {
				$this->log(__('Failed login attempt using username "' . $this->request->data['User']['username'] . '"'), 'important', 'activity');
				$this->Session->setFlash(__('Incorrect Username and/or Password.'), 'Flash/admin_error');
			}
		}
	}

/**
 * logout method
 *
 * @return void
 */	
	public function logout(){
		$this->layout = 'login';
		$this->Session->setFlash('You are now logged out!', 'Flash/admin_success');
		$this->redirect($this->Auth->logout());
		
	}

/**
 * forgotten method
 *
 * @param string $id
 * @return void
 */
	public function forgotten() {
		if ($this->request->is('post')) {
			$c = $this->User->findByEmail($this->request->data['User']['email']);
			if ($c) {
				$new_password = $this->generatePassword($c['User']['id'], 12, 8);
				$email = new CakeEmail('default');
				$email->config(array('from' => array(Configure::read('MySite.send_email') => Configure::read('MySite.send_from'))));
				$email->helpers(array('Html'));
				$email->subject(Configure::read('MySite.site_name') . ' Password Reset');
				$email->template('newpassword');
				$email->emailFormat('both');
				$email->to($c['User']['email']);
				$email->viewVars(array(
					'site_name' => Configure::read('MySite.site_name'),
					'new_password' => $new_password,
					'c' => $c
				));
				if ($email->send()) {
					$this->Session->setFlash(__('Password reset successfully. You have been emailed your new password.'), 'Flash/admin_success');
				} else {
					$this->Session->setFlash(__('Password was not reset.'), 'Flash/admin_error');
				}
			} else {
				$this->Session->setFlash(__('Your email address was not found.'), 'Flash/admin_error');
			}
		} 
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$_conditions = array();
		if ($this->Session->read('Auth.User.group_id') > 2) {
			$_conditions = array('User.company_id' => $this->Session->read('Auth.User.company_id'));
		}
		$this->paginate = array('conditions' => array_merge(array('User.group_id >=' => $this->Session->read('Auth.User.group_id'), $_conditions)));
		$this->set('users', $this->paginate());
	}

/**
 * profile method
 *
 * @param string $id
 * @return void
 */
	public function profile() {
		$id = $this->Session->read('Auth.User.id');
		$this->set('title_for_layout', __('My Profile'));
		$this->edit($id);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->log(__('New user created.'), 'warning', 'activity');
				if ($this->saveAvatar($this->request->data['User']['id'])) {
					$this->Session->setFlash(__('The user has been saved'), 'Flash/admin_success');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The users image was not saved. ' . $this->getErr()), 'Flash/admin_success');
					$this->redirect(array('action' => 'edit', $this->User->id));
				}
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'Flash/admin_error');
			}
		}
		$groups = $this->User->Group->find('list', array('conditions' => array('Group.id > ' => $this->Session->read('Auth.User.group_id'))));
		$companies = $this->User->Company->find('list');
		$this->set(compact('companies', 'groups'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		
		$_conditions = array('Group.id >= ' => $this->Session->read('Auth.User.group_id'));
		if ($this->Session->read('Auth.User.group_id') > 2) {
			$_conditions = array('User.company_id' => $this->Session->read('Auth.User.company_id'));
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			$this->Session->setFlash(__('You are not authorized to access this area'), 'Flash/admin_error');
			$this->redirect(array('action' => 'index'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				if ($this->saveAvatar($this->request->data['User']['id'])) {
					$this->Session->setFlash(__('The user has been saved'), 'Flash/admin_success');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The users image was not saved. ' . $this->getErr()), 'Flash/admin_success');
				}
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'Flash/admin_error');
			}
		} 
		$_conditions = array_merge(array('User.id' => $id), $_conditions);
		$this->request->data = $this->User->find('first', array('conditions' => $_conditions));
		if (empty($this->request->data)) {
			$this->Session->setFlash(__('You are not authorized to access this area'), 'Flash/admin_error');
			$this->redirect(array('action' => 'index'));
		}
		$groups = $this->User->Group->find('list', array('conditions' => array('Group.id >= ' => $this->Session->read('Auth.User.group_id'))));
		$companies = $this->User->Company->find('list');
		$this->set(compact('companies', 'groups'));
	}
	
/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			$this->Session->setFlash(__('You are not authorized to access this area'), 'Flash/admin_error');
			$this->redirect(array('action' => 'index'));
		}
		if ($this->User->delete()) {
			$this->log(__('User deleted') . " #$id", 'important', 'activity');
			$this->Session->setFlash(__('User deleted'), 'Flash/admin_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'), 'Flash/admin_error');
		$this->redirect(array('action' => 'index'));
	}
	
/**
 * cancel method
 *
 * @param string $id
 * @return void
 */
	public function cancel($id = null) {
		$this->Session->setFlash(__('Operation cancelled', true), 'Flash/admin_info');
		$this->redirect(array('action' => 'index'));
	}

/**
 * removeAvatar method
 *
 * @param string $id
 * @return void
 */
	public function removeAvatar( $id = false ){
		$this->layout = 'ajax';
		$this->render(false);
		$this->Session->setFlash(__('User avatar was not removed', true), 'Flash/admin_warning');
		if ($id) {
			$_img = $this->User->read('image', $id);
			if($_img && file_exists(WWW_ROOT . 'img/users/' . $_img['User']['image'])){
				unlink(WWW_ROOT . 'img/users/' . $_img['User']['image']);
			}
			if ($this->User->saveField('image', '')) {
				$this->Session->setFlash(__('User avatar was removed', true), 'Flash/admin_success');
			}
		}
		$this->redirect(array('action' => 'edit', $id));
	}
	
/**
 * saveAvatar method
 *
 * @param string $id
 * @return void
 */	
	private function saveAvatar($id = false){
		if(isset($this->request->data['Image']['file']) && $this->request->data['Image']['file']['error'] != 4){
			$tempFile = $this->request->data['Image']['file']['tmp_name'];
			$targetPath = WWW_ROOT . 'img/users';
			if(!is_dir($targetPath)){
				mkdir($targetPath, 0766);
			}
			$___fileinfo = pathinfo($this->request->data['Image']['file']['name']);
			$__data['file'] = time() . md5($this->request->data['Image']['file']['name']) . '.' . $___fileinfo['extension'];
			$targetFile =  str_replace('//','/',$targetPath) . '/' . $__data['file'];
			if(move_uploaded_file($tempFile,$targetFile)){
				$this->User->saveField('image', $__data['file']);
			}else{
				return false;
			}
		} 
		return true;
	}
	
/**
 * generatePassword method
 * 
 * Generates a random set of characters depending upon the parameters entered and saves to the user record.
 *
 * @param integer $uid The user id of the user to save the password
 * @param integer $length The number of characters to generate
 * @param integer $strength The strength of the password to generate. 1 being alpha only, 8 being alpha numeric with symbols.
 * @return string $password
 */		
	private function generatePassword($uid = false, $length = 9, $strength = 8) {
		
		$vowels = 'aeiou';
		$consonants = 'bcsfghjklmnpqrstvwxyz';
		if ($strength & 1) {
			$consonants .= 'BCDFGHJKLMNPQRSTVWXYZ';
		}
		if ($strength & 2) {
			$vowels .= "AEIOU";
		}
		if ($strength & 4) {
			$consonants .= '1234567890';
		}
		if ($strength & 8) {
			$consonants .= '@#$%!*_()^!?][{}|';
		}
		 
		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		if ($uid) {
			$this->User->id = $uid;
			$this->User->saveField('password', $password);
		}
		return $password;
		
	}

	
	private function getErr() {
		$message = '';
		if(isset($this->request->data['Image']['file'])  && $this->request->data['Image']['file']['error'] != 4) {
			$max_upload = (int)(ini_get('upload_max_filesize'));
			$max_post = (int)(ini_get('post_max_size'));
			$memory_limit = (int)(ini_get('memory_limit'));
			$upload_mb = min($max_upload, $max_post, $memory_limit);
			
			switch ($this->request->data['Image']['file']['error']) {
	            case 1:
	                $message = __("The file you attempted to upload exceeds the maximum file size of ") . $upload_mb . 'MB';
	                break;
	            case 2:
	                $message = __("The file you attempted to upload exceeds the maximum file size of ") . $upload_mb . 'MB';
	                break;
	            case 3:
	                $message = __("The file was only partially uploaded");
	                break;
	            case 5:
	                $message = __("No file was uploaded");
	                break;
	            case 6:
	                $message = __("Missing a temporary folder");
	                break;
	            case 7:
	                $message = __("Failed to write file to disk");
	                break;
	            case 8:
	                $message = __("File upload stopped by extension");
	                break;
	            default:
	                $message = __("An unknown error occurred");
	                break;
	        } 
		}
		return $message;
	}
	
}
