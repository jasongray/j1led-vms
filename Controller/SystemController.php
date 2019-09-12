<?php
App::uses('AppController', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
/**
 * System Controller
 *
 */
class SystemController extends AppController {

/**
 * updateserver field
 *
 * The url path to the update server with no leading slashes
 *
 * @var string
 */
	var $updateserver = 'http://webwidget.com.au/cms-updates';
	
	public function beforeFilter() {
	    parent::beforeFilter();
	}

/**
 * index method
 * 
 * Displays everything needed
 */	 
	public function index() {
		
		$this->set('ver', $this->version());
		$file = new File(ROOT . DS . APP_DIR . DS . 'CHANGELOG');
		$contents = $file->read();
		$file->close(); 
		$this->set('changelog', $contents);
		
		$this->set('tables', $this->checkTables());
		
	}

/**
 * version method
 * 
 * Returns the current version of this CMS.
 *
 * @return string $ver the current version number of CMS
 */	 
	public function version() {
		return $this->System->getVer();
	}
	
/**
 * checkUpdates method
 * 
 * Checks current version of CMS with update server and shows if updates available.
 *
 * @return array $array Array of updates available
 */	 
	public function checkUpdates() {
		$this->autoRender = false; // use this function in ajax requests.
		$__cver = $this->System->getVer();
		$__data = file_get_contents($this->updateserver . '/' . $this->System->getFolder() . 'update-log.txt');
		$__vlist = explode("\n", $__data);
		$versions = array();
		foreach ($__vlist as $v) {
			if ($v > $__cver) {
				$versions[] = $v;
			}
		}
		$__array = array('count' => count($versions), 'versions' => $versions);
		echo json_encode($__array);
	}	

/**
 * checkTables method
 * 
 * Returns the current version of this CMS.
 *
 * @return array $out An array of table data
 */	 
	public function checkTables() {
		
		// Check table status first
		$result = $this->System->query("SHOW TABLE STATUS");
		$out = array();
		foreach ($result as $r) {
			if ($r['TABLES']['Engine'] != 'InnoDB') {
				$t = $r['TABLES']['Name'];
				$_r = $this->System->query("CHECK TABLE $t");
				$out[] = array_merge($r['TABLES'], $_r[0][0]);
			}
		}
		return $out;
	}
	
/**
 * optimiseTable method
 * 
 * Optimizes the specified table
 *
 * @return boolean
 */	 
	public function optimiseTable() {
		$this->log(__('Optimising database table') . ' ' . $this->request->params['named']['table'], 'success', 'activity');
		$this->autoRender = false; // use this function in ajax requests.
		$table = $this->request->params['named']['table'];
		if ($table) {
			$_r = $this->System->query("OPTIMIZE TABLE $table");
			if ($_r[0][0]['Msg_text'] == 'OK') {
				$msg = array('response' => 1, 'msg' => array(__("$table optimised")));
			} else {
				$msg = array('response' => 0, 'msg' => array(__("$table was not optimised")));
			}
		} else {
			$msg = array('response' => 0, 'msg' => array(__("$table not found")));
		}
		echo json_encode($msg);
	}
	
/**
 * optimiseAll method
 * 
 * Optimizes all tables in the database
 *
 * @return string
 */	 
	public function optimiseAll() {
		$this->log(__('Optimising all database tables.'), 'success', 'activity');
		$this->autoRender = false; // use this function in ajax requests.
		// Check table status first
		$result = $this->System->query("SHOW TABLE STATUS");
		$out = array();
		foreach ($result as $r) {
			if ($r['TABLES']['Engine'] != 'InnoDB') {
				$t = $r['TABLES']['Name'];
				$_r = $this->System->query("OPTIMIZE TABLE $t");
				$out[] = array_merge($r['TABLES'], $_r[0][0]);
			}
		}
		echo json_encode($out);
	}

/**
 * emptyTable method
 * 
 * Truncates table in database
 *
 * @return string
 */	 
	public function emptyTable() {
		$this->log(__('Truncating database table') . ' ' . $this->request->params['named']['table'], 'success', 'activity');
		$this->autoRender = false; // use this function in ajax requests.
		$table = $this->request->params['named']['table'];
		if ($table) {
			$_r = $this->System->query("TRUNCATE $table");
			if ($_r == 1) {
				$msg = array('response' => 1, 'msg' => array(__("$table has been emptied")));
			} else {
				$msg = array('response' => 0, 'msg' => array(__("$table was not emptied")));
			}
		} else {
			$msg = array('response' => 0, 'msg' => array(__("$table not found")));
		}
		echo json_encode($msg);
	}



/**
 * downloadUpdate method
 *
 * Downloads the current selected update using CURL to show progress to the temp dir
 * The view file renders the progress and installs the files
 *
 * @param string $ver
 * @return string
 */
 	public function downloadUpdate($ver = false) {
 		$this->log(__('System update started. Version') . ' ' . $ver, 'success', 'activity');
 		$this->layout = 'ajax';
 		if ($ver) {
			$this->set('url', $this->updateserver . '/' . $this->System->getFolder() . 'update-' . $ver . '.zip');
 		}
 		$this->render('download');
 	}
 
/**
 * backupDB method
 *
 * Generates a backup of the database for download.
 *
 */ 	
 	public function backupDB($tables = '*') {
 		
 		$return = '';
 		$dataSource = $this->System->getDataSource();
 		$databaseName = $dataSource->getSchemaName();
 		
 		// Do a short header
 		$return .= '-- Database: `' . $databaseName . '`' . "\n";
 		$return .= '-- Generation time: ' . date('D jS M Y H:i:s') . "\n\n\n";
 		
 		if ($tables == '*') {
 			$tables = array();
 			$result = $this->System->query('SHOW TABLES');
 			foreach($result as $resultKey => $resultValue){
 				$tables[] = current($resultValue['TABLE_NAMES']);
 			}
 		} else {
 			$tables = is_array($tables) ? $tables : explode(',', $tables);
 		}
 		
 		// Run through all the tables
 		foreach ($tables as $table) {
 			$tableData = $this->System->query('SELECT * FROM ' . $table);
 			
 			$return .= 'DROP TABLE IF EXISTS ' . $table . ';';
 			$createTableResult = $this->System->query('SHOW CREATE TABLE ' . $table);
 			$createTableEntry = current(current($createTableResult));
 			$return .= "\n\n" . $createTableEntry['Create Table'] . ";\n\n";
 			
 			// Output the table data
 			foreach($tableData as $tableDataIndex => $tableDataDetails) {
 				
 				$return .= 'INSERT INTO ' . $table . ' VALUES(';
 				
 				foreach($tableDataDetails[$table] as $dataKey => $dataValue) {
 					
 					if(is_null($dataValue)){
 						$escapedDataValue = 'NULL';
 					} else {
 						// Convert the encoding
 						$escapedDataValue = mb_convert_encoding( $dataValue, "UTF-8", "ISO-8859-1" );
 						
 						// Escape any apostrophes using the datasource of the model.
 						$escapedDataValue = $this->System->getDataSource()->value($escapedDataValue);
 					}
 					
 					$tableDataDetails[$table][$dataKey] = $escapedDataValue;
 					
 				}
 				
 				$return .= implode(',', $tableDataDetails[$table]);
 				$return .= ");\n";
 			}
 			$return .= "\n\n\n";
 		}
 		
 		// Set the default file name
 		$fileName = $databaseName . '-backup-' . date('Y-m-d_H-i-s') . '.sql';
 		
 		// Serve the file as a download
 		$this->autoRender = false;
 		$this->response->type('Content-Type: text/x-sql');
 		$this->response->download($fileName);
 		$this->response->body($return);
 		
 	}
 	
 	
/**
 * unzip method
 * 
 * Unzips an archive file and stores the files onto the server.
 *
 * @return string $e String of errors if any
 */		
	private function unzip($file) {
		
		$zip = zip_open(realpath(".")."/".$file);
		
		if(!$zip) { 
			$this->log(__('Unable to proccess file') . ' ' . $file, 'important', 'activity');
			return false; 
		}
		$e = '';
		
		while ($zip_entry = zip_read($zip)) {
			$zdir = dirname(zip_entry_name($zip_entry));
			$zname = zip_entry_name($zip_entry);
			
			if (!zip_entry_open($zip, $zip_entry, "r")) {
				$e .= "Unable to proccess file '{$zname}'";
				continue;
			}
			
			if (!is_dir($zdir)) $this->mkdirr($zdir, 0777);
			$zip_fs = zip_entry_filesize($zip_entry);
			if (empty($zip_fs)) continue;
			$zz = zip_entry_read($zip_entry, $zip_fs);
			$z = fopen($zname, "w");
			fwrite($z, $zz);
			fclose($z);
			zip_entry_close($zip_entry);
			
		}
		
		zip_close($zip);
		return $e;
		
	}
	
/**
 * mkdirr method
 * 
 * Used to create directories when unzipping the archive.
 *
 * @return boolean
 */	
	private function mkdirr($pn, $mode = null) {
		
		if (is_dir($pn)||empty($pn)) return true;
		
		$pn = str_replace(array('/', ''), DIRECTORY_SEPARATOR, $pn);
		
		if (is_file($pn)) {
			return false;
		}
		
		$next_pathname = substr($pn, 0, strrpos($pn, DIRECTORY_SEPARATOR));
		
		if ($this->mkdirr($next_pathname, $mode)) {
			if (!file_exists($pn)) {
				return mkdir($pn, $mode);
			}
		}
		
		return false;
		
	}

	
}
