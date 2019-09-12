<?php
App::uses('AppModel', 'Model');
/**
 * SignColour Model
 *
 * @property SignColour $ParentSignColour
 */
class SignColour extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';
	
	
	public function getColoursbySignType ($sign_type_id = false) {
		if(empty($sign_type_id)) return false;
		$db = $this->getDataSource();
		$subQuery = $db->buildStatement(
			array(
				'fields' => array('SignColourType.sign_colour_id'),
				'table' => 'sign_colour_types',
				'alias' => 'SignColourType',
				'conditions' => array('SignColourType.sign_type_id' => $sign_type_id),
			),
			$this->SignImage
		);
		$subQuery = 'SignColour.id IN ('.$subQuery.')';
		$conditions = $db->expression($subQuery);
		$this->recursive = -1;
	    $images = $this->find('all', array('conditions' => $conditions->value, 'group' => 'SignColour.id'));
	    return $images;
	}

}