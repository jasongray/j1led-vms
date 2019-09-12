<?php
App::uses('AppController', 'Controller');
/**
 * ActivityLogs Controller
 *
 * @property ActivityLog $ActivityLog
 */
class ActivityLogsController extends AppController {
	
	public function beforeFilter() {
	    parent::beforeFilter();
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->ActivityLog->recursive = 0;
		$this->paginate = array('order' => array('ActivityLog.created' => 'DESC'));
		$this->set('activity', $this->paginate());
		
		if ($this->Acl->check(array('User' => array('id' => $this->Session->read('Auth.User.id'))), 'ActivityLogs')){
			$editable = true;
		} else {
			$editable = false;
		}
		$this->set('editable', $editable);
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
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->ActivityLog->id = $id;
		if (!$this->ActivityLog->exists()) {
			throw new NotFoundException(__('Invalid log entry'));
		}
		
		if ($this->Acl->check(array('User' => array('id' => $this->Session->read('Auth.User.id'))), 'ActivityLogs/delete')){
			$editable = true;
		} else {
			$editable = false;
		}
		$this->set('editable', $editable);
		
		$log = $this->ActivityLog->read(null, $id);
		$sign = array();
		
		if(preg_match('/(\bsign\b)/', $log['ActivityLog']['description'], $m)) { 
			if(preg_match('/\((\d+)\)/', $log['ActivityLog']['description'], $m)) {
				$this->loadModel('Sign');
				$sign = $this->Sign->read(null, $m[1]);
			}
		}
		$this->set(compact('log', 'sign'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->ActivityLog->id = $id;
		if (!$this->ActivityLog->exists()) {
			throw new NotFoundException(__('Invalid log entry'));
		}
		if ($this->ActivityLog->delete()) {
			$this->Session->setFlash(__('Log entry deleted'), 'Flash/admin_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Log entry was not deleted'), 'Flash/admin_error');
		$this->redirect(array('action' => 'index'));
	}
}
