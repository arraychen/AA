<?php

class dMysqli extends bSql {
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
	public static function quote($f) {	return '`'.$f.'`';}
	public function query($sql) {
		if ($this->dbi) {
			return $this->dbo->query($sql);
		} else {
			$this->dbi->connect();
			return $this->dbi->query($sql);
		}
	}
}