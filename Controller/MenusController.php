<?php
App::uses('AppController', 'Controller');
/**
 * Menus Controller
 *
 * @property Menu $Menu
 */
class MenusController extends AppController {
	
	public function beforeFilter() {
	    parent::beforeFilter();
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Menu->recursive = 0;
		$this->set('menus', $this->paginate());
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
			$this->Menu->create();
			if ($this->Menu->save($this->request->data)) {
				$this->Session->setFlash(__('The menu has been saved'), 'Flash/admin_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The menu could not be saved. Please, try again.'), 'Flash/admin_error');
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
		$this->Menu->id = $id;
		if (!$this->Menu->exists()) {
			throw new NotFoundException(__('Invalid menu'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Menu->save($this->request->data)) {
				$this->Session->setFlash(__('The menu has been saved'), 'Flash/admin_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The menu could not be saved. Please, try again.'), 'Flash/admin_error');
			}
		} else {
			$this->request->data = $this->Menu->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Menu->id = $id;
		if (!$this->Menu->exists()) {
			throw new NotFoundException(__('Invalid menu'));
		}
		if ($this->Menu->delete()) {
			$this->Session->setFlash(__('Menu deleted'), 'Flash/admin_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Menu was not deleted'), 'Flash/admin_error');
		$this->redirect(array('action' => 'index'));
	}
	
}
