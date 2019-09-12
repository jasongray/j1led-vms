<?php
App::uses('AppController', 'Controller');
/**
 * SignTypes Controller
 *
 * @property SignType $SignType
 */
class SignTypesController extends AppController {

	public function beforeFilter() {
	    parent::beforeFilter();
	}
		
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->SignType->recursive = 0;
		$this->set('signs', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->SignType->id = $id;
		if (!$this->SignType->exists()) {
			throw new NotFoundException(__('Invalid sign'));
		}
		$this->set('sign', $this->SignType->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SignType->create();
			if ($this->SignType->saveAll($this->request->data)) {
				$this->log(__('New sign type created.'), 'notice', 'activity');
				if ($this->saveImage($this->request->data['SignType']['id'])) {
					$this->Session->setFlash(__('The sign has been saved'), 'Flash/admin_success');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('Image was not saved. ' . $this->getErr()), 'Flash/admin_success');
				}
				$this->Session->setFlash(__('The sign has been saved'), 'Flash/admin_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sign could not be saved. Please, try again.'), 'Flash/admin_error');
			}
		}
		$signColours = $this->SignType->SignColour->find('list');
		$this->set(compact('signColours'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->SignType->id = $id;
		if (!$this->SignType->exists()) {
			throw new NotFoundException(__('Invalid sign'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->SignType->saveAll($this->request->data)) {
				if ($this->saveImage($this->SignType->id)) {
					$this->Session->setFlash(__('The sign has been saved'), 'Flash/admin_success');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('Image was not saved. ' . $this->getErr()), 'Flash/admin_error');
				}
			} else {
				$this->Session->setFlash(__('The sign could not be saved. Please, try again.'), 'Flash/admin_error');
			}
		}
		
		$this->request->data = $this->SignType->read(null, $id);
		$signColours = $this->SignType->SignColour->find('list');
		$overlayColours = $this->SignType->SignColour->find('list');
		$this->set(compact('signColours', 'overlayColours'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->SignType->id = $id;
		if (!$this->SignType->exists()) {
			throw new NotFoundException(__('Invalid sign'));
		}
		if ($this->SignType->delete()) {
			$this->log(__('Sign type deleted') . " #$id", 'important', 'activity');
			$this->Session->setFlash(__('Sign deleted'), 'Flash/admin_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Sign was not deleted'), 'Flash/admin_error');
		$this->redirect(array('action' => 'index'));
	}
	
/**
 * cancel method
 *
 * @param string $id
 * @return void
 */
	public function cancel($id = null) {
		$this->Session->setFlash(__('Operation cancelled', true), 'Flash/admin_info');
		$this->redirect(array('action' => 'index'));
	}

/**
 * removeLogo method
 *
 * @param string $id
 * @return void
 */
	public function removeImage( $id = false ){
		$this->layout = 'ajax';
		$this->render(false);
		$this->Session->setFlash(__('Sign image was not removed', true), 'Flash/admin_warning');
		if ($id) {
			$_img = $this->SignType->read('image', $id);
			if($_img && file_exists(WWW_ROOT . 'img/signtypes/' . $_img['SignType']['image'])){
				unlink(WWW_ROOT . 'img/signtypes/' . $_img['SignType']['image']);
			}
			if ($this->SignType->saveField('image', '')) {
				$this->Session->setFlash(__('Sign image was removed', true), 'Flash/admin_success');
			}
		}
		$this->redirect(array('action' => 'edit', $id));
	}
	
/**
 * saveLogo method
 *
 * @param string $id
 * @return void
 */	
	private function saveImage($id = false){
		if(isset($this->request->data['Image']['file']) && $this->request->data['Image']['file']['error'] != 4){
			$tempFile = $this->request->data['Image']['file']['tmp_name'];
			$targetPath = WWW_ROOT . 'img/signtypes';
			if(!is_dir($targetPath)){
				mkdir($targetPath, 0766);
			}
			$___fileinfo = pathinfo($this->request->data['Image']['file']['name']);
			$__data['file'] = time() . md5($this->request->data['Image']['file']['name']) . '.' . $___fileinfo['extension'];
			$targetFile =  str_replace('//','/',$targetPath) . '/' . $__data['file'];
			if(move_uploaded_file($tempFile,$targetFile)){
				$this->SignType->saveField('image', $__data['file']);
			}else{
				return false;
			}
		} 
		return true;
	}
	
	private function getErr() {
		$message = '';
		if(isset($this->request->data['Image']['file'])  && $this->request->data['Image']['file']['error'] != 4) {
			$max_upload = (int)(ini_get('upload_max_filesize'));
			$max_post = (int)(ini_get('post_max_size'));
			$memory_limit = (int)(ini_get('memory_limit'));
			$upload_mb = min($max_upload, $max_post, $memory_limit);
			
			switch ($this->request->data['Image']['file']['error']) {
	            case 1:
	                $message = __("The file you attempted to upload exceeds the maximum file size of ") . $upload_mb . 'MB';
	                break;
	            case 2:
	                $message = __("The file you attempted to upload exceeds the maximum file size of ") . $upload_mb . 'MB';
	                break;
	            case 3:
	                $message = __("The file was only partially uploaded");
	                break;
	            case 5:
	                $message = __("No file was uploaded");
	                break;
	            case 6:
	                $message = __("Missing a temporary folder");
	                break;
	            case 7:
	                $message = __("Failed to write file to disk");
	                break;
	            case 8:
	                $message = __("File upload stopped by extension");
	                break;
	            default:
	                $message = __("An unknown error occurred");
	                break;
	        } 
		}
		return $message;
	}
	
}