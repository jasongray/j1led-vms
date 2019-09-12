<?php
App::uses('AppModel', 'Model');
/**
 * MenuItem Model
 *
 * @property Menu $Menu
 */
class MenuItem extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';
	
	public $actsAs = array('Tree');

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Menu' => array(
			'className' => 'Menu',
			'foreignKey' => 'menu_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
