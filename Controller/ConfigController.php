<?php
App::uses('AppController', 'Controller');
/**
 * Config Controller
 *
 */
class ConfigController extends AppController {
	
	function beforeFilter() {
	    parent::beforeFilter();
	}
	
/**
 * admin_index method
 *
 * @return void
 */
	public function index(){
		
		if(!empty($this->request->data)){
			$this->saveToFile($this->request->data['Config']);
		}
		include_once APP . 'Config' . DS . 'my.site.config.php';
		$vars = new MySite();
		foreach($vars as $k => $v){
			$this->request->data['Config'][$k] = $v;
		}
		
		$this->set('themes', $this->getThemes());
		
	}
	
/**
 * admin_cancel method
 *
 * @param string $id
 * @return void
 */
	public function cancel($id = null) {
		$this->Session->setFlash(__('Operation cancelled', true), 'Flash/admin_info');
		$this->redirect($this->Auth->redirect());
	}
	
	
	private function saveToFile( $data = false ){
		if($data){
			$file = APP . 'Config' . DS . 'my.site.config.php';
			if (is_writable($file)) {
				$handle = fopen($file, 'w');
				$txt = "<?php\n
class MySite extends Object{\n\n";
				foreach($data as $k => $v){
					$txt .= "var $$k = '$v';\n";
				}
				$txt .= "
}\n
?>\n";
				if (fwrite($handle, $txt) === FALSE) {
					$this->Session->setFlash(__('Could not save config information to file.', true), 'Flash/admin_warning');
					return false;
				}
				fclose($handle);
				$this->Session->setFlash(__('Config information saved.', true), 'Flash/admin_success');
				$this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(__('Config file is not writeable. Please correct the issue and try again!', true), 'Flash/admin_error');
				return false;
			}
		} else {
			$this->Session->setFlash(__('No data can be saved.', true), 'Flash/admin_error');
			return false;
		}
		
	}
	
	private function getThemes() {
		App::uses('Folder', 'Utility');
		$_path = APP . DS . 'View' . DS . 'Themed';
		$_folder = new Folder($_path);
		$_list = $_folder->read();
		if ($_list) {
			$_f = array();
			foreach($_list[0] as $f){
				$_f[$f] = $f;
			}
			return $_f;
		}
		return false;
	}

}
?>