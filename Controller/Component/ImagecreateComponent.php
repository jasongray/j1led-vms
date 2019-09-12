<?php
/**
 * Imagecreate Component
 *
 * The component helps with the creation of BMP images from an array of data
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2013, Webwidget Pty Ltd (http://webwidget.com.au)
 * @link          http://webwidget.com.au
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Component', 'Controller');

class ImagecreateComponent extends Component  {
	
	public $image_loc = false;
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
		$this->image_loc = WWW_ROOT.IMAGES_URL.'frames';	
		$this->file_loc = WWW_ROOT.DS.'files'.DS.'frame_data';
	}
	
/**
 * bmp method
 *
 * generates BMP file based on array of rgb colours
 *
 * @param $matrix array
 * @param $fname string
 * @return $fname string
 */	
	public function bmp($matrix = array(), $fname = false) {
		if (!empty($matrix) && $fname) {
			$h = count($matrix);
			$w = count($matrix[0]); // assume first row will have all the columns
			if ($h && $w) {
				$fname = $fname.time();
				if (file_exists($this->image_loc.DS.$fname.'.bmp')) {
					unlink($this->image_loc.DS.$fname.'.bmp');
				}
				$im = imagecreatetruecolor($w, $h);
				for ($r=0;$r<count($matrix);$r++) {
					for ($c=0;$c<count($matrix[$r]);$c++) {
						if (strstr($matrix[$r][$c], '#')){
							$col = explode(',', $this->convertColour($matrix[$r][$c]));
						} else {
							if (empty($matrix[$r][$c])) {
								$col = explode(',', '0,0,0');
							} else {
								$col = explode(',', $matrix[$r][$c]);
							}
						}
						$bg = imagecolorallocate($im, (int)$col[0], (int)$col[1], (int)$col[2]);
						imagesetpixel($im, $c, $r, $bg);
					}
				}
				$this->imagebmp($im, $this->image_loc.DS.$fname.'.bmp');
				imagepng($im, $this->image_loc.DS.$fname.'.png');
				imagedestroy($im);
				return $fname.'.bmp';
			}
		}
		return false;
	}

/**
 * bmpfile method
 *
 * generates a text file based upon the BMP matrix
 *
 * @param $matrix array
 * @param $fname string
 * @return void
 */		
	public function bmpfile($matrix = array(), $fname = false) {
		if (!empty($matrix) && $fname) {
			$fname = $fname.time().'.bmp.txt';
			if (file_exists($this->file_loc.DS.$fname)) {
				unlink($this->file_loc.DS.$fname);
			}
			$f = fopen($this->file_loc.DS.$fname, 'w');
			for ($r=0;$r<count($matrix);$r++) {
				$_c = array();
				for ($c=0;$c<count($matrix[$r]);$c++) {
					if (strstr($matrix[$r][$c], '#')) {
						$_c[$c] = $this->convertColour($matrix[$r][$c]);
					} else {
						if (empty($matrix[$r][$c])) {
							$_c[$c] = '0,0,0';
						} else {
							$_c[$c] = $matrix[$r][$c];
						}
					}
				}
				fwrite($f, implode('|', $_c) . "\n");
			}
			fclose($f);
		}
	}
	
	private function convertColour($str) {
		switch ($str) {
			default: case '#000':
			$s = '0,0,0'; break;
			case '#00255':
			$s = '0,0,255'; break;
			case '#02550':
			$s = '0,255,0'; break;
			case '#0255255':
			$s = '0,255,255'; break;
			case '#255255255':
			$s = '255,255,255'; break;
			case '#2552550':
			$s = '255,255,0'; break;
			case '#25500':
			$s = '255,0,0'; break;
		}
		return $s;
	}
	
	private function imagebmp(&$img, $filename = false) {
		$wid = imagesx($img);
		$hei = imagesy($img);
		$wid_pad = str_pad('', $wid % 4, "\0");
		
		$size = 54 + ($wid + $wid_pad) * $hei;
		
		//prepare & save header
		$header['identifier'] = 'BM';
		$header['file_size'] = $this->dword($size);
		$header['reserved'] = $this->dword(0);
		$header['bitmap_data']  = $this->dword(54);
		$header['header_size'] = $this->dword(40);
		$header['width'] = $this->dword($wid);
		$header['height'] = $this->dword($hei);
		$header['planes'] = $this->word(1);
		$header['bits_per_pixel'] = $this->word(24);
		$header['compression'] = $this->dword(0);
		$header['data_size'] = $this->dword(0);
		$header['h_resolution'] = $this->dword(0);
		$header['v_resolution'] = $this->dword(0);
		$header['colors'] = $this->dword(0);
		$header['important_colors'] = $this->dword(0);
		
		if ($filename) {
			$f = fopen($filename, "wb");
			foreach ($header AS $h) {
				fwrite($f, $h);
			}
        	
			//save pixels
			for ($y=$hei-1; $y>=0; $y--) {
				for ($x=0; $x<$wid; $x++) {
					$rgb = imagecolorat($img, $x, $y);
					fwrite($f, $this->byte3($rgb));
				}
				fwrite($f, $wid_pad);
			}
			fclose($f);
			
		} else {
			foreach ($header AS $h) {
				echo $h;
			}
        	
			//save pixels
			for ($y=$hei-1; $y>=0; $y--) {
				for ($x=0; $x<$wid; $x++) {
					$rgb = imagecolorat($img, $x, $y);
					echo $this->byte3($rgb);
				}
				echo $wid_pad;
			}
			
		}
		
	}
	
	private function dwordize($str) {
		$a = ord($str[0]);
		$b = ord($str[1]);
		$c = ord($str[2]);
		return $c*256*256 + $b*256 + $a;
	}
	
	private function byte3($n) {
		return chr($n & 255) . chr(($n >> 8) & 255) . chr(($n >> 16) & 255);    
	}
	
	private function dword($n) {
		return pack("V", $n);
	}
	
	private function word($n) {
		return pack("v", $n);
	}
	
	
}