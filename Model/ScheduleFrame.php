<?php
App::uses('AppModel', 'Model');
/**
 * ScheduleFrame Model
 *
 * @property Menu $Menu
 */
class ScheduleFrame extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Schedule' => array(
			'className' => 'Schedule',
			'foreignKey' => 'schedule_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	
	public function beforeSave($options = array()) {
		if (!isset($this->data['ScheduleFrame']['_frameid']) || empty($this->data['ScheduleFrame']['_frameid'])) {
			$this->data['ScheduleFrame']['_frameid'] = $this->getNextFrameID($this->data['ScheduleFrame']['sign_id']);
		}
		if (!isset($this->data['ScheduleFrame']['_scheduleid']) || empty($this->data['ScheduleFrame']['_scheduleid'])) {
			$this->data['ScheduleFrame']['_scheduleid'] = $this->getNextScheduleID($this->data['ScheduleFrame']['sign_id']);
		}
	    return true;
	}
	
	public function afterSave($created, $options = array()) {
		if ($created) {
			if (!empty($this->data['ScheduleFrame']['frame_id']) && !empty($this->data['ScheduleFrame']['sign_id'])) {
				$_result = $this->find('first', array('conditions' => array(
					'ScheduleFrame.frame_id' => $this->data['ScheduleFrame']['frame_id'], 
					'ScheduleFrame.sign_id' => $this->data['ScheduleFrame']['sign_id'], 
					'ScheduleFrame._sign_frameid IS NOT NULL'))
				);
				if (!empty($_result)) {
					$this->id = $this->data['ScheduleFrame']['id'];
					$_data['_sign_frameid'] = $_result['ScheduleFrame']['_sign_frameid'];
					$_data['_frameid'] = $_result['ScheduleFrame']['_frameid'];
					$this->save($_data);
				}
			}
		}
	}
	
	public function getNextFrameID($sign_id = false) {
		if ($sign_id) {
			$this->recursive = -1;
			$this->virtualFields = array('nextID' => '(MAX(ScheduleFrame._frameid) + 1)');
			$_result = $this->find('first', array('conditions' => array('ScheduleFrame.sign_id' => $sign_id), 'order' => array('ScheduleFrame._frameid DESC')));
			if ($_result) {
				if ($_result['ScheduleFrame']['nextID'] < 256) {
					if ($_result['ScheduleFrame']['nextID'] > 160) {
						return $_result['ScheduleFrame']['nextID'];
					} else {
						return 161;  // minimum frame id
					}
				}
			} else {
				return 161;  // minimum frame id
			}
		}
		return false;
	}
	
	public function getNextScheduleID($sign_id = false) {
		if ($sign_id) {
			$this->recursive = -1;
			$this->virtualFields = array('nextID' => '(MAX(ScheduleFrame._scheduleid) + 1)');
			$_result = $this->find('first', array('conditions' => array('ScheduleFrame.sign_id' => $sign_id), 'order' => array('ScheduleFrame._scheduleid DESC')));
			if ($_result && isset($_result['ScheduleFrame']['nextID'])) {
				if ($_result['ScheduleFrame']['nextID'] < 256) {
					if ($_result['ScheduleFrame']['nextID'] == 0) {
						return 1;  // minimum schedule id
					} else {
						return $_result['ScheduleFrame']['nextID'];
					}
				}
			} else {
				return 1;  // minimum schedule id
			}
		}
		return false;
	}

}
