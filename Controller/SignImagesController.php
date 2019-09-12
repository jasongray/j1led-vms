<?php
App::uses('AppController', 'Controller');
/**
 * SignImages Controller
 *
 * @property SignImage $SignImage
 */
class SignImagesController extends AppController {
	
	var $components = array('Imagecreate', 'BMPLoader', 'Hexcreator');
	
	public function beforeFilter() {
	    parent::beforeFilter();
	}
	
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->set('title_for_layout', __('Image Library'));
		$this->SignImage->recursive = 0;
		$this->set('images', $this->paginate());
	}
	
/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->set('title_for_layout', __('Create Frame'));
		if ($this->request->is('ajax')) {
			$this->request->data['SignImage']['width'] = $this->request->params['named']['width'];
			$this->request->data['SignImage']['height'] = $this->request->params['named']['height'];
		}
		if ($this->request->is('post')) {
			$this->SignImage->create();
			if ($this->SignImage->save($this->request->data)) {
				$this->log(__('New sign image was saved.') . ' #' . $this->SignImage->id, 'warning', 'activity');
				if ($this->saveFrame($this->request->data['SignImage']['id'])) {
					$this->Session->setFlash(__('The image file has been saved...'), 'Flash/admin_success');
					$this->redirect(array('action' => 'index'));
				} else {
					if ($file = $this->Imagecreate->bmp($this->request->data['matrix'], Inflector::slug($this->request->data['SignImage']['name']))){
						$this->SignImage->saveField('image', $file);
					}
					$this->Imagecreate->bmpfile($this->request->data['matrix'], Inflector::slug($this->request->data['SignImage']['name']));
					//$this->Hexcreator->hexstring($this->request->data['matrix'], Inflector::slug($this->request->data['SignImage']['name']));
					
					if ($hex = $this->Hexcreator->hexstring($this->request->data['matrix'], $this->request->data['SignImage']['colours'])){
						$this->SignImage->saveField('hexstring', $hex);
					}
					
					$this->Session->setFlash(__('The image file has been saved. '), 'Flash/admin_success');
					$this->redirect(array('action' => 'index'));
				}
			} else {
				$this->Session->setFlash(__('The sign image could not be saved. Please, try again.'), 'Flash/admin_error');
			}
		}
		if (empty($this->request->data['SignImage']['width'])) $this->request->data['SignImage']['width'] = 48;
		if (empty($this->request->data['SignImage']['height'])) $this->request->data['SignImage']['height'] = 28;
		$signTypes = $this->SignImage->SignType->find('list');
		$companies = $this->SignImage->Company->find('list');
		$this->loadModel('SignColour');
		$ledcolours = $this->SignColour->find('all');
		$this->set(compact('companies', 'signTypes', 'ledcolours'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->set('title_for_layout', __('Edit Frame'));
		$this->SignImage->id = $id;
		if (!$this->SignImage->exists()) {
			$this->Session->setFlash(__('That ID seems to be missing from the database.'), 'Flash/admin_error');
			$this->redirect(array('action' => 'index'));
		}
		if ($this->request->is('ajax')) {
			$this->request->data['SignImage']['width'] = $this->request->params['named']['width'];
			$this->request->data['SignImage']['height'] = $this->request->params['named']['height'];
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->SignImage->save($this->request->data)) {
				if ($this->saveFrame($this->request->data['SignImage']['id'])) {
					$this->Session->setFlash(__('The image file has been saved'), 'Flash/admin_success');
					$this->redirect(array('action' => 'index'));
				} else {
					if ($file = $this->Imagecreate->bmp($this->request->data['matrix'], Inflector::slug($this->request->data['SignImage']['name']))){
						$this->SignImage->saveField('image', $file);
					}
					$this->Imagecreate->bmpfile($this->request->data['matrix'], Inflector::slug($this->request->data['SignImage']['name']));
					$this->Session->setFlash(__('The image has been created and saved.'), 'Flash/admin_success');
					$this->redirect(array('action' => 'index'));
				}
			} else {
				$this->Session->setFlash(__('The image file could not be saved. Please, try again.'), 'Flash/admin_error');
			}
		} 
		$this->request->data = $this->SignImage->read(null, $id);
		if (empty($this->request->data['SignImage']['width'])) $this->request->data['SignImage']['width'] = 48;
		if (empty($this->request->data['SignImage']['height'])) $this->request->data['SignImage']['height'] = 28;
		$signTypes = $this->SignImage->SignType->find('list');
		$companies = $this->SignImage->Company->find('list');
		$this->loadModel('SignColour');
		$ledcolours = $this->SignColour->find('all');
		$this->set(compact('companies', 'signTypes', 'ledcolours'));
	}
	
