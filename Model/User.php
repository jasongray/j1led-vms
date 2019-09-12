<?php
App::uses('AppModel', 'Model');
App::uses('Security', 'Utility');
/**
 * User Model
 *
 * @property UserStatus $UserStatus
 * @property Group $Group
 */
class User extends AppModel {
	
	public $validate = array(
		'email' => array(
			'rule'       => 'email',
			'required'   => true,
			'allowEmpty' => false,
			'message'    => 'A valid email address is required'
		),
		'username' => array(
			'rule'       => 'notEmpty',
			'required'   => true,
			'allowEmpty' => false,
			'message'    => 'Please enter a username'
		),
		
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
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

	var $actsAs = array('Acl' => array('type' => 'requester'));
	
	function parentNode() {
		if (!$this->id && empty($this->data)) {
			return null;
		}
		if (isset($this->data['User']['group_id'])) {
			$groupId = $this->data['User']['group_id'];
		} else {
			$groupId = $this->field('group_id');
		}
		if (!$groupId) {
			return null;
		} else {
			return array('Group' => array('id' => $groupId));
		}
	}

	public function beforeSave($options = array()) {
		if (isset($this->data['User']['password']) && !empty($this->data['User']['password'])) {
			$this->data['User']['password'] = Security::hash($this->data['User']['password'], 'blowfish');
	    } else {
			unset($this->data['User']['password']);
		}
	    return true;
	}
	
	public function usage() {
		$_data = $this->find('all', array('fields' => array('User.id', 'User.username', 'User.last_login', 'User.created'), 'conditions' => array('User.is_active' => 1, 'User.group_id > 2')));
		$_start_date = strtotime('2013-04-01 00:00:00'); // estimated start date of project
		$_end_date = strtotime(date('Y-m-d'));
		$_sum = 0;
		$_test = array();
		if ($_data) {
			for ($i=0;$i<count($_data);$i++) {
				$u = $_data[$i];
				$_test[$i]['lastlogin-created'] = (strtotime($u['User']['last_login']) - strtotime($u['User']['created'])) / 86400; // convert to days
				$_test[$i]['end-lastlogin'] = ($_end_date - strtotime($u['User']['last_login'])) / 86400;
				$_test[$i]['end-start'] = ($_end_date - $_start_date) / 86400;
				if (empty($u['User']['last_login'])) {
					$_test[$i]['end-lastlogin'] = $_test[$i]['end-start'];
				}
				$_test[$i]['percent'] = round((1 - ($_test[$i]['end-lastlogin'] / $_test[$i]['end-start'])) * 100, 4);
				$_sum = $_sum + $_test[$i]['percent'];
			}
		}
		return $_sum / count($_data);
	}

}
