<?php
/**
 * MessageEngine Component
 *
 * This component formats and communicates with J1LEDs Message Engine to poll information to VMS
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2013, Webwidget Pty Ltd (http://webwidget.com.au)
 * @link          http://webwidget.com.au
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Component', 'Controller');
App::uses('phpsocket', 'Network/Socket');
ini_set('max_execution_time', 300);

class MessageEngineComponent extends Component  {

	public $socket;
	
	public $connected = false;
	
	public $guid;

/**
 * Settings for the socket connection
 *
 * @var array
 */	
	public $settings = array(
		'host' => 'localhost',
		'port' => '11000',
		'timeout' => 30
	);
	
/**
 * Constructor
 *
 * @param ComponentCollection $collection A ComponentCollection this component can use to lazy load its components
 * @param array $settings Array of configuration settings.
 */
	public function __construct(ComponentCollection $collection, $settings = array()) {
		$this->_controller = $collection->getController();
		parent::__construct($collection, $settings);
		$this->initialize($this->_controller);
	}

/**
 * Initialize component
 *
 * @param Controller $controller Instantiating controller
 * @return void
 */
	public function initialize(Controller $controller, $settings = array()) {	
		$this->socket = new phpsocket('localhost', '11000');
		$this->connected = $this->socket->establish();
		$this->guid = $this->guid();
		return $this->connected;
	}
	
/**
 * clearSchedule method
 *
 * @param Integer $sign_id
 * @return Boolean
 */
	public function clearSchedule($sign_id) {	
		$guid = $this->guid();
		$msg = sprintf('|%s|253|{%s}|Clear Schedule|F005|',  $sign_id, $guid);
		if ($this->sendMessage($msg)) {
			return true;
		}
		return false;
	}
	
/**
 * reset method
 *
 * @param Integer $sign_id
 * @return Boolean
 */
	public function reset($sign_id, $level = '00') {	
		$guid = $this->guid();
		$msg = sprintf('|%s|08|{%s}|Reset Sign|00%s|',  $sign_id, $guid, $this->padstr($level));
		if ($this->sendMessage($msg)) {
			return true;
		}
		return false;
	}
	
/**
 * getGPS method
 *
 * @param Integer $sign_id
 * @return Boolean
 */
	public function getGPS($sign_id) {	
		$guid = $this->guid();
		$msg = sprintf('|%s|253|{%s}|Get GPS|10|',  $sign_id, $guid);
		if ($this->sendMessage($msg)) {
			return true;
		}
		return false;
	}
	
/**
 * setGeoFence method
 *
 * @param Integer $sign_id
 * @return Boolean
 */
	public function setGeoFence($sign_id, $distance = 0) {	
		$guid = $this->guid();
		$distance = $this->padstr(dechex($distance), 4);
		$msg = sprintf('|%s|253|{%s}|Set GEO Fence|1F%s|',  $sign_id, $guid, $distance);
		if ($this->sendMessage($msg)) {
			return true;
		}
		return false;
	}

/**
 * enableGeoFence method
 *
 * @param Integer $sign_id
 * @return Boolean
 */
	public function enableGeoFence($sign_id, $enable = 1) {	
		$guid = $this->guid();
		$enable = $this->padstr($enable);
		$msg = sprintf('|%s|253|{%s}|Enable GEO Fence|20%s|',  $sign_id, $guid, $enable);
		if ($this->sendMessage($msg)) {
			return true;
		}
		return false;
	}

/**
 * getVoltage method
 *
 * @param Integer $sign_id
 * @return Boolean
 */
	public function getVoltage($sign_id) {	
		$guid = $this->guid();
		$msg = sprintf('|%s|64|{%s}|Request Battery Voltage|',  $sign_id, $guid);
		if ($this->sendMessage($msg)) {
			return true;
		}
		return false;
	}
	
/**
 * getUsage method
 *
 * @param Integer $sign_id
 * @return Boolean
 */
	public function getUsage($sign_id) {	
		$guid = $this->guid();
		$msg = sprintf('|%s|68|{%s}|Request Usage||',  $sign_id, $guid);
		if ($this->sendMessage($msg)) {
			return true;
		}
		return false;
	}

/**
 * setTextFrame method
 *
 * @param Controller $controller Instantiating controller
 * @return void
 */
	public function setTextFrame($sign_id, $text, $colour = '00', $font = '00') {	
		// Mi code 10
		
		
	}
	
/**
 * displayMessage method
 *
 * @param Integer $sign_id
 * @param Integer $message_id
 * @return Boolean
 */
	public function displayMessage($sign_id, $message_id) {	
		// Mi code 10
		$msg = sprintf('|%s|15|{%s}|Display Sign Message|00%s|',  $sign_id, $this->guid, $message_id);
		if ($this->sendMessage($msg)) {
			return true;
		}
		return false;
	}
	
