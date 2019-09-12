<?php
/**
 * Hexcreator Component
 *
 * The component creates a hex string of the signs data if colour is single
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2013, Webwidget Pty Ltd (http://webwidget.com.au)
 * @link          http://webwidget.com.au
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Component', 'Controller');

class HexcreatorComponent extends Component  {
	
	public $file_loc = false;

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
		$this->file_loc = WWW_ROOT.DS.'files'.DS.'frame_data';
	}


/**
 * hexstring method
 *
 * converts the matrix of colours into hexidecimal strings for each colour used in the array.
 *
 * @param Array $matrix 
 * @param Array $colours
 * @return String
 */	
 
	public function hexstring($matrix = array(), $colours = false) {
		if (!empty($matrix) && !empty($colours)) {
			$_colourstring = array();
			$_col = explode('|', $colours);
			foreach ($_col as $c) {
				$_pslrd = explode('=', $c);
				$__colours[$_pslrd[0]] = $_pslrd[1];
			}
			if (!array_key_exists(0, $__colours)) {
				$__colours[0] = '255,140,0';
			}
			$_str = '';
			foreach ($__colours as $__k => $__v) {
				$_colourcode = str_pad($__k, 2, 0, STR_PAD_LEFT);
				$_graphicsframe = '';
				for ($r=0; $r<count($matrix); $r++) {
					$_colourarray = array();
					$k = 1; // bit counter
					$_colourstr = array();
					$_columns = count($matrix);
					for ($c=0; $c<count($matrix[$r]); $c++) {
						$_rows = count($matrix[$r]);
						if ($matrix[$r][$c] == $__v) {
							$_colourstr[] = '1';
						} else {
							$_colourstr[] = '0';
						}
						if ($k % 8 === 0 || $c == count($matrix[$r]) - 1) {
							$_colourstr = array_reverse($_colourstr);
							$_colourarray[$c] = str_pad(dechex(bindec(implode('', $_colourstr))), 2, 0, STR_PAD_LEFT);
							$_colourstr = array();
						}
						$k++;	
					}
					$_graphicsframe .= implode('', $_colourarray);
				}
				if ($this->notempty($_graphicsframe)) {
					$rows = dechex($_rows);
					$columns = dechex($_columns);
					$_lenframe = str_pad(dechex(($_rows * $_columns) / 8), 4, 0, STR_PAD_LEFT);
					$_colourstring[] =  strtoupper(sprintf('00%s%s%s00%s%s', $rows, $columns, $_colourcode, $_lenframe, $_graphicsframe));
				}
			}
			$__hexstring = implode('|', $_colourstring);
			//$this->log(__('Hex string :: ') . $__hexstring, 'info', 'activity');
			return $__hexstring;
			
		}
		return false;
	}
	
	
	/*
	public function __hexstring($matrix = array(), $colours = false, $fname = 'testframe') {
		if (!empty($matrix) && $fname) {
			$fname = $fname . '.hex.txt';
			if (file_exists($this->file_loc.DS.$fname)) {
				unlink($this->file_loc.DS.$fname);
			}
			$f = fopen($this->file_loc.DS.$fname, 'w');
			for ($r=0;$r<count($matrix);$r++) {
				$_c = array();
				$k = 1; // bit counter
				$str = array();
				for ($c=0;$c<count($matrix[$r]);$c++) {
					if (empty($matrix[$r][$c]) || $matrix[$r][$c] == '0,0,0') {
						$str[] = '0';
					} else {
						$str[] = '1';
					}
					if ($k % 8 === 0 || $c == count($matrix[$r]) - 1) {
						$str = array_reverse($str);
						pr($str);
						$_c[$c] = dechex(bindec(implode('', $str)));
						if (strlen($_c[$c]) == 1){
							$_c[$c] = '0'.$_c[$c];
						}
						$str = array();
					}
					$k++;	
				}
				fwrite($f, implode('', $_c));
			}
			fclose($f);
		}
		
	}
	*/
	
/**
 * empty method
 *
 * tests the massive string is empty as the built-in php function errors...
 *
 * @param String $str
 * @return Boolean
 */		
	private function notempty($str) {
		$_len = strlen($str);
		$_mtc = substr_count($str, '0');
		if ($_len === $_mtc) {
			return false;
		}
		return true;
	}
	
}