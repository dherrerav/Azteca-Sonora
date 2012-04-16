<?php
/**
 * @copyright	Copyright (C) 2009-2012 ACYBA SARL - All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?>
<?php
class cpanelClass extends acymailingClass{
	function load(){
		$query = 'SELECT * FROM '.acymailing_table('config');
		$this->database->setQuery($query);
		$this->values = $this->database->loadObjectList('namekey');
	}
	function get($namekey,$default = ''){
		if(isset($this->values[$namekey])) return $this->values[$namekey]->value;
		return $default;
	}
	function save($configObject){
		$query = 'REPLACE INTO '.acymailing_table('config').' (namekey,value) VALUES ';
		$params = array();
		$i = 0;
		foreach($configObject as $namekey => $value){
			$i++;
			if($i>100){
				$query .= implode(',',$params);
				$this->database->setQuery($query);
				if(!$this->database->query()) return false;
				$i = 0;
				$query = 'REPLACE INTO '.acymailing_table('config').' (namekey,value) VALUES ';
				$params = array();
			}
			$this->values[$namekey]->value = $value;
			$params[] = '('.$this->database->Quote(strip_tags($namekey)).','.$this->database->Quote(strip_tags($value,'<br/>')).')';
		}
		if(empty($params)) return true;
		$query .= implode(',',$params);
		$this->database->setQuery($query);
		return $this->database->query();
	}
}