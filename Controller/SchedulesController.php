<?php
App::uses('AppController', 'Controller');
/**
 * Schedules Controller
 *
 * @property Schedule $Schedule
 */
class SchedulesController extends AppController {
	
	public function beforeFilter() {
	    parent::beforeFilter();
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Schedule->recursive = 0;
		$this->set('schedules', $this->Schedule->getSchedules());
	}
	
/**
 * sign method
 *
 * @return void
 */
	public function sign($id = null) {
		$this->Schedule->recursive = 0;
		$this->set('schedules', $this->Schedule->getCurrentSchedules($id, $this->Session->read('Auth.User.company_id')));
		$this->render('index');
	}
	
/**
 * getframes method
 *
 * @return void
 */
	public function getframes($id = null) {
		$this->Schedule->recursive = 0;
		$this->request->data = $this->Schedule->getFrames($id, $this->Session->read('Auth.User.company_id'));
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
		if($this->RequestHandler->isAjax()){
			$this->layout = 'ajax';
			$this->autoRender = false;
			$this->Schedule->set($this->request->data);
			if ($this->Schedule->validates()) {
				$this->request->data['Schedule']['company_id'] = $this->Session->read('Auth.User.company_id');
				if ($this->Schedule->saveAll($this->request->data)) {
					$msg = array('response' => 1, 'msg' => array(__('The schedule has been saved')));
				} else {
					$msg = array('response' => 0, 'msg' => array(__('Error saving schedule')), 'data' => array());
				}
			} else {
				$Schedule = $this->Schedule->invalidFields();
				$data = compact('Schedule');
				$msg = array('response' => 0, 'msg'  => array(__('The schedule was not saved')), 'data' => $data);
			}
			echo json_encode($msg);
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->layout = 'ajax';
		$this->autoRender = false;
		$this->Schedule->id = $id;
		$redirect = false;
		if (!$this->Schedule->exists()) {
			$msg = array('response' => 0, 'msg' => array(__('Invalid schedule')));
			$this->Session->setFlash(__('SInvalid schedule'), 'Flash/admin_error');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Schedule->saveAll($this->request->data)) {
				$msg = array('response' => 1, 'msg' => array(__('Schedule updated')));
				$this->Session->setFlash(__('The schedule has been saved'), 'Flash/admin_success');
				$redirect = true;
			} else {
				$this->Session->setFlash(__('The schedule could not be saved. Please, try again.'), 'Flash/admin_error');
			}
		} else {
			$this->request->data = $this->Schedule->read(null, $id);
		}
		if($this->RequestHandler->isAjax()){
			echo json_encode($msg);
		} else {
			if ($redirect) {
				$this->redirect(array('action' => 'index'));
			}
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->layout = 'ajax';
		$this->autoRender = false;
		$this->Schedule->id = $id;
		if (!$this->Schedule->exists()) {
			$msg = array('response' => 0, 'msg' => array(__('Invalid schedule')));
			$this->Session->setFlash(__('Invalid schedule'), 'Flash/admin_error');
		}
		$data = $this->Schedule->read(null, $id);
		if ($data && $this->Schedule->deleteAll(array('Schedule.id' => $id), true)) {
			if ($data['Schedule']['uploaded'] == 1) {
				$this->MessageEngine = $this->Components->load('MessageEngine');
				foreach ($data['ScheduleFrame'] as $f) {
					$this->MessageEngine->setSchedule($data['Sign']['me_id'], '00', $f['_scheduleid']);
				}
			}
			$msg = array('response' => 1, 'msg' => array(__('Schedule deleted')));
			$this->Session->setFlash(__('Schedule deleted'), 'Flash/admin_success');
		} else {
			$msg = array('response' => 0, 'msg' => array(__('Schedule was not deleted')));
			$this->Session->setFlash(__('Schedule was not deleted'), 'Flash/admin_error');
		}
		if($this->RequestHandler->isAjax()){
			echo json_encode($msg);
		} else {
			$this->redirect(array('action' => 'index'));
		}
	}
	
	
	public function ajaxupload($id = null){
		$this->layout = 'ajax';
		$this->autoRender = false;
		$this->Schedule->id = $id;
		if($this->RequestHandler->isAjax()){
			if (!$this->Schedule->exists()) {
				$msg = array('response' => 0, 'msg' => array(__('Invalid Schedule.')));
			} else {
				$schd = $this->Schedule->getFrames($id, $this->Session->read('Auth.User.company_id'));
				if ($schd) {
					$data = array();
					$this->MessageEngine = $this->Components->load('MessageEngine');
					foreach ($schd['ScheduleFrame'] as $f) {
						$this->Schedule->ScheduleFrame->id = $f['id'];
						/*
						if (empty($f['hex'])){
							// create hex string, save to db and load here
							$f['hex'] = $this->createHex($f['image']);
						}
						*/
						if (empty($f['_sign_frameid'])) {
							$f['_sign_frameid'] = $this->MessageEngine->setGraphicsFrame($schd['Sign']['me_id'], explode('|', $f['hex']), $f['_frameid']);
							$this->Schedule->ScheduleFrame->saveField('_sign_frameid', implode(',', $f['_sign_frameid']));
						} else {
							// we still want to send it anyway...
							$this->MessageEngine->setGraphicsFrame($schd['Sign']['me_id'], explode('|', $f['hex']), $f['_frameid']);
						}
						if (!is_array($f['_sign_frameid'])) {
							$f['_sign_frameid'] = implode(',', $f['_sign_frameid']);
						}
						if (empty($f['_sign_msgid'])) {
							$f['_sign_msgid'] = $this->MessageEngine->setMessage($schd['Sign']['me_id'], $f['_sign_frameid']);
							$this->Schedule->ScheduleFrame->saveField('_sign_msgid', $f['_sign_msgid']);
						} else {
							// we still want to send it anyway...
							$this->MessageEngine->setMessage($schd['Sign']['me_id'], $f['_sign_frameid']);
						}
						$data[] = array(
							'id' => $f['id'],
							'me_id' => $schd['Sign']['me_id'],
							'msg_id' => $f['_sign_msgid'],
							's_id' => $f['_scheduleid'],
							'ontime' => $f['duration'],
							'start' => $schd['Schedule']['start'],
							'end' => $schd['Schedule']['end'],
							'transition' => $f['transition']
						);
					}	
					if (!empty($data)) {
						foreach ($data as $d) {
							$schedule = $this->MessageEngine->setSchedule($d['me_id'], $d['msg_id'], $d['s_id'], $d['start'], $d['end'], $d['ontime'], $d['transition']);
							$this->Schedule->ScheduleFrame->id = $d['id'];
							$this->Schedule->ScheduleFrame->saveField('_sign_scheduleid', $schedule);
						}
						$msg = array('response' => 1, 'msg' => array(__('Schedule updated.')));
						$this->Schedule->saveField('uploaded', 1);
					}
				} else {
					$msg = array('response' => 0, 'msg' => array(__('Sign was not found.')));
				}
			}
			echo json_encode($msg);
		}
	}
	
	public function removeframe($id = false) {
		$this->layout = 'ajax';
		$this->autoRender = false;
		$this->Schedule->ScheduleFrame->id = $id;
		if($this->RequestHandler->isAjax()){
			if (!$this->Schedule->ScheduleFrame->exists()) {
				$msg = array('response' => 0, 'msg' => array(__('Invalid Frame.')));
			} else {
				if ($this->Schedule->ScheduleFrame->delete()) {
					$msg = array('response' => 1, 'msg' => array(__('Scheduled frame was successfully removed.')));
				} else {
					$msg = array('response' => 0, 'msg' => array(__('Frame was not removed from the schedule.')));
				}
			}
			echo json_encode($msg);
		}
	}
	
	public function reorderframes() {
		if($this->RequestHandler->isAjax()){
			$this->layout = 'ajax';
			$this->autoRender = false;
			if (!empty($this->request->data['frames'])) {
				foreach ($this->request->data['frames'] as $order => $id) {
					$data['ScheduleFrame'][$order]['id'] = $id;
					$data['ScheduleFrame'][$order]['ordering'] = $order;
				}
				if ($this->Schedule->ScheduleFrame->saveMany($data['ScheduleFrame'])) {
					$msg = array('response' => 1, 'msg' => array(__('Frame order updated.')));
				} else {
					$msg = array('response' => 0, 'msg' => array(__('Frame order was not updated.')));
				}
				echo json_encode($msg);
			}
		}
	}
	
	private function createHex($image = false) {
		if ($image) {
			
		}
		return false;
	}
	
}
