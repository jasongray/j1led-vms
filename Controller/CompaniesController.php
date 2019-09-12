<?php
App::uses('AppController', 'Controller');
/**
 * Companys Controller
 *
 * @property Company $Company
 */
class CompaniesController extends AppController {


	public function beforeFilter() {
	    parent::beforeFilter();
	}
		
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Company->recursive = 0;
		$this->set('companies', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Company->id = $id;
		if (!$this->Company->exists()) {
			throw new NotFoundException(__('Invalid company'));
		}
		$this->set('company', $this->Company->read(null, $id));
	}

/**
 * profile method
 *
 * @param string $id
 * @return void
 */
	public function profile() {
		$id = $this->Session->read('Auth.User.company_id');
		$this->set('title_for_layout', __('Company Profile'));
		$this->edit($id);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Company->create();
			if ($this->Company->saveAll($this->request->data)) {
				$this->log(__('New company created.'), 'notice', 'activity');
				$this->saveLogo($this->request->data['Company']['id']);
				$this->saveCss($this->request->data['Company']['id']);
				$this->Session->setFlash(__('The company has been saved'), 'Flash/admin_success');
				if ($this->Session->read('Auth.User.group_id') < 3) {
					$this->redirect(array('action' => 'index'));
				} else {
					$this->redirect($this->referer());
				}
			} else {
				$this->Session->setFlash(__('The company could not be saved. Please, try again.'), 'Flash/admin_error');
			}
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Company->id = $id;
		if (!$this->Company->exists()) {
			throw new NotFoundException(__('Invalid company'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			//pr($this->request->data);exit;
			if ($this->Company->saveAll($this->request->data)) {
				$this->saveLogo($this->request->data['Company']['id']);
				$this->saveCss($this->request->data['Company']['id']);
				$this->Session->setFlash(__('The company has been saved'), 'Flash/admin_success');
				if ($this->Session->read('Auth.User.group_id') < 3) {
					$this->redirect(array('action' => 'index'));
				} else {
					$this->redirect($this->referer());
				}
			} else {
				$this->Session->setFlash(__('The company could not be saved. Please, try again.'), 'Flash/admin_error');
			}
		} else {
			$this->request->data = $this->Company->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Company->id = $id;
		if (!$this->Company->exists()) {
			throw new NotFoundException(__('Invalid company'));
		}
		if ($this->Company->delete()) {
			$this->log(__('Company deleted') . " #$id", 'important', 'activity');
			$this->Session->setFlash(__('Company deleted'), 'Flash/admin_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Company was not deleted'), 'Flash/admin_error');
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
		if ($this->Session->read('Auth.User.group_id') < 3) {
			$this->redirect(array('action' => 'index'));
		} else {
			$this->redirect('/');
		}
	}

/**
 * removeLogo method
 *
 * @param string $id
 * @return void
 */
	public function removeLogo( $id = false ){
		$this->layout = 'ajax';
		$this->render(false);
		$this->Session->setFlash(__('Company logo was not removed', true), 'Flash/admin_warning');
		if ($id) {
			$_img = $this->Company->read('image', $id);
			if($_img && file_exists(WWW_ROOT . 'img/companies/' . $_img['Company']['image'])){
				unlink(WWW_ROOT . 'img/companies/' . $_img['Company']['image']);
			}
			if ($this->Company->saveField('logo', '')) {
				$this->Session->setFlash(__('Company logo was removed', true), 'Flash/admin_success');
			}
		}
		if ($this->Session->read('Auth.User.group_id') < 3) {
			$this->redirect(array('action' => 'edit', $id));
		} else {
			$this->redirect(array('action' => 'profile', $id));
		}
	}
	
/**
 * saveLogo method
 *
 * @param string $id
 * @return void
 */	
	private function saveLogo($id = false){
		if(isset($this->request->data['Image']['file']) && $this->request->data['Image']['file']['error'] != 4){
			$tempFile = $this->request->data['Image']['file']['tmp_name'];
			$targetPath = WWW_ROOT . 'img/companies';
			if(!is_dir($targetPath)){
				mkdir($targetPath, 0766);
			}
			$___fileinfo = pathinfo($this->request->data['Image']['file']['name']);
			$__data['file'] = time() . md5($this->request->data['Image']['file']['name']) . '.' . $___fileinfo['extension'];
			$targetFile =  str_replace('//','/',$targetPath) . '/' . $__data['file'];
			if(move_uploaded_file($tempFile,$targetFile)){
				$this->Company->saveField('logo', $__data['file']);
			}else{
				$_result = '<p class="error">' . __('Failed to move uploaded file') . '</p>';
			}
		}
	}
	
/**
 * saveCss method
 *
 * @param string $id
 * @return void
 */	
	private function saveCss($id = false){
		if(isset($this->request->data['Css']['file']) && $this->request->data['Css']['file']['error'] != 4){
			$tempFile = $this->request->data['Css']['file']['tmp_name'];
			$targetPath = WWW_ROOT . 'files/companies';
			if(!is_dir($targetPath)){
				mkdir($targetPath, 0766);
			}
			$___fileinfo = pathinfo($this->request->data['Css']['file']['name']);
			$__data['file'] = time() . md5($this->request->data['Css']['file']['name']) . '.' . $___fileinfo['extension'];
			$targetFile =  str_replace('//','/',$targetPath) . '/' . $__data['file'];
			if(move_uploaded_file($tempFile,$targetFile)){
				$this->Company->saveField('css', $__data['file']);
			}else{
				$_result = '<p class="error">' . __('Failed to move uploaded file') . '</p>';
			}
		}
	}	
	
/**
 * removeCss method
 *
 * @param string $id
 * @return void
 */
	public function removeCss( $id = false ){
		$this->layout = 'ajax';
		$this->render(false);
		$this->Session->setFlash(__('CSS file was not removed', true), 'Flash/admin_warning');
		if ($id) {
			$_img = $this->Company->read('css', $id);
			if($_img && file_exists(WWW_ROOT . 'files/companies/' . $_img['Company']['css'])){
				unlink(WWW_ROOT . 'files/companies/' . $_img['Company']['css']);
			}
			if ($this->Company->saveField('css', '')) {
				$this->Session->setFlash(__('CSS file was removed', true), 'Flash/admin_success');
			}
		}
		if ($this->Session->read('Auth.User.group_id') < 3) {
			$this->redirect(array('action' => 'edit', $id));
		} else {
			$this->redirect(array('action' => 'profile', $id));
		}
	}
	
}