/**
 * setGraphicsFrame method
 *
 * @param Integer $sign_id
 * @param String $str
 * @param Integer $f_id
 * @return Boolean
 */
	public function setGraphicsFrame($sign_id, $str = array(), $f_id = false) {	
		$_id = (!$f_id)? mt_rand(161, 255): $f_id;
		if (is_array($str)) {
			$msg = array();
			$id = array();
			for ($i=0;$i<count($str);$i++) {
				$_s = $str[$i];
				$id[$i] = $this->padstr(dechex($_id++));
				$msg[] = sprintf('|%s|11|{%s}|Set Graphics Frame|%s%s|',  $sign_id, $this->guid, $id[$i], $_s);
			}
		} else {
			$id = $this->padstr(dechex($_id));
			$msg = sprintf('|%s|11|{%s}|Set Graphics Frame|%s%s|',  $sign_id, $this->guid, $id, $str);
		}
		if ($this->sendMessage($msg)) {
			return $id;
		}
		return false;
	}
	
/**
 * setMessage method
 *
 * Instruct the sign to display individual frames as a message
 *
 * @param Integer $sign_id
 * @param Array $frame_id
 * @param Boolean $overlay
 * @param Integer $protocol
 * @return Boolean
 */
	public function setMessage($sign_id, $frame_id = array(), $transition = '00', $overlay = true, $protocol = 'strict') {	
		if ($protocol == 'strict') {
			$micode = 12;
			$prepend = '';
			$count = 6;
		} else {
			$micode = 253;
			$prepend = '0C';
			$count = count($frame_id);
		}
		$mid = $this->padstr(dechex(mt_rand(161, 255)));
		$msg = sprintf('|%s|%s|{%s}|Set Message|%s%s00%s',  $sign_id, $micode, $this->guid, $prepend, $mid, $transition);
		if (is_array($frame_id)) {
			for ($i=0;$i<$count;$i++) {
				if (isset($frame_id[$i])) {
					if ($overlay) {
						$_d = '00';
					}
					$msg .= sprintf('%s%s', $frame_id[$i], $_d);
				} 
			}
		} else {
			if ($overlay) {
				$_d = '00';
			}
			$msg .= sprintf('%s%s', $frame_id, $_d);
		}
		$msg .= '00|'; // Let the sign know we have finished and there are no more frames.
		if ($this->sendMessage($msg)) {
			return $mid;
		}
		return false;
	}
	
/**
 * setSchedule method
 *
 * Instruct the sign to display individual frames as a message
 *
 * @param Integer $sign_id
 * @param Array $m_id array of message ids to display
 * @param Integer $s_id predefined schedule id
 * @param Integer $ontime  in milliseconds.
 * @param Integer $starttime  as time string - will be converted
 * @param Integer $endtime  as time string - will be converted
 * @param Integer $transition
 * @param Integer $protocol
 * @return Boolean
 */
	public function setSchedule($sign_id, $m_id = array(), $s_id = false, $starttime = '0000000000', $endtime = '0000000000', $ontime = '2000', $transition = '80', $protocol = false) {	
		if ($protocol == 'strict') {
			$micode = 17;
			$prepend = '';
		} else {
			$micode = 253;
			$prepend = 17;
		}
		if ($s_id) {
			$ontime = !empty($ontime)? $this->padstr(dechex($this->seconds2units($ontime)), 4): dechex('2000');
			$starttime = !empty($starttime)? $this->strtime2hex($starttime): '0000000000';
			$endtime = !empty($endtime)? $this->strtime2hex($endtime): '0000000000';
			$transition = !empty($transition)? $transition: '80';
			if (is_array($m_id)) {
				foreach ($m_id as $m) {
					if ($protocol == 'strict') {
						$sid[$i] = $this->padstr(dechex($s_id));
					} else {
						$sid[$i] = $this->padstr(dechex($s_id), 4);
					}
					$serial = '81';//str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
					$msg[] = sprintf('|%s|%s|{%s}|Set Schedule|%s%s%s%s%s%sFF%s%s0000000000|',  $sign_id, $micode,  $this->guid, $prepend, $sid[$i], $m, $transition, $ontime, $serial, $starttime, $endtime);
				}
			} else {
				if ($protocol == 'strict') {
					$sid = $this->padstr(dechex($s_id++));
				} else {
					$sid = $this->padstr(dechex($s_id++), 4);
				}
				$serial = '81';//str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
				$msg = sprintf('|%s|%s|{%s}|Set Schedule|%s%s%s%s%s%sFF%s%s0000000000|',  $sign_id, $micode,  $this->guid, $prepend, $sid, $m_id, $transition, $ontime, $serial, $starttime, $endtime);
			}
			if ($this->sendMessage($msg)) {
				return $sid;
			}
		}
		return false;
		/*
		|62|253|{44A4C208-8B0C-FAED-E07F-A214403F8664}|SET SCHEDULE|17 0099 79 80 0064 81 FF0D0C10010A0D0C1F170A0000000000|
		|62|253|{44A4C208-8B0C-FAED-E07F-A214403F8664}|SET SCHEDULE|17 0023 59 80 0064 81 FF0D0C10010A0D0C1F170A0000000000|
		|62|253|{44A4C208-8B0C-FAED-E07F-A214403F8664}|SET SCHEDULE|17 0048 54 80 0064 81 FF0D0C10010A0D0C1F170A0000000000|
		|62|253|{44A4C208-8B0C-FAED-E07F-A214403F8664}|SET SCHEDULE|17 00A7 57 80 0064 81 FF0D0C10010A0D0C1F170A0000000000|
		*/
	}

