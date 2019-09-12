<?php
App::uses('AppModel', 'Model');
/**
 * Schedule Model
 *
 * @property Frames $Frame
 */
class Schedule extends AppModel {
	
	public $actsAs = array('Containable');
		
	public $validate = array(
		'title' => array(
			'rule'       => 'notEmpty',
			'required'   => true,
			'allowEmpty' => false,
			'message'    => 'A name for this schedule is required'
		)
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Sign' => array(
			'className' => 'Sign',
			'foreignKey' => 'sign_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'company_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	
/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasMany = array(
        'ScheduleFrame' => array(
			'className' => 'ScheduleFrame',
			'foreignKey' => 'schedule_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);	
	
	public function beforeSave($options = array()) {
		if (!empty($this->data['Schedule']['daterange'])) {
			$_date = explode('-', str_replace(' ', '', $this->data['Schedule']['daterange']));
			$this->data['Schedule']['start'] = strtotime(str_replace('/', '-', $_date[0]) . ' ' . strtolower($this->data['Schedule']['starttime']));
			$this->data['Schedule']['end'] = strtotime(str_replace('/', '-', $_date[1]) . ' ' . strtolower($this->data['Schedule']['endtime']));
		}
		unset($this->data['Schedule']['daterange']);
		unset($this->data['Schedule']['starttime']);
		unset($this->data['Schedule']['endtime']);
		return true;
	}
	
	public function getSchedules ($sign_id = false, $company_id = '0') {
		$conditions = array();
		if(!empty($company_id)) $conditions[] = array('Schedule.company_id' => $company_id);
		if(!empty($sign_id)) $conditions[] = array('Schedule.sign_id' => $sign_id);
		return $this->find('all', array('conditions' => $conditions, 'order' => array('Schedule.start' => 'DESC')));
	}
	
	public function getCurrentFrames ($sign_id = false, $company_id = '0') {
		if(!$sign_id) return false;
		$this->recursive = -1;
		$joins = array(
			array(
				'table' => 'sign_images',
				'alias' => 'SignImage',
				'type' => 'INNER',
				'conditions'=> array('ScheduleFrame.frame_id = SignImage.id')
			)
		);
		$conditions = (!empty($company_id))? $conditions = array('Schedule.company_id' => $company_id): array();
		$conditions = array_merge(array('Schedule.uploaded' => 1, 'Schedule.sign_id' => $sign_id, '(NOW() BETWEEN FROM_UNIXTIME(Schedule.start) AND FROM_UNIXTIME(Schedule.end))'), $conditions);
		$schedule = $this->find('first', array('conditions' => $conditions, 'order' => array('Schedule.start' => 'DESC'), 'group' => 'Schedule.id'));
		if(!$schedule) return false;
		$this->ScheduleFrame->recursive = -1;
		$this->ScheduleFrame->virtualFields = array('image' => 'SignImage.image');
		return $this->ScheduleFrame->find('all', array('fields' => array('*'), 'conditions' => array('ScheduleFrame.schedule_id' => $schedule['Schedule']['id'], 'ScheduleFrame.frame_id <> 0'), 'joins' => $joins, 'order' => array('ScheduleFrame.ordering' => 'ASC'), 'group' => 'ScheduleFrame.frame_id'));
	}
	
	public function getFrames ($schedule_id = false, $company_id = '0') {
		if(!$schedule_id) return false;
		$conditions = array('Schedule.id' => $schedule_id);
		$conditions = (!empty($company_id))? $conditions = array_merge(array('Schedule.company_id' => $company_id), $conditions): $conditions;
		$joins = array(
			array(
				'table' => 'sign_images',
				'alias' => 'SignImage',
				'type' => 'INNER',
				'conditions'=> array('ScheduleFrame.frame_id = SignImage.id')
			)
		);
		//$this->recursive = -1;
		//$this->id = $schedule_id;
		$schedule = $this->find('first', array('conditions' => $conditions, 'order' => array('Schedule.start' => 'DESC'), 'group' => 'Schedule.id'));
		if(!$schedule) return false;
		// create custom input fields for form
		if (!empty($schedule['Schedule']['start']) || !empty($schedule['Schedule']['end'])) {
			$schedule['Schedule']['daterange'] = date('d/m/Y', $schedule['Schedule']['start']) . ' - ' . date('d/m/Y', $schedule['Schedule']['end']); // 01/09/2013 - 31/01/2014
			$schedule['Schedule']['starttime'] = date('h:i A', $schedule['Schedule']['start']); // 04:00 PM
			$schedule['Schedule']['endtime'] = date('h:i A', $schedule['Schedule']['end']); // 04:00 PM
		}
		$this->ScheduleFrame->recursive = 0;
		$this->ScheduleFrame->virtualFields = array('image' => 'SignImage.image', 'name' => 'SignImage.name', 'hex' => 'SignImage.hexstring');
		$scheduleframes = $this->ScheduleFrame->find('all', array('conditions' => array('ScheduleFrame.schedule_id' => $schedule_id, 'ScheduleFrame.frame_id <> 0'), 'joins' => $joins, 'order' => array('ScheduleFrame._scheduleid' => 'ASC'), 'group' => 'ScheduleFrame.frame_id'));
		$_frames = array();
		if (!empty($scheduleframes)) {
			for ($i=0;$i<count($scheduleframes);$i++){
				$_frames['ScheduleFrame'][$i] = $scheduleframes[$i]['ScheduleFrame'];
			}
		}
		return array_merge($schedule, $_frames);
	}	
	
	public function getCurrentSchedules ($sign_id = false, $company_id = '0') {
		if(!$sign_id) return false;
		$conditions = array('Schedule.company_id' => $company_id, 'Schedule.sign_id' => $sign_id, 'Schedule.uploaded = 0');
		//$conditions = array_merge(array('Schedule.sign_id' => $sign_id, "IF(Schedule.end IS NOT NULL, FROM_UNIXTIME(Schedule.end) > NOW(), '')"), $conditions);
		return $this->find('all', array('conditions' => $conditions, 'order' => array('Schedule.start' => 'DESC')));
	}
	
	public function getUploadedSchedules ($sign_id = false, $company_id = '0') {
		if(!$sign_id) return false;
		$conditions = array('Schedule.company_id' => $company_id, 'Schedule.sign_id' => $sign_id, 'Schedule.uploaded = 1');
		//$conditions = array_merge(array('Schedule.sign_id' => $sign_id, "IF(Schedule.end IS NOT NULL, FROM_UNIXTIME(Schedule.end) > NOW(), '')"), $conditions);
		return $this->find('all', array('conditions' => $conditions, 'order' => array('Schedule.start' => 'DESC')));
	}
	
	public function getCounts ($sign_id = false, $company_id = '0') {
		if(!$sign_id) return false;
		$this->ScheduleFrame->recursive = -1;
		$this->ScheduleFrame->virtualFields = array();
		$firstresults = $this->ScheduleFrame->find('all', array('conditions' => array('ScheduleFrame.sign_id' => $sign_id, 'ScheduleFrame._sign_frameid IS NOT NULL')));
		$frame_count = 0;
		if ($firstresults) {
			foreach ($firstresults as $r) {
				$_frames = explode(',', $r['ScheduleFrame']['_sign_frameid']);
				$frame_count = count($_frames) + $frame_count;
			}
		}
		$this->ScheduleFrame->virtualFields = array('frame_count' => 'COUNT(ScheduleFrame._sign_frameid)', 'message_count' => 'COUNT(ScheduleFrame._sign_msgid)', 'schedule_count' => 'COUNT(ScheduleFrame._sign_scheduleid)');
		$finalresults = $this->ScheduleFrame->find('first', array('fields' => array('message_count', 'schedule_count'), 'conditions' => array('ScheduleFrame.sign_id' => $sign_id), 'group' => 'ScheduleFrame.sign_id'));
		if ($finalresults) {
			$finalresults['ScheduleFrame']['frame_count'] = $frame_count;
		} else {
			$finalresults = array('ScheduleFrame' => 
				array(
					'frame_count' => 0,
					'message_count' => 0,
					'schedule_count' => 0
				)
			);
		}
		return $finalresults;
	}
	
}