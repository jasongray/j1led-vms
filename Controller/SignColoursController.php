<?php
App::uses('AppController', 'Controller');
/**
 * SignColours Controller
 *
 * @property SignColour $SignColour
 */
class SignColoursController extends AppController {
	
	public function beforeFilter() {
	    parent::beforeFilter();
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->SignColour->recursive = 0;
		$this->set('colours', $this->paginate());
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
			$this->SignColour->create();
			if ($this->SignColour->save($this->request->data)) {
				$this->Session->setFlash(__('The colour has been saved'), 'Flash/admin_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The colour could not be saved. Please, try again.'), 'Flash/admin_error');
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
		$this->SignColour->id = $id;
		if (!$this->SignColour->exists()) {
			throw new NotFoundException(__('Invalid colour'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->SignColour->save($this->request->data)) {
				$this->Session->setFlash(__('The colour has been saved'), 'Flash/admin_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The colour could not be saved. Please, try again.'), 'Flash/admin_error');
			}
		} else {
			$this->request->data = $this->SignColour->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->SignColour->id = $id;
		if (!$this->SignColour->exists()) {
			throw new NotFoundException(__('Invalid colour'));
		}
		if ($this->SignColour->delete()) {
			$this->Session->setFlash(__('SignColour deleted'), 'Flash/admin_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('SignColour was not deleted'), 'Flash/admin_error');
		$this->redirect(array('action' => 'index'));
	}
}
