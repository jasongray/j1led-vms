<?php
App::uses('AppModel', 'Model');
/**
 * SignImage Model
 *
 * @property Company $Company
 * @property SignType $SignType
 */
class SignImage extends AppModel {
	
	public $validate = array(
		'name' => array(
			'rule'       => 'notEmpty',
			'required'   => true,
			'allowEmpty' => false,
			'message'    => 'A name for this frame is required'
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
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
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
        'SignType' => array(
			'className' => 'SignType',
			'joinTable' => 'sign_image_types',
			'foreignKey'  => 'sign_image_id',
			'associationForeignKey' => 'sign_type_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
        )
	);
	
	public function getImagesbySignType($sign_type_id = null, $company_id = false) {
		if(empty($sign_type_id)) return false;
		$db = $this->getDataSource();
		$subQuery = $db->buildStatement(
			array(
				'fields' => array('SignImageType.sign_image_id'),
				'table' => 'sign_image_types',
				'alias' => 'SignImageType',
				'conditions' => array('SignImageType.sign_type_id' => $sign_type_id),
			),
			$this->SignImage
		);
		$subQuery = 'SignImage.id IN ('.$subQuery.')';
		$conditions = $db->expression($subQuery);
		$this->recursive = -1;
		$conditions2 = ($company_id)? array('SignImage.company_id' => $company_id): array('OR' => array('SignImage.company_id IS NULL', 'SignImage.company_id = 0'));
	    $images = $this->find('all', array('conditions' => array($conditions->value, $conditions2), 'group' => 'SignImage.id'));
	    return $images;
    }

}
