<?php

class dMysqli extends bSql {
	public static function quote($f) {	return '`'.$f.'`';}
	public function connect($config) {
		$this->dbi=new mysqli($config['host'],$config['user'],$config['password'],$config['database'],$config['port'],$config['socket']);
	}
	public function close() {
		$this->dbi->close();
	}
	public function dataBase($name) {
		$this->dataBase=self::quote($name);
	}
	public function table($name) {
		$this->table=self::quote($name);
	}
	public function query($sql) {
		return $this->dbo->query($sql);
	}
}