/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->SignImage->id = $id;
		if (!$this->SignImage->exists()) {
			$this->Session->setFlash(__('That ID seems to be missing from the database.'), 'Flash/admin_error');
			$msg = array('response' => 0, 'msg' => array(__('That ID seems to be missing from the database.')));
		}
		if ($this->SignImage->delete()) {
			$this->log(__('The sign image was deleted') . " #$id", 'important', 'activity');
			$this->Session->setFlash(__('Sign image was deleted'), 'Flash/admin_success');
			$msg = array('response' => 1, 'msg' => array(__('Sign image was deleted')));
		} else {
			$this->Session->setFlash(__('Sign image was not deleted'), 'Flash/admin_error');
			$msg = array('response' => 0, 'msg' => array(__('Sign image was not deleted')));
		}
		if($this->RequestHandler->isAjax()) {
			$this->layout = 'ajax';
			$this->autoRender = false;
			$this->Session->delete('Message.flash');
			echo json_encode($msg);
		} else {
			$this->redirect(array('action' => 'index'));
		}
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
 * ajaxadd method
 *
 * @return void
 */
	public function ajaxadd() {
		$this->layout = 'ajax';
		$this->autoRender = false;
		if($this->RequestHandler->isAjax()){
			$this->SignImage->set($this->request->data);
			if ($this->SignImage->validates()) {
				if ($this->SignImage->save($this->request->data)) {
					$this->log(__('New sign image was saved.') . ' #' . $this->SignImage->id, 'warning', 'activity');
					if ($this->saveFrame()) {
						$msg = array('response' => 1, 'msg' => array(__('The image information has been saved')));
					} else {
						if ($file = $this->Imagecreate->bmp($this->request->data['matrix'], Inflector::slug($this->request->data['SignImage']['name']))){
							$this->SignImage->saveField('image', $file);
						}
						$this->Imagecreate->bmpfile($this->request->data['matrix'], Inflector::slug($this->request->data['SignImage']['name']));
						//$this->Hexcreator->hexstring($this->request->data['matrix'], Inflector::slug($this->request->data['SignImage']['name']));	
										
						if ($hex = $this->Hexcreator->hexstring($this->request->data['matrix'], $this->request->data['SignImage']['colours'])){
							$this->SignImage->saveField('hexstring', $hex);
						}
						//pr($hex);	exit;
						$msg = array('response' => 1, 'msg' => array(__('The image file has been saved')));
					}
				} else {
					$msg = array('response' => 0, 'msg' => array(__('The image file has not been saved')));
				}
			} else {
				$SignImage = $this->SignImage->invalidFields();
				$data = compact('SignImage');
				$msg = array('response' => 0, 'msg'  => array(__('Please fix any errors and try again.')), 'data' => $data);
			}
			echo json_encode($msg);
		}
		
	}

	public function ajaxupload(){
		$this->layout = 'ajax';
		$this->autoRender = false;
		if($this->RequestHandler->isAjax()){
			$this->loadModel('Sign');
			$sign = $this->Sign->read(null, $this->request->params['named']['sign_id']);
			if ($sign) {
				$hex = $this->Hexcreator->hexstring($this->request->data['matrix'], $this->request->params['named']['colours']);
				$hex = explode('|', $hex);
				//pr($hex);	exit;
				$this->MessageEngine = $this->Components->load('MessageEngine');
				$this->MessageEngine->clearSchedule($sign['Sign']['me_id']);
				if ($frames = $this->MessageEngine->setGraphicsFrame($sign['Sign']['me_id'], $hex, $sign['SignType']['protocol'])) {
					if ($message_id = $this->MessageEngine->setMessage($sign['Sign']['me_id'], $frames)) {
						//if ($schedule = $this->MessageEngine->setSchedule($sign['Sign']['me_id'], $message_id)) {
						if ($schedule = $this->MessageEngine->displayMessage($sign['Sign']['me_id'], $message_id)) {
							$msg = array('response' => 1, 'msg' => array(__('Frame upload complete. No errors! Congratulations.')));
						} else {
							$msg = array('response' => 0, 'msg' => array(__('Schedule was not created and sent to Message Engine.')));
						}
					} else {
						$msg = array('response' => 0, 'msg' => array(__('Message was not created and sent to Message Engine.')));
					}
				} else {
					$msg = array('response' => 0, 'msg' => array(__('Frames were not sent to Message Engine.')));
				}			
			} else {
				$msg = array('response' => 0, 'msg' => array(__('Sign was not found.')));
			}
			echo json_encode($msg);
		}
	}
	
