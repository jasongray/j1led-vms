<?php

App::uses('Helper', 'View');

/**
 * Menu helper
 *
 * Creates list styled menu for Webwidget CMS.
 *
 * @package       app.View.Helper
 */
class menuHelper extends Helper{

	var $helpers = array('Html', 'Session');
	
/**
 * create method
 * 
 * Generates an unordered list of links in ul li format
 *
 * @param integer $menu_id The id of the menu to generate
 * @param array $htmlAttributes An array of html attributes
 * @return string Formatted string of ul li links to create a menu
 */		
	public function create($menu_id = false, $htmlAttributes = array()) {
	
		if($menu_id){
			
			if($_menu = $this->load($menu_id)) {
				
				$this->tags['ul'] = '<ul%s>%s</ul>';
				$this->tags['ol'] = '<ol%s>%s</ol>';
				$this->tags['li'] = '<li%s>%s</li>';
				$this->tags['span'] = '<span%s>%s</span>';
				
				$out = array();
				
				foreach($_menu as $m) {
					$out[] = $this->li($m);
				}
				
				$tmp = implode("\n", $out);
				return $this->ul($tmp, $htmlAttributes);
				
			}
			
		}
		
		return null;
	
	}
	
/**
 * ul method
 * 
 * Outputs the list into a <ul></ul> format
 *
 * @param array $_link The array of data to list
 * @param array $attr An array of html attributes
 * @return string Formatted string of ul elements
 */		
	private function ul($_link, $attr = array()) {
		return $this->output(sprintf($this->tags['ul'], $this->_parseAttributes($attr), $_link));
	}

/**
 * li method
 * 
 * Outputs the list into a <li></li> format
 *
 * @param array $_menuitem The array of data to generate into li elements
 * @param array $attr An array of html attributes
 * @return string Formatted string of li elements or false
 */		
	private function li($_menuitem = array(), $attr = array()) {
		
		if (count($_menuitem['children']) > 0) {
			
			$_link = $this->link($_menuitem, '<span class="arrow"></span>');
			$continue = true;
			foreach($_menuitem['children'] as $c){
				if (($this->Session->read('Auth.User.group_id') > $c['MenuItem']['permissions'])) {
					$continue = false;
				}
			}
			if ($_link && $continue) {
				$attr = array_merge(array('class' => 'has-sub'), $attr);
				$active = false;
				$out = array();
				foreach($_menuitem['children'] as $m) {
					$out[] = $this->li($m);
				}
				$tmp = implode("\n", $out);
				$_link = $_link . $this->ul($tmp, array('class' => 'sub'));
			}
			
		} else {
			
			$_link = $this->link($_menuitem);
			
		}
		
		if ($_link) {
			
			$url = $this->generateURL($_menuitem);
			$test_url = (is_array($url))? $this->Html->url($url): $url;
			if (str_replace($this->base, '', $this->here) == str_replace($this->base, '', $test_url)){
				if (in_array('class', $attr)) {
					$_exp = implode(' ', $attr['class']);
					$_exp[] = 'active';
					$attr['class'] = explode(' ', $_exp);
				} else {
					$attr = array_merge(array('class' => 'active'), $attr);
				}
			}
			
			if (strpos($_link, 'active')) {
				if (array_key_exists('class', $attr)) {
					$_exp = explode(' ', $attr['class']);
					$_exp[] = 'active';
					$attr['class'] = implode(' ', $_exp);
					$_link = str_replace('class="arrow">', 'class="arrow open">', $_link);
				}
			}
			
			return $this->output(sprintf($this->tags['li'], $this->_parseAttributes($attr), $_link));
		
		} else {
			
			return false;
			
		}
		
	}
	
/**
 * link method
 * 
 * Outputs the html link to use for the menu
 *
 * @param array $l The array of data used to generate the link htmlHelper::link
 * @return string Formatted HTML link element or false
 */		
	private function link($l = array(), $x = '') {
		if (empty($l['MenuItem']['permissions'])) {
			$l['MenuItem']['permissions'] = 0;
		}
		if (!empty($l['children'])) {
			foreach($l['children'] as $c){
				if (($this->Session->read('Auth.User.group_id') > $c['MenuItem']['permissions'])) {
					$x = '';
				}
			}
		}
		
		if (($this->Session->read('Auth.User.group_id') <= $l['MenuItem']['permissions']) || empty($l['MenuItem']['permissions'])) {
		
			$url = $this->generateURL($l);
			$attr = array();
			$test_url = (is_array($url))? $this->Html->url($url): $url;
			if (str_replace($this->base, '', $this->here) == str_replace($this->base, '', $test_url)) {
				$attr = array('class' => 'selected');
				$k = $x . '<span class="selected"></span>';
			} else {
				$k = $x . '';
			}
			
			if (isset($l['MenuItem']['class']) && !empty($l['MenuItem']['class'])) {
				$i = '<i class="' . $l['MenuItem']['class'] . '"></i>';
			} else {
				$i = '';
			}
			$attr = array_merge(array('escape' => false), $attr);
			
			return $this->Html->link($i . $l['MenuItem']['title'] . $k, $url, $attr);
			
		} else {
			
			return false;
			
		}
		
	}
	
/**
 * load method
 * 
 * Returns the array of data for the menu
 *
 * @param integar $menu_id The id of the menu items required
 * @return array $list array of data
 */			
	private function load($menu_id = null) {
		
		App::uses('MenuItem', 'Model');
		$this->_MenuItem = new MenuItem();
		$list = $this->_MenuItem->find('threaded', array('conditions' => array('MenuItem.menu_id' => $menu_id, 'MenuItem.published' => 1), 'order' => 'MenuItem.lft ASC'));
		return $list;
		
	}
	
/**
 * generateURL method
 * 
 * Returns the url
 *
 * @param array $l The array of menu items
 * @return array $url The array of url items
 */		
	private function generateURL($l = array()) {
		
		$url = '';
		if (!empty($l)) {
			if (!empty($l['MenuItem']['controller'])) {
				$url['controller'] = $l['MenuItem']['controller'];
				if (!empty($l['MenuItem']['action'])) {
					$url['action'] = $l['MenuItem']['action'];
				} else {
					$url['action'] = 'index';
				}
				if (!empty($l['MenuItem']['slug'])) {
					$url['id'] = $l['MenuItem']['slug'];
					if(!empty($l['MenuItem']['title'])) {
						$url['slug'] = str_replace(' ', '-', $l['MenuItem']['title']);
					}
				}
				if (!empty($l['MenuItem']['named'])) {
					$__named = preg_split('/\:/', $l['MenuItem']['named']);	
					$url[$__named[0]] = $__named[1];
				}
				if (!empty($l['MenuItem']['plugin'])) {
					$url['plugin'] = $l['MenuItem']['plugin'];
				} else {
					$url['plugin'] = false;
				}
				if (!empty($l['MenuItem']['admin'])) {
					$url['admin'] = $l['MenuItem']['admin'];
				} else {
					$url['admin'] = false;
				}
			}
			
			if (!empty($l['MenuItem']['url'])) {
				$url = $l['MenuItem']['url'];
			}
						
			if ($l['MenuItem']['default'] == 1) {
				$url = '/';
			}
		}
		return $url;
			
	}

}