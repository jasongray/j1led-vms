<?php
/**
 * FTP Component
 *
 * This file is used to upload files to your server using FTP.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2013, Webwidget Pty Ltd (http://webwidget.com.au)
 * @link          http://webwidget.com.au
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Component', 'Controller');

class FtpComponent extends Component  {
	
/**
 * FTP server
 *
 * @var string
 */
	public $server = '';

/**
 * FTP username
 *
 * @var string
 */
	public $ftpuser = '';
	
/**
 * FTP users password
 *
 * @var string
 */
	public $ftppass = '';
	
/**
 * FTP passive mode
 *
 * @var boolean
 */
	public $passive = false;
	
/**
 * Controller reference
 *
 * @var Controller
 */
	protected $_controller = null;
	
/**
 * FTP connection reference
 *
 * @var boolean
 */
	protected $_connection = null;

/**
 * FTP login result
 *
 * @var boolean
 */
	protected $_loginresult = null;

/**
 * Constructor
 *
 * @param ComponentCollection $collection A ComponentCollection this component can use to lazy load its components
 * @param array $settings Array of configuration settings.
 */
	public function __construct(ComponentCollection $collection, $settings = array()) {
		$this->_controller = $collection->getController();
		parent::__construct($collection, $settings);
	}

/**
 * Initialize component
 *
 * @param Controller $controller Instantiating controller
 * @return void
 */
	public function initialize(Controller $controller) {
			
	}
	
/**
 * Upload a file using FTP
 *
 * @param array $file The file being uploaded
 * @return boolean Success
 */
	public function upload($fileFrom, $fileTo) {
		if ($this->connect()) {
			if (ftp_put($this->_connection, $fileTo, $fileFrom, FTP_BINARY)) {
				return true;
			} else {
				$this->log(__('FTP upload has failed.'), 'ftp');
			}
		}
		return false;
	}

/**
 * Make a directory
 *
 * @param string $dir The name fo the directory
 * @return boolean Success
 */	
	public function mkdir($dir = null) {
		if ($dir) {
			if (ftp_mkdir($this->_connection, $dir)) {
				return true;
			}
		}
		return false;
	}

/**
 * Change directory
 *
 * @param string $dir The name fo the directory
 * @return boolean Success
 */	
	public function chdir($dir = null) {
		if ($dir) {
			if (ftp_chdir($this->_connection, $dir)) {
				return true;
			}
		}
		return false;
	}
	
/**
 * Connect to FTP server
 *
 * @return boolean Success
 */	
	protected function connect() {
		$this->_connection = ftp_connect($this->server);
		$this->_loginresult = ftp_login($this->_connection, $this->ftpuser, $this->ftppass);
		ftp_pasv($this->_connection, $this->passive);
		if ((!$this->_connection) || (!$this->_loginresult)) {
			$this->log(__('Error connecting to FTP server.'), 'ftp');
			return false;
		} else {
			return true;
		}
	}

/**
 * Close the connection to FTP server
 *
 */	
	public function __destruct() {
		if ($this->_connection) {
			ftp_close($this->_connection);
		}
	}

}

?>