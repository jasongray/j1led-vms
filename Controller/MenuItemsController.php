<?php
App::uses('AppController', 'Controller');
/**
 * MenuItems Controller
 *
 * @property MenuItem $MenuItem
 */
class MenuItemsController extends AppController {

	var $components = array('Googlemap');
	
	public function beforeFilter() {
	    parent::beforeFilter();
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		
		$id = $this->request->params['named']['menu_id'];
		if (!$id) {
			$this->Session->setFlash(__('Invalid menu selected', true), 'Flash/admin_error');
			$this->redirect($this->referer());
		}
		$this->MenuItem->recursive = -1;
		$this->paginate = array(
			'conditions' => array(
				'MenuItem.menu_id' => $id,
				'MenuItem.editable' => 1
			),
			'limit' => 9999,
			'order' => 'MenuItem.lft ASC'
		);
		
		$rows = $this->paginate();
		$children = array();
		foreach ($rows as $v ){
			$pt = !empty($v['MenuItem']['parent'])? $v['MenuItem']['parent']: 0;
			$list = @$children[$pt] ? $children[$pt] : array();
			array_push( $list, $v );
			$children[$pt] = $list;
		}
		
		$list = $this->recurse( 0, '', array(), $children, max( 0, 10 ) );
		$list = array_values($list);
		$this->set('menuItems', $list);
		
		$menu_title = $this->MenuItem->Menu->findByMenuId($this->request->params['named']['menu_id']);
		$this->set(compact('menu_title'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->MenuItem->recursive = 0;
			$this->request->data['MenuItem']['named'] = '';
			$this->request->data['MenuItem']['alias'] = Inflector::slug(strtolower($this->request->data['MenuItem']['title']), '-');
			$this->request->data['MenuItem']['controller'] = strtolower($this->request->data['MenuItem']['controller']);
			$this->request->data['MenuItem']['action'] = (isset($this->request->data['MenuItem']['action']))? strtolower($this->request->data['MenuItem']['action']): 'index';
			if($this->request->data['MenuItem']['controller'] === 'pages'){
				$this->request->data['MenuItem']['slug'] = $this->request->data['MenuItem']['action'];
				$this->request->data['MenuItem']['action'] = 'display';
			}elseif($this->request->data['MenuItem']['controller'] === 'products'){
				$this->request->data['MenuItem']['slug'] = $this->request->data['MenuItem']['action'];
				$this->request->data['MenuItem']['action'] = 'view';
			}elseif($this->request->data['MenuItem']['controller'] === 'categories'){
				if($this->request->data['MenuItem']['action'] == '0' || empty($this->request->data['MenuItem']['action'])){
					$this->request->data['MenuItem']['action'] = 'index';
				}else{
					$this->request->data['MenuItem']['slug'] = $this->request->data['MenuItem']['action'];
					$this->request->data['MenuItem']['action'] = 'view';
				}
			}elseif($this->request->data['MenuItem']['controller'] === 'assets'){
				$this->request->data['MenuItem']['slug'] = $this->request->data['MenuItem']['action'];
				$this->request->data['MenuItem']['action'] = 'download';
			}elseif($this->request->data['MenuItem']['controller'] === 'projects'){
				if (is_numeric($this->request->data['MenuItem']['action'])) {
					$this->request->data['MenuItem']['named'] = 'category:'.$this->request->data['MenuItem']['action'];
				}
				$this->request->data['MenuItem']['action'] = 'index';
			}
			if(empty($this->request->data['MenuItem']['action'])){
				$this->request->data['MenuItem']['action'] = 'index';
			}
			if(!empty($this->request->data['MenuItem']['named'])){
				$this->request->data['MenuItem']['slug'] = '';
			}
			if (!empty($this->request->data['MenuItem']['params']['address_string'])) {
				$geocode = $this->Googlemap->geocode($this->request->data['MenuItem']['params']['address_string']);
				if ($geocode) {
					$this->request->data['MenuItem']['params']['lat'] = $geocode['lat'];
					$this->request->data['MenuItem']['params']['lng'] = $geocode['lng'];
				}
			}
			$this->request->data['MenuItem']['params'] = json_encode($this->request->data['MenuItem']['params']);
			$this->MenuItem->create();
			if ($this->MenuItem->save($this->request->data)) {
				$this->Session->setFlash(__('The menu item has been saved', true), 'Flash/admin_success');
				$this->redirect(array('action' => 'index', 'menu_id' => $this->request->data['MenuItem']['menu_id']));
			} else {
				$this->Session->setFlash(__('The menu item could not be saved. Please, try again.', true), 'Flash/admin_error');
			}
		}
		$links = $this->findControllers();
		$slugs = array();
		$_slug = '';
		$menus = $this->MenuItem->Menu->find('list');
		$parents = $this->MenuItem->generateTreeList(array('MenuItem.menu_id' => $this->request->params['named']['menu_id']));
		$this->set(compact('menus', 'parents', 'links', 'slugs', '_slug'));
		$this->setGroups();
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->MenuItem->id = $id;
		if (!$this->MenuItem->exists()) {
			throw new NotFoundException(__('Invalid menu item'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['MenuItem']['named'] = '';
			$this->request->data['MenuItem']['alias'] = Inflector::slug(strtolower($this->request->data['MenuItem']['title']), '-');
			$this->request->data['MenuItem']['controller'] = strtolower($this->request->data['MenuItem']['controller']);
			$this->request->data['MenuItem']['action'] = strtolower( $this->request->data['MenuItem']['action']);
			if($this->request->data['MenuItem']['controller'] === 'pages'){
				$this->request->data['MenuItem']['slug'] = $this->request->data['MenuItem']['action'];
				$this->request->data['MenuItem']['action'] = 'display';
			}elseif($this->request->data['MenuItem']['controller'] === 'products'){
				$this->request->data['MenuItem']['slug'] = $this->request->data['MenuItem']['action'];
				$this->request->data['MenuItem']['action'] = 'view';
			}elseif($this->request->data['MenuItem']['controller'] === 'categories'){
				if($this->request->data['MenuItem']['action'] == '0' || empty($this->request->data['MenuItem']['action'])){
					$this->request->data['MenuItem']['action'] = 'index';
				}else{
					$this->request->data['MenuItem']['slug'] = $this->request->data['MenuItem']['action'];
					$this->request->data['MenuItem']['action'] = 'view';
				}
			}elseif($this->request->data['MenuItem']['controller'] === 'assets'){
				$this->request->data['MenuItem']['slug'] = $this->request->data['MenuItem']['action'];
				$this->request->data['MenuItem']['action'] = 'download';
			}elseif($this->request->data['MenuItem']['controller'] === 'projects'){
				if (is_numeric($this->request->data['MenuItem']['action'])) {
					$this->request->data['MenuItem']['named'] = 'category:'.$this->request->data['MenuItem']['action'];
				}
				$this->request->data['MenuItem']['action'] = 'index';
			}
			if(empty($this->request->data['MenuItem']['action'])){
				$this->request->data['MenuItem']['action'] = 'index';
			}
			if(!empty($this->request->data['MenuItem']['named'])){
				$this->request->data['MenuItem']['slug'] = '';
			}
			if (!empty($this->request->data['MenuItem']['params']['address_string']) && empty($this->request->data['MenuItem']['params']['lat']) && empty($this->request->data['MenuItem']['params']['lng'])) {
				$geocode = $this->Googlemap->geocode($this->request->data['MenuItem']['params']['address_string']);
				if ($geocode) {
					$this->request->data['MenuItem']['params']['lat'] = $geocode['lat'];
					$this->request->data['MenuItem']['params']['lng'] = $geocode['lng'];
				}
			}
			$this->request->data['MenuItem']['params'] = json_encode($this->request->data['MenuItem']['params']);
			if ($this->MenuItem->save($this->request->data)) {
				$this->Session->setFlash(__('The menu item has been saved', true), 'Flash/admin_success');
				$this->redirect(array('action' => 'index', 'menu_id' => $this->request->data['MenuItem']['menu_id']));
			} else {
				$this->Session->setFlash(__('The menu item could not be saved. Please, try again.', true), 'Flash/admin_error');
			}
		} else {
			$this->request->data = $this->MenuItem->read(null, $id);
			$this->request->data['MenuItem']['params'] = json_decode($this->request->data['MenuItem']['params'], true);
		}
		$links = $this->findControllers();
		$slugs = $this->findViews($this->request->data['MenuItem']['controller']);
		if ($this->request->data['MenuItem']['controller'] == 'projects') {
			$_slug = (int)str_replace('category:', '', $this->request->data['MenuItem']['named']);
		} else {
			$_slug = $this->request->data['MenuItem']['slug'];
		}
		$menus = $this->MenuItem->Menu->find('list');
		$parents = $this->MenuItem->generateTreeList(array('MenuItem.menu_id' => $this->request->params['named']['menu_id']));
		$this->set(compact('menus', 'parents', 'links', 'slugs', '_slug'));
		$this->setGroups();
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->MenuItem->id = $id;
		if (!$this->MenuItem->exists()) {
			throw new NotFoundException(__('Invalid menu item'));
		}
		if ($this->MenuItem->delete()) {
			$this->Session->setFlash(__('Menu item deleted'), 'Flash/admin_success');
		} else {
			$this->Session->setFlash(__('Menu item was not deleted'), 'Flash/admin_error');
		}
		$this->redirect(array('action' => 'index', 'menu_id' => $this->request->params['named']['menu_id']));
	}
	
/**
 * cancel method
 *
 * @param string $id
 * @return void
 */
	public function cancel($id = null) {
		$this->Session->setFlash(__('Operation cancelled', true), 'Flash/admin_info');
		$this->redirect(array('action' => 'index', 'menu_id' => $this->request->params['named']['menu_id']));
	}

	
	public function orderup($id = false){
		$this->autoRender = false;
		$menu_id = $this->request->params['named']['menu_id'];
		if($id){
			$this->MenuItem->moveUp($id, 1);
		}
		$this->redirect(array('action' => 'index', 'menu_id' => $menu_id));
	}
	
	public function orderdown($id = false){
		$this->autoRender = false;
		$menu_id = $this->request->params['named']['menu_id'];
		if($id){
			$this->MenuItem->moveDown($id, 1);
		}
		$this->redirect(array('action' => 'index', 'menu_id' => $menu_id));
	}
	
	public function saveorder(){
		$data = $this->MenuItem->find('threaded');
        pr($data); die;
	}
	
	public function getViews(){
		
		$this->layout = 'ajax';
		if(isset($this->request->params['named']['method'])){
			$this->set('options', $this->findViews($this->request->params['named']['method']));
		}
	}
	
	private function ordering( $dir, $id ){
		
		$menu_id = $this->request->params['named']['menu_id'];
		$this->MenuItem->recursive = -1;
		$_this = $this->MenuItem->find('first', array('conditions' => array('MenuItem.id' => $id)));
		
		if($dir < 0){
			$options = array(
				'conditions' => array(
					'MenuItem.parent' => $this->request->params['named']['parent'],
					'MenuItem.ordering < ' . $_this['MenuItem']['ordering'],
					'MenuItem.menu_id' => $menu_id
				), 
				'order' => 'MenuItem.ordering DESC',
				'limit' => 1
			);
		}else{
			$options = array(
				'conditions' => array(
					'MenuItem.parent' => $this->request->params['named']['parent'],
					'MenuItem.ordering > ' . $_this['MenuItem']['ordering'],
					'MenuItem.menu_id' => $menu_id
				),
				'order' => 'MenuItem.ordering ASC',
				'limit' => 1
			);
		}
		
		$_row = $this->MenuItem->find('first', $options);
		
		if($_row){
			$this->MenuItem->id = $id;
			$this->MenuItem->saveField('ordering', $_row['MenuItem']['ordering']);
			$this->MenuItem->id = $_row['MenuItem']['id'];
			$this->MenuItem->saveField('ordering', $_this['MenuItem']['ordering']);
		}else{
			$this->MenuItem->id = $id;
			$this->MenuItem->saveField('ordering', $_this['MenuItem']['ordering']);
		}
		$this->reorder();
		$this->Session->setFlash(__('Menu ordering has been updated'), 'Flash/admin_success');
		$this->redirect(array('action' => 'index', 'menu_id' => $menu_id));
			
	}
	
	private function reorder(){
		
		$menu_id = $this->request->params['named']['menu_id'];
		$this->MenuItem->recursive = -1;
		$_m = $this->MenuItem->find('all', array(
			'conditions' => array(
				'MenuItem.ordering >=0',
				'MenuItem.menu_id' => $menu_id
			),
			'order' => 'MenuItem.ordering'
		));
		
		if($_m){
			
			for ($i=0, $n=count($_m); $i < $n; $i++){
				if($_m[$i]['MenuItem']['ordering'] >= 0){
					if($_m[$i]['MenuItem']['ordering'] != $i+1){
						$_m[$i]['MenuItem']['ordering'] = $i+1;
						$this->MenuItem->id = $_m[$i]['MenuItem']['id'];
						$this->MenuItem->saveField('ordering', $_m[$i]['MenuItem']['ordering']);
					}
				}
			}
			
		}
		
	}
	
	private function recurse( $id, $indent, $list, &$children, $maxlevel=9999, $level=0, $type=1 ){
		if (@$children[$id] && $level <= $maxlevel)
		{
			foreach ($children[$id] as $v)
			{
				$id = $v['MenuItem']['id'];

				if ( $type ) {
					$pre 	= '<sup>|_</sup>&nbsp;';
					$spacer = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				} else {
					$pre 	= '- ';
					$spacer = '...';
				}

				$pt = !empty($v['MenuItem']['parent_id'])? $v['MenuItem']['parent_id']: 0;
				if ( $pt == 0 ) {
					$txt 	= $v['MenuItem']['title'];
				} else {
					$txt 	= $pre . $spacer . $v['MenuItem']['title'];
				}
				
				$list[$id]['MenuItem'] = $v['MenuItem'];
				$list[$id]['MenuItem']['treename'] = "$indent$txt";
				$list[$id]['MenuItem']['treename'] = $this->ampReplace($list[$id]['MenuItem']['treename']);
				$list[$id]['MenuItem']['treename'] = str_replace('"', '&quot;', $list[$id]['MenuItem']['treename']);
				$list[$id]['MenuItem']['children'] = count( @$children[$id] );
				$list = $this->recurse( $id, $indent . $spacer, $list, $children, $maxlevel, $level+1, $type );
			}
		}
		return $list;
	}
	
	private function ampReplace( $text ){
		$text = str_replace( '&&', '*--*', $text );
		$text = str_replace( '&#', '*-*', $text );
		$text = str_replace( '&amp;', '&', $text );
		$text = preg_replace( '|&(?![\w]+;)|', '&amp;', $text );
		$text = str_replace( '*-*', '&#', $text );
		$text = str_replace( '*--*', '&&', $text );
		
		return $text;
	}
	
	private function findControllers(){
		App::uses('Sanitize', 'Utility');
		App::uses('Folder', 'Utility');
		App::uses('Inflector', 'Utility');
		$_path = ROOT . DS . APP_DIR . DS . 'Controller' . DS;
		$_folder = new Folder($_path);
		$_ignore = array(
			'AppController.php', 
			'ConfigController.php',
			'GroupsController.php',
			'AdvertsController.php',
			'MenusController.php', 
			'MenuItemsController.php',
			'ModulesController.php', 
			'FormsController.php', 
			'ImagesController.php',
			'SlideshowsController.php',
			'TagsController.php', 
			'VisitsController.php',
			'Component',
			'empty', 
			'.DS_Store');
		$_list = $_folder->read(true, $_ignore);
		//$_path = Sanitize::escape($_path);
		$_f = array();
		foreach($_list[1] as $f){
			$_name = str_replace("Controller.php", '', str_replace($_path, '', $f));
			$_f[strtolower($_name)] = Inflector::humanize($_name);
		}
		return $_f;
	}
	
	private function findViews( $folder = false ){
		
		switch ($folder){
			case 'Pages':case 'pages':
				$this->loadModel('Page');
				return $this->Page->find('list', array('fields' => array('Page.id', 'Page.title'), 'conditions' => array('Page.published' => 1)));
			break;
			case 'Assets':case 'assets':
				$this->loadModel('Asset');
				return $this->Asset->find('list', array('fields' => array('Asset.id', 'Asset.title'), 'conditions' => array('Asset.published' => 1)));
			break;
			case 'Categories':case 'categories':
				$this->loadModel('Category');
				$_list = $this->Category->find('list', array('fields' => array('Category.id', 'Category.title'), 'conditions' => array('Category.published' => 1)));
				return $_list;
			break;
			case 'Projects':case 'projects':
				$this->loadModel('Category');
				$_list = $this->Category->find('list', array('fields' => array('Category.id', 'Category.title'), 'conditions' => array('Category.published' => 1)));
				return $_list;
			break;
			case 'Products':case 'products':
				$this->loadModel('Product');
				return $this->Product->find('list', array('fields' => array('Product.id', 'Product.title'), 'conditions' => array('Product.published' => 1)));
			break;
			default:
				App::uses('Sanitize', 'Utility');
				App::uses('Folder', 'Utility');
				$_path = ROOT . DS . APP_DIR . DS . 'View' . DS . $folder . DS;
				$_folder = new Folder($_path);
				$_ignore = array(
					'admin_index.ctp',
					'admin_images.ctp', 
					'admin_add.ctp',
					'admin_edit.ctp', 
					'admin_dashboard.ctp',
					'Errors',
					'Emails',
					'Elements', 
					'Groups',
					'Helper',
					'Layouts',
					'Menu',
					'MenuItems',
					'Modules',
					'Scaffolds',
					'Components',
					'.DS_Store');
				$_list = $_folder->tree($_path, $_ignore);
				//$_path = Sanitize::escape($_path);
				$_f = array();
				foreach($_list[1] as $f){
					$_name = str_replace(".ctp", '', str_replace($_path, '', $f));
					$_f[$_name] = $_name;
				}
				return $_f;
			break;
		}
		
	}
	
	private function setGroups() {
		App::uses('Group', 'Model');
		$this->Group = new Group();
		$this->set('_groups', $this->Group->find('list', array('order' => array('id' => 'ASC'))));
	}
	
}
