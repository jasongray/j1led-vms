<?php
App::uses('AppModel', 'Model');

class System extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = '';
	
/**
 * useTable field
 *
 * @var string
 */
	var $useTable = 'system';

/**
 * getVer method
 * 
 * Returns the current version number of the CMS
 *
 * @return string
 */
	public function getVer() {
		$_data = $this->find('first', array('fields' => 'val', 'conditions' => array('var' => 'version')));
		return $_data['System']['val'];
	}
	
/**
 * getFolder method
 * 
 * Returns the update folder on the server for this CMS
 *
 * @return string
 */
	public function getFolder() {
		$_data = $this->find('first', array('fields' => 'val', 'conditions' => array('var' => 'update_folder')));
		return (!empty($_data['System']['val']))? $_data['System']['val'] . '/': '';
	}
	
}
