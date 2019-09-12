<?php
App::uses('AppModel', 'Model');
/**
 * Sign Model
 *
 * @property SignType $SignType
 * @property Client $Client
 */
class Sign extends AppModel {

	public $findMethods = array('signlist' => true);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'SignType' => array(
			'className' => 'SignType',
			'foreignKey' => 'sign_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Tcpip' => array(
			'className' => 'Tcpip',
			'foreignKey' => 'tcpip_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Serial' => array(
			'className' => 'Serial',
			'foreignKey' => 'serial_id',
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
		)
	);
	
/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Contract' => array(
			'className' => 'Contract',
			'foreignKey' => 'sign_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'CustomField' => array(
			'className' => 'CustomField',
			'foreignKey' => 'sign_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Schedule' => array(
			'className' => 'Schedule',
			'foreignKey' => 'sign_id',
			'dependent' => false,
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
	
	protected function _findSignlist($state, $query, $results = array()) {
		if ($state == 'before') {
			// set these up
			
			if (isset($query[0])){
				$query['conditions'] = $query[0]['conditions'];
				$query['limit'] = $query[0]['limit'];
			}
			
			//$this->unbindModel(array('hasMany' => array('Schedule')));
			
			$joins = array(
				array(
					'table' => 'sign_images',
					'alias' => 'SignImage',
					'type' => 'INNER',
					'conditions'=> array('ScheduleFrame.frame_id = SignImage.id')
				)
			);
			
			$_db = $this->getDataSource();
			$_subq = $_db->buildStatement(
				array(
					'fields' => array('id'),
					'table' => 'schedules',
					'alias' => 'Schedule',
					'conditions' => array('NOW() BETWEEN FROM_UNIXTIME(Schedule.start) AND FROM_UNIXTIME(Schedule.end) AND Schedule.uploaded = 1'),
					'order' => array('Schedule.start' => 'DESC'), 
					'group' => 'Schedule.id',
				),
				$this
			);
			
			$this->bindModel(array(
				'hasMany' => array(
					'ScheduleFrame' => array(
						'foreignKey' => 'sign_id',
						'conditions'=> array('ScheduleFrame.schedule_id IN (' . $_subq . ')', 'ScheduleFrame.frame_id <> 0'),
						'order' => 'ScheduleFrame.ordering ASC', 
						'group' => 'ScheduleFrame.frame_id',
					),
				)
			));
			$this->ScheduleFrame->virtualFields = array('image' => '(SELECT SignImage.image FROM sign_images AS SignImage WHERE ScheduleFrame.frame_id = SignImage.id)');		
			return $query;
			
		}
		
		return $results;
		
	}

	public function lock($id = false, $userid) {
		if ($id) {
			$this->updateAll(array('Sign.locked' => '1', 'Sign.locked_by' => $userid), array('Sign.id' => $id));
		}
	}
	
	public function unlock($id = false) {
		if ($id) {
			$this->updateAll(array('Sign.locked' => '0'), array('Sign.id' => $id));
		}
	}
	
}
