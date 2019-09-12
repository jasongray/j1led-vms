<?php
App::uses('AppModel', 'Model');
/**
 * Serial Model
 *
 * @property Sign $Sign
 */
class Serial extends AppModel {
	
	var $useTable = 'serial';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Sign' => array(
			'className' => 'Sign',
			'foreignKey' => 'serial_id',
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

}
