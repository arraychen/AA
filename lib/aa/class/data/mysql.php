<?php

class dMysql extends bSql {
	public static function quote($f) {	return '`'.$f.'`';}
	public function connect($config) {
		$this->dbi=mysql_connect($config);
		if (isset($config['code']))
			mysql_query('SET NAMES "'.$config['charset'].'"',$this->dbi);
	}
	public function dataBase($name) {
		$this->dataBase=self::quote($name);
		return mysql_select_db($this->dataBase,$this->dbi);
	}
	public function table($name) {
		$this->table=self::quote($name);
	}
	public function close() {
		return mysql_close($this->dbi);
	}
	public function query($sql) {
		return mysql_query($sql,$this->dbi);
	}
	public function build($action,$field,$table,$where) {
		$sql=$action.' '.$field.' FROM '.$table.' WHERE '.$where;
		return $sql;
	}

}