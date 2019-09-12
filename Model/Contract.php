<?php
App::uses('AppModel', 'Model');
/**
 * Contract Model
 *
 * @property Sign $Sign
 */
class Contract extends AppModel {
	
	public $findMethods = array('active' =>  true);
	
	public $validate = array(
		'sign_id' => array(
			'rule'       => 'notEmpty',
			'required'   => true,
			'allowEmpty' => false,
			'message'    => 'Please select a sign'
		),
		'company_id' => array(
			'rule'       => 'notEmpty',
			'required'   => true,
			'allowEmpty' => false,
			'message'    => 'Please select a company'
		)
	);
	
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'company_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Sign' => array(
			'className' => 'Sign',
			'foreignKey' => 'sign_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SignType' => array(
			'className' => 'SignType',
			'foreignKey' => '',
			'conditions' => 'SignType.id = Sign.sign_type_id',
			'fields' => '',
			'order' => ''
		),
	);


	public function noConflict($data = array()) {
		$start_date = date('Y-m-d H:i:s', strtotime($data['Contract']['on_hire_date']));
		$end_date = date('Y-m-d H:i:s', strtotime($data['Contract']['off_hire_date']));
		$conditions = sprintf("Contract.sign_id = %d AND (('%s' BETWEEN Contract.on_hire_date AND Contract.off_hire_date) OR ('%s' BETWEEN Contract.on_hire_date AND Contract.off_hire_date))", $data['Contract']['sign_id'], $start_date, $end_date);
		$this->recursive = -1;
		$result = $this->find('first', array('conditions' => $conditions));
		if (empty($result)) {
			return true;
		}
		return false;
	}
	
	public function beforeSave($options = array()) {
		if (!empty($this->data['Contract']['on_hire_date'])) {
			$this->data['Contract']['on_hire_date'] = date('Y-m-d H:i:s', strtotime($this->data['Contract']['on_hire_date']));
		}
		if (!empty($this->data['Contract']['off_hire_date'])) {
			$this->data['Contract']['off_hire_date'] = date('Y-m-d H:i:s', strtotime($this->data['Contract']['off_hire_date']));
		}
		return true;
	}
	
	protected function _findActive($state, $query, $results = array()) {
        if ($state === 'before') {
            $query['conditions'] = array('(CURDATE() BETWEEN Contract.on_hire_date AND Contract.off_hire_date) OR (CURDATE() BETWEEN Contract.on_hire_date AND Contract.off_hire_date)');
            return $query;
        }
        return $results;
    }
    
    public function getCurrentContracts ($id = false) {
    	if(!$id) return false;
    	return $this->find('all', array('conditions' => array('Contract.sign_id' => $id, 'CURDATE() BETWEEN Contract.on_hire_date AND Contract.off_hire_date OR CURDATE() < Contract.on_hire_date'), 'order' => array('on_hire_date' => 'ASC')));
    }


}
