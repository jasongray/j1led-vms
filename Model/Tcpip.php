<?php
App::uses('AppModel', 'Model');
/**
 * Tcpip Model
 *
 * @property Sign $Sign
 */
class Tcpip extends AppModel {
	
	var $useTable = 'tcpip';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Sign' => array(
			'className' => 'Sign',
			'foreignKey' => 'tcpip_id',
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
