<?php
App::uses('AppController', 'Controller');
/**
 * Frames Controller
 *
 * @property Frame $Frame
 */
class FramesController extends AppController {
	
	public function beforeFilter() {
	    parent::beforeFilter();
	}
	
	public function index() {
		
	}
	
	public function sign($id) {
		$this->loadModel('Sign');
		$this->Sign->id = $id;
		if ($this->Sign->exists()) {
			$sign = $this->Sign->read(null, $id);
			$this->set('s', $sign);
			
			$this->loadModel('SignImage');
			$this->set('frames', $this->SignImage->getImagesbySignType($sign['Sign']['sign_type_id']));
		}
	}
	

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Frame->create();
			if ($this->Frame->saveAll($this->request->data)) {
				$this->log(__('New frame created.'), 'notice', 'activity');
				$this->saveLogo($this->request->data['Frame']['id']);
				$this->saveCss($this->request->data['Frame']['id']);
				$this->Session->setFlash(__('The frame has been saved'), 'Flash/admin_success');
				if ($this->Session->read('Auth.User.group_id') < 3) {
					$this->redirect(array('action' => 'index'));
				} else {
					$this->redirect($this->referer());
				}
			} else {
				$this->Session->setFlash(__('The frame could not be saved. Please, try again.'), 'Flash/admin_error');
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
		$this->Frame->id = $id;
		if (!$this->Frame->exists()) {
			throw new NotFoundException(__('Invalid frame'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			//pr($this->request->data);exit;
			if ($this->Frame->saveAll($this->request->data)) {
				$this->saveLogo($this->request->data['Frame']['id']);
				$this->saveCss($this->request->data['Frame']['id']);
				$this->Session->setFlash(__('The frame has been saved'), 'Flash/admin_success');
				if ($this->Session->read('Auth.User.group_id') < 3) {
					$this->redirect(array('action' => 'index'));
				} else {
					$this->redirect($this->referer());
				}
			} else {
				$this->Session->setFlash(__('The frame could not be saved. Please, try again.'), 'Flash/admin_error');
			}
		} else {
			$this->request->data = $this->Frame->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Frame->id = $id;
		if (!$this->Frame->exists()) {
			throw new NotFoundException(__('Invalid frame'));
		}
		if ($this->Frame->delete()) {
			$this->log(__('Frame deleted') . " #$id", 'important', 'activity');
			$this->Session->setFlash(__('Frame deleted'), 'Flash/admin_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Frame was not deleted'), 'Flash/admin_error');
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

	
}