<?php
App::uses('AppController', 'Controller');
/**
 * CustomLabels Controller
 *
 * @property CustomLabel $CustomLabel
 */
class CustomLabelsController extends AppController {
	
	public function beforeFilter() {
	    parent::beforeFilter();
	}
	
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CustomLabel->recursive = 0;
		$this->set('labels', $this->paginate());
	}

/**
 * cancel method
 *
 * @param string $id
 * @return void
 */
	public function cancel($id = null) {
		$this->Session->setFlash(__('Operation cancelled'), 'Flash/admin_info');
		$this->redirect(array('action' => 'index'));
	}
	
/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CustomLabel->create();
			if ($this->CustomLabel->save($this->request->data)) {
				$this->Session->setFlash(__('The label has been saved'), 'Flash/admin_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The label could not be saved. Please, try again.'), 'Flash/admin_error');
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
		$this->CustomLabel->id = $id;
		if (!$this->CustomLabel->exists()) {
			throw new NotFoundException(__('Invalid label'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CustomLabel->save($this->request->data)) {
				$this->Session->setFlash(__('The label has been saved'), 'Flash/admin_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The label could not be saved. Please, try again.'), 'Flash/admin_error');
			}
		} else {
			$this->request->data = $this->CustomLabel->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->CustomLabel->id = $id;
		if (!$this->CustomLabel->exists()) {
			throw new NotFoundException(__('Invalid label'));
		}
		if ($this->CustomLabel->delete()) {
			$this->Session->setFlash(__('CustomLabel deleted'), 'Flash/admin_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('CustomLabel was not deleted'), 'Flash/admin_error');
		$this->redirect(array('action' => 'index'));
	}

/**
 * ajaxupdate method
 *
 * @param string $id
 * @return void
 */
	public function ajaxupdate($id = null) {
		$this->autoRender = false;
		$this->CustomLabel->id = $id;
		if (!$this->CustomLabel->exists()) {
			echo false;
		}
		if ($this->CustomLabel->save($this->request->data)) {
			echo true;
		} else {
			echo false;
		}
	}
	
/**
 * ajaxdelete method
 *
 * @param string $id
 * @return void
 */
	public function ajaxdelete($id = null) {
		$this->autoRender = false;
		$this->CustomLabel->id = $id;
		if (!$this->CustomLabel->exists()) {
			echo false;
		}
		if ($this->CustomLabel->delete()) {
			echo true;
		} else {
			echo false;
		}
	}
}
