<?php
App::uses('AppModel', 'Model');
/**
 * Company Model
 *
 * @property CompanyItem $CompanyItem
 */
class Company extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
	
	public $validate = array(
		'name' => array(
			'rule'       => 'notEmpty',
			'required'   => true,
			'allowEmpty' => false,
			'message'    => 'Please enter the company name'
		),
		
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'company_id',
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
		'Contract' => array(
			'className' => 'Contract',
			'foreignKey' => 'company_id',
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
		'CustomLabel' => array(
			'className' => 'CustomLabel',
			'foreignKey' => 'company_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);
	
	
	public function beforeSave($options = array()) {
		if (!empty($this->data['CustomLabel'])) {
			for($i=0;$i<count($this->data['CustomLabel']);$i++){
				$k = $this->data['CustomLabel'][$i];
				if (empty($k['CustomLabel']['text'])) {
					unset($this->data['CustomLabel'][$i]);
				}
			}
		}
		return true;
	}

}
