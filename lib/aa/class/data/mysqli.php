<?php

class mysqli extends bSql {
	public function connect($config) {	}
	public function table($name) {}
	public function dataBase($name) {
	}
	public function quote($field) {	return '`'.$field.'`';}
	public function query($sql) {
		return $sql;
	}

}