/**
 * saveFrame method
 *
 * @param string $id
 * @return boolean
 */	
	private function saveFrame($id = false){
		if(isset($this->request->data['Image']['file']) && $this->request->data['Image']['file']['error'] != 4){
			$tempFile = $this->request->data['Image']['file']['tmp_name'];
			$targetPath = WWW_ROOT . 'img/frames';
			if(!is_dir($targetPath)){
				mkdir($targetPath, 0766);
			}
			$targetFile =  str_replace('//','/',$targetPath) . '/' . $this->request->data['Image']['file']['name'];
			if(move_uploaded_file($tempFile,$targetFile)){
				$this->BMPLoader->Load_BMP($targetFile);
				$this->Imagecreate->bmpfile($this->BMPLoader->getMatrix(), Inflector::slug($this->request->data['SignImage']['name']));
				$this->SignImage->saveField('image', $this->request->data['Image']['file']['name']);
				return true;
			}
		} 
		return false;
	}
	
/**
 * removeFrame method
 *
 * @param string $id
 * @return void
 */
	public function removeFrame( $id = false ){
		$this->layout = 'ajax';
		$this->render(false);
		$this->Session->setFlash(__('Frame image was not removed', true), 'Flash/admin_warning');
		if ($id) {
			$_img = $this->Frame->read('image', $id);
			if($_img && file_exists(WWW_ROOT . 'img/frames/' . $_img['Frame']['image'])){
				unlink(WWW_ROOT . 'img/frames/' . $_img['Frame']['image']);
			}
			if ($this->Frame->saveField('image', '')) {
				$this->Session->setFlash(__('Frame image was removed', true), 'Flash/admin_success');
			}
		}
		$this->redirect(array('action' => 'edit', $id));
	}
	
/**
 * saveFile method
 *
 * @param string $id
 * @return boolean
 */	
	private function saveFile($id = false){
		if(isset($this->request->data['Textfile']['file']) && $this->request->data['Textfile']['file']['error'] != 4){
			$tempFile = $this->request->data['Textfile']['file']['tmp_name'];
			$targetPath = WWW_ROOT . 'files/frame_data';
			if(!is_dir($targetPath)){
				mkdir($targetPath, 0766);
			}
			$targetFile =  str_replace('//','/',$targetPath) . '/' . $this->request->data['Textfile']['file']['name'];
			if(move_uploaded_file($tempFile,$targetFile)){
				$this->SignImage->saveField('textfile', $this->request->data['Textfile']['file']['name']);
				return true;
			}
		} 
		return false;
	}	
	
/**
 * removeFile method
 *
 * @param string $id
 * @return void
 */
	public function removeFile( $id = false ){
		$this->layout = 'ajax';
		$this->render(false);
		$this->Session->setFlash(__('Text file was not removed', true), 'Flash/admin_warning');
		if ($id) {
			$_img = $this->Frame->read('textfile', $id);
			if($_img && file_exists(WWW_ROOT . 'files/frame_data/' . $_img['Frame']['textfile'])){
				unlink(WWW_ROOT . 'files/frame_data/' . $_img['Frame']['textfile']);
			}
			if ($this->Frame->saveField('textfile', '')) {
				$this->Session->setFlash(__('Text file was removed', true), 'Flash/admin_success');
			}
		}
		$this->redirect(array('action' => 'edit', $id));
	}
	
}