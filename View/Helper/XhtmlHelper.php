<?php

App::uses('Helper', 'View');

/**
 * Xhtml helper
 *
 *
 */
class XhtmlHelper extends Helper {

	var $helpers = array('Html', 'Session');

	function trim($str, $cnt, $strip = true){
		
		if ($strip) $str = strip_tags($str);
		$_array = str_word_count($str, 2);
		$_str = array();
		if(count($_array) > 0){
			foreach($_array as $k => $v){
				if($k < $cnt){
					$_str[] = $v;
				}
			}
		}
		return implode(' ', $_str);
		
	}
	
	function navmenu($pclass, $navitem){
		if($pclass == $navitem){
			return ' mega-current';
		}
		return false;
	}
	
	function mailto($email, $attributes = array()){
		$a = '';
		if(Validation::email($email)){
			$_email = preg_split('/(\@)/', $email);	
			$b = '';
			if (is_array($attributes) && count($attributes) > 0){
				foreach ($attributes as $key => $val){
					$b .= ' ' . $key . '="' . $val . '"';
				}
			}
			$a = '<script type="text/javascript">'.PHP_EOL;
			$a .= '<!-- '.PHP_EOL;
			$a .= " var m = ('".$_email[0]."&#64;' + '".$_email[1]."');".PHP_EOL;
			$a .= "document.write('<a href=\"mailto:' + m + '\"".$b.">' + m + '</a>');".PHP_EOL;
			$a .= '//-->'.PHP_EOL;
			$a .= '</script>'.PHP_EOL;
			$a .= '<ins><noscript>'.PHP_EOL;
			$a .= '<p><em>Email address protected by JavaScript.</em></p>'.PHP_EOL;
			$a .= '</noscript></ins>'.PHP_EOL;
		}
		return $a;
		
	}
	
	function legend($value=''){
		
		$legend = '<legend>';
		
		if(isset($value)){
			$legend .= $value;
		}
		
		$legend .= '</legend>';
		return $legend;
		
	}
	
	function fieldset($pos,$attributes=array()){
	
		$_lg = '';
		switch($pos){
			default:
			case 'start':
			$fset = '<fieldset ';
			if (is_array($attributes) && count($attributes) > 0){
				if(isset($attributes['legend']) && !empty($attributes['legend'])){
					$_lg = $this->legend($attributes['legend']);
					unset($attributes['legend']);
				}
				foreach ($attributes as $key => $val){
					$fset .= ' '.$key.'="'.$val.'"';
				}
			}
			$fset .= '>' . $_lg;
			break;
			case 'end':
			$fset = '</fieldset>';
			break;
		}			
			
		return $fset;
		
	}
	
	function getCrumbs($separator = '&raquo;', $startText = false) {
		
		if (!empty($this->Html->_crumbs)) {
			$rtn = '<ul>';
			$out = array();
			if ($startText) {
				$out[] = '<li>' . $this->Html->link($startText, '/') . '</li>';
			}

			foreach ($this->Html->_crumbs as $crumb) {
				if (!empty($crumb[1])) {
					$out[] = '<li>' . $this->Html->link($crumb[0], $crumb[1], $crumb[2]) . '</li>';
				} else {
					$out[] = '<li class="current">' . $crumb[0] . '</li>';
				}
			}
			$rtn .= join('<li>'.$separator.'</li>', $out) . '</ul>';
			return $rtn;
		} else {
			return null;
		}
		
	}
	
	function footer($string = null, $options = array()) {
		$str = '';
		if (preg_match('/\{SITE_NAME\}/', $string)) {
			$str = preg_replace('/\{SITE_NAME\}/', Configure::read('MySite.site_name'), $string);
		} else {
			if (isset($options['position']) && ($options['position'] == 'right' || $options['position'] == 'after')) {
				$str = Configure::read('MySite.site_name') . ' ' . $string;
			} else {
				$str = $string . ' ' . Configure::read('MySite.site_name');
			}
		}
		return $str;
	}
	
	function iconImage($type){
		
		switch ($type) {
			default: $ext = 'default'; break;
			case 'application/pdf': $ext = 'pdf'; break;
			case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
			case 'application/vnd.ms-excel': $ext = 'excel'; break;
			case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
			case 'application/msword': $ext = 'word'; break;
			case 'image/jpeg': 
			case 'image/jpg': $ext = 'jpg'; break;
			case 'image/png': $ext = 'png'; break;
			case 'image/gif': $ext = 'gif'; break;
		}
		return $ext;
	}
	
	function content( $text = false, $split = true, $link = '' ){
		if($text){
			if($split && preg_match('/\<hr id\=\"system-readmore\" \/\>/', $text)){
				$str = preg_split('/\<hr id\=\"system-readmore\" \/\>/', stripslashes($text));
				$lk = (!empty($link))? $this->Html->para(false, $link): '';
				return $str[0] . $lk; 
			}else{
				$lk = (!empty($link))? $this->Html->para(false, $link): '';
				return preg_replace('/\<hr id\=\"system-readmore\" \/\>/', '', stripslashes($text)) . $lk;
			}
		}
		return false;
	}
	
	
	function pagetitle($title_for_layout){
		$regexp = Configure::read('MySite.site_name_layout');
		if(empty($regexp)){
			$regexp = '{site name} :: {model} :: {site name}';
		}
		return preg_replace(
			array('/\{site name\}/i', '/\{model\}/i', '/\{page title\}/i'), 
			array(Configure::read('MySite.site_name'), Inflector::classify($this->request->params['controller']), $title_for_layout), 
			$regexp);
		
	}
	
