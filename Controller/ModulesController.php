<?php
App::uses('AppController', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
/**
 * Modules Controller
 *
 * @property Module $Module
 */
class ModulesController extends AppController {
	
	public function beforeFilter() {
	    parent::beforeFilter();
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Module->recursive = 0;
		$this->paginate = array(
			'order' => array('Module.position' => 'ASC', 'Module.ordering' => 'ASC'),
			'limit' => 20
		);
		$this->set('modules', $this->paginate());
	}
/**
 * cancel method
 *
 * @param string $id
 * @return void
 */
	public function cancel($id = null) {
		$this->Session->setFlash(__('Operation cancelled'), 'Flash/admin_info');
		$this->redirect(array('action' => 'index'));
	}
	
/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Module->recursive = 0;
			$_m = $this->Module->find('first', array(
				'fields' => array(
					'MAX(Module.ordering) as max_size'
				), 
				'conditions' => array(
					'Module.position' => $this->request->data['Module']['position']
				)
			));
			$this->request->data['Module']['ordering'] = $_m[0]['max_size'] + 1;
			if ($this->request->data['Module']['menus'] == 0) {
				$this->request->data['Module']['menuselections'] = $this->getAllMenuItems();
			}
			if ($this->request->data['Module']['menus'] == 1) {
				$this->request->data['Module']['menuselections'] = array();
			}
			$this->request->data['Module']['menuselections'] = implode('|', $this->request->data['Module']['menuselections']);
			$this->Module->create();
			if ($this->Module->save($this->request->data)) {
				$this->Session->setFlash(__('The module has been saved'), 'Flash/admin_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The module could not be saved. Please, try again.'), 'Flash/admin_error');
			}
		}
		if (!isset($this->request->data['Module']['menuselections'])) {
			$selected = array();
		} else {
			$selected = $this->request->data['Module']['menuselections'];
		}
		$this->set(compact('selected'));
		$this->set('positions', $this->getModulePositions());
		$this->set('modfiles', $this->getModuleFiles());
		$this->set('menus', $this->getModuleMenus());
		$this->set('menuselections', $this->getModuleMenusitems());
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Module->id = $id;
		if (!$this->Module->exists()) {
			throw new NotFoundException(__('Invalid module'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {		
			if ($this->request->data['Module']['menus'] == 0) {
				$this->request->data['Module']['menuselections'] = $this->getAllMenuItems();
			}
			if ($this->request->data['Module']['menus'] == 1) {
				$this->request->data['Module']['menuselections'] = array();
			}
			$this->request->data['Module']['menuselections'] = implode('|', $this->request->data['Module']['menuselections']);
			
			if ($this->Module->save($this->request->data)) {
				$this->Session->setFlash(__('The module has been saved'), 'Flash/admin_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The module could not be saved. Please, try again.'), 'Flash/admin_error');
			}
		} else {
			$this->request->data = $this->Module->read(null, $id);
			$this->request->data['Module']['menuselections'] = explode('|', $this->request->data['Module']['menuselections']);
		}
		$this->set('positions', $this->getModulePositions());
		$this->set('modfiles', $this->getModuleFiles());
		$this->set('menus', $this->getModuleMenus());
		$this->set('menuselections', $this->getModuleMenusitems());
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Module->id = $id;
		if (!$this->Module->exists()) {
			throw new NotFoundException(__('Invalid module'));
		}
		if ($this->Module->delete()) {
			$this->Session->setFlash(__('Module deleted'), 'Flash/admin_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Module was not deleted'), 'Flash/admin_error');
		$this->redirect(array('action' => 'index'));
	}
	
	
/**
 * orderup method
 *
 * @param string $id
 * @return void
 */
	public function orderup($id = false){
		if($id){
			$this->ordering(-1, $id);
		}
	}

/**
 * orderdown method
 *
 * @param string $id
 * @return void
 */	
	public function orderdown($id = false){
		if($id){
			$this->ordering(1, $id);
		}
	}
	
/**
 * saveorder method
 *
 * @return void
 */
	public function saveorder(){
		$this->reorder();
	}
	
	private function ordering( $dir, $id ){
		
		$this->Module->recursive = -1;
		$_this = $this->Module->find('first', array('conditions' => array('Module.id' => $id)));
		
		if($dir < 0){
			$options = array(
				'conditions' => array(
					'Module.ordering < ' . $_this['Module']['ordering'],
					'Module.position' => $_this['Module']['position']
				), 
				'order' => 'Module.ordering DESC',
				'limit' => 1
			);
		}else{
			$options = array(
				'conditions' => array(
					'Module.ordering > ' . $_this['Module']['ordering'],
					'Module.position' => $_this['Module']['position']
				),
				'order' => 'Module.ordering ASC',
				'limit' => 1
			);
		}
		
		$_row = $this->Module->find('first', $options);
		
		if($_row){
			$this->Module->id = $id;
			$this->Module->saveField('ordering', $_row['Module']['ordering']);
			$this->Module->id = $_row['Module']['id'];
			$this->Module->saveField('ordering', $_this['Module']['ordering']);
		}else{
			$this->Module->id = $id;
			$this->Module->saveField('ordering', $_this['Module']['ordering']);
		}
		$this->reorder($_this['Module']['position']);
		$this->redirect(array('action' => 'index'));
			
	}
	
	private function reorder($pos){
		
		$this->Module->recursive = -1;
		$_m = $this->Module->find('all', array(
			'conditions' => array(
				'Module.ordering >= 0',
				'Module.position' => $pos
			),
			'order' => 'Module.ordering'
		));
		
		if($_m){
			
			for ($i=0, $n=count($_m); $i < $n; $i++){
				if($_m[$i]['Module']['ordering'] >= 0){
					if($_m[$i]['Module']['ordering'] != $i+1){
						$_m[$i]['Module']['ordering'] = $i+1;
						$this->Module->id = $_m[$i]['Module']['id'];
						$this->Module->saveField('ordering', $_m[$i]['Module']['ordering']);
					}
				}
			}
			
		}
		
	}
	
	private function getModulePositions() {
		$_folder = (isset($this->theme))? 'Themed' . DS . $this->theme . DS . 'Modules': 'Modules';
		$_folder = APP . DS . 'View' . DS . $_folder;
		$dir = new Folder($_folder);
		$files = $dir->find('modules.ini');
		if ($files) {
			$modules = array();
			foreach ($files as $file) {
			    $file = new File($_folder . DS . $file);
			    $contents = $file->read();
			    $file->close(); 
			    $contents = preg_replace('/\/\*(.*)\*\//', '', $contents);
			    $_modules = preg_split("/[\s,]+/", $contents);
			    asort($_modules);
			    foreach ($_modules as $m) {
			    	$modules[$m] = $m;
			    }
			}
			return $modules;
		} else {
			$this->Session->setFlash(__('You are missing the modules.ini file. Please create the file with the required modules and save into the ' . $_folder . ' directory.'), 'Flash/admin_error');
		}
		return array();
	}
	
	private function getModuleMenusitems() {
		$this->loadModel('Menu');
		$menu = $this->Menu->find('all', array('conditions' => array('Menu.published' => 1)));
		$options = array();
		if ($menu) {
			foreach ($menu as $m) {
				if (!empty($m['MenuItem'])) {
					foreach ($m['MenuItem'] as $mi) {
						$options[$m['Menu']['title']][$mi['id']] = $mi['title'];
					}
				}
			}
		}
		return $options;
	}
	
	private function getModuleFiles() {
		$_folder = (isset($this->theme))? 'Themed' . DS . $this->theme . DS . 'Modules': 'Modules';
		$dir = new Folder(APP . 'View' . DS . $_folder);
		$files = $dir->find('.*\.php');
		if ($files) {
			$modules = array();
			foreach ($files as $file) {
				$modules[$file] = preg_replace('/\.php/', '', $file);
			}
			return $modules;
		} 
		return array();
	}
	
	private function getModuleMenus() {
		$this->loadModel('Menu');
		$menu = $this->Menu->findAllByPublished(1);
		$options = array();
		if ($menu) {
			foreach ($menu as $m) {
				if (!empty($m['Menu'])) {
					$options[$m['Menu']['id']] = $m['Menu']['title'];
				}
			}
		}
		return $options;
	}
	
	private function getAllMenuItems() {
		$this->loadModel('Menu');
		$menu = $this->Menu->findAllByPublished(1);
		$options = array();
		if ($menu) {
			foreach ($menu as $m) {
				if (!empty($m['MenuItem'])) {
					foreach ($m['MenuItem'] as $mi) {
						$options[] = $mi['id'];
					}
				}
			}
		}
		return $options;
	}

}
