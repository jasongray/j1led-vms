<?php
App::uses('Component', 'Controller');

class FacebookComponent extends Component  {
	
	public $Facebook;
	
/**
 * Facebook settings.  
 *
 * - `appId` The app id you have received from Facebook
 * - `secret` The secret key
 *
 * @var array
 */
	public $settings = array(
		'appId'  => 'APPID', 
		'secret' => 'SECRETCODE', 
		'fileUpload' => true, 
		'cookie' => true);


	public function __construct(ComponentCollection $collection, $settings = array()) {
		$settings = array_merge($this->settings, (array)$settings);
		$this->Controller = $collection->getController();
		parent::__construct($collection, $settings);
		
		// load Facebook
		require_once dirname(__FILE__) . DS . 'fb' . DS . 'facebook.php';
		$this->_facebook = new Facebook($settings);
	}

	public function getUser()	{
		return $this->_facebook->getUser();
	}
	
	public function getLoginUrl($params = array()) {
		if (empty($params)) {
			$params = array(
				'redirect_uri' => Router::url($this->here, true),
				'scope' => 'publish_stream,user_photos'
			);
		}
		return $this->_facebook->getLoginUrl($params);
	}
	
	public function post($url = false, $msg = false) {
		if ($url && $msg) {
			try {
				if ($this->_facebook->api($url, 'post', $msg)) {
					return true;
				}
			} catch (FacebookApiException $e) {
				$this->_facebook->error = $e->getMessage();
				return false;
			}
		}
		return false;
	}
	
	public function getError() {
		return explode(' ', $this->_facebook->error);
	}

}

?>