	function randomColor(){
	    $randomcolor = '#' . strtoupper(dechex(rand(0,10000000)));
	    if (strlen($randomcolor) != 7){
	        $randomcolor = str_pad($randomcolor, 10, '0', STR_PAD_RIGHT);
	        $randomcolor = substr($randomcolor,0,7);
	    }
		return $randomcolor;
	}
	
	function visit(){
		App::uses('Visit', 'Model');
		$this->Visit = new Visit;
		$this->Visit->add($this->Session->read('Config.userAgent'), $this->Session->read('Customer'));
	}
	
	function ver() {
		App::uses('System', 'Model');
		$this->System = new System;
		return $this->System->getVer();
	}
	
	
	function googleAnalytics() {
		$ga = Configure::read('MySite.ga');
		if (!empty($ga)) {
			return "<script type=\"text/javascript\">
			var _gaq = _gaq || []; 
			_gaq.push(['_setAccount', '$ga']); 
			_gaq.push(['_trackPageview']); 
			(function() { var ga = document.createElement('script'); ga.type = 'text/javascript'; 
			ga.async = true; ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; 
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
			</script>";
		}
	}
	
	function dateBetween($start_date = false, $end_date = false) {
		if ($start_date && $end_date) {
			App::uses('CakeTime', 'Utility');
			$now = CakeTime::fromString(date('m/d/Y h:i:s a', time()));
			$d1 = CakeTime::fromString($start_date);
			$d2 = CakeTime::fromString($end_date);
			if ($d1 < $now && $now < $d2) {
				return true;
			}
		}
		return false;
	}

	function link($url = false) {
		if ($url) {
			$_url = array();
			if (!empty($url['controller'])) {
				$_url['controller'] = $url['controller'];
				if (!empty($url['action'])) {
					$_url['action'] = $url['action'];
				} else {
					$_url['action'] = 'index';
				}
				if (!empty($url['slug'])) {
					$_url[] = $url['slug'];
					if(!empty($url['title'])) {
						$_url['slug'] = str_replace(' ', '-', $url['title']);
					}
				}
				if (!empty($url['named'])) {
					$__named = preg_split('/\:/', $url['named']);	
					$_url[$__named[0]] = $__named[1];
				}
				if (!empty($url['plugin'])) {
					$_url['plugin'] = $url['plugin'];
				} else {
					$_url['plugin'] = false;
				}
				if (!empty($url['admin'])) {
					$_url['admin'] = $url['admin'];
				} else {
					$_url['admin'] = false;
				}
			}
			
			if (!empty($url['url'])) {
				$_url = $url['url'];
			}
			return $this->Html->url($_url);
		}
		return false;
	}
	
	function image($path, $options) {
		$tag = '<img src="%s" %s/>';
		$path = $this->Html->assetUrl($path, $options + array('pathPrefix' => IMAGES_URL));
		$options = array_diff_key($options, array('fullBase' => '', 'pathPrefix' => ''));
		foreach ($options as $k => $v) {
			$_options[] = $k.' ="'.$v.'"';
		}
		return sprintf($tag, $path, implode(' ', $_options));
	}
	
	function badgeme($string = null, $compare = null, $class = 'important') {
		if (!empty($string) && !empty($compare)){
			if (strtolower($string) == strtolower($compare)) {
				return sprintf('<span class="badge badge-success">%s</span>', $string);
			} else {
				return sprintf('<span class="badge badge-%s">%s</span>', $class, $string);
			}
		}
	}
	
	function iconme($string = false) {
		$msg = 'icon-bell';
		if (strstr(strtolower($string), 'new')) {
			$msg = 'icon-plus';
		}
		if (strstr(strtolower($string), 'add')) {
			$msg = 'icon-plus';
		}
		if (strstr(strtolower($string), 'login')) {
			$msg = 'icon-bullhorn';
		}
		if (strstr(strtolower($string), 'logged in')) {
			$msg = 'icon-bullhorn';
		}
		if (strstr(strtolower($string), 'delete')) {
			$msg = 'icon-bolt';
		}
		if (strstr(strtolower($string), 'failed')) {
			$msg = 'icon-bolt';
		}
		if (strstr(strtolower($string), 'exception')) {
			$msg = 'icon-warning-sign';
		}
		if (strstr(strtolower($string), 'fatal')) {
			$msg = 'icon-ambulance';
		}
		if (strstr(strtolower($string), 'system')) {
			$msg = 'icon-cogs';
		}
		if (strstr(strtolower($string), 'database')) {
			$msg = 'icon-table';
		}
		return $msg;
	}
	
	function maxfilesize() {
		$max_upload = (int)(ini_get('upload_max_filesize'));
		$max_post = (int)(ini_get('post_max_size'));
		$memory_limit = (int)(ini_get('memory_limit'));
		return min($max_upload, $max_post, $memory_limit) * 1024 * 1024;
	}
	
	function batteryalert($voltage) {
		if ($voltage > '11.8') {
			return sprintf('<span class="badge badge-success">%s</span>', $voltage);
		} else if ($voltage <= '11.8' && $voltage > '1.4') {
			return sprintf('<span class="badge badge-warning">%s</span>', $voltage);
		} else {
			return sprintf('<span class="badge badge-important">%s</span>', $voltage);
		}
	}

}