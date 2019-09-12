<?php
App::uses('AppModel', 'Model');
/**
 * CustomLabel Model
 *
 * @property Sign $Sign
 */
class CustomLabel extends AppModel {
	
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
		)
	);
	
	
			
	public function getCustomFields($sign_id = false, $company_id = false) {
		if(empty($sign_id)) return false;
		$conditions = ($company_id)? array('CustomField.company_id' => $company_id): array();
		$this->unbindModel(array('belongsTo' => array('Company')));
		$this->bindModel(
			array('hasOne' => array(
                'CustomField' => array(
                    'className'    => 'CustomField',
                    'foreignKey'   => 'custom_label_id',
                    'conditions'   => array('CustomField.sign_id' => $sign_id, '(CustomField.sign_id IS NOT NULL OR CustomField.sign_id <> 0)', $conditions),
                    'dependent'    => true
                	)
            	)
        	)
		);
	    return $this->find('all', array('conditions' => array('OR' => array('CustomLabel.text IS NOT NULL', "CustomLabel.text <> ''")), 'order' => 'CustomLabel.text ASC', 'group' => 'CustomField.id'));
	}

}
