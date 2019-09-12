<?php
App::uses('AppModel', 'Model');
/**
 * CustomField Model
 *
 * @property Sign $Sign
 */
class CustomField extends AppModel {
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
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
		)
	);

}
