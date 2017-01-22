<?php

class dMysqli extends bSql {
	public function connect($config) {
		$this->dbo=new mysqli($config['host'],$config['username'],$config['password'],$config['db'],$config['port'],$config['socket']);
	}
	public function dataBase($name) {
		$this->dataBase=self::quote($name);
	}
	public function table($name) {
		$this->table=self::quote($name);
	}
	public static function quote($f) {	return '`'.$f.'`';}
	public function queryi($sql) {
		if ($this->dbo) {
			return $this->dbo->query($sql);
		} else {
			$this->dbo->connect();
			return $this->dbo->query($sql);
		}
	}

}