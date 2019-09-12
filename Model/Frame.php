<?php
App::uses('AppModel', 'Model');
/**
 * Frame Model
 *
 * @property Frame $Frame
 */
class Frame extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

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
		)
	);

}
