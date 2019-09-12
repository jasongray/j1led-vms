<?php
App::uses('AppModel', 'Model');
/**
 * Module Model
 *
 */
class Module extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';
	
	
	public function getModules($position = false, $params = array()) {
		if ($position) {
			if (!isset($params['id'])) {
				$params['id'] = 0;
			}
			$_conditions = array("IF(Module.menus = 2, Module.menuselections LIKE '%{$params['id']}%', Module.menus = 0)");
			$_conditions = array_merge(array('Module.published' => 1, 'Module.position' => $position), $_conditions);
			return $this->find('all', array('conditions' => $_conditions, 'order' => 'Module.ordering ASC'));
		}
	}
}
