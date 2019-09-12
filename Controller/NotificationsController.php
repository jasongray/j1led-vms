<?php
App::uses('AppController', 'Controller');
/**
 * Notifications Controller
 *
 * @property Notification $Notification
 */
class NotificationsController extends AppController {

	public function beforeFilter() {
	    parent::beforeFilter();
	}

/**
 * new method
 *
 * @return void
 */
	public function recent() {
		$this->autoRender = false;
		$this->Notification->recursive = -1;
		$client_id = $this->Session->read('Auth.User.client_id');
		$conditions =  array('Notification.read' => 0);
		if (!empty($client_id)) {
			$conditions = array_merge(array('Notification.client_id' => $client_id), $conditions);
		} 
		return $this->Notification->find('all', array('conditions' => array($conditions), 'order' => array('Notification.created' => 'ASC')));
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Notification->recursive = 0;
		$client_id = $this->Session->read('Auth.User.client_id');
		$user_id = $this->Session->read('Auth.User.id');
		$conditions = array("IF (Notification.user_id IS NOT NULL, Notification.user_id = $user_id, 1=1)");
		if (!empty($client_id)) {
			$conditions = array_merge(array('Notification.client_id' => $client_id), $conditions);
		} 
		$this->paginate = array('conditions' => $conditions, 'order' => array('Notification.read' => 'ASC', 'Notification.created' => 'DESC'));
		$this->set('notifications', $this->paginate());
		
		if ($this->Acl->check(array('User' => array('id' => $this->Session->read('Auth.User.id'))), 'Notifications')){
			$editable = true;
		} else {
			$editable = false;
		}
		$this->set('editable', $editable);
	}


/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Notification->id = $id;
		if (!$this->Notification->exists()) {
			$this->Session->setFlash(__('Invalid notification'), 'Flash/admin_error');
			$this->redirect(array('action' => 'index'));
		}
		$this->set('sign', $this->Notification->read(null, $id));
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
			$this->Notification->create();
			if ($this->Notification->save($this->request->data)) {
				$this->Session->setFlash(__('The notification has been saved'), 'Flash/admin_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The notification could not be saved. Please, try again.'), 'Flash/admin_error');
			}
		}
		$clients = $this->Notification->Client->find('list');
		$this->set(compact('clients'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Notification->id = $id;
		if (!$this->Notification->exists()) {
			throw new NotFoundException(__('Invalid notification'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Notification->save($this->request->data)) {
				$this->Session->setFlash(__('The notification has been saved'), 'Flash/admin_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The notification could not be saved. Please, try again.'), 'Flash/admin_error');
			}
		} else {
			$this->request->data = $this->Notification->read(null, $id);
		}
		$clients = $this->Notification->Client->find('list');
		$this->set(compact('clients'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Notification->id = $id;
		if (!$this->Notification->exists()) {
			throw new NotFoundException(__('Invalid notification'));
		}
		if ($this->Notification->delete()) {
			$this->Session->setFlash(__('Notification deleted'), 'Flash/admin_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Notification was not deleted'), 'Flash/admin_error');
		$this->redirect(array('action' => 'index'));
	}
}
