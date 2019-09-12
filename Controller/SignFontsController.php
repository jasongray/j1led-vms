<?php
App::uses('AppController', 'Controller');
/**
 * SignFonts Controller
 *
 * @property SignFont $SignFont
 */
class SignFontsController extends AppController {
	
	public function beforeFilter() {
	    parent::beforeFilter();
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->SignFont->recursive = 0;
		$this->set('fonts', $this->paginate());
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
			$this->SignFont->create();
			if ($this->SignFont->save($this->request->data)) {
				$this->Session->setFlash(__('The font has been saved'), 'Flash/admin_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The font could not be saved. Please, try again.'), 'Flash/admin_error');
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
		$this->SignFont->id = $id;
		if (!$this->SignFont->exists()) {
			throw new NotFoundException(__('Invalid font'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->SignFont->save($this->request->data)) {
				$this->Session->setFlash(__('The font has been saved'), 'Flash/admin_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The font could not be saved. Please, try again.'), 'Flash/admin_error');
			}
		} else {
			$this->request->data = $this->SignFont->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->SignFont->id = $id;
		if (!$this->SignFont->exists()) {
			throw new NotFoundException(__('Invalid font'));
		}
		if ($this->SignFont->delete()) {
			$this->Session->setFlash(__('SignFont deleted'), 'Flash/admin_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('SignFont was not deleted'), 'Flash/admin_error');
		$this->redirect(array('action' => 'index'));
	}
}