/**
 * signDisplayFrame method
 *
 * instruct the sign to display pre-stored frame
 *
 * @param integer $frame_id
 * @param integer $sign_id
 * @return boolean
 */
	public function signDisplayFrame($sign_id = false, $frame_id = false, $group_id = '00') {	
		// Mi code 14 (decimal), 0E (hex)
		if ($frame_id && $sign_id) {
			$msg = sprintf('|%s|14|{%s}|Sign Display Frame|%s%s|',  $sign_id,  $this->guid, $group_id, $frame_id);
			if ($this->sendMessage($msg)) {
				return true;
			}
		}
		return false;
	}

/**
 * sendMessage method
 *
 * Sends the message string to the MessageEngine program
 *
 * @param array $message Array of messages or string for single message.
 * @return boolean
 */
	public function sendMessage($message = false) {	
		if (!$this->connected) {
			$this->socket->establish();
		}
		if (!empty($message)) {
			$error = false;
			if (is_array($message) && !empty($message)) {
				foreach($message as $m) {
					$this->log(__('Socket message :: ') . $m, 'info', 'activity');
					usleep(1500000);
					if ($this->socket->send_data('BasicMessage ' . strtoupper($m) . "\r\n")) {
						$error = 0;
					} else {
						$this->log(__('Socket error sending message :: ') . $this->socket->lastError(), 'info', 'activity');
						$error = 1;
					}
				}
			} else {
				$this->log(__('Socket message :: ') . $message, 'info', 'activity');
				usleep(1500000);
				if ($this->socket->send_data('BasicMessage ' . strtoupper($message) . "\r\n")) {
					$error = 0;
				} else {
					$this->log(__('Socket error sending message :: ') . $this->socket->lastError(), 'info', 'activity');
					$error = 1;
				}
			}
			if ($error == 0) {
				return true;
			}
		}
		return false;
	}

/**
 * Destructor, used to disconnect from current connection.
 *
 */
	public function __destruct() {
		$this->socket->close();
	}

/*
 * Pad string
 *
 */
	private function padstr($str, $len = 2) {
		return str_pad($str, $len, '0', STR_PAD_LEFT);
	} 	
	
/*
 * Create GUID for message engine
 * 8 - 4 - 4 - 4 - 12
 *
 */
	private function guid() {
		$str = md5(session_id());
		$_str[] = substr($str, 0, 8);
		$_str[] = substr($str, 8, 4);
		$_str[] = substr($str, 12, 4);
		$_str[] = substr($str, 16, 4);
		$_str[] = substr($str, 20, 32);
		return implode('-', $_str);
	}
	
/*
 * Convert milliseconds to units
 * 20 milliseconds = 1 unit
 * 50 units = 1 second
 */
	private function milliseconds2units($num) {
		// assume anything less than say 50 milliseconds has been entered incorrectly
		// as seconds and needs to be converted to milliseconds.... okay?!
		if ($num < 50) {
			$num = $num * 1000;
		}
		return $num / 20;
	}
	
/*
 * Convert seconds to units
 * and rounds seconds to nearest 0.02
 * 50 units = 1 second
 */
	private function seconds2units($num) {
		$num = round($num / 0.02) * 0.02;
		return $num * 50;
	}
	
/*
 * Convert strtime to hex
 *
 */
	private function strtime2hex($time) {
		// we'll do this the slow way...
		$hextime = array();
		$hextime[] = $this->padstr(dechex(date('y', $time)));
		$hextime[] = $this->padstr(dechex(date('m', $time)));
		$hextime[] = $this->padstr(dechex(date('d', $time)));
		$hextime[] = $this->padstr(dechex(date('H', $time)));
		$hextime[] = $this->padstr(dechex(date('i', $time)));
		return implode('', $hextime);
	}
}