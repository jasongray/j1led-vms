<?php
App::uses('Helper', 'View');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 * Module helper
 *
 * Manages module rendering for Webwidget CMS
 *
 * @package       app.View.Helper
 */
class ModuleHelper extends Helper{
	
	var $helpers = array('Html', 'Form', 'Session', 'Paginator', 'Resize', 'Xhtml', 'Menu', 'Module', 'Number', 'Time', 'Numtext');
	
/**
 * load method
 * 
 * Checks for modules in the referenced position and loads them into the view accordingly
 *
 * @param string $position The position of the modules to check and generate
 * @param string $tpl An overriding template file
 * @return null
 */			
	public function load($position = false, $tpl = false) {
		
		if ($position) {
			if ($tpl) { 
				$tpl = $tpl . '.ctp';
			} else {
				$tpl = $position . '.ctp';
			}
			App::uses('Module', 'Model');
			$this->Module = new Module;
			$___params = !empty($this->_View->viewVars['params'])? $this->_View->viewVars['params']: array();
			if ($modules = $this->Module->getModules($position, $___params)) {
				$_path = APP . DS . 'View' . DS;
				$_folder = (isset($this->theme))? 'Themed' . DS . $this->theme . DS . 'Modules': 'Modules';
				$dir = new Folder($_path . $_folder);
				$file = new File($dir->pwd() . DS . $tpl);
				for ($i=0;$i<count($modules);$i++) {
					$m = $modules[$i];
					if ($m['Module']['html_file'] == 'html') {
						if ($file->exists()) {
							include $_path . $_folder . DS . $tpl;
						} else {
							include $_path . $_folder . DS . 'default.ctp';
						}
					}
					if ($m['Module']['html_file'] == 'file' && file_exists($_path . $_folder . DS . $m['Module']['modfile'])) {
						include $_path . $_folder . DS . $m['Module']['modfile'];
					}
					if ($m['Module']['html_file'] == 'menu') {
						App::uses('Menu', 'Model');
						$this->_Menu = new Menu;
						$this->_Menu->recursive = -1;
						$menu = $this->_Menu->read(null, $m['Module']['menu_id']);
						include $_path . $_folder . DS . 'menu.ctp';
					}
				}
				
			}
		}
		return null;
	}
	
/**
 * has method
 * 
 * Checks to see if modules exisit in the referenced position 
 *
 * @param string $position The position of the modules to check
 * @return booelan
 */	
	public function has($position = false) {
		
		if ($position) {
			App::uses('Module', 'Model');
			$this->Module = new Module;
			if ($this->Module->getModules($position, $this->_View->viewVars['params'])) {
				return true;
			}
		}
		return false;
	}
	
}