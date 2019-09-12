<?php
App::uses('AppController', 'Controller');
App::uses('File', 'Utility');
/**
 * Signs Controller
 *
 * @property Sign $Sign
 */
class SignsController extends AppController {
	
	var $helpers = array('Googlemap');

	var $components = array('Googlemap');
	
	public $paginate = array(
		'limit' => 10,
	); 

	public function beforeFilter() {
	    parent::beforeFilter();
	}

/**
 * dashboard method
 *
 * @return void
 */
	public function dashboard() {
		$this->set('title_for_layout', __('Dashboard'));
		
		if ($this->Session->read('Auth.User.group_id') < 3) {
			
			$this->set('sign_count', $this->Sign->find('count', array('conditions' => array('enabled' => 1))));
			
			$this->loadModel('Company');
			$this->set('client_count', $this->Company->find('count'));
			
			$this->loadModel('Contract');
			$this->set('contract_count', $this->Contract->find('count', array('conditions' => array('(CURDATE() BETWEEN Contract.on_hire_date AND Contract.off_hire_date) OR (CURDATE() BETWEEN Contract.on_hire_date AND Contract.off_hire_date)'))));
			
			$this->loadModel('User');
			$this->set('user_count', $this->User->usage());
			
			$this->loadModel('ActivityLog');
			$this->set('log', $this->ActivityLog->find('all', array('limit' => 10, 'order' => array('ActivityLog.created' => 'DESC'))));
			
			
		} else {
			
			if ($this->Acl->check(array('User' => array('id' => $this->Session->read('Auth.User.id'))), 'Signs/edit')){
				$editable = true;
			} else {
				$editable = false;
			}
			$this->set('editable', $editable);
			
			$_view = $this->Session->read('Auth.User.Company.default_view');
			if (isset($this->request->params['named']['view'])) {
				$_view = $this->request->params['named']['view'];
			}
			
			$this->Sign->recursive = 1;
			$_conditions = array('Sign.company_id' => $this->Session->read('Auth.User.company_id'));
			$_limit = ($_view == 'map')? 5: '';
			
			$this->paginate = array('signlist');
			$this->Paginator->settings = array(
				'conditions' => $_conditions, 
				'limit' => $_limit
			);
			$this->set('signs', $this->Paginator->paginate());
			
			$this->loadModel('CustomLabel');
			$this->set('labels', $this->CustomLabel->findAllByCompanyId($this->Session->read('Auth.User.company_id')));
			
			$file = new File(APP . DS . 'View' . DS . 'Signs' . DS . $_view . '.ctp');
			if (!empty($_view) && $file->exists()) {
				$this->render($_view);
			} else {
				$this->render('list');
			}
			
		}
		
	}
		
/**
 * index method
 *
 * @return void
 */
	public function index() {
		//$this->Sign->recursive = 0;
		
		$_conditions = array();
		if ($this->Session->read('Auth.User.company_id')) {
			$_conditions = array('Sign.company_id' => $this->Session->read('Auth.User.company_id'));
		}
		
		$_view = $this->Session->read('Auth.User.Company.default_view');
		if (isset($this->request->params['named']['view'])) {
			$_view = $this->request->params['named']['view'];
		}
		//$_limit = ($_view == 'map')? 5: '';
		switch ($_view) {
			case 'list': default:
			$_limit = 10; break;
			case 'grid':
			$_limit = 16; break;
			case 'map':
			$_limit = 5; break;
		}
		
		if (isset($this->request->params['named']['limit'])) {
			$_limit = $this->request->params['named']['limit'];
		}
		
		$this->paginate = array('signlist');
		$this->Paginator->settings = array(
			'conditions' => $_conditions, 
			'limit' => $_limit
		);
		$this->set('signs', $this->Paginator->paginate());
		
		if ($this->Acl->check(array('User' => array('id' => $this->Session->read('Auth.User.id'))), 'Signs/edit')){
			$editable = true;
		} else {
			$editable = false;
		}
		$this->set('editable', $editable);
		
		$viewfile = APP . DS . 'View' . DS . 'Signs' . DS . $_view . '.ctp';
		$file = new File($viewfile);
		if (!empty($_view) && $file->exists()) {
			$this->render($viewfile);
		}
		
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Sign->id = $id;
		if (!$this->Sign->exists()) {
			$this->Session->setFlash(__('Invalid sign'), 'Flash/admin_error');
			$this->redirect(array('action' => 'index'));
		}
		$this->set('sign', $this->Sign->read(null, $id));
		
		$company_id = $this->Session->read('Auth.User.company_id');
		
		$contracts = $this->Sign->Contract->getCurrentContracts($id);
		$this->loadModel('CustomLabel');
		$customlabels = $this->CustomLabel->getCustomFields($id, $company_id);
		$this->set(compact('contracts', 'customlabels'));
		
		$this->loadModel('Schedule');
		$this->set('frames', $this->Schedule->getCurrentFrames($id, $company_id));
		
		if ($this->Acl->check(array('User' => array('id' => $this->Session->read('Auth.User.id'))), 'Signs/edit')){
			$editable = true;
		} else {
			$editable = false;
		}
		$this->set('editable', $editable);
		
	}



/**
 * frames method
 *
 * @param string $id
 * @return void
 */
	public function frames($id = null) {
		$this->Sign->id = $id;
		if (!$this->Sign->exists()) {
			$this->Session->setFlash(__('Invalid sign'), 'Flash/admin_error');
			$this->redirect(array('action' => 'index'));
		}
		$sign = $this->Sign->read(null, $id);
		$this->set('s', $sign);
		$this->set('title_for_layout', __('Sign Dashboard') . ' ' . $sign['Sign']['name']);
		$this->request->data['SignImage']['width'] = $sign['SignType']['width'];
		$this->request->data['SignImage']['height'] = $sign['SignType']['height'];
		
		$this->loadModel('SignImage');
		$this->set('predefined', $this->SignImage->getImagesbySignType($sign['Sign']['sign_type_id']));
		
		if ($c_id = $this->Session->read('Auth.User.company_id')) {
			$custom = $this->SignImage->getImagesbySignType($sign['Sign']['sign_type_id'], $c_id);
		} else {
			$custom = array();
		}
		$this->set('custom', $custom);
		
		$this->loadModel('Schedule');
		$this->set('schedules', $this->Schedule->getCurrentSchedules($id, $this->Session->read('Auth.User.company_id')));
		$this->set('uploadedschedules', $this->Schedule->getUploadedSchedules($id, $this->Session->read('Auth.User.company_id')));
		$this->set('count', $this->Schedule->getCounts($id, $this->Session->read('Auth.User.company_id')));
		$this->set('frames', $this->Schedule->getCurrentFrames($id, $this->Session->read('Auth.User.company_id')));
		
		$this->loadModel('SignColour');
		$this->set('ledcolours', $this->SignColour->getColoursbySignType($sign['Sign']['sign_type_id']));
		
		$this->loadModel('CustomLabel');
		$this->set('customlabels', $this->CustomLabel->getCustomFields($id, $this->Session->read('Auth.User.company_id')));
		
		if ($this->Acl->check(array('User' => array('id' => $this->Session->read('Auth.User.id'))), 'Signs/edit')){
			$editable = true;
		} else {
			$editable = false;
		}
		$this->set('editable', $editable);
		$this->Sign->lock($id, $this->Session->read('Auth.User.id'));
		
	}


/**
 * ajax method
 *
 * @param string $id
 * @return void
 */
	public function ajax($id = null) {
		$this->Sign->id = $id;
		if (!$this->Sign->exists()) {
			$this->Session->setFlash(__('Invalid sign'), 'Flash/admin_error');
			$this->redirect(array('action' => 'index'));
		}
		$this->set('s', $this->Sign->read(null, $id));
		
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Sign->create();
			if (!empty($this->request->data['Sign']['geocodeme'])) {
				$geocode = $this->Googlemap->geocode($this->request->data['Sign']['address']);
				if ($geocode) {
					$this->request->data['Sign']['lat'] = $geocode['lat'];
					$this->request->data['Sign']['lng'] = $geocode['lng'];
				}
			}
			/*
			if ($this->request->data['Sign']['geo_fence_enable'] != $this->request->data['Sign']['geo_fence_enable_value'] && !empty($this->request->data['Sign']['me_id'])) {
				$this->MessageEngine = $this->Components->load('MessageEngine');
				$this->MessageEngine->enableGeoFence($this->request->data['Sign']['me_id'], $this->request->data['Sign']['geo_fence_enable']);
				if ($this->request->data['Sign']['geo_fence_radius'] != $this->request->data['Sign']['geo_fence_radius_value'] && !empty($this->request->data['Sign']['me_id'])) {
					$this->MessageEngine->setGeoFence($this->request->data['Sign']['me_id'], $this->request->data['Sign']['geo_fence_radius']);
				}
				unset($this->request->data['Sign']['geo_fence_enable_value']);
				unset($this->request->data['Sign']['geo_fence_radius_value']);
			}
			*/
			if ($this->Sign->saveAll($this->request->data)) {
				$this->log(__('New sign created.') . ' (' . $this->Sign->id . ')', 'info', 'activity');
				$this->Session->setFlash(__('The sign has been saved'), 'Flash/admin_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sign could not be saved. Please, try again.'), 'Flash/admin_error');
			}
		}
		$companies = $this->Sign->Company->find('list');
		$signTypes = $this->Sign->SignType->find('list');
		$this->loadModel('CustomLabel');
		$customlabels = $this->CustomLabel->find('all', array('conditions' => array('CustomLabel.company_id' => $this->Session->read('Auth.User.company_id'))));
		$this->set(compact('signTypes', 'companies', 'customlabels'));
		if ($this->Session->read('Auth.User.group_id') < 3) {
			$this->render('admin_add');
		} 
		
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$company_id = $this->Session->read('Auth.User.company_id');
		$this->Sign->id = $id;
		if (!$this->Sign->exists()) {
			throw new NotFoundException(__('Invalid sign'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if (!empty($this->request->data['Sign']['geocodeme'])) {
				$geocode = $this->Googlemap->geocode($this->request->data['Sign']['address']);
				if ($geocode) {
					$this->request->data['Sign']['lat'] = $geocode['lat'];
					$this->request->data['Sign']['lng'] = $geocode['lng'];
				}
			}
			/*
			if ($this->request->data['Sign']['geo_fence_enable'] != $this->request->data['Sign']['geo_fence_enable_value'] && !empty($this->request->data['Sign']['me_id'])) {
				$this->MessageEngine = $this->Components->load('MessageEngine');
				$this->MessageEngine->enableGeoFence($this->request->data['Sign']['me_id'], $this->request->data['Sign']['geo_fence_enable']);
				if ($this->request->data['Sign']['geo_fence_radius'] != $this->request->data['Sign']['geo_fence_radius_value'] && !empty($this->request->data['Sign']['me_id'])) {
					$this->MessageEngine->setGeoFence($this->request->data['Sign']['me_id'], $this->request->data['Sign']['geo_fence_radius']);
				}
				unset($this->request->data['Sign']['geo_fence_enable_value']);
				unset($this->request->data['Sign']['geo_fence_radius_value']);
			}
			*/
			if ($this->Sign->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The sign has been saved'), 'Flash/admin_success');
				$this->Sign->unlock($id);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sign could not be saved. Please, try again.'), 'Flash/admin_error');
			}
		} else {
			$this->request->data = $this->Sign->read(null, $id);
		}
		$companies = $this->Sign->Company->find('list');
		$signTypes = $this->Sign->SignType->find('list');
		$contracts = $this->Sign->Contract->getCurrentContracts($id);
		$this->loadModel('CustomLabel');
		$customlabels = $this->CustomLabel->findAllByCompanyId($company_id);
		$this->set(compact('signTypes', 'companies', 'contracts', 'customlabels'));
		
		$this->loadModel('Schedule');
		$this->set('frames', $this->Schedule->getCurrentFrames($id, $company_id));
		$this->set('count', $this->Schedule->getCounts($id, $company_id));
		
		
		if ($this->Session->read('Auth.User.group_id') < 3) {
			$this->render('admin_edit');
		} 
		
		$this->Sign->lock($id, $this->Session->read('Auth.User.id'));
		
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Sign->id = $id;
		$this->autoRender = false;
		if (!$this->Sign->exists()) {
			throw new NotFoundException(__('Invalid sign'));
		}
		$s = $this->Sign->read();
		if ($this->Sign->delete()) {
			$this->log(__('Sign deleted.') . ' (' . $s['Sign']['name'] . ')', 'important', 'activity');
			// then check for schedules and delete them too
			$this->loadModel('Schedule');
			$this->Schedule->recursive = -1;
			$schedule = $this->Schedule->findAllBySignId($id);
			if (!empty($schedule)) {
				$this->Schedule->deleteAll(array('Schedule.sign_id' => $id));
				if (count($schedule) > 1) {
					foreach ($schedule as $f) {
						$_f[] = $f['Schedule']['id'];
					}
					$schedules = implode(',', $_f);
				} else {
					$schedules = $schedule['Schedule']['id'];
				}
				$this->Schedule->ScheduleFrame->deleteAll(array('ScheduleFrame.schedule_id IN (' . $schedules . ')'));
			}
			$this->Session->setFlash(__('Sign deleted'), 'Flash/admin_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Sign was not deleted'), 'Flash/admin_error');
		$this->redirect(array('action' => 'index'));
		
	}
	
/**
 * cancel method
 *
 * @param string $id
 * @return void
 */
	public function cancel($id = null) {
		$this->Sign->unlock($id);
		$this->Session->setFlash(__('Operation cancelled', true), 'Flash/admin_info');
		$this->redirect(array('action' => 'index'));
	}


/**
 * query sign method
 *
 * @params string $id
 * @return array
 */
	public function querySign($id = null) {
		if($this->RequestHandler->isAjax()) {
			$this->layout = 'ajax';
			$this->autoRender = false;
			$function = (isset($this->request->params['named']['function'])) ?$this->request->params['named']['function']:'';
			
			$this->MessageEngine = $this->Components->load('MessageEngine');
			
			if ($this->request->data['Sign']['geo_fence_enable'] != $this->request->data['Sign']['geo_fence_enable_value']) {
				$this->MessageEngine = $this->Components->load('MessageEngine');
				$this->MessageEngine->enableGeoFence($id, $this->request->data['Sign']['geo_fence_enable']);
			}
			if ($this->request->data['Sign']['geo_fence_radius'] != $this->request->data['Sign']['geo_fence_radius_value'] && !empty($this->request->data['Sign']['me_id'])) {
				$this->MessageEngine->setGeoFence($id, $this->request->data['Sign']['geo_fence_radius']);
			}
			unset($this->request->data['Sign']['geo_fence_enable_value']);
			unset($this->request->data['Sign']['geo_fence_radius_value']);
			$this->Sign->updateAll($this->request->data['Sign'], array('Sign.me_id' => $id));
			switch ($function) {
				case 'gps':
					if ($this->MessageEngine->getGPS($id)) {
						$msg = array('response' => 1, 'msg' => array(__('GPS request sent.')));
					}
				break;
				case 'battery':
					if ($this->MessageEngine->getVoltage($id)) {
						$msg = array('response' => 1, 'msg' => array(__('Battery voltage request sent.')));
					}
				break;
				case 'setgeo':
					if ($this->MessageEngine->setGeoFence($id, $this->request->params['named']['geo_fence_radius'])) {
						$msg = array('response' => 1, 'msg' => array(__('GEO Fence radius set.')));
					}
				break;
				case 'enablegeo':
					if ($this->MessageEngine->enableGeoFence($id, 1)) {
						$msg = array('response' => 1, 'msg' => array(__('GEO Fence enabled.')));
					}
				break;
				case 'disablegeo':
					if ($this->MessageEngine->enableGeoFence($id, 0)) {
						$msg = array('response' => 1, 'msg' => array(__('GEO Fence disabled.')));
					}
				break;
				default:
					$this->MessageEngine->getGPS($id);
					$this->MessageEngine->getVoltage($id);
					$msg = array('response' => 1, 'msg' => array(''));
				break;
			}
			echo json_encode($msg);
		} else {
			$this->Session->setFlash(__('Cannot access this method via this request.', true), 'Flash/admin_info');
			$this->redirect(array('action' => 'index'));
		}
	}
	
	public function ajaxreset($id = null){
		$this->layout = 'ajax';
		$this->autoRender = false;
		$this->Sign->id = $id;
		if($this->RequestHandler->isAjax()) {
			if (!$this->Sign->exists()) {
				$msg = array('response' => 0, 'msg' => array(__('Invalid Sign Id.')));
			} else {
				$schd = $this->Sign->read(null, $id);
				if ($schd) {
					$level =(isset($this->request->data['level']))? $this->request->data['level']: '';
					$this->MessageEngine = $this->Components->load('MessageEngine');
					if ($this->MessageEngine->reset($schd['Sign']['me_id'], $level)) {
						if ($level == '03' || $level == '255') {
							$this->loadModel('Schedule');
							$this->Schedule->updateAll(array('uploaded' => 'NULL'), array('sign_id' => $id));
							$this->Schedule->ScheduleFrame->updateAll(array('_sign_frameid' => 'NULL', '_sign_msgid' => 'NULL', '_sign_scheduleid' => 'NULL'), array('sign_id' => $id));
						}
						$msg = array('response' => 1, 'msg' => array(__('Reset command successfully sent.')));
					} else {
						$msg = array('response' => 0, 'msg' => array(__('Reset command not sent to Message Engine.')));	
					}		
				} else {
					$msg = array('response' => 0, 'msg' => array(__('Sign was not found.')));
				}
			}
			echo json_encode($msg);
		}
	}
	
	public function ajaxclear($id = null){
		$this->layout = 'ajax';
		$this->autoRender = false;
		$this->Sign->id = $id;
		if($this->RequestHandler->isAjax()){
			if (!$this->Sign->exists()) {
				$msg = array('response' => 0, 'msg' => array(__('Invalid Schedule.')));
			} else {
				$schd = $this->Sign->read(null, $id);
				if ($schd) {
					$this->MessageEngine = $this->Components->load('MessageEngine');
					if ($this->MessageEngine->clearSchedule($schd['Sign']['me_id'])) {
						$this->loadModel('Schedule');
						$this->Schedule->updateAll(array('uploaded' => 'NULL'), array('sign_id' => $id));
						$msg = array('response' => 1, 'msg' => array(__('Schedule successfully cleared.')));
					} else {
						$msg = array('response' => 0, 'msg' => array(__('Command not sent to Message Engine.')));	
					}		
				} else {
					$msg = array('response' => 0, 'msg' => array(__('Sign was not found.')));
				}
			}
			echo json_encode($msg);
		}
	}
}