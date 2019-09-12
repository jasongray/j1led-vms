<?php
App::uses('AppController', 'Controller');
/**
 * CustomFields Controller
 *
 * @property CustomField $CustomField
 */
class CustomFieldsController extends AppController {
	
	public function beforeFilter() {
	    parent::beforeFilter();
	}
	
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CustomField->recursive = 0;
		$this->set('fields', $this->paginate());
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
			$this->CustomField->create();
			if ($this->CustomField->save($this->request->data)) {
				$this->Session->setFlash(__('The field has been saved'), 'Flash/admin_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The field could not be saved. Please, try again.'), 'Flash/admin_error');
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
		$this->CustomField->id = $id;
		if (!$this->CustomField->exists()) {
			throw new NotFoundException(__('Invalid field'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CustomField->save($this->request->data)) {
				$this->Session->setFlash(__('The field has been saved'), 'Flash/admin_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The field could not be saved. Please, try again.'), 'Flash/admin_error');
			}
		} else {
			$this->request->data = $this->CustomField->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->CustomField->id = $id;
		if (!$this->CustomField->exists()) {
			throw new NotFoundException(__('Invalid field'));
		}
		if ($this->CustomField->delete()) {
			$this->Session->setFlash(__('CustomField deleted'), 'Flash/admin_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('CustomField was not deleted'), 'Flash/admin_error');
		$this->redirect(array('action' => 'index'));
	}

}
