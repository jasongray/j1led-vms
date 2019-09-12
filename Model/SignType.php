<?php
App::uses('AppModel', 'Model');
/**
 * SignType Model
 *
 * @property SignType $ParentSignType
 * @property SignType $ChildSignType
 * @property User $User
 */
class SignType extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Sign' => array(
			'className' => 'Sign',
			'foreignKey' => 'sign_type_id',
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
	
/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
        'SignColour' => array(
			'className' => 'SignColour',
			'joinTable' => 'sign_colour_types',
			'foreignKey'  => 'sign_type_id',
			'associationForeignKey' => 'sign_colour_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
        ),
        'SignColourOverlay' => array(
			'className' => 'SignColourOverlay',
			'joinTable' => 'sign_colour_overlays',
			'foreignKey'  => 'sign_type_id',
			'associationForeignKey' => 'sign_colour_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => 'SELECT `SignColour`.`id`, `SignColour`.`rta_code`, `SignColour`.`title`, `SignColour`.`created`, `SignColour`.`modified`, `SignColourOverlay`.`sign_type_id`, `SignColourOverlay`.`sign_colour_id` FROM `sign_colours` AS `SignColour` JOIN `sign_colour_overlays` AS `SignColourOverlay` ON (`SignColourOverlay`.`sign_type_id` = {$__cakeID__$} AND `SignColourOverlay`.`sign_colour_id` = `SignColour`.`id`) ',
			'deleteQuery' => '',
			'insertQuery' => ''
        )
	);

}
