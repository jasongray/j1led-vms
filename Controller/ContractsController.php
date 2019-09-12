<?php
App::uses('AppController', 'Controller');
/**
 * Contracts Controller
 *
 * @property Contract $Contract
 */
class ContractsController extends AppController {
	

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Contract->recursive = 0;
		$this->paginate = array(
			'conditions' => array('CURDATE() BETWEEN Contract.on_hire_date AND Contract.off_hire_date OR CURDATE() < Contract.on_hire_date'),
			'order' => array('Contract.on_hire_date' => 'ASC')
		);
		$this->set('contracts', $this->paginate());
	}
	
/**
 * archive method
 *
 * @return void
 */
	public function archive() {
		$this->Contract->recursive = 0;
		$this->set('title_for_layout', __('Archived Contracts'));
		$this->paginate = array(
			'conditions' => array('CURDATE() > Contract.off_hire_date'),
			'order' => array('Contract.on_hire_date' => 'ASC')
		);
		$this->set('contracts', $this->paginate());
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
			if ($this->Contract->noConflict($this->request->data)) {
				$this->Contract->create();
				if ($this->Contract->save($this->request->data)) {
					$this->log('notice', __('New contract created. #') . $this->Contract->id, 'activity');
					$this->Session->setFlash(__('The contract has been saved'), 'Flash/admin_success');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The contract could not be saved. Please, try again.'), 'Flash/admin_error');
				}
			} else {
				$this->Session->setFlash(__('This contract conflicts with another. Please select different dates.'), 'Flash/admin_error');
			}
		}
		$signs = $this->Contract->Sign->find('list', array('conditions' => array('Sign.company_id' => $this->Session->read('Auth.User.company_id'))));
		$companies = $this->Contract->Company->find('list');
		$this->set(compact('companies', 'signs'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Contract->id = $id;
		if (!$this->Contract->exists()) {
			throw new NotFoundException(__('Invalid contract'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Contract->noConflict($this->request->data)) {
				if ($this->Contract->save($this->request->data)) {
					$this->Session->setFlash(__('The contract has been saved'), 'Flash/admin_success');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The contract could not be saved. Please, try again.'), 'Flash/admin_error');
				}
			} else {
				$this->Session->setFlash(__('This contract conflicts with another. Please select different dates.'), 'Flash/admin_error');
			}
		} else {
			$this->request->data = $this->Contract->read(null, $id);
		}
		$signs = $this->Contract->Sign->find('list', array('conditions' => array('Sign.company_id' => $this->Session->read('Auth.User.company_id'))));
		$companies = $this->Contract->Company->find('list');
		$this->set(compact('companies', 'signs'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Contract->id = $id;
		if (!$this->Contract->exists()) {
			throw new NotFoundException(__('Invalid contract'));
		}
		if ($this->Contract->delete()) {
			$this->Session->setFlash(__('Contract deleted'), 'Flash/admin_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Contract was not deleted'), 'Flash/admin_error');
		$this->redirect(array('action' => 'index'));
	